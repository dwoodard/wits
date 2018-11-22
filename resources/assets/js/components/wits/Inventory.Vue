<template>
    <div v-if="rowData">

        <inventory-actions ref="inventoryActions" :gridApi="gridApi" :currentUser="currentUser"> </inventory-actions>

        <ag-grid-vue style="height: 80vh;" class="ag-theme-bootstrap"
                    :editable="true"
                    :components="components"

                    :gridOptions="gridOptions"
                    :columnDefs="columnDefs"
                    :rowData="rowData"
                    :showToolPanel="true"

                    :enableColResize="true"

                    :suppressRowClickSelection="true"
                    rowSelection="multiple"
                    rowGroupPanelShow="always"


                    :gridReady="onGridReady"
                    :modelUpdated="onModelUpdated"
                    :cellClicked="onCellClicked"
                    :cellDoubleClicked="onCellDoubleClicked"
                    :cellContextMenu="onCellContextMenu"
                    :cellValueChanged="onCellValueChanged"
                    :cellFocused="onCellFocused"
                    :rowSelected="onRowSelected"
                    :selectionChanged="onSelectionChanged"
                    :beforeFilterChanged="onBeforeFilterChanged"
                    :afterFilterChanged="onAfterFilterChanged"
                    :filterModified="onFilterModified"
                    :beforeSortChanged="onBeforeSortChanged"
                    :afterSortChanged="onAfterSortChanged"
                    :virtualRowRemoved="onVirtualRowRemoved"
                    :rowClicked="onRowClicked"
                    :getRowHeight="getRowHeight"

                    :columnEverythingChanged="onColumnEvent"
                    :columnRowGroupChanged="onColumnEvent"
                    :columnValueChanged="onColumnEvent"
                    :columnMoved="onColumnEvent"
                    :columnVisible="onColumnEvent"
                    :columnGroupOpened="onColumnEvent"
                    :columnResized="onColumnEvent"
                    :columnPinnedCountChanged="onColumnEvent"

                    > </ag-grid-vue>




    </div>
</template>

<script>
import Vue from 'vue'

import { mapState, mapMutations } from 'vuex'
import { AgGridVue } from 'ag-grid-vue'
import 'ag-grid-enterprise'

import DetailPanelComponent from './inventory/DetailPanelComponent.vue'
import Properties from './components/properties.vue'
import store from '../../vuex/store.js'

import StewardEditorComponent from './components/Editors/StewardEditorComponent.vue'


import InventoryActions from './inventory/InventoryActions.vue'
Vue.component('inventory-actions', InventoryActions)

export default {
    data: function() {
        return {
            gridOptions: {},
            gridApi: null,
            columnApi: null,
            columnDefs: null,
            detailCellRendererParams: null,
            defaultColDef: null,
            rowData: [],

            components: null,

            asset: {
                label: '',
                description: '',
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
            detailRowHeight: null,
            detailCellRenderer: null,
            frameworkComponents: null
        }
    },

    store,

    components: {
        'ag-grid-vue': AgGridVue,
    },

    computed: {
        currentUser: function() {
            return this.$store.getters.currentUser
        }
    },

    methods: {
        getDatePicker() {
            function Datepicker() {}
            Datepicker.prototype.init = function(params) {
                this.eInput = document.createElement('input')
                this.eInput.value = params.value
                this.eInput.type = 'date'
            }
            Datepicker.prototype.getGui = function() {
                return this.eInput
            }
            Datepicker.prototype.afterGuiAttached = function() {
                this.eInput.focus()
                this.eInput.select()
            }
            Datepicker.prototype.getValue = function() {
                return this.eInput.value
            }
            Datepicker.prototype.destroy = function() {}
            Datepicker.prototype.isPopup = function() {
                return false
            }
            return Datepicker
        },
        isFullWidthCell(rowNode) {
            return rowNode.level === 1
        },
        getNodeChildDetails(record) {
            // console.log( record)
            if (record.label) {
                return {
                    group: true,
                    // the key is used by the default group cellRenderer
                    key: record.department,
                    // provide ag-Grid with the children of this group
                    children: [record.label]
                }
            } else {
                return null
            }
        },
        onGridReady(params) {
            let vm = this

            this.gridApi = params.api
            this.columnApi = params.columnApi

            this.gridOptions.api.sizeColumnsToFit()

            // console.log('onGridReady')
        },
        onCellValueChanged(event) {
            console.log('onCellValueChanged', event)
            this.saveRow(event)
        },
        onModelUpdated(e) {
            // console.log('onModelUpdated', e)
        },
        onCellClicked() {
            // console.log('onCellClicked')
        },
        onCellDoubleClicked() {
            // console.log('onCellDoubleClicked')
        },
        onCellContextMenu() {
            // console.log('onCellContextMenu')
        },
        onCellFocused(e) {
            // console.log('onCellFocused', e)
        },
        onRowSelected() {
            // console.log('Inventory onRowSelected', )
            this.$refs.inventoryActions.onRowSelected(
                this.gridApi.getSelectedNodes()
            )
        },
        onSelectionChanged() {
            // console.log('onSelectionChanged')
        },
        onBeforeFilterChanged() {
            // console.log('onBeforeFilterChanged')
        },
        onAfterFilterChanged() {
            // console.log('onAfterFilterChanged')
        },
        onFilterModified() {
            // console.log('onFilterModified')
        },
        onBeforeSortChanged() {
            // console.log('onBeforeSortChanged')
        },
        onAfterSortChanged() {
            // console.log('onAfterSortChanged')
        },
        onVirtualRowRemoved() {
            // console.log('onVirtualRowRemoved')
        },
        onRowClicked() {
            // console.log('onRowClicked')
        },
        onColumnEvent(event) {
            switch (event.type) {
                case 'columnResized':
                    // console.log('columnResized.')
                    break
                case 'columnVisible':
                    if (
                        event.column &&
                        event.column.colId == 'media' &&
                        event.column.visible == false
                    ) {
                        // console.log('columnVisible false')
                        event.api.setGridAutoHeight(25)

                        // event.api.onRowHeightChanged()
                        // setTimeout(function(){event.api.refreshView(),0})

                        event.api.forEachNode(function(node) {
                            node.setRowHeight(25)
                        })
                        setTimeout(function() {
                            event.api.onRowHeightChanged()
                        }, 0)
                    }

                    break
                default:
                    // console.log('switch default onColumnEvent: ', event)
                    break
            }
        },
        onQuickFilterChanged(event) {
            this.gridOptions.api.setQuickFilter(event.target.value)
        },
        saveRow(row) {

            let that = this
            let field = row.colDef.altField ? row.colDef.altField : row.colDef.field

            if(field == "user_id"){
                return false
            }

            console.log("saveRow", row.data.id, field, row.newValue, row.data.user_id)

            axios //'api/v1/asset/' + '[asset_id]'
                .put(row.colDef.url + row.data.id, {
                    pk: row.data.id,
                    name: field,
                    value: row.newValue
                })
                .then(function(result) {
                    console.log(result)
                    // var rowNode = row.api.getRowNode(row.data.id);
                    // rowNode.setData(result.data)
                    // rowNode.gridApi.redrawRows()

                })
        }
    },

    beforeMount() {
        let vm = this

        this.groupColumn = {
            headerName: 'Group',
            headerTooltip: 'Grouped Column(s)' + Math.random(),
            pinned: 'left',

            // minWidth: 50,
            field: 'name',
            headerCheckboxSelection: true,
            headerCheckboxSelectionFilteredOnly: true,
            cellRenderer: 'agGroupCellRenderer',
            cellRendererParams: {
                checkboxSelection: true,
                checkbox: true
            }
        }

        this.gridOptions = {
            animateRows: true,
            defaultColDef: {
                editable: true,
                enableRowGroup: true,
                minWidth: 120,
                rowDragManaged: true,
                filter: 'agTextColumnFilter',
                filterParams: {
                    clearButton: true
                }
            },

            context: { componentParent: this },
            floatingFilter: true,
            masterDetail: true,
            detailCellRenderer: 'detailPanelComponent',
            frameworkComponents: {
                detailPanelComponent: DetailPanelComponent,
                properties: Properties
            },
            refreshCells: true,
            enableStatusBar: true,
            enableRangeSelection: true,
            enableSorting: true,
            quickFilterText: null,
            groupSelectsChildren: true,
            suppressRowClickSelection: true, // if true, clicking rows doesn't select (useful for checkbox selection)
            suppressCopyRowsToClipboard: true,
            suppressClipboardPaste: true,
            autoGroupColumnDef: this.groupColumn
            // groupUseEntireRow: true
        }

        this.gridOptions.getRowNodeId =  function(data) {
            return data.id;
        },

        this.columnDefs = [
            {
                headerName: 'Wits ID',
                headerTooltip: 'Wits ID',
                field: 'id',
                editable: false,
                hide: true,
                url: '/api/v1/asset/'
            },
            {
                headerName: 'media',
                headerTooltip: 'Images of Asset',
                field: 'media',
                hide: true,
                autoHeight: true,
                maxWidth: 200,
                cellRenderer: function(params) {
                    if (
                        params.api.gridOptionsWrapper.gridOptions.columnApi.getColumn(
                            'media'
                        ).visible == false
                    ) {
                        params.node.setRowHeight(25)
                        params.api.onRowHeightChanged()
                        return ``
                    }

                    if (!params.data && params.value && !params.value.length) {
                        return ``
                    }

                    if (
                        !!params.api.gridOptionsWrapper.gridOptions.columnApi.getColumn(
                            'media'
                        ).visible &&
                        params.value &&
                        !!params.value[0]
                    ) {
                        // console.log('show and resize')
                        params.node.setRowHeight(200)
                        params.api.onRowHeightChanged()
                        return `<img src="${
                            params.value[0].path
                        }" style="height: auto;margin: 0 auto;width:100%;" />`
                    }

                    // console.log('hide and resize')
                    // params.node.setRowHeight(25)
                    // params.api.onRowHeightChanged()
                    // return ``
                }
            },
            {
                headerName: 'Label',
                headerTooltip: 'A recognizable Name',
                field: 'label',
                pinned: 'left',
                checkboxSelection: true,
                cellRenderer: 'agGroupCellRenderer',
                url: '/api/v1/asset/'
            },
            {
                headerName: 'Weber Inventory Tag',
                headerTooltip: 'Weber Inventory Tag',
                field: 'weber_inventory_tag',
                url: '/api/v1/asset/',
                valueGetter: function(params) {
                    if(params.data && params.data.weber_inventory_tag){
                        return params.data.weber_inventory_tag
                    }
                    else{
                        return "---"
                    }
                }
            },
            {
                headerName: 'Steward',
                headerTooltip: 'Person incharge of the asset',
                // field: 'user_id',
                valueGetter: function(params) {
                    // return params.data.user_id
                    if (params.data) {
                        return `${params.data.users.first_name} ${ params.data.users.last_name}`
                    }
                    return null
                },

                valueSetter: function(params) {
                    console.log("valueSetter", params.newValue)

                    if(params.oldValue !== params.newValue){
                        params.data.user_id = params.newValue
                        return true
                    }

                },

                cellEditorFramework: StewardEditorComponent,
                cellRenderer: function(params) {
                    // HACK!!!! Just need to see the output after it was value was changed, Sorry Future Dev(s), best I could do!
                    // look at StewardEditorComponent getValue in connections with this hack.

                    if(params && params.data){
                        if(typeof params.data.user_id == 'number'){
                            return `${params.data.users.first_name} ${params.data.users.last_name}`
                        }
                        else{
                            return params.data.user_id
                        }
                    }
                    else{
                        // console.log("no params",params.value)
                        return params.value
                    }

                },
                altField: 'user_id',
                url: '/api/v1/asset/'
            },
            {
                headerName: 'Department',
                headerTooltip: 'Department',
                field: 'department.name',
                altField: 'department_id',
                url: '/api/v1/asset/'
            },

            {
                headerName: 'Category',
                headerTooltip: 'category name',
                field: 'category',
                url: '/api/v1/asset/',
            },
            {
                headerName: 'Location',
                children: [
                    {
                        headerName: 'Campus',
                        headerTooltip: 'Example tooltip for Campus',
                        field: 'room.building.campus.name',
                        editable: false,
                        hide: true
                    },
                    {
                        headerName: 'Building',
                        headerTooltip: 'Example tooltip for building',
                        field: 'room.building.name',
                        editable: false
                        // hide: true
                    },
                    {
                        headerName: 'Room',
                        headerTooltip: 'Example tooltip for Room',
                        field: 'room.number',
                        editable: false
                        // hide: true
                    }

                ]
            },

            {
                headerName: 'Cost',
                headerTooltip: 'Cost of Asset',
                field: 'cost',
                filter: 'agNumberColumnFilter',
                url: '/api/v1/asset/',
                aggFunc: 'sum',
                enableValue: true,
                cellStyle: {textAlign: "right"},
                valueGetter: function(params){
                    return Number(params.data.cost)
                },
                valueFormatter: function(params){
                    // console.log(params.data)
                    if(params.data == undefined){
                        return Number(params.value).toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    });
                    }

                    return Number(params.data.cost).toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    });
                }
            },

            {
                headerName: 'Details',
                // hide: true,
                children: [
                    {
                        headerName: 'Manufacturer',
                        headerTooltip: 'Example tooltip for manufacturer',
                        field: 'manufacturer',
                        url: '/api/v1/asset/',
                        valueGetter: function(params) {
                            if(params.data && params.data.manufacturer){
                                return params.data.manufacturer
                            }
                            else{
                                return "---"
                            }

                        }
                    },

                    {
                        headerName: 'Model',
                        headerTooltip: 'Example tooltip for model',
                        field: 'model',
                        url: '/api/v1/asset/',
                        valueGetter: function(params) {
                            if(params.data && params.data.model){
                                return params.data.model
                            }
                            else{
                                return "---"
                            }
                        }
                    },
                    {
                        headerName: 'serial_number',
                        headerTooltip: 'Example tooltip for serial_number',
                        enableRowGroup: false,
                        field: 'serial_number',
                        url: '/api/v1/asset/',
                        valueGetter: function(params) {
                            if(params.data && params.data.serial_number){
                                return params.data.serial_number
                            }
                            else{
                                return "---"
                            }
                        }
                    }
                ]
            },
             {
                headerName: 'Budget Planning',
                children: [
                    {
                        headerName: 'Replacment Eligible',
                        headerTooltip: 'Example tooltip for Replacment Eligible',
                        valueGetter: function(params) {
                            if(params.data == undefined){
                                return
                            }

                            if(!!params.data.replacement_fiscal_year){
                                return "scheduled for fiscal year"
                            }

                            if( params.data.acquisition_year && params.data.lifecycle){
                                return (new Date).getFullYear() > (params.data.acquisition_year + params.data.lifecycle) ? "replace eligible" : "not eligible"
                            }
                            else{
                                // console.log(params.data.id,params.data.replacement_fiscal_year,params.data.acquisition_year, params.data.lifecycle)
                                return "no lifecycle or year"
                            }
                        },
                        editable: false,
                    },
                    {
                        headerName: 'Replacement Fiscal Year',
                        headerTooltip: 'Enter the Last Year of the fiscal year',
                        field: 'replacement_fiscal_year',
                        url: '/api/v1/asset/',
                        type: 'numberColumn',
                        filter: 'agNumberColumnFilter',
                        width: 175,
                        minWidth: 175,

                        // hide: true,

                        valueGetter: function(params){
                            // console.log("valueGetter",params.data.replacement_fiscal_year)
                            if(params.data && params.data.replacement_fiscal_year){
                                return params.data.replacement_fiscal_year
                            }
                            else{
                                return ""
                            }
                        },


                        valueFormatter: function(params){
                            // console.log(params)
                            if(params.value === ""){
                                return ""
                            }
                            if(params.data && params.data.replacement_fiscal_year == null){
                                return null
                            }

                            var fiscal1
                            var fiscal2
                            var fiscal

                            if(params.data == undefined){
                                fiscal = params.value
                            }
                            else if(params.value !== null){
                                fiscal = params.data.replacement_fiscal_year
                            }

                            fiscal2 = Number(fiscal)
                            fiscal1 = fiscal2 - 1

                            return `${fiscal1} - ${fiscal2}`

                        },

                    },
                    {
                        headerName: 'Replacement Cost Estimate',
                        headerTooltip:
                            'Replacement Cost Estimate',
                        field: 'replacement_cost_est',
                        url: '/api/v1/asset/',
                        type: 'numberColumn',
                        // hide: true,
                        aggFunc: 'sum',
                        enableValue: true,
                        valueGetter: function(params){
                            return Number(params.data.replacement_cost_est)
                        },
                        valueFormatter: function(params){
                            // console.log(params.data)
                            if(params.data == undefined){
                                return Number(params.value).toLocaleString('en-US', {
                            style: 'currency',
                            currency: 'USD',
                            });
                            }

                            return Number(params.data.replacement_cost_est).toLocaleString('en-US', {
                            style: 'currency',
                            currency: 'USD',
                            });
                        }
                    },


                ]
            },

            {
                headerName: 'Lifecycle',
                headerTooltip: '(Lifecycle) Years to Estimated replacement ',
                // field: 'lifecycle',
                valueGetter: function(params) {
                            if(params.data && params.data.lifecycle){
                                return params.data.lifecycle
                            }
                            else{
                                return ""
                            }
                        },
                url: '/api/v1/asset/',
                hide: true

            },

            {
                headerName: 'Dates',
                children: [
                    {
                        headerName: 'Acquired year',
                        headerTooltip: 'Example tooltip for acquisition_year',
                        field: 'acquisition_year',
                        editable: false,
                    },

                    {
                        headerName: 'Acquired date',
                        headerTooltip: 'Example tooltip for acquisition_date',
                        field: 'acquisition_date',
                        url: '/api/v1/asset/',
                        cellEditor: 'datePicker',
                        hide: true,
                        width: 175,
                        minWidth: 175,
                    },
                    {
                        headerName: 'Year Created',
                        headerTooltip: 'Example tooltip for created_at_year',
                        field: 'created_at_year',
                        hide: true,
                        editable: false,
                    },

                    {
                        headerName: 'Audited Last',
                        headerTooltip: 'Example tooltip for last_audit',
                        field: 'last_audit',
                        url: '/api/v1/asset/',
                        cellEditor: 'datePicker',
                        width: 175,
                        minWidth: 175,
                    },

                    {
                        headerName: 'Created',
                        headerTooltip: 'Date it was added to database',
                        field: 'created_at',
                        hide: true,
                        editable: false,
                    },
                    {
                        headerName: 'Updated Last',
                        headerTooltip: 'Last edited Date in the database',
                        field: 'updated_at',
                        type: ['dateColumn'],
                        hide: true,
                        editable: false,
                    }
                ]
            },

            {
                headerName: 'PO Number',
                headerTooltip: 'Example tooltip for po_number',
                field: 'po_number',
                hide: true,
                url: '/api/v1/asset/',
                valueGetter: function(params) {
                    if(params.data && params.data.po_number){
                        return params.data.po_number
                    }
                    else{
                        return "---"
                    }
                }
            },







            {
                hide: true,
                headerName: 'Properties',
                headerTooltip: 'Example tooltip for Properties',
                valueGetter: function(params) {
                    let props = []
                    if (params.data && params.data.properties) {
                        for (var prop in params.data.properties) {
                            props.push(
                                `${params.data.properties[prop].name}: ${
                                    params.data.properties[prop].value
                                } `
                            )
                        }
                        return props.toString()
                    }

                    // if (params.data) { return `${params.data.properties} ${ params.data.users.last_name }` }
                    return null
                }
            },
            {
                headerName: 'Description',
                headerTooltip: 'Example tooltip for description',
                field: 'description',
                url: '/api/v1/asset/'
            },
            {
                headerName: 'Quantity',
                headerTooltip: 'Example tooltip for quantity',
                field: 'quantity',
                type: 'numberColumn',
                url: '/api/v1/asset/',
                hide: true
            },
            {
                headerName: 'replacement_id',
                headerTooltip: 'Example tooltip for replacement_id',
                field: 'replacement_id',
                url: '/api/v1/asset/',
                type: 'numberColumn',
                hide: true
            },
            {
                headerName: 'Changes',
                headerTooltip: 'Example tooltip for Changes',
                field: 'revision_history.length',
                type: 'numberColumn',
                hide: true
            },
            {
                headerName: 'Room Style',
                headerTooltip: 'Room type',
                field: 'room.roomstyle.name',
                editable: false,
                hide: true
            }
        ]

        this.components = {
            datePicker: this.getDatePicker()
        }

        this.getRowHeight = params => {
            if (params.node && params.node.detail) {
                var offset = 80
                var allDetailRowHeight = 500 //params.data.callRecords.length * 28;
                return allDetailRowHeight + offset
            } else {
                return 25
            }
        }
    },

    created() {
        console.log('Inventory Created', this.$store.state.currentUser)
        // this.$store.dispatch('FETCH_ALL_TRANSFERS_BY_FIELD')

    },

    mounted() {
        let vm = this

        // console.log('Inventory Mounted')

        axios
        .get('/api/v1/currentuser/departments')
        .then(result => {
            // add check if admin,
            // if it is get all departments,
            // otherwise get nested departments

            let roles = result.data.currentUser.roles.map(
                value => value.name
            )

            if (roles.includes('admin')) {
                return axios.get(
                    '/api/v1/asset?' +
                        'with=' +
                        'media,' +
                        'department,' +
                        'room,' +
                        'room.roomstyle,' +
                        'room.building,' +
                        'room.building.campus,' +
                        'checkout,' +
                        'properties,' +
                        'properties.revisionHistory,' +
                        'revisionHistory,' +
                        'transfer,' +
                        'transfer.revisionHistory,' +
                        'users'
                )
            }

            if (roles.includes('department_admin')) {
                // department_admin

                return axios.get(
                    '/api/v1/asset?' +
                        'wherein=department_id,' +
                        result.data.departments_ids.toString() +
                        '&' +
                        'with=' +
                        'media,' +
                        'department,' +
                        'room,' +
                        'room.roomstyle,' +
                        'room.building,' +
                        'room.building.campus,' +
                        'checkout,' +
                        'properties,' +
                        'properties.revisionHistory,' +
                        'revisionHistory,' +
                        'transfer,' +
                        'transfer.revisionHistory,' +
                        'users'
                )
            }

            if (roles.includes('department_user')) {
                // department_user

                return axios.get(
                    '/api/v1/asset?' +
                        'wherein=department_id,' +
                        result.data.currentUser.departments
                            .map(o => o.id)
                            .toString() +
                        '&' +
                        'with=' +
                        'media,' +
                        'department,' +
                        'room,' +
                        'room.roomstyle,' +
                        'room.building,' +
                        'room.building.campus,' +
                        'checkout,' +
                        'properties,' +
                        'properties.revisionHistory,' +
                        'revisionHistory,' +
                        'transfer,' +
                        'transfer.revisionHistory,' +
                        'users'
                )
            }
        })
        .then(response => {
            // console.log('Response', response)
            _.each(response.data, function(value, key) {
                Vue.set( value, 'acquisition_year', new Date(value.acquisition_date).getFullYear()  )
                Vue.set( value, 'created_at_year', new Date(value.created_at).getFullYear() )
            })
            // console.log('assets, response.data', response.data)
            vm.$store.state.inventory = vm.rowData = response.data
        })


        // vm.$store.dispatch('FETCH_DEPARTMENTS_USERS_SUGGESSTIONS')
        vm.$store.dispatch('FETCH_ALL_TRANSFERS')

        // console.log(this.$store.state.currentUser.department_id, 'old_department_id')
    }
}
</script>

<style>
.ag-row {
  border-bottom: 1px solid lightgrey;
}
.ag-row-level-0 {
  background-color: #fff !important;
}
.ag-row-level-1 {
  background-color: #eee !important;
}
.ag-row-level-2 {
  background-color: #ddd !important;
}

.ag-row-hover .ag-cell {
  background: rgba(73,35,101,0.75) !important;
  color: #ccc !important;
}

.ag-row-hover .ag-cell-edit-input {
  color: #000;
}
.ag-header-cell-resize {
  border-left: 1px solid #e0e0df;
}
</style>
