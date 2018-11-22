<template>
    <div>
        <ui-tabs type="text" fullwidth raised indicatorColor="white">
            <ui-tab title="Transfer">
                <div class="row">

                    <div class="col-md-12">
                        <!-- {{selectedItems}} -->
                    </div>
                    <div class="col-md-6">
                        All of these {{selectedItems.length}} Assets
                    </div>
                    <div class="col-md-6">
                        Transfer to:
                        <multiselect
                            v-if="selectedItems.length"
                            v-model="newDepartment"
                            :allow-empty="false"
                            :options="departments"
                            :multiple="false"
                            track-by="id"
                            label="name"
                            :hideSelected="false"
                            :close-on-select="true"
                            >
                        </multiselect>

                        <button v-if="newDepartment" class="btn btn-primary" @click="onTransfer">Go</button>
                    </div>
                </div>
            </ui-tab>

            <ui-tab :title="`Queue (${transferCount})`">

                <div class="row">
                    <div class="col-md-6">
                        <h3>Sending</h3>

                        <ul v-for="(sending, index) in transfers.sending" :ref="sending">
                            <table class="table table-striped table-sm table-dark" v-if="transfers.sending[index].transfers.length">
                                <thead>
                                    <tr>
                                    <th scope="col"></th>
                                    <th scope="col">From</th>
                                    <th scope="col">To</th>
                                    <th scope="col">Label</th>
                                    <th scope="col">w tag</th>
                                    <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(transfer, index) in transfers.sending[index].transfers">
                                        <th scope="row">
                                            <img width="100" v-if="transfer.asset.media[0]" :src="transfer.asset.media[0].path">
                                        </th>
                                        <td>{{transfer.old_department.name}}</td>
                                        <td>{{transfer.new_department.name}}</td>
                                        <td>{{transfer.asset.label}}</td>
                                        <td>{{transfer.asset.weber_inventory_tag}}</td>
                                        <td><button type="button" class="btn btn-warning btn-sm" @click="onCancel(transfer, $event)">Cancel </button></td>
                                    </tr>


                                </tbody>
                            </table>


                        </ul>

                    </div>

                    <div class="col-md-6">
                        <h3>Receiving</h3>
                        <ul v-for="(receiving, index) in transfers.receiving">

                                <table class="table table-striped table-sm table-dark" v-if="transfers.receiving[index].transfers.length">
                                    <thead>
                                        <tr>
                                        <th scope="col"></th>
                                        <th scope="col">From</th>
                                        <th scope="col">To</th>
                                        <th scope="col">Label</th>
                                        <th scope="col">w tag</th>
                                        <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(transfer, index) in transfers.receiving[index].transfers">
                                            <th scope="row">
                                                <img width="100" v-if="transfer.asset.media[0]" :src="transfer.asset.media[0].path">
                                            </th>
                                            <td>{{transfer.old_department.name}}</td>
                                            <td>{{transfer.new_department.name}}</td>
                                            <td>{{transfer.asset.label}}</td>
                                            <td>{{transfer.asset.weber_inventory_tag}}</td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" @click="onAccept(transfer,$event)">Accept</button>
                                                <button type="button" class="btn btn-danger btn-sm" @click="onReject(transfer,$event)">Reject</button>
                                            </td>
                                        </tr>


                                    </tbody>
                            </table>




                        </ul>
                    </div>
                </div>


            </ui-tab>

            <ui-tab title="History"></ui-tab>
        </ui-tabs>
    </div>
</template>

<script>
import Vue from 'vue'
import store from '../../../vuex/store.js'

export default {
    data () {
        return {
            selectedItems:[],
            newDepartment: null

        }
    },
    store,
    props: {
        gridApi: {required: true },
    },
    computed:{
        departments: function() {
            let departments = this.$store.getters.departments
            if (typeof departments !== 'undefined') {
                return departments
            }

        },
        transfers: function(){
            return this.$store.state.transfers
        },
        transferCount: function(){
            return this.$store.state.transfers.receiving.map(o => o.transfers.length).reduce(function(a,b){return a+b}, 0)
        }
    },
    methods: {
        onCancel(transfer,e){
            console.log("onCancel", transfer, e)
            let vm = this
            let force = true
            axios
            .delete('/api/v1/transfer/' + transfer.id + "/" + force)
            .then(function(response){
                toastr.success("Transfer Canceled")

                $(e.target).closest('tr').remove()

            })
            .catch(function(err){
                console.log(err)
            })
        },
        onAccept(transfer,e){
            console.log("onAccept", transfer, e)
            let vm = this

            axios
            .put('/api/v1/asset/' + transfer.asset.id, {
                    pk: transfer.asset.id,
                    name: 'department_id',
                    value: transfer.new_department_id
                })
            .then(function(response){
                toastr.success("Transfer Accepted")
            })



            axios
            .put('/api/v1/transfer/' + transfer.id, {
                    pk: transfer.asset.id,
                    name: 'status',
                    value: 'accepted'
                })
            .then(function(response){
                axios
                .delete('/api/v1/transfer/'+ transfer.id + "/" + 'true')
                .then(function(){
                    // e.target.parentElement.remove()
                    $(e.target).closest('tr').remove()

                    vm.transfers.receiving.forEach(department => {
                        var receiving_index = _.findIndex(department.transfers, function(transfer) {
                            return transfer.id == response.data.id;
                        });

                        department.transfers.splice(receiving_index, 1);
                    });

                })


            })

        },

        onReject(transfer,e){
            // console.log("onReject", transfer, e)
            let vm = this
            let force = true

            axios
            .put('/api/v1/transfer/' + transfer.id, {
                pk: transfer.asset.id,
                name: 'status',
                value: 'rejected'
            })
            .then(function(response){
                axios
                .delete('/api/v1/transfer/'+ transfer.id + "/" + force)
                .then(function(){
                    // console.log(response.data)
                    $(e.target).closest('tr').remove()

                    vm.transfers.receiving.forEach(department => {
                        var receiving_index = _.findIndex(department.transfers, function(transfer) {
                            return transfer.id == response.data.id;
                        });

                        department.transfers.splice(receiving_index, 1);
                    });



                    toastr.success("Transfer Rejected")
                })
            })


        },

        onRowSelected(){
            // console.log("Transfer onRowSelected", selectedRows)
            this.selectedItems = this.gridApi.gridOptionsWrapper.gridApi.getSelectedRows()
        },
        onTransfer(){
            // console.log("onTransfer")
            let vm = this

            var data = {
                asset_ids: this.selectedItems.map(i => i.id),
                new_department_id: this.newDepartment.id,
                status: 'pending'
            }

            $.confirm({
            title:
                'Transfer (' + this.selectedItems.length + ') Selected Assets',
            content: 'Ok... if your absolutely positive',
            icon: 'fa fa-exclamation-triangle',
            animation: 'zoom',
            closeAnimation: 'zoom',
            buttons: {
                confirm: {
                    text: 'Transfer!',
                    btnClass: 'btn-red',
                    action: function() {
                        // console.log("Transfering assets)", vm)

                        axios
                        .post('/api/v1/transfer', data)
                        .then(function(response) {
                                    toastr.info("Transfer Pending: An Email has Been Sent")

                        })

                    }
                },
                close: {
                    text: 'Close'
                }
            }
        })

        }
    },
    created: function(){
        // console.log("Transfers Created")
    },
    mounted: function(){
        let vm = this
        // console.log("Transfers Mounted")
        this.$store.dispatch("FETCH_ALL_DEPARTMENTS");
    },
}
</script>
