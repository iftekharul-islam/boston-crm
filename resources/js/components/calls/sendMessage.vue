<template>
    <b-modal id="send-message" size="md" title="Send messages">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="group">
                        <label for="" class="d-block mb-1">Receipant email</label>
                        <input type="text" class="dashboard-input w-100">
                    </div>
                    <div class="group">
                        <label for="" class="d-block mb-1">Mobile no</label>
                        <input type="text" class="dashboard-input w-100">
                    </div>
                    <div class="group">
                        <label for="" class="d-block mb-1">Subject</label>
                        <input type="text" class="dashboard-input w-100">
                    </div>
                    <div class="group">
                        <label for="" class="d-block mb-1">Messages</label>
                        <textarea name="" id="" cols="30" rows="3" class="dashboard-textarea w-100 br-8"
                            placeholder="Type here..."></textarea>
                    </div>
                    <div>
                        <p class="mgb-12">Send message to</p>
                        <div class="d-flex">
                            <div class="checkbox-group mgr-32">
                                <input type="checkbox" class="checkbox-input">
                                <label for="" class="checkbox-label">Email</label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" class="checkbox-input">
                                <label for="" class="checkbox-label">SMS</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button variant="secondary" @click="$bvModal.hide('send-message')">Close</b-button>
            <b-button variant="primary">Delete</b-button>
        </div>
    </b-modal>
</template>
<script>
    export default {
        data() {
            return {

            }
        }
    }
</script>
