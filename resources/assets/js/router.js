import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Dashboard from './components/wits/Dashboard.vue';
import Inventory from './components/wits/Inventory.vue';
import AllAssets from './components/wits/AllAssets.vue';
import Departments from './components/wits/Departments.vue';
import Locations from './components/wits/Locations.vue';
import Users from './components/wits/Users.vue';
import RolesPermissions from './components/wits/RolesPermissions.vue';
import Reports from './components/wits/Reports.vue';
import Settings from './components/wits/Settings.vue';



const router = new VueRouter({
  mode: 'history',
  base: 'app',
  routes: [
    { path: '/', component: Dashboard },
    //Sidebar
    { path: '/dashboard', component: Dashboard },
    { path: '/inventory', component: Inventory },
    { path: '/departments', component: Departments },
    { path: '/locations', component: Locations },
    { path: '/users', component: Users },
    { path: '/users/roles-permissions', component: RolesPermissions },
    { path: '/reports', component: Reports },
    //UserDropdown
    { path: '/settings', component: Settings },
  ]
});
//Define route components
// const Home = { template: '<div>home</div>' }
// const Foo = { template: '<div>Foo</div>' }

export default router
