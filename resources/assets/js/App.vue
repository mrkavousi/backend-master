<template>
    <div class="page-container md-layout-row">
        <md-app md-waterfall md-mode="fixed">
            
            <md-app-toolbar v-if="$auth.check()" class="md-light">
                <md-button class="md-icon-button" @click="toggleSidenav">
                    <md-icon>menu</md-icon>
                </md-button>

                <span class="md-title">{{ this.pageTitle }}</span>

                <md-menu :md-direction="(pageDirection == 'ltr') ? 'bottom-end' : 'bottom-start'" class="md-toolbar-section-end">
                    <md-button class="md-icon-button" md-menu-trigger>
                        <md-icon>person</md-icon>
                    </md-button>

                    <md-menu-content>
                        <md-menu-item>{{$auth.user().metadatas.name}}</md-menu-item>
                        <md-menu-item @click.prevent="$auth.logout()">{{ Translate('logout') }}</md-menu-item>
                    </md-menu-content>
                </md-menu>
            </md-app-toolbar>

            <md-app-drawer v-if="$auth.check()" :class="{'md-right': (pageDirection == 'rtl') ? true : false}" md-permanent="full" :md-active.sync="showSidenav">
                <md-toolbar class="md-transparent" md-elevation="1">
                    <b class="fw-9">{{ Translate('pansea') }}</b>
                    <md-badge class="md-square md-primary" :md-content="Translate('beta')" />
                </md-toolbar>
<!--just show if user has permission-->
                <md-list v-if="$auth.user().can.show_dashboard">
                    <md-list-item to="/">
                        <md-icon>home</md-icon>
                        <span class="md-list-item-text">{{ Translate('dashboard') }}</span>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'census' || $auth.user().roles[0].name == 'recipient'">
                        <md-icon>layers</md-icon>
                        <span class="md-list-item-text">{{ Translate('projects') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item v-if="$auth.user().can['insert_dashboard']" class="md-inset" to="/projects/add">{{ Translate('add') }}</md-list-item>
                            <md-list-item v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'census' || $auth.user().roles[0].name == 'recipient'" class="md-inset" to="/projects">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <!-- <md-list-item to="/processes">
                        <md-icon>sync</md-icon>
                        <span class="md-list-item-text">Processes</span>
                    </md-list-item> -->

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'storage-observer'">
                        <md-icon>shopping_cart</md-icon>
                        <span class="md-list-item-text">{{ Translate('orders') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item v-if="$auth.user().can['insert_dashboard']" class="md-inset" to="/orders/add">{{ Translate('add') }}</md-list-item>
                            <md-list-item v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'storage-observer'" class="md-inset" to="/orders">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <!-- <md-list-item to="/notes">
                        <md-icon>edit</md-icon>
                        <span class="md-list-item-text">Notes</span>
                    </md-list-item> -->

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'census'">
                        <md-icon>build</md-icon>
                        <span class="md-list-item-text">{{ Translate('merchandises') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item v-if="$auth.user().can['insert_dashboard']" class="md-inset" to="/merchandises/add">{{ Translate('add') }}</md-list-item>
                            <md-list-item v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'census'" class="md-inset" to="/merchandises">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>place</md-icon>
                        <span class="md-list-item-text">{{ Translate('locations') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/locations/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/locations">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>location_city</md-icon>
                        <span class="md-list-item-text">{{ Translate('cities') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/cities/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/cities">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>flag</md-icon>
                        <span class="md-list-item-text">{{ Translate('countries') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/countries/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/countries">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>local_shipping</md-icon>
                        <span class="md-list-item-text">{{ Translate('vehicles') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/vehicles/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/vehicles">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>inbox</md-icon>
                        <span class="md-list-item-text">{{ Translate('packages') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/packages/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/packages">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>bubble_chart</md-icon>
                        <span class="md-list-item-text">{{ Translate('sizes') }}</span>
                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/sizes/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/sizes">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>fitness_center</md-icon>
                        <span class="md-list-item-text">{{ Translate('weights') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/weights/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/weights">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>grade</md-icon>
                        <span class="md-list-item-text">{{ Translate('grades') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/grades/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/grades">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().roles[0].name == 'admin'">
                        <md-icon>pets</md-icon>
                        <span class="md-list-item-text">{{ Translate('aquatics') }}</span>

                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/aquatics/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/aquatics">{{ Translate('list') }}</md-list-item>
                        </md-list>
                    </md-list-item>

                    <md-list-item md-expand v-if="$auth.user().can.show_dashboard">
                        <md-icon>group</md-icon>
                        <span class="md-list-item-text">{{ Translate('users') }}</span>
                        <md-list slot="md-expand">
                            <md-list-item class="md-inset" to="/users/add" v-if="$auth.user().can['insert_dashboard']">{{ Translate('add') }}</md-list-item>
                            <md-list-item class="md-inset" to="/users">{{ Translate('list') }}</md-list-item>
                            <md-list-item class="md-inset" to="/roles">نقش‌ها</md-list-item>
                            <!--<md-list-item class="md-inset" tocsrfToken="/permissions">سطح دسترسی ها</md-list-item>-->
                        </md-list>
                    </md-list-item>

                </md-list>
            </md-app-drawer>

            <md-app-content>

                <router-view :key="$route.fullPath"></router-view>

                <md-snackbar md-position="center" :md-duration="8000" :md-active.sync="snackbarShow" md-persistent>
                    <span>{{snackbarText}}</span>
                    <md-button class="md-primary" @click="closeSnackbar">{{ Translate('ok') }}</md-button>
                </md-snackbar>

            </md-app-content>

        </md-app>
    </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
    data: () => ({
        showSidenav: false,
    }),

    computed: mapState({
        pageTitle: state => state.pageTitle,
        snackbarText: state => state.snackbarText,
        snackbarShow: state => state.snackbarShow,
        pageDirection: state => state.pageDirection
    }),

    created () {
        var self = this
        const requiresAuth = this.$route.matched.some(record => record.meta.requiresAuth)
        const html = document.documentElement // returns the html tag
        
        html.setAttribute('dir', this.pageDirection)

        this.$auth.ready(function () {
            if (self.$auth.check()) {
                var pageDirection = 'rtl'
                if (self.$auth.user().metadatas.locale != 'fa')
                    pageDirection = 'ltr'
                self.setLocale(self.$auth.user().metadatas.locale)
                self.setPageDirection(pageDirection)
                html.setAttribute('dir', self.pageDirection)
            }
        })
  
        if (requiresAuth && !localStorage.getItem('authToken'))
            this.$router.push('/login/?redirect=' + this.$route.path)
    },

    methods: {
        $can(permissionName) {
            return Permissions.indexOf(permissionName) !== -1;
        },
        toggleSidenav () {
            if (this.showSidenav)
                this.showSidenav = false
            else
                this.showSidenav = true
        },

        closeSnackbar () {
            this.setSnackbarText(null)
            this.setSnackbarShow(false)
        },

        ...mapMutations([
            'setPageTitle',
            'setSnackbarText',
            'setSnackbarShow',
            'setLocale',
            'setPageDirection',
        ])
    },

    watch: {
        'pageTitle': function () {
            document.title = this.pageTitle + ' - ' + this.Translate('pansea')
        },
    }
}

</script>