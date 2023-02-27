<template>
    <div class="dashboard-main d-flex">
        <div class="sidebar sidebar__width bg-light-black">
            <div class="sidebar__logo">
               <router-link to="/"> <img src="/img/sidebar-logo.png" alt="boston logo"></router-link>
            </div>
            <div class="sidebar__collapse mgb-20">
                <button class="sidebar__collapse__btn">
                    <span class="bars bg-white"></span>
                    <span class="bars bg-white"></span>
                    <span class="bars bg-white"></span>
                </button>
            </div>
            <div class="sidebar__menu-list">
                <router-link to="/dashboard" :class="`list-item d-flex align-items-center  text-white ${activeMenu}`">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-dashboard text-white me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        Dashboard
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                <router-link to="/orders" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-order me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                        Orders
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                <router-link to="/calls" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-call me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                        Calls
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                <router-link to="/clients" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-client me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                        Clients
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                <router-link to="/users" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-user me-3 fs-3"><span class="path1"></span><span class="path2"></span></span>
                        Users
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                 <router-link to="/invoice" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-invoice me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        Invoices
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                 <router-link to="/marketing" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-ranking me-3 fs-3"></span>
                        Marketing
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                 <router-link to="/knowledge/base" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-note me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span>
                        Knowledge base
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                 <router-link to="/my-profile" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-profile-circle me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                        My profile
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
                 <router-link to="/chats" class="list-item d-flex align-items-center  text-white">
                    <div class="d-inline-flex align-items-center">
                        <span class="icon-messages me-3 fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
                        Chat
                     </div>
                     <span class="icon-arrow-down ms-auto"></span>
                </router-link>
            </div>
        </div>
        <div class="dashboard-main__right flex-grow-1 bg-platinum">
            <!-- Header -->
            <header class="dashboard-header d-flex align-items-center justify-content-between bg-white">
                <div class="dashboard-header__left">
                    <p class="text-light-black text-medium mb-0 fs-20">Boston appraisal services</p>
                </div>
                 <div class="dashboard-header__right d-flex align-items-center">
                     <div class="d-flex align-items-center">
                        <router-link to="#" class="notification-icon fs-3 text-light-black d-flex align-items-center"><span class="icon-notification"></span></router-link>
                        <router-link to="#" class="dashboard-icon text-light-black d-flex align-items-center"> <span class="icon-dashboard fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></router-link>
                     </div>
                     <div class="profile d-flex align-items-center">
                         <div class="profile__img me-2">
                            <img src="/img/dummy-profile.png" alt="boston profile">
                         </div>
                         <div class="profile__name">
                             <p class="text-bold text-light-black fs-14 mb-0">John doe</p>
                             <p class="text-gray fs-12 mb-0">Admin</p>
                         </div>
                         <span class="icon-arrow-bottom text-light-black mgl-32"></span>
                     </div>
                </div>
            </header>
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
// import { defineComponent } from '@vue/composition-api';

export default {
    data: () => ({
       activeMenu: false,
    }),
    created() {
        let route = this.$route.path;
        if (route == '/') {
            this.activeDashboardMenu(true);
        }
    },
    methods : {
        activeDashboardMenu(active = false) {
            if (active == true) {
                this.activeMenu = 'router-link-active';
            } else {
                this.activeMenu = null;
            }
        }
    },
    watch: {
        $route: {
            handler(val) {
                if (val.path == '/') {
                    this.activeDashboardMenu(true);
                } else {
                    this.activeDashboardMenu(false);
                }
            },
            deep: true
        }
    }
}
</script>

<style lang="css">
</style>

