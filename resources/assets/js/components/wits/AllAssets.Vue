<template>

    <div id="all-assets-vue" class="container-fluid">
      <h2>All Assets</h2>
        <template>
          <all-assets-inventory-table :assets="this.$store.state.allAssets" />
        </template>

    </div>

</template>

<script>
import _ from "lodash";
import confirm from "jquery-confirm";
import Form from "../../utils/Form";
import { mapState, mapMutations } from "vuex";

export default {
  data: function() {
    return {};
    function regexFilter(data, filterString) {
      return data.match(new RegExp(filterString, "mig"));
    }
  },
  computed: {
    // allAssets: function() {
    //   return this.$store.getters.allAssets;
    // }
  },
  methods: {
    
  },
  watch: {},
  mounted() {
    let vm = this;
    vm.$store.dispatch("FETCH_ALL_ASSETS");
    this.$events.listen("updateInventory", this.updateInventory);

  }
};
</script>





