<template>
    <div>
        <ValidationObserver ref="orderForm">
            <div class="row mgb-32">
                <div class="col-md-12 ">
                    <div class="form-box">
                        <h4 class="box-header mb-3">Borrower info</h4>

                        <div class="d-flex justify-content-between w-100 box-flex">
                            <div class="left max-w-424 w-100 me-3">
                                <ValidationProvider class="group" name="Borrower Name" rules="required"
                                    v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Borrower name <span
                                                class="text-danger require"></span></label>
                                        <input type="text" v-model="step2.borrower_name" class="dashboard-input w-100">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                                <div class="mt-3">
                                    <div class="group">
                                        <label for="" class="d-block mb-2 dashboard-label">Co-borrower name</label>
                                        <input type="text" v-model="step2.co_borrower_name"
                                            class="dashboard-input w-100">
                                    </div>
                                </div>
                            </div>
                            <div class="middle max-w-424 w-100 me-3">
                                <ValidationObserver ref="addContactForm">
                                    <ValidationProvider class="group" name="Contact No"
                                        :rules="{ 'required' : add.contact == null && step2.borrower_contact == false, min: 10, max: 12 }"
                                        v-slot="{ errors }">
                                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                            <label for="" class="d-block mb-2 dashboard-label">Contact no <span
                                                    class="text-danger require"></span></label>
                                            <input v-model="add.contact" @input="contactNumberChecking($event, 1)"
                                                @blur="addContact" @change="addContact" type="tel"
                                                class="dashboard-input w-100">
                                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                            <span v-if="invalidPhone1 == false"
                                                class="text-danger error-message">Invalid Phone Number</span>
                                            <!-- new item -->
                                            <div class="new-array-items">
                                                <div class="items" v-for="item, ki in step2.borrower_contact_s"
                                                    :key="ki">
                                                    <div class="item-content"> {{ item }} </div>
                                                    <div class="item-remove">
                                                        <button class="button button-transparent p-2 pe-0"
                                                            @click="removeItem(ki, 'contact')">
                                                            <span class="icon-trash"><span class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- add button -->
                                            <div class="text-end mt-3">
                                                <button class="add-more " @click="addContact">
                                                    <span class="icon-plus"></span> Add
                                                </button>
                                            </div>
                                        </div>
                                    </ValidationProvider>
                                </ValidationObserver>
                            </div>
                            <div class="right max-w-424 w-100">
                                <ValidationObserver ref="addEmailForm">
                                    <ValidationProvider class="group" name="Email Address"
                                        :rules="{ 'required' : add.email == null && step2.borrower_email == false, 'email' : true }"
                                        v-slot="{ errors }">
                                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                            <label for="" class="d-block mb-2 dashboard-label">Email address <span
                                                    class="text-danger require"></span></label>
                                            <input v-model="add.email" type="text" class="dashboard-input w-100"
                                                @blur="addEmail">
                                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>

                                            <div class="new-array-items">
                                                <div class="items" v-for="item, ki in step2.borrower_email_s" :key="ki">
                                                    <div class="item-content"> {{ item }} </div>
                                                    <div class="item-remove">
                                                        <button class="button button-transparent p-2 pe-0"
                                                            @click="removeItem(ki, 'email')">
                                                            <span class="icon-trash"><span class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-3">
                                                <button class="add-more" @click="addEmail">
                                                    <span class="icon-plus"></span> Add
                                                </button>
                                            </div>
                                        </div>
                                    </ValidationProvider>
                                </ValidationObserver>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mgb-32">
                <div class="col-md-12 ">
                    <div class="form-box box-flex">
                        <h4 class="box-header mb-3">Contact info</h4>

                        <div class="d-flex justify-content-between w-100">
                            <div class="left max-w-424 w-100 me-3">
                                <div class="checkbox-group position-relative mgb-20">
                                    <input v-model="step2.contactSame" type="checkbox" class=" checkbox-input w-100">
                                    <label for="" class="checkbox-label primary-text">Set borrower as contact</label>
                                </div>
                                <ValidationProvider class="group" name="Contact Info"
                                    :rules="{'required' : step2.contactSame == false }" v-slot="{ errors }">
                                    <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                        <label for="" class="d-block mb-2 dashboard-label">Contact<span
                                                class="text-danger require"></span></label>
                                        <input v-model="step2.contact_info" :disabled="step2.contactSame == true"
                                            type="text" class="dashboard-input w-100"
                                            placeholder="Enter contact name...">
                                        <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                            </div>
                            <div class="middle max-w-424 w-100 me-3" v-pd:t="42">
                                <ValidationObserver ref="addContact2form">
                                    <ValidationProvider class="group" name="Contact Number"
                                        :rules="{'required' : step2.contactSame == false && (step2.contact_number == false && add.contact2 == null), min: 10, max: 12 }"
                                        v-slot="{ errors }">
                                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                            <label for="" class="d-block mb-2 dashboard-label">Contact no <span
                                                    class="text-danger require"></span></label>
                                            <input :disabled="step2.contactSame == true"
                                                @input="contactNumberChecking($event, 2)" @blur="addContact2"
                                                v-model="add.contact2" type="tel" class="dashboard-input w-100">
                                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                            <span v-if="invalidPhone2 == false"
                                                class="text-danger error-message">Invalid Phone Number</span>

                                            <div class="new-array-items">
                                                <div class="items" v-for="item, ki in step2.contact_number_s" :key="ki">
                                                    <div class="item-content"> {{ item }} </div>
                                                    <div class="item-remove">
                                                        <button class="button button-transparent p-2 pe-0"
                                                            @click="removeItem(ki, 'contact2')">
                                                            <span class="icon-trash"><span class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-3">
                                                <button class="add-more " @click="addContact2">
                                                    <span class="icon-plus"></span> Add
                                                </button>
                                            </div>
                                        </div>
                                    </ValidationProvider>
                                </ValidationObserver>
                            </div>
                            <div class="right max-w-424 w-100" v-pd:t="42">
                                <ValidationObserver ref="addEmail2form">
                                    <ValidationProvider class="group" name="Contact Email Address"
                                        :rules="{'required' : step2.contactSame == false && (step2.email_address == false && add.email2 == null), 'email' : true}"
                                        v-slot="{ errors }">
                                        <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                            <label for="" class="d-block mb-2 dashboard-label">Email address <span
                                                    class="text-danger require"></span></label>
                                            <input :disabled="step2.contactSame == true" @blur="addEmail2"
                                                v-model="add.email2" type="text" class="dashboard-input w-100">
                                            <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>

                                            <div class="new-array-items">
                                                <div class="items" v-for="item, ki in step2.email_address_s" :key="ki">
                                                    <div class="item-content"> {{ item }} </div>
                                                    <div class="item-remove">
                                                        <button class="button button-transparent p-2 pe-0"
                                                            @click="removeItem(ki, 'email2')">
                                                            <span class="icon-trash"><span class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end mt-3">
                                                <button class="add-more" @click="addEmail2">
                                                    <span class="icon-plus"></span> Add
                                                </button>
                                            </div>
                                        </div>
                                    </ValidationProvider>
                                </ValidationObserver>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mgb-32">
                <div class="col-md-12">
                    <div class="form-box box-flex">
                        <h4 class="box-header mb-3">Property coordinate info</h4>
                        <div class="left max-w-424 w-100 me-3">
                            <ValidationProvider class="group" name="Property coordinate" rules="required"
                                v-slot="{ errors }">
                                <div class="group" :class="{ 'invalid-form': errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Property coordinate
                                        <span class="text-danger require"></span></label>
                                    <m-select class="dashboard-input w-100" no-border v-model="step2.coordinate" object
                                        item-text="coordinate" item-value="coordinate" hover :options="coordinates">
                                    </m-select>
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-box box-flex">
                        <h4 class="box-header mb-3">Property maping with boston</h4>
                    </div>
                    <div id="map"></div>
                </div>
            </div>
            <div class="d-flex">
                <div class="group mgt-32 mgb-32">
                    <h4 class="box-header mb-3">Upload order form</h4>
                    <div class="position-relative file-upload d-flex align-items-center">
                        <input type="file" @change="addFile">
                        <label for="">Upload <img src="/img/upload.png" alt="boston order file"></label>
                        <!--          {{ step2 }}-->

                        <span class="text-success file-name">{{ step2.fileName }}</span>
                    </div>
                </div>
                <div class="group mgt-32 mgb-32 mgl-32">
                    <h4 class="box-header mb-3">Store as Rush Order</h4>
                    <label for="rushOrder">
                        <input type="checkbox" v-model="step2.rush" id="rushOrder" class="pr-2">
                        Rush
                    </label>
                </div>
            </div>
            <div class="add-client__bottom d-flex justify-content-end  p-3">
                <a @click.prevent="discardOrder" href="/orders/create"
                    class="button button-discard me-3 d-flex align-items-center text-light-black">Discard <span
                        class="icon-close-circle ms-3"><span class="path1"></span><span class="path2"></span></span></a>
                <button class="button button-primary" v-if="type == 2" @click="addNewOrder(true)"> Update order
                </button>
                <button class="button button-primary" v-else @click="addNewOrder"> Add order </button>
            </div>
        </ValidationObserver>
        <confirm-dialog ref="popup">
            <h4 style="margin-top: 0">{{ dialogue.title }}</h4>
            <p>{{ dialogue.message }}</p>
            <div class="btns mt-3">
                <button class="cancel-btn" @click="_cancel">{{ dialogue.cancelButton }}</button>
                <span class="ok-btn" @click="_confirm">{{ dialogue.okButton }}</span>
            </div>
        </confirm-dialog>
    </div>
</template>

<script>
    export default {
        name: "Step2",
        props: ['type', 'order','stepData'],
        data: () => ({
            invalidPhone1: true,
            invalidPhone2: true,
            dialogue: {
                title: undefined,
                message: undefined,
                okButton: undefined,
                cancelButton: 'Go Back',
                resolvePromise: undefined,
                rejectPromise: undefined,
            },
            step2: {
                borrower_name: null,
                co_borrower_name: null,
                borrower_contact: false,
                borrower_email: false,
                borrower_contact_s: [],
                borrower_email_s: [],
                contactSame: false,
                contact_info: null,
                contact_number: false,
                email_address: false,
                coordinate: '',
                rush: 0,
                contact_number_s: [],
                email_address_s: [],
                file: '',
                fileName: ''
            },
            add: {
                contact: null,
                email: null,
                contact2: null,
                email2: null
            },
            coordinates: [
                { "coordinate": "north" },
                { "coordinate": "south" },
            ],
        }),
        created() {
            this.$root.$on('orderSubmitConfirm', (status) => {
                this.removeDataValue()
            })
            if (this.type == 2) {
                this.setStep2Data()
            }

            this.$root.$on("property-data", (res) => {
                this.initMap(res.lat,res.lng)
            })
        },
        methods: {
            initMap(lat,lng) {
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 14,
                    center: { lat: 42.361145, lng: -71.057083 },
                });
                let marker1 = new google.maps.Marker({
                    map,
                    draggable: false,
                    position: { lat: 42.361145, lng: -71.057083 },
                });

                let marker2 = new google.maps.Marker({
                    map,
                    draggable: false,
                    position: { lat: lat, lng: lng },
                });
                let poly = new google.maps.Polyline({
                    strokeColor: "#4A89F3",
                    strokeOpacity: 1.0,
                    strokeWeight: 5,
                    map: map,
                })

                const bounds = new google.maps.LatLngBounds(
                    marker1.getPosition(),
                    marker2.getPosition()
                );
                map.fitBounds(bounds)
                google.maps.event.addListenerOnce(map, 'bounds_changed', function () {
                    map.setZoom(14)
                    map.setCenter({ lat: 42.361145, lng: -71.057083 });
                });
                google.maps.event.addListener(marker1, "position_changed", this.update(marker1, marker2, poly))
                google.maps.event.addListener(marker2, "position_changed", this.update(marker1, marker2, poly))
                this.update(marker1, marker2, poly)
            },
            update(marker1, marker2, poly) {
                const path = [marker1.getPosition(), marker2.getPosition()]
                poly.setPath(path)
            },
            addFile(event) {
                let that = this
                let fileData = event.target.files[0]
                let reader = new FileReader();
                reader.readAsDataURL(fileData);
                reader.onload = function () {
                    that.step2.file = reader.result
                };
                this.step2.fileName = event.target.files[0].name
            },
            addEmail2() {
                this.$refs.addEmail2form.validate().then((status) => {
                    if (status) {
                        let newEmail = this.add.email2;
                        let findOld = this.step2.email_address_s.find((ele) => ele == newEmail);
                        if (!findOld && newEmail != null && newEmail != "") {
                            this.step2.email_address_s.push(newEmail);
                            this.add.email2 = null;
                            this.step2.email_address = true;
                            this.$refs.addEmail2form.reset();
                        }
                    }
                });
            },
            addContact2() {
                this.$refs.addContact2form.validate().then((status) => {
                    if (status) {
                        let newContact = this.add.contact2;
                        if (newContact != null && newContact != "") {
                            if (newContact.length < 10 || newContact.length > 12) {
                                return false;
                            }
                        }
                        let findOld = this.step2.contact_number_s.find((ele) => ele == newContact);
                        if (!findOld && newContact != null && newContact != "") {
                            this.step2.contact_number_s.push(newContact);
                            this.add.contact2 = null;
                            this.step2.contact_number = true;
                            this.$refs.addContact2form.reset();
                        }
                    }
                });
            },
            addEmail() {
                this.$refs.addEmailForm.validate().then((status) => {
                    if (status) {
                        let newEmail = this.add.email;
                        let findOld = this.step2.borrower_email_s.find((ele) => ele == newEmail);
                        if (!findOld && newEmail != null && newEmail != "") {
                            this.step2.borrower_email_s.push(newEmail);
                            this.add.email = null;
                            this.step2.borrower_email = true;
                        }
                    }
                });
            },
            addContact() {
                this.$refs.addContactForm.validate().then((status) => {
                    if (status) {
                        let newContact = this.add.contact;
                        if (newContact != null && newContact != "") {
                            if (newContact.length < 10 || newContact.length > 12) {
                                return false;
                            }
                        }
                        let findOld = this.step2.borrower_contact_s.find((ele) => ele == newContact);
                        if (!findOld && newContact != null && newContact != "") {
                            this.step2.borrower_contact_s.push(newContact);
                            this.add.contact = null;
                            this.step2.borrower_contact = true;
                        }
                    }
                });
            },
            removeItem(index, type) {
                if (type == 'email2') {
                    this.step2.email_address_s.splice(index, 1);
                    if (this.step2.email_address_s.length == 0) {
                        this.step2.email_address = false;
                    }
                } else if (type == 'email') {
                    this.step2.borrower_email_s.splice(index, 1);
                    if (this.step2.borrower_email_s.length == 0) {
                        this.step2.borrower_email = false;
                    }
                } else if (type == 'contact') {
                    this.step2.borrower_contact_s.splice(index, 1);
                    if (this.step2.borrower_contact_s.length == 0) {
                        this.step2.borrower_contact = false;
                    }
                } else if (type == 'contact2') {
                    this.step2.contact_number_s.splice(index, 1);
                    if (this.step2.contact_number_s.length == 0) {
                        this.step2.contact_number = false;
                    }
                }
            },
            addNewOrder(type = false) {
                this.$refs.orderForm.validate().then((res) => {
                    this.$root.$emit("updateStepData", {
                        step: 2,
                        data: this.step2
                    });
                    this.$root.$emit("submitOrder", type);
                });
            },
            removeDataValue() {
                let newData = [];
                for (let i in this.step2) {
                    newData.i = null;
                    if (i == "borrower_contact_s" || i == "borrower_email_s" || i == "contact_number_s" || i == "email_address_s") {
                        newData.i = [];
                    } else if (i == "rush") {
                        newData.i = 0;
                    }
                }
                this.step2 = newData;
                this.$refs.addContactForm.reset();
            },
            setStep2Data() {
                let borrowerContact = JSON.parse(this.order.borrower_info.contact_email);
                let borrowerEmail = borrowerContact['email'];
                let borrowerPhone = borrowerContact['phone'];

                let contactInfo = JSON.parse(this.order.contact_info.contact_email);
                let contactInfoEmail = contactInfo['email'];
                let contactInfoPhone = contactInfo['phone'];


                let step2 = {
                    borrower_name: this.order.borrower_info.borrower_name,
                    co_borrower_name: this.order.borrower_info.co_borrower_name,
                    borrower_contact: borrowerPhone.length ? true : false,
                    borrower_email: borrowerEmail.length ? true : false,
                    borrower_contact_s: borrowerPhone,
                    borrower_email_s: borrowerEmail,
                    contactSame: this.order.contact_info.is_borrower,
                    contact_info: this.order.contact_info.contact,
                    contact_number: contactInfoPhone.length ? true : false,
                    email_address: contactInfoEmail.length ? true : false,
                    contact_number_s: contactInfoPhone,
                    rush: this.order.rush,
                    email_address_s: contactInfoEmail,
                    fileName: this.order.file ? this.order.file.file_name : null,
                };
                this.step2 = step2;
            },
            discardOrder() {
                this.dialogue.title = "Discard Order.";
                this.dialogue.message = "Are you want to discard this order now.";
                this.dialogue.okButton = "Yes";
                this.dialogue.cancelButton = "No";
                this.$refs.popup.open();
            },
            _confirm() {
                this.$refs.popup.close();
                window.location.href = "/orders/create";
            },

            _cancel() {
                this.$refs.popup.close();
            },

            contactNumberChecking(e, type) {
                let phoneNo = e.target.value;
                let formatedNumber = this.$boston.formatPhoneNo(phoneNo);
                if (type == 1) {
                    this.invalidPhone1 = true;
                    this.add.contact = formatedNumber;
                }
                if (type == 2) {
                    this.invalidPhone2 = true;
                    this.add.contact2 = formatedNumber;
                }
            },
        },
        watch: {
            step2: {
                handler(val) {
                    this.$root.$emit("updateStepData", {
                        step: 2,
                        data: val
                    });
                },
                deep: true
            }
        }
    }
</script>
<style scoped>
    #map {
        height: 300px;
        width: 98%;
        margin: 1%;
    }

</style>
