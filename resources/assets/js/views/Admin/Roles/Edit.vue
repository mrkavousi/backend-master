<template>
    <form>
        <div class="roles roles-edit md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>{{ Translate('name') }}</label>
                            <md-input v-model="role.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('name') }}</label>
                            <md-input v-model="role.display_name"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('description') }}</label>
                            <md-input v-model="role.description"></md-input>
                        </md-field>

                        <md-field v-if="permissions">
                            <label for="permissions">{{ Translate('role') }}</label>
                            <md-select v-model="role.permissions.id" id="permissions" multiple>
                                <md-option v-for="permission in permissions" :key="permission.id" :value="permission.id">{{permission.display_name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label for="locale">{{ Translate('locale') }}</label>
                            <md-select v-model="role.metadatas.locale" id="locale">
                                <md-option value="fa">فارسی</md-option>
                                <md-option value="en">English</md-option>
                            </md-select>
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
                        <md-button class="md-raised md-primary" @click="saveUser">{{ Translate('save') }}</md-button>
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
        role: {
            name: '',
            display_name: '',
            description: '',
            permissions: {
                id: '',
            },
            metadatas: {
                locale: '',
            },
        },
        permissions: [],
    }),

    created() {

        /*Vue.axios.get('roles').then((response) => {
            this.roles = response.data
        })*/

        Vue.axios.get('permissions').then((response) => {
            this.permissions = response.data
        })

        Vue.axios.get('roles/' + this.$route.params.hashid).then((response) => {
            this.role = response.data
            this.setPageTitle(this.Translate('edit.role', {'name': this.role.name}))
        })

    },

    methods: {
        saveUser () {
            Vue.axios.put('roles/' + this.$route.params.hashid, this.role)
                .then((response) => {
                    this.setSnackbarText(this.Translate('role.updated.successfully'))
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