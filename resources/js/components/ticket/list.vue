<template>
    <div class="clients-box clients-box-main bg-white">
      <div class="clients-top d-flex flex-wrap justify-content-between">
        <div class="left d-flex">
          <button v-for="(type, index) in types" :key="index" class="clients-top-btn px-3 h-40" :class="{'active': isActive === type.type}"
                    @click="getType(type.type)">
              {{ type.name }} <span class="ms-3">{{ type.count }}</span>
          </button>
        </div>
        <div class="right d-flex">
          <input type="text" v-model="searchText" placeholder="Search by issue..." @keyup="searchTickets" class="px-3 bdr-1 br-4 gray-border me-3 h-40">
        </div>
      </div>
      <div class="clients-table mt-3">
        <table class="table">
          <thead>
          <tr>
            <th>Order no</th>
            <th>System Order no</th>
            <th>Client name</th>
            <th>Client type</th>
            <th>Issue title</th>
            <th>Issue date</th>
            <th>Assigned to</th>
            <th>Status</th>
            <th></th>
          </tr>
          </thead>
          <tbody>

          <tr v-for="(ticket, index) in tickets.data" :key="index">
            <td>{{ ticket.order.client_order_no }}</td>
            <td>{{ ticket.order.system_order_no }}</td>
            <td>{{ ticket.order.lender.name }}</td>
            <td>{{ ticket.order.lender.client_type }}</td>
            <td><b>{{ ticket.subject }} </b></td>
            <td>{{ ticket.created_at | onlyDate }}</td>
            <td>{{ isAssigned(ticket.assigned_user) }}</td>
            <td>{{ ticket.status ? 'Solved' : 'pending' }}</td>
            <td>
                <a title="View order information" :href="`orders/${ticket.order.id}`" class="view-btn" :data-key="ticket.order.id">
                    <span class="cursor-pointer">
                        View
                    </span>
                </a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="pagination justify-content-center mgt-32">
        <pagination v-model="page" :edgeNavigation="false" :options="{chunk: 3,theme : 'bootstrap4',texts:{ count: '',first: '',last: '' }}" :records="parseInt(this.tickets.total)" :per-page="this.tickets.per_page"
                    @paginate="getTickets"/>
      </div>
    </div>
</template>
<script>
import Pagination from 'vue-pagination-2'
Vue.component('pagination', Pagination)
export default {
  data() {
    return {
      tickets: {},
      types: [
        {
            'type': 'all',
            'name': 'Issues',
            'count': 0,
        },
        {
            'type': 'open',
            'name': 'Open task',
            'count': 0,
        },
        {
            'type': 'my',
            'name': 'My task',
            'count': 0,
        }
      ],
      all: 0,
      amc: 0,
      lender: 0,
      isActive: false,
      currentType: 'all',
      page: 1,
      searchText: '',
    }
  },
  created() {
    this.getType('all')
  },
  methods: {
      isAssigned(obj) {
          if(!_.isEmpty(obj)){
              return obj.name
          }
          return '-'
      },
    searchTickets() {
      this.getTickets()
    },
    getType(type) {
      this.currentType = type
      this.isActive = type
      this.page = 1
      this.getTickets()
    },
    getTickets(page = 1) {
      axios.get(window.origin + '/get-tickets/' + this.currentType + '?page=' + page + '&searchKey=' + (this.searchText).trim())
          .then(res => {
            this.tickets = res.data.data.tickets
            this.types[0].count = res.data.data.all
            this.types[1].count = res.data.data.open
            this.types[2].count = res.data.data.my
          }).catch(err => {
        console.log(err)
      })
    },
    showClientDetails(clientId){
      window.location.href = this.showRoute + '/' + clientId
    },
    deleteClient(clientId){
      swal({
        title: "Are you sure want to delete this client?",
        text: "Please ensure and then confirm!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, delete",
        cancelButtonText: "No, cancel!",
        reverseButtons: !0
      }).then((result) => {
        if(result.value) {
          axios.delete(this.deleteRoute + '/' + clientId)
              .then(res => {
                this.$swal('Deleted', 'You successfully deleted this client', 'success')
                setTimeout(function (){
                  location.reload()
                },2000);
              }).catch(err => {
            console.log(err)
          })
        }
      })
    }
  }
}
</script>
<style scoped>
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

