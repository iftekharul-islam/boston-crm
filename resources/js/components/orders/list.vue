<template>
    <div id="order-views">
        <Table :items="orderData" :header="order.header">
            <template v-slot:created_at="{item}">
                Its created_at {{item.id}}
            </template>
            <template v-slot:id="{item}">
                Its id {{item.id}}
            </template>
        </Table>
    </div>
</template>

<script>
import Table from "../../src/Table.vue"
export default {
    props: [
        'data'
    ],
    components: {
        Table
    },
    data: () => ({
        orderData: [],
        order: {
            header: [
                'Id@id@center@center',
                'Amc Id@amc_id@center@center',
                'Lender Id@lender_id@center@center',
                'receiver@received_date@center@center',
                'Due date@due_date@center@center',
                'Created At@created_at@center@center',
            ]
        }
    }),
    created() {
        this.orderData = this.data;
    }
}

</script>