require('./bootstrap')
require('./sb-admin-2')
require('metisMenu')

import VueRouter from 'vue-router'
import router from './router'
import Vue from 'vue'
import VueGoodTable from 'vue-good-table'
import VueEvents from 'vue-events'
import KeenUI from 'keen-ui'
import 'keen-ui/src/bootstrap'
import Multiselect from 'vue-multiselect/dist/vue-multiselect.min.js'
import store from './vuex/store.js'


//ag-grid License
import {LicenseManager} from "ag-grid-enterprise/main";
LicenseManager.setLicenseKey("Evaluation_License_Valid_Until__30_September_2018__MTUzODI2MjAwMDAwMA==b0211b0a791ee130b75eaa29a676124a");


import * as uiv from 'uiv'

Vue.use(uiv)

Vue.use(VueGoodTable)
Vue.use(VueEvents)
Vue.use(KeenUI)

import fontawesome from '@fortawesome/fontawesome'
import fontawesomeFree from '@fortawesome/fontawesome-free-solid'

// fontawesome.library.add(faSpinner)

// Vue.component('fontawesome', fontawesome)

import '../../../node_modules/ag-grid/dist/styles/ag-grid.css'
import '../../../node_modules/ag-grid/dist/styles/ag-theme-bootstrap.css'

Vue.component('multiselect', Multiselect)

// Pages
Vue.component('roles-permissions', require('./components/wits/RolesPermissions.vue'))
Vue.component('users', require('./components/wits/Users.vue'))
Vue.component('locations', require('./components/wits/Locations.vue'))
Vue.component('departments', require('./components/wits/Departments.vue'))
Vue.component('inventory', require('./components/wits/Inventory.vue'))

// Wits Components

// Components
Vue.component('xeditable', require('./components/xeditable.vue'))

// Passport
Vue.component('passport-clients', require('./components/passport/Clients.vue'))
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'))
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'))

const app = new Vue({
  el: '#app',
  store,
  router,

  created() {

    this.$store.dispatch('FETCH_CURRRET_USER').then(data => {
        console.log('App created', data)
    })
  },

  mounted() {
    console.log('App mounted', this.$store.getters.currentUser)
  }
})
