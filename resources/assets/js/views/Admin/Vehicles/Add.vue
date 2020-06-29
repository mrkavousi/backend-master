<template>
    <form>
        <div class="vehicles vehicles-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label for="driver">Driver</label>
                            <md-select v-model="vehicle.driver.id" id="driver">
                                <md-option v-for="driver in drivers" :key="driver.id" :value="driver.id">{{driver.metadatas.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label for="vehicleType">Vehicle Type</label>
                            <md-select v-model="vehicle.type.id" id="vehicleType">
                                <md-option v-for="type in types" :key="type.id" :value="type.id">{{type.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>Name</label>
                            <md-input v-model="vehicle.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>Plate</label>
                            <md-input v-model="vehicle.metadatas.plate"></md-input>
                        </md-field>

                        <md-field>
                            <label>Color</label>
                            <md-input v-model="vehicle.metadatas.color"></md-input>
                        </md-field>

                        <md-field>
                            <label>Model</label>
                            <md-input v-model="vehicle.metadatas.model"></md-input>
                        </md-field>

                        <md-field>
                            <label>Description</label>
                            <md-textarea v-model="vehicle.description"></md-textarea>
                            <span class="md-helper-text">Optional</span>
                        </md-field>
                        
                    </md-card-content>
                </md-card>
            </div>

            <div class="md-layout-item md-size-25 md-small-size-50 md-xsmall-size-100">
                <md-card class="card-publish">
                    <md-card-header>
                        <div class="md-subhead">Save and Publish</div>
                    </md-card-header>
                    <md-card-content>
                        
                    </md-card-content>
                    <md-card-actions>
                        <md-button class="md-raised md-primary" @click="saveVehicle">Save</md-button>
                    </md-card-actions>
                </md-card>
            </div>
        </div>
    </form>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'

export default {
    data: () => ({
        page: {
            title: 'Add Vehicle'
        },

        vehicle: {
            name: '',
            type: {
                id: 0
            },
            driver: {
                id: 0
            },
            description: '',
            metadatas: {
                plate: '',
                color: '',
                model: ''
            }
        },

        drivers: [],
        types: []
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

        Vue.axios.get('drivers').then((response) => {
            this.drivers = response.data
        })

        Vue.axios.get('types/?model=vehicle').then((response) => {
            this.types = response.data
        })

    },

    methods: {
        saveVehicle () {
            Vue.axios.post('vehicles/add', this.vehicle)
                .then((response) => {
                    this.setSnackbarText('Vehicle added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/vehicles/' + response.data.hashid)
                })
                .catch((response) => {

                })
        },

        ...mapMutations([
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}
</script>