<template>
    <form>
        <div class="processes processes-add merchandise-process-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label for="processType">Action Type</label>
                            <md-select v-model="process.type.id" id="processType">
                                <md-option v-for="type in types" :key="type.id" :value="type.id">{{type.name}}</md-option>
                            </md-select>
                        </md-field>


                        <md-field v-if="merchandise">
                            <label for="processable">Merchandise</label>
                            <md-select v-model="merchandise.hashid" @md-selected="setMerchandise" id="processable">
                                <md-option v-for="m in merchandises" :key="m.id" :value="m.hashid">{{m.name}}</md-option>
                            </md-select>
                        </md-field>


                        <md-field v-if="process.type.id == 9 || process.type.id == 10">
                            <label for="location">Location</label>
                            <md-select v-model="process.location.id" id="location">
                                <md-option v-for="location in locations" :key="location.id" :value="location.id">{{location.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="process.type.id == 9 || process.type.id == 10">
                            <label>Quantity</label>
                            <md-input v-model="process.metadatas.quantity"></md-input>
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
                        <md-field>
                            <label for="processStatus">Action Status</label>
                            <md-select v-model="process.status" name="status" id="processStatus">
                                <md-option value="0">Upcoming</md-option>
                                <md-option value="1">Doing</md-option>
                                <md-option value="2">Done</md-option>
                            </md-select>
                        </md-field>
                    </md-card-content>
                    <md-card-actions>
                        <md-button class="md-raised md-primary" @click="saveProcess">Save</md-button>
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
            title: 'Add Action'
        },

        process: {
            type: {
                id: 0
            },
            location: {
                id: 0
            },
            metadatas: {
                quantity: 0
            },
            status: 0
        },

        merchandises: [],
        merchandise: null,
        types: [],
        locations: [],
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

        Vue.axios.get('types/?model=process&use_for=merchandise').then((response) => {
            this.types = response.data
        })

        Vue.axios.get('merchandises').then((response) => {
            this.merchandises = response.data
        })

        Vue.axios.get('locations').then((response) => {
            this.locations = response.data
        })

        this.setMerchandise(this.$route.params.merchandiseHashid)

    },

    methods: {
        saveProcess () {
            Vue.axios.post('processes/add/?model=merchandise&processable=' + this.merchandise.hashid, this.process)
                .then((response) => {
                    this.setSnackbarText('Action added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/merchandises/' + this.merchandise.hashid + '/processes/' + response.data.hashid)
                })
                .catch((response) => {

                })
        },

        setMerchandise (merchandiseHashid) {
            if (merchandiseHashid) {
                Vue.axios.get('merchandises/' + merchandiseHashid).then((response) => {
                    this.merchandise = response.data
                })
            }
        },

        ...mapMutations([
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}
</script>