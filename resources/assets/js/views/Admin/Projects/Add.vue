<template>
    <form>
        <div class="projects projects-add md-layout" >
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>{{ Translate('name') }}</label>
                            <md-input v-model="project.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('aquatic') }}</label>
                            <md-select v-model="project.metadatas.aquatic">
                                <md-option @click.native="getNewAquatic">+ {{ Translate('add.new') }}</md-option>
                                <md-option v-for="aquatic in aquatics" :key="aquatic.id" :value="aquatic.id">{{aquatic.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('total.cost') }}</label>
                            <md-input v-model="project.metadatas.total_cost"></md-input>
                            <span class="md-suffix">{{ Translate('money.unit') }}</span>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('total.weight') }}</label>
                            <md-input v-model="project.metadatas.total_weight"></md-input>
                            <span class="md-suffix">{{ Translate('kg') }}</span>
                        </md-field>

                        <h4 class="mb-1 mt-5">{{ Translate('expected.packages') }}</h4>

                        <div class="md-layout md-alignment-center-space-between" v-for="(pack, index) in project.packages" :key="index">
                            <md-field class="md-layout-item md-size-50">
                                <label>{{ Translate('package') }}</label>
                                <md-select v-model="pack.id">
                                    <md-option @click.native="getNewPackage">+ {{ Translate('add.new') }}</md-option>
                                    <md-option v-for="p in packages" :key="p.id" :value="p.id">{{p.name}}</md-option>
                                </md-select>
                            </md-field>

                            <md-field class="md-layout-item md-size-30">
                                <label>{{ Translate('quantity') }}</label>
                                <md-input v-model="pack.pivot.quantity"></md-input>
                            </md-field>

                            <div class="md-layout-item md-size-10">
                                <md-button class="md-icon-button md-dense md-primary" @click="removePackage(index)">
                                    <md-icon>close</md-icon>
                                </md-button>
                            </div>
                        </div>

                        <md-button class="md-primary m-0 mb-3" @click="addAnotherPackage">
                            <md-icon>add</md-icon>
                            {{ Translate('add.another.package') }}
                        </md-button>

                        <md-field>
                            <label>{{ Translate('description') }}</label>
                            <md-textarea v-model="project.description"></md-textarea>
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
                        <md-button class="md-raised md-primary" @click="saveProject">{{ Translate('save') }}</md-button>
                    </md-card-actions>
                </md-card>
            </div>
        </div>
    </form>
</template>

<script>
import Vue from 'vue';
import { mapMutations } from 'vuex'

export default {
    data: () => ({
        project: {
            name: '',
            description: '',
            packages: [
                {
                    id: 0,
                    pivot: {
                        quantity: 0
                    }
                }
            ],
            metadatas: {
                total_cost: 0,
                total_weight: 0,
                aquatic: null
            }
        },

        packages: [],
        aquatics: [],
    }),

    created() {

        this.setPageTitle(this.Translate('add.project'))

        Vue.axios.get('packages').then((response) => {
            this.packages = response.data
        })

        Vue.axios.get('aquatics').then((response) => {
            this.aquatics = response.data
        })

    },

    methods: {
        saveProject () {
            Vue.axios.post('projects/add', this.project)
                .then((response) => {
                    this.setSnackbarText('Project added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/projects/' + response.data.hashid)
                })
                .catch((response) => {

                })
        },

        addAnotherPackage () {
            this.project.packages.push({
                id: 0,
                pivot: {
                    quantity: 0
                }
            })
        },

        removePackage (index) {
            this.project.packages.splice(index, 1)
        },

        getNewAquatic () {
            let routeData = this.$router.resolve({name: 'aquatics.add'})
            window.open(routeData.href, '_blank')
        },

        getNewPackage () {
            let routeData = this.$router.resolve({name: 'packages.add'})
            window.open(routeData.href, '_blank')
        },

        ...mapMutations([
            'setPageTitle',
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}
</script>