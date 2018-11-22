<template>
  <div id="department-vue" class="container-fluid">
    <h2>Departments</h2>
    <aside class="col-md-3 col-xs-12">
      <ui-collapsible title="Add Department" open>


        <form @submit.prevent="onSubmitDepartment">

          <ui-textbox
          floating-label
          label="Department Name"
          v-model="formDepartment.name"
          :error="formDepartment.errors.get('name')"
          :invalid="!!formDepartment.errors.get('name')"
          @keydown="formDepartment.errors.clear('name')"

          />

          <ui-textbox
          floating-label
          label="Department Org Code"
          v-model="formDepartment.orgcode"
          :error="formDepartment.errors.get('orgcode')"
          :invalid="!!formDepartment.errors.get('orgcode')"
          @keydown="formDepartment.errors.clear('orgcode')"

          />

          <ui-textbox
          floating-label
          label="Primary Contact Name"
          v-model="formDepartment.primary_contact_name"
          :error="formDepartment.errors.get('primary_contact_name')"
          :invalid="!!formDepartment.errors.get('primary_contact_name')"
          @keydown="formDepartment.errors.clear('primary_contact_name')"
          />

          <ui-textbox
          type="number"
          floating-label
          label="Phone"
          v-model="formDepartment.phone"
          :error="formDepartment.errors.get('phone')"
          :invalid="!!formDepartment.errors.get('phone')"
          @keydown="formDepartment.errors.clear('phone')"
          />

          <ui-textbox
          type="text"
          floating-label
          label="Primary Contact Email"
          v-model="formDepartment.email"
          :error="formDepartment.errors.get('email')"
          :invalid="!!formDepartment.errors.get('email')"
          @keydown="formDepartment.errors.clear('email')"

          />


          <ui-select
          v-if="departments"
          has-search
          floating-label
          label="Parent Department"
          :options="departments"
          :keys="{label: 'name', value:'id'}"
          v-model="formDepartment.parent_department_id"
          :error="formDepartment.errors.get('parent_department_id')"
          :invalid="!!formDepartment.errors.get('parent_department_id')"
          @keydown="formDepartment.errors.clear('parent_department_id')"
          ></ui-select>


          <ui-button buttonType="submit" type="primary" color="primary" size="small">Add Department</ui-button>

        </form>

      </ui-collapsible>
    </aside>

    <div class="col-md-9 col-xs-12">

      <div class="col-sm-12">

        <div class="form-group">
          <div class="btn-group">

            <input v-model="search" class="form-control" type="text">
            <span id="searchclear"  @click="search = ''" class="glyphicon glyphicon-remove-circle"></span>

          </div>
        </div>


        <table class="table table-striped" style="border-collapse:collapse;">
          <thead>
            <tr>
              <th></th>
              <th>Name</th>
              <th>Primary Contact</th>
              <th>Org Code</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Parent Department</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <template v-for="(department, departmentKey) in results">
              <tr>
                <td data-toggle="collapse" :data-target="'#row'+departmentKey" class="accordion-toggle" aria-expanded="false">
                  <i class="fa fa-chevron-right fa-fw"></i>
                  <i class="fa fa-chevron-down fa-fw"></i>
                </td>
                <td><span class="">{{department.name}}</span></td>
                <td><span class="">{{department.primary_contact_name}}</span></td>
                <td><span class="">{{department.orgcode}}</span></td>
                <td><span class="">{{department.phone}}</span></td>
                <td><span class="">{{department.email}}</span></td>
                <td><span class="" v-if="department.parent" >{{department.parent.name}}</span> </td>
                <td @click="onDeleteDepartment(department)"><i class="fa fa-trash" ></i></td>
              </tr>

              <tr>
                <td colspan="7" style="padding: 0">
                    <div class="accordian-body collapse" :id="'row'+departmentKey">
                        <ui-tabs type="text" fullwidth raised>


                            <ui-tab title="Team">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(user, index) in department.users" :key="index">
                                            <td>{{user.first_name}}</td>
                                            <td>{{user.last_name}}</td>
                                            <td>{{user.email}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </ui-tab>

                            <ui-tab title="Rooms">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Campus</th>
                                            <th>Building</th>
                                            <th>Room</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(room, index) in department.rooms" :key="index">
                                            <td>{{room.building.campus.name}}</td>
                                            <td>{{room.building.name}}</td>
                                            <td>{{room.number +" - "+room.name || room.name ||room.number}}  </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </ui-tab>


                            <ui-tab title="Details">



                              <form class="form-horizontal" @submit.prevent="onUpdateDepartment(department)">

                                <div class="form-group row">
                                  <label class="col-sm-2 col-form-label"> Name: </label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control " v-model="department.name">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-2 col-form-label"> Primary Contact Name: </label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control " v-model="department.primary_contact_name">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-2 col-form-label"> Orgcode: </label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control " v-model="department.orgcode">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-2 col-form-label"> Phone: </label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control " v-model="department.phone">
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label class="col-sm-2 col-form-label"> Email:  </label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control " v-model="department.email ">
                                  </div>
                                </div>

                                 <div class="form-group row">
                                  <label class="col-sm-2 col-form-label"> Parent Department:  </label>
                                  <div class="col-sm-10">

                                    <ui-select
                                    v-if="departments"
                                    has-search
                                    :options="departments"
                                    :keys="{label: 'name', value:'id'}"
                                    v-model="department.parent"
                                    ></ui-select>

                                  </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                  </div>
                                </div>
                              </form>

                            </ui-tab>


                        </ui-tabs>
                    </div>


                </td>
              </tr>
            </template>

          </tbody>
        </table>

      </div>
    </div>
  </div>
</template>

<script>
import Fuse from "fuse.js";
import _ from "lodash";
import confirm from "jquery-confirm";
import Form from "../../utils/Form";

export default {
  data: function() {
    return {
      // depaartments: [],

      formDepartment: new Form({
        name: "",
        primary_contact_name: "",
        orgcode: "",
        phone: "",
        email: "",
        parent_department_id: ""
      }),



      search: "",
      fuse: null
      // results: []
    };
  },

  methods: {
    onSubmitDepartment: function(e) {
      var vm = this;
      console.log("onSubmitDepartment", this, e);

      this.formDepartment
        .beforeSubmit(function(form) {
          console.log(form);
          if (form.get("parent_department_id")) {
            form.set(
              "parent_department_id",
              form.get("parent_department_id").id
            );
          }
        })
        .post("/api/v1/departments")
        .then(function(response) {
          vm.departments.push(response);
          toastr["success"]("Saved Department");
        })
        .catch(errors => console.log(this.formDepartment.errors.errors));
    },

    onUpdateDepartment: function(department) {
      var vm = this;
      console.log("onUpdateDepartment", department);
      department._method = 'PUT';
      department.parent_department_id = department.parent.id
      axios
        .post("/api/v1/departments/"+department.id, department)
        .then(function(response) {toastr["success"]("Updated Department"); })
        .catch(error => {

          console.log(error.response.data);
          Object.keys(error.response.data).forEach( (key, val) => {
            toastr["error"](`${error.response.data[key][0]}`);
            // console.log(key, val, error.response.data[key][0])
          });

         });
    },


    onDeleteDepartment: function(department) {
      var vm = this;

      $.confirm({
        title: "Delete: " + department.name,
        content: "Ok... if your absolutely positive",
        icon: "fa fa-exclamation-triangle",
        animation: "zoom",
        closeAnimation: "zoom",
        buttons: {
          confirm: {
            text: "DELETE!",
            btnClass: "btn-red",
            action: function() {
              vm.formDepartment
                .beforeSubmit(form => {
                  form._method = "DELETE";
                  form.id = department.id;
                })
                .delete("/api/v1/departments/" + vm.formDepartment.id)
                .then(response => {
                  var department_index = _.findIndex(vm.departments, function(department) {
                      return department.id == response.id;
                    });
                  vm.departments.splice(department_index, 1);

                  toastr["success"]("Deleted Department");
                })
                .catch(error => console.log(vm.formOrg.errors.errors));
            }
          },
          close: {
            text: "Close"
          }
        }
      });
    },


  },

  // watch: {
  //   search: function() {
  //     if (this.search.trim() === "") {
  //       this.results = this.departments;
  //     } else {
  //       this.results = this.fuse.search(this.search.trim());
  //     }
  //   }
  // },

  computed: {
    phoneHelp: function() {
      // if (10 - this.formDepartment.phone.length !== 0) {
      //   return (
      //     "10 digit phone number: " +
      //     (10 - this.formDepartment.phone.length) +
      //     " left"
      //   );
      // }
      // return "10 digit phone number";
    },

    departments: function() {
      // console.log(this.$store.getters.departments)
      return this.$store.getters.departments;
    },

    results: function() {
      this.fuse = new Fuse(this.departments, {
        caseSensitive: false,
        tokenize: true,
        threshold: 0.6,
        location: 0,
        distance: 900,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
          { name: "name", weight: 0.7 },
          { name: "email", weight: 0.1 },
          { name: "org.code", weight: 0.1 },
          { name: "parent.name", weight: 0.1 }
        ]
      });

      if (this.search) {
        return this.fuse.search(this.search.trim());
      } else {
        return this.departments;
      }
    }
  },

  mounted() {
    var vm = this;
    this.$store.dispatch("FETCH_ALL_DEPARTMENTS");
  }
};
</script>
