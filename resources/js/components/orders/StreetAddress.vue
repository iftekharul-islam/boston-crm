<template>
    <transition name="fade" appear>
        <div id="streetAddress-modal">
            <div class="st-box">
                <div class="st-title">
                    <span>This property information already exists</span>
                    <div class="close">
                        <slot name="close"></slot>
                    </div>
                </div>
                <div class="st-body">
                    <div class="tables w-100">
                        <thead>
                            <th>Client Order No</th>
                            <th>Property Address</th>
                            <th>AMC Name</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <tr v-for="item, ik in data" :key="`st-road-${ik}`">
                                <td>{{ item.client_order_no }}</td>
                                <td>{{ item.property_info.street_name }}</td>
                                <td>{{ item.amc.name }}</td>
                                <td>
                                    <div class="dot"></div>
                                    Scheduled
                                </td>
                            </tr>
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
    </transition>
    
</template>

<script>

export default {
    name: 'street-address',
    props: ['data']
}

</script>

<style scoped>
div#streetAddress-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.25);
}
.st-box {
    background: #fff;
    max-width: 800px;
    position: absolute;
    left: 50%;
    top: 20%;
    transform: translate(-50%, 100%);
    width: 800px;
    border-radius: 0.25rem;
    padding: 15px;
}
.st-box .st-title {
    position: relative;
    width: 100%;
}
.st-box .st-title .close{
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
}
.st-box .st-body {
    margin-top: 15px;
}
.st-box .tables {
    margin-bottom: 0px;
    width: 100%;
    border-collapse: collapse;
}
.st-box .tables thead, .st-box .tables tbody {
    width: 100%;
}
.st-box .dot{
    height: 10px;
    width: 10px;
    border-radius: 10px;
    background: #00c851;
    margin-right: 5px;
    display: inline-block;
}
</style>