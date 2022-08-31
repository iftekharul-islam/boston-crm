<template>
    <div>
        <div v-for="(order, type) in orders" :key="type"
            class="d-flex p-2 bd-highlight border border-secondary border-1 rounded-3 bg-white m-5 p-4">
            <div class="d-flex flex-column bd-highlight mb-3 w-100">
                <div class="p-2 bd-highlight">
                    <h4 class="text-danger">{{ type + ' (' + order.length + ')' }}</h4>
                </div>
                <div v-for="ord,ordIndex in order" :key="ordIndex">
                    <div class="card p-2 ms-2 bg-gradient mb-1 bd-highlight background-primary">
                        <h5>{{ ord.appraisal_detail.appraiser.name }}</h5>
                    </div>
                    <div class="card p-2 ms-5 mb-1 bd-highlight bg-gradient" :class="ord.coordinate == 'north' ? 'background-danger' : 'background-warning'">
                        <div class="d-flex flex-row">
                            <h5 class="ms-0">{{ ord.coordinate }}</h5>
                            <a class="ms-auto" href="javascript:;"><img src="/img/marker.png"
                                    alt="map marker image"></a>
                        </div>
                    </div>
                    <table class="table table-hover ms-5 w-auto">
                        <thead>
                            <tr>
                                <th scope="col">Order no</th>
                                <th scope="col">Client name</th>
                                <th scope="col">Property address</th>
                                <th scope="col">Inspection date</th>
                                <th scope="col">Due date</th>
                                <th scope="col">Effective date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>{{ ord.client_order_no }}</th>
                                <td>{{ ord.amc.name }}</td>
                                <td>{{ ord.property_info.formatedAddress }}</td>
                                <td>01-08-2022</td>
                                <td>{{ ord.due_date }}</td>
                                <td>{{ ord.due_date }}</td>
                                <td>{{ ord.status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'effective-date',
    props: {
        orders: [],
        appraisers: [],
    },
    data() {
        return {

        }
    },
    created() {
        console.log(this.orders)
    }
}

</script>
<style scoped>
.background-primary {
    background-color: #E3FFFB !important;
}

.background-danger {
    background-color: #FFE5DA !important;
}

.background-warning {
    background-color: #FFF2CF !important;
}
</style>
