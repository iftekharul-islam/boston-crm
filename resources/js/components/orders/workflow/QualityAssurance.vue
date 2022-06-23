<template>
    <div class="quality-assurance-item step-items">
        <!-- step 1 -->
        <div v-if="currentStep == 'step1'">
            <div class="group">
                <p class="text-light-black mgb-12">Instruction from previous step</p>
                <p class="text-success">(Rewrite & send back)</p>
                <p class="mb-0 text-light-black fw-bold">{{ rewrite_note }}</p>
            </div>
            <div class="group">
                <p class="text-success">(Check & Upload)</p>
                <p class="mb-0 text-light-black fw-bold">{{ analysisnote }}</p>
            </div>
            <div class="group" v-if="orderData.analysis">
                <p class="text-light-black mgb-12">Files</p>
                <div class="d-flex align-items-center" v-for="attachment, indexKey in analysis.attachments" :key="indexKey">
                    <div class="file-img">
                        <img src="/img/pdf.png" alt="boston pdf image">
                    </div>
                    <div class="mgl-12">
                        <p class="text-light-black mb-0">{{ attachment.name }}</p>
                        <p class="text-gray mb-0 fs-12">Uploaded: {{ analysis.updated_by.name + ', ' + analysis.updated_at }}</p>
                    </div>
                </div>
            </div>
            <ValidationObserver ref="qualityAssuranceForm">
                <div class="mgb-32">
                    <ValidationProvider class="group" name="Assigned to" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="d-block mb-2 dashboard-label">Assigned to<span
                                    class="text-danger require"></span></label>
                            <select class="dashboard-input w-100" v-model="qa.assigned_to">
                                <option value="">Please select to assign</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
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
                <p class="mb-0 text-light-black fw-bold">{{ rewrite_note }}</p>
            </div>
            <div class="group">
                <p class="text-success">(Check & Upload)</p>
                <p class="mb-0 text-light-black fw-bold">{{ analysisnote }}</p>
            </div>
            <div class="group" v-if="analysis">
                <p class="text-light-black mgb-12">Files</p>
                <div class="d-flex align-items-center" v-for="attachment, indexKey in analysis.attachments" :key="indexKey">
                    <div class="file-img">
                        <img src="/img/pdf.png" alt="boston pdf image">
                    </div>
                    <div class="mgl-12">
                        <p class="text-light-black mb-0">{{ attachment.name }}</p>
                        <p class="text-gray mb-0 fs-12">Uploaded: {{ analysis.updated_by.name + ', ' + analysis.updated_at }}</p>
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
                    <ValidationProvider class="group" name="Quality Assurance Note" rules="required" v-slot="{ errors }">
                        <div :class="{ 'invalid-form' : errors[0] }">
                            <label for="" class="mb-2 text-light-black d-inline-block">Add note</label>
                            <div class="preparation-input w-100 position-relative">
                                <textarea v-model="qa.note" cols="30" rows="3"
                                    class="w-100 dashboard-textarea"></textarea>
                            </div>
                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                        </div>
                    </ValidationProvider>
                </div>
            </ValidationObserver>
            <button v-if="canAddCom" class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="comList = true">Add
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

                        <!-- <div class="map-name-outline mgb-20">
                        <span class="d-inline-block me-2">
                            <svg width="15" height="20" viewBox="0 0 15 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.5455 7.10145L14.5453 7.14009C14.5453 7.15636 14.5451 7.17264 14.5449 7.18892C14.5453 7.20792 14.5455 7.22706 14.5455 7.24638C14.5455 10.2793 12.1825 12.964 10.6012 14.7606C10.1424 15.2819 9.74943 15.7284 9.49907 16.087C8.60853 17.3623 8.13853 18.744 8.01484 19.2754C8.01484 19.6756 7.68259 20 7.27273 20C6.86286 20 6.53061 19.6756 6.53061 19.2754C6.40692 18.744 5.93692 17.3623 5.04638 16.087C4.79603 15.7284 4.40303 15.2819 3.94421 14.7606C2.36297 12.964 0 10.2793 0 7.24638C0 7.22706 0.00018118 7.20792 0.000543541 7.18892C0.00018118 7.1598 0 7.13064 0 7.10145C0 3.17942 3.2561 0 7.27273 0C11.2894 0 14.5455 3.17942 14.5455 7.10145ZM7.27273 9.71014C8.83019 9.71014 10.0928 8.47731 10.0928 6.95652C10.0928 5.43574 8.83019 4.2029 7.27273 4.2029C5.71526 4.2029 4.45269 5.43574 4.45269 6.95652C4.45269 8.47731 5.71526 9.71014 7.27273 9.71014Z"
                                    fill="#34A851" />
                                <path
                                    d="M13.732 3.83497C12.8415 2.15942 11.2872 0.87425 9.40928 0.311523L5.23242 5.05578C5.74596 4.53038 6.47019 4.20305 7.27271 4.20305C8.83018 4.20305 10.0927 5.43589 10.0927 6.95668C10.0927 7.57708 9.88263 8.14957 9.5281 8.60997L13.732 3.83497Z"
                                    fill="#4285F5" />
                                <path
                                    d="M4.02877 14.8569C4.00092 14.8252 3.9728 14.7933 3.94443 14.761C2.90214 13.5768 1.52018 12.0067 0.699219 10.2053L5.04043 5.27441C4.67209 5.73973 4.45291 6.32333 4.45291 6.95697C4.45291 8.47775 5.71549 9.71059 7.27295 9.71059C8.0619 9.71059 8.77517 9.39423 9.287 8.88437L4.02877 14.8569Z"
                                    fill="#F9BB0E" />
                                <path
                                    d="M1.7208 2.51465C0.64734 3.75212 0 5.35322 0 7.10198C0 7.13117 0.00018118 7.16033 0.000543541 7.18945C0.00018118 7.20845 0 7.22759 0 7.24691C0 8.28065 0.274506 9.27395 0.698994 10.2054L5.03288 5.28281L1.7208 2.51465Z"
                                    fill="#E74335" />
                                <path
                                    d="M9.40918 0.311403C8.7336 0.108979 8.01614 0 7.27261 0C5.04692 0 3.05475 0.976244 1.7207 2.51412L5.03279 5.28225L5.04 5.27407C5.10024 5.19797 5.16447 5.12501 5.2324 5.05552L9.40918 0.311403Z"
                                    fill="#1A73E6" />
                            </svg>
                        </span>
                        <p class="mb-0">www.google.com/maps/@23.8457047, 90.4408129,15z</p>
                        <span class="d-inline-block ms-auto">
                            <span class="icon-edit cursor-pointer"><span class="path1"></span><span
                                    class="path2"></span></span>
                        </span>
                    </div> -->
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
                <p class="text-success">(Check & Upload)</p>
                <p class="mb-0 text-light-black fw-bold">{{ analysisnote }}</p>
            </div>
            <div class="group" v-if="orderData.analysis">
                <p class="text-light-black mgb-12">Files</p>
                <div class="d-flex align-items-center" v-for="attachment, indexKey in orderData.analysis.attachments"
                    :key="indexKey">
                    <div class="file-img">
                        <img src="/img/pdf.png" alt="boston pdf image">
                    </div>
                    <div class="mgl-12">
                        <p class="text-light-black mb-0">{{ attachment.name }}</p>
                        <p class="text-gray mb-0 fs-12">Uploaded: {{ orderData.analysis.updated_by.name + ', ' +
                            orderData.analysis.updated_at }}</p>
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
            <div class="group" v-if="analysis">
                <p class="text-light-black mgb-12">Files</p>
                <div class="d-flex align-items-center" v-for="attachment, indexKey in analysis.attachments" :key="indexKey">
                    <div class="file-img">
                        <img src="/img/pdf.png" alt="boston pdf image">
                    </div>
                    <div class="mgl-12">
                        <p class="text-light-black mb-0">{{ attachment.name }}</p>
                        <p class="text-gray mb-0 fs-12">Uploaded: {{ analysis.updated_by.name + ', ' + analysis.updated_at }}</p>
                    </div>
                </div>
            </div>
            <button v-if="showSeeCom" type="button"
                class="button button-primary px-4 h-40 d-inline-flex align-items-center" @click="openComMap">See
                Com</button>
            <!-- load see com -->
            <div v-if="mapOpen" class="map-direction vue-modal">
                <div class="content">
                    <div class="left bg-white">
                        <div class="starting-point">
                            <!-- assign -->
                            <ValidationObserver ref="seeComForm">
                                <div class="mgb-32">
                                    <ValidationProvider class="group" name="Assigned to" rules="required"
                                        v-slot="{ errors }">
                                        <div :class="{ 'invalid-form' : errors[0] }">
                                            <label for="" class="d-block mb-2 dashboard-label">Assigned to<span
                                                    class="text-danger require"></span></label>
                                            <select class="dashboard-input w-100" v-model="qa.assigned_to">
                                                <option value="">Please select to assign</option>
                                                <option v-for="user in users" :key="user.id" :value="user.id">
                                                    {{ user.name }}
                                                </option>
                                            </select>
                                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                        </div>
                                    </ValidationProvider>
                                </div>
                            </ValidationObserver>
                            <!-- starting point -->
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Starting point</label>
                                <input @keyup="getStartPoint" id="starting-point" type="text"
                                    class="dashboard-input w-100 gray-border">
                            </div>
                        </div>
                        <!-- destination -->
                        <div class="destination mgt-32">
                            <p class="text-600 mgb-12">Destination</p>
                            <ul class="destination-list">
                                <li class="destination-list-item" v-for="address,index in comAddresses" :key="index">
                                    <span class="drag-dot">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="2" cy="2" r="2" fill="#7E829B" />
                                            <circle cx="2" cy="10" r="2" fill="#7E829B" />
                                            <circle cx="10" cy="2" r="2" fill="#7E829B" />
                                            <circle cx="10" cy="10" r="2" fill="#7E829B" />
                                        </svg>
                                    </span>
                                    <input type="text" :value="address.address"
                                        class="dashboard-input w-100 gray-border" readonly>
                                    <button @click="removeDestination(index,address.id)"
                                        class="button button-transparent p-0 del-icon">
                                        <span class="icon-trash fs-20"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></span>
                                    </button>
                                </li>
                                <li v-if="showDestination" class="destination-list-item">
                                    <span class="drag-dot">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="2" cy="2" r="2" fill="#7E829B" />
                                            <circle cx="2" cy="10" r="2" fill="#7E829B" />
                                            <circle cx="10" cy="2" r="2" fill="#7E829B" />
                                            <circle cx="10" cy="10" r="2" fill="#7E829B" />
                                        </svg>
                                    </span>
                                    <input @keyup="getDestination" type="text" id="destination"
                                        class="dashboard-input w-100 gray-border">
                                    <button class="button button-transparent p-0 del-icon">
                                        <span class="icon-trash fs-20"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span></span>
                                    </button>
                                </li>
                            </ul>
                            <div class="text-end">
                                <button type="button" @click="addDestination"
                                    class="button button-transparent p-0 primary-text"><span class="icon-plus"></span>
                                    Add
                                    destination</button>
                            </div>

                        </div>
                        <!-- time -->
                        <div class="destination-time-space">
                            <div class="destination-time d-flex">
                                <div class="left d-flex me-2">
                                    <div class="logo mgr-12">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.51 2.83008H8.49C6 2.83008 5.45 4.07008 5.13 5.59008L4 11.0001H20L18.87 5.59008C18.55 4.07008 18 2.83008 15.51 2.83008Z"
                                                stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M21.9907 19.82C22.1007 20.99 21.1607 22 19.9607 22H18.0807C17.0007 22 16.8507 21.54 16.6607 20.97L16.4607 20.37C16.1807 19.55 16.0007 19 14.5607 19H9.44071C8.00071 19 7.79071 19.62 7.54071 20.37L7.34071 20.97C7.15071 21.54 7.00071 22 5.92071 22H4.04071C2.84071 22 1.90071 20.99 2.01071 19.82L2.57071 13.73C2.71071 12.23 3.00071 11 5.62071 11H18.3807C21.0007 11 21.2907 12.23 21.4307 13.73L21.9907 19.82Z"
                                                stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M4 8H3" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M21 8H20" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <g opacity="0.4">
                                                <path d="M12 3V5" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10.5 5H13.5" stroke="white" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </g>
                                            <path opacity="0.4" d="M6 15H9" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path opacity="0.4" d="M15 15H18" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="">
                                        <p class="fw-bold mb-0">Via MA-24 N</p>
                                        <p class="text-gray fs-14 mb-0">60 min without traffic</p>
                                    </div>

                                </div>
                                <div class="right ms-auto">
                                    <div class="">
                                        <p class="fw-bold mb-0">62 min</p>
                                        <p class="text-gray fs-14 mb-0">100 km</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right full-map position-relative">
                        <button @click="mapOpen = false" class="button button-transparent x-btn p-0">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 13L13 1" stroke="#2F415E" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M13 13L1 1" stroke="#2F415E" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div id="map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116834.15093170418!2d90.34928581382016!3d23.78062065335469!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8b087026b81%3A0x8fa563bbdd5904c2!2sDhaka!5e0!3m2!1sen!2sbd!4v1655630336126!5m2!1sen!2sbd"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'QualityAssurance',
        props: {
            order: [],
            users: []
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
            },
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
            mapOpen: false,
            comList: false,
            startingPointName: '',
            startingPointLat: '',
            startingPointLng: '',
            showSeeCom: false,
            comAddresses: [],
            wayPoints: [],
            showDestination: false,
            canAddCom: false,
        }),
        created() {
            let order = this.order;
            let localOrderData = this.$store.getters['app/orderDetails']
            if(localOrderData){
                order = localOrderData;
            }
            this.getReportAnalysisData(order)
            this.$root.$on('wk_update', (res) => {
                localStorage.setItem('qaItem', JSON.stringify(res));
                this.getReportAnalysisData(res, true);
            });
        },
        destroyed(){
            localStorage.removeItem('qaItem');
        },
        methods: {
            initMap() {
                var directionsService = new google.maps.DirectionsService();
                var directionsRenderer = new google.maps.DirectionsRenderer({
                    draggable: true,
                    map
                });
                var chicago = new google.maps.LatLng(41.850033, -87.6500523);
                var mapOptions = {
                    zoom: 14,
                    center: chicago
                }
                var endAddress = '';
                for (var i = 0; i < this.comAddresses.length; i++) {
                    this.wayPoints.push({
                        'location': this.comAddresses[i]['address'], 'stopover': true
                    })
                    if (i == this.comAddresses.length - 1) {
                        endAddress = this.comAddresses[i]['address']
                    }
                }

                var start = this.startingPointName;
                var end = endAddress;
                var request = {
                    origin: start,
                    destination: endAddress,
                    waypoints: this.wayPoints,
                    travelMode: 'DRIVING'
                };
                var map = new google.maps.Map(document.getElementById('map'), mapOptions);
                directionsRenderer.setMap(map);
                directionsService.route(request, function (result, status) {
                    if (status == 'OK') {
                        directionsRenderer.setDirections(result);
                    }
                });
            },
            getLocation() {
                const center = { lat: 50.064192, lng: -130.605469 };
                // Create a bounding box with sides ~10km away from the center point
                const defaultBounds = {
                    north: center.lat + 0.1,
                    south: center.lat - 0.1,
                    east: center.lng + 0.1,
                    west: center.lng - 0.1,
                };
                //need to make dynamic if get time
                const comInput = document.getElementById("com-input")

                const options = {
                    bounds: defaultBounds,
                    componentRestrictions: { country: "us" },
                    fields: ["formatted_address", "geometry"],
                    strictBounds: false,
                    types: ["establishment"],
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
            getStartPoint() {
                const center = { lat: 50.064192, lng: -130.605469 };
                // Create a bounding box with sides ~10km away from the center point
                const defaultBounds = {
                    north: center.lat + 0.1,
                    south: center.lat - 0.1,
                    east: center.lng + 0.1,
                    west: center.lng - 0.1,
                };
                const startingPoint = document.getElementById("starting-point")
                const options = {
                    bounds: defaultBounds,
                    componentRestrictions: { country: "us" },
                    fields: ["formatted_address", "geometry"],
                    strictBounds: false,
                    types: ["establishment"],
                };
                const autocomplete = new google.maps.places.Autocomplete(startingPoint, options);
                let self = this;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace()
                    if (startingPoint.value.length > 0) {
                        setTimeout(() => {
                            self.startingPointName = place.formatted_address
                            self.startingPointLat = place.geometry.location.lat()
                            self.startingPointLng = place.geometry.location.lng()
                            self.initMap()
                        }, 1000)
                    } else {
                        return false
                    }
                }.bind(this))
            },
            getDestination() {
                const center = { lat: 50.064192, lng: -130.605469 };
                // Create a bounding box with sides ~10km away from the center point
                const defaultBounds = {
                    north: center.lat + 0.1,
                    south: center.lat - 0.1,
                    east: center.lng + 0.1,
                    west: center.lng - 0.1,
                };
                const destination = document.getElementById("destination")
                const options = {
                    bounds: defaultBounds,
                    componentRestrictions: { country: "us" },
                    fields: ["formatted_address", "geometry"],
                    strictBounds: false,
                    types: ["establishment"],
                };
                const autocomplete = new google.maps.places.Autocomplete(destination, options);
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace()
                    var destinationObject = {
                        "order_id": this.orderData.id,
                        "address": place.formatted_address,
                        "lat": place.geometry.location.lat(),
                        "lng": place.geometry.location.lng()
                    }
                    if (place.formatted_address != '') {
                        this.$boston.post('add-com', destinationObject)
                            .then(res => {
                                this.orderData = res.data
                                document.getElementById("destination").value = '';
                                this.showDestination = false;
                                this.initMap()
                                this.$root.$emit('wk_update', this.orderData)
                                this.$root.$emit('wk_flow_toast', res);
                            })
                            .catch(err => {
                                console.log(err)
                            })
                    }
                }.bind(this))
            },
            addLocation() {
                if (this.placeName.length > 0) {
                    this.addresses.push({ 'address': this.placeName, 'lat': this.placeLat, 'lng': this.placeLng })
                    document.getElementById("com-input").value = ''
                }
                return false
            },
            removeAddress(index) {
                this.addresses.splice(index, 1)
            },
            removeDestination(index, id) {
                this.$boston.post('delete-com/' + id)
                    .then(res => {
                        this.orderData = res.data
                        this.$root.$emit('wk_update', res.data)
                        this.$root.$emit('wk_flow_toast', res);
                    })
                    .catch(err => {
                        console.error(err)
                    })
            },
            addDestination() {
                this.showDestination = true
            },
            saveCom() {
                this.$boston.post('save-com/' + this.orderData.id, this.addresses)
                    .then(res => {
                        let self = this
                        this.orderData = res.data
                        this.alreadyHaveComList = false
                        this.comAddresses = this.orderData.comlist
                        this.$root.$emit('wk_update', this.orderData)
                        this.$root.$emit('wk_flow_menu', this.orderData)
                        this.$root.$emit('wk_flow_toast', res);
                        this.showSeeCom = true
                        setTimeout(() => {
                            self.comList = false
                        }, 1000);
                    })
                    .catch(err => {
                        console.log(err)
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
                    this.rewrite_note = this.orderData.analysis.rewrite_note;
                    this.analysisnote = this.orderData.analysis.note;
                }

                this.comAddresses = this.orderData.comlist
                this.qa.order_id = this.orderData.id
                this.qa.effective_date = this.orderData.due_date
                if (this.comAddresses.length && this.orderData.comlist[0].id != undefined) {
                    this.showSeeCom = true
                }

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
                                console.log(err)
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
            openComMap() {
                this.mapOpen = true
                let self = this
            },
            updateQualityAssurance() {
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
                            this.$root.$emit('wk_update', this.orderData)
                            this.$root.$emit('wk_flow_menu', this.orderData)
                            this.$root.$emit('wk_flow_toast', res);
                            this.getReportAnalysisData(res.data);
                            this.currentStep = 'step3'
                        }).catch(err => {
                            console.log(err)
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
