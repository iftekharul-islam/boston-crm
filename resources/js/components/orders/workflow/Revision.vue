<template>
  <transition name="fade-x" appear v-if="revissionModal" :duration="500">
    <div class="revission-modal">
      <div ref="revissionContent" class="revission-content position-relative anim">
        <div class="header bg-gray d-flex align-items-center justify-content-between">
          <p class="mb-0 fs-20 fw-bold text-white">Revision</p>
          <span class="cursor-pointer" @click="revission()">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1 17L17 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M17 17L1 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
        </div>
        <div class="revission-body" ref="revissionBody">
          <!-- add button -->
          <div class="revission-add text-end mb-3">
            <button v-if="!addRevission" @click="revissionAdd(true)" class="button button-primary py-2 h-40 flex-center d-inline-flex">Add revision</button>
          </div>

          <ValidationObserver ref="addRevission">
            <!-- add revission form -->
            <transition v-if="addRevission" name="fade" appear>
              <div class="add-revission bg-white mgb-12">
                <p class="fs-20 fw-bold">Add revision</p>
                <ValidationProvider name="Date & time" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label>Date & time</label>
                      <!-- <input type="datetime" v-model="form.date" class="dashboard-input w-100 gray-border"> -->
                      <v-date-picker mode="datetime" v-model="form.date">
                        <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                            <input class="dashboard-input w-100" :value="inputValue"
                                v-on="inputEvents" />
                        </template>
                      </v-date-picker>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>

                <ValidationProvider name="Revission details" rules="required" v-slot="{ errors }">
                  <div class="group" :class="{ 'invalid-form' : errors[0] }">
                    <label for="revissionData">Revision details</label>
                    <textarea v-model="form.revission" id="revissionData" rows="5" class="dashboard-textarea w-100 gray-border"></textarea>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                </ValidationProvider>
                <div class="text-end">
                  <button @click="revissionAdd(false)" class="button button-transparent px-5 h-40 flex-center">Close</button>
                  <button @click="revissionSubmit(true)" class="button button-primary px-5 h-40 flex-center d-inline-flex">Add</button>
                </div>
              </div>
            </transition>
          </ValidationObserver>

          <!-- revission card -->
          <div class="revission-card bg-white position-relative">

            <template v-if="revisionData.length > 0">
              <div :class="`revission-item solution-btn-position-${item.id}`" v-for="item, ir in revisionData" :key="ir">
                <div class="revission-card-top">
                  <div class="revission-card-header d-flex">
                    <div class="revission-name me-3">
                      <p class="mb-2 fs-20 fw-bold lh-20">{{ item.users.created_by.name }}</p>
                      <p class="mb-0">{{ item.revision_date | dateTime }}</p>
                    </div>
                    <div class="marked" :class="{'completed' : item.status == 1 }">
                      <a href="javascript:;" class="open open-btn fs-14">Open</a>
                      <a href="" @click.prevent="openMarkAsDelivery(item, ir)" class="mark-delivery fs-14">Mark as delivered</a>
                    </div>
                    <div class="button-box ms-auto">
                      <button @click="deleteRevission(item, ir)" class="action-btn mgr-12"> <span class="icon-trash"><span class="path1"></span><span
                            class="path2"></span><span class="path3"></span><span class="path4"></span></span></button>
                      <button @click="editNotes(item, ir, $event)" class="action-btn"><span class="icon-edit"><span
                            class="path1"></span><span class="path2"></span></span></button>
                    </div>
                  </div>
                  <p class="mgb-12">Revision details</p>
                  <p>{{ item.revision_details }}</p>
                </div>
                <!-- solution -->
                <div class="solution" v-if="item.solution_details != '-' && item.open_solution == false">
                  <div class="solution-header d-flex align-items-start mb-2">
                    <div>
                      <p class="mgb-12">Solution</p>
                      <p class="mb-0">{{ item.delivery_date | dateTime }}</p>
                    </div>
                    <div :class="`button-box ms-auto`">
                      <button @click.prevent="openMarkAsDelivery(item, ir, true)" class="action-btn"><span class="icon-edit"><span class="path1"></span><span
                            class="path2"></span></span>
                        </button>
                    </div>
                  </div>
                  <p class="fw-bold mgb-20"> {{ item.solution_details }} </p>
                  <div class="d-flex" v-if="item.users.delivered_by && item.users.completed_by">
                    <div class="col-6">
                      <p class="mgb-10">Delivered by</p>
                      <p class="fw-bold">{{ item.users.delivered_by.name }}</p>
                    </div>
                    <div class="col-6">
                      <p class="mgb-10">Completed by</p>
                      <p class="fw-bold">{{ item.users.completed_by.name }}</p>
                    </div>
                  </div>
                </div>

                <!-- add solution button -->
                <div v-if="item.open_solution == false && item.solution_details == '-'" class="text-end mgt-28">
                  <button @click="item.open_solution = true; editRevision = false;" class="button button-transparent primary-text p-0"> <span
                      class="icon-plus primary-text"></span> <span class="ms-2 primary-text">Add solution</span></button>
                </div>
                <!-- add solution box -->
                <div v-if="item.open_solution == true" class="add-solution-box mgt-28">
                    <ValidationObserver :ref="`addSolutions-${item.id}`">
                      <ValidationProvider name="Solutions" rules="required" v-slot="{ errors }">
                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                            <label class="mgb-8">Add solution</label>
                            <textarea name="" v-model="item.solution_details_edited" rows="5" class="dashboard-textarea w-100 gray-border"></textarea>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                      </ValidationProvider>
                      <div class="d-flex justify-content-end mgt-12">
                        <button @click="item.open_solution = false" class="close-solution bg-white fs-14"> <svg width="10" height="10"
                            viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 9L9 1" stroke="#7E829B" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round" />
                            <path d="M9 9L1 1" stroke="#7E829B" stroke-width="1.5" stroke-linecap="round"
                              stroke-linejoin="round" />
                          </svg>
                          Close</button>
                        <button @click="addSolutionSubmit(item, ir)" class="add-solution bg-white fs-14"><svg width="12" height="9" viewBox="0 0 12 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M4.29515 8.6053C4.05503 8.6053 3.82691 8.50925 3.65883 8.34117L0.261131 4.94347C-0.0870435 4.5953 -0.0870435 4.01901 0.261131 3.67084C0.609305 3.32266 1.18559 3.32266 1.53377 3.67084L4.29515 6.43222L10.4662 0.261131C10.8144 -0.0870435 11.3907 -0.0870435 11.7389 0.261131C12.087 0.609305 12.087 1.18559 11.7389 1.53377L4.93147 8.34117C4.76338 8.50925 4.53527 8.6053 4.29515 8.6053Z"
                              fill="#19B7A2" />
                          </svg>
                          Add</button>
                      </div>
                    </ValidationObserver>
                </div>
              </div>
            </template>

            <template v-else>
              <div class="no-revission text-center">
                <p class="fs-20 mb-0 fw-bold">There are no revision added yet.</p>
              </div>
            </template>

            <!-- edit revission -->
            <transition name="fade" v-if="revissionEdit" :key="revissionKey" appear>
              <ValidationObserver ref="markDelivery">
                <div class="edit-revission">
                  <p class="mgb-22 fs-20 fw-bold">Mark as delivered</p>
                  <ValidationProvider rules="required" name="Completed By" v-slot="{errors}">
                    <div class="group" :class="{'invalid-form' : errors[0]}">
                      <label for="" class="d-block mb-2 dashboard-label">Completed by <span class="require"></span> </label>
                      <m-select :class="{'required' : errors[0] }" theme="blue" :options="usersInfo" object item-text="name" item-value="id" v-model="marked.completed_by"></m-select>
                      <span class="error-message">{{ errors[0] }}</span>
                    </div>
                  </ValidationProvider>

                  <ValidationProvider rules="required" name="Delivered By" v-slot="{errors}">
                  <div class="group" :class="{'invalid-form' : errors[0]}">
                    <label for="" class="d-block mb-2 dashboard-label">Delivered by <span class="require"></span> </label>
                    <m-select :class="{'required' : errors[0] }" theme="blue" :options="usersInfo" object item-text="name" item-value="id" v-model="marked.delivered_by"></m-select>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                  </ValidationProvider>

                  <ValidationProvider rules="required" name="Delivered Date" v-slot="{errors}">
                  <div class="group" :class="{'invalid-form' : errors[0]}">
                    <label for="" class="d-block mb-2 dashboard-label">Delivered Date <span class="require"></span> </label>
                    <div class="position-relative">
                      <input type="date" v-model="marked.delivery_date" class="dashboard-input w-100 gray-border">
                      <span class="icon-calendar icon"><span class="path1"></span><span class="path2"></span><span
                          class="path3"></span><span class="path4"></span><span class="path5"></span><span
                          class="path6"></span><span class="path7"></span><span class="path8"></span></span>
                    </div>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                  </ValidationProvider>

                  <ValidationProvider rules="required" name="Add solution" v-slot="{errors}">
                  <div class="group" :class="{'invalid-form' : errors[0]}">
                    <label for="" class="mb-2 text-light-black d-inline-block">Add solution <span
                        class="require"></span></label>
                    <div class="preparation-input w-100 position-relative">
                      <textarea name="" v-model="marked.solution_details" id="" cols="30" rows="3" class="w-100 dashboard-textarea"></textarea>
                    </div>
                    <span class="error-message">{{ errors[0] }}</span>
                  </div>
                  </ValidationProvider>

                  <div class="text-end">
                    <button @click="revissionEdit = false" class="button button-transparent px-5 h-40 flex-center">Close</button>
                    <button @click="saveAsMarked" class="button button-primary px-5 h-40 flex-center d-inline-flex">Mark</button>
                  </div>
                </div>
              </ValidationObserver>
            </transition>

            <!-- Edit notes -->
            <transition name="fade" v-if="editNotesModal" appear>
              <div class="edit-revission" ref="editNotesModals">
                  <ValidationObserver ref="editRevision">
                      <p class="fs-20 fw-bold">Edit revision</p>
                      <ValidationProvider name="Date & time" rules="required" v-slot="{ errors }">
                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                          <label>Date & time</label>
                          <v-date-picker mode="datetime" v-model="form.date">
                            <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                                <input class="dashboard-input w-100" :value="inputValue"
                                    v-on="inputEvents" />
                            </template>
                          </v-date-picker>
                          <span class="error-message">{{ errors[0] }}</span>
                        </div>
                      </ValidationProvider>

                      <ValidationProvider name="Revission details" rules="required" v-slot="{ errors }">
                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                          <label for="revissionData">Revision details</label>
                          <textarea v-model="form.revission" id="revissionData" rows="5" class="dashboard-textarea w-100 gray-border"></textarea>
                          <span class="error-message">{{ errors[0] }}</span>
                        </div>
                      </ValidationProvider>
                      <div class="text-end">
                        <button @click="editNotesModal = false" class="button button-transparent px-5 h-40 flex-center">Close</button>
                        <button @click="revissionEditSubmit" class="button button-primary px-5 h-40 flex-center d-inline-flex">Update Revision</button>
                      </div>
                  </ValidationObserver>
              </div>
            </transition>

          </div>
        </div>

      </div>
      <confirm-dialog ref="popup">
          <h4 style="margin-top: 0">{{ dialogue.title }}</h4>
          <p>{{ dialogue.message }}</p>
          <div class="btns mt-3">
              <button class="cancel-btn" @click="_cancel">Cancel</button>
              <span class="ok-btn" @click="_confirm">Confirm</span>
          </div>
      </confirm-dialog>
    </div>
  </transition>
</template>
<script>
export default {
  name: 'Revision',
  props: ['order'],
  model: {
    prop: 'modelData',
    event: 'change'
  },
  inject: ['usersInfo'],
  data: () => ({
    dialogue: {
      title: "Delete Revission!",
      message: "Are you want to delete this revission?",
    },
    modalOpenNext: false,
    editNotesModal: false,
    revissionModal: true,
    addRevission: false,
    addSolution: false,
    revissionEdit: false,
    openModalKey: 'open-model',
    orderData: [],
    solutions: [],
    revissionKey: 'rev-key',
    revisionData: [],
    deleteRevision: [],
    form: {
      id: null,
      date: null,
      revission: null
    },
    currentTopPosition: 0,
    marked: {
      id: null,
      completed_by: null,
      delivered_by: null,
      delivery_date: null,
      solution_details: null,
    }
  }),
  created(){
      this.revissionModal = this.$attrs.modelData;

      // this.$root.$on('open_revision', status => {
      //     this.revissionModal = status;
      // });

      let order = this.order;
      let localOrderData = this.$store.getters['app/orderDetails']
      if(localOrderData){
          order = localOrderData;
      }
      this.initData(order);

      this.$root.$on("wk_update", (res) => {
          this.initData(res);
      });
  },
  methods: {
    initData(order) {
        this.orderData = order;
        this.revisionData = this.orderData.revission;
        this.revissionKey = Math.floor(Math.random(10000) * 1000);
    },
    revission() {
        this.revissionModal = !this.revissionModal
        document.documentElement.style.overflow = 'auto';
        this.$emit('change', this.revissionModal);
    },
    revissionAdd(status) {
        this.form.id = null;
        this.form.date = null;
        this.form.revission = null;
        this.addRevission = status;
        this.revissionEdit = false;
        this.editNotesModal = false;
    },
    revissionSubmit() {
        this.$refs.addRevission.validate().then((status) => {
            if (status) {
                let formData = new FormData();
                formData.append('order_id',this.orderData.id)
                formData.append('id',this.form.id)
                formData.append('date',this.form.date)
                formData.append('revission',this.form.revission)

              this.$boston.post('revissin/add', formData).then( (res) => {
                this.revisionData = res.data.revission;
                this.addRevission = false;
                this.$root.$emit('wk_flow_menu', res.data);
                this.$root.$emit('wk_update', res.data);
                this.$root.$emit('wk_flow_toast', res);
              }).catch(err => {
              });
            }
        });
    },

    addSolutionSubmit(item, index) {
        this.$boston.post('revissin/solutions/add', {
          'order_id' : this.orderData.id,
          'revission' : item
        }).then( (res) => {
            if (res.status == 'success') {
                this.revisionData = res.data.revission;
                this.revisionData[index].open_solution = false;
                this.$root.$emit('wk_flow_menu', res.data);
                this.$root.$emit('wk_update', res.data);
                this.$root.$emit('wk_flow_toast', res);
            }
        }).catch(err => {
        });
    },

    solutionAdd() {
      this.addRevission = false;
      this.addSolution = !this.addSolution;
      this.revissionEdit = false;
    },
    editRevission() {
      // this.revissionEdit = !this.revissionEdit
    },
    editNotes(item, index, event) {
        this.form.id = item.id;
        this.form.date = item.revision_date;
        this.form.revission = item.revision_details;
        this.addRevission = false;
        this.editNotesModal = true;
        this.$nextTick(() => {
            $(".edit-revission").attr("style", "top:"+this.currentTopPosition + 'px!important');
        });
    },
    openMarkAsDelivery(item, index, status = false) {
        if (status == false) {
            if (item.solution_details == 1) {
                return false;
            }
        }
        this.addRevission = false;
        this.revissionEdit = true;

        this.marked.id = item.id;
        this.marked.solution_details = item.solution_details.replace('-', '');
        this.marked.delivered_by = item.delivered_by;
        this.marked.completed_by = item.completed_by;
        this.marked.delivery_date = item.delivery_date_format;
        this.$nextTick(() => {
            $(".edit-revission").attr("style", "top:"+this.currentTopPosition + 'px!important');
        });
    },
    saveAsMarked() {
      this.$refs.markDelivery.validate().then((status) => {
          if (status) {
            this.$boston.post('revissin/solutions/marked', {
              'order_id' : this.orderData.id,
              ...this.marked
            }).then( (res) => {
                if (res.status == 'success') {
                    this.revisionData = res.data.revission;
                    this.revissionEdit = false;
                    this.$root.$emit('wk_flow_menu', res.data);
                    this.$root.$emit('wk_update', res.data);
                    this.$root.$emit('wk_flow_toast', res);
                }
            }).catch(err => {
            });
          }
      });
    },
    revissionEditSubmit() {
        this.$refs.editRevision.validate().then((status) => {
            if (status) {
                let formData = new FormData();
                formData.append('order_id',this.orderData.id)
                formData.append('id',this.form.id)
                formData.append('date',this.form.date)
                formData.append('revission',this.form.revission)

              this.$boston.post('revissin/edit', formData).then( (res) => {
                  this.revisionData = res.data.revission;
                  this.editNotesModal = false;
                  this.$root.$emit('wk_flow_menu', res.data);
                  this.$root.$emit('wk_update', res.data);
                  this.$root.$emit('wk_flow_toast', res);
              }).catch(err => {
              });
            }
        });
    },
    deleteRevission(item, index) {
        this.deleteRevision = item;
        this.$refs.popup.open();
    },

    _confirm() {
        this.$boston.post('revissin/solutions/delete', {
          'order_id' : this.orderData.id,
          'id' : this.deleteRevision.id
        }).then( (res) => {
            this.revisionData = res.data.revission;
            this.$root.$emit('wk_flow_menu', res.data);
            this.$root.$emit('wk_update', res.data);
            this.$root.$emit('wk_flow_toast', res);
        }).catch(err => {

        });
        this.$refs.popup.close();
    },

    _cancel() {
        this.$refs.popup.close();
    },
    scrollDiv() {
        const scrollDemo = $(".revission-content");
        let output = "";
        scrollDemo.on("scroll", function(e){
            output = scrollDemo.scrollTop();
            this.currentTopPosition = output;
        }.bind(this));
    },
    animControll(status) {
      this.$nextTick(() => {
        let ele = $(".revission-content");
        if (status == false) {
            $(ele).addClass('anim');
        } else {
            setTimeout(() => {
                $(ele).removeClass('anim');
            },200);
        }
      });
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.scrollDiv();
    });
    this.animControll(this.revissionModal);
  },
  watch: {
    $attrs: {
      handler(val) {
          this.revissionModal = val.modelData;
          this.animControll(this.revissionModal);
      }, 
      deep: true
    }
  }
}
</script>


<style scoped>
.revission-item{
  margin-bottom: 20px;
  padding: 16px;
  background: #fff;
  border-radius: 0.25rem;
  overflow: hidden;
}
.revission-card {
  padding: 0!important;
  background: #e5e5e5!important;
}
.revission-card .solution {
  border-top: thin solid #ddd;
}
.marked.completed .mark-delivery {
    background: #34A851;
    color: #fff;
}

.marked.completed .open {
    background: #F99A73;
    color: #fff;
    display: none;
}
input.dashboard-input.w-100 {
    border: thin solid #888;
    margin-top: 5px;
}

/* we will explain what these classes do next! */
.anim {
      margin-right: -100%;
      transition: all 300ms ease-in-out;
}
</style>
