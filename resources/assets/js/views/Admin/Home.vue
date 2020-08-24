<template>
    <div>
        <md-card v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'census' || $auth.user().roles[0].name == 'storage-observer' || $auth.user().roles[0].name == 'recipient'" class="md-dark mb-4">
            <md-card-header>
                <md-card-header-text>
                    <div class="md-title">{{ Translate('projects') }}</div>
                    <div class="md-subhead">{{ Translate('latest.active.projects') }}</div>
                </md-card-header-text>
            </md-card-header>

            <md-card-content>
                <md-list>
                    <md-list-item v-for="(project, index) in projects" :key="index">
                        <span class="md-list-item-text">
                            <md-button :to="'/projects/' + project.hashid" class="md-light">{{project.name}}</md-button>
                        </span>
                        
                        <md-badge v-if="!project.done" class="md-primary md-square ml-2 blinking" :md-content="Translate('process')" />
                        <md-badge v-if="project.done" class="md-green md-square ml-2" :md-content="Translate('done')" />

                        <md-button :to="'/projects/' + project.hashid + '/processes/add'" class="md-icon-button md-list-action">
                            <md-icon class="md-light">add</md-icon>
                            <md-tooltip md-direction="top">{{ Translate('add.process') }}</md-tooltip>
                        </md-button>
                    </md-list-item>
                </md-list>
            </md-card-content>

            <md-card-actions>
                <md-button v-if="$auth.user().roles[0].name == 'admin'" to="/projects/add">{{ Translate('add') }}</md-button>
                <md-button to="/projects">{{ Translate('manage.all') }}</md-button>
            </md-card-actions>
        </md-card>
        <md-card v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'census' || $auth.user().roles[0].name == 'storage-observer' || $auth.user().roles[0].name == 'recipient'" class="md-dark mb-4">
            <md-card-header>
                <md-card-header-text>
                    <div class="md-title">{{ Translate('locations') }}</div>
                    <div class="md-subhead">{{ Translate('latest.active.locations') }}</div>
                </md-card-header-text>
            </md-card-header>

            <md-card-content>
                <md-list>
                    <md-list-item v-for="(location, index) in locations" :key="index">
                        <span class="md-list-item-text">
                            <md-button :to="'/locations/' + location.hashid" class="md-light">{{location.name}}</md-button>
                        </span>

                        <md-badge v-if="!project.done" class="md-primary md-square ml-2 blinking" :md-content="Translate('process')" />
                        <md-badge v-if="project.done" class="md-green md-square ml-2" :md-content="Translate('done')" />

                        <md-button :to="'/locations/' + location.hashid + '/processes/add'" class="md-icon-button md-list-action">
                            <md-icon class="md-light">add</md-icon>
                            <md-tooltip md-direction="top">{{ Translate('add.process') }}</md-tooltip>
                        </md-button>
                    </md-list-item>
                </md-list>
            </md-card-content>

            <md-card-actions>
                <md-button v-if="$auth.user().roles[0].name == 'admin'" to="/locations/add">{{ Translate('add') }}</md-button>
                <md-button to="/locations">{{ Translate('manage.all') }}</md-button>
            </md-card-actions>
        </md-card>


        <md-card v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'storage-observer'" class="md-primary mb-4">
            <md-card-header>
                <md-card-header-text>
                    <div class="md-title">{{ Translate('orders') }}</div>
                    <div class="md-subhead">{{ Translate('latest.active.orders') }}</div>
                </md-card-header-text>
            </md-card-header>

            <md-card-content>
                <md-list>
                    <md-list-item v-for="(order, index) in orders" :key="index">
                        <span class="md-list-item-text">
                            <md-button :to="'/orders/' + order.hashid" class="md-light">{{order.name}}</md-button>
                        </span>
                        
                        <md-badge v-if="order.status == 1" class="md-secondary md-square ml-2 blinking" :md-content="Translate('shipping')" />
                        <md-badge v-if="order.status == 2" class="md-green md-square ml-2" :md-content="Translate('done')" />

                        <md-button :to="'/orders/' + order.hashid + '/shipments/add'" class="md-icon-button md-list-action">
                            <md-icon class="md-light">add_shopping_cart</md-icon>
                            <md-tooltip md-direction="top">{{ Translate('add.shipment') }}</md-tooltip>
                        </md-button>
                    </md-list-item>
                </md-list>
            </md-card-content>

            <md-card-actions>
                <md-button v-if="$auth.user().roles[0].name == 'admin'" to="/orders/add">{{ Translate('add') }}</md-button>
                <md-button to="/orders">{{ Translate('manage.all') }}</md-button>
            </md-card-actions>
        </md-card>


        <md-card v-if="$auth.user().roles[0].name == 'admin' || $auth.user().roles[0].name == 'census'" class="md-dark mb-4">
            <md-card-header>
                <md-card-header-text>
                    <div class="md-title">{{ Translate('merchandises') }}</div>
                    <div class="md-subhead">{{ Translate('latest.active.merchandises') }}</div>
                </md-card-header-text>
            </md-card-header>

            <md-card-actions>
                <md-button v-if="$auth.user().roles[0].name == 'admin'" to="/merchandises/add">{{ Translate('add') }}</md-button>
                <md-button to="/merchandises">{{ Translate('manage.all') }}</md-button>
            </md-card-actions>
        </md-card>
        
    </div>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'

export default {
    name: 'Home',
    components: {
    },
    data: () => ({
        projects: [],
        locations: [],
        orders: [],
    }),

    mounted () {
    },

    created () {
        this.setPageTitle(this.Translate('dashboard'))
        
        Vue.axios.get('projects').then((response) => {
            this.projects = response.data.data.slice(0, 3)
        })

        Vue.axios.get('locationsAdmin').then((response) => {
            this.locations = response.data.data.slice(0, 3)
        })

        Vue.axios.get('orders').then((response) => {
            this.orders = response.data.data.slice(0, 5)
        })
    },

    methods: {
        ...mapMutations([
            'setPageTitle',
        ])
    }
}
</script>
