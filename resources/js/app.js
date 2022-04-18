require('./bootstrap');
import Vue from 'vue';
window.Vue = Vue;
import VueRouter from 'vue-router';
import default_routes from './routes/routes';
import { i18n } from "./i18nPlugin/index";
import { storage } from './store/index';
import "./vee-validate/index";

Vue.use(VueRouter);
Vue.config.productionTip = false;

const Home = () => import(/* webpackChunkName : "Home" */ './components/Init');

const router = new VueRouter({
    default_routes,
    mode: 'history',
    scrollBehavior() {
        return { x: 0, y: 0 }
    }
});

router.beforeEach((to, from, next) => {
    let title = to.meta.title;
    if (title) {
        document.title = title + ' | ' + storage.state.app.appName
    } else {
        document.title = storage.state.app.appName
    }
    next();
});

const app = new Vue({
    el: '#app',
    i18n,
    router,
    storage,
    components: {
        'init-app': Home
    }
});
