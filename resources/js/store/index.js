import Vuex from 'vuex'
import Vue from 'vue'
Vue.use(Vuex);

import appStore from './module/AppStore'
import authStore from './module/AuthStore'

export const storage = new Vuex.Store({
    modules: {
        'app': appStore,
        'auth': authStore
    }
});
