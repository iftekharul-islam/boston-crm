import VuexPersistence from 'vuex-persist'

const vuexLocal = new VuexPersistence({
  storage: window.localStorage
})
function getOrderDetails() {
    let data = localStorage.getItem('orderDetails')
    if(data && data !== undefined && data != 'undefined'){
        return JSON.parse(data)
    }
    return null
}
const appStore = {
    namespaced: true,
    state: {
        appName: "Boston CRM",
        orderDetails: getOrderDetails(),
    },
    getters: {
        getAppName : (state) => state.appName,
        orderDetails : (state) => state.orderDetails
    },
    mutations: {
        storeOrder(state, value) {
            localStorage.setItem('orderDetails', JSON.stringify(value))
            state.orderDetails = value;
        },
    },
    actions: {

    },
    plugins: [vuexLocal.plugin]
};

export default appStore;
