<template>
    <div>
        <md-table v-model="permissions" md-sort="created_at" md-sort-order="desc" md-card md-fixed-header>
        <md-table-toolbar>
            <div class="md-toolbar-section-start">
                <h1 class="md-title">{{ Translate('users') }}</h1>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
                <md-input :placeholder="Translate('search')" v-model="searchKeyword" @input="searchOnTable" />
            </md-field>
        </md-table-toolbar>

        <md-table-empty-state>
            <md-button class="md-primary md-raised" to="/permissions/add">{{ Translate('add.new') }}</md-button>
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell :md-label="Translate('id')" md-sort-by="hashid" md-numeric>
                {{ item.hashid }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('name')" md-sort-by="title">
                {{ item.name }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('name')" md-sort-by="display_name">
                {{ item.display_name }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('description')" md-sort-by="description">
                {{ item.description }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('created.at')" md-sort-by="created_at">
                {{ item.created_at | moment("from", "now") }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('updated.at')" md-sort-by="updated_at">
                {{ item.updated_at | moment("from", "now") }}
            </md-table-cell>
            <md-table-cell md-label="">
                <md-button class="md-icon-button md-primary" :to="'/permissions/' + item.hashid">
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
        permissions: [],
        searchKeyword: null
    }),

    created() {
        this.setPageTitle(this.Translate('permission'))
        
        Vue.axios.get('permissions').then((response) => {
            this.permissions = response.data
        })
    },

    methods: {
        searchOnTable () {
            this.permissions = this.search(this.permissions, this.search)
        },

        search (permissions, search) {
            if (search) {
                return permissions
            }

            return permissions
        },

        ...mapMutations([
            'setPageTitle',
        ])
    }
  }
</script>