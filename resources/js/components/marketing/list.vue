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
                <a v-for="status,index in allStatuses" href="#" class="text-light-black active">{{ status.status }}
                    <span class="text-gray mgl-12">{{ status.client_count }}</span></a>
            </div>
            <div class="ms-auto">
                <button type="button" @click.prevent="addStatus" class="btn btn-primary">Add Status</button>
            </div>
        </div>

        <div class="marketing-box">
            <div class="left">
                <a href="javascript:;" @click.prevent="changeActiveClient(index)" class="menu-box"
                    :class="index == activeClient ? 'active' : ''" v-if="allClients.length > 0"
                    v-for="client,index in allClients">
                    <span class="round"></span>
                    <div class="ms-3">
                        <p class="mb-1">{{ client.name }}</p>
                        <div class="d-inline-flex align-items-center">
                            <span class="icon-sms"><span class="path1"></span><span class="path2"></span></span>
                            <span class="ms-2 fs-14 sms-number">0</span>
                        </div>
                    </div>
                    <div v-if="index == activeClient" class="icon ms-auto"><span class="icon-arrow-down1"></span></div>
                </a>
                <a href="javascript:;" v-if="allClients.length == 0" class="menu-box">
                    <p class="text-danger text-center display-6">No clients found !</p>
                </a>
            </div>
            <div class="right">
                <div class="marketing-box__content h-100 bg-white" v-if="allClients.length > 0">
                    <div class="content-left me-3">
                        <p class="fs-20 text-light-black fw-bold mgb-24">{{ currentClient.name }}</p>
                        <div class="d-flex flwx-wrap corporation">
                            <a href="" class="corporation-btn">Schedule <div class="mgl-12"><span
                                        class="icon-clock"><span class="path1"></span><span class="path2"></span></span>
                                </div></a>
                            <a href="" class="corporation-btn">Assign to <div class="mgl-12"><span
                                        class="icon-user"><span class="path1"></span><span class="path2"></span></span>
                                </div></a>
                            <a href="" class="corporation-btn">Email now <div class="mgl-12"><span
                                        class="icon-sms"><span class="path1"></span><span class="path2"></span></span>
                                </div></a>
                            <a href="" class="corporation-btn">Call <div class="mgl-12"><span class="icon-call"><span
                                            class="path1"></span><span class="path2"></span></span></div></a>
                        </div>

                        <div class="comment">
                            <div class="comment__header">
                                <p class="mb-0 fw-bold">Comments</p>
                                <span class="comment-count text-gray">12</span>
                            </div>
                            <div class="comment-item">
                                <div class="d-flex align-items-center">
                                    <img src="https://deadline.com/wp-content/uploads/2020/07/shutterstock_671527774-e1594584322476.jpg"
                                        alt="boston image" class="comment-img">
                                    <div class="d-flex fw-bold mgl-12">Hussain M. Nasir <span
                                            class="ms-3 text-gray text-400">13 Jan
                                            2021 02:09</span></div>
                                </div>
                                <p class="comment-text mb-0">Scott Hurley
                                    VP/Director of Mortgage Lending
                                    (401) 248-7379 (Direct)
                                    (401) 248-7310 (HQ)
                                    shurley@admiralsbank.com

                                    Called and left a message for scott.</p>
                            </div>
                            <div class="comment-item">
                                <div class="d-flex align-items-center">
                                    <img src="https://deadline.com/wp-content/uploads/2020/07/shutterstock_671527774-e1594584322476.jpg"
                                        alt="boston image" class="comment-img">
                                    <div class="d-flex fw-bold mgl-12">Hussain M. Nasir <span
                                            class="ms-3 text-gray text-400">13 Jan
                                            2021 02:09</span></div>
                                </div>
                                <p class="comment-text mb-0">Scott Hurley
                                    VP/Director of Mortgage Lending.</p>
                            </div>

                            <div class="comment-box">
                                <div class="comment-box-header mb-3">
                                    <a href="#" class="tag">Notify</a>
                                    <a href="#" class="tag-img">
                                        <img src="https://deadline.com/wp-content/uploads/2020/07/shutterstock_671527774-e1594584322476.jpg"
                                            alt="boston image" class="">
                                        <span>Hussain M. Nasir</span>
                                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 9L9 1" stroke="#7E829B" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M9 9L1 1" stroke="#7E829B" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                                <textarea name="" id="" rows="5" class="comment-box-textarea"
                                    placeholder="Write here..."></textarea>
                                <div class="text-end">
                                    <button class="button button-primary py-2 px-3">Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-right">
                        <div class="group status-group">
                            <label for="role" class="d-block text-light-black mb-2">Status</label>
                            <div class="position-relative">
                                <m-select :options="statuses" object item-text="status" item-value="id"
                                    v-model="currentClient.status" @change="changeClientStatus">
                                </m-select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="marketing-box__content h-100 bg-white" v-else>
                    <p class="text-danger text-center display-6">No client information available</p>
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
            status: '',
            activeClient: 0,
            currentClient: {
                id: '',
                name: '',
                address: '',
                email: '',
                phone: '',
                status: '',
            },
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
                this.initClient(res.data)
                this.initStatus(res.statuses)
                this.activeClient = res.data.length - 1
                this.changeActiveClient(this.activeClient)
            })
            this.$root.$on('status_res', (res) => {
                this.allStatuses = res
                this.initStatus(res)
                this.changeActiveClient(this.activeClient)
            })
            if (this.clients && this.clients.length > 0) {
                this.activeClient = 0
            }
            this.changeActiveClient(this.activeClient)
        },
        methods: {
            initClient(client) {
                this.allClients = client
            },
            initStatus(status) {
                this.allStatuses = status
            },
            addClient() {
                this.$bvModal.show('add-client')
            },
            addStatus() {
                this.$bvModal.show('add-status')
            },
            changeActiveClient(index) {
                this.activeClient = index
                let client = this.allClients[index]
                if (client) {
                    this.currentClient.id = client.id
                    this.currentClient.name = client.name
                    this.currentClient.address = client.address
                    this.currentClient.email = client.email
                    this.currentClient.phone = client.phone
                    this.currentClient.status = client.status_id
                }
            },
            changeClientStatus() {
                let formData = new FormData()
                formData.append('id', this.currentClient.id)
                formData.append('status_id', this.currentClient.status)
                this.$boston.post('change-client-status', formData)
                    .then(res => {
                        this.initClient(res.data)
                        console.log(res.statuses)
                        this.initStatus(res.statuses)
                        this.$root.$emit('toast_msg', res)
                    })
                    .catch(err => {
                        console.error(err)
                    })
            }
        }
    }
</script>
