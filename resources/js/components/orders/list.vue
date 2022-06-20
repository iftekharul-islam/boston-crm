<template>
    <div id="order-views" class="order-views">
        <div class="report-top d-flex justify-content-between mgb-32 flex-wrap">
            <div class="left chart-box-header-btn d-flex flex-wrap justify-content-between">
                <button v-for="dCol, di in order.filterItems" class="chart-btn h-32 d-flex align-items-center justify-content-between mb-2" :key="di">
                    {{ dCol.title }}
                </button>
            </div>
            <div class="right d-flex">
                <div class="search-box d-flex me-3 mb-3">
                    <input type="text" v-model="pages.searchModel" @input="searchData($event)" class=" px-3 bdr-1 br-4 gray-border" placeholder="Search...">
                    <button class="search-btn">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.33333 13.6667C10.8311 13.6667 13.6667 10.8311 13.6667 7.33333C13.6667 3.83553 10.8311 1 7.33333 1C3.83553 1 1 3.83553 1 7.33333C1 10.8311 3.83553 13.6667 7.33333 13.6667Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M17 17L13 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
              
                <button class="button button-primary h-40 d-inline-flex align-items-center py-2">View daily report</button>
            </div>
        </div>
        <Table :items="orderData" :sl-start="pages.pageData.from" :header="order.header" @headClick="headerClick($event)">
            <template v-slot:amc_id="{item}">
                {{ item.amc ? item.amc.name : '-' }}
            </template>
            <template v-slot:map_it="{item}">
                <a target="_blank" :href="`https://www.google.com/maps/search/?api=1&query=${item.property_info ? item.property_info.search_address : ''}`" :data-key="item.id">
                    <img src="/img/marker.png" class="img-fluid" style="height: 24px">
                </a>
            </template>
            <template v-slot:inspector="{item}">
                {{ item.inspection ? item.inspection.user.name : '-' }}
            </template>
            <template v-slot:due_date="{item}">
                {{ item.due_date | onlyDate }}
            </template>
            <template v-slot:inspection_date="{item}">
                {{ item.inspection ? item.inspection.inspection_date_time : '-' }}
            </template>
            <template v-slot:appraiser="{item}">
                <template v-if="item.appraisal_detail">
                    {{ item.appraisal_detail.appraiser ? item.appraisal_detail.appraiser.name : '-' }}
                </template>
                <template v-else>
                    -
                </template>
            </template>
             <template v-slot:property_address="{item}">
                {{ item.property_info.search_address }}
            </template>
            <template v-slot:action="{item}">
                <a title="Edit order information" :href="`orders/${item.id}/edit`" class="btn btn-success btn-sm d-none" :data-key="item.id">
                    <span onclick="roleUpdateOpen(2);" class="icon-edit cursor-pointer"><span class="path1"></span><span class="path2"></span></span>
                </a>
                <a title="View order information" :href="`orders/${item.id}`" class="view-btn" :data-key="item.id">
                    <span onclick="roleUpdateOpen(2);" class="cursor-pointer">
                        View
                    </span>
                </a>
            </template>
            <template v-slot:head_action="{item}">
                <img src="/icons/column.svg" :tag="item.item" class="cursor-pointer">
            </template>
            <template v-slot:popup>
                <transition name="fade" appear v-if="visibleColumnDropDown">
                    <div class="column-list">
                        <div class="col-item" @click="addToTable(item)" :class="{ 'active' : checkColumnActive(item) }" v-for="item, ci in order.disableHeader" :key="ci">{{ item.title }}</div>
                    </div>
                </transition>
            </template>
        </Table>
        <div class="text-center d-flex justify-content-center">
             <select @change="loadPage(pages.activePage)" name="paginate" class="form-control per-page" v-model="pages.paginate">
                <option value="">Per page</option>
                <option :value="item" :key="ik" v-for="item, ik in pages.perPages">{{ item }} Per page</option>
            </select>
         </div>
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
        visibleColumnDropDown: false,
        pages: {
            acitvePage: 1,
            pageData: [],
            searchModel: null,
            paginate: 10,
            perPages: [10,15,20,25,30,40,50,60,100]
        },
        order: {
            header: [
                'Order No@client_order_no@left@left',
                'Client Name@amc_id@left@left',
                'Property Address@property_address@left@left',
                'Appraiser@appraiser@left@left',
                'Inspector@inspector@left@left',
                'Inspection Date@inspection_date@left@left',
                'Due date@due_date@left@left',
                'Status@order_status@left@left',
                'Map It@map_it@center@center',
                'Action@action@center@left'
            ],
            filterItems: [
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

            disableHeader: [
                {
                    title: "Serial No",
                    key: "system_order_no"
                },
                {
                    title: "Due Date",
                    key: "due_date"
                }
            ]
 
        }
    }),
    created() {
        this.pages.pageData = this.data;
        this.orderData = this.data.data;

        this.order.header.map( (ele) => {
            let item = ele.split("@");
            let checkDisable = this.order.disableHeader.find((ele) => ele.key == item[1]);
            if (!checkDisable) {
                this.order.disableHeader.push({
                    title: item[0],
                    key:  item[1]
                });
            }
        });
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
                this.order.header.splice( 8, 0, 
                    val.title + '@' + val.key + '@left@left'
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
        }, 300),

        headerClick(event) {
            if (event.item == "action") {
                this.visibleColumnDropDown = !this.visibleColumnDropDown;
            }
        }
    }
}

</script>

<style scoped>
select.form-control {
    height: 38px;
}
.column-list {
    position: absolute;
    background: #fff;
    min-width: 220px;
    height: auto;
    right: 0;
    top: 40px;
    box-shadow: 0 5px 10px 0px rgb(0 0 0 / 50%);
    border-radius: 0.25rem;
    overflow: hidden;
    bottom: auto;
}
.column-list .col-item {
    padding: 5px 5px 5px 30px;
    cursor: pointer;
    position: relative;
}

.column-list .col-item::after {
    content: "";
    position: absolute;
    height: 15px;
    width: 15px;
    background: transparent;
    border: thin solid #19b7a2;
    left: 5px;
    top: 50%;
    border-radius: 0.5rem;
    transform: translate(0, -50%);
}
.column-list .col-item.active::after {
    background: #19b7a2;
}
.view-btn {
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 16px;
    padding: 5px 12px;
    color: #FFFFFF;
    background: #7E829B;
    border-radius: 0.9rem;
}
</style>
