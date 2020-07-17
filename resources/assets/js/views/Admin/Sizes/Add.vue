<template>
    <form>
        <div class="sizes sizes-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>Name</label>
                            <md-input v-model="size.name"></md-input>
                        </md-field>

                        <md-field>
                            <label for="sizeableType">Use for</label>
                            <md-select v-model="size.sizeable_type" id="sizeableType">
                                <md-option value="App\Models\Package">Package</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>Description</label>
                            <md-textarea v-model="size.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveSize">Save</md-button>
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
            title: 'Add Size'
        },

        size: {
            name: '',
            sizeable_type: 'App\\Models\\Package',
            description: '',
            metadatas: {
            }
        },
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

    },

    methods: {
        saveSize () {
            Vue.axios.post('sizes/add', this.size)
                .then((response) => {
                    this.setSnackbarText('Size added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/sizes/' + response.data.hashid)
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