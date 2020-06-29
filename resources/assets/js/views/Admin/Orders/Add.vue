<template>
    <form>
        <div class="orders orders-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>{{ Translate('title') }}</label>
                            <md-input v-model="order.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('aquatic.type') }}</label>
                            <md-select v-model="order.metadatas.aquatic">
                                <md-option @click.native="getNewAquatic">+ {{ Translate('add.new') }}</md-option>
                                <md-option v-for="aquatic in aquatics" :key="aquatic.id" :value="aquatic.id">{{aquatic.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label for="customer">{{ Translate('customer') }}</label>
                            <md-select v-model="order.customer.id" id="customer">
                                <md-option v-for="customer in customers" :key="customer.id" :value="customer.id">{{customer.metadatas.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('description') }}</label>
                            <md-textarea v-model="order.description"></md-textarea>
                            <span class="md-helper-text">{{ Translate('optional') }}</span>
                        </md-field>
                        
                    </md-card-content>
                </md-card>
            </div>

            <div class="md-layout-item md-size-25 md-small-size-50 md-xsmall-size-100">
                <md-card class="card-publish">
                    <md-card-header>
                        <div class="md-subhead">{{ Translate('save.publish') }}</div>
                    </md-card-header>
                    <md-card-content>

                        <md-field>
                            <label for="orderStatus">{{ Translate('order.status') }}</label>
                            <md-select v-model="order.status" name="status" id="orderStatus">
                                <md-option value="0">{{ Translate('upcoming') }}</md-option>
                                <md-option value="1">{{ Translate('doing') }}</md-option>
                                <md-option value="2">{{ Translate('done') }}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('deadline') }}</label>
                            <md-input v-model="order.metadatas.deadline" id="deadline"></md-input>
                            <md-button @click="dateTimePickerShow=true" class="md-icon-button md-primary">
                                <md-icon>event</md-icon>
                            </md-button>
                        </md-field>
                        
                    </md-card-content>
                    <md-card-actions>
                        <md-button class="md-raised md-primary" @click="saveOrder">{{ Translate('save') }}</md-button>
                    </md-card-actions>
                </md-card>
            </div>
        </div>

        <date-picker
            v-model="order.metadatas.deadline"
            type="datetime"
            element="deadline"
            :show="dateTimePickerShow"
            @close="dateTimePickerShow=false">
        </date-picker>
    </form>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'

export default {
    data: () => ({
        order: {
            name: '',
            customer: {
                id: 0
            },
            description: '',
            metadatas: {
                aquatic: null,
                deadline: null,
            }
        },
        customers: [],
        aquatics: [],

        dateTimePickerShow: false,
    }),

    created() {

        this.setPageTitle(this.Translate('add.order'))

        Vue.axios.get('customers').then((response) => {
            this.customers = response.data
        })

        Vue.axios.get('aquatics').then((response) => {
            this.aquatics = response.data
        })

    },

    methods: {
        saveOrder () {
            Vue.axios.post('orders/add', this.order)
                .then((response) => {
                    this.setSnackbarText('Order added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/orders/' + response.data.hashid)
                })
                .catch((response) => {

                })
        },

        getNewAquatic () {
            let routeData = this.$router.resolve({name: 'aquatics.add'})
            window.open(routeData.href, '_blank')
        },

        ...mapMutations([
            'setPageTitle',
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}
</script>