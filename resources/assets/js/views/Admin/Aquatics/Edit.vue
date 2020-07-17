<template>
    <form>
        <div class="aquatics aquatics-edit md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>{{ Translate('name') }}</label>
                            <md-input v-model="aquatic.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('description') }}</label>
                            <md-textarea v-model="aquatic.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveAquatic">{{ Translate('save') }}</md-button>
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
        aquatic: {
            name: '',
            description: '',
            metadatas: {
            }
        },
    }),

    created() {
        Vue.axios.get('aquatics/' + this.$route.params.hashid).then((response) => {
            this.aquatic = response.data
            this.setPageTitle(this.Translate('edit.aquatic', {'name': this.aquatic.name}))
        })
    },

    methods: {
        saveAquatic () {
            Vue.axios.put('aquatics/' + this.$route.params.hashid, this.aquatic)
                .then((response) => {
                    this.setSnackbarText(this.Translate('aquatic.updated.successfully'))
                    this.setSnackbarShow(true)
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