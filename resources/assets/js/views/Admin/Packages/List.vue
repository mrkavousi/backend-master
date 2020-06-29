<template>
    <div>
        <md-table v-model="packages" md-sort="created_at" md-sort-order="desc" md-card md-fixed-header>
        <md-table-toolbar>
            <div class="md-toolbar-section-start">
                <h1 class="md-title">{{ Translate('packages') }}</h1>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
                <md-input :placeholder="Translate('search')" v-model="searchKeyword" @input="searchOnTable" />
            </md-field>
        </md-table-toolbar>

        <md-table-empty-state>
            <md-button class="md-primary md-raised" to="/packages/add">{{ Translate('add.new') }}</md-button>
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell :md-label="Translate('id')" md-sort-by="hashid" md-numeric>
                {{ item.hashid }}
            </md-table-cell>
            <md-table-cell :md-label="Translate('name')" md-sort-by="name">
                {{ item.name }}
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
                <md-button class="md-icon-button md-primary" :to="'/packages/' + item.hashid">
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
        packages: [],
        searchKeyword: null
    }),

    created() {
        this.setPageTitle(this.Translate('packages'))
        
        Vue.axios.get('packages').then((response) => {
            this.packages = response.data
        })
    },

    methods: {
        searchOnTable () {
            this.packages = this.search(this.packages, this.search)
        },

        search (packages, search) {
            if (search) {
                return packages
            }

            return packages
        },

        ...mapMutations([
            'setPageTitle',
        ])
    }
  }
</script>