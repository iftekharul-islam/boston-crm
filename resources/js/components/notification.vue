<template>
    <div>
        <b-dropdown variant="link" right toggle-class="text-decoration-none" no-caret class="mt-2">
            <template #button-content>
                <a class="notification-icon fs-3 text-light-black d-flex align-items-center">
                    <span class="icon-notification"></span>
                </a>
            </template>
            <b-dropdown-item href="#" v-for="(item, index) in notifications" :key="index">
                <div class="call-summary-item mx-2">
                    <div class="top d-flex align-items-center">
                        <div v-if="item.sender.media.length">
                            <img :src="item.sender.media[0].original_url" alt=" profile photo boston"
                                 class="img-fluid">
                        </div>
                        <div v-else>
                            <img src="/img/user.png" alt="boston image" class="comment-img">
                        </div>
                        <div class="ms-3">
                            <p class="fw-bold mb-1">{{ item.message }}</p>
                            <p class="text-gray fs-12 mb-0">{{ item.created_at }}</p>
                        </div>
                    </div>
                </div>
            </b-dropdown-item>
        </b-dropdown>
    </div>
</template>

<script>
export default {
    name: "notification",
    data: () => ({
        notifications: [],
    }),
    created() {
        this.fetchData()
        this.$root.$on('notification_update', () => {
            console.log('this is for emitting log')
            this.fetchData()
        })
    },
    methods: {
        fetchData() {
            this.$boston.get('notifications')
                .then(res => {
                    console.log('all notifications :', res)
                    this.notifications = res
                })
                .catch(err => {
                    console.error(err)
                })
        },
    }
}
</script>

<style scoped>
.call-summary-item {
    margin-bottom: 0px!important;
}
</style>
