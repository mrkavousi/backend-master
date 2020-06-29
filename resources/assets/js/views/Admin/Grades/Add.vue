<template>
    <form>
        <div class="grades grades-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>Name</label>
                            <md-input v-model="grade.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>Description</label>
                            <md-textarea v-model="grade.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveGrade">Save</md-button>
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
            title: 'Add Grade'
        },

        grade: {
            name: '',
            description: '',
            metadatas: {
            }
        },
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

    },

    methods: {
        saveGrade () {
            Vue.axios.post('grades/add', this.grade)
                .then((response) => {
                    this.setSnackbarText('Grade added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/grades/' + response.data.hashid)
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