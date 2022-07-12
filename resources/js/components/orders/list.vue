<template>
    <div id="order-list-view">
        <div class="open-archive d-flex">
            <div class="open-archive-left">
                <div class="d-flex flex-wrap">
                    <div class="open-archive-box" v-for="(item, key) in summary" @click="updateOrderList(item)" :key="key">
                        <button class="order-sml-box">
                            <h5 class="mb-2 number">{{ item.total }}</h5>
                            <p class="mb-0 text">{{ item.name }}</p>
                            <span class="badges" :class="updateClass(item.name)"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="open-archive-btn">
                <a href="/orders/create" class="button button-primary h-40 d-inline-flex align-items-center py-2">Add new order</a>
            </div>
        </div>
        <br>
        <div class="report bg-white">
            <div id="order-views" class="order-views">
                <div class="report-top d-flex justify-content-between mgb-32 flex-wrap">
                    <div class="left chart-box-header-btn d-flex flex-wrap justify-content-between">
                        <div class="item-btn-drop" v-for="dCol, di in order.filterItems" :key="di">
                            <button class="chart-btn h-32 d-flex align-items-center justify-content-between mb-2" :key="di" :id="`dropdownMenuLink_${dCol.key}`" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ dCol.title }} ({{ showNumber(filterTypeValue[dCol.key]) }})
                            </button>
                            <!-- dropdown -->
                            <div class="dropdown-menu py-0 search-dropdown" :aria-labelledby="`dropdownMenuLink_${dCol.key}`">
                                <input type="text" class="search-input" @input="checkSearch($event.target.value, dCol)" placeholder="Search...">
                                <ul class="p-0 m-0 search-results">
                                    <li class="results-item" v-for="filter_item, fi in filterTypeValue[dCol.key]" :key="fi" @click="chooseFilterItem(filter_item, dCol.key)">
                                        <span v-if="dCol.key == 'appraisal_types'">{{ filter_item.form_type }}</span>
                                        <span v-else-if="dCol.key == 'property_types'">{{ filter_item.type }}</span>
                                        <span v-else>{{ filter_item.name }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
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

                        <button class="button button-primary h-32 d-inline-flex align-items-center py-2">View daily report</button>
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
                    <template v-slot:view="{item}">
                        <template v-if="viewAvailable(item.status)">
                            <a title="Edit order information" :href="`orders/${item.id}/edit`" class="btn btn-success btn-sm d-none" :data-key="item.id">
                                <span onclick="roleUpdateOpen(2);" class="icon-edit cursor-pointer"><span class="path1"></span><span class="path2"></span></span>
                            </a>
                            <a title="View order information" :href="`orders/${item.id}`" class="view-btn" :data-key="item.id">
                                <span onclick="roleUpdateOpen(2);" class="cursor-pointer">
                                    View
                                </span>
                            </a>
                        </template>
                        <template v-else>
                            -
                        </template>
                    </template>
                    <template v-slot:action="{item}">
                        <div>
                            <b-dropdown variant="link" right toggle-class="text-decoration-none" no-caret class="mt-2">
                                <template #button-content>
                                    <span class="icon-arrow-bottom"></span>
                                </template>
                                <b-dropdown-item href="#" @click.prevent="addFeeAmount(item.id, 17)" :disabled="item.status == 17">Cancel with payment</b-dropdown-item>
                                <b-dropdown-item href="#" @click.prevent="submitAction(item.id, 18)" :disabled="item.status == 18">Cancel with out payment </b-dropdown-item>
                                <b-dropdown-item href="#" @click.prevent="submitAction(item.id, 15)" :disabled="item.status == 15">Delete</b-dropdown-item>
                                <b-dropdown-item href="#" @click.prevent="submitAction(item.id, 19)" :disabled="item.status == 19">On Hold</b-dropdown-item>
                                <b-dropdown-item href="#" @click.prevent="submitAction(item.id, 20)" :disabled="item.status == 20">Re-Active</b-dropdown-item>
                            </b-dropdown>
                        </div>
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
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-center d-flex justify-content-center mgr-20">
                        <select @change="loadPage(pages.activePage)" name="paginate" class="form-control per-page" v-model="pages.paginate">
                            <option value="">Per page</option>
                            <option :value="item" :key="ik" v-for="item, ik in pages.perPages">{{ item }} Per page</option>
                        </select>
                    </div>
                    <paginate align="center" :total-page="pages.pageData.last_page" @loadPage="loadPage($event)"></paginate>
                </div>
            </div>
        </div>
        <!-- modal -->
        <ValidationObserver ref="addFeeAmountFrom">
            <!-- modal -->
            <b-modal id="add-fee-amount-modal" class="brrower-modal" size="md" title="Add Fee Amount" no-close-on-backdrop>
                <div class="modal-body brrower-modal-body">
                    <div class="row">
                        <div class="col-12">
                            <ValidationProvider class="d-block group" name="Fee amount" rules="required" v-slot="{ errors }">
                                <div class="group" :class="{ 'invalid-form' : errors[0] }">
                                    <label for="" class="d-block mb-2 dashboard-label">Fee amount</label>
                                    <input type="number" v-model="updateStatus.feeAmount" class="dashboard-input w-100">
                                    <span v-if="errors[0]" class="error-message">{{ errors[0] }}</span>
                                </div>
                            </ValidationProvider>
                        </div>
                    </div>
                </div>
                <div slot="modal-footer" class="mgt-44">
                    <button class="button button-transparent" @click="$bvModal.hide('add-fee-amount-modal')">Close</button>
                    <button class="button button-primary" @click="submitFeeAmount">Submit</button>
                </div>
            </b-modal>
        </ValidationObserver>
    </div>
</template>



<script>
import Table from "../../src/Table.vue"
export default {
    props: [
        'data', 'summaryData', 'filterType'
    ],
    components: {
        Table
    },
    data: () => ({
        updateStatus: {
            feeAmount: '',
            orderId: '',
            status: '',
        },
        summary: [],
        orderData: [],
        filterDataBackup: [],
        filterTypeValue: [],
        visibleColumnDropDown: false,
        filterTypeBack: [],
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
                'view@view@center@left',
                'Action@action@center@left'
            ],
            filterItems: [
                {
                    title: "Appraiser",
                    key: "appraisal_users"
                },
                {
                    title: "Client",
                    key: "client_users"
                },
                {
                    title: "Loan Type",
                    key: "loan_types"
                },
                {
                    title: "Property Type",
                    key: "property_types"
                },
                {
                    title: "Appraisal Type",
                    key: "appraisal_types"
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
        this.initTableDate(this.data);
        this.filterTypeValue = this.filterType;
        this.summary = this.summaryData
        localStorage.setItem('orderSearchType', JSON.stringify(this.filterType));
    },
    destroyed() {
        localStorage.removeItem('orderSearchType');
    },
    methods: {
        viewAvailable(status) {
            console.log(status)
            if(jQuery.inArray(status, [15, 17, 18, 19]) !== -1){
                return false
            }
            return true
        },
        addFeeAmount(orderId, status) {
            this.updateStatus.orderId = orderId
            this.updateStatus.status = status
            this.$bvModal.show('add-fee-amount-modal')
        },
        submitFeeAmount() {
            this.$bvModal.hide('add-fee-amount-modal')
            this.submitAction(this.updateStatus.orderId, this.updateStatus.status)
            this.updateStatus.orderId = ''
            this.updateStatus.status = ''
        },
        submitAction(orderId, status) {
            console.log(orderId)
            console.log(status)
            let data = {
                'id': orderId,
                'status': status,
                'fee_amount': this.updateStatus.feeAmount
            }
            this.$boston.post('update-order-status', data).then( (res) => {
                console.log(res)
                let data = res.data
                this.initTableDate(data.orderData);
                this.filterTypeValue = data.filterType;
                this.summary = data.summaryData
                this.$toast.open({
                    message: res.message,
                    type: res.error == true ? 'error' : 'success',
                });
            }).catch( (err) => {
                console.log(err);
            });
        },
        updateOrderList(item) {
            this.pages.acitvePage = 1
            this.$boston.post('filter-list/order?page='+this.pages.acitvePage, { item: item, paginate: this.pages.paginate }).then( (res) => {
                this.pages.pageData = res;
                this.orderData = res.data;
            }).catch( (err) => {
                console.log(err);
            });
        },
        updateClass(type) {
            let firstRow = ['Due today', 'Due tomorrow', 'Appt Today', 'Appt Tomorrow', 'Overdue', 'Rush']
            let badge = 'progress-badges'
            if(type == 'Deleted' || type == 'Cancelled'){
                badge = 'archive-badges'
            } else if (type == 'Revisions' || type == 'Revised') {
                badge = 'revision-badges'
            } else if (_.includes(firstRow, type)) {
                badge = 'open-badges';
            }
            return badge
        },
        initTableDate(data) {
            this.pages.pageData = data;
            this.orderData = data.data;
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
        },
        showNumber(data) {
            if (typeof data == 'object') {
                return Object.values(data).length;
            } else if(typeof data == 'array') {
                return data.length;
            } else return 0;
        },
        checkSearch(value, dcol) {
            if (value.length == 0) {
                let filterBackup = JSON.parse(localStorage.getItem('orderSearchType'));
                this.filterTypeValue = filterBackup;
            } else {
                let findData = this.filterTypeValue[dcol.key];
                let searchData = [];

                if (dcol.key == 'property_types') {
                    searchData = findData.filter((ele) => (ele.form_type).toLowerCase().match(value.toLowerCase()));
                } else {
                    searchData = findData.filter((ele) => (ele.name).toLowerCase().match(value.toLowerCase()));
                }
                this.filterTypeValue[dcol.key] = searchData;
            }
        },
        chooseFilterItem(item, key) {
            this.$boston.post('search/order/by/filter', { item, key }).then( (res) => {
                this.initTableDate(res);
            }).catch( (err) => {
                console.log(err);
            });
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
    border: 1px solid rgba(25, 183, 162, 0.5);
    box-shadow: 0px 4px 12px 4px rgba(0, 0, 0, 0.08);
    border-radius: 8px;
    overflow: hidden;
    bottom: auto;
    padding: 20px;
}
.column-list .col-item {
    padding: 0px 0px 0px 40px;
    cursor: pointer;
    position: relative;
    margin-bottom: 12px;
}

.column-list .col-item::after {
    content: "";
    position: absolute;
    height: 24px;
    width: 24px;
    background: transparent;
    border: 1px solid #19B7A2;
    left: 5px;
    top: 50%;
    border-radius: 4px;
    transform: translate(0, -50%);
}
.column-list .col-item.active::after {
    background: #19b7a2;
}
.column-list .col-item.active::before {
    content: '';
    display: inline-block;
    transform: rotate(45deg);
    height: 15px;
    width: 8px;
    border-bottom: 3px solid #ffffff;
    border-right: 3px solid #ffffff;
    position: absolute;
    left: 13px;
    z-index: 9;
    top: 4px;
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
.search-results li {
    list-style-type: none;
    padding-top: 5px;
    cursor: pointer;
    transition: all 0.2s linear;
}

.search-results {
    max-height: 250px;
    overflow-x: auto;
    overflow-y: auto;
}

.search-dropdown {
    box-shadow: 0 5px 10px rgb(0 0 0 / 20%);
    padding: 10px;
    padding-top: 10px!important;
    padding-bottom: 10px!important;
    border: unset;
}
.search-dropdown input {
    margin-bottom: 10px;
    padding: 5px;
    border: unset;
    background: #eee;
    border-radius: 0.15rem;
}
.search-results li:hover {
    transition: all 0.2s linear;
    color: #19b7a2;
}
</style>
