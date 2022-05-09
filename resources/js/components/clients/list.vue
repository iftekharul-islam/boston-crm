<template>
  <div class="clients bg-platinum dashboard-space">
    <div class="clients-box clients-box-main bg-white">
      <div class="clients-top d-flex flex-wrap justify-content-between">
        <div class="left d-flex">
          <template v-for="(type, index) in types">
            <button class="clients-top-btn px-3 h-40" :class="{'active': isActive === type.type}"
                    @click="getType(type.type)">
              {{ type.type }} <span class="ms-3">{{ type.count }}</span>
            </button>
          </template>
        </div>
        <div class="right d-flex">
          <!-- Loader -->
          <div v-if="loading" class="loader">
            <!-- about -->
              <div class="about">
                <a class="bg_links social portfolio" href="https://www.rafaelalucas.com" target="_blank">
                    <span class="icon"></span>
                </a>
                <a class="bg_links social dribbble" href="https://dribbble.com/rafaelalucas" target="_blank">
                    <span class="icon"></span>
                </a>
                <a class="bg_links social linkedin" href="https://www.linkedin.com/in/rafaelalucas/" target="_blank">
                    <span class="icon"></span>
                </a>
                <a class="bg_links logo"></a>
              </div>
              <!-- end about -->

              <div class="content">
                <div class="loading">
              <p>loading</p>
                    <span></span>
                </div>
              </div>
          </div>
          <input type="text" v-model="searchText" placeholder="Search ..." @keyup="searchClients" class="px-3 bdr-1 br-4 gray-border me-3 h-40">
          <a :href="this.createRoute" class="button button-primary h-40 py-2 d-flex align-items-center">Add clients</a>
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
              <a class="eye-btn text-light-black cursor-pointer me-3" @click.prevent="showClientDetails(client.id)">
                <span class="icon-eye fs-20"><span class="path1"></span><span class="path2"></span></span>
              </a>
              <a class="eye-btn text-light-black cursor-pointer" @click.prevent="deleteClient(client.id)">
                <span class="icon-trash fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
              </a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="pagination justify-content-center mgt-32">

        <pagination v-model="page" :edgeNavigation="false" :options="{chunk: 3,theme : 'bootstrap4',texts:{ count: '',first: '',last: '' }}" :records="parseInt(this.clients.total)" :per-page="this.clients.per_page"
                    @paginate="getClients"/>
      </div>
    </div>
  </div>
</template>
<script>
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
      loading: false,
      searchText: ''
    }
  },
  created() {
    this.getType('All')
  },
  methods: {
    searchClients: function() {
      this.getClients()
    },
    getType(type) {
      this.currentType = type
      this.isActive = type
      this.page = 1
      this.getClients()
    },
    getClients(page = 1) {
      this.loading = true;
      axios.get('get-clients/' + this.currentType + '?page=' + page + '&searchKey=' + (this.searchText).trim())
          .then(res => {
            this.clients = res.data.data.clients
            this.all = res.data.data.all
            this.types[0].count = res.data.data.all
            this.types[1].count = res.data.data.amc
            this.types[2].count = res.data.data.lender
          }).catch(err => {
        console.log(err)
      }).finally(() => this.loading = false);
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
                //console.log(res)
              }).catch(err => {
            console.log(err)
          })
          this.$swal('Deleted', 'You successfully deleted this client', 'success')
          setTimeout(function (){
            location.reload()
          },2000);
        }
      })
    }
  }
}
</script>

