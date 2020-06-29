<template>
    <form>
        <div class="users users-edit md-layout">
            <div class="md-layout-item md-size-75 md-small-size-50 md-xsmall-size-100">
                <md-card>
                    <md-card-content>

                        <md-field>
                            <label>{{ Translate('name') }}</label>
                            <md-input v-model="user.metadatas.name"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('email') }}</label>
                            <md-input v-model="user.email"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('phone') }}</label>
                            <md-input v-model="user.metadatas.phone"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('mobile') }}</label>
                            <md-input v-model="user.mobile"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('address') }}</label>
                            <md-input v-model="user.metadatas.address"></md-input>
                        </md-field>

                        <md-field>
                            <label>{{ Translate('password') }}</label>
                            <md-input v-model="user.password"></md-input>
                        </md-field>

                        <md-field v-if="roles">
                            <label for="roles">{{ Translate('role') }}</label>
                            <md-select v-model="user.roles[0].id" id="roles">
                                <md-option v-for="role in roles" :key="role.id" :value="role.id">{{role.display_name}}</md-option>
                            </md-select>
                        </md-field>

                        <md-field>
                            <label for="locale">{{ Translate('locale') }}</label>
                            <md-select v-model="user.metadatas.locale" id="locale">
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
        user: {
            email: '',
            mobile: '',
            password: '',
            roles: [{
                id: 0
            }],
            metadatas: {
                name: '',
                locale: '',
                phone: '',
                address: ''
            }
        },

        roles: []
    }),

    created() {

        Vue.axios.get('roles').then((response) => {
            this.roles = response.data
        })

        Vue.axios.get('users/' + this.$route.params.hashid).then((response) => {
            this.user = response.data
            this.setPageTitle(this.Translate('edit.user', {'name': this.user.metadatas.name}))
        })

    },

    methods: {
        saveUser () {
            Vue.axios.put('users/' + this.$route.params.hashid, this.user)
                .then((response) => {
                    this.setSnackbarText(this.Translate('user.updated.successfully'))
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