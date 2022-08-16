<template>
<!--    <div class="panel panel-default">-->
<!--        <div class="panel-body">-->
<!--            &lt;!&ndash; Single button &ndash;&gt;-->
<!--            <div class="btn-group pull-right top-head-dropdown">-->
<!--                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                    Notification <span class="caret"></span>-->
<!--                </button>-->
<!--                <ul class="dropdown-menu dropdown-menu-right">-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading">You have <b>3 new themes</b> trending</div>-->
<!--                            <div class="top-text-light">15 minutes ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading">New asset recommendations in <b>Gaming Laptop</b></div>-->
<!--                            <div class="top-text-light">2 hours ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading">New asset recommendations in <b>5 themes</b></div>-->
<!--                            <div class="top-text-light">4 hours ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading">Assets specifications modified in themes</div>-->
<!--                            <div class="top-text-light">4 hours ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading">We crawled <b>www.dell.com</b> successfully</div>-->
<!--                            <div class="top-text-light">5 hours ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading">Next crawl scheduled on <b>10 Oct 2016</b></div>-->
<!--                            <div class="top-text-light">6 hours ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading">You have an update for <b>www.dell.com</b></div>-->
<!--                            <div class="top-text-light">7 hours ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading"><b>"Gaming Laptop"</b> is now trending</div>-->
<!--                            <div class="top-text-light">7 hours ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a href="#" class="top-text-block">-->
<!--                            <div class="top-text-heading">New asset recommendations in <b>Gaming Laptop</b></div>-->
<!--                            <div class="top-text-light">7 hours ago</div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <div class="loader-topbar"></div>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->


        <div>
        <b-dropdown id="dropdown-text" variant="link" right toggle-class="text-decoration-none" no-caret class="mt-2 main-dropdown">
            <template #button-content>
                <a class="notification-icon fs-3 text-light-black d-flex align-items-center">
                    <span class="icon-notification"></span>
                </a>
            </template>
            <b-dropdown-text style="width: 400px;" v-for="(item, index) in notifications" :key="index">
                    <div class="call-summary-item">
                        <div class="top d-flex align-items-center">
                            <div v-if="item.sender.media.length">
                                <img :src="item.sender.media[0].original_url" alt=" profile photo boston"
                                     class="img-fluid">
                            </div>
                            <div v-else>
                                <img src="/img/user.png" alt="boston image" class="comment-img">
                            </div>
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ item.sender.name }}</p>
                                <p class="text-gray fs-12 mb-0">{{ item.created_at }}</p>
                            </div>
                        </div>
                    </div>
                    <b>{{ item.message }}</b>
                    <b-dropdown-divider></b-dropdown-divider>
            </b-dropdown-text>
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
            this.fetchData()
        })
    },
    methods: {
        fetchData() {
            this.$boston.get('notifications')
                .then(res => {
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
    .main-dropdown /deep/ .dropdown-menu {
        max-height: 400px;
        overflow-y: auto;
    }
    .top-text-block {
        display: block;
        padding: 3px 20px;
        clear: both;
        font-weight: 400;
        line-height: 1.42857143;
        color: #333;
        white-space: inherit !important;
        border-bottom: 1px solid #f4f4f4;
        position: relative;
    }
    .top-text-block:hover:before {
        content: '';
        width: 4px;
        background: #f05a1a;
        left: 0;
        top: 0;
        bottom: 0;
        position: absolute;
    }
    .top-text-block.unread {
        background: #ffc;
    }
    .top-text-block .top-text-light {
        color: #999;
        font-size: 0.8em;
    }
    .top-head-dropdown .dropdown-menu {
        width: 350px;
        height: 300px;
        overflow: auto;
    }
    .top-head-dropdown li:last-child .top-text-block {
        border-bottom: 0;
    }
    .topbar-align-center {
        text-align: center;
    }
    .loader-topbar {
        margin: 5px auto;
        border: 3px solid #ddd;
        border-radius: 50%;
        border-top: 3px solid #666;
        width: 22px;
        height: 22px;
        -webkit-animation: spin-topbar 1s linear infinite;
        animation: spin-topbar 1s linear infinite;
    }
    @-webkit-keyframes spin-topbar {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
        }
    }
    @keyframes spin-topbar {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>
