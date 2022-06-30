<template>
    <div>
        <ValidationObserver ref="orderForm">
            <div class="row mgb-32">
                <div class="col-md-8 ">
                    <div class="map" ref="map" style="height: 0"></div>
                    <div class="form-box h-100">
                        <h4 class="box-header mb-3">Appraisal details</h4>
                        <div class="d-flex justify-content-between w-100 box-flex">
                            <div class="left max-w-424 w-100 me-3">

                                <ValidationProvider class="group" name="Order no" rules="required" v-slot="{ errors }">
                                    <div :class="{ 'invalid-form' : errors[0] || oldOrderNo.find }">
                                        <label for="" class="d-block mb-2 dashboard-label">Client order no <span
                                                class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100" @input="checkclientOrderNo($event)" v-model="step1.clientOrderNo">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                        <span v-if="oldOrderNo.find" class="error-message" v-html="oldOrderNo.message"></span>
                                    </div>
                                </ValidationProvider>

                                <div class="group mb-3">
                                    <label for="" class="d-block mb-2 dashboard-label">Loan no</label>
                                    <input type="text" class="dashboard-input w-100" v-model="step1.loanNo">
                                </div>


                                <ValidationProvider class="group" name="Received date" rules="required"
                                    v-slot="{ errors }">
                                    <div :class="{ 'invalid-form' : (errors[0] || dateIssue.status) }">
                                        <label for="" class="d-block mb-2 dashboard-label">Received date <span
                                                class="text-danger require"></span></label>
                                        <div class="position-relative">
                                            <input type="date" class="dashboard-input w-100"
                                                @input="checkDateInput($event.target.value, 1)"
                                                v-model="step1.receiveDate">
                                            <span class="icon-calendar icon"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span><span
                                                    class="path6"></span><span class="path7"></span><span
                                                    class="path8"></span></span>
                                        </div>
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                        <span v-if="dateIssue.status" class="error-message">{{ dateIssue.message
                                            }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="Due date" rules="required" v-slot="{ errors }">
                                    <div :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Due date <span
                                                class="text-danger require"></span></label>
                                        <div class="position-relative">
                                            <input type="date" class="dashboard-input w-100"
                                                @input="checkDateInput($event.target.value, 2)" v-model="step1.dueDate">
                                            <span class="icon-calendar icon"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span><span
                                                    class="path6"></span><span class="path7"></span><span
                                                    class="path8"></span></span>
                                        </div>
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                            </div>
                            <div class="right max-w-424 w-100">

                                <span class="group">
                                    <label for="" class="d-block mb-2 dashboard-label">System order </label>
                                    <input type="text" class="dashboard-input w-100" v-model="step1.systemOrder"
                                        readonly>
                                </span>

                                <ValidationProvider class="group" name="Loan type" rules="required" v-slot="{ errors }">
                                    <div class="position-relative" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Loan type </label>
                                        <select name="" id="loanTypeSelect"
                                            class="dashboard-input w-100 loan-type-select" v-model="step1.loanType">
                                            <option value="">Please Select Loan Type</option>
                                            <option v-for="loan_type in loanTypes" :key="loan_type.id"
                                                :value="loan_type.id" :data-fha="loan_type.is_fha">
                                                {{ loan_type.name }}
                                            </option>
                                        </select>
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="FHA case no" :rules="{ required: this.fhaExists == 1 }"
                                    v-slot="{ errors }">
                                    <div :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">FHA case no <span
                                                class="text-danger require" v-if="fhaExists == 1"></span></label>
                                        <input type="text" class="dashboard-input w-100" v-model="step1.fhaCaseNo">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="Appraiser name" rules="required"
                                    v-slot="{ errors }">
                                    <div class="position-relative" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Appraiser name <span
                                                class="text-danger require"></span></label>
                                        <select id="apprClientSelect" class="dashboard-input w-100"
                                            v-model="step1.appraiserName">
                                            <option value="">Please select appraisal user name</option>
                                            <option v-for="appraisal_user in appraisalUsers" :key="appraisal_user.id"
                                                :value="appraisal_user.id">
                                                {{ appraisal_user.name }}
                                            </option>
                                        </select>
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                                <ValidationProvider class="group" name="Property type" rules="required"
                                    v-slot="{ errors }">
                                    <div class="position-relative" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Property Type <span
                                                class="text-danger require"></span></label>
                                        <select id="propertyTypeSelect" class="dashboard-input w-100"
                                            v-model="step1.propertyType">
                                            <option value="">Please select property type</option>
                                            <option v-for="propertyType in propertyTypes" :key="propertyType.id"
                                                :value="propertyType.id">
                                                {{ propertyType.type }}
                                            </option>
                                        </select>
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-box h-100 d-flex flex-column">
                        <div>
                            <h4 class="box-header mb-3">Provided services</h4>
                            <div class="row">
                                <div class="provided-service-data row mgb-20" v-if="providerTypes.extra.length > 0">
                                    <!-- label -->
                                    <div class="col-6">
                                        <label for="" class="d-block mb-2 dashboard-label"><strong>Appraiser
                                                type</strong> </label>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="d-block mb-2 dashboard-label"><strong>Fee</strong> </label>
                                    </div>
                                    <!-- after added -->
                                    <div class="row" v-for="providerType, pi in providerTypes.extra" :key="pi">
                                        <div class="col-6">
                                            <p class="mb-0 ">{{ providerType.type }}</p>
                                        </div>
                                        <div class="col-6 d-flex justify-content-between">
                                            <p class="pdl-10 mb-0 fw-bold">{{ providerType.fee }}</p>
                                            <button class="button button-transparent p-2"
                                                @click="remoteProviderType(providerType, pi)">
                                                <span class="icon-trash"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span><span
                                                        class="path4"></span></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- input box and new add -->
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="group" :class="{ 'invalid-form': providerTypes.error.type == true }">
                                                <label for="" class="d-block mb-2 dashboard-label">Appraiser
                                                    type </label>
                                                <div class="position-relative borderless-select">
                                                    <select id="providerTypeFee" class="dashboard-input w-100"
                                                        v-model="providerTypes.default.type">
                                                        <option value="">Choose Provided Service</option>
                                                        <option :value="item.id"
                                                            :data-full="item.is_full_appraisal" :key="ki"
                                                            v-for="item, ki in appraisalTypes">{{ item.form_type
                                                            }}</option>
                                                    </select>
                                                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group" :class="{ 'invalid-form': providerTypes.error.fee == true }">
                                                <label for="" class="d-block mb-2 dashboard-label">Fee </label>
                                                <input @input="checkProviderValidation($event, 2)" type="number"
                                                    step="any" class="dashboard-input w-100" v-model="providerTypes.default.fee" @blur="addFee">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 text-end mt-3">
                                    <button class="add-more" @click="addFee">
                                        <span class="icon-plus"></span> Add
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="mt-auto">
                            <div class="group">
                                <label for="" class="d-block mb-2 dashboard-label">Note</label>
                                <textarea name="" id="" rows="7" class="dashboard-textarea w-100"
                                    v-model="step1.note"></textarea>
                            </div>
                            <h3 class="text-light-black fw-bold mgt-40">Total fee : <span> $ {{
                                    providerTypes.totalAmount }} </span></h3>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-box h-100 box-flex">
                        <h4 class="box-header mb-3">Client info</h4>

                        <ValidationProvider class="group" name="AMC name" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">AMC name <span
                                        class="text-danger require"></span></label>
                                <div class="position-relative">
                                    <select id="amcClientSelect" class="dashboard-input w-100 select2"
                                        v-model="step1.amcClient">
                                        <option value="">Choose Amc Client</option>
                                        <option :value="item.id" :key="ik" v-for="item, ik in amcClients"
                                            :data-uad="item.fee_for_1004uad" :data-d="item.fee_for_1004d"
                                            :data-processing="item.processing_fee">{{ item.name
                                            }}</option>
                                    </select>
                                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                                </div>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>

                        <ValidationProvider class="group" name="Technology fee"
                            :rules=" { required: (step1.amcClient == '') ? false : true}" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Technology fee <span
                                        class="text-danger require"></span></label>
                                <input readonly type="text" class="dashboard-input w-100" v-model="step1.technologyFee">
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>

                        <ValidationProvider class="group" name="Lender" rules="required" v-slot="{ errors }">
                            <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                <label for="" class="d-block mb-2 dashboard-label">Lender <span
                                        class="text-danger require"></span></label>
                                <div class="position-relative">
                                    <select id="lenderClientSelect" class="dashboard-input w-100"
                                        v-model="step1.lender">
                                        <option value="">Choose Lender</option>
                                        <option :value="item.id" :key="ik" v-for="item, ik in lenderClients"
                                            :data-uad="item.fee_for_1004uad" :data-d="item.fee_for_1004d"
                                            :data-processing="item.processing_fee">{{
                                            item.name }}</option>
                                    </select>
                                    <span class="icon-arrow-down bottom-arrow-icon"></span>
                                </div>
                                <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                            </div>
                        </ValidationProvider>
                    </div>
                </div>
                <div class="col-md-8 ">
                    <div class="form-box">
                        <h4 class="box-header mb-3">Property info</h4>
                        <div class="d-flex justify-content-between w-100 box-flex">
                            <div class="left max-w-424 w-100 mb-3">

                                <div class="group mb-3">
                                    <label for="" class="d-block mb-2 dashboard-label">Search address <span
                                            class="text-danger require"></span></label>
                                    <input type="text" v-model="searchIngAddress" ref="searchMapLocation"
                                        class="dashboard-input w-100">
                                </div>

                                <ValidationProvider class="group" name="Address name" rules="required"
                                    v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Address Name <span
                                                class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100" v-model="step1.searchAddress">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="State name" rules="required"
                                    v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">State name <span
                                                class="text-danger require"></span>
                                        </label>
                                        <input type="text" class="dashboard-input w-100" v-model="step1.state">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>



                                <ValidationProvider class="group" name="City name" rules="required" v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label label for="" class="d-block mb-2 dashboard-label">Area/City name <span
                                                class="text-danger require"></span></label>
                                        <input type="text" class="dashboard-input w-100" v-model="step1.city">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="Unit No"
                                    :rules="{'required' : condoType == true}" v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Unit No <span
                                                class="text-danger require"></span>
                                        </label>
                                        <input type="text" class="dashboard-input w-100" v-model="step1.unitNo">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                            </div>

                            <div class="right max-w-424 w-100">
                                <ValidationProvider class="group" name="Street name" rules="required"
                                    v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Street name <span
                                                class="text-danger require"></span>
                                        </label>
                                        <input type="text" @input="changeStreetAddress($event.target.value)"
                                            class="dashboard-input w-100" v-model="step1.street">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="Zip code" rules="required|integer"
                                    v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Zipcode <span
                                                class="text-danger require"></span>
                                        </label>
                                        <input type="number" class="dashboard-input w-100" v-model="step1.zipcode">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="Latitude" rules="required" v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Latitude <span
                                                class="text-danger require"></span>
                                        </label>
                                        <input type="text" class="dashboard-input w-100" v-model="step1.lat">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="Longitude" rules="required" v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Longitude <span
                                                class="text-danger require"></span>
                                        </label>
                                        <input type="text" class="dashboard-input w-100" v-model="step1.lng">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider class="group" name="County" rules="required" v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Country <span
                                                class="text-danger require"></span>
                                        </label>
                                        <input type="text" readonly class="dashboard-input w-100" v-model="step1.country">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-client__bottom d-flex justify-content-end p-3 mgt-32">
                <button class="button button-primary" @click="nextStep">
                    Next
                    <svg class="ms-4" width="20" height="14" viewBox="0 0 20 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.4291 13.82C12.2391 13.82 12.0491 13.75 11.8991 13.6C11.6091 13.31 11.6091 12.83 11.8991 12.54L17.4391 7L11.8991 1.46C11.6091 1.17 11.6091 0.689995 11.8991 0.399995C12.1891 0.109995 12.6691 0.109995 12.9591 0.399995L19.0291 6.47C19.3191 6.76 19.3191 7.24 19.0291 7.52999L12.9591 13.6C12.8091 13.75 12.6191 13.82 12.4291 13.82Z"
                            fill="white" />
                        <path
                            d="M18.33 7.75H1.5C1.09 7.75 0.75 7.41 0.75 7C0.75 6.59 1.09 6.25 1.5 6.25H18.33C18.74 6.25 19.08 6.59 19.08 7C19.08 7.41 18.74 7.75 18.33 7.75Z"
                            fill="white" />
                    </svg>
                </button>
            </div>
        </ValidationObserver>

        <street-address v-if="showStreetAddress" :data="streetAddress">
            <template v-slot:close>
                <span @click="showStreetAddress = false">X</span>
            </template>
        </street-address>

    </div>
</template>

<script>
    import StreetAddress from "./StreetAddress";
    export default {
        name: "Step1",
        components: {
            StreetAddress
        },
        props: {
            order: [],
            systemOrderNo: String,
            orderListUrl: String,
            appraisalUsers: [],
            appraisalTypes: [],
            loanTypes: [],
            type: null,
            amcClients: [],
            lenderClients: [],
            propertyTypes:[]
        },
        data() {
            return {
                oldOrderNo: {
                    find: false, 
                    message: null
                },
                fhaExists: 0,
                showStreetAddress: false,
                streetAddress: [],
                dateIssue: {
                    status: false,
                    message: "Received Date Must Be Smaller Than Due Date"
                },
                invalidPhone1: null,
                invalidPhone2: null,
                submitAction: false,
                stepActive: false,
                proviedServicePass: false,
                step1: {
                    unitNo: '',
                    clientOrderNo: '',
                    systemOrder: '',
                    loanNo: '',
                    loanType: '',
                    receiveDate: '',
                    technologyFee: 0,
                    fhaCaseNo: '',
                    propertyType:'',
                    appraiserName: null,
                    dueDate: '',
                    appraiserType: '',
                    amcClient: '',
                    lender: '',
                    fee: [],
                    note: '',
                    searchAddress: '',
                    formatedAddress: '',
                    state: '',
                    city: '',
                    street: null,
                    zipcode: null,
                    country: null,
                    lat: null,
                    lng: null,
                },
                searchIngAddress: null,
                //All Msg Property
                clientOrderErrorMsg: '',
                fahCaseNoErrorMsg: '',
                condoType: false,
                providerTypes: {
                    default: {
                        type: null,
                        fee: null,
                    },
                    error: {
                        type: false,
                        fee: false
                    },
                    extra: [],
                    totalAmount: 0
                },
                mapData: {
                    address: null,
                    map: null,
                    center: { lat: -25.308, lng: 133.036 },
                    currentPlace: null,
                    markerIcon: "",
                    data: [],
                },
                isFullAppraisal: 0
            }
        },
        created() {
            this.step1.systemOrder = this.systemOrderNo;

            if (this.type == 2) {
                this.setOrderValue();
            }

            this.$root.$on('orderSubmitConfirm', (status) => {
                this.removeDataValue();
            });
        },
        mounted() {
            this.geolocate();
            $('select').select2();
            this.select2Features();
        },
        methods: {
            updateLoanType(event){
                this.step1.loanType = null
            },
            select2Features() {
                $(document).on("change", "#providerTypeFee", function (e) {
                    let value = e.target.value;
                    this.providerTypes.default.type = value;
                    this.checkProviderValidation(e, 1);
                    this.isFullAppraisal = e.target.selectedOptions[0].dataset.full
                }.bind(this));
                 $("#propertyTypeSelect").on("select2:select", function (e) {
                    let value = e.target.value;
                    this.step1.propertyType = value;
                }.bind(this));

                $("#loanTypeSelect").on("select2:select", function (e) {
                    let value = e.target.value;
                    this.step1.loanType = value;
                    this.fhaExists = e.target.selectedOptions[0].dataset.fha
                }.bind(this));

                $(document).on("change", "#amcClientSelect", function (e) {
                    let changeLender = false;
                    let id = e.target.value;
                    this.step1.amcClient = id;
                    let findObject = this.amcClients.find(ele => ele.id == id);
                    if (findObject && findObject.client_type == "both") {
                        this.step1.lender = id;
                        changeLender = true;
                    } else {
                        let checkAmcId = this.lenderClients.find(ele => ele.id == this.step1.lender);
                        if (checkAmcId && checkAmcId.client_type == "both") {
                            this.step1.lender = null;
                            changeLender = true;
                        }
                    }
                    if (changeLender) {
                        $("#lenderClientSelect").val(this.step1.lender).trigger('change');
                    }
                    this.calculateTechnologyFee(e)

                }.bind(this));

                $("#lenderClientSelect").on("select2:select", function (e) {
                    var data = e.params.data;
                    let id = data.id;
                    this.step1.lender = id;
                    let changeLender = false;
                    let findObject = this.lenderClients.find(ele => ele.id == id);
                    if (findObject && findObject.client_type == "both") {
                        this.step1.amcClient = id;
                        changeLender = true;
                        this.calculateTechnologyFee(e)
                    } else {
                        let checkAmcId = this.amcClients.find(ele => ele.id == this.step1.amcClient);
                        if (checkAmcId && checkAmcId.client_type == "both") {
                            this.step1.amcClient = null;
                            changeLender = true;
                            this.calculateTechnologyFee(e)
                        }
                    }
                    if (changeLender) {
                        $("#amcClientSelect").val(this.step1.amcClient).trigger('change');
                    }
                }.bind(this));

                $(document).on("change", "#apprClientSelect", function (e) {
                    let value = e.target.value;
                    this.step1.appraiserName = value;
                }.bind(this));
            },
            stepChangeActive() {
                this.$emit('step-change-active', {
                    status: this.stepActive,
                    data: this.step1
                });
            },

            nextStep() {
                this.$refs.orderForm.validate().then((status) => {
                    if (status && this.providerTypes.extra.length && !this.dateIssue.status) {
                        this.stepActive = true;
                        this.stepChangeActive();
                    } else {
                        $("html, body").animate({ scrollTop: 0 }, 300);
                    }
                });
            },

            validateData() {
                let errorCount = 0;
                if (this.clientOrderNo.length === 0) {
                    errorCount++;
                    this.clientOrderErrorMsg = 'Client Order No Required';
                }
                return !errorCount >= 0;
            },
            resetAllErrorMsg() {
                this.clientOrderErrorMsg = '';
                this.fahCaseNoErrorMsg = '';
            },
            addFee() {
                let newType = this.providerTypes.default.type;
                let newFee = this.providerTypes.default.fee;
                this.providerTypes.error.type = false;
                this.providerTypes.error.fee = false;
                if (newType == null) {
                    this.providerTypes.error.type = true;
                } 
                if (newFee == null) {
                    this.providerTypes.error.fee = true;
                } 
                
                if (newType && newFee) {
                    this.setNewFee(newType, newFee);
                }
            },

            setNewFee(newType, newFee) {
                let appType = newType;
                if (newType.id) {
                    appType = newType;
                } else {
                    for (let i in this.appraisalTypes) {
                        let appritem = this.appraisalTypes[i];
                        if (appritem.id == newType) {
                            appType = appritem;
                        }
                    }
                }

                if (appType.condo_type == 1) {
                    this.condoType = true;
                }
                let checkOld = (this.providerTypes.extra).find((ele) => ele.typeId == appType.id);
                if (!checkOld && appType.id) {
                    this.providerTypes.extra.push({
                        typeId: appType.id,
                        type: appType.form_type,
                        fee: newFee
                    });
                }
                
                this.providerTypes.default.type = null;
                this.providerTypes.default.fee = null;
                this.providerTypes.error.type = false;
                this.providerTypes.error.fee = false;

                $("#providerTypeFee").val(this.providerTypes.default.type).trigger('change');
                this.checkProviderBalance();
                this.$root.$emit("updateProviderData", this.providerTypes);
            },

            checkProviderBalance() {
                let totalfee = 0;
                let checkCondoType = false;
                this.providerTypes.extra.map((ele) => {
                    totalfee += parseFloat(ele.fee);
                    let checkCondo = Object.values(this.appraisalTypes).find(eles => eles.id == ele.typeId);
                    if (checkCondo && checkCondo.condo_type == 1) {
                        checkCondoType = true;
                    }
                });
                this.providerTypes.totalAmount = totalfee;
                this.condoType = checkCondoType;

                if (this.providerTypes.extra.length <= 0) {
                    this.providerTypes.error.type = true;
                    this.providerTypes.error.fee = true;
                }
            },

            checkProviderValidation(event, type) {
                if (type == 2 && this.providerTypes.default.type != null) {
                    this.providerTypes.error.type = false;
                }
                if (type == 1 && this.providerTypes.default.fee != null) {
                    this.providerTypes.error.fee = false;
                }
            },
            //technologyFee caculation
            calculateTechnologyFee(e) {
                let uad = e.target.selectedOptions[0].dataset.uad
                let d = e.target.selectedOptions[0].dataset.d
                let processingFee = e.target.selectedOptions[0].dataset.processing
                this.isFullAppraisal == 1 ? this.step1.technologyFee = uad : this.step1.technologyFee = d
                if (processingFee != '' && processingFee > 0) {
                    let technologyFee = parseFloat(parseFloat(this.step1.technologyFee) + parseFloat(this.providerTypes.totalAmount * (processingFee / 100)))
                    this.step1.technologyFee = technologyFee
                }
            },
            remoteProviderType(item, index) {
                this.providerTypes.extra.splice(index, 1);
                if (this.providerTypes.extra.length == 0) {
                    this.providerTypes.totalAmount = 0;
                    this.condoType = false;
                } else {
                    this.checkProviderBalance();
                }
            },
            removeDataValue() {
                let newData = [];
                for (let i in this.step1) {
                    if (i == "technologyFee") {
                        newData[i] = 10;
                    } else if (i == "fee") {
                        newData[i] = [];
                    } else {
                        newData[i] = null;
                    }
                }
                this.step1 = newData;
                this.providerTypes.extra = [];
                this.providerTypes.totalAmount = 0;
                this.$refs.orderForm.reset();
            },
            setOrderValue() {
                let receivedDate = this.formateDate(this.order.received_date);
                let dueDate = this.formateDate(this.order.due_date);
                let step1 = {
                    clientOrderNo: this.order.client_order_no,
                    unitNo: this.order.property_info.unit_no,
                    systemOrder: this.order.system_order_no,
                    loanNo: this.order.appraisal_detail.loan_no,
                    loanType: this.order.appraisal_detail.loan_type,
                    receiveDate: receivedDate,
                    dueDate: dueDate,
                    technologyFee: this.order.appraisal_detail.technology_fee,
                    fhaCaseNo: this.order.appraisal_detail.fha_case_no,
                    propertyType: this.order.appraisal_detail.property_type,
                    appraiserName: this.order.appraisal_detail.appraiser_id,
                    appraiserType: '',
                    amcClient: this.order.amc.id,
                    lender: this.order.lender.id,
                    note: this.order.provider_service.note,
                    searchAddress: this.order.property_info.search_address,
                    state: this.order.property_info.state_name,
                    city: this.order.property_info.city_name,
                    street: this.order.property_info.street_name,
                    formatedAddress: this.order.property_info.formatedAddress,
                    zipcode: this.order.property_info.zip,
                    country: this.order.property_info.country,
                    lat: this.order.property_info.latitude,
                    lng: this.order.property_info.longitude,
                };

                this.step1 = step1;
                let setFee = JSON.parse(this.order.provider_service.appraiser_type_fee);
                for (let i in setFee) {
                    let ele = setFee[i];
                    this.setNewFee(ele.typeId, ele.fee);
                }

                this.searchIngAddress = this.order.property_info.formatedAddress;

                let receivedDateFormated = new Date(receivedDate);
                let dueDateFormated = new Date(dueDate);
                if (receivedDateFormated > dueDateFormated) {
                    this.dateIssue.status = true;
                }

            },

            geolocate() {
                this.mapData.markerIcon = this.$boston.host('img/marker.png');
                this.mapData.map = new window.google.maps.Map(this.$refs['map'], {
                    center: this.center,
                    zoom: 7,
                    gestureHandling: 'greedy'
                });
                new window.google.maps.Marker({
                    position: this.center,
                    map: this.map,
                    icon: this.markerIcon
                });

                const input = this.$refs.searchMapLocation;
                const searchBox = new window.google.maps.places.SearchBox(input);
                this.mapData.map.controls[window.google.maps.ControlPosition.TOP_LEFT].push(input);
                this.mapData.map.addListener("bounds_changed", () => {
                    searchBox.setBounds(this.mapData.map.getBounds());
                });

                searchBox.addListener("places_changed", () => {
                    const places = searchBox.getPlaces();
                    if (places.length == 0) {
                        return;
                    }


                    // For each place, get the icon, name and location.
                    const bounds = new window.google.maps.LatLngBounds();
                    let markers = [];

                    places.forEach((place) => {
                        if (!place.geometry || !place.geometry.location) {
                            console.error("Returned place contains no geometry");
                            return;
                        }

                        const icon = {
                            url: place.icon,
                            size: new window.google.maps.Size(71, 71),
                            origin: new window.google.maps.Point(0, 0),
                            anchor: new window.google.maps.Point(17, 34),
                            scaledSize: new window.google.maps.Size(25, 25),
                        };

                        // Create a marker for each place.
                        markers.push(
                            new window.google.maps.Marker({
                                map: this.mapData.map,
                                icon: this.mapData.markerIcon,
                                title: place.name,
                                position: place.geometry.location,
                            })
                        );

                        if (place.geometry.viewport) {
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                        let addressData = {
                            postal_code: null,
                            country: null,
                            name: null,
                            street: null,
                            city: null,
                            location: null,
                            lat: null,
                            lon: null,
                            state: null,
                            place_id: null,
                        };
                        addressData.place_id = place.place_id;

                        for (var i = 0; i < place.address_components.length; i++) {
                            if (place.address_components[i].types[0] == 'postal_code') {
                                addressData.postal_code = place.address_components[i].long_name;
                            }
                            // if (place.address_components[i].types[0] == 'route') {
                            //   addressData.street = place.address_components[i].long_name;
                            // }
                            if (place.address_components[i].types[0] == 'locality') {
                                addressData.city = place.address_components[i].long_name;
                            }
                            if (place.address_components[i].types[0] == 'administrative_area_level_1') {
                                addressData.state = place.address_components[i].short_name;
                            }
                            if (place.address_components[i].types[0] == 'country') {
                                addressData.country = place.address_components[i].long_name;
                            }
                        }
                        let streetRd = place.formatted_address.split(",");
                        addressData.street = streetRd[0];
                        addressData.name = place.name;
                        addressData.location = place.formatted_address;
                        addressData.lat = place.geometry.location.lat();
                        addressData.lon = place.geometry.location.lng();
                        this.mapData.data = addressData;
                        this.step1.formatedAddress = $(input).val();
                        this.setMapDataToMode();
                    });
                    this.mapData.map.fitBounds(bounds);
                });
            },

            setMapDataToMode() {
                this.step1.searchAddress = this.mapData.data.location;
                this.step1.formatedAddress = this.mapData.data.location;
                this.step1.state = this.mapData.data.state;
                this.step1.city = this.mapData.data.city;
                this.step1.street = this.mapData.data.street;
                this.step1.zipcode = this.mapData.data.postal_code;
                this.step1.country = this.mapData.data.country;
                this.step1.lat = this.mapData.data.lat;
                this.step1.lng = this.mapData.data.lon;
                this.changeStreetAddress(this.step1.street);
            },
            getAmcClient(id) {

            },
            getLenderClient(id) {

            },

            findTechnologyFee() {

            },

            changeStreetAddress(value) {
                this.$boston.authPost('get/same/orders/by/street', { 'street': value }).then((res) => {
                    let totalOrder = res.totalOrder;
                    let orders = res.orders;
                    if (totalOrder > 0) {
                        this.showStreetAddress = true;
                        this.streetAddress = orders;
                    }
                }).catch(err => {

                });
            },

            checkDateInput(value, type) {
                this.dateIssue.status = false;
                var date = new Date(value);
                if (type == 1) {
                    if (this.step1.dueDate) {
                        let dueDate = new Date(this.step1.dueDate);
                        if (dueDate < date) {
                            this.dateIssue.status = true;
                        }
                    }
                } else {
                    if (this.step1.receiveDate) {
                        let receiveDate = new Date(this.step1.receiveDate);
                        if (receiveDate > date) {
                            this.dateIssue.status = true;
                        }
                    }
                }
            },

            checkclientOrderNo: _.debounce( function (event) {
                let value = event.target.value;
                this.oldOrderNo.find = false;
                this.$boston.post('/check/client/order/no', {'client_no' : value}).then((res) => {
                    this.oldOrderNo.find = res.find;
                    this.oldOrderNo.message = res.message;
                }).catch(err => {
                    console.log(err);
                });
            }, 300),

        },
        watch: {
            providerTypes: {
                handler(val) {

                },
                deep: true
            },
            step1: {
                handler(val) {
                    this.$root.$emit("updateStepData", {
                        step: 1,
                        data: { providerType: this.providerTypes, ...val }
                    });
                },
                deep: true
            },
        }
    }
</script>

<style scoped>
    .provider-items {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        text-align: left;
        font-size: 13px;
        vertical-align: middle;
        align-items: center;
        border-bottom: thin solid #999;
        padding-bottom: 15px;
    }

    .provider-items span strong {
        display: block;
    }

    .provider-items:nth-last-child(1) {
        border-bottom: none;
    }
</style>
