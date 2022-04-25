<template>
  <div class="clients bg-platinum dashboard-space">
    <div class="clients-box clients-box-main bg-white">
      <div class="clients-top d-flex flex-wrap justify-content-between">
        <div class="left d-flex">
          <template v-for="(type, index) in types">
            <button class="clients-top-btn px-3 h-32" :class="{'active': isActive === type.type}"
                    @click="getType(type.type)">
              {{ type.type }} <span class="ms-3">{{ type.count }}</span>
            </button>
          </template>
        </div>
        <div class="right d-flex">
          <input type="text" placeholder="Search ..." class="px-3 bdr-1 br-4 gray-border me-3">
          <a :href="this.createRoute" class="button button-primary">Add clients</a>
        </div>
      </div>
      <div class="clients-table mt-3">
        <table class="table">
          <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Client type</th>
            <th>Client city</th>
            <th>Address</th>
            <th></th>
          </tr>
          </thead>
          <tbody>

          <tr v-for="client in clients.data">
            <td><b>{{ client.name }} </b></td>
            <td>{{ client.email }}</td>
            <td>{{ client.phone }}</td>
            <td>{{ client.client_type }}</td>
            <td>{{ client.city }}</td>
            <td>{{ client.address }}</td>
            <td>
              <a class="eye-btn text-light-black" @click.prevent="showClientDetails(client.id)">
                <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
              </a>
              <a class="eye-btn text-light-black" @click.prevent="deleteClient(client.id)">
                <span class="icon-eye"><span class="path1"></span><span class="path2"></span></span>
              </a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="pagination justify-content-center mgt-32">
        <pagination v-model="page" :options="{chunk: 5,theme : 'bootstrap4'}" :records="parseInt(this.clients.total)" :per-page="this.clients.per_page"
                    @paginate="getClients"/>
      </div>
    </div>
  </div>
</template>
<script>
import {get} from "../../http/axios.method";

export default {
  props: {
    showRoute: String,
    createRoute: String,
    deleteRoute: String
  },
  data() {
    return {
      clients: {},
      types: [
        {
          'type': 'All',
          'count': 0,
        },
        {
          'type': 'Amc',
          'count': 0,
        },
        {
          'type': 'Lender',
          'count': 0,
        }
      ],
      all: 0,
      amc: 0,
      lender: 0,
      isActive: false,
      currentType: 'all',
      page: 1,
    }
  },
  created() {
    this.getType('All')
  },
  methods: {
    getType(type) {
      this.currentType = type
      this.isActive = type
      this.getClients()
    },
    getClients(page = 1) {
      get('get-clients/' + this.currentType + '?page=' + page)
          .then(res => {
            console.log(res.data)
          }).catch(err => {
            console.log(err)
      })
      axios.get('get-clients/' + this.currentType + '?page=' + page)
          .then(res => {
            this.clients = res.data.data.clients
            this.all = res.data.data.all
            this.types[0].count = res.data.data.all
            this.types[1].count = res.data.data.amc
            this.types[2].count = res.data.data.lender
          }).catch(err => {
        console.log(err)
      })
    },
    showClientDetails(clientId){
      window.location.href = this.showRoute + '/' + clientId
    },
    deleteClient(clientId){
      this.$swal({
        title: 'Are you sure you want to delete the client?',
        text: 'You can\'t revert your action',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes Delete it!',
        cancelButtonText: 'No, Keep it!',
        showCloseButton: true,
        showLoaderOnConfirm: true
      }).then((result) => {
        if(result.value) {
          axios.delete(this.deleteRoute + '/' + clientId)
              .then(res => {
                console.log(res)
              }).catch(err => {
            console.log(err)
          })
          this.$swal('Deleted', 'You successfully deleted this file', 'success')
          setTimeout(function (){
            location.reload()
          },2000);
        } else {
          this.$swal('Cancelled', 'Your data is still intact', 'info')
        }
      })
    }
  }
}
</script>
