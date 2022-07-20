<template>
    <div class="marketing bg-platinum dashboard-space">
        <div class="d-flex marketing-menu-list">
            <p class="fs-20 text-600 text-light-black mgb-20">Client acquisition</p>
            <div class="ms-auto">
                <button type="button" @click="addClient" class="btn btn-primary">Add client</button>
            </div>
        </div>
        <div class="d-flex marketing-menu-list">
            <div class="menu">
                <a v-for="status,index in allStatuses" href="#" class="text-light-black active">{{ status.status }} <span
                        class="text-gray mgl-12">{{ status.client_count }}</span></a>
            </div>
            <div class="ms-auto">
                <button type="button" @click.prevent="addStatus" class="btn btn-primary">Add Status</button>
            </div>
        </div>

        <div class="marketing-box">
            <div class="left">
                <a href="javascript:;" @click.prevent="changeActiveClient(index)" class="menu-box" v-for="client,index in allClients">
                    <span class="round"></span>
                    <div class="ms-3">
                        <p class="mb-1">{{ client.name + index }}</p>
                        <div class="d-inline-flex align-items-center">
                            <span class="icon-sms"><span class="path1"></span><span class="path2"></span></span>
                            <span class="ms-2 fs-14 sms-number">0</span>
                        </div>
                    </div>
                    <div class="icon ms-auto"><span class="icon-arrow-down1"></span></div>
                </a>
            </div>
            <div class="right">
                <div class="marketing-box__content h-100 bg-white">
                    <client-data ref="clientDataComponent" v-if="showClientData" :statuses="statuses"></client-data>
                </div>
            </div>
        </div>
        <add-client></add-client>
        <add-status></add-status>
    </div>
</template>
<script>
    export default {
        props: {
            clients: [],
            statuses: []
        },
        data: () => ({
            allClients: [],
            allStatuses: [],
            status:'',
            activeClient: '',
            showClientData: false
        }),
        created() {
            this.initClient(this.clients)
            this.initStatus(this.statuses)
            this.$root.$on('toast_msg', (res) => {
                this.$toast.open({
                    message: res.message,
                    type: res.error == true ? 'error' : 'success',
                })
            })
            this.$root.$on('client_res', (res) => {
                this.allClients = res
                this.initClient(res)
            })
            this.$root.$on('status_res', (res) => {
                this.allStatuses = res
                this.initStatus(res)
            })
            if(this.clients && this.clients.length > 0){
                this.activeClient = 0
            }
        },
        methods: {
            initClient(client) {
                this.allClients = client
            },
            initStatus(status){
                this.allStatuses = status
            },
            addClient() {
                this.$bvModal.show('add-client')
            },
            addStatus() {
                this.$bvModal.show('add-status')
            },
            changeActiveClient(index){
                this.activeClient = index
                this.$refs.clientDataComponent.setClientData(this.allClients[index])
                this.showClientData = true
            }
        }
    }
</script>
