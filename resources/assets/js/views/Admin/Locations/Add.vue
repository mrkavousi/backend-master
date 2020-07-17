<template>
    <form>
        <div class="cities cities-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label for="cities">{{ Translate('city') }}</label>
                            <md-select v-model="location.city.id" id="cities">
                                <md-option v-for="city in cities" :key="city.id" :value="city.id">{{city.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label for="locations">{{ Translate('parent.location') }}</label>
                            <md-select v-model="location.parent.id" id="locations">
                                <md-option v-for="location in locations" :key="location.id" :value="location.id">{{location.name}}</md-option>
                            </md-select>
                            <span class="md-helper-text">{{ Translate('optional') }}</span>
                        </md-field>

                        <md-field>
                            <label for="locationType">{{ Translate('location.type') }}</label>
                            <md-select v-model="location.type.id" id="locationType">
                                <md-option v-for="type in types" :key="type.id" :value="type.id">{{type.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('name') }}</label>
                            <md-input v-model="location.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('coordinate') }}</label>
                            <md-input v-model="location.metadatas.coordinate"></md-input>
                            <span class="md-helper-text">{{ Translate('optional') }}. {{ Translate('coordinate.example') }}</span>
                        </md-field>

                        <md-field v-if="location.type.id == 12 || location.type.id == 13">
                            <label>{{ Translate('capacity') }}</label>
                            <md-input v-model="location.metadatas.capacity"></md-input>
                        </md-field>

                        <md-field v-if="location.type.id == 13">
                            <label>Harvesting at</label>
                            <md-input v-model="location.metadatas.harvesting_at" id="harvestingAt"></md-input>
                        </md-field>

                        <md-field v-if="location.type.id == 13">
                            <label>Feed Time</label>
                            <md-input v-model="location.metadatas.feed_time_per_day"></md-input>
                            <span class="md-suffix">Per Day</span>
                        </md-field>

                        <md-field v-if="location.type.id == 15">
                            <label>No. of Tunnels</label>
                            <md-input v-model="location.metadatas.tunnels_count"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('description') }}</label>
                            <md-textarea v-model="location.description"></md-textarea>
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
                        
                    </md-card-content>
                    <md-card-actions>
                        <md-button class="md-raised md-primary" @click="saveLocation">{{ Translate('save') }}</md-button>
                    </md-card-actions>
                </md-card>
            </div>
        </div>

        <date-picker
            v-model="location.metadatas.harvesting_at"
            type="datetime"
            element="harvestingAt">
        </date-picker>

    </form>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'

export default {
    data: () => ({
        location: {
            name: '',
            type: {
                id: 0
            },
            parent: {
                id: 0
            },
            city: {
                id: 0
            },
            description: '',
            metadatas: {
                coordinate: '',
                capacity: null,
                harvesting_at: null,
                feed_time_per_day: null,
                tunnels_count: null,
            }
        },

        cities: [],
        locations: [],
        types: []
    }),

    created() {

        this.setPageTitle(this.Translate('add.location'))

        Vue.axios.get('cities').then((response) => {
            this.cities = response.data
        })

        Vue.axios.get('locations').then((response) => {
            this.locations = response.data
        })

        Vue.axios.get('types/?model=location').then((response) => {
            this.types = response.data
        })

    },

    methods: {
        saveLocation () {
            Vue.axios.post('locations/add', this.location)
                .then((response) => {
                    this.setSnackbarText('Location added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/locations/' + response.data.hashid)
                })
                .catch((response) => {

                })
        },

        ...mapMutations([
            'setPageTitle',
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}
</script>