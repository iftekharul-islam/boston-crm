<template>
    <ValidationObserver ref="addCallLogForm">
        <!-- modal -->
        <b-modal id="add-call-log" class="brrower-modal" size="md" title="Add Call Log" no-close-on-backdrop>
            <div class="modal-body brrower-modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Assign To</label>
                            <m-select :options="users" object item-text="name" item-value="id" v-model="assignTo"></m-select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="group">
                            <label for="" class="d-block mb-2 dashboard-label">Template</label>
                            <m-select :options="templates" object item-text="title" item-value="message" v-model="message"></m-select>
                        </div>
                    </div>
                    <div class="col-12 mt-2" v-if="template.save">
                        <ValidationProvider class="d-block group" name="Title" :rules="{'required': template.save}" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Title</label>
                                <input type="text" v-model="template.title" placeholder="Enter title..." class="dashboard-input w-100">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="col-12 mt-2">
                        <ValidationProvider class="d-block group" name="Message" :rules="{'required': schedule.save == false}" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Message</label>
                                <b-form-textarea v-model="message" placeholder="Enter Message..." rows="2"
                                                 cols="5">
                                </b-form-textarea>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div v-if="schedule.save">
                        <ValidationProvider class="d-block group" name="Schedule date" :rules="{'required': schedule.save}" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Schedule date</label>
                                <v-date-picker mode="datetime" v-model="schedule.date"
                                               :available-dates='{ start: new Date(), end: null }'>
                                    <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                                        <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents"
                                               @change="schedule.error = false"/>
                                    </template>
                                </v-date-picker>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="col-12">
                        <div class="checkbox-group review-check mgt-20">
                            <input type="checkbox" class="checkbox-input check-data" v-model="schedule.save">
                            <label for="" class="checkbox-label text-capitalize">Create schedule </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="checkbox-group review-check mgt-20">
                            <input type="checkbox" class="checkbox-input check-data" v-model="template.save">
                            <label for="" class="checkbox-label text-capitalize">Save as Template </label>
                        </div>
                    </div>
                </div>
            </div>
            <div slot="modal-footer" class="mgt-44">
                <button class="button button-transparent" @click="hideModel">Close</button>
                <button class="button button-primary" @click="addLog">Post</button>
            </div>
        </b-modal>
    </ValidationObserver>
</template>


<script>
export default {
    props: [
        'order', 'showModal', 'users', 'isCompleted'
    ],
    data: () => ({
        schedule: {
            save: false,
            date: '',
            error: false
        },
        id: '',
        message: '',
        assignTo: '',
        notCompleted: true,
        complete: null,
        templates: [],
        template: {
            save: false,
            title: ''
        }
    }),
    watch: {
        showModal(newValue, oldValue) {
            if (newValue === true) {
                this.fetchData(this.order)
                this.notCompleted = this.isCompleted
                this.$bvModal.show('add-call-log')
            } else {
                this.$bvModal.hide('add-call-log')
            }
        }
    },
    created() {
        this.id = this.order.id;
        this.notCompleted = this.isCompleted
        this.updateTemplate()
    },
    methods: {
        fetchData(order) {
            console.log(order)
            this.message = ''
            this.assignTo = ''
            this.complete = null
            this.template.save = false

            this.template.title = ''
            this.schedule.date = order.call_date
            if(this.schedule.date){
                this.schedule.save = true
            }
            this.updateTemplate()
            this.id = order.id
        },
        updateTemplate(){
            axios.get('log-template-list')
                .then(res => {
                    this.templates = res.data
                }).catch(err => {
                console.log(err)
            })
        },
        hideModel() {
            this.$bvModal.hide('add-call-log')
            this.$root.$emit('update_modal')
        },
        addLog(){
            this.$refs.addCallLogForm.validate().then((status) => {
                if (status) {

                    let formData = new FormData();
                    formData.append('message', this.message)
                    formData.append('caller_id', this.assignTo)
                    formData.append('template', this.template.save)
                    formData.append('title', this.template.title)
                    formData.append('schedule', this.schedule.save)
                    formData.append('date', this.schedule.date)

                    axios.post('call-log/' + this.id, formData)
                        .then(res => {
                            this.$root.$emit('wk_flow_toast', res.data)
                            this.$bvModal.hide('add-call-log')
                            if(res.data.data){
                                this.$root.$emit('call_log_update', res.data.data)
                                this.$root.$emit('wk_update', res.data.data)
                                this.$root.$emit('wk_flow_menu', res.data.data)
                            }
                        }).catch(err => {
                        console.log(err)
                    })
                }
            })
        },
    }
}

</script>
