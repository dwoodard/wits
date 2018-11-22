<template>
    <div id="BulkUploaderContainer">
        <form-wizard
        @on-complete="onComplete"
        @on-validate="handleValidation"
        @on-error="handleErrorMessage"
        :startIndex="0"
        color="#337ab7"
        error-color="tomato"
        title="Bulk Uploader"
        subtitle="">

            <tab-content title="Download & Fill out CSV">

                <div class="container">
                    <div class="row">


                        <div class="col-sm-12 col-xs-12">
                            <h3>Download File</h3>


                            <div class="col-sm-6">
                                <p>
                                    This is a template of a CSV file (Comma seperated values).
                                    It has pre-populated columns that will be expected for the uploading process.
                                    While all fields may not be required do your best to fill in all fields
                                </p>
                                <p>
                                    Take your time to double check that all fields are correct.
                                    It will be easier to fix problems there than afterwards.
                                </p>
                                <p>
                                    Some Columns will have a astrix <b>asterix *</b> meaning these are required. Some will
                                    have 2 <b>asterix **</b> meaning they are run though a validator in order to be uploaded.
                                </p>
                                <p>
                                    Start you entries on line 3
                                </p>

                            </div>
                            <div class="col-sm-5 col-md-offset-1 ">
                                <p>
                                    Download the CSV template. Fill in data, once done,
                                    move on to section 2 (Upload File)
                                </p>
                                <a href="/downloads/BulkUploadTemplate.csv">
                                    <span class="fa-layers fa-fw fa-6x">
                                        <i class="fas fa-file" style="color:#070"></i>
                                        <i class="fas fa-arrow-down fa-inverse" data-fa-transform="shrink-11.5 up-5 left-3 rotate--20"></i>
                                        <span class="fa-layers-text fa-inverse" data-fa-transform="shrink-11.5 down-1 rotate--20" style="font-weight:500">CSV</span>
                                        <span class="fa-layers-text fa-inverse" data-fa-transform="shrink-13.5 down-6 rotate--0" style="font-weight:100">Template</span>
                                    </span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </tab-content>

            <tab-content title="Upload File" :before-change="uploadFile">
                <div class="container">
                    <div class="row">

                        <div class="col-xs-12 col-md-5 col-md-offset-1">
                            <h3>Upload File:</h3>

                            <p>
                                Click <b>Choose file</b>. Browse to your upload file. Select file to upload then click next.
                            </p>

                            <h3>Validation</h3>
                            <ul>
                                <li>Make sure there are no commas in your fields. It will mess up the formatting of the file</li>
                            </ul>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading">Select file</div>
                                <div class="panel-body">
                                    <input type="file" name="bulkUploadFile">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </tab-content>

            <tab-content title="Validation">

                <ul class="nav nav-tabs">
                    <li class="active"> <a data-toggle="tab" href="#failed">Failed</a></li>
                    <li> <a data-toggle="tab" href="#passed">Passed</a></li>
                </ul>

                <div class="tab-content">

                    <div id="failed" class="tab-pane fade in active">

                        <!-- Download Failed -->
                        <p>
                            <a id="downloadFailedCSV"
                                class="btn btn-success"
                             @click.prevent="downloadFailedCSV">Download csv</a>
                        </p>

                        <div v-if="columns">
                            <vue-good-table
                            :columns="columns"
                            :rows="results.failed"
                            :lineNumbers="false"
                            :paginate="true"
                            :childrow="true"
                            :onClick="vueGoodTableRowClick"
                            styleClass="table table-bordered table-striped condensed vue-good-table ">

                                <template slot="table-row" scope="props">
                                    <td>{{props.row['row'][0]}}  </td>
                                    <td>{{props.row['row'][1]}}  </td>
                                    <td>{{props.row['row'][2]}}  </td>
                                    <td>{{props.row['row'][3]}}  </td>
                                    <td>{{props.row['row'][4]}}  </td>
                                    <td>{{props.row['row'][5]}}  </td>
                                    <td>{{props.row['row'][6]}}  </td>
                                    <td>{{props.row['row'][7]}}  </td>
                                    <td>{{props.row['row'][8]}}  </td>
                                    <td>{{props.row['row'][9]}}  </td>
                                    <td>{{props.row['row'][10]}} </td>
                                    <td>{{props.row['row'][11]}} </td>
                                    <td>{{props.row['row'][12]}} </td>
                                    <td>{{props.row['row'][13]}} </td>
                                    <td>{{props.row['row'][14]}} </td>
                                    <td>{{props.row['row'][15]}} </td>
                                    <td>{{props.row['row'][16]}} </td>
                                </template>


                                <template slot="childrow" scope="props" v-if="showChildRow">

                                    <ui-tabs type="text" fullwidth raised>
                                        <ui-tab>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <p>Row ID: {{props.row['row_id']}}</p>

                                                    <p>Type: {{props.row['type']}}</p>
                                                    <p>Errors:</p>
                                                    <ul v-for="(error, index) in props.row['errors']">
                                                        <li>{{error}}</li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </ui-tab>
                                    </ui-tabs>
                                </template>

                            </vue-good-table>
                        </div>

                    </div>

                    <div id="passed" class="tab-pane fade">
                        <h3>Passed</h3>

                        <div v-if="columns">
                            <vue-good-table :columns="columns" :rows="results.assets" :lineNumbers="false" :paginate="true" styleClass="table table-bordered table-striped condensed vue-good-table ">
                                <template slot="table-row" scope="props">
                                    <td>{{props.row.weber_inventory_tag}}</td>
                                    <td>{{props.row.category}}</td>
                                    <td>{{props.row.manufacturer}}</td>
                                    <td>{{props.row.vendor}}</td>
                                    <td>{{props.row.model}}</td>
                                    <td>{{props.row.wired_mac_address}}</td>
                                    <td>{{props.row.wireless_mac_address}}</td>
                                    <td>{{props.row.serial_number}}</td>
                                    <td>{{props.row.username}}</td>
                                    <td>{{props.row.building_code}}</td>
                                    <td>{{props.row.room_id}}</td>
                                    <td>{{props.row.acquisition_date}}</td>
                                    <td>{{props.row.cost}}</td>
                                    <td>{{props.row.po_number}}</td>
                                    <td>{{props.row.org_code}}</td>
                                    <td>{{props.row.label}}</td>
                                    <td>{{props.row.description_notes}}</td>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>

                </div>


            </tab-content>



            <div v-if="errorMsg">
              <span class="error">{{errorMsg}}</span>
            </div>

        </form-wizard>
    </div>
</template>

<script>
    import Vue from 'vue'

    import VueFormWizard from "vue-form-wizard";
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'

    Vue.use(VueFormWizard)

    export default {

        data () {
            return {
                errorMsg: null,
                results: {
                    assets:null
                }
            }
        },
        computed:{
            columns: function () {
                if(!this.results.headers){
                    return;
                }

                let columns = [];
                this.results.headers.forEach(function(i){
                    columns.push({label: i, sortable:true})
                });
                return columns;
            }
        },
        methods: {
            onComplete: function(){
                console.log(this)
                $('[id^=bulkUploadForm]').collapse('hide')
                // this.reset()
            },
            uploadFile: function () {
                console.log("uploadFile")
                let vm = this
                return new Promise((resolve, reject) => {
                    let bulkUploadFile = $("[name=bulkUploadFile]");
                    console.log("uploadFile", "bulkUploadFile",bulkUploadFile);

                    if(bulkUploadFile[0].files.length == 0){
                        reject('Need a file to upload')
                        return
                    }

                    if (!/\.csv/.test(bulkUploadFile[0].files[0].name)) {
                        reject('File needs to be a .csv')
                        return
                    }


                    //Ajax file up
                    let data = new FormData();
                    let config = { headers: { 'Content-Type': "multipart/form-data" }};
                    data.append( "upload", bulkUploadFile[0].files[0], bulkUploadFile[0].files[0].name );

                    if (bulkUploadFile[0].files[0] && bulkUploadFile[0].files[0].name) {
                        axios.post("/api/v1/bulkupload/assets", data, config)
                        .then(function(response){

                            vm.results = response.data

                            for (var i = 0; i < vm.results.assets.length; i++) {

                                if(vm.$store.state.inventory.id == vm.results.assets[i].department_id){
                                    Vue.set(vm.results.assets[i], 'selected', false)
                                    vm.$store.state.inventory.assets.unshift(vm.results.assets[i])
                                }
                            }

                            resolve(true)
                        })
                        .catch(error => {
                            reject(error)
                            console.log(error)
                        });
                    }

                    });

                    resolve(true)
            },

            downloadFailedCSV: function () {
                let vm = this

                var saveData = (function () {
                    var a = document.createElement("a");
                    document.body.appendChild(a);
                    a.style = "display: none";
                    return function (data, fileName) {
                        let blob = new Blob([data], {type: 'text/csv;charset=utf-8;'}),
                        url = window.URL.createObjectURL(blob);
                        a.href = url;
                        a.download = fileName;
                        a.click();
                        window.URL.revokeObjectURL(url);
                    };
                }());

                let failed = vm.results.failed
                let csvData = ""

                csvData += vm.results.headers.join(',') // headers
                csvData += "\r\n"
                csvData += Array(vm.results.headers.length-1).join(",") //example row
                csvData += "\r\n"

                vm.results.failed.forEach(function(rowItem){
                   let row = rowItem.row.join(",");
                   csvData += row + "\r\n";
                });

                csvData = csvData.replace(/([^\r])\n/g, "$1\r\n");
                saveData(csvData, 'failed.csv')
            },

            handleValidation: function(isValid, tabIndex){
                console.log('Tab: '+tabIndex+ ' valid: '+isValid)
            },
            handleErrorMessage: function(errorMsg){
                this.errorMsg = errorMsg
            },

            vueGoodTableRowClick: function(row, index) {
                let vm = this;
                console.log("onClick")
            },

       }
    }
</script>

<style>

span.error{
    color:#e74c3c;
    font-size:20px;
    display:flex;
    justify-content:center;
}
</style>
