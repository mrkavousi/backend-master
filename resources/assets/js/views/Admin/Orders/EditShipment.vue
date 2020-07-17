<template>
    <form>
        <div class="shipments shipments-edit order-shipment-edit  md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <p v-if="order">{{ Translate('you.adding.shipment.order') }}: <b><router-link :to="'/orders/' + order.hashid">{{order.name}}</router-link></b></p>

                        <md-field>
                            <label>{{ Translate('title') }}</label>
                            <md-input v-model="shipment.metadatas.name"></md-input>
                            <span class="md-helper-text">{{ Translate('optional') }}</span>
                        </md-field>

                        <md-field>
                            <label for="storage">{{ Translate('storage') }}</label>
                            <md-select v-model="currentStorage.hashid" @md-selected="setStorage" id="storage">
                                <md-option v-for="storage in storages" :key="storage.id" :value="storage.hashid">{{storage.name}}</md-option>
                            </md-select>
                        </md-field>

                        <div v-if="currentStorage.id" class="md-layout mb-4">

                            <h5 class="md-layout-item md-size-100">{{ Translate('inventory') }}</h5>

                            <p v-if="!currentStorage.inventories.length">{{ Translate('no.inventory') }}</p>

                            <md-card class="md-primary md-layout-item mb-2" md-with-hover v-for="(inventory, index) in currentStorage.inventories" :key="index">
                                <md-card-header>
                                    <div class="md-title">{{inventory.name}}</div>
                                    <div class="md-subhead"><md-icon>inbox</md-icon> {{inventory.pivot.quantity - inventory.pivot.ordered_quantity}} {{ Translate('packages') }}</div>
                                </md-card-header>

                                <md-card-content>
                                    {{ Translate('from') }} {{ Translate('unload') }} 
                                    <b><router-link :to="'/projects/' + inventory.unload_process.project_hashid + '/processes/' + inventory.unload_process.hashid">{{inventory.unload_process.metadatas.name || 'Untitled'}} ({{inventory.unload_process.hashid}})</router-link></b><br>
                                    {{ Translate('code') }}: {{inventory.pivot.hashid}}
                                </md-card-content>
                                
                                <md-card-actions class="mb-2">
                                    <md-button class="md-icon-button md-raised md-primary mr-2" @click="addPackage(inventory)">
                                        <md-icon>add</md-icon>
                                    </md-button>

                                    <md-button class="md-icon-button md-raised md-primary mr-2" @click="removePackage(inventory)">
                                        <md-icon>remove</md-icon>
                                    </md-button>
                                </md-card-actions>
                            </md-card>

                        </div>

                        <div v-if="shipment.packages.length" class="md-layout mb-4">

                            <h5 class="md-layout-item md-size-100">{{ Translate('selected.packages') }}</h5>

                            <md-card class="md-dark md-layout-item md-size-100 mb-2 card-selected-package" md-with-hover v-for="(pack, index) in shipment.packages" :key="index">
                                <md-card-header>
                                    <div class="md-title">{{pack.source_package.name}}</div>
                                    <div class="md-subhead"><md-icon>inbox</md-icon> <b>{{pack.pivot.quantity}}</b> {{ Translate('packages') }}</div>
                                </md-card-header>

                                <md-card-content>
                                    {{ Translate('from') }} {{ Translate('unload') }} 
                                    <b><router-link :to="'/projects/' + pack.unload_process.project_hashid + '/processes/' + pack.unload_process.hashid">{{pack.unload_process.metadatas.name || 'Untitled'}} ({{pack.unload_process.hashid}})</router-link></b> 
                                    {{ Translate('storaged.in') }} <b>{{pack.storage ? pack.storage.name : pack.inventory.storage.name}}</b> | {{ Translate('code') }}: {{pack.inventory.pivot.hashid}}
                                </md-card-content>
                                
                                <md-card-actions class="mb-2">
                                    <md-button class="md-icon-button md-raised md-primary mr-2" @click="addPackage(pack.inventory)">
                                        <md-icon>add</md-icon>
                                    </md-button>

                                    <md-button class="md-icon-button md-raised md-primary mr-2" @click="removePackage(pack.inventory)">
                                        <md-icon>remove</md-icon>
                                    </md-button>
                                </md-card-actions>
                            </md-card>

                        </div>

                        <md-field>
                            <label for="vehicle">{{ Translate('vehicle') }}</label>
                            <md-select v-model="shipment.vehicle.id" id="vehicle">
                                <md-option v-for="vehicle in vehicles" :key="vehicle.id" :value="vehicle.id">{{vehicle.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('description') }}</label>
                            <md-textarea v-model="shipment.metadatas.description"></md-textarea>
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
                            <label for="shipmentStatus">{{ Translate('shipment.status') }}</label>
                            <md-select v-model="shipment.status" name="status" id="shipmentStatus">
                                <md-option value="0">{{ Translate('upcoming') }}</md-option>
                                <md-option value="1">{{ Translate('doing') }}</md-option>
                                <md-option value="2">{{ Translate('done') }}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('done.at') }}</label>
                            <md-input v-model="shipment.metadatas.done_at" id="doneAt"></md-input>
                            <md-button @click="dateTimePickerShow=true" class="md-icon-button md-primary">
                                <md-icon>event</md-icon>
                            </md-button>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('etd') }}</label>
                            <md-input v-model="shipment.metadatas.etd" id="etd"></md-input>
                            <md-button @click="etdDateTimePickerShow=true" class="md-icon-button md-primary">
                                <md-icon>event</md-icon>
                            </md-button>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('eta') }}</label>
                            <md-input v-model="shipment.metadatas.eta" id="eta"></md-input>
                            <md-button @click="etaDateTimePickerShow=true" class="md-icon-button md-primary">
                                <md-icon>event</md-icon>
                            </md-button>
                        </md-field>
                    </md-card-content>
                    <md-card-actions>
                        <md-button class="md-raised md-primary" @click="saveShipment">{{ Translate('save') }}</md-button>
                    </md-card-actions>
                </md-card>
            </div>
        </div>

        <date-picker
            v-model="shipment.metadatas.done_at"
            type="datetime"
            element="doneAt"
            :show="dateTimePickerShow"
            @close="dateTimePickerShow=false">
        </date-picker>

        <date-picker
            v-model="shipment.metadatas.eta"
            type="datetime"
            element="eta"
            :show="etaDateTimePickerShow"
            @close="etaDateTimePickerShow=false">
        </date-picker>

        <date-picker
            v-model="shipment.metadatas.etd"
            type="datetime"
            element="etd"
            :show="etdDateTimePickerShow"
            @close="etdDateTimePickerShow=false">
        </date-picker>

    </form>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'

var _ = require('lodash')

export default {
    data: () => ({
        shipment: {
            packages: [],
            vehicle: {
                id: 0
            },
            metadatas: {
                name: null,
                description: null,
                done_at: null,
                eta: null,
                etd: null,
            },
            status: 0
        },

        currentStorage: {
            hashid: 0
        },

        order: null,
        storages: [],
        vehicles: [],

        dateTimePickerShow: false,
        etaDateTimePickerShow: false,
        etdDateTimePickerShow: false,
    }),

    created() {

        this.setPageTitle(this.Translate('edit.shipment'))

        Vue.axios.get('shipments/' + this.$route.params.shipmentHashid).then((response) => {
            this.shipment = response.data
        })

        Vue.axios.get('orders/' + this.$route.params.orderHashid).then((response) => {
            this.order = response.data
        })

        Vue.axios.get('locations/?types[]=12').then((response) => {
            this.storages = response.data
        })

        Vue.axios.get('vehicles').then((response) => {
            this.vehicles = response.data
        })

    },

    methods: {
        saveShipment () {
            Vue.axios.put('shipments/' + this.$route.params.shipmentHashid + '?order=' + this.order.hashid, this.shipment)
                .then((response) => {
                    this.setSnackbarText('Shipment updated successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/orders/' + this.order.hashid)
                })
                .catch((response) => {

                })
        },

        setStorage (storageHashid) {
            if (storageHashid) {
                Vue.axios.get('locations/' + storageHashid + '/inventory').then((response) => {
                    this.currentStorage = response.data
                })
            }
        },

        addPackage (inventory) {
            var packageIndex = this.shipment.packages.findIndex(p => p.id == inventory.pivot.id)
            if (packageIndex >= 0 && this.shipment.packages[packageIndex].pivot.quantity < (inventory.pivot.quantity - inventory.pivot.ordered_quantity)) {
                this.shipment.packages[packageIndex].pivot.quantity ++
            } else if (packageIndex < 0) {
                this.shipment.packages.push({
                    id: inventory.pivot.id,
                    hashid: inventory.pivot.hashid,
                    source_package: {
                        name: inventory.name,
                    },
                    unload_process: {
                        hashid: inventory.unload_process.hashid,
                        project_hashid: inventory.unload_process.project_hashid,
                        metadatas: {
                            name: inventory.unload_process.metadatas.name
                        }
                    },
                    pivot: {
                        quantity: 1
                    },
                    inventory: inventory
                })
            }
        },

        removePackage (inventory) {
            var packageIndex = this.shipment.packages.findIndex(p => p.id == inventory.pivot.id)
            if (packageIndex >= 0 && this.shipment.packages[packageIndex].pivot.quantity > 1) {
                this.shipment.packages[packageIndex].pivot.quantity --
            } else if (packageIndex >= 0) {
                this.shipment.packages.splice(packageIndex, 1)
            }
        },

        ...mapMutations([
            'setPageTitle',
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}
</script>