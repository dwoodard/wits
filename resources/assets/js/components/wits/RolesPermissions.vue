<template>
  <div>

    <h2>Roles &amp; Permission</h2>
    <div class="row">
        <div class="col-xs-12">

            <!-- {{permissions}} -->
          <table class="table table-striped">

            <thead>
              <tr>
                <th width="1%">Permissions</th>
                <th class="rotate" v-for="(role,index) in roles" v-bind:key="index" >
                    <div> <span>{{role.name}}</span></div>
                </th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(permission,index) in permissions" v-bind:key="index">
                <td >{{permission.label}}</td>
                <td v-for="(role,index) in roles" v-bind:key="index" >
                    <span class="checkbox">
                        <input type="checkbox"  @change="togglePermission(role, permission)" :checked="hasPermission(role,permission)">
                    </span>
                </td>
              </tr>
            </tbody>

          </table>
        </div>
      </div>
  </div>
</template>

<script>
import Fuse from 'fuse.js';
import _ from 'lodash';
import toastr from 'toastr';
import confirm from 'jquery-confirm';
import Form from '../../utils/Form';



export default {
  data() {
    return {
    //   formRole: new Form({
    //     name:""
    //   }),
    }
  },
  methods: {
        hasPermission: function(role, permission){
            return  !!_.find(role.permissions, { name: permission.name })
        },
        togglePermission: function(role, permission){
            console.log(role, permission)
            let data = {
                role:role,
                permission:permission
                }

            axios.post('/api/v1/roles/'+ role.id +'/sync/permission', data)
                .then(function (response) {
                var items = response.data
                console.log(items);

                // _.each(items['attached'], function(item){
                //     toastr["success"]("Toggled Permission: " + item.name)
                // })

            })


        },
        onSubmitRole: function (e) {
        var vm = this
        // console.log('onSubmitRole', this, e)

        this.formRoles
        // .beforeSubmit(function(form){
        //   console.log(form)
        //   if (form.get('parent_roles_id')) {
        //     form.set('parent_roles_id', form.get('parent_roles_id').id)
        //   }
        // })
        .post('/api/v1/roles')
        .then(function(response){
            vm.roles.push(response)
            toastr["success"]("Saved Roles")
        })
        .catch(errors => console.log(this.formRoles.errors.errors))
        }
  },
  watch: {},
  computed: {
    roles: function () {
      return this.$store.getters.roles_with_permissions;
    },
    permissions: function () {
      return this.$store.getters.permissions;
    }
  },
  mounted() {
        let vm = this
        this.$nextTick(function() {
            vm.$store.dispatch( "FETCH_ALL_ROLES_WITH_PERMISSIONS");
            vm.$store.dispatch( "FETCH_ALL_PERMISSIONS");
        });
    }
  }
</script>

<style>
th.rotate {
  /* Something you can count on */
  height: 140px;
  white-space: nowrap;
  width: 1%;
}

th.rotate > div {
  transform: translate(0px, 0px) rotate(-45deg);
  border-bottom: 1px solid #ccc;
  width: 30px;
}
th.rotate > div {
  /*   border-bottom: 1px solid #ccc; */
  padding: 5px 10px;
}
</style>
