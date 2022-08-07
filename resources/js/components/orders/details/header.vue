<template>
    <div class="order-details-header d-flex mgb-20">
        <div class="left d-flex align-items-center">
            <h4 class="fs-24 fw-bold text-light-black mb-0 mgr-20">Order details</h4>
            <span class="due" v-if="diffInDay >= 0 && diffInHour > 0">Due in {{ diffInDay + ' days' }}
                {{diffInDay == 0 ?
                ', ' +diffInHour + ' hours' : ''}}</span>
            <span class="due" v-else>Already Overdue</span>
        </div>
        <div class="card mx-auto" v-if="holdReason">
            <div class="card-body bg-light text-dark">
                <span class="card-title"><strong>Hold Reason:</strong>
                    <span v-html="holdReason" class="card-subtitle text-danger"></span>
                </span>
            </div>
        </div>
        <div class="right d-flex align-items-center ms-auto">
            <div class="current-status-group d-flex align-items-center mgr-20">
                <label for="role" class="d-block text-light-black me-3">{{ currentStatus }}</label>
                <div class="position-relative">
                    <a href="javascript:;" class="button button-white h-40 d-inline-flex align-items-center"><span>{{
                            $store.state.app.orderDetails.order_status }}</span></a>
                    <!-- <select name="role" id="role" class="login-input role-error fw-bold" @change="changeOrderStatus($event)" v-model="order.status">
                        <option value="">Select</option>
                        <option value="0">Active</option>
                        <option value="14">Cancel</option>
                        <option value="15">Delete</option>
                    </select>
                    <span class="icon-arrow-down bottom-arrow-icon text-gray"></span> -->
                </div>
            </div>
            <a href="javascript:;" v-if="savingStatus" @click="saveStatus"
                class="button button-white h-40 d-inline-flex align-items-center mgr-20"><span>Save Status</span></a>

            <!-- <a href="#" class="button button-primary h-40 d-inline-flex align-items-center mgr-20"><span
                    class="mgr-20">Schedule</span> <span class="icon-calendar"><span class="path1"></span><span
                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                        class="path5"></span><span class="path6"></span><span class="path7"></span><span
                        class="path8"></span></span></a> -->
            <span v-if="copied" class="alert alert-success py-2 mb-0 mgr-20 text-600">Copied</span>
            <a :href="shareUrl" @click.prevent="copyURL" ref="shareLink"
                class="button button-primary h-40 d-inline-flex align-items-center"><span class="mgr-20">Share
                    order</span> <span class="icon-share"><span class="path1"></span><span class="path2"></span><span
                        class="path3"></span><span class="path4"></span><span class="path5"></span><span
                        class="path6"></span></span></a>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['order', 'diff_in_days', 'diff_in_hours', 'shareUrl'],
        name: 'Order-header',
        data: () => ({
            diffInDay: '',
            diffInHour: '',
            savingStatus: false,
            currentStatus: "Current Status",
            copied: false,
            holdReason: "",
        }),
        created() {
            if (this.order.hold_reason) {
                this.holdReason = this.order.hold_reason
            }
            this.updateNewTime(this.diff_in_days, this.diff_in_hours)
            this.$root.$on('update_order_time', (res) => {
                this.updateNewTime(res.data.diff_in_days, res.data.diff_in_hours)
            });
        },
        methods: {
            updateNewTime(inDay, inHour) {
                this.diffInDay = inDay
                this.diffInHour = inHour
            },
            changeOrderStatus(val) {
                this.savingStatus = true;
            },
            copyURL(event) {
                let container = this.$refs.shareLink
                this.copy(container);
                this.copied = true
                setTimeout(() => {
                    this.copied = false
                }, 1000)
            },
            saveStatus() {
                this.currentStatus = "Saving";
                this.$boston.post("order/update/status", { order: this.order, status: this.order.status }).then((res) => {
                    this.currentStatus = "Current Status";
                });
                this.savingStatus = false;
            }
        }
    }

</script>
