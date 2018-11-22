<template>
    <div>
        <div class="row">

            <div class="col-md-12">
                <ui-tabs>
                    <ui-tab title="Details">

                        <div class="row">
                            <div class="col-md-4">

                                <ui-textbox
                                    enforce-maxlength
                                    floating-label
                                    label="Label"
                                    :maxlength="50"
                                    v-model="fields.label"
                                ></ui-textbox>

                                <ui-textbox
                                    enforce-maxlength
                                    floating-label
                                    label="Category"
                                    :maxlength="25"
                                    v-model="fields.category"
                                ></ui-textbox>

                                <ui-textbox
                                    floating-label
                                    label="Steward"
                                    help="Person incharge of the asset"
                                    v-model="fields.user_id"
                                ></ui-textbox>

                                <ui-textbox
                                    floating-label
                                    :multiLine='true'
                                    label="description"
                                    help="Notes about the asset"
                                    v-model="fields.description"
                                ></ui-textbox>


                            </div>

                            <div class="col-md-4">
                                <ui-datepicker
                                    floating-label
                                    orientation="landscape"
                                    placeholder="Select a date"
                                    :customFormatter="this.formatter"
                                    v-model="fields.acquisition_date_temp"
                                ><b>Acquisition Date</b></ui-datepicker>

                                <ui-textbox
                                    floating-label
                                    label="Model"
                                    v-model="fields.model"
                                ></ui-textbox>

                                <ui-textbox
                                    floating-label
                                    label="Lifecycle"
                                    help="Number of years until replacement"
                                    type="number"
                                    v-model="fields.lifecycle"
                                ></ui-textbox>


                                <ui-textbox
                                    floating-label
                                    label="Manufacturer"
                                    v-model="fields.manufacturer"
                                ></ui-textbox>



                            </div>

                            <div class="col-md-4">
                                <ui-textbox
                                    floating-label
                                    label="Cost"
                                    v-model="fields.cost"
                                ></ui-textbox>
                                <ui-textbox
                                    floating-label
                                    label="Quantity"
                                    v-model="fields.quantity"
                                ></ui-textbox>
                                 <ui-textbox
                                    floating-label
                                    label="Serial_number"
                                    v-model="fields.serial_number"
                                ></ui-textbox>
                                <ui-textbox
                                    floating-label
                                    label="Replacement_fiscal_year"
                                    v-model="fields.replacement_fiscal_year"
                                ></ui-textbox>
                            </div>
                        </div>

                    </ui-tab>
                    <ui-tab title="Location">
                        <div class="row">
                             <div class="col-md-4">
                                <ui-textbox
                                    floating-label
                                    label="Room"
                                    v-model="fields.room_id"
                                ></ui-textbox>

                             </div>
                        </div>

                    </ui-tab>
                    <ui-tab :title="`Assets (${selectedItems.length})`">
                        <ul class="list">
                            <li v-for="(label, key) in selectedItems.map(o => o.label )">
                                {{label}}
                            </li>
                        </ul>
                    </ui-tab>
                </ui-tabs>

                <ui-button class="btn-success" @click="onEdit">Save</ui-button>

            </div>

        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import store from '../../../vuex/store.js'
import { forEach } from 'async';

export default {
    data () {
        return {
            selectedItems:[],
            fields:{
                label: null,
                description: null,
                user_id: null,
                room_id: null,
                weber_inventory_tag: null,
                acquisition_date_temp: null,
                acquisition_date: null,
                category: null,
                lifecycle: null,
                serial_number: null,
                manufacturer: null,
                model: null,
                cost: null,
                quantity: null,
                replacement_fiscal_year: null
            }
        }
    },
    store,
    props: {
        gridApi: {required: true },
    },
    computed:{

    },
    methods: {
        formatter(value){
            return new Date(value).toISOString().split('T')[0]
        },
        onEdit(){
            let vm = this
            if(!this.selectedItems.length){
                toastr.warning("no selected assets")
                return
            }
            if(!!this.fields.acquisition_date_temp){
                this.fields.acquisition_date = this.fields.acquisition_date_temp.toISOString().split('T')[0]
            }

            axios
            .post('/api/v1/asset/bulk-edit', {
                    asset_ids: this.selectedItems.map(o => o.id),
                    fields: this.fields
                })
            .then(function(response){
                toastr.success("Bulk Edit Successful")

                response.data.forEach(function(asset){
                    let row = vm.gridApi.getRowNode(asset.id)
                    row.setData(asset)
                    row.gridApi.redrawRows()


                })

            })



        },
        onRowSelected(){
            // console.log("BulkEdit onRowSelected", selectedRows)
            this.selectedItems = this.gridApi.gridOptionsWrapper.gridApi.getSelectedRows()
        }

    },
    created: function(){
        // console.log("BulkEdit Created")
    },
    mounted: function(){
        let vm = this
        // console.log("BulkEdit Mounted")
    },
}
</script>


<style scoped>
.list{
    column-count: 4
}
</style>
