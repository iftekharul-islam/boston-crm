<template>
    <transition name="slide-y" appear>
        <div class="modals quick-view-modal">
            <div class="modal-dialog h-100">
                <div class="modal-content h-100 p-0">
                    <div class="bg-gray pdl-32 pdr-22 d-flex align-items-center justify-content-between h-60 min-h-60 header-modal">
                    <h5 class="fs-20 fw-bold text-white mb-0" id="exampleModalLabel">Quickview</h5>
                    <button @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body h-100 overflow-auto">
                    <p class="mb-3 fw-bold">Client info</p>
                    <div class="modal-item">
                        <p class="mb-0">AMC name</p>
                        <span>:</span>
                        <p class="mb-0 text-600">EStreet Appraisal Management
                            Company, LLC</p>
                    </div>
                    <a href="#" class="primary-text underline text-600 mgb-24 d-inline-block">AMC requirements</a>
                    <div class="modal-item">
                        <p class="mb-0">AMC name</p>
                        <span>:</span>
                        <p class="mb-0 text-600">EStreet Appraisal Management
                            Company, LLC</p>
                    </div>
                    <div class="modal-item">
                        <p class="mb-0">AMC name</p>
                        <span>:</span>
                        <p class="mb-0 text-600">EStreet Appraisal Management
                            Company, LLC</p>
                    </div>
                    <a href="#" class="primary-text underline text-600 d-inline-block">Lender requirements</a>
                    <div class="mgt-32">
                        <p class="mb-3 text-600">Property info</p>
                        <div class="modal-item">
                            <p class="mb-0">Property address</p>
                            <span>:</span>
                            <p class="mb-0 text-600">EStreet Appraisal Management
                                Company, LLC</p>
                        </div>
                        <div class="modal-item">
                            <p class="mb-0">Property address</p>
                            <span>:</span>
                            <p class="mb-0 text-700 fs-20 primary-text">EStreet Appraisal Management Company, LLC</p>
                        </div>
                        <a href="#" class="primary-text underline text-600 mgb-24 d-inline-block">AMC
                            requirements</a>
                        <div class="modal-item">
                            <p class="mb-0">Due date</p>
                            <span>:</span>
                            <p class="mb-0 text-600">33-33-33</p>
                        </div>
                        <div class="modal-item">
                            <p class="mb-0">Order no</p>
                            <span>:</span>
                            <p class="mb-0 text-600">4654765765</p>
                        </div>
                        <div class="modal-item">
                            <p class="mb-0">Order receive date</p>
                            <span>:</span>
                            <p class="mb-0 text-600">40-89-32</p>
                        </div>
                        <div class="mgt-32">
                            <p class="mb-3 text-600 ">Contact info</p>
                            <div class="modal-item">
                                <p class="mb-0">Contact name</p>
                                <span>:</span>
                                <p class="mb-0 text-600">Abid ali ahmede</p>
                            </div>
                            <div class="modal-item">
                                <p class="mb-0">Phone</p>
                                <span>:</span>
                                <p class="mb-0 text-600">35465765565</p>
                            </div>
                            <div class="modal-item">
                                <p class="mb-0">Email</p>
                                <span>:</span>
                                <p class="mb-0 text-600">exmplll@mail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="text-700 mb-3">Notes</p>
                        <p class="note-text mb-3 text-700">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                            in laying out print, graphic or web designs. The passage is attributed
                            to an unknown</p>
                        <p class="note-text text-700">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used
                                in laying out print, graphic or web designs. The passage is attributed
                                to an unknown</p>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeModal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'quick-view',
    methods: {
        closeModal() {
            this.$emit('closeQuickView', false);
        }
    }
}
</script>

<style scoped>
.modals {
    position: fixed;
    top: 0;
    right: 0;
    height: 100vh;
    overflow: auto;
}
.quick-view-modal .modal-dialog {
    box-shadow: 0 5px 10px rgb(0 0 0 / 20%);
}
</style>