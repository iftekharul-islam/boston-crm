<template>
    <div>
        <b-dropdown variant="link" right toggle-class="text-decoration-none" no-caret class="mt-2">
            <template #button-content>
                <a class="notification-icon fs-3 text-light-black d-flex align-items-center">
                    <span class="icon-notification"></span>
                </a>
            </template>
            <b-dropdown-item href="#">
                <div class="call-summary-item mx-2">
                    <div class="top d-flex align-items-center">
                        <img src="/img/user.png" alt=" profile photo boston" class="img-fluid">
                        <div class="ms-3">
                            <p class="fw-bold mb-1">asdasdasdas</p>
                            <p class="text-gray fs-12 mb-0">asdasdasdasd</p>
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
