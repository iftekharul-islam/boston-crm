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
                <div class="d-flex align-items-center" v-for="file, indexKey in analysis.attachments" :key="indexKey">
                    <div class="file-img">
                        <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                            class="img-fluid">
                        <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                            class="img-fluid">
                        <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                    </div>
                    <div class="mgl-12 document">
                        <a :href="file.original_url" target="_blank" download class="text-light-black mb-0 file-name">{{
                            file.name }}</a>
                        <p class="text-gray mb-0 fs-12 ">Uploaded: {{ analysis.updated_by.name + ', ' +
                            analysis.updated_at }}</p>
                    </div>
                </div>
            </div>
            <!-- <div>{{ calculateEffectiveDate() }}</div> -->
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
                <p class="mb-0 text-light-black fw-bold">{{ rewrite_note }}</p>
            </div>
            <div class="group">
                <p class="text-success">(Check & Upload)</p>
                <p class="mb-0 text-light-black fw-bold">{{ analysisnote }}</p>
            </div>
            <div class="group" v-if="analysis">
                <p class="text-light-black mgb-12">Files</p>
                <div class="d-flex align-items-center" v-for="file, indexKey in analysis.attachments" :key="indexKey">
                    <div class="file-img">
                        <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                            class="img-fluid">
                        <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                            class="img-fluid">
                        <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                    </div>
                    <div class="mgl-12 document">
                        <a :href="file.original_url" target="_blank" download class="text-light-black mb-0 file-name">{{
                            file.name }}</a>
                        <p class="text-gray mb-0 fs-12">Uploaded: {{ analysis.updated_by.name + ', ' +
                            analysis.updated_at }}</p>
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
                    <ValidationProvider class="group" name="Quality Assurance Note" rules="required"
                        v-slot="{ errors }">
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
                <div class="d-flex align-items-center" v-for="file, indexKey in orderData.analysis.attachments"
                    :key="indexKey">
                    <div class="file-img">
                        <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                            class="img-fluid">
                        <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                            class="img-fluid">
                        <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                    </div>
                    <div class="mgl-12 document">
                        <a :href="file.original_url" target="_blank" download class="text-light-black mb-0 file-name">{{
                            file.name }}</a>
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
            <div class="group" v-if="orderData.quality_assurance">
                <p class="text-light-black mgb-12">Quality assurance files</p>
                <div class="d-flex align-items-center" v-for="file, indexKey in orderData.quality_assurance.attachments"
                    :key="indexKey">
                    <div class="file-img">
                        <img v-if="file.mime_type == 'image/jpeg'" src="/img/image.svg" alt="boston files"
                            class="img-fluid">
                        <img v-else-if="file.mime_type == 'application/pdf'" src="/img/pdf.svg" alt="boston files"
                            class="img-fluid">
                        <img v-else src="/img/common.svg" alt="boston files" class="img-fluid">
                    </div>
                    <div class="mgl-12 document">
                        <a :href="file.original_url" target="_blank" download class="text-light-black mb-0 file-name">{{
                            file.name }}</a>
                        <p class="text-gray mb-0 fs-12">Uploaded: {{ orderData.quality_assurance.updated_by.name + ', '
                            +
                            orderData.quality_assurance.updated_at }}</p>
                    </div>
                </div>
            </div>
            <button v-if="showSeeCom" type="button"
                class="button button-primary px-4 h-40 d-inline-flex align-items-center mt-4" @click="openSeeCom">See
                com</button>
            <!-- load see com -->
            <div v-if="mapOpen"></div>
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
            mapOpen: false,
            comList: false,
            showSeeCom: false,
            comAddresses: [],
            comId: 0,
            wayPoints: [],
            canAddCom: false,
            summary: 'No Route Found',
            totalDistance: 0,
            totalTime: 0,
            startAddress: '',
            isStartAddress: false,
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
            calculateEffectiveDate() {
                var boston = new google.maps.LatLng(42.3145186, -71.1103703);
                var property = new google.maps.LatLng(43.0567336, -70.8455425);
                var heading = google.maps.geometry.spherical.computeHeading(boston, property);
                console.log(heading)
                return (heading > -71.14897993051316 || heading > 39.592128988706385) ? "South of Boston" : "North of Boston"
            },
            handleChange() {
                // nothing to do here
            },
            saveMapOrganize() {
                this.$nextTick(() => {
                    this.initMap();
                })
            },
            saveMapData() {
                if (!this.qa.assigned_to) {
                    this.$toast.open({
                        message: "Please assign someone",
                        type: 'error',
                    });
                } else {
                    this.$boston.post('save-com-route/' + this.orderData.id + '/' + this.comId + '/' + this.qa.assigned_to, this.comAddresses)
                        .then(res => {
                            this.orderData = res.data
                            this.comAddresses = JSON.parse(this.orderData.comlist.destination)
                            this.$root.$emit('wk_update', this.orderData)
                            this.$root.$emit('wk_flow_menu', this.orderData)
                            this.$root.$emit('wk_flow_toast', res);
                            this.getReportAnalysisData(res.data);
                            this.mapOpen = false
                        })
                        .catch(err => {
                            console.error(err)
                        })
                }
            },
            getComponentData() {
                return {
                    on: {
                        change: this.handleChange,
                    },
                }
            },
            openSeeCom() {
                this.mapOpen = true;
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

                //this.$nextTick(() => {
                //    this.initMap();
                //})
            },
            initMap() {

                var endAddress = ''
                var startAddress = ''

                var directionsService = new google.maps.DirectionsService();
                var directionsRenderer = new google.maps.DirectionsRenderer({ 'draggable': true });

                let getStartingLatLng = this.comAddresses[0];
                startAddress = getStartingLatLng['address']
                var firstLatLng = new google.maps.LatLng(getStartingLatLng.lat, getStartingLatLng.lng);
                var mapOptions = {
                    zoom: 14,
                    center: firstLatLng,
                    gestureHandling: 'greedy'
                }

                this.wayPoints = [];
                for (var i = 1; i < this.comAddresses.length; i++) {
                    if (i != this.comAddresses.length - 1)
                        this.wayPoints.push({
                            'location': this.comAddresses[i]['address'], 'stopover': true
                        })

                    if (i == this.comAddresses.length - 1) {
                        endAddress = this.comAddresses[i]['address']
                    }
                }
                var start = startAddress;
                var end = endAddress;
                this.startingPointValue = start;

                var request = {
                    origin: start,
                    destination: end,
                    waypoints: this.wayPoints,
                    travelMode: "DRIVING"
                };
                const map = new google.maps.Map(document.getElementById('map'), mapOptions);
                directionsRenderer.setMap(map);
                var bounds = '';
                directionsService.route(request, function (result, status) {
                    if (status == 'OK') {
                        directionsRenderer.setDirections(result)
                        bounds = result.routes[0].bounds;
                        map.fitBounds(bounds);
                        var totalTime = 0;
                        var totalDistance = 0;
                        this.summary = result.routes[0].summary
                        for (var i = 0; i < result.routes[0].legs.length; i++) {
                            totalTime += result.routes[0].legs[i].duration['value']
                            totalDistance += result.routes[0].legs[i].distance['value']
                        }
                        this.totalTime = parseInt(totalTime / 60);
                        this.totalDistance = parseFloat(totalDistance / 1609.34).toFixed(2);
                    }
                }.bind(this));
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
            getStartPoint() {
                const center = { lat: 42.361145, lng: -71.057083 };
                // const startingPoint = document.getElementById("starting-point")
                const startingPoint = this.$refs.startingPoint;
                const options = {
                    componentRestrictions: { country: "us" },
                    fields: ["address_components", "formatted_address", "geometry"],
                    strictBounds: false,
                    types: ["address"],
                };
                const autocomplete = new google.maps.places.Autocomplete(startingPoint, options);
                let self = this;
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace()
                    if (this.startingPointValue.length > 0) {
                        this.startAddress = { 'address': place.formatted_address, 'lat': place.geometry.location.lat(), 'lng': place.geometry.location.lng() }
                        this.comAddresses.unshift(this.startAddress)
                        this.initMap()
                        this.isStartAddress = true
                    } else {
                        return false
                    }
                }.bind(this))
            },
            getDestination() {
                const center = { lat: 42.361145, lng: -71.057083 };

                const destination = document.getElementById("destination")

                const options = {
                    componentRestrictions: { country: "us" },
                    fields: ["formatted_address", "geometry"],
                    strictBounds: false,
                    types: ["address"],
                };
                const autocomplete = new google.maps.places.Autocomplete(destination, options);
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace()
                    var destinationObject = {
                        "address": place.formatted_address,
                        "lat": place.geometry.location.lat(),
                        "lng": place.geometry.location.lng()
                    }
                    this.comAddresses.push(destinationObject)
                    destination.value = ''
                    this.initMap()
                }.bind(this))
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
            removeDestination(index) {
                if (index == 0) {
                    return false
                }
                this.comAddresses.splice(index, 1)
                this.initMap()
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
