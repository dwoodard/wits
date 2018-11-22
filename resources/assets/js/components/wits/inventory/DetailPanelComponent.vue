<template>
    <div class="full-width-panel"  >

        <ui-tabs type="text" fullwidth raised>
            <ui-tab title="Details">

                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">

                        <p v-if="asset.media[0]">
                            <img :src="asset.media[0].path" width="250"/>
                            <button class="btn btn-default" @click="onDeleteThumb(asset, asset.media[0])"> <i class="fa fa-trash"></i></button>
                        </p>

                        <div>Asset Picture:

                            <ui-fileupload
                            accept="image/*"
                            :name="'thumbnail-'+asset.id"
                            @change="onUpdateImage($event, asset)"
                            >Select an image</ui-fileupload>

                            <div class="page__demo-preview" v-if="previewUpdateImage.length > 0">
                                <img class="page__demo-preview-image" :src="previewUpdateImage" width="250">
                            </div>

                        </div>
                        <div>Asset Id: {{asset.id}}</div>

                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4">

                        <p>Label:
                            <xeditable field="label"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.label"
                            :store="asset"
                            ></xeditable>
                        </p>

                        <p>Description:
                            <xeditable field="description"
                            type="textarea"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.description"></xeditable>
                        </p>

                        <p>Department: {{asset.department.name}} </p>

                        <!-- <p>Steward:
                            <xeditable field="user_id"
                            type="select"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="departmentUsersSuggestionsFind(asset.department_id, asset.user_id).text"
                            :options="{
                                value: asset.user_id,
                                source: departmentUsersSuggestions
                            }"></xeditable>
                        </p> -->

                        <p>Category:
                            <xeditable field="category"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.category"
                            ></xeditable>
                        </p>

                        <p>Lifecycle:
                            <xeditable field="lifecycle"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.lifecycle"
                            ></xeditable>
                        </p>

                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <p>Weber Inventory Tag:
                            <xeditable field="weber_inventory_tag"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.weber_inventory_tag"></xeditable>
                        </p>

                        <p>Acquired:
                            <xeditable field="acquisition_date"
                            type="date"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.acquisition_date"
                            :options="{}"
                            ></xeditable>
                        </p>


                        <p>Serial Number:
                            <xeditable field="serial_number"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.serial_number"></xeditable>
                        </p>

                        <p>Manufacturer:
                            <xeditable field="manufacturer"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.manufacturer"></xeditable>
                        </p>

                        <p>Model:
                            <xeditable field="model"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.model"></xeditable>
                        </p>

                        <p>Created At:
                            <span>{{asset.created_at}}</span>
                        </p>

                        <p>Updated At:
                            <span>{{asset.updated_at}}</span>
                        </p>
                    </div>

                </div>

            </ui-tab>

            <ui-tab title="Location" @select="onSelectResize" >

                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <p>Room:
                            <xeditable field="room_id"
                            type="select"
                            inputclass="testClass"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :options="{
                                value: asset.room_id,
                                source: departmentRoomsSuggestionsForXeditable
                            }"> </xeditable>
                        </p>

                        <p>Name:
                            <span v-if="asset.room">{{asset.room.name}}</span>
                        </p>

                        <p>Campus:
                            <span v-if="asset.room">{{asset.room.building.campus.name}}</span>
                        </p>

                        <p>Number:
                            <span v-if="asset.room">{{asset.room.number}}</span>
                        </p>

                        <p>Building:
                            <span v-if="asset.room">{{asset.room.building.name}}</span>
                        </p>

                        <p>Style:
                            <span v-if="asset.room && asset.room.roomstyle">{{asset.room.roomstyle.name}} </span>
                        </p>

                        <p>Capacity:
                            <span v-if="asset.room">{{asset.room.capacity}}</span>
                        </p>

                        <p>LAT LONG:
                            <span v-if="asset.room">{{asset.room.latlong}}</span>
                        </p>

                    </div>

                    <div class="col-xs-12 col-sm-6" v-if="asset.room">
                        <gmap-map v-if="!!Object.keys(JSON.parse(asset.room.latlong)).length" ref="map" :center="JSON.parse(asset.room.latlong)" :zoom="18" map-type-id="terrain" style="width: 100%; height: 200px">
                            <gmap-marker :position="JSON.parse(asset.room.latlong)"></gmap-marker>
                        </gmap-map>
                    </div>
                </div>

            </ui-tab>

            <ui-tab title="Purchasing">

                <div class="row">
                    <div class="col-xs-12 col-sm-6">

                        <p>Cost:
                            <xeditable field="cost"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.cost"></xeditable>
                        </p>

                        <p>Quantity:
                            <xeditable field="quantity"
                            type="number"
                            tpl="<input type='number' step='any'></input>"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.quantity"></xeditable>
                        </p>

                        <p>Acquisition Date:
                            <xeditable field="acquisition_date"
                            type="date"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.acquisition_date"
                            :options="{}"></xeditable>
                        </p>

                        <p>PO#:
                            <xeditable field="po_number"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.po_number"></xeditable>
                        </p>

                        <p>Category:
                            <xeditable field="category"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.category"
                            ></xeditable>
                        </p>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <p>Replacement Fiscal Year:
                            <xeditable field="replacement_fiscal_year"
                            tpl="<div class='input-append date'> <input type='date'/> <span class='add-on'> <i class='icon-th'></i> </span> </div> "
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.replacement_fiscal_year"
                            :options="{}"></xeditable>
                        </p>

                        <p>Replacement Cost:
                            <xeditable field="replacement_cost_est"
                            type="number"
                            tpl="<input type='number' step='any'></input>"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.replacement_cost_est"
                            :options="{}"></xeditable>
                        </p>

                        <p>Replacement ID:
                            <xeditable field="replacement_id"
                            type="number"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.replacement_id"
                            :options="{}"></xeditable>
                        </p>

                        <p>Last Audit:
                            <xeditable field="last_audit"
                            type="date"
                            :pk="asset.id"
                            :url="'/api/v1/asset/'+asset.id"
                            :value="asset.last_audit"
                            :options="{}"></xeditable>
                        </p>
                    </div>
                </div>

            </ui-tab>

            <ui-tab title="properties">
                <properties :id="asset.id" :propertiesData="asset.properties"></properties>
            </ui-tab>

            <ui-tab title="History">
                <history :assetHistory="asset.revision_history" :properties="asset.properties" ></history>
            </ui-tab>

            <!-- <ui-tab title="Checkout">

            </ui-tab> -->

        </ui-tabs>


    </div>

</template>

<script>
import Vue from 'vue'
import { AgGridVue } from 'ag-grid-vue'
import store from '../../../vuex/store.js'
import Properties from '../components/properties.vue'
import History from '../components/history.vue'

import * as VueGoogleMaps from 'vue2-google-maps'

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyBaB3pP8S65JEZ9gvA5XxYn5urVMgpoxuU',
        v: '3.29'
    }
})

export default Vue.extend({
    name: 'detail-panel-component',
    data: function() {
        return {
            gridOptions: null,
            colDefs: null,
            rowData: null,

            previewImage: '',
            previewUpdateImage: '',
            thumbnail: new FormData()
        }
    },
    store,

    components: {
        'ag-grid-vue': AgGridVue,
        properties: Properties,
        history: History
    },
    computed: {
        asset: function(){
            return this.params.data
        },
        categorySuggestions: function() {
            return this.$store.getters.categories
        },

        departmentUsersSuggestions: function() {
            console.log("departmentUsersSuggestions")
            let departmentData = this.$store.getters.departmentUsersSuggestionsById(
                this.params.data.department_id
            )
            if (typeof departmentData !== 'undefined') {
                return departmentData.data
            }
        },

        departmentRoomsSuggestions: function() {
            let departmentRooms = this.$store.getters.departmentRoomsSuggestionsById(
                this.params.data.department_id
            )
            // console.log(this, departmentRooms)
            if (typeof departmentRooms !== 'undefined') {
                return departmentRooms
            }
        },

        departmentRoomsSuggestionsForXeditable: function() {
            // console.log('departmentRoomsSuggestionsForXeditable', this)
            let rooms = this.$store.getters.departmentRoomsSuggestionsById(
                this.params.data.department_id
            )

            if (rooms && rooms.data) {
                return _.map(rooms.data, function(item) {
                    return {
                        text: item.building.name + ' -  ' + item.number,
                        value: item.id
                    }
                })
            }
        }
    },

    methods: {
        onSelectResize() {
            let vm = this
            // console.log(vm.$refs.map)
            Vue.$gmapDefaultResizeBus.$emit('resize')
        },

        onFileChange(files, event) {
            this.previewImage = URL.createObjectURL(files[0])
            console.log('onFileChange', files, event)
        },

        onUpdateImage(files, asset) {
            let vm = this
            this.previewUpdateImage = URL.createObjectURL(files[0])

            console.log('onUpdateImage', files, asset)

            //do upload thing
            let data = new FormData()
            let config = {}
            data.append('media', files[0], files[0].name)
            config = { headers: { 'Content-Type': 'multipart/form-data' } }

            //after postAsset returns successful add media (if has media)
            axios
                .post('/api/v1/asset/' + asset.id + '/add-media', data, config)
                .then(function(response) {
                    let asset = response.data
                    toastr.success(
                        'Updated Asset: ' + asset.label + ' {' + asset.id + '}'
                    )


                    console.log(vm.params.data.media, asset);
                    vm.params.data.media = asset.media
                    vm.previewUpdateImage = ''
                })
                .catch(function(error) {
                    toastr.error('Failed to Update')

                    console.log(error)
                })
        },

        onDeleteThumb: function(row, media) {
            let vm = this

            // asset/{id}/delete-media/{media_id}
            $.confirm({
                title: 'Delete Thumbnail',
                content: 'Ok... if your absolutely positive',
                icon: 'fa fa-exclamation-triangle',
                animation: 'zoom',
                closeAnimation: 'zoom',
                buttons: {
                    confirm: {
                        text: 'DELETE!',
                        btnClass: 'btn-red',
                        action: function() {
                            console.log(media)
                            axios
                                .delete(
                                    '/api/v1/asset/' +
                                        row.id +
                                        '/delete-media/' +
                                        media.id
                                )
                                .then(function(response) {
                                    let asset = response.data
                                    console.log(asset)

                                    let index = row.media.findIndex(
                                        media => media.id === media.id
                                    )
                                    row.media.splice(index, 1)
                                })
                        }
                    },
                    close: {
                        text: 'Close'
                    }
                }
            })
        },

        onGridReady(params) {
            let detailGridId = 'detail_' + this.rowIndex

            let gridInfo = {
                id: detailGridId,
                api: this.params.api,
                columnApi: this.params.columnApi
            }

            console.log('adding detail grid info with id: ', detailGridId)
            this.masterGridApi.addDetailGridInfo(detailGridId, gridInfo)
        },

        // categorySuggestionsFind: function(category_id) {
        //     if (this.categorySuggestions) {
        //         if (this.categorySuggestions.find) {
        //             let _categorySuggestionsFind = this.categorySuggestions.find(
        //                 function(i) {
        //                     return i.value == category_id
        //                 }
        //             )

        //             if (_categorySuggestionsFind) {
        //                 return _categorySuggestionsFind.text
        //             }
        //         }
        //     } else {
        //         return null
        //     }
        // },

        departmentUsersSuggestionsFind: function(department_id, user_id) {
            console.log("departmentUsersSuggestionsFind", user_id)
            if(this.$store.state.suggestions.departmentUsers.length){
                return this.$store.state.suggestions.departmentUsers[department_id].find( i => i.value == user_id )
            }

        },

    },

    beforeDestroy() {
        let detailGridId = 'detail_' + this.rowIndex
        // console.log('removing detail grid info with id: ', detailGridId)
        this.masterGridApi.removeDetailGridInfo(detailGridId)
    },
    beforeMount() {
        // console.log('beforeMount')
        this.$store.dispatch( 'FETCH_DEPARTMENTS_ROOMS_SUGGESSTIONS', this.params.data.department_id )
    },

    mounted() {
        // console.log('DetailPanelComponent.vue mounted')
        this.rowData = this.params.data.callRecords
        this.rowIndex = this.params.rowIndex
        this.masterGridApi = this.params.api
    }
})
</script>

<style>
.full-width-panel {
  position: relative;
  background: #fafafa;
  height: 100%;
  width: 100%;
  padding: 5px;
  box-sizing: border-box;
  border-left: 2px solid grey;
  border-bottom: 2px solid lightgray;
  border-right: 2px solid lightgray;
}

.full-width-grid {
  margin-left: 150px;
  padding-top: 25px;
  box-sizing: border-box;
  display: block;
  height: 100%;
}
</style>

