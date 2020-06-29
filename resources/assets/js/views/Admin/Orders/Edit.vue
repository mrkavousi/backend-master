<template>
    <form>
        <div class="orders orders-edit">

            <md-tabs>
                <md-tab id="tab-overview" :md-label="Translate('overview')">
                    <div class="md-layout">
                        <div class="md-layout-item md-size-100 mb-4">
                            <md-card>
                                <md-card-header>
                                    <md-card-header-text>
                                        <div class="md-title">{{order.name}}</div>
                                    </md-card-header-text>
                                </md-card-header>

                                <md-card-content>
                                    {{order.description}}
                                </md-card-content>
                            </md-card>
                        </div>

                        <div class="md-layout-item md-xsmall-size-100 md-small-size-60 md-large-size-70">
                            <md-card class="md-primary">
                                <md-card-header>
                                    <md-card-header-text>
                                        <div class="md-title">{{ Translate('all.shipments') }}</div>
                                    </md-card-header-text>
                                </md-card-header>

                                <md-card-actions>
                                    <md-button :to="'/orders/' + $route.params.hashid + '/shipments/add'">
                                        <md-icon>add_shopping_cart</md-icon>
                                        {{ Translate('add.shipment') }}
                                    </md-button>
                                </md-card-actions>
                            </md-card>
                            <md-card>
                                <md-card-content>
                                    
                                    <div v-for="(shipment, index) in order.shipments" :key="index">
                                        
                                        <p><small>{{shipment.created_at | moment("from", "now")}} <md-tooltip md-direction="top">{{shipment.created_at}}</md-tooltip> - {{ Translate('status') }}: {{getStatusName(shipment.status)}}</small></p>
                                        
                                        <p v-if="shipment.metadatas.name">{{ Translate('name') }}: <b>{{shipment.metadatas.name}}</b></p>

                                        <p v-if="shipment.vehicle.id">{{ Translate('vehicle') }}: <b><router-link :to="'/vehicles/' + shipment.vehicle.hashid">{{shipment.vehicle.name}}</router-link></b></p>
                                        
                                        <div v-if="shipment.packages.length">
                                            <p>{{ Translate('selected.packages') }}:</p>
                                            <div v-for="(pack, index) in shipment.packages" :key="index">
                                                <p>
                                                    {{index + 1}}. 
                                                    <router-link :to="'/packages/' + pack.source_package.hashid">{{pack.source_package.name}}</router-link>: <b>{{pack.pivot.quantity}}</b>
                                                    <span>({{ Translate('storage') }}: <router-link :to="'/locations/' + pack.storage.hashid">{{pack.storage.name}}</router-link> - </span>
                                                    <span>{{ Translate('unload') }}: <router-link :to="'/projects/' + order.hashid + '/processes/' + pack.unload_process.hashid">{{pack.unload_process.metadatas.name}}</router-link>)</span>
                                                </p>
                                            </div>

                                            <p>{{ Translate('total.selected.packages.quantity') }}: <b>{{shipment.packages.sum('pivot', 'quantity')}}</b></p>
                                            <p>{{ Translate('total.selected.packages.weight') }}: <b>{{shipment.total_packages_weight / 1000}} {{ Translate('kg') }}</b></p>
                                        </div>

                                        <p v-if="shipment.metadatas.description">{{ Translate('description') }}: {{shipment.metadatas.description}}</p>
                                        
                                        <p v-if="shipment.metadatas.done_at">{{ Translate('done.at') }}: <b>{{shipment.metadatas.done_at}}</b></p>

                                        <p v-if="shipment.metadatas.etd">{{ Translate('etd') }}: <b>{{shipment.metadatas.etd}}</b></p>

                                        <p v-if="shipment.metadatas.eta">{{ Translate('eta') }}: <b>{{shipment.metadatas.eta}}</b></p>

                                        <p v-if="$auth.user().roles[0].name == 'admin'">
                                            <router-link :to="'/orders/' + order.hashid + '/shipments/' + shipment.hashid">{{ Translate('edit') }}</router-link>
                                        </p>

                                        <md-divider></md-divider>
                                    </div>
                                    
                                </md-card-content>
                            </md-card>
                        </div>

                        <div class="md-layout-item md-xsmall-size-100 md-small-size-40 md-large-size-30">
                            <md-card class="md-light">
                                <md-card-header>
                                    <md-card-header-text>
                                        <div class="md-title"><md-icon>comment</md-icon> {{ Translate('notes') }}</div>
                                    </md-card-header-text>
                                </md-card-header>

                                <md-card-actions>
                                    <md-button @click="showNoteDialog = true">
                                        <md-icon>add</md-icon>
                                        {{ Translate('new.note') }}
                                    </md-button>
                                </md-card-actions>
                            </md-card>
                            <md-card>
                                <md-card-content>
                                    <div v-for="(note, index) in notes" :key="index" class="notes">
                                        <p class="body"><b class="name">{{note.user.metadatas.name}}</b>: {{note.body}}</p>
                                        
                                        <a v-if="note.attachments.length && isImage(note.attachments[0].url)" :href="note.attachments[0].url" target="_blank">
                                            <img :src="note.attachments[0].url" class="mb-2">
                                        </a>
                                        
                                        <md-button v-if="note.attachments.length && !isImage(note.attachments[0].url)" class="md-primary" @click.native="downloadAttachment(note.attachments[0].url)">
                                            <md-icon>attachment</md-icon>
                                            {{note.attachments[0].path.replace(/^.*[\\\/]/, '').substring(note.attachments[0].path.replace(/^.*[\\\/]/, '').length - 16, note.attachments[0].path.replace(/^.*[\\\/]/, '').length)}}
                                            <template v-if="note.attachments[0].path.replace(/^.*[\\\/]/, '').length > 16">...</template>
                                        </md-button>
                                        
                                        <md-divider></md-divider>
                                    </div>
                                </md-card-content>
                            </md-card>

                            <md-dialog :md-active.sync="showNoteDialog">

                                <md-dialog-title>{{ Translate('new.note') }}</md-dialog-title>
                                
                                <md-dialog-content>
                                    <md-field>
                                        <label>{{ Translate('write.here') }}</label>
                                        <md-textarea v-model="note.body" md-autogrow></md-textarea>
                                    </md-field>

                                    <input
                                        type="file"
                                        class="d-none"
                                        @change="handleFile"
                                        ref="attachmentInput"
                                    />
                                    <md-button class="md-icon-button" @click="chooseFile">
                                        <md-icon>attachment</md-icon>
                                    </md-button>

                                    <md-progress-spinner v-show="attachmentUploadBusy" :md-diameter="30" :md-stroke="3" md-mode="indeterminate"></md-progress-spinner>
                                </md-dialog-content>

                                <md-dialog-actions>
                                    <md-button @click="showNoteDialog = false">{{ Translate('cancel') }}</md-button>
                                    <md-button class="md-primary" @click="saveNote">{{ Translate('save') }}</md-button>
                                </md-dialog-actions>

                            </md-dialog>
                        </div>
                    </div>
                </md-tab>

                <md-tab id="tab-edit" :md-label="Translate('edit.order')">
                    <div class="md-layout">
                        <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                            <md-card>
                                <md-card-content>

                                    <md-field>
                                        <label>{{ Translate('title') }}</label>
                                        <md-input v-model="order.name"></md-input>
                                    </md-field>

                                    <md-field>
                                        <label>{{ Translate('aquatic.type') }}</label>
                                        <md-select v-model="order.metadatas.aquatic">
                                            <md-option @click.native="getNewAquatic">+ {{ Translate('add.new') }}</md-option>
                                            <md-option v-for="aquatic in aquatics" :key="aquatic.id" :value="aquatic.id">{{aquatic.name}}</md-option>
                                        </md-select>
                                    </md-field>

                                    <md-field>
                                        <label for="customer">{{ Translate('customer') }}</label>
                                        <md-select v-model="order.customer.id" id="customer">
                                            <md-option v-for="customer in customers" :key="customer.id" :value="customer.id">{{customer.metadatas.name}}</md-option>
                                        </md-select>
                                    </md-field>

                                    <md-field>
                                        <label>{{ Translate('description') }}</label>
                                        <md-textarea v-model="order.description"></md-textarea>
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
                                        <label for="orderStatus">{{ Translate('order.status') }}</label>
                                        <md-select v-model="order.status" name="status" id="orderStatus">
                                            <md-option value="0">{{ Translate('upcoming') }}</md-option>
                                            <md-option value="1">{{ Translate('doing') }}</md-option>
                                            <md-option value="2">{{ Translate('done') }}</md-option>
                                        </md-select>
                                    </md-field>

                                    <md-field>
                                        <label>{{ Translate('deadline') }}</label>
                                        <md-input v-model="order.metadatas.deadline" id="deadline"></md-input>
                                        <md-button @click="dateTimePickerShow=true" class="md-icon-button md-primary">
                                            <md-icon>event</md-icon>
                                        </md-button>
                                    </md-field>
                                    
                                </md-card-content>
                                <md-card-actions>
                                    <md-button class="md-raised md-primary" @click="saveOrder">{{ Translate('save') }}</md-button>
                                </md-card-actions>
                            </md-card>
                        </div>
                    </div>
                </md-tab>
            </md-tabs>
        </div>

        <date-picker
            v-model="order.metadatas.deadline"
            type="datetime"
            element="deadline"
            :show="dateTimePickerShow"
            @close="dateTimePickerShow=false">
        </date-picker>
    </form>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'

export default {
    data: () => ({
        order: {
            name: '',
            customer: {
                id: 0
            },
            description: '',
            metadatas: {
                aquatic: null,
                deadline: null,
            },
        },
        note: {
            body: ''
        },
        customers: [],
        aquatics: [],
        notes: [],

        showNoteDialog: false,
        attachmentUploadBusy: false,
        uploadedAttachment: null,

        dateTimePickerShow: false,
    }),

    created() {

        this.setPageTitle(this.Translate('edit.order'))

        Vue.axios.get('orders/' + this.$route.params.hashid).then((response) => {
            this.order = response.data

            this.order.shipments.reverse()

            this.order.shipments.forEach(function (shipment) {
                if (shipment.packages.length) {
                    shipment.total_packages_weight = 0
                    shipment.packages.forEach(function (pack) {
                        shipment.total_packages_weight = shipment.total_packages_weight + (pack.source_package.weight.net_weight * pack.pivot.quantity)
                    })
                }
            })
        })

        this.getNotes()

        Vue.axios.get('customers').then((response) => {
            this.customers = response.data
        })

        Vue.axios.get('aquatics').then((response) => {
            this.aquatics = response.data
        })

    },

    methods: {
        saveOrder () {
            Vue.axios.put('orders/' + this.$route.params.hashid, this.order)
                .then((response) => {
                    this.setSnackbarText('Order updated successfully')
                    this.setSnackbarShow(true)
                })
                .catch((response) => {

                })
        },

        getStatusName (status) {
            const statuses = {
                0: 'Upcoming',
                1: 'Doing',
                2: 'Done'
            }
            
            return statuses[status]
        },

        getNewAquatic () {
            let routeData = this.$router.resolve({name: 'aquatics.add'})
            window.open(routeData.href, '_blank')
        },

        getNotes () {
            Vue.axios.get('notes?model=order&notable=' + this.$route.params.hashid).then((response) => {
                this.notes = response.data.reverse()
            })
        },

        saveNote () {
            this.showNoteDialog = false
            Vue.axios.post('notes/add?model=order&notable=' + this.$route.params.hashid, {note: this.note, attachment: this.uploadedAttachment})
                .then((response) => {
                    this.setSnackbarText('Note added successfully')
                    this.setSnackbarShow(true)
                    this.note = {body: ''}
                    this.uploadedAttachment = null
                    this.getNotes()
                })
                .catch((response) => {

                })
        },

        chooseFile () {
            this.$refs.attachmentInput.click ()
        },

        handleFile (e) {
            this.attachmentUploadBusy = true
            this.files = e.target.files || e.dataTransfer.files
            if (!this.files.length)
                return
            this.prepareAttachment(this.files[0])
        },

        prepareAttachment (file) {
            let reader = new FileReader()
            let self = this
            reader.onload = (e) => {
                self.uploadAttachment()
            }
            reader.readAsDataURL(file)
        },

        uploadAttachment () {
            let formData = new FormData()
            formData.append('file', this.files[0])
            formData.append('dir', 'notes')
            formData.append('used_as', 'document')

            Vue.axios.post('attachments/upload', formData)
                .then((response) => {
                    this.attachmentUploadBusy = false
                    this.uploadedAttachment = response.data.id
                })
                .catch(() => {
                    this.attachmentUploadBusy = false
                })
        },

        isImage (url) {
            return(url.match(/\.(jpeg|jpg|gif|png)$/) != null)
        },

        downloadAttachment (url) {
            window.open(url, '_blank')
        },

        ...mapMutations([
            'setPageTitle',
            'setSnackbarText',
            'setSnackbarShow',
        ])
    },
}
</script>