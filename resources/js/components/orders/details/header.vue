<template>
    <div class="order-details-header d-flex mgb-20">
        <div class="left d-flex align-items-center">
            <h4 class="fs-24 fw-bold text-light-black mb-0 mgr-20">Order details</h4>
            <span class="due" v-if="diff_in_days > 0">Due in {{ diff_in_days }} days</span>
            <span class="due" v-else>Already Overdue</span>
        </div>
        <div class="right d-flex align-items-center ms-auto">
            <div class="current-status-group d-flex align-items-center mgr-20">
                <label for="role" class="d-block text-light-black me-3">Current status</label> 
                <div class="position-relative">
                    <select name="role" id="role" class="login-input role-error fw-bold">
                        <option value="">Not done</option> 
                        <option value="3" class="text-capitalize">Done</option> 
                        <option value="2" class="text-capitalize">admin</option>
                    </select> 
                    <span class="icon-arrow-down bottom-arrow-icon text-gray"></span>
                </div>
            </div>
            <a href="#" class="button button-primary h-40 d-inline-flex align-items-center mgr-20"><span class="mgr-20">Schedule</span> <span class="icon-calendar"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></span></a>
            <a href="#" class="button button-primary h-40 d-inline-flex align-items-center"><span class="mgr-20">Share order</span> <span class="icon-share"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span></span></a>
        </div>
    </div>
</template>

<script>

export default {
    props: ['order', 'diff_in_days'],
    name: 'Order-header',
    created() {

    },
    methods: {

    }
}

</script>