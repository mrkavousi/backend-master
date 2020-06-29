<template>
    
    <form>
        
        <div class="md-layout md-alignment-center-center h-100 login-view">
        
            <md-card class="md-layout-item md-size-25 md-small-size-50 md-xsmall-size-100">

                <md-card-header>
                    <div class="md-title align-center">{{ Translate('login.pansea.cloud') }}</div>
                </md-card-header>

                <md-card-content>
                    <md-field>
                        <label>{{ Translate('mobile.email') }}</label>
                        <md-input name="user" v-model="user" @keydown.enter="login"></md-input>
                    </md-field>

                    <md-field>
                        <label>{{ Translate('password') }}</label>
                        <md-input type="password" name="password" v-model="password" @keydown.enter="login"></md-input>
                    </md-field>
                </md-card-content>

                <md-card-actions>
                    <md-button class="md-raised md-primary" @click="login">{{ Translate('login') }}</md-button>
                </md-card-actions>

            </md-card>
        
        </div>

    </form>
    
</template>

<script>
import { mapMutations } from 'vuex'

export default {
    name: 'login',
    data: () => ({
      user: '',
      password: ''
    }),
    created () {
        this.setPageTitle(this.Translate('login'))
    },
    methods: {
        login () {
            this.$auth.login({
                data: {
                    user: this.user,
                    password: this.password
                },
                success: function (result) {
                },
                error: function () {},
                rememberMe: true,
                redirect: this.$route.query.redirect || '/',
                fetchUser: true,
            })
        },

        ...mapMutations([
            'setPageTitle',
        ])
    }
}
</script>