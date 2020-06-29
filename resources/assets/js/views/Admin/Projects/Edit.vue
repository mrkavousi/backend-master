<template>
    <form>
        <div class="projects projects-edit">

            <md-tabs>
                <md-tab id="tab-overview" :md-label="Translate('overview')">
                    <div class="md-layout">
                        <div v-if="packageSummaries" class="md-layout-item md-size-100">
                            <md-card>
                                <md-card-header>
                                    <md-card-header-text>
                                        <div class="md-title">{{ Translate('packages.summary') }}</div>
                                    </md-card-header-text>
                                </md-card-header>

                                <md-card-content class="chart-wrapper md-layout md-alignment-center-left">
                                    <div class="md-layout-item md-small-size-100 md-medium-size-40 md-large-size-30">
                                        <md-list>
                                            <md-list-item v-for="(pack, index) in packageSummaries" :key="pack.package.id">
                                                <div>
                                                    <p>{{index + 1}}. <router-link :to="'/packages/' + pack.package.hashid">{{pack.package.name}}</router-link>: <b>{{pack.quantity}}</b></p>
                                                </div>
                                            </md-list-item>
                                            <md-list-item>
                                                <div>
                                                    <p>{{ Translate('total') }}: <b>{{packageSummaries.sum('quantity')}}</b></p>
                                                </div>
                                            </md-list-item>
                                        </md-list>
                                    </div>
                                    
                                    <div class="md-layout-item md-small-size-100 md-medium-size-40 md-large-size-30">
                                        <doughnut-chart :chart-data="reportPackagesSummaryData" :options="reportPackagesSummaryChartOptions"></doughnut-chart>
                                    </div>
                                </md-card-content>
                            </md-card>
                        </div>

                        <div class="md-layout-item md-size-100">
                            <md-card class="md-primary">
                                <md-card-header>
                                    <md-card-header-text>
                                        <div class="md-title">{{ Translate('all.processes') }}</div>
                                        <div class="md-subhead" v-if="!project.processes.length">{{ Translate('there.is.no.process.add') }}</div>
                                    </md-card-header-text>
                                </md-card-header>

                                <md-card-actions>
                                    <md-menu md-direction="bottom-end">
                                        <md-button md-menu-trigger>
                                            <md-icon>more_vert</md-icon>
                                            {{ Translate('download') }}
                                        </md-button>

                                        <md-menu-content>
                                            <md-menu-item @click="exportProcesses(24)">{{ Translate('temperaturing.report') }}</md-menu-item>
                                            <md-menu-item @click="exportProcesses(25)">{{ Translate('quality.controlling.report') }}</md-menu-item>
                                        </md-menu-content>
                                    </md-menu>

                                    <md-button :to="'/projects/' + $route.params.hashid + '/processes/add'">
                                        <md-icon>add</md-icon>
                                        {{ Translate('add.process') }}
                                    </md-button>
                                </md-card-actions>
                            </md-card>
                        </div>

                        <div class="md-layout-item md-size-100">
                            <md-card>
                                <md-card-content>
                                    <md-field>
                                        <label for="processType">{{ Translate('process.type') }}</label>
                                        <md-select v-model="selectedProcessType" @md-selected="filterProcesses" id="processType">
                                            <md-option :value="0">{{ Translate('all.types') }}</md-option>
                                            <md-option v-for="type in processTypes" :key="type.id" :value="type.id">{{ Translate(type.slug) }}</md-option>
                                        </md-select>
                                    </md-field>

                                    <p>{{filteredProcesses.length}} {{ Translate('results') }}:</p>

                                    
                                        <div v-for="(process, index) in filteredProcesses" :key="index">
                                            
                                            <p><b>{{ Translate(process.type.slug) }}</b> <small>({{process.created_at | moment("from", "now")}}) <md-tooltip md-direction="top">{{process.created_at}}</md-tooltip> - {{ Translate('status') }}: {{getStatusName(process.status)}}</small></p>
                                            
                                            <p v-if="process.metadatas.name">{{ Translate('name') }}: <b>{{process.metadatas.name}}</b></p>
                                            
                                            <p v-if="process.from.id">{{ Translate('from') }}: <b><router-link :to="'/locations/' + process.from.hashid">{{process.from.name}}</router-link></b></p>
                                            <p v-if="process.to.id">{{ Translate('to') }}: <b><router-link :to="'/locations/' + process.to.hashid">{{process.to.name}}</router-link></b></p>
                                            <p v-if="process.location.id">
                                                <span v-if="process.type.id != 34">{{ Translate('current.location') }}: </span>
                                                <span v-if="process.type.id == 34">{{ Translate('tunnel') }}: </span>
                                                <b><router-link :to="'/locations/' + process.location.hashid">{{process.location.name}}</router-link></b>
                                            </p>

                                            <p v-if="process.vehicle.id">{{ Translate('vehicle') }}: <b><router-link :to="'/vehicles/' + process.vehicle.hashid">{{process.vehicle.name}}</router-link></b></p>
                                            
                                            <p v-if="process.driver.id">{{ Translate('driver') }}: <b><router-link :to="'/users/' + process.driver.hashid">{{process.driver.metadatas.name}}</router-link></b></p>
                                            
                                            <p v-if="process.metadatas.total_weight">{{ Translate('total.weight') }}: <b>{{process.metadatas.total_weight}} {{ Translate('kg') }}</b></p>
                                            <p v-if="process.metadatas.package_quantity">{{ Translate('quantity') }}: <b>{{process.metadatas.package_quantity}}</b></p>

                                            <p v-if="process.metadatas.trolley">{{ Translate('trolley') }}: <b>{{process.metadatas.trolley}}</b></p>
                                            <p v-if="process.metadatas.pallet">{{ Translate('pallet') }}: <b>{{process.metadatas.pallet}}</b></p>

                                            <p v-if="process.metadatas.trolley_quantity">{{ Translate('trolly.quantity') }}: <b>{{process.metadatas.trolley_quantity}}</b></p>
                                            <p v-if="process.metadatas.pallet_quantity">{{ Translate('pallet.quantity') }}: <b>{{process.metadatas.pallet_quantity}}</b></p>
                                            
                                            <p v-if="process.metadatas.temprature">{{ Translate('temprature') }}: <b>{{process.metadatas.temprature}}</b> °C</p>
                                            <p v-if="process.metadatas.duration">{{ Translate('duration') }}: <b>{{process.metadatas.duration}}</b> Minutes</p>
                                            
                                            <p v-if="process.size">{{ Translate('size') }}: <b><router-link :to="'/sizes/' + process.size.hashid">{{process.size.name}}</router-link></b></p>

                                            <p v-if="process.grade">{{ Translate('grade') }}: <b><router-link :to="'/grades/' + process.grade.hashid">{{process.grade.name}}</router-link></b></p>
                                            
                                            <p v-if="process.metadatas.black_spot">Black Spot: <b>{{process.metadatas.black_spot}}</b></p>
                                            <p v-if="process.metadatas.red_head">Red head: <b>{{process.metadatas.red_head}}</b></p>
                                            <p v-if="process.metadatas.half_soft_shell">Half soft-shell: <b>{{process.metadatas.half_soft_shell}}</b></p>
                                            <p v-if="process.metadatas.soft_shell">Soft-shell: <b>{{process.metadatas.soft_shell}}</b></p>
                                            <p v-if="process.metadatas.weight_2big_10small">Weight of 2 big shrimp / weight of 10 small: <b>{{process.metadatas.weight_2big_10small}}</b></p>
                                            <p v-if="process.metadatas.weight_2big && process.metadatas.weight_10small">Weight of 2 big shrimp (<b>{{process.metadatas.weight_2big}}</b> g) / weight of 10 small (<b>{{process.metadatas.weight_10small}}</b> g): <b>{{(process.metadatas.weight_2big / process.metadatas.weight_10small).toFixed(3)}}</b> g</p>
                                            <p v-if="process.metadatas.weight_2kg_after_2min_water_washing">Weight of 2kg shrimp after 2 minute water-washing: <b>{{process.metadatas.weight_2kg_after_2min_water_washing}}</b> g</p>
                                            <p v-if="process.metadatas.no_in_1kg">No. Of Shrimp in 1 Kg: <b>{{process.metadatas.no_in_1kg}}</b></p>
                                            <p v-if="process.metadatas.no_total_2kg_basket">No. Of Total shrimp in 2kg basket: <b>{{process.metadatas.no_total_2kg_basket}}</b></p>
                                            
                                            <p v-if="process.metadatas.male_count">Male Count: <b>{{process.metadatas.male_count}}</b></p>
                                            <p v-if="process.metadatas.female_count">Female Count: <b>{{process.metadatas.female_count}}</b></p>
                                            
                                            <p v-if="process.metadatas.send_process">{{ Translate('sending') }}: <b><router-link :to="'/projects/' + project.hashid + '/processes/' + process.sending.hashid">{{process.sending.metadatas.name || 'Untitled'}} ({{process.sending.hashid}})</router-link></b></p>
                                            <p v-if="process.metadatas.delivery_process">{{ Translate('delivering') }}: <b><router-link :to="'/projects/' + project.hashid + '/processes/' + process.delivering.hashid">{{process.delivering.metadatas.name || 'Untitled'}} ({{process.delivering.hashid}})</router-link></b></p>
                                            <p v-if="process.metadatas.unload_process">{{ Translate('unloading') }}: <b><router-link :to="'/projects/' + project.hashid + '/processes/' + process.unloading.hashid">{{process.unloading.metadatas.name || 'Untitled'}} ({{process.unloading.hashid}})</router-link></b></p>
                                            <p v-if="process.metadatas.frost_process">{{ Translate('frosting') }}: <b><router-link :to="'/projects/' + project.hashid + '/processes/' + process.frosting.hashid">{{process.frosting.metadatas.name || 'Untitled'}} ({{process.frosting.hashid}})</router-link></b></p>
                                            
                                            <div v-if="process.packages.length">
                                                <p>{{ Translate('packages') }}:</p>
                                                <div v-for="(pack, index) in process.packages" :key="index">
                                                    <p>
                                                        {{index + 1}}. 
                                                        <span v-if="process.type.id == 34 && pack.pivot.floor">{{ Translate('floor') }} <b>{{pack.pivot.floor}}</b></span> 
                                                        <router-link :to="'/packages/' + pack.hashid">{{pack.name}}</router-link>: <b>{{pack.pivot.quantity}}</b>
                                                        <span v-if="process.type.id == 35 && pack.storage">({{ Translate('storage') }}: <router-link :to="'/locations/' + pack.storage.hashid">{{pack.storage.name}}</router-link> - </span>
                                                        <span v-if="process.type.id == 35 && pack.unload_process">{{ Translate('unload') }}: <router-link :to="'/projects/' + project.hashid + '/processes/' + pack.unload_process.hashid">{{pack.unload_process.metadatas.name}}</router-link>)</span>
                                                    </p>
                                                </div>

                                                <p>Total Packages Quantity: <b>{{process.packages.sum('pivot', 'quantity')}}</b></p>
                                                <p>Total Packages Weight: <b>{{process.total_packages_weight / 1000}} {{ Translate('kg') }}</b></p>
                                            </div>

                                            <p v-if="process.metadatas.description">Description: {{process.metadatas.description}}</p>

                                            <p v-if="process.metadatas.started_at">Started at: <b>{{process.metadatas.started_at}}</b></p>
                                            <p v-if="process.metadatas.ended_at">Ended at: <b>{{process.metadatas.ended_at}}</b></p>
                                            
                                            <p v-if="process.metadatas.done_at">Done at: <b>{{process.metadatas.done_at}}</b></p>

                                            <p v-if="$auth.user().roles[0].name == 'admin'">
                                                <router-link :to="'/projects/' + project.hashid + '/processes/' + process.hashid">{{ Translate('edit') }}</router-link>
                                            </p>

                                            <md-divider></md-divider>
                                        </div>
                                    
                                </md-card-content>
                            </md-card>
                        </div>
                    </div>
                </md-tab>

                <md-tab v-if="$auth.user().roles[0].name == 'admin'" id="tab-edit" :md-label="Translate('edit.project.2')">
                    <div class="md-layout">
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
                </md-tab>
            </md-tabs>
        </div>
    </form>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'
import DoughnutChart from '../../../components/DoughnutChart.vue'

var _ = require('lodash')

export default {
    components: {
        DoughnutChart
    },
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
            processes: [],
            metadatas: {
                total_cost: 0,
                total_weight: 0,
                aquatic: null
            }
        },

        packageSummaries: null,
        reportPackagesSummaryData: null,
        reportPackagesSummaryChartOptions: {
            responsive: true,
            legend: {
                labels: {
                    fontColor: "black"
                }
            }
        },

        packages: [],
        processTypes: [],
        selectedProcessType: 0,
        filteredProcesses: [],
        aquatics: [],
    }),

    created() {

        Vue.axios.get('projects/' + this.$route.params.hashid).then((response) => {
            this.project = response.data
            this.filteredProcesses = this.project.processes.reverse()
            this.setPageTitle(this.Translate('edit.project', {'name': this.project.name}))

            this.project.processes.forEach(function (process) {
                if (process.packages.length) {
                    process.total_packages_weight = 0
                    process.packages.forEach(function (pack) {
                        process.total_packages_weight = process.total_packages_weight + (pack.weight.net_weight * pack.pivot.quantity)
                    })
                }
            })
        })

        Vue.axios.get('projects/' + this.$route.params.hashid + '/reports/packages-summary').then((response) => {
            if (response.data.length) {
                this.packageSummaries = response.data
                this.reportPackagesSummaryData = {
                    labels: response.data.map(pack => pack.package.name),
                    datasets: [
                        {
                            label: this.Translate('package'),
                            backgroundColor: [
                                '#ff5382',
                                '#ff9b18',
                                '#ffcc34',
                                '#00c3c1',
                                '#00a3f1',
                            ],
                            // borderColor: '#424242',
                            data: response.data.map(pack => pack.quantity)
                        }
                    ]
                }
            }
        })

        Vue.axios.get('types/?model=process&use_for=project').then((response) => {
            this.processTypes = _.orderBy(response.data, 'name')
        })

        Vue.axios.get('packages').then((response) => {
            this.packages = response.data
        })

        Vue.axios.get('aquatics').then((response) => {
            this.aquatics = response.data
        })

    },

    methods: {
        saveProject () {
            Vue.axios.put('projects/' + this.$route.params.hashid, this.project)
                .then((response) => {
                    this.setSnackbarText('Project updated successfully')
                    this.setSnackbarShow(true)
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

        getStatusName (status) {
            const statuses = {
                0: this.Translate('upcoming'),
                1: this.Translate('doing'),
                2: this.Translate('done')
            }
            
            return statuses[status]
        },

        filterProcesses (processTypeId) {
            this.filteredProcesses = this.project.processes.filter((proc) => { 
                if (processTypeId == 0 || proc.type.id == processTypeId)
                    return proc
            })
        },

        exportProcesses (type) {
            window.open(Vue.axios.defaults.baseURL + 'projects/' + this.$route.params.hashid + '/' + type + '/export', '_blank')
        },

        ...mapMutations([
            'setPageTitle',
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}

Array.prototype.sum = function (prop, subprob) {
    subprob = subprob || null
    var total = 0
    for ( var i = 0, _len = this.length; i < _len; i++ ) {
        if (subprob)
            total += parseInt(this[i][prop][subprob])
        else
            total += parseInt(this[i][prop])
    }
    return total
}
</script>