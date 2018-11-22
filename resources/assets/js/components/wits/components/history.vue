<template>
    <div class="pre-scrollable">
        <!-- {{data}} -->
        changes: {{mergeHistory.length}}

            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>id</th>
                        <th>Changed By</th>
                        <th>Key</th>
                        <th>old_value</th>
                        <th>new_value</th>
                        <th>created_at</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(history, index) in mergeHistory" :key="history.id">
                        <td>
                            {{history.revisionable_type}}
                        </td>
                        <td>
                            <small>{{history.id}}</small>
                        </td>
                        <td>
                            {{history.user_id}}
                        </td>
                        <td>
                            {{history.key}}
                        </td>
                        <td>
                            {{history.old_value}}
                        </td>
                        <td>
                            {{history.new_value}}
                        </td>
                        <td>
                            {{new Date(history.created_at).toLocaleString('en-us',
                            {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: "2-digit",
                                minute: "2-digit",
                                second: "2-digit"
                                }
                                )}}
                        </td>



                    </tr>
                </tbody>
            </table>
    </div>
</template>
<script>
import store from '../../../vuex/store.js'

export default {
    store,
    props: ['assetHistory', 'properties'],
    data: function() {
        return {
            // suggestions: [],
        }
    },
    computed: {
        mergeHistory: function(){
            // merge 'assetHistory' 'properties'

            let propsHistory = this.properties.map(i => i.revision_history)
            propsHistory = propsHistory.flat()

            // console.log(propsHistory)
            // console.log(this.assetHistory)


            if(this.assetHistory && propsHistory){
                let mergeHistory = [...this.assetHistory, ...propsHistory]
                mergeHistory.sort(function(a,b){
                    return Number(new Date(b.created_at)) - Number(new Date(a.created_at));
                });
                return mergeHistory
            }

            return []


        }

    },
    methods: {},

    mounted() {
        var vm = this
        // vm.$store.dispatch("FETCH_ASSETS_PROPERTIES");
    }
}
</script>
