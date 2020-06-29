<template>
    <form>
        <div class="merchandises merchandises-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>Name</label>
                            <md-input v-model="merchandise.name"></md-input>
                        </md-field>

                        <md-field>
                            <label for="merchandiseType">Merchandise Type</label>
                            <md-select v-model="merchandise.type.id" id="merchandiseType">
                                <md-option v-for="type in types" :key="type.id" :value="type.id">{{type.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label for="location">Location</label>
                            <md-select v-model="merchandise.location.id" id="location">
                                <md-option v-for="location in locations" :key="location.id" :value="location.id">{{location.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>Quantity</label>
                            <md-input v-model="merchandise.quantity"></md-input>
                        </md-field>

                        <md-field>
                            <label>Description</label>
                            <md-textarea v-model="merchandise.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveMerchandise">Save</md-button>
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
            title: 'Add Merchandise'
        },

        merchandise: {
            type: {
                id: 0
            },
            location: {
                id: 0
            },
            name: '',
            description: '',
            metadatas: {

            }
        },

        types: [],
        locations: [],
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

        Vue.axios.get('types/?model=merchandise').then((response) => {
            this.types = response.data
        })

        Vue.axios.get('locations').then((response) => {
            this.locations = response.data
        })

    },

    methods: {
        saveMerchandise () {
            Vue.axios.post('merchandises/add', this.merchandise)
                .then((response) => {
                    this.setSnackbarText('Merchandise added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/merchandises/' + response.data.hashid)
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