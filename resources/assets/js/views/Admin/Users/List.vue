<template>
    <div>
        <md-table v-model="users" md-sort="created_at" md-sort-order="desc" md-card md-fixed-header>
        <md-table-toolbar>
            <div class="md-toolbar-section-start">
                <h1 class="md-title">{{ Translate('users') }}</h1>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
                <md-input :placeholder="Translate('search')" v-model="searchKeyword" @input="searchOnTable" />
            </md-field>
        </md-table-toolbar>

        <md-table-empty-state>
            <md-button class="md-primary md-raised" to="/users/add">{{ Translate('add.new') }}</md-button>
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell :md-label="Translate('id')" md-sort-by="hashid" md-numeric>
                {{ item.hashid }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('name')" md-sort-by="title">
                {{ item.metadatas.name }}
            </md-table-cell>
            <md-table-cell md-label="Mobile" md-sort-by="description">
                {{ item.mobile }}
            </md-table-cell>
            <md-table-cell md-label="Email" md-sort-by="description">
                {{ item.email }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('created.at')" md-sort-by="created_at">
                {{ item.created_at | moment("from", "now") }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('updated.at')" md-sort-by="updated_at">
                {{ item.updated_at | moment("from", "now") }}
            </md-table-cell>
            <md-table-cell md-label="">
                <md-button class="md-icon-button md-primary" :to="'/users/' + item.hashid">
                    <md-icon>edit</md-icon>
                </md-button>
            </md-table-cell>
        </md-table-row>
        </md-table>
    </div>
</template>

<script>
import Vue from 'vue'
import { mapMutations } from 'vuex'

  export default {
    data: () => ({
        users: [],
        searchKeyword: null
    }),

    created() {
        this.setPageTitle(this.Translate('users'))
        
        Vue.axios.get('users').then((response) => {
            this.users = response.data
        })
    },

    methods: {
        searchOnTable () {
            this.users = this.search(this.users, this.search)
        },

        search (users, search) {
            if (search) {
                return users
            }

            return users
        },

        ...mapMutations([
            'setPageTitle',
        ])
    }
  }
</script>