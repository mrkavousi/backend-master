<template>
    <form>
        <div class="cities cities-edit md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field v-if="countries">
                            <label for="countries">Country</label>
                            <md-select v-model="city.country.id" id="countries">
                                <md-option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>Name</label>
                            <md-input v-model="city.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>Description</label>
                            <md-textarea v-model="city.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveCity">Save</md-button>
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
            title: 'Edit City'
        },

        city: {
            name: '',
            country: {
                id: 0
            },
            description: '',
            metadatas: {
            }
        },

        countries: []
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

        Vue.axios.get('countries').then((response) => {
            this.countries = response.data
        })

        Vue.axios.get('cities/' + this.$route.params.hashid).then((response) => {
            this.city = response.data
        })

    },

    methods: {
        saveCity () {
            Vue.axios.put('cities/' + this.$route.params.hashid, this.city)
                .then((response) => {
                    this.setSnackbarText('City updated successfully')
                    this.setSnackbarShow(true)
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