<template>
    <div class="quality-assurance-item step-items">
        <!-- step 1 -->
        <div v-if="currentStep == 'step1'">
            <div class="group">
                <p class="text-light-black mgb-12">Instruction from previous step</p>
                <p class="text-success">(Rewrite & send back)</p>
                <p class="mb-0 text-light-black fw-bold" v-html="rewrite_note"></p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Note from this step</p>
                <p class="text-success">(Check & Upload)</p>
                <p class="mb-0 text-light-black fw-bold notes-prev" v-html="analysisnote"></p>
            </div>
            <div class="group" v-if="orderData.analysis">
                <p class="text-light-black mgb-12">Files</p>
                <div class="document">
                    <div class="row">
                        <div class="d-flex align-items-center mb-3" v-for="file, indexKey in analysis.attachments" :key="indexKey">
                            <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                                    class="img-fluid">
                            <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                                class="img-fluid">
                            <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12 file-name">
                                <a :href="file.original_url" target="_blank" download class="text-light-black mb-0 file-name">{{
                                    file.name }}</a>
                                <p class="text-gray mb-0 fs-12 ">Uploaded: {{ analysis.updated_by.name + ', ' +
                                    analysis.updated_at }}</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <ValidationObserver ref="qualityAssuranceForm">
                <div class="mgb-32">
                    <ValidationProvider class="group" name="Assigned to" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Assigned to<span
                                    class="text-danger require"></span></label>
                            <!-- <select class="dashboard-input w-100" v-model="qa.assigned_to">
                                <option value="">Please select to assign</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select> -->
                            <m-select theme="blue" :options="users" object item-text="name" item-value="id"
                                v-model="qa.assigned_to"></m-select>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>
            </ValidationObserver>
            <div class="group">
                <p class="text-light-black mgb-12">Effective Date</p>
                <p class="mb-0 text-light-black fw-bold">{{ orderData.due_date }}</p>
            </div>
            <div class="group">
                <label for="" class="d-block mb-2 dashboard-label">Modify Effective date</label>
                <v-date-picker v-model="qa.effective_date" :available-dates='{ start: qa.effective_date, end: null }'>
                    <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                        <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents" />
                    </template>
                </v-date-picker>
            </div>
            <div class="text-end mgt-32">
                <button class="button button-primary px-4 h-40 d-inline-flex align-items-center"
                    @click="saveQualityAssurance">Save</button>
            </div>
        </div>
        <!-- step 2 -->
        <div v-if="currentStep == 'step2'">
            <div class="group">
                <p class="text-light-black mgb-12">Instruction from previous step</p>
                <p class="text-success">(Rewrite & send back)</p>
                <p class="mb-0 text-light-black fw-bold" v-html="rewrite_note"></p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Note from this step</p>
                <p class="text-success">(Check & Upload)</p>
                <p class="mb-0 text-light-black fw-bold notes-prev" v-html="analysisnote"></p>
            </div>
            <div class="group" v-if="analysis">
                <p class="text-light-black mgb-12">Files</p>
                <div class="document">
                    <div class="row">
                        <div class="d-flex align-items-center mb-3" v-for="file, indexKey in analysis.attachments" :key="indexKey">
                            <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                                class="img-fluid">
                            <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                                class="img-fluid">
                            <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12 file-name">
                                <a :href="file.original_url" target="_blank" download class="text-light-black mb-0 file-name">{{
                                    file.name }}</a>
                                <p class="text-gray mb-0 fs-12">Uploaded: {{ analysis.updated_by.name + ', ' +
                                    analysis.updated_at }}</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Assigned to</p>
                <p class="mb-0 text-light-black fw-bold">{{ qa.assigned_name }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Original effective date</p>
                <p class="mb-0 text-light-black fw-bold">{{ this.orderData.due_date }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Changed effective date</p>
                <p class="mb-0 text-light-black fw-bold">{{ qa.effective_date }}</p>
            </div>
            <div class="group">
                <div class="position-relative file-upload">
                    <input type="file" multiple v-on:change="addFiles">
                    <label for="" class="py-2">Upload <span class="icon-upload ms-3 fs-20"><span
                                class="path1"></span><span class="path2"></span><span
                                class="path3"></span></span></label>
                    <p v-if="filesCount > 0">{{ filesCount + 'files selected' }}</p>
                </div>
            </div>
            <ValidationObserver ref="qaUpdate">
                <div class="mgb-20">
                    <ValidationProvider class="group" name="Quality Assurance Note"
                        v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                            <div class="preparation-input w-100 position-relative">
                                <text-editor v-model="qa.note" placeholder="Add note..."></text-editor>
                            </div>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>
            </ValidationObserver>
            <button v-if="canAddCom" class="button button-primary px-4 h-40 d-inline-flex align-items-center"
                @click="comList = true">Add
                comparable list for original photo</button>
            <div class="text-end mgt-32">
                <button type="button" class="button button-primary px-4 h-40 d-inline-flex align-items-center"
                    @click="updateQualityAssurance">Done</button>
            </div>
            <!-- Com list -->
            <div v-if="comList" class="com-list vue-modal">
                <div class="content w-100 max-w-556">
                    <p class="fs-20 fw-bold mgb-20">COM list</p>
                    <div class="">
                        <p class="mgb-8">Add new</p>
                        <input type="text" @keyup="getLocation" id="com-input"
                            class="dashboard-input w-100 gray-border">
                        <div class="text-end" @click="addLocation">
                            <span style="cursor:pointer" class="add primary-text fw-bold">
                                <svg width="12" height="9" viewBox="0 0 12 9" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.29515 8.6053C4.05503 8.6053 3.82691 8.50925 3.65883 8.34117L0.261131 4.94347C-0.0870435 4.5953 -0.0870435 4.01901 0.261131 3.67084C0.609305 3.32266 1.18559 3.32266 1.53377 3.67084L4.29515 6.43222L10.4662 0.261131C10.8144 -0.0870435 11.3907 -0.0870435 11.7389 0.261131C12.087 0.609305 12.087 1.18559 11.7389 1.53377L4.93147 8.34117C4.76338 8.50925 4.53527 8.6053 4.29515 8.6053Z"
                                        fill="#19B7A2" />
                                </svg>
                                Add</span>
                        </div>
                    </div>
                    <!-- map name -->
                    <div class="map-name mgt-20">
                        <div class="map-name-list d-flex justify-content-between" v-for="(address,index) in addresses"
                            :id="address.id" :key="index">
                            <p class="mb-0">{{ address.address }}</p>
                            <span @click="removeAddress(index)" class="icon-trash fs-20 cursor-pointer"><span
                                    class="path1"></span><span class="path2"></span><span class="path3"></span><span
                                    class="path4"></span></span>
                        </div>
                    </div>
                    <!-- button -->
                    <div class="text-end">
                        <button type="button" class="button button-transparent" @click="comList = false">Close</button>
                        <button type="button" class="button button-primary px-5" @click="saveCom">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- step 3 -->
        <div v-if="currentStep == 'step3'">
            <a class="edit-btn" @click="editQualityAssurance"><span class="icon-edit"><span class="path1"></span><span
                        class="path2"></span></span></a>
            <div class="group">
                <p class="text-light-black mgb-12">Instruction from previous step</p>
                <p class="text-success">(Rewrite & send back)</p>
                <p class="mb-0 text-light-black fw-bold">{{ rewrite_note }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Note from this step</p>
                <p class="text-success">(Check & Upload)</p>
                <p class="mb-0 text-light-black fw-bold notes-prev">{{ analysisnote }}</p>
            </div>
            <div class="group" v-if="orderData.analysis">
                <p class="text-light-black mgb-12">Files</p>
                <div class="document">
                    <div class="row">
                        <div class="d-flex align-items-center mb-3" v-for="file, indexKey in orderData.analysis.attachments"
                            :key="indexKey">
                            <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                                    class="img-fluid">
                            <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                                class="img-fluid">
                            <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12 file-name">
                                <a :href="file.original_url" target="_blank" download class="text-light-black mb-0 file-name">{{
                                    file.name }}</a>
                                <p class="text-gray mb-0 fs-12">Uploaded: {{ orderData.analysis.updated_by.name + ', ' +
                                    orderData.analysis.updated_at }}</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Assigned to</p>
                <p class="mb-0 text-light-black fw-bold">{{ qa.assigned_name }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Original effective date</p>
                <p class="mb-0 text-light-black fw-bold">{{ this.orderData.due_date }}</p>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Changed effective date</p>
                <p class="mb-0 text-light-black fw-bold">{{ qa.effective_date }}</p>
            </div>
            <div class="group" v-if="orderData.quality_assurance">
                <p class="text-light-black mgb-12">Quality assurance files</p>
                <div class="document">
                    <div class="row">
                        <div class="d-flex align-items-center mb-3" v-for="file, indexKey in orderData.quality_assurance.attachments"
                            :key="indexKey">
                            <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                                class="img-fluid">
                            <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                                class="img-fluid">
                            <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                            <span class="text-light-black d-inline-block mgl-12 file-name">
                                <a :href="file.original_url" target="_blank" download class="text-light-black mb-0 file-name">{{
                                    file.name }}</a>
                                <p class="text-gray mb-0 fs-12">Uploaded: {{ orderData.quality_assurance.updated_by.name + ', '
                                    +
                                    orderData.quality_assurance.updated_at }}</p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="group">
                <p class="text-light-black mgb-12">Com route list</p>
                <p class="mb-0 text-light-black fw-bold" v-for="address,index in comAddresses" :key="index+'qa-01'">{{ (index+1) + '. ' +
                    address.address }}</p>
            </div>
            <button v-if="showSeeCom" type="button"
                class="button button-primary px-4 h-40 d-inline-flex align-items-center mt-4" @click="openSeeCom">Open
                Map
            </button>
            <span v-if="copied" class="alert alert-success py-2 mb-0 mgr-20 text-600">Copied</span>
            <a v-if="showSeeCom" :href="publicCom" @click.prevent="copyURL" ref="shareLink"
                class="button button-primary h-40 d-inline-flex align-items-center"><span class="mgr-20">Share
                    com url</span> <span class="icon-share"><span class="path1"></span><span class="path2"></span><span
                        class="path3"></span><span class="path4"></span><span class="path5"></span><span
                        class="path6"></span></span></a>
            <b-modal id="com-assign" size="md" title="Assign Route">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ValidationObserver ref="comAssignForm">
                                <ValidationProvider class="group d-block" name="Assign to" rules="required"
                                    v-slot="{ errors }">
                                    <div :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Assign to<span
                                                class="text-danger require"></span></label>
                                        <m-select theme="blue" :options="users" object item-text="name" item-value="id"
                                            v-model="qa.assigned_to"></m-select>
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider class="group d-block" name="Route link" rules="required"
                                    v-slot="{ errors }">
                                    <div :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Route link<span
                                                class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100 gray-border"
                                            placeholder="Enter generated route from the map" v-model="qa.route">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                            </ValidationObserver>
                        </div>
                    </div>
                </div>
                <div slot="modal-footer">
                    <b-button type="button" variant="secondary" @click="$bvModal.hide('com-assign')">Close</b-button>
                    <b-button type="button" variant="primary" @click="saveMapData">Save</b-button>
                </div>
            </b-modal>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'QualityAssurance',
        props: {
            order: [],
            users: [],
            publicCom: ''
        },
        data: () => ({
            qa: {
                qa_id: 0,
                order_id: '',
                effective_date: '',
                assigned_to: '',
                assigned_name: '',
                note: '',
                files: [],
                route: ''
            },
            startingPointValue: null,
            analysis: {},
            rewrite_note: null,
            analysisnote: null,
            placeName: '',
            placeLat: '',
            placeLng: '',
            addresses: [],
            orderData: [],
            filesCount: '',
            currentStep: 'step1',
            alreadyQualityAssurance: 0,
            comList: false,
            showSeeCom: false,
            comAddresses: [],
            comId: 0,
            canAddCom: false,
            copied: false
        }),
        created() {
            let order = this.order;
            let localOrderData = this.$store.getters['app/orderDetails']
            if (localOrderData) {
                order = localOrderData;
            }
            this.getReportAnalysisData(order)
            this.$root.$on('wk_update', (res) => {
                localStorage.setItem('qaItem', JSON.stringify(res))
                this.getReportAnalysisData(res, true)
            })
        },
        destroyed() {
            localStorage.removeItem('qaItem');
        },
        methods: {
            copyURL(event) {
                let container = this.$refs.shareLink
                this.copy(container);
                this.copied = true
                setTimeout(() => {
                    this.copied = false
                }, 500)
            },
            saveMapData() {
                this.$refs.comAssignForm.validate().then((status) => {
                    if (status) {
                        let formData = new FormData();
                        formData.append('com_id', this.comId)
                        formData.append('order_id', this.orderData.id)
                        formData.append('assigned_to', this.qa.assigned_to)
                        formData.append('route', this.qa.route)
                        this.$boston.post('save-com-route', formData)
                            .then(res => {
                                this.orderData = res.data
                                this.$root.$emit('wk_update', this.orderData)
                                this.$root.$emit('wk_flow_menu', this.orderData)
                                this.$root.$emit('wk_flow_toast', res);
                                this.getReportAnalysisData(res.data);
                                this.$bvModal.hide('com-assign')
                            })
                            .catch(err => {
                                console.error(err)
                            })
                    }
                })
            },
            openSeeCom() {
                this.$bvModal.show('com-assign');
                let startAddress = this.comAddresses[0].address
                let endAddress = ''
                let wayPoints = '';
                let travelMode = "driving";
                for (var i = 1; i < this.comAddresses.length; i++) {
                    if (i != this.comAddresses.length - 1)
                        wayPoints += this.comAddresses[i]['address'] + "|"

                    if (i == this.comAddresses.length - 1) {
                        endAddress = this.comAddresses[i]['address']
                    }
                }
                let url = 'https://www.google.com/maps/dir/?api=1&travelmode=' + travelMode + '&origin=' + startAddress + '&destination=' + endAddress + '&waypoints=' + wayPoints;

                window.open(url, '_blank');
            },
            getLocation() {
                const center = { lat: 42.361145, lng: -71.057083 };
                //need to make dynamic if get time
                const comInput = document.getElementById("com-input")

                const options = {
                    componentRestrictions: { country: "us" },
                    fields: ["address_components", "formatted_address", "geometry"],
                    strictBounds: false,
                    types: ["address"],
                };
                const autocomplete = new google.maps.places.Autocomplete(comInput, options);

                let self = this;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace()
                    if (comInput.value.length > 0) {
                        self.placeName = place.formatted_address
                        self.placeLat = place.geometry.location.lat()
                        self.placeLng = place.geometry.location.lng()
                    } else {
                        return false
                    }
                })
            },
            addLocation() {
                if (this.placeName.length > 0) {
                    this.addresses.push({ 'address': this.placeName, 'lat': this.placeLat, 'lng': this.placeLng })
                    document.getElementById("com-input").value = ''
                    this.placeName = ''
                }
                return false
            },
            removeAddress(index) {
                this.addresses.splice(index, 1)
            },
            saveCom() {
                this.$boston.post('save-com/' + this.orderData.id, this.addresses)
                    .then(res => {
                        let self = this
                        this.orderData = res.data
                        this.alreadyHaveComList = false
                        this.comAddresses = JSON.parse(this.orderData.comlist.destination)
                        this.$root.$emit('wk_update', this.orderData)
                        this.$root.$emit('wk_flow_menu', this.orderData)
                        this.$root.$emit('wk_flow_toast', res);
                        this.showSeeCom = true
                        //this.initMap()
                        setTimeout(() => {
                            self.comList = false
                        }, 1000);
                    })
                    .catch(err => {
                        console.error(err)
                    })
            },
            getReportAnalysisData(order, localstore) {
                if (localstore == true) {
                    let orderInfo = JSON.parse(localStorage.getItem('qaItem'));
                    this.orderData = orderInfo;
                } else {
                    this.orderData = order;
                }
                this.alreadyQualityAssurance = (JSON.parse(this.orderData.workflow_status)).qualityAssurance
                this.alreadyQualityAssurance == 1 ? this.currentStep = 'step2' : 'step1';
                this.orderData.amc.com_required == '1' ? this.canAddCom = true : false
                this.analysis = this.orderData.analysis;

                if (this.orderData.analysis) {
                    this.analysisnote = this.orderData.analysis.note;
                }
                if (this.orderData.report_rewrite) {
                    this.rewrite_note = this.orderData.report_rewrite.note;
                }

                if (this.orderData.comlist) {
                    this.showSeeCom = true
                    this.comAddresses = JSON.parse(this.orderData.comlist.destination)
                    this.addresses = this.comAddresses
                    this.comId = this.orderData.comlist.id
                }
                this.qa.order_id = order.id
                this.qa.effective_date = this.orderData.due_date

                if (this.orderData.quality_assurance) {
                    if (this.alreadyQualityAssurance == 1 && this.orderData.quality_assurance.note) {
                        this.currentStep = 'step3';
                    }

                    this.qa.qa_id = this.orderData.quality_assurance.id

                    if (this.orderData.quality_assurance.note === "null" || this.orderData.quality_assurance.note == "null" || this.orderData.quality_assurance.note === null || (typeof this.orderData.quality_assurance.note) == undefined) {

                    } else {
                        this.qa.note = this.orderData.quality_assurance.note;
                    }

                    this.qa.assigned_to = this.orderData.quality_assurance.assigned_to
                    this.qa.assigned_name = this.orderData.quality_assurance.assignee.name
                    this.qa.effective_date = this.orderData.quality_assurance.effective_date
                }
                this.analysis = this.orderData.analysis;
            },
            saveQualityAssurance() {
                this.$refs.qualityAssuranceForm.validate().then((status) => {
                    if (status) {
                        let self = this
                        this.$boston.post('save-quality-assurance', this.qa)
                            .then(res => {
                                this.orderData = res.data
                                this.$root.$emit('wk_update', this.orderData)
                                this.$root.$emit('wk_flow_menu', this.orderData)
                                this.$root.$emit('wk_flow_toast', res);
                                this.getReportAnalysisData(res.data);
                                this.currentStep = 'step2'
                            }).catch(err => {
                                console.error(err)
                            })
                    }
                })
            },
            addFiles(event) {
                this.qa.files = event.target.files
                this.filesCount = event.target.files.length
            },
            editQualityAssurance() {
                this.currentStep = 'step2'
            },
            updateQualityAssurance() {
                if (this.orderData.quality_assurance?.attachments.length == 0 && !this.fileCheck(this.qa.files)) {
                    return false;
                }
                this.$refs.qaUpdate.validate().then((status) => {
                    if (status) {
                        let formData = new FormData();
                        for (let i = 0; i < this.qa.files.length; i++) {
                            let file = this.qa.files[i];
                            formData.append('files[' + i + ']', file);
                        }
                        formData.append('note', this.qa.note)
                        formData.append('qa_id', this.qa.qa_id)
                        this.$boston.post('update-quality-assurance', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(res => {
                            this.orderData = res.data
                            this.qa.files = []
                            this.$root.$emit('wk_update', this.orderData)
                            this.$root.$emit('wk_flow_menu', this.orderData)
                            this.$root.$emit('wk_flow_toast', res);
                            this.getReportAnalysisData(res.data);
                            this.currentStep = 'step3'
                        }).catch(err => {
                            console.error(err)
                        })
                    }
                })
            }
        }
    }
</script>
<style scoped>
    #map {
        height: 100%;
        width: 100%;
    }

</style>
