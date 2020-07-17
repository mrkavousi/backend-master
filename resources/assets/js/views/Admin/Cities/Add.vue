<template>
    <form>
        <div class="cities cities-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label for="countries">{{ Translate('country') }}</label>
                            <md-select v-model="city.country.id" id="countries">
                                <md-option v-for="country in countries" :key="country.id" :value="country.id">{{country.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('name') }}</label>
                            <md-input v-model="city.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('description') }}</label>
                            <md-textarea v-model="city.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveCity">{{ Translate('save') }}</md-button>
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
            title: 'Add City'
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

    },

    methods: {
        saveCity () {
            Vue.axios.post('cities/add', this.city)
                .then((response) => {
                    this.setSnackbarText('City added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/cities/' + response.data.hashid)
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