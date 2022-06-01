<template>
    <div id="order-views">
        <div class="report-top d-flex justify-content-between mgb-32 flex-wrap">
            <div class="left chart-box-header-btn d-flex flex-wrap justify-content-between">
                <button v-for="dCol, di in order.disableHeader" @click="addToTable(dCol)" :class="{ 'active' : checkColumnActive(dCol) }" class="chart-btn h-32 d-flex align-items-center justify-content-between mb-2" :key="di">
                    {{ dCol.title }}
                </button>
            </div>
            <div class="right d-flex">
                <input type="text" v-model="pages.searchModel" @input="searchData($event)" class="me-3 mb-3 px-3 bdr-1 br-4 form-control gray-border" placeholder="Search...">
                <select @change="loadPage(pages.activePage)" name="paginate" class="form-control" v-model="pages.paginate">
                    <option value="">Per page</option>
                    <option :value="item" :key="ik" v-for="item, ik in pages.perPages">{{ item }} Per page</option>
                </select>
            </div>
        </div>
        <Table :items="orderData" :show-sl="true" :sl-start="pages.pageData.from" :header="order.header">
            <template v-slot:user="{item}">
                {{ item.user.name }}
            </template>
            <template v-slot:created_at="{item}">
                {{ item.created_at | dateTime }}
            </template>
            <template v-slot:received_date="{item}">
                {{ item.received_date | onlyDate }}
            </template>
            <template v-slot:due_date="{item}">
                {{ item.due_date | onlyDate }}
            </template>
            <template v-slot:lender_id="{item}">
                {{ item.amc.name }}
            </template>
            <template v-slot:amc_id="{item}">
                {{ item.lender.name }}
            </template>
            <template v-slot:rush="{item}">
                {{ item.rush == 1 ? 'Yes' : 'No' }}
            </template>
            <template v-slot:lat="{item}">
                {{ item.property_info ? item.property_info.latitude : '-' }}
            </template>
            <template v-slot:lon="{item}">
                {{ item.property_info ? item.property_info.longitude : '-' }}
            </template>
            <template v-slot:action="{item}">
                <a :href="`orders/${item.id}/edit`" class="btn btn-success btn-sm" :data-key="item.id">
                    <span onclick="roleUpdateOpen(2);" class="icon-edit cursor-pointer"><span class="path1"></span><span class="path2"></span></span>
                </a>
                <a :href="`orders/${item.id}`" class="btn btn-primary btn-sm" :data-key="item.id">
                    <span onclick="roleUpdateOpen(2);" class="icon-eye cursor-pointer"><span class="path1"></span><span class="path2"></span></span>
                </a>
                <a target="_blank" :href="`https://www.google.com/maps/search/?api=1&query=${item.property_info ? item.property_info.search_address : ''}`" class="btn btn-warning btn-sm" :data-key="item.id">
                    Map
                </a>
            </template>
        </Table>
        <paginate align="center" :total-page="pages.pageData.last_page" @loadPage="loadPage($event)"></paginate>
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
        pages: {
            acitvePage: 1,
            pageData: [],
            searchModel: null,
            paginate: 10,
            perPages: [10,15,20,25,30,40,50,60,100]
        },
        order: {
            header: [
                'System Order No@system_order_no@center@center',
                'Client Order No@client_order_no@center@center',
                'Received Date@received_date@center@center',
                'Due date@due_date@center@center',
                'Created At@created_at@center@center',
                'Action@action@center@center',
            ],
            disableHeader: [
                {
                    title: "Lender",
                    key: "lender_id"
                },
                {
                    title: "Amc",
                    key: "amc_id"
                },
                {
                    title: "Created By",
                    key: "user"
                },
                {
                    title: "Rush Order",
                    key: "rush"
                },
                {
                    title: "Latitude",
                    key: "lat"
                },
                {
                    title: "Longitude",
                    key: "lon"
                }
            ],
 
        }
    }),
    created() {
        this.pages.pageData = this.data;
        this.orderData = this.data.data;
    },
    methods: {
        checkColumnActive(val) {
            let getHeader = (this.order.header);
            let findActive = false;            
            for (let index in getHeader){
                let ele = getHeader[index];
                let key = ele.split("@");
                if (key[1] && val.key == key[1]) {
                    findActive = val.key == key[1] ? true : false;
                    break;
                }
            }
            return findActive;
        },
        addToTable(val) {
            let getHeader = (this.order.header);
            let getIndex = getHeader.find( (ele) => {
                let key = ele.split("@");
                if(val.key == key[1]) {
                    return true;
                }
            });
            if (!getIndex) {
                this.order.header.splice( 3, 0, 
                    val.title + '@' + val.key + '@center@center'
                );
            } else  {
                let getIndexNo = this.order.header.findIndex(ele => {
                    return ele == getIndex;
                });
                this.order.header.splice(getIndexNo, 1);
            } 
            this.checkColumnActive(val)
        },
        loadPage(acitvePage = null){
            this.pages.acitvePage = acitvePage;
            this.$boston.post('search/order?page='+this.pages.acitvePage, { data: this.pages.searchModel, paginate: this.pages.paginate }).then( (res) => {
                this.pages.pageData = res;
                this.orderData = res.data;
            }).catch( (err) => {
                console.log(err);
            });
        },
        // Search Table Data 
        searchData: _.debounce( function (event) {
            this.loadPage(this.pages.acitvePage, event.target.value);
        }, 300)
    }
}

</script>

<style scoped>
select.form-control {
    height: 38px;
}
</style>