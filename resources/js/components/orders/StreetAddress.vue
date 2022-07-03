<template>
    <transition name="fade" appear>
        <div id="streetAddress-modal" class="exist-modal">
            <div class="st-box">
                <div class="st-title">
                    <span class="d-block fs-20 fw-bold primary-text mgb-32">This property information already exists</span>
                    <div class="close">
                        <slot class="span" name="close">
                        </slot>
                        
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 17L17 1" stroke="#7E829B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17 17L1 1" stroke="#7E829B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
                <div class="st-body">
                    <table class="tables w-100">
                        <thead>
                            <th>Client Order No</th>
                            <th>Property Address</th>
                            <th>AMC Name</th>
                            <th>Appraisal Type</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <tr v-for="item, ik in data" :key="`st-road-${ik}`">
                                <td>{{ item.client_order_no }}</td>
                                <td>{{ item.property_info.full_addr }}</td>
                                <td>{{ item.amc.name }}</td>
                                <td>
                                    {{ showProvidedServiceType(item) }}
                                </td>
                                <td>
                                    <div class="dot"></div>
                                    {{ item.order_status }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </transition>
    
</template>

<script>

export default {
    name: 'street-address',
    props: ['data'],
    methods: {
        showProvidedServiceType(items) {
            let item = JSON.parse(items.provider_service.appraiser_type_fee);
            let firstItem = item[0];
            if (firstItem) {
                return firstItem.type;
            }
        }
    }
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
    display: flex;
    align-items: center;
    backdrop-filter: blur(5px);
    justify-content: center;
}
.st-box {
    background: #fff;
    max-width: 90%;
    min-width: 80%;
    border-radius: 0.25rem;
    padding: 32px;
    max-height: 80vh;
    overflow: auto;
}
.st-box .st-title {
    position: relative;
    width: 100%;
}
.st-box .st-title .close{
    position: absolute;
    right: 0px;
    top: 0px;
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
.st-box .tables th,td {
    padding: 16px 0;
    border-bottom: 1px solid #E5E5E5;
}
.st-box .tables tbody tr:last-of-type td {
    border-bottom: 0;
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
