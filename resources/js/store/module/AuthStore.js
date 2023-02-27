import VuexPersistence from 'vuex-persist'

const vuexLocal = new VuexPersistence({
  storage: window.localStorage
})

const authStore = {
    namespaced: true,
    state: {
        authUser: null,
        lang: ''
    },
    getters: {
        user(state) {
            return state.authUser
        },
        isAuthenticated: (state) => {
            return state.authUser && state.authUser.token !== null
        }
    },
    mutations: {
        authUser(state, payload) {
            localStorage.setItem('auth', JSON.stringify(payload));
            state.authUser = payload;
        },
        clearAuth(state) {
            state.authUser = null;
        },
        updateAuth(state, data) {
            let user = JSON.parse(localStorage.getItem('auth'));
            user.active_company = data.active_company;
            user.name = data.name;
            user.profile_photo_url = data.profile_photo_url;
            user.mobile_number = data.mobile_number;

            localStorage.setItem('auth', JSON.stringify(user));
            state.authUser = user;
        },
        setLoading(state, loading) {
            state.isLoading = loading;
        },
        setLanguage(state, payload) {
            state.lang = payload;
        },
    },
    actions: {
        logout(context) {
            localStorage.removeItem('auth');
            context.commit('clearAuth');
        },
        saveAuthUser(context, data) {
            context.commit('authUser', data);
            context.commit('setLoading', false);
        },
        saveLocalLanguage(context, data) {
            context.commit('setLanguage', data)
        }
    },
    plugins: [vuexLocal.plugin]
};

export default authStore;
