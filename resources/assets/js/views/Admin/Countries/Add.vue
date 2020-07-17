<template>
    <form>
        <div class="countries countries-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>Name</label>
                            <md-input v-model="country.name"></md-input>
                        </md-field>

                        <md-field class="md-size-50">
                            <label>Locale</label>
                            <md-input v-model="country.locale"></md-input>
                            <span class="md-helper-text">Optional. Example: ir</span>
                        </md-field>

                        <md-field>
                            <label>Description</label>
                            <md-textarea v-model="country.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveCountry">Save</md-button>
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
            title: 'Add Country'
        },

        country: {
            name: '',
            locale: '',
            description: '',
            metadatas: {
            }
        },
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

    },

    methods: {
        saveCountry () {
            Vue.axios.post('countries/add', this.country)
                .then((response) => {
                    this.setSnackbarText('Country added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/countries/' + response.data.hashid)
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