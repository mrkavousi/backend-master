<template>
    <form>
        <div class="weights weights-edit md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>Name</label>
                            <md-input v-model="weight.name"></md-input>
                        </md-field>

                        <md-field>
                            <label for="weightableType">Use for</label>
                            <md-select v-model="weight.weightable_type" id="weightableType">
                                <md-option value="App\Models\Package">Package</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>Gross Weight</label>
                            <md-input v-model="weight.gross_weight"></md-input>
                            <span class="md-suffix">g</span>
                        </md-field>

                        <md-field>
                            <label>Net Weight</label>
                            <md-input v-model="weight.net_weight"></md-input>
                            <span class="md-suffix">g</span>
                        </md-field>

                        <md-field>
                            <label>Description</label>
                            <md-textarea v-model="weight.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveWeight">Save</md-button>
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
            title: 'Edit Weight'
        },

        weight: {
            name: '',
            weightable_type: 'App\\Models\\Package',
            gross_weight: 0,
            net_weight: 0,
            description: '',
            metadatas: {
            }
        },
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

        Vue.axios.get('weights/' + this.$route.params.hashid).then((response) => {
            this.weight = response.data
        })

    },

    methods: {
        saveWeight () {
            Vue.axios.put('weights/' + this.$route.params.hashid, this.weight)
                .then((response) => {
                    this.setSnackbarText('Weight updated successfully')
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