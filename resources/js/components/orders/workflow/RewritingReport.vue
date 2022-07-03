<template>
    <div id="rewrite-section">
        <div class="step-non-ediable" v-if="!editable">
            <ValidationObserver ref="rewritingReport">
                <div class="re-writing-report-item step-items">
                    <div class="group">
                        <p class="text-light-black mgb-12">Note from previous stpes</p>
                        <p class="mb-0 text-light-black fw-bold" v-html="prev.rewrite_note"></p>
                    </div>

                    <div class="group" v-if="current.note">
                        <p class="text-light-black mgb-12">Note from this step</p>
                        <a href="#" class="primary-text mb-2">(Rewrite & send back)</a>
                        <p class="mb-0 text-light-black fw-bold" v-html="current.note"></p>
                    </div>

                    <div class="assign_rewrite" :class="{ 'invalid-form' : chooseAssign.type }">
                        <div class="rewrite_step_1">
                            <label for="" class="mb-2 text-light-black d-inline-block">Assign to</label>
                            <m-select theme="blue" :options="usersInfo" object item-text="name" item-value="id" @change="chooseAssignChange($event)" v-model="assigned_to"></m-select>
                            <span class="error-message" v-if="chooseAssign.type">{{ chooseAssign.message }}</span>
                        </div>
                        <div class="rewrite_step_2">
                            <button class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="saveAssigneeOnly">Assign</button>
                        </div>
                    </div>

                    <div class="group">
                        <p class="text-light-black mgb-12">Files From Previous Step</p>
                        <div class="row">
                            <div class="d-flex align-items-center mb-3 document" v-for="file, fileIndex in dataFiles"
                                :key="fileIndex">
                                <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                <span class="text-light-black d-inline-block mgl-12 file-name">{{ file.name }}</span>
                            </div>
                        </div>
                    </div>
                    <template v-if="orderData.report_rewrite != null">
                        <div class="mgb-20">
                            <ValidationProvider class="group" name="Choose Notes" rules="required" v-slot="{ errors }">
                                <div :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                                    <div class="preparation-input w-100 position-relative">
                                        <textarea v-model="note" cols="30" rows="3"
                                            class="w-100 dashboard-textarea"></textarea>
                                    </div>
                                </div>
                            </ValidationProvider>
                        </div>
                        <div>
                            <p class="text-light-black mgb-12">Files</p>
                            <div class="position-relative file-upload">
                                <input type="file" multiple v-on:change="addFiles">
                                <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span></span></label>
                            </div>
                            <p class="text-light-black mgb-12" v-if="fileData.files.length">{{ fileData.files.length }}
                                Files</p>
                        </div>
                        <div class="text-end mgt-32">
                            <button v-if="current.note"
                                class="button button-danger px-4 h-40 d-inline-flex align-items-center"
                                @click="editable = true">Close</button>
                            <button class="button button-primary px-4 h-40 d-inline-flex align-items-center"
                                @click="saveAssigneeData">Done</button>
                        </div>
                    </template>
                </div>
            </ValidationObserver>
        </div>
        <div class="step-editable" v-else>
            <ValidationObserver>
                <div class="re-writing-report-item step-items">
                    <a class="edit-btn" @click="editable = false"><span class="icon-edit"><span
                                class="path1"></span><span class="path2"></span></span></a>
                    <div class="group">
                        <p class="text-light-black mgb-12">Note from previous stpes</p>
                        <p class="mb-0 text-light-black fw-bold" v-html="prev.rewrite_note"></p>
                    </div>
                    <div class="group">
                        <p class="text-light-black mgb-12">Note from this step</p>
                        <p class="primary-text mb-2">(Rewrite & send back)</p>
                        <p class="mb-0 text-light-black fw-bold" v-html="current.note"></p>
                    </div>
                    <div class="group" v-if="current.assignee">
                        <p class="text-light-black mgb-12">Assign to</p>
                        <p class="mb-0 text-light-black fw-bold">{{ current.assignee.name }}</p>
                    </div>

                    <div class="group">
                        <p class="text-light-black mgb-12">Files From Previous Step</p>
                        <div class="row">
                            <div class="d-flex align-items-center mb-3 document" v-for="file, fileIndex in dataFiles"
                                :key="fileIndex">
                                <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                <span class="text-light-black d-inline-block mgl-12 file-name">
                                    <a :href="file.original_url" download>{{ file.name }}</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="group">
                        <p class="text-light-black mgb-12">Files From Current Step</p>
                        <div class="row">
                            <div class="d-flex align-items-center mb-3 document" v-for="file, fileIndex in reportFiles"
                                :key="fileIndex">
                                <img src="/img/pdf.svg" alt="boston profile" class="img-fluid">
                                <span class="text-light-black d-inline-block mgl-12 file-name">
                                    <a :href="file.original_url" download>{{ file.name }}</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </ValidationObserver>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'RewritingReport',
        props: ['order'],
        data: () => ({
            chooseAssign: {
                message: null,
                type: false,
            },
            orderData: [],
            prev: [],
            current: [],
            dataFiles: [],
            note: null,
            assigned_to: null,
            editable: false,
            fileData: {
                files: [],
            },
            retportFiles: [],
        }),
        inject: ['usersInfo'],
        created() {
            let order = this.order;
            let localOrderData = this.$store.getters['app/orderDetails']
            if (localOrderData) {
                order = localOrderData;
            }
            this.initData(order);

            this.$root.$on("wk_update", (res) => {
                this.initData(res);
            });
        },
        methods: {
            addFiles(event) {
                this.fileData.files = event.target.files
            },
            initData(order) {
                this.orderData = order;
                this.prev = order.analysis ?? [];
                this.current = order.report_rewrite ?? [];

                this.dataFiles = this.prev.attachments;
                if (this.current) {
                    this.assigned_to = this.current.assigned_to;
                    this.note = this.current.note;
                    this.editable = true;
                    this.reportFiles = this.current.attachments
                }
            },
            saveAssigneeData() {
                this.$refs.rewritingReport.validate().then((status) => {
                    if (status) {
                        let formData = new FormData();
                        for (let i = 0; i < this.fileData.files.length; i++) {
                            let file = this.fileData.files[i];
                            formData.append('files[' + i + ']', file);
                        }
                        formData.append('note',this.note)
                        formData.append('assigned_to',this.assigned_to)
                        formData.append('order_id', this.orderData.id)
                        this.$boston.post('rewrite-report/update', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(res => {
                            if (res.error == false) {
                                this.fileData.files = []
                                this.orderData = res.data;
                                this.editable = true;
                                this.initData(this.orderData);
                                this.$root.$emit('wk_update', this.orderData);
                                this.$root.$emit('wk_flow_menu', this.orderData);
                            }
                            this.$root.$emit('wk_flow_toast', res);
                        }).catch(err => {
                            console.log('err', err)
                        });
                    }
                })
            },
            chooseAssignChange(value) {
                if (value) {
                    this.chooseAssign.type = false;
                }
            },
            saveAssigneeOnly() {
                this.chooseAssign.type = false;
                if (this.assigned_to == null || this.assigned_to == "") {
                    this.chooseAssign = {
                        message: "Please choose an assignee",
                        type: true
                    }
                    return false;
                }
                this.$boston.post('rewrite-report/update/assignee', {
                        assigned_to: this.assigned_to,
                        orderId: this.orderData.id
                    }).then(res => {
                        if (res.error == false) {
                            this.orderData = res.data;
                            this.initData(this.orderData);
                            this.$root.$emit('wk_update', this.orderData);
                            this.$root.$emit('wk_flow_menu', this.orderData);
                        }
                        this.$root.$emit('wk_flow_toast', res);
                    }).catch(err => {
                        console.log('err', err)
                    });
                },
        }
    }
</script>

<style scoped>
    .invalid-form textarea,
    .invalid-form select {
        border: thin solid #c44 !important;
    }

    .invalid-form label {
        color: rgb(238, 80, 80) !important;
    }
    .assign_rewrite {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
    }
    .rewrite_step_1 {
        flex: 80%;
    }
    .rewrite_step_2 {
        flex: 20%;
        text-align: right;
        margin-top: 30px;
    }
    .invalid-form .rewrite_step_2 {
        margin-top: 10px;
    }
</style>
