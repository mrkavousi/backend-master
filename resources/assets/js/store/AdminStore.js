import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        pageTitle: 'Pansea',
        snackbarText: null,
        snackbarShow: false,
        locale: 'fa',
        pageDirection: 'rtl',
    },
    getters: {
        pageTitle: state => {
            return state.pageTitle
        },
        snackbarText: state => {
            return state.snackbarText
        },
        snackbarShow: state => {
            return state.snackbarShow
        },
        locale: state => {
            return state.locale
        },
        pageDirection: state => {
            return state.pageDirection
        },
    },
    mutations: {
        setPageTitle: (state, payload) => {
            state.pageTitle = payload
        },
        setSnackbarText: (state, payload) => {
            state.snackbarText = payload
        },
        setSnackbarShow: (state, payload) => {
            state.snackbarShow = payload
        },
        setLocale: (state, payload) => {
            state.locale = payload
        },
        setPageDirection: (state, payload) => {
            state.pageDirection = payload
        },
    },
    actions: {
        
    }
})

export default store