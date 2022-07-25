<template>
    <b-modal id="assign-to" size="md" title="Assign to">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-11 search">
                        <input type="text" class="form-control" @keyup="filterUsers" v-model="searchKey"
                            placeholder="Search here ...">
                    </div>
                    <div class="row">
                        <div class="col-md-5 checkboxes" v-for="user,index in allUsers" :key="index"
                            v-bind:id="user.id">
                            <div class="form-check">
                                <label class="form-check-label">
                                    {{ user.name }}
                                </label>
                                <input class="form-check-input user-checkbox" :id="user.id"
                                    @change="getCheckedUsers($event)" type="checkbox"
                                    :checked="checkSelected(user.id,checkedUsers)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div slot="modal-footer">
            <b-button type="button" variant="secondary" @click="$bvModal.hide('assign-to')">Close</b-button>
            <b-button type="button" variant="primary" @click="saveAssignedTo">Save</b-button>
        </div>
    </b-modal>
</template>
<script>
    export default {
        name: 'assign-to',
        props: {
            users: [],
            client: []
        },
        data: () => ({
            searchKey: '',
            allUsers: [],
            checkedUsers: []
        }),
        created() {
            this.checkedUsers = []
            this.initUsers(this.users);
        },
        watch: {
            client: {
                handler(val) {
                    this.checkedUsers = JSON.parse(val.assigned_to) ?? []
                    console.log(this.checkedUsers)
                },
                deep: true
            }
        },
        methods: {
            initUsers(users) {
                this.allUsers = users
            },
            checkSelected(needle, haystack) {
                if (haystack) {
                    var length = haystack.length
                    for (var i = 0; i < length; i++) {
                        if (haystack[i] == needle) return true
                    }
                }
                return false;
            },
            getCheckedUsers(event) {
                let isChecked = event.target.checked
                if (isChecked) {
                    this.checkedUsers.push(event.target.id)
                } else {
                    const index = this.checkedUsers.indexOf(event.target.id)
                    if (index > -1) {
                        this.checkedUsers.splice(index, 1)
                    }
                }
            },
            saveAssignedTo() {
                if (this.checkedUsers.length > 0) {
                    this.$boston.post('save-assigned-users', { id: this.client.id, users: this.checkedUsers })
                        .then(res => {
                            this.$root.$emit('update_client', res)
                            this.$bvModal.hide('assign-to')
                            this.$toast.open({
                                message: "Assigned successfully",
                                type: 'success',
                            })
                        })
                        .catch(err => {
                            console.error(err)
                        })
                } else {
                    this.$toast.open({
                        message: "Please select atleast one user from the list",
                        type: 'error',
                    })
                }
            },
            filterUsers: _.debounce(function (event) {
                let value = event.target.value;
                this.$boston.post('filter-users', { 'search_key': value }).then((res) => {
                    this.allUsers = res.data
                }).catch(err => {
                    console.log(err);
                });
            }, 300),
        }
    }
</script>
<style scoped>
    .checkboxes {
        padding: .5em;
        border: .1em solid gray;
        margin: 1em;
        font-size: 1.1em !important;
        border-radius: .3em !important;
    }

    input[type='checkbox'].checkboxes:checked {
        border: .1em solid #19B7A2 !important;
    }

    .search input {
        margin: .6em !important;
        border: .2em solid #19B7A2 !important;
    }

    .user-checkbox {
        border-radius: 50% !important;
        height: 1.2em !important;
        width: 1.2em !important;
        padding: 0.5em !important;
    }

</style>
