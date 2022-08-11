<template>
    <div class="marketing bg-platinum dashboard-space">
        <div class="d-flex marketing-menu-list">
            <p class="fs-20 text-600 text-light-black mgb-20">Client acquisition</p>
            <div class="ms-auto">
                <button type="button" @click="addClient" class="m-0 p-2 button button-primary">Add client</button>
            </div>
        </div>
        <div class="d-flex marketing-menu-list">
            <div class="menu">
                <a v-for="status, index in allStatuses" :key="index" href="javascript:;" @click="changeActiveStatus(status.id)"
                    class="text-light-black" :class="status.id == activeStatus ? 'active' : ''">{{ status.status }}
                    <span class="text-gray mgl-12">{{ status.client_count }}</span></a>
            </div>
            <div class="ms-auto">
                <button type="button" @click.prevent="addStatus" class="m-0 p-2 button button-primary">Add
                    Status</button>
            </div>
        </div>

        <div class="marketing-box">
            <div class="left">
                <a href="javascript:;" @click.prevent="makeActiveClient(client.id)" class="menu-box"
                    :class="client.id == activeClient ? 'active' : ''" v-if="currentClients.length > 0"
                    v-for="client, index in currentClients" :key="index">
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
                <a href="javascript:;" v-if="currentClients.length == 0" class="menu-box">
                    <p class="text-gray">No clients found !</p>
                </a>
            </div>
            <div class="right">
                <div class="marketing-box__content h-100 bg-white" v-if="currentClients.length > 0">
                    <div class="content-left me-3">
                        <p class="fs-20 text-light-black fw-bold mgb-24">{{ currentClient.name }}</p>
                        <div class="d-flex flwx-wrap corporation">
                            <a href="javascript:;" class="corporation-btn" @click.prevent="openTasks">Tasks <div
                                    class="mgl-12"><span class="icon-clock"><span class="path1"></span><span
                                            class="path2"></span></span>
                                </div></a>
                            <a href="javascript:;" class="corporation-btn" @click.prevent="openAssignedTo">Assign to
                                <div class="mgl-12"><span class="icon-user"><span class="path1"></span><span
                                            class="path2"></span></span>
                                </div>
                            </a>
                            <a href="javascript:;" class="corporation-btn">Email now <div class="mgl-12"><span
                                        class="icon-sms"><span class="path1"></span><span class="path2"></span></span>
                                </div></a>
                            <a href="javascript:;" class="corporation-btn">Call <div class="mgl-12"><span
                                        class="icon-call"><span class="path1"></span><span class="path2"></span></span>
                                </div></a>
                        </div>

                        <div class="comment">
                            <div>
                                <button type="button" class="comment__header p-2 border-1" :class="currentTab == 'comments' ? 'button button-primary' : 'button button-transparent'" @click.prevent="changeTab('comments')">
                                    <p class="mb-0 fw-bold">Comments</p>
                                    <span class="comment-count">{{ currentClient.comments.length }}</span>
                                </button>
                                <button type="button" class="comment__header p-2 mx-2 border-1"
                                    :class="currentTab == 'tasks' ? 'button button-primary' : 'button button-transparent'"
                                    @click.prevent="changeTab('tasks')">
                                    <p class="mb-0 fw-bold">Task list</p>
                                    <span class="comment-count">{{ currentClient.tasks.length }}</span>
                                </button>
                            </div>

                            <div v-if="currentTab == 'comments'">
                                <div class="comment-item" v-for="(comment, index) in currentClient.comments"
                                    :key="index">
                                    <div class="d-flex align-items-center">
                                        <div v-if="comment.user.media.length">
                                            <img :src="comment.user.media[0].original_url" alt=" profile photo boston"
                                                class="img-fluid">
                                        </div>
                                        <div v-else>
                                            <img src="/img/user.png" alt="boston image" class="comment-img">
                                        </div>
                                        <div class="d-flex fw-bold mgl-12">
                                            {{ comment.user.name }}
                                            <span class="ms-3 text-gray text-400">
                                                {{ comment.created_at }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="comment-text mb-0">
                                        {{ comment.description }}
                                    </p>
                                </div>
                                <div class="comment-box">
                                    <div class="comment-box-header mb-3" v-if="tagsAvailable">
                                        <a href="#" class="tag">Notify</a>
                                        <vue-tags-input v-model="tag" :tags="tags" :autocomplete-items="filteredItems"
                                            :add-only-from-autocomplete="true" placeholder="Add User"
                                            @tags-changed="newTags => tags = newTags" />
                                    </div>
                                    <b-form-textarea v-model="currentClient.newComment"
                                        class="comment-box-textarea mb-2" placeholder="Enter issue..." rows="5"
                                        cols="5">
                                    </b-form-textarea>
                                    <p class="text-danger mb-2" v-if="currentClient.commentValidate">Please add a
                                        comment
                                        first !!!</p>
                                    <div class="text-end">
                                        <button class="button button-primary py-2 px-3"
                                            @click="updateComment">Comment</button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="currentTab == 'tasks' && currentClient.tasks.length > 0">
                                <table class="table table-hover" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Due Date</th>
                                            <th scope="col">Reminder</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="task,index in currentClient.tasks" :key="'task-'+index">
                                            <td style="width: 15%">{{ task.subject }}</td>
                                            <td style="width: 50%" v-html="task.description"></td>
                                            <td style="width: 15%">{{ task.due_date }}</td>
                                            <td style="width: 20%">{{ task.reminder }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <p class="text gray">No tasks available for this client.</p>
                            </div>
                        </div>
                    </div>
                    <div class="content-right">
                        <div class="group status-group">
                            <label for="role" class="d-block text-light-black mb-2">Status</label>
                            <div class="position-relative">
                                <m-select :options="allStatuses" object item-text="status" item-value="id"
                                    v-model="currentClient.status" @change="changeClientStatus">
                                </m-select>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:;" v-if="currentClients.length == 0" class="menu-box">
                    <p class="text-gray">No client information available !</p>
                </a>
            </div>
        </div>
        <assign-to :users="users" :client="currentClient"></assign-to>
        <tasks :client="currentClient"></tasks>
        <add-client :categories="categories"></add-client>
        <add-status :statuses="allStatuses"></add-status>
    </div>
</template>
<script>
import VueTagsInput from '@johmun/vue-tags-input';
export default {
    components: {
        VueTagsInput,
    },
    props: {
        users: [],
        clients: [],
        statuses: [],
        categories: []
    },
    data: () => ({
        tag: '',
        tags: [],
        tagsAvailable: false,
        autocompleteItems: [],
        allClients: [],
        allStatuses: [],
        status: '',
        activeClient: 0,
        activeStatus: 0,
        filterClients: [],
        currentClient: {
            id: '',
            name: '',
            address: '',
            email: '',
            phone: '',
            status: '',
            comments: [],
            newComment: '',
            commentValidate: false,
            tasks: []
        },
        currentTab: 'comments'
    }),
    computed: {
        filteredItems() {
            return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
        },
    },
    created() {
        this.fetchUsers()
        this.allClients = this.clients
        this.initStatus(this.statuses)
        this.filterAllClients(1, 'status', this.allClients)
        this.changeActiveStatus(1)
        this.$root.$on('toast_msg', (res) => {
            this.$toast.open({
                message: res.message,
                type: res.error == true ? 'error' : 'success',
            })
        })
        this.$root.$on('client_res', (res) => {
            this.allClients = res.data
            this.initStatus(res.statuses)
            this.filterAllClients(1, 'status', this.allClients)
            if(res.active_client_id){
                this.makeActiveClient(res.active_client_id)
            }else{
                this.activeClient = res.data.length - 1
            }
        })
        this.$root.$on('update_client', (res) => {
            this.allClients = res.data
        })
        this.$root.$on('status_res', (res) => {
            this.allStatuses = res
            this.initStatus(res)
        })
    },
    methods: {
        updateComment() {
            if (!this.currentClient.newComment.replace(/\s/g, "").length) {
                this.currentClient.commentValidate = true;
                setTimeout(() => {
                    this.currentClient.commentValidate = false;
                }, 1000)
                return
            }
            let data = {
                'client_id': this.currentClient.id,
                'description': this.currentClient.newComment,
                'notify': this.tags
            }
            this.$boston.post('create-client-comment', data)
                .then(res => {
                    this.currentClient.newComment = ''
                    this.tags = [];
                    this.allClients = res.data
                    this.initStatus(res.statuses)
                    this.$root.$emit('toast_msg', res)
                    this.changeActiveStatus(this.currentClient.status)
                })
                .catch(err => {
                    console.error(err)
                })
        },
        fetchUsers() {
            this.$boston.get('user-list')
                .then(res => {
                    // console.log('all users :', res)
                    this.autocompleteItems = res.map(a => {
                        return { text: a.name, id: a.id };
                    });
                    this.tagsAvailable = true
                })
                .catch(err => {
                    console.error(err)
                })
        },
        changeTab(tabName) {
            this.currentTab = tabName
        },
        initClient(client) {
            this.currentClients = client
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
        openAssignedTo() {
            this.$bvModal.show('assign-to')
        },
        openTasks() {
            this.$bvModal.show('tasks')
        },
        makeActiveClient(clientId) {
            this.activeClient = clientId
            let client = this.allClients.filter(client => client.id == clientId)
            if (client) {
                this.currentClient.id = client[0].id
                this.currentClient.name = client[0].name
                this.currentClient.address = client[0].address
                this.currentClient.email = client[0].email
                this.currentClient.phone = client[0].phone
                this.currentClient.assigned_to = client[0].assigned_to
                this.currentClient.status = client[0].status_id
                this.currentClient.comments = client[0].comments
                this.currentClient.tasks = client[0].tasks
            }
        },
        changeActiveStatus(statusId) {
            this.activeStatus = statusId
            this.filterAllClients(statusId, 'status', this.allClients)
        },
        changeClientStatus() {
            let formData = new FormData()
            formData.append('id', this.currentClient.id)
            formData.append('status_id', this.currentClient.status)
            this.$boston.post('change-client-status', formData)
                .then(res => {
                    this.allClients = res.data
                    this.initStatus(res.statuses)
                    this.$root.$emit('toast_msg', res)
                    this.changeActiveStatus(this.currentClient.status)
                })
                .catch(err => {
                    console.error(err)
                })
        },
        filterAllClients(id, type, allClients) {
            if (type == 'client') {
                this.filterClients = allClients.filter(client => client.id == id)
            } else {
                this.filterClients = allClients.filter(client => client.status_id == id)
            }
            if (this.filterClients.length > 0) {
                this.makeActiveClient(this.filterClients[0].id)
                this.initClient(this.filterClients)
            } else {
                this.initClient([])
            }
        }
    }
}
</script>
<style scoped>
.comment-box-header .tag {
    height: 37px !important;
}
</style>
