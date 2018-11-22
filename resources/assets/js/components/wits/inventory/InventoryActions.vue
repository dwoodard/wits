<template>
    <div v-if="this.$store.getters.currentUser">

        <div class="row" id="hidden-tool-panels">

            <div class="panel-group" id="actions">

                <div class="panel-collapse collapse" :id="'bulkUploadForm-'+_uid">

                    <div class="well container-fluid">


                        <div class="row">
                            <ui-toolbar
                                text-color="white"
                                title="Bulk Upload"
                                type="colored">

                                <div slot="icon"></div>
                                <div slot="actions">
                                    <a data-toggle="collapse" data-parent="#actions" :data-target="'#bulkUploadForm-'+_uid">
                                    <span class="fa-layers fa-fw fa-2x">
                                        <i class="fas fa-circle" style="color:Tomato"></i>
                                        <i class="fa-inverse fas fa-times" data-fa-transform="shrink-6"></i>
                                    </span>
                                </a>
                                </div>
                            </ui-toolbar>
                        </div>


                        <div style="margin-top: 30px;">
                            <bulk-uploader></bulk-uploader>
                        </div>
                    </div>

                </div>

                <div class="panel-collapse collapse" :id="'bulkEditForm-'+_uid">

                    <div class="well container-fluid">
                        <div class="row">
                            <ui-toolbar
                                text-color="white"
                                title="Bulk Edit"
                                type="colored">

                                <div slot="icon"></div>
                                <div slot="actions">
                                    <a data-toggle="collapse" data-parent="#actions" :data-target="'#bulkEditForm-'+_uid">
                                        <span class="fa-layers fa-fw fa-2x">
                                            <i class="fas fa-circle" style="color:Tomato"></i>
                                            <i class="fa-inverse fas fa-times" data-fa-transform="shrink-6"></i>
                                        </span>
                                    </a>
                                </div>
                            </ui-toolbar>
                        </div>

                        <div style="margin-top: 30px;">

                            <div>
                                <bulk-editor :gridApi="gridApi" ref="bulkEditor"></bulk-editor>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="panel-collapse collapse" :id="'addAssetForm-'+_uid">
                    <div class="well container-fluid">

                        <div class="row">
                            <ui-toolbar
                                text-color="white"
                                title="Add Asset"
                                type="colored">

                                <div slot="icon"></div>
                                <div slot="actions">
                                    <a data-toggle="collapse" data-parent="#actions" :data-target="'#addAssetForm-'+_uid">
                                    <span class="fa-layers fa-fw fa-2x">
                                        <i class="fas fa-circle" style="color:Tomato"></i>
                                        <i class="fa-inverse fas fa-times" data-fa-transform="shrink-6"></i>
                                    </span>
                                    </a>
                                </div>
                            </ui-toolbar>
                        </div>



                        <div class="row">

                            <form :id="'addAsset-'+_uid" class="form-horizontal" v-on:submit.prevent="onSubmitAssetMedia" method="post">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Image</label>
                                        <div class="col-sm-9">
                                            <ui-fileupload
                                            accept="image/*"
                                            :name="'thumbnail-'"
                                            @change="onFileChange"
                                            >Select an image</ui-fileupload>

                                            <div class="page__demo-preview" v-if="previewImage.length > 0">
                                                <img class="page__demo-preview-image"
                                                :src="previewImage"
                                                width="200"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Label *</label>
                                        <div class="col-sm-9">
                                            <input required v-model="asset.label" type="text" class="form-control" placeholder="Label">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Description</label>
                                        <div class="col-sm-9">
                                            <input v-model="asset.description" type="text" class="form-control" placeholder="Description">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Department *</label>
                                        <div class="col-sm-9">
                                            <multiselect
                                                v-if="Array.isArray(departmentSuggestions)"
                                                v-model="asset.department"
                                                :allow-empty="false"
                                                :options="departmentSuggestions"
                                                :multiple="false"
                                                track-by="id"
                                                label="name"
                                                :hideSelected="false"
                                                :close-on-select="true"
                                                @select="getAfterDepartmentSelect"
                                                >
                                                <template slot="option" scope="props">
                                                <div class="option__desc">
                                                    <span class="option__title">{{ props.option.name }}</span>
                                                </div>
                                                </template>
                                            </multiselect>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Steward *</label>
                                        <div class="col-sm-9">


                                            <multiselect
                                                v-if="asset.department.id && Array.isArray(departmentUsersSuggestions)"
                                                v-model="asset.userid"
                                                :allow-empty="false"
                                                :options="departmentUsersSuggestions"
                                                :multiple="false"
                                                track-by="value"
                                                label="text"
                                                :hideSelected="false"
                                                :close-on-select="true"
                                                >
                                            </multiselect>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Room *</label>
                                        <div class="col-sm-9">
                                            <multiselect
                                                v-if="asset.department.id && Array.isArray(departmentRoomsSuggestions)"
                                                v-model="asset.roomid"
                                                :allow-empty="false"
                                                :options="departmentRoomsSuggestions"
                                                :multiple="false"
                                                label="name"
                                                :hideSelected="false"
                                                :close-on-select="true"
                                                >
                                            </multiselect>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Weber tag</label>
                                        <div class="col-sm-9">
                                            <input v-model="asset.weber_inventory_tag" type="text" class="form-control" placeholder="Weber Inventory Tag">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Acquired</label>
                                        <div class="col-sm-9">
                                            <input v-model="asset.acquisition_date" :value="asset.acquisition_date" type="date" class="form-control" placeholder="Acquisition Date">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Cost *</label>
                                        <div class="col-sm-9">
                                            <input required v-model="asset.cost" type="number" min="1" step="any" class="form-control" placeholder="Cost">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Po#</label>
                                        <div class="col-sm-9">
                                            <input v-model="asset.po_number" type="text" class="form-control" placeholder="Po Number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Category</label>

                                        <div class="col-sm-9">
                                            <input v-model="asset.category" type="text" class="form-control" placeholder="Category">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Serial</label>
                                        <div class="col-sm-9">
                                            <input v-model="asset.serial_number" type="text" class="form-control" placeholder="Serial Number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Manufacturer</label>
                                        <div class="col-sm-9">
                                            <input v-model="asset.manufacturer" type="text" class="form-control" placeholder="Manufacturer">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Model</label>
                                        <div class="col-sm-9">
                                            <input v-model="asset.model" type="text" class="form-control" placeholder="Model">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Quantity *</label>
                                        <div class="col-sm-9">
                                            <input required name="quantity" v-model="asset.quantity" type="number" value="1" min="1" step="any" class="form-control" placeholder="Quantity">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Can Checkout</label>
                                        <div class="col-sm-9">
                                            <input v-model="asset.checkoutable" type="checkbox" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-default">Add Asset</button>
                                            <button type="reset" class="btn btn-default">Clear</button>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <div class="panel-collapse collapse" :id="'transferForm-'+_uid">

                    <div class="well container-fluid">
                        <div class="row">
                            <ui-toolbar
                                text-color="white"
                                title="Transfer"
                                type="colored">

                                <div slot="icon"></div>
                                <div slot="actions">
                                    <a data-toggle="collapse" data-parent="#actions" :data-target="'#transferForm-'+_uid">
                                        <span class="fa-layers fa-fw fa-2x">
                                            <i class="fas fa-circle" style="color:Tomato"></i>
                                            <i class="fa-inverse fas fa-times" data-fa-transform="shrink-6"></i>
                                        </span>
                                    </a>
                                </div>
                            </ui-toolbar>
                        </div>

                        <div style="margin-top: 30px;">

                            <transfers :gridApi="gridApi" ref="transfers"></transfers>


                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="btn-toolbar">

            <div class="btn-group">
                <button type="button" class="btn btn-default" @click="toggleSelectAll($event)" title="Selected Assets">
                    <input type="checkbox" :checked="selectedItems.length > 0">
                    <span class="badge">{{selectedItems.length}}</span>
                </button>

                <div class="input-group">
                    <input @keyup="onQuickFilterChanged" type="text" id="quickFilterInput" class="form-control"
                            placeholder="Type text to filter..."/>
                </div>

                <button type="button" class="btn btn-default" data-toggle="collapse" data-parent="#actions" :data-target="'#addAssetForm-'+_uid" title="Add Assets">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </button>

                <!-- <button class="btn btn-default" @click="gridApi.gridOptionsWrapper.gridOptions.columnApi.setColumnVisible('id', !gridApi.gridOptionsWrapper.gridOptions.columnApi.getColumn('id').visible)" title="Toggle WITS Id">
                    Id >
                </button> -->



                <button type="button" class="btn btn-default" @click="onBulkUpload" data-toggle="collapse" data-parent="#actions" :data-target="'#bulkUploadForm-'+_uid" title="Bulk Upload Wizard">
                    <span class="fa-layers">
                        <i class="fas fa-arrow-alt-circle-up"></i>
                    </span>
                </button>

                <button type="button" class="btn btn-default" @click="onBulkEdit" data-toggle="collapse" data-parent="#actions" :data-target="'#bulkEditForm-'+_uid" title="Bulk Edit">
                    <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                </button>

                <button type="button" class="btn btn-default" :class="{'btn-danger': transferCount}" @click="onTransferAsset" data-toggle="collapse" data-parent="#actions" :data-target="'#transferForm-'+_uid" title="Transfer Assets to a new Department">
                    <i class="fa fa-exchange-alt" aria-hidden="true"></i>
                    <span v-if="transferCount" class="badge">{{transferCount}}</span>
                </button>

                <button type="button" class="btn btn-default" @click="onMediaClick" title="Toggle Thumbnail">
                    <i class="fa fa-image" aria-hidden="true"></i>
                </button>

                <button type="button" class="btn btn-default" @click="onDeleteAsset" title="Delete Asset">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>







            </div>

        </div>

    </div>
</template>

<script>
import Vue from 'vue'

import BulkUploader from '../components/BulkUploader.vue'
Vue.component('bulk-uploader', BulkUploader)

import Transfers from '../components/Transfers.vue'
Vue.component('transfers', Transfers)

import BulkEditor from '../components/BulkEditor.vue'
Vue.component('bulk-editor', BulkEditor)

export default {
    name: 'inventory-actions',

    props: {
        gridApi: {required: true },
        currentUser: {required: true }
    },

    data: function() {
        return {
            departmentid: '',
            previewImage: [],
            asset: {
                label: '',
                description: '',
                department: '',
                department_id: '',
                user_id: '',
                room_id: '',
                weber_inventory_tag: '',
                acquisition_date: moment().format('YYYY-MM-DD'),
                category: '',
                lifecycle: '',
                serial_number: '',
                manufacturer: '',
                model: '',
                cost: '',
                quantity: '1',
                replacement_fiscal_year: ''
            },
            selectedItems:[]

        }
    },

    methods: {
        onFileChange(files, event) {
            this.previewImage = URL.createObjectURL(files[0])
            console.log('onFileChange', files, event)
        },
        departmentUsersSuggestionsFind: function(user_id) {
            return this.$store.state.suggestions.departmentUsers[0].data.find( i => i.value == user_id )
        },
        onMediaClick() {
            this.gridApi.gridOptionsWrapper.gridOptions.columnApi.setColumnVisible('media', !this.gridApi.gridOptionsWrapper.gridOptions.columnApi.getColumn('media').visible);
            this.gridApi.refreshCells();
        },
        onBulkEdit(event) {
            let vm = this
            if (vm.selectedItems.length === 0) {
                toastr.warning('BulkEdit: No Assets selected')
                return
            }
            console.log('onBulkEdit')

            // show panel of editable fields
        },
        onBulkUpload() {
            let vm = this
            console.log('onBulkUpload')
        },
        onToggleImage() {
            this.showPictures = !this.showPictures
        },
        onDeleteAsset: function(e) {
            let vm = this
            let selectedItems = vm.gridApi.gridOptionsWrapper.gridApi.getSelectedRows()
            e.stopPropagation()

            console.log("onDeleteAsset", this, selectedItems)

            if (selectedItems.length === 0) {
                toastr.warning('No Assets selected')
                return
            }

            //get All checkboxes ids

            $.confirm({
                title:
                    'Delete (' + selectedItems.length + ') Selected Assets',
                content: 'Ok... if your absolutely positive',
                icon: 'fa fa-exclamation-triangle',
                animation: 'zoom',
                closeAnimation: 'zoom',
                buttons: {
                    confirm: {
                        text: 'DELETE!',
                        btnClass: 'btn-red',
                        action: function() {
                            console.log("Soft Delete)", vm)

                            _.each(selectedItems, function(asset) {
                                console.log(asset.id)
                                axios
                                    .delete('/api/v1/asset/' + asset.id)
                                    .then(function(response) {
                                        let index = _.findIndex( vm.$store.state.inventory.assets, function(o) { return o.id == asset.id } )
                                        // console.log(index, vm.$store.state.inventory.assets[index]);

                                        //REMOVE from assets
                                        vm.gridApi.gridOptionsWrapper.gridApi.updateRowData({remove: selectedItems})
                                        // Vue.delete( vm.$store.state.inventory.assets, index )
                                    })
                            })
                        }
                    },
                    close: {
                        text: 'Close'
                    }
                }
            })
        },
        onTransferAsset: function(e) {
            let vm = this
            let selectedItems = vm.gridApi.gridOptionsWrapper.gridApi.getSelectedRows()
            // e.stopPropagation()

            console.log("onTransferAsset", this, selectedItems)
        },
        toggleSelectAll: function(e) {
            // console.log("toggleSelectAll",this.gridApi, e)
            this.gridApi.deselectAll()
        },
        onSubmitAssetMedia: function(e) {
            console.log('onSubmitAssetMedia')

            if (!this.asset.department) {
                toastr.warning( "Need an Department" )
                return
            }

            let vm = this
            let data = new FormData()

            let thumbnail = $('[name=thumbnail-' + vm.departmentid + ']')
            let config = {}

            //HACK: had to get the ids and values from the objects
            this.asset.department_id = this.asset.department.id
            this.asset.user_id = this.asset.userid.value
            this.asset.room_id = this.asset.roomid.id

            console.log('onSubmitAssetMedia',this.asset.department.id)

            console.log(data)
            //post Asset data to create asset and get an asset.id
            axios
            .post('/api/v1/asset', this.asset)
            .then(function(response) {
                let asset = response.data
                console.log(asset)

                toastr.success(
                    'Added Asset: ' + asset.label + ' {' + asset.id + '}'
                )
                //determain if asset has thumbnail
                if (thumbnail[0].files.length) {
                    // this.asset.media = new FormData()
                    console.log(thumbnail)
                    data.append(
                        'media',
                        thumbnail[0].files[0],
                        thumbnail[0].files[0].name
                    )
                    config = {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }

                    //after postAsset returns successful add media (if has media)
                    axios
                        .post(
                            '/api/v1/asset/' + asset.id + '/add-media',
                            data,
                            config
                        )
                        .then(function(response) {
                            let asset = response.data

                            if ( vm.$store.state.inventory.id == asset.department_id ) {
                                Vue.set(asset, 'selected', false)
                                vm.$store.state.inventory.assets.unshift(asset)
                            }
                        })
                } else {
                    if (vm.$store.state.inventory.id == asset.department_id) {
                        Vue.set(asset, 'selected', false)
                        vm.$store.state.inventory.assets.unshift(asset)
                    }
                }


            })
        },
        getAfterDepartmentSelect(department) {
            let that = this
            console.log('getAfterDepartmentSelect', department)

            this.asset.department_id = department.id

            this.$store.dispatch("FETCH_DEPARTMENTS_USERS_SUGGESSTIONS", department.id)
            .then(function(){
                that.$store.getters.departmentUsersSuggestionsById(that.asset.department.id)
                console.log("Dispatch getAfterDepartmentSelect",that);

            })


            this.$store.dispatch("FETCH_DEPARTMENTS_ROOMS_SUGGESSTIONS", department.id)
            .then(function(){
                that.$store.getters.departmentRoomsSuggestionsById(that.asset.department.id)
            })


        },
        onQuickFilterChanged(e) {
            this.gridApi.gridOptionsWrapper.gridOptions.api.setQuickFilter( e.target.value )
        },
        onDepartmentDropdownChange(e) {
            this.departmentUsersSuggestions = this.$store.getters.departmentUsersSuggestionsById( e.target.value )
        },
        onRowSelected(selectedRows){
            this.selectedItems = selectedRows

            this.$refs.transfers.onRowSelected()
            this.$refs.bulkEditor.onRowSelected()
        }
    },

    computed: {
        categorySuggestions: function() {
            return this.$store.getters.categories
        },

        departmentSuggestions: function(){

            //can i haz role at this point
            if(this.$store.getters.currentUser && this.$store.getters.currentUser.roles){
                if(!!this.$store.getters.currentUser.roles.find(i => i.name === 'admin')){
                    // console.log('get admin suggestions', this.$store.getters.departmentSuggestions())
                    return this.$store.getters.departmentSuggestions() || []
                }else{
                    console.log('get ANY OTHER suggestions', this.$store.getters.currentUser.departments)
                    return Object.entries(this.$store.getters.currentUser.departments).map((key,data) => ({"id": key[1].id,  "name":key[1].name}))
                }
            }
            else{
                console.log('no suggestions')
                return []
            }
        },

        departmentUsersSuggestions: function() {
            let departmentUsers = this.$store.getters.departmentUsersSuggestionsById( this.asset.department.id )
            // console.log("departmentUsersSuggestions", departmentUsers)

            if (typeof departmentUsers !== 'undefined') {
                return departmentUsers.data
            }
        },
        departmentRoomsSuggestions: function() {
            if(!this.asset.department){
                return
            }

            let departmentRooms = this.$store.getters.departmentRoomsSuggestionsById( this.asset.department.id )
            console.log("departmentRoomsSuggestions", departmentRooms)

            if (typeof departmentRooms !== 'undefined') {
                return departmentRooms.data
            }
        },
        transferCount: function(){
            return this.$store.state.transfers.receiving.map(o => o.transfers.length).reduce(function(a,b){return a+b}, 0)
        }


    },

    mounted: function(){
        let vm = this
        vm.$store.dispatch('FETCH_DEPARTMENTS_SUGGESSTIONS')
        // console.log("Inventory Actions Mounted")

    },

    created: function(){
        console.log("Inventory Actions Created", this.gridApi)


    }
}
</script>

<style scoped>
.panelHeader{
    font-size: 1.5em;
}
</style>

