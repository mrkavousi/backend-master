<template>
    <form>
        <div class="packages packages-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>Name</label>
                            <md-input v-model="pack.name"></md-input>
                        </md-field>

                        <md-field v-if="sizes">
                            <label for="size">Size</label>
                            <md-select v-model="pack.size.id" id="size">
                                <md-option v-for="size in sizes" :key="size.id" :value="size.id">{{size.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="weights">
                            <label for="weight">Weight</label>
                            <md-select v-model="pack.weight.id" id="weight">
                                <md-option v-for="weight in weights" :key="weight.id" :value="weight.id">{{weight.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="grades">
                            <label for="grade">Grade</label>
                            <md-select v-model="pack.grade.id" id="grade">
                                <md-option v-for="grade in grades" :key="grade.id" :value="grade.id">{{grade.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>Description</label>
                            <md-textarea v-model="pack.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="savePackage">Save</md-button>
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
            title: 'Add Package'
        },

        pack: {
            name: '',
            size: {
                id: 0
            },
            weight: {
                id: 0
            },
            grade: {
                id: 0
            },
            description: '',
            metadatas: {
            }
        },

        sizes: [],
        weights: [],
        grades: []
    }),

    created() {

        this.$emit('pageDataUpdate', this.page)

        Vue.axios.get('sizes').then((response) => {
            this.sizes = response.data
        })

        Vue.axios.get('weights').then((response) => {
            this.weights = response.data
        })

        Vue.axios.get('grades').then((response) => {
            this.grades = response.data
        })

    },

    methods: {
        savePackage () {
            Vue.axios.post('packages/add', this.pack)
                .then((response) => {
                    this.setSnackbarText('Package added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/packages/' + response.data.hashid)
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