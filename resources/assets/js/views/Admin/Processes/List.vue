<template>
    <div>
        <md-table v-model="processes" md-sort="created_at" md-sort-order="desc" md-card md-fixed-header>
        <md-table-toolbar>
            <div class="md-toolbar-section-start">
                <h1 class="md-title">Latest Processes</h1>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
                <md-input placeholder="Search..." v-model="searchKeyword" @input="searchOnTable" />
            </md-field>
        </md-table-toolbar>

        <md-table-empty-state md-label="Nothing found"
        :md-description="'Your search was not any result'">
            <md-button class="md-primary md-raised" to="/processes/add">Add New Process</md-button>
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell md-label="ID" md-sort-by="hashid" md-numeric>
                {{ item.hashid }}
            </md-table-cell>
            <md-table-cell md-label="Type">
                {{ item.type.name }}
            </md-table-cell>
            <md-table-cell md-label="On">
                <router-link v-if="item.processable_type == 'App\\Models\\Project'" :to="'/projects/' + item.processable.hashid">{{ 'Project: ' + item.processable.name }}</router-link>
                <router-link v-if="item.processable_type == 'App\\Models\\Merchandise'" :to="'/merchandises/' + item.processable.hashid">{{ 'Merchandise: ' + item.processable.name }}</router-link>
            </md-table-cell>
            <md-table-cell md-label="Created At" md-sort-by="created_at">
                {{ item.created_at | moment("from", "now") }}
            </md-table-cell>
            <md-table-cell md-label="Updated At" md-sort-by="updated_at">
                {{ item.updated_at | moment("from", "now") }}
            </md-table-cell>
            <md-table-cell md-label="">
                <md-button v-if="item.processable_type == 'App\\Models\\Project'" class="md-icon-button md-primary" :to="'/projects/' + item.processable.hashid + '/processes/' + item.hashid">
                    <md-icon>edit</md-icon>
                </md-button>

                <md-button v-if="item.processable_type == 'App\\Models\\Merchandise'" class="md-icon-button md-primary" :to="'/merchandises/' + item.processable.hashid + '/processes/' + item.hashid">
                    <md-icon>edit</md-icon>
                </md-button>
            </md-table-cell>
        </md-table-row>
        </md-table>
    </div>
</template>

<script>
import Vue from 'vue'

  export default {
    data: () => ({
        page: {
            title: 'Processes'
        },
        processes: [],
        searchKeyword: null
    }),

    created() {
        this.$emit('pageDataUpdate', this.page)
        
        Vue.axios.get('processes').then((response) => {
            this.processes = response.data.data
        })
    },

    methods: {
        searchOnTable () {
            this.processes = this.search(this.processes, this.search)
        },

        search (processes, search) {
            if (search) {
                return processes
            }

            return processes
        }
    }
  }
</script>