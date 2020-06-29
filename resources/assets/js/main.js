import Vue from 'vue'
import store from './store/AdminStore'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './App'

import router from './routes/main'

import Material from './material'

import GlobalComponents from './globalComponents'

import VueMomentJalaali from 'vue-moment-jalaali'
require('moment/locale/fa')

import VuePersianDatetimePicker from 'vue-persian-datetime-picker'

import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

import './mixins/Translate'

Vue.use(VueAxios, axios)
Vue.use(Material)
Vue.use(GlobalComponents)
Vue.use(VueMomentJalaali)

Vue.use(VuePersianDatetimePicker, {
    name: 'date-picker',
    props: {
        format: 'YYYY-MM-DD HH:mm:ss',
        inputFormat: 'YYYY-MM-DD HH:mm:ss',
        displayFormat: 'dddd jDD jMMMM jYYYY',
        altFormat: 'YYYY-MM-DD HH:mm:ss',
        color: '#2979ff'
    }
})

NProgress.configure({ showSpinner: false })

Vue.router = router

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
    tokenDefaultName: 'authToken',
    authRedirect: {
        path: '/login/?redirect=' + global.location.pathname
    },
    forbiddenRedirect: {
        path: '/login/?redirect=' + global.location.pathname
    },
    refreshData: {
        enabled: false
    },
    logoutData: {
        redirect: '/login',
        makeRequest: true
    },
})

Vue.axios.defaults.baseURL = process.env.MIX_API_BASE_URL
Vue.axios.defaults.headers.common['Accept'] = 'application/json'
Vue.axios.defaults.headers.common['Content-Type'] = 'application/json;charset=UTF-8'
Vue.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'


router.beforeEach((to, from, next) => {
    NProgress.start()
    next()
})
router.afterEach(() => {
    setTimeout(function () {
        NProgress.done(true)
    }, 1500)
})

axios.interceptors.request.use(request => {
    NProgress.start()
    return request
})

axios.interceptors.response.use(response => {
    setTimeout(function () {
        NProgress.done(true)
    }, 1500)
    return response
})


new Vue({
    el: '#app',
    render: h => h(App),
    router,
    store
})