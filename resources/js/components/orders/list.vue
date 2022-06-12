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
        <Table :items="orderData" :sl-start="pages.pageData.from" :header="order.header">
            <template v-slot:amc_id="{item}">
                {{ item.amc.name }}
            </template>
            <template v-slot:map_it="{item}">
                <a target="_blank" :href="`https://www.google.com/maps/search/?api=1&query=${item.property_info ? item.property_info.search_address : ''}`" :data-key="item.id">
                    <img src="/img/marker.png" class="img-fluid" style="height: 24px">
                </a>
            </template>
            <template v-slot:inspector="{item}">
                {{ item.inspector ? '-' : '-' }}
            </template>
            <template v-slot:due_date="{item}">
                {{ item.due_date | onlyDate }}
            </template>
            <template v-slot:inspection_date="{item}">
                {{ item.inspector ? '-' : '-' }}
            </template>
            <template v-slot:appraiser="{item}">
                {{ item.appraisal_detail.appraiser.name }}
            </template>
             <template v-slot:property_address="{item}">
                {{ item.property_info.search_address }}
            </template>
            <template v-slot:action="{item}">
                <a :href="`orders/${item.id}/edit`" class="btn btn-success btn-sm" :data-key="item.id">
                    <span onclick="roleUpdateOpen(2);" class="icon-edit cursor-pointer"><span class="path1"></span><span class="path2"></span></span>
                </a>
                <a :href="`orders/${item.id}`" class="btn btn-primary btn-sm" :data-key="item.id">
                    <span onclick="roleUpdateOpen(2);" class="icon-eye cursor-pointer"><span class="path1"></span><span class="path2"></span></span>
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
                'Order No@client_order_no@center@center',
                'Client Name@amc_id@center@center',
                'Property Address@property_address@center@center',
                'Appraiser@appraiser@center@center',
                'Inspector@inspector@center@center',
                'Inspection Date@inspection_date@center@center',
                'Due date@due_date@center@center',
                'Status@status@center@center',
                'Map It@map_it@center@center',
                'Action@action@center@center',
            ],
            disableHeader: [
                {
                    title: "Appraiser (0)",
                    key: "appraiser"
                },
                {
                    title: "Client (0)",
                    key: "client"
                },
                {
                    title: "Loan Type (0)",
                    key: "loanType"
                },
                {
                    title: "Report Type (0)",
                    key: "reportType"
                },
                {
                    title: "Property Type (0)",
                    key: "lat"
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
            // let getHeader = (this.order.header);
            // let findActive = false;            
            // for (let index in getHeader){
            //     let ele = getHeader[index];
            //     let key = ele.split("@");
            //     if (key[1] && val.key == key[1]) {
            //         findActive = val.key == key[1] ? true : false;
            //         break;
            //     }
            // }
            // return findActive;
        },
        addToTable(val) {
            // let getHeader = (this.order.header);
            // let getIndex = getHeader.find( (ele) => {
            //     let key = ele.split("@");
            //     if(val.key == key[1]) {
            //         return true;
            //     }
            // });
            // if (!getIndex) {
            //     this.order.header.splice( 3, 0, 
            //         val.title + '@' + val.key + '@center@center'
            //     );
            // } else  {
            //     let getIndexNo = this.order.header.findIndex(ele => {
            //         return ele == getIndex;
            //     });
            //     this.order.header.splice(getIndexNo, 1);
            // } 
            // this.checkColumnActive(val)
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