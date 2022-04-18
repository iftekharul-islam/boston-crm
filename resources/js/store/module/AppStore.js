import VuexPersistence from 'vuex-persist'

const vuexLocal = new VuexPersistence({
  storage: window.localStorage
})

const appStore = {
    namespaced: true,
    state: {
        appName: "Boston CRM"
    },
    getters: {
        getAppName : (state) => state.appName
    },
    mutations: {

    },
    actions: {

    },
    plugins: [vuexLocal.plugin]
};

export default appStore;
