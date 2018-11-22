<template>
    <div class="container-fluid">
        <div class="row">

            <datalist id="props">
                <option v-for="(item, index) in suggestions" :key="item.id" :data-value="item.id">{{item.name}}</option>
            </datalist>

            <table class="table">
                <tbody>
                <tr v-for="(property, index) in propertiesData" :key="property.id">
                    <td>
                        <input list="props" v-model="property.name" class="col-xs-12">
                    </td>

                    <td>
                        <input type="text" v-model="property.value" class="col-xs-12">
                    </td>
                    <td>
                        <button @click="removeProperty(index)">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>

            <ui-button color="primary" @click="addProperty">Add row</ui-button>
            <ui-button color="primary" @click="saveProperties">Save</ui-button>

            <!--<code>-->
            <!--<pre>{{data}}</pre>-->
            <!--</code>-->

        </div>
    </div>
</template>
<script>
import store from '../../../vuex/store.js'

export default {
  props: ["id", "propertiesData"],
  store,
  data: function() {
    return {
      // suggestions: [],
    };
  },
  computed: {
    suggestions: function() {
      return this.$store.getters.properties;
    }
  },
  methods: {
    getSuggestions() {
      this.$store.dispatch("FETCH_ASSETS_PROPERTIES");
    },

    addProperty() {
      this.propertiesData.push({
        id: null,
        asset_id: this.id,
        name: null,
        value: null
      });
    },

    removeProperty(index) {
      var vm = this;
      var remove_id = this.propertiesData[index].id;
      this.propertiesData.splice(index, 1);
      // vm.$store.dispatch("DELETE_ASSETS_PROPERTIES");
      axios.delete("/api/v1/properties/" + remove_id).then(function(response) {
        toastr.warning("Removed Property");
      });
    },

    saveProperties() {
      var vm = this;

      _.each(this.propertiesData, function(item, index) {
        if (item.name == null) {
          toastr.warning("Needs Property Name");
          return;
        }

        if (item.value == null) {
          toastr.warning("Needs Property Value");
          return;
        }
        // vm.$store.dispatch("SAVE_ASSETS_PROPERTIES");
        axios
          .post("/api/v1/properties", {
            id: item.id,
            asset_id: vm.id,
            name: item.name,
            value: item.value
          })
          .then(function(response) {
            item.id = response.data.id;

            toastr.success("Saved Property");

            vm.getSuggestions();
          });
      });
    }
  },
  watch: {},
  mounted() {
    var vm = this;
    vm.$store.dispatch("FETCH_ASSETS_PROPERTIES");
  }
};
</script>
