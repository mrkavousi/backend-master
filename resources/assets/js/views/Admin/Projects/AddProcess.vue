<template>
    <form>
        <div class="processes processes-add project-process-add md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <p v-if="project">{{ Translate('you.adding.process.project') }}: <b><router-link :to="'/projects/' + project.hashid">{{project.name}}</router-link></b></p>

                        <md-field>
                            <label>{{ Translate('name') }}</label>
                            <md-input v-model="process.metadatas.name"></md-input>
                            <span class="md-helper-text">{{ Translate('optional') }}</span>
                        </md-field>


                        <md-field>
                            <label for="processType">{{ Translate('process.type') }}</label>
                            <md-select v-model="process.type.id" id="processType">
                                <md-option v-for="type in types" :key="type.id" :value="type.id">{{ Translate(type.slug) }}</md-option>
                            </md-select>
                        </md-field>


                        <md-field v-if="project">
                            <label for="processable">{{ Translate('project') }}</label>
                            <md-select v-model="project.hashid" @md-selected="setProject" id="processable">
                                <md-option v-for="m in projects" :key="m.id" :value="m.hashid">{{m.name}}</md-option>
                            </md-select>
                        </md-field>


                        <!-- <md-field v-if="process.type.id == 1 || process.type.id == 2">
                            <label for="from">From</label>
                            <md-select v-model="process.from.id" id="from">
                                <md-option v-for="location in locations" :key="location.id" :value="location.id">{{location.name}}</md-option>
                            </md-select>
                        </md-field> -->

                        <md-field v-if="process.type.id == 1 || process.type.id == 4 || process.type.id == 5 || process.type.id == 6 || process.type.id == 7 || process.type.id == 8 || process.type.id == 24">
                            <label for="location">{{ Translate('current.location') }}</label>
                            <md-select v-model="process.location.id" id="location">
                                <md-option v-for="location in locations" :key="location.id" :value="location.id">{{location.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="process.type.id == 1">
                            <label for="to">{{ Translate('to') }}</label>
                            <md-select v-model="process.to.id" id="to">
                                <md-option v-for="location in locations" :key="location.id" :value="location.id">{{location.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="process.type.id == 1">
                            <label for="vehicle">{{ Translate('vehicle') }}</label>
                            <md-select v-model="process.vehicle.id" id="vehicle">
                                <md-option v-for="vehicle in vehicles" :key="vehicle.id" :value="vehicle.id">{{vehicle.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="process.type.id == 1 && process.vehicle.id">
                            <label for="driver">{{ Translate('driver') }}</label>
                            <md-select v-model="process.driver.id" id="driver">
                                <md-option v-for="driver in drivers" :key="driver.id" :value="driver.id">{{driver.metadatas.name}}</md-option>
                            </md-select>
                        </md-field>


                        <md-field v-if="process.type.id == 34 || process.type.id == 35">
                            <label for="tunnel">{{ Translate('tunnel') }}</label>
                            <md-select v-model="process.location.id" id="tunnel">
                                <md-option v-for="location in locations" :key="location.id" :value="location.id">{{location.name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="process.type.id == 34">
                            <label>{{ Translate('pallet') }}</label>
                            <md-input v-model="process.metadatas.pallet"></md-input>
                        </md-field>
                        
                        <md-field v-if="process.type.id == 34">
                            <label>{{ Translate('trolley') }}</label>
                            <md-input v-model="process.metadatas.trolley"></md-input>
                        </md-field>


                        <md-field v-if="process.type.id == 33">
                            <label>{{ Translate('trolley.quantity') }}</label>
                            <md-input v-model="process.metadatas.trolley_quantity"></md-input>
                        </md-field>

                        <md-field v-if="process.type.id == 33">
                            <label>{{ Translate('pallet.quantity') }}</label>
                            <md-input v-model="process.metadatas.pallet_quantity"></md-input>
                        </md-field>


                        <md-field v-if="process.type.id == 2">
                            <label for="sends">{{ Translate('assign.sending.process') }}</label>
                            <md-select v-model="process.metadatas.send_process" id="sends">
                                <md-option v-for="send in sends" :key="send.id" :value="send.id">{{send.metadatas.name || 'Untitled'}} ({{send.hashid}})</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="process.type.id == 3">
                            <label for="deliveries">{{ Translate('assign.delivering.process') }}</label>
                            <md-select v-model="process.metadatas.delivery_process" id="deliveries">
                                <md-option v-for="delivery in deliveries" :key="delivery.id" :value="delivery.id">{{delivery.metadatas.name || 'Untitled'}} ({{delivery.hashid}})</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="process.type.id == 4 || process.type.id == 5 || process.type.id == 6 || process.type.id == 7 || process.type.id == 8 || process.type.id == 24 || process.type.id == 25 || process.type.id == 29 || process.type.id == 31 || process.type.id == 32 || process.type.id == 33 || process.type.id == 34">
                            <label for="unloads">{{ Translate('assign.unloading.process') }}</label>
                            <md-select v-model="process.metadatas.unload_process" id="unloads">
                                <md-option v-for="unload in unloads" :key="unload.id" :value="unload.id">{{unload.metadatas.name || 'Untitled'}} ({{unload.hashid}})</md-option>
                            </md-select>
                        </md-field>

                        <md-field v-if="process.type.id == 35">
                            <label for="unloads">{{ Translate('assign.frosting.process') }}</label>
                            <md-select v-model="process.metadatas.frost_process" id="unloads">
                                <md-option v-for="frost in frosts" :key="frost.id" :value="frost.id">{{frost.metadatas.name || 'Untitled'}} ({{frost.hashid}})</md-option>
                            </md-select>
                        </md-field>


                        <md-field v-if="process.type.id == 1 || process.type.id == 3">
                            <label>{{ Translate('basket.quantity') }}</label>
                            <md-input v-model="process.metadatas.basket_quantity"></md-input>
                        </md-field>

                        <md-field v-if="process.type.id == 1 || process.type.id == 3">
                            <label>{{ Translate('unilit.quantity') }}</label>
                            <md-input v-model="process.metadatas.unilit_quantity"></md-input>
                        </md-field>


                        <md-field v-if="process.type.id == 25">
                            <label>{{ Translate('color') }}</label>
                            <md-input v-model="process.metadatas.color"></md-input>
                        </md-field>


                        <md-field v-if="process.type.id == 3 || process.type.id == 4 || process.type.id == 5 || process.type.id == 6 || process.type.id == 7 || process.type.id == 8">
                            <label>{{ Translate('total.weight') }}</label>
                            <md-input v-model="process.metadatas.total_weight"></md-input>
                            <span class="md-suffix">{{ Translate('kg') }}</span>
                        </md-field>


                        <md-field v-if="process.type.id == 33">
                            <label>{{ Translate('started.at') }}</label>
                            <md-input v-model="process.metadatas.started_at" id="startedAt"></md-input>
                            <md-button @click="startedAtDateTimePickerShow=true" class="md-icon-button md-primary">
                                <md-icon>event</md-icon>
                            </md-button>
                        </md-field>

                        <md-field v-if="process.type.id == 33">
                            <label>{{ Translate('ended.at') }}</label>
                            <md-input v-model="process.metadatas.ended_at" id="endedAt"></md-input>
                            <md-button @click="endedAtDateTimePickerShow=true" class="md-icon-button md-primary">
                                <md-icon>event</md-icon>
                            </md-button>
                        </md-field>


                        <md-field v-if="process.type.id == 6 || process.type.id == 24 || process.type.id == 33">
                            <label>{{ Translate('temprature') }}</label>
                            <md-input v-model="process.metadatas.temprature"></md-input>
                            <span class="md-suffix">°C</span>
                        </md-field>

                        <md-field v-if="process.type.id == 6">
                            <label>{{ Translate('duration') }}</label>
                            <md-input v-model="process.metadatas.duration"></md-input>
                            <span class="md-suffix">{{ Translate('in.minutes') }}</span>
                        </md-field>


                        <md-field v-if="process.type.id == 23">
                            <label>Male Count</label>
                            <md-input v-model="process.metadatas.male_count"></md-input>
                        </md-field>

                        <md-field v-if="process.type.id == 23">
                            <label>Female Count</label>
                            <md-input v-model="process.metadatas.female_count"></md-input>
                        </md-field>


                        <md-field v-if="process.type.id == 25">
                            <label for="sizes">{{ Translate('size') }}</label>
                            <md-select v-model="process.metadatas.size" id="sizes">
                                <md-option v-for="size in sizes" :key="size.id" :value="size.id">{{size.name}}</md-option>
                            </md-select>
                        </md-field>


                        <md-field v-if="process.type.id == 25">
                            <label for="grades">{{ Translate('grade') }}</label>
                            <md-select v-model="process.metadatas.grade" id="grades">
                                <md-option v-for="grade in grades" :key="grade.id" :value="grade.id">{{grade.name}}</md-option>
                            </md-select>
                        </md-field>


                        <md-field v-if="process.type.id == 25">
                            <label>Black spot</label>
                            <md-input v-model="process.metadatas.black_spot"></md-input>
                        </md-field>

                        <md-field v-if="process.type.id == 25">
                            <label>Red head</label>
                            <md-input v-model="process.metadatas.red_head"></md-input>
                        </md-field>

                        <md-field v-if="process.type.id == 25">
                            <label>Half soft-shell</label>
                            <md-input v-model="process.metadatas.half_soft_shell"></md-input>
                        </md-field>

                        <md-field v-if="process.type.id == 25">
                            <label>Soft-shell</label>
                            <md-input v-model="process.metadatas.soft_shell"></md-input>
                        </md-field>

                        <md-field v-if="process.type.id == 25">
                            <label>Weight of 2 big shrimp</label>
                            <md-input v-model="process.metadatas.weight_2big"></md-input>
                            <span class="md-suffix">g</span>
                        </md-field>

                        <md-field v-if="process.type.id == 25">
                            <label>Weight of 10 small shrimp</label>
                            <md-input v-model="process.metadatas.weight_10small"></md-input>
                            <span class="md-suffix">g</span>
                        </md-field>

                        <md-field v-if="process.type.id == 25">
                            <label>Weight of 2kg shrimp</label>
                            <md-input v-model="process.metadatas.weight_2kg_after_2min_water_washing"></md-input>
                            <span class="md-suffix">g</span>
                            <span class="md-helper-text">After 2 minute water-washing</span>
                        </md-field>

                        <md-field v-if="process.type.id == 25">
                            <label>No. Of Shrimp in 1 Kg</label>
                            <md-input v-model="process.metadatas.no_in_1kg"></md-input>
                        </md-field>

                        <md-field v-if="process.type.id == 25">
                            <label>No. Of Total shrimp in 2kg basket</label>
                            <md-input v-model="process.metadatas.no_total_2kg_basket"></md-input>
                        </md-field>


                        <div v-if="process.type.id == 34">
                            <div class="md-layout md-alignment-center-space-between" v-for="(pack, index) in process.packages" :key="index">
                                <md-field class="md-layout-item md-size-20">
                                    <label>{{ Translate('floor') }}</label>
                                    <md-input v-model="pack.pivot.floor"></md-input>
                                    <span class="md-helper-text">Optional</span>
                                </md-field>
                                
                                <md-field class="md-layout-item md-size-40">
                                    <label>{{ Translate('package') }}</label>
                                    <md-select v-model="pack.id">
                                        <md-option v-for="p in packages" :key="p.id" :value="p.id">{{p.name}}</md-option>
                                    </md-select>
                                </md-field>

                                <md-field class="md-layout-item md-size-20">
                                    <label>{{ Translate('quantity') }}</label>
                                    <md-input v-model="pack.pivot.quantity"></md-input>
                                </md-field>

                                <div class="md-layout-item md-size-10">
                                    <md-button class="md-icon-button md-dense md-primary" @click="removePackage(index)">
                                        <md-icon>close</md-icon>
                                    </md-button>
                                </div>
                            </div>
                        </div>


                        <div v-if="process.type.id == 7 || process.type.id == 8 || process.type.id == 35">
                            <br>
                            <h5>{{ Translate('final.packages') }}</h5>
                            <p>{{ Translate('add.output.packages.storage.specify.unload') }}</p>
                        </div>

                        <div v-if="process.type.id == 7 || process.type.id == 8 || process.type.id == 35">
                            <div class="md-layout md-alignment-center-space-between" v-for="(pack, index) in process.packages" :key="index">

                                <md-field class="md-layout-item md-size-20 md-small-size-65">
                                    <label>{{ Translate('package') }}</label>
                                    <md-select v-model="pack.id">
                                        <md-option v-for="p in packages" :key="p.id" :value="p.id">{{p.name}}</md-option>
                                    </md-select>
                                </md-field>

                                <md-field class="md-layout-item md-size-10 md-small-size-30">
                                    <label>{{ Translate('quantity') }}</label>
                                    <md-input v-model="pack.pivot.quantity"></md-input>
                                </md-field>

                                <md-field class="md-layout-item md-size-30 md-small-size-50">
                                    <label for="packageUnloads">{{ Translate('assign.unloading.process') }}</label>
                                    <md-select v-model="pack.pivot.unload_id" id="packageUnloads">
                                        <md-option v-for="unload in unloads" :key="unload.id" :value="unload.id">{{unload.metadatas.name || 'Untitled'}} ({{unload.hashid}})</md-option>
                                    </md-select>
                                </md-field>

                                <md-field class="md-layout-item md-size-20 md-small-size-30">
                                    <label for="storage">{{ Translate('storage') }}</label>
                                    <md-select v-model="pack.pivot.storage_id" id="storage">
                                        <md-option v-for="location in locations" :key="location.id" :value="location.id">{{location.name}}</md-option>
                                    </md-select>
                                </md-field>

                                <div class="md-layout-item md-size-10 md-small-size-10">
                                    <md-button class="md-icon-button md-dense md-primary" @click="removePackage(index)">
                                        <md-icon>close</md-icon>
                                    </md-button>
                                </div>
                                
                            </div>
                        </div>
                        

                        <md-button v-if="process.type.id == 7 || process.type.id == 8 || process.type.id == 34  || process.type.id == 35" class="md-primary m-0 mb-3" @click="addAnotherPackage">
                            <md-icon>add</md-icon>
                            {{ Translate('add.another.package') }}
                        </md-button>


                        <md-field>
                            <label>{{ Translate('description') }}</label>
                            <md-textarea v-model="process.metadatas.description"></md-textarea>
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
                        <md-field>
                            <label for="processStatus">{{ Translate('process.status') }}</label>
                            <md-select v-model="process.status" name="status" id="processStatus">
                                <md-option value="0">{{ Translate('upcoming') }}</md-option>
                                <md-option value="1">{{ Translate('doing') }}</md-option>
                                <md-option value="2">{{ Translate('done') }}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('done.at') }}</label>
                            <md-input v-model="process.metadatas.done_at" id="doneAt"></md-input>
                            <md-button @click="dateTimePickerShow=true" class="md-icon-button md-primary">
                                <md-icon>event</md-icon>
                            </md-button>
                        </md-field>
                    </md-card-content>
                    <md-card-actions>
                        <md-button class="md-raised md-primary" @click="saveProcess">{{ Translate('save') }}</md-button>
                    </md-card-actions>
                </md-card>
            </div>
        </div>

        <date-picker
            v-model="process.metadatas.done_at"
            type="datetime"
            element="doneAt"
            :show="dateTimePickerShow"
            @close="dateTimePickerShow=false">
        </date-picker>

        <date-picker
            v-model="process.metadatas.started_at"
            type="datetime"
            element="startedAt"
            :show="startedAtDateTimePickerShow"
            @close="startedAtDateTimePickerShow=false">
        </date-picker>

        <date-picker
            v-model="process.metadatas.ended_at"
            type="datetime"
            element="endedAt"
            :show="endedAtDateTimePickerShow"
            @close="endedAtDateTimePickerShow=false">
        </date-picker>

    </form>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'

var _ = require('lodash')

export default {
    data: () => ({
        process: {
            type: {
                id: 0
            },
            from: {
                id: 0
            },
            to: {
                id: 0
            },
            vehicle: {
                id: 0
            },
            driver: {
                id: 0
            },
            location: {
                id: 0
            },
            packages: [
                {
                    id: 0,
                    pivot: {
                        quantity: 0,
                        floor: null,
                        unload_id: null,
                        storage_id: null
                    }
                }
            ],
            metadatas: {
                name: null,
                description: null,
                total_weight: '',
                basket_quantity: null,
                unilit_quantity: null,
                color: null,
                temprature: '',
                duration: '',
                black_spot: null,
                red_head: null,
                half_soft_shell: null,
                soft_shell: null,
                weight_2big: null,
                weight_10small: null,
                weight_2kg_after_2min_water_washing: null,
                no_in_1kg: null,
                no_total_2kg_basket: null,
                male_count: null,
                female_count: null,
                send_process: null,
                delivery_process: null,
                unload_process: null,
                started_at: null,
                ended_at: null,
                done_at: null,
                size: null,
                grade: null,
                trolley: null,
                pallet: null,
                trolley_quantity: null,
                pallet_quantity: null,
                frost_process: null,
            },
            status: 0
        },

        projects: [],
        project: null,
        sends: [],
        deliveries: [],
        unloads: [],
        frosts: [],
        types: [],
        locations: [],
        vehicles: [],
        drivers: [],
        packages: [],
        sizes: [],
        grades: [],

        dateTimePickerShow: false,
        startedAtDateTimePickerShow: false,
        endedAtDateTimePickerShow: false,
    }),

    created() {

        this.setPageTitle(this.Translate('add.process'))

        Vue.axios.get('types/?model=process&use_for=project&for=add').then((response) => {
            this.types = _.orderBy(response.data, 'name')
            if (this.$auth.user().roles[0].name == 'census') {
                var typesForCensus = []
                var typesProcessed = 0
                var self = this
                this.types.forEach(function (type, index, object) {
                    typesProcessed++
                    if (type.id == 2 || type.id == 3 || type.id == 34 || type.id == 35) {
                        typesForCensus.push(type)
                    }
                    if (typesProcessed === self.types.length) {
                        self.types = typesForCensus
                    }
                })
            }

            if (this.$auth.user().roles[0].name == 'storage-observer') {
                var typesForStorageObserver = []
                var typesProcessed = 0
                var self = this
                this.types.forEach(function (type, index, object) {
                    typesProcessed++
                    if (type.id == 35) {
                        typesForStorageObserver.push(type)
                    }
                    if (typesProcessed === self.types.length) {
                        self.types = typesForStorageObserver
                    }
                })
            }

            if (this.$auth.user().roles[0].name == 'recipient') {
                var typesForRecipient = []
                var typesProcessed = 0
                var self = this
                this.types.forEach(function (type, index, object) {
                    typesProcessed++
                    if (type.id == 1 || type.id == 2) {
                        typesForRecipient.push(type)
                    }
                    if (typesProcessed === self.types.length) {
                        self.types = typesForRecipient
                    }
                })
            }

        })

        Vue.axios.get('projects/' + this.$route.params.projectHashid + '/1').then((response) => {
            this.sends = response.data
        })

        Vue.axios.get('projects/' + this.$route.params.projectHashid + '/2').then((response) => {
            this.deliveries = response.data
        })

        Vue.axios.get('projects/' + this.$route.params.projectHashid + '/3').then((response) => {
            this.unloads = response.data
        })

        Vue.axios.get('projects/' + this.$route.params.projectHashid + '/33').then((response) => {
            this.frosts = response.data
        })

        Vue.axios.get('projects').then((response) => {
            this.projects = response.data.data
        })

        Vue.axios.get('locations').then((response) => {
            this.locations = response.data
        })

        Vue.axios.get('vehicles').then((response) => {
            this.vehicles = response.data
        })

        Vue.axios.get('drivers').then((response) => {
            this.drivers = response.data
        })

        Vue.axios.get('packages').then((response) => {
            this.packages = response.data
        })

        Vue.axios.get('sizes').then((response) => {
            this.sizes = response.data
        })

        Vue.axios.get('grades').then((response) => {
            this.grades = response.data
        })

        this.setProject(this.$route.params.projectHashid)

    },

    methods: {
        saveProcess () {
            Vue.axios.post('processes/add/?model=project&processable=' + this.project.hashid, this.process)
                .then((response) => {
                    this.setSnackbarText('Process added successfully')
                    this.setSnackbarShow(true)
                    this.$router.push('/projects/' + this.project.hashid)
                })
                .catch((response) => {

                })
        },

        setProject (projectHashid) {
            if (projectHashid) {
                Vue.axios.get('projects/' + projectHashid).then((response) => {
                    this.project = response.data
                })
            }
        },

        addAnotherPackage () {
            this.process.packages.push({
                id: 0,
                pivot: {
                    quantity: 0,
                    floor: null,
                    unload_id: null,
                    storage_id: null
                }
            })
        },

        removePackage (index) {
            this.process.packages.splice(index, 1)
        },

        ...mapMutations([
            'setPageTitle',
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}
</script>