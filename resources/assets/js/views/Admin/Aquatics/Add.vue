<template>
    <form>
        <div class="aquatics aquatics-add md-layout">
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
        this.setPageTitle(this.Translate('add.aquatic'))
    },

    methods: {
        saveAquatic () {
            Vue.axios.post('aquatics/add', this.aquatic)
                .then((response) => {
                    this.setSnackbarText(this.Translate('aquatic.added.successfully'))
                    this.setSnackbarShow(true)
                    this.$router.push('/aquatics/' + response.data.hashid)
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