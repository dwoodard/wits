import Vue from 'vue';
import Vuex from 'vuex';
import _ from "lodash"

Vue.use(Vuex);

const state = {
    currentUser: {},
    allAssets: {},
    inventory: {},
    departments: [],
    transfers: {
        sending:[],
        receiving:[]
      },
    locations: {
        campuses: {},
        },
    suggestions: {
        departmentUsers: [],
        departmentRooms: [],
        departments: {},
        roomStyles: {},
        supportUsers: {},
        assets: {
            properties: [],
            categories: {},
            // steward:{}
        }
        },
    roles:[],
    permissions: []

}

const getters = {
    currentUser: (store, currentUser) => {
        return store.currentUser
    },

    inventory: (store, inventory) => {
        return store.inventory
    },

    roles: ({ currentUser }) => {
        if (!store.state.currentUser) {
            return
        }
        return _.map(currentUser.roles, 'name') //roles.includes('admin')
    },

    allAssets: (store) => {
        return store.allAssets
    },

    campuses: (store) => {
        return store.locations.campuses
    },

    roomStyles: (store) => {
        return store.suggestions.roomStyles
    },

    departmentUsersSuggestionsById: (store) => (department_id) => {
        // console.log(department_id)
        return store.suggestions.departmentUsers.find(item => item.departmentid === department_id)
    },

    departmentRoomsSuggestionsById: (store) => (department_id) => {
        return store.suggestions.departmentRooms.find(item => item.departmentid === department_id)
    },

    departmentSuggestions: (store) => () => {
        return store.suggestions.departments
    },

    supports: (store) => {
        return store.suggestions.supportUsers
    },

    properties: (store) => {
        return store.suggestions.assets.properties
    },

    categories: (store) => {
        return store.suggestions.assets.categories
    },

    departments: (store) => {
        return store.departments
    },

    roles_with_permissions: (store) => {
        return store.roles
    },

    permissions: (store) => {
        return store.permissions
    },

}

const mutations = {
    FETCH_CURRRET_USER(state, currentUser) {
        state.currentUser = currentUser
    },

    FETCH_ALL_ASSETS(state, allAssets) {
        state.allAssets = allAssets
    },

    GET_CURRENT_USER_ROLES(state, roles) {
        state.currentUser.roles = roles
    },

    FETCH_CAMPUSES(state, campuses) {
        state.locations.campuses = campuses
    },

    FETCH_ROOM_STYLES(state, roomStyles) {
        state.suggestions.roomStyles = roomStyles
    },

    FETCH_DEPARTMENTS_SUGGESSTIONS(state, departments) {
        state.suggestions.departments = departments
    },

    FETCH_DEPARTMENTS_USERS_SUGGESSTIONS(state, data) {
        if(!state.suggestions.departmentUsers.find( i => i.departmentid === data.departmentid)){
            state.suggestions.departmentUsers.push(data)
        }
    },

    FETCH_DEPARTMENTS_ROOMS_SUGGESSTIONS(state, data) {
        if(!state.suggestions.departmentRooms.find( i => i.departmentid === data.departmentid)){
            state.suggestions.departmentRooms.push(data)
        }
    },

    FETCH_SUPPORT_USERS(state, supportUsers) {
        state.suggestions.supportUsers = supportUsers[0].users
    },

    FETCH_ASSETS_PROPERTIES(state, assetProperties) {
        state.suggestions.assets.properties = assetProperties
    },

    // FETCH_CATEGORY_SUGGESSTIONS(state, assetCategories) {
    //     toastr.info("FETCH_CATEGORY_SUGGESSTIONS")
    //     state.suggestions.assets.categories = assetCategories
    // },

    FETCH_INVENTORY_FOR_DEPARTMENT(state, response) {
        // toastr.info("FETCH_INVENTORY_FOR_DEPARTMENT")
        state.inventory = response.currentuser.departments[0]
    },
    FETCH_ALL_DEPARTMENTS(state, data) {
        toastr.info("FETCH_ALL_DEPARTMENTS")

        // console.log("FETCH_ALL_DEPARTMENTS", data)

        for (var i=0; i < data.length; i++ ) {
            if(data[i].parent_department_id == null){
                data[i].parent =  {name:null, id: null}
            }
        }

        state.departments = data
    },
    FETCH_ALL_ROLES_WITH_PERMISSIONS(state, data) {
        toastr.info("FETCH_ALL_ROLES_WITH_PERMISSIONS")
        state.roles = (data)
    },
    FETCH_ALL_PERMISSIONS(state, data) {
        toastr.info("FETCH_ALL_PERMISSIONS")
        state.permissions = (data)
    },
    // UPDATE_INVENTORY_BY_ID(state, data) {
    //   toastr.info("UPDATE_INVENTORY_BY_ID")
    //   console.log("UPDATE_INVENTORY_BY_ID", data, )
    //   // state.inventory = data
    // },
    FETCH_ALL_TRANSFERS(state, data) {
        // console.log("Mutation FETCH_ALL_TRANSFERS")

        var transfer = {
            sending: data.send,
            receiving: data.receive,
        }

        //TODO: These needs a Check to make sure it doesn't exsit
        state.transfers.sending.push({department: data.department, transfers:transfer.sending});
        state.transfers.receiving.push({department: data.department, transfers:transfer.receiving})


        // if(!state.transfers.find( i => i[data.field] === data.departmentid)){
        //     state.transfers.push(data)
        // }
    }
}

const actions = {
    // FETCH, // UPSERT, // DELETE

    FETCH_CURRRET_USER({ commit }) {
         return axios.get("/api/v1/currentuser?with=roles,departments")
            .then((response) => {
                commit("FETCH_CURRRET_USER", response.data.currentuser);
                toastr.success("Loaded Current User");
            })
    },

    FETCH_ALL_ASSETS({ commit }) {
        axios
            .get(
                "/api/v1/asset?" +
                "with=" +
                // Department Assets
                "media," +
                "room," +
                "room.roomstyle," +
                "room.building," +
                "room.building.campus," +
                "checkout," +
                // "category," +
                "properties," +
                "users"
            )
            .then((response) => {
                commit("FETCH_ALL_ASSETS", response.data);
                toastr.success("Loaded All Assets");
            })
    },

    FETCH_CAMPUSES({ commit }) {
        var $with = [
            'buildings.rooms.assets',
            'buildings.rooms.assets.media',
            // 'buildings.rooms.assets.category',
            'buildings.rooms.assets.users',
            'buildings.rooms.assets.department',
            'buildings.rooms.software',
            'buildings.rooms.departments',
            'buildings.rooms.supports',
            'buildings.rooms.media',
        ]

        axios.get('/api/v1/campus?with=' + $with.join())
            .then(function (response) {
                commit("FETCH_CAMPUSES", response.data);
                toastr.success("Loaded Campuses")
            })
    },

    FETCH_ROOM_STYLES({ commit }) {
        axios.get('/api/v1/roomstyle')
            .then(function (response) {
                commit("FETCH_ROOM_STYLES", response.data);
                toastr.success("Loaded Room Styles")

            })
    },

    FETCH_DEPARTMENTS_SUGGESSTIONS({ commit }) {
        axios.get('/api/v1/departments?fields=id,name')
            .then(function (response) {
                commit("FETCH_DEPARTMENTS_SUGGESSTIONS", response.data);
                toastr.success("Loaded Departments Suggestions")

            })
    },

    FETCH_DEPARTMENTS_USERS_SUGGESSTIONS({ commit }, departmentid) {
        let that = this;
        let department_data = {
            departmentid: departmentid,
            data: {}
        }

        if (departmentid) {
            axios
                .get("/department/" + departmentid + "/user/suggestions")
                .then(function (response) {
                    department_data.data = response.data
                    commit("FETCH_DEPARTMENTS_USERS_SUGGESSTIONS", department_data);
                    toastr.success("Departments User Suggestions");
                });
        }

    },

    FETCH_DEPARTMENTS_ROOMS_SUGGESSTIONS({ commit }, departmentid) {
        let that = this;
        let department_data = {
            departmentid: departmentid,
            data: {}
        }

        if (departmentid) {
            axios
                .get("/department/" + departmentid + "/rooms/suggestions")
                .then(function (response) {
                    department_data.data = response.data
                    commit("FETCH_DEPARTMENTS_ROOMS_SUGGESSTIONS", department_data);

                    toastr.success("Departments Rooms Suggestions");
                });
        }

    },

    FETCH_SUPPORT_USERS({ commit }) {
        axios.get('/api/v1/roles?with=users&search=support&searchColumns=name')
            .then(function (response) {
                commit("FETCH_SUPPORT_USERS", response.data);
                toastr.success("Loaded Support Roles Users")
            })
    },

    FETCH_ASSETS_PROPERTIES({ commit }) {
        axios.get('/properties/suggestions')
            .then(function (response) {
                commit("FETCH_ASSETS_PROPERTIES", response.data);
                toastr.success("Loaded Properties Suggesstions")
            })
    },

    // FETCH_CATEGORY_SUGGESSTIONS({ commit }) {
    //     axios.get("/category/suggestions")
    //         .then(function (response) {
    //             //Add Blank value
    //             response.data.unshift({text: "", value: null})

    //             commit("FETCH_CATEGORY_SUGGESSTIONS", response.data);
    //             toastr.success("Loaded Category Suggesstions");
    //         })

    // },

    FETCH_INVENTORY_FOR_DEPARTMENT({ commit }) {
        axios
            .get(
                "/api/v1/currentuser?" +
                "fields=username,id&" +
                "with=" +
                // Department Assets
                "departments.assets," +
                "departments.assets.media," +
                "departments.assets.room," +
                "departments.assets.room.roomstyle," +
                "departments.assets.room.building," +
                "departments.assets.room.building.campus," +
                "departments.assets.checkout," +
                // "departments.assets.category," +
                "departments.assets.properties," +
                "departments.assets.users"

            )
            .then(function (response) {
                //Add Selected property to all assests
                _.each(response.data.currentuser.departments[0].assets, function (value, key) {
                    Vue.set(value, 'selected', false)
                })


                commit("FETCH_INVENTORY_FOR_DEPARTMENT", response.data);
                toastr.success("Loaded Inventory for Department");
            })
    },

    FETCH_ALL_DEPARTMENTS({ commit }) {
        axios.get('/api/v1/departments?with=parent,users,rooms.building.campus')
            .then(function (response) {
                // vm.departments = response.data;
                commit("FETCH_ALL_DEPARTMENTS", response.data);
                toastr.success("Loaded departments")
            })

    },

    FETCH_ALL_ROLES_WITH_PERMISSIONS({ commit }) {
        axios.get('/api/v1/roles?with=permissions')
            .then(function (response) {
                commit("FETCH_ALL_ROLES_WITH_PERMISSIONS", response.data);
                toastr.success("Loaded ROLES_WITH_PERMISSIONS")
            })

    },

    FETCH_ALL_PERMISSIONS({ commit }) {
        axios.get('/api/v1/permissions')
            .then(function (response) {
                commit("FETCH_ALL_PERMISSIONS", response.data);

                toastr.success("Loaded ROLES_WITH_PERMISSIONS")
            })

    },

    FETCH_ALL_TRANSFERS({ dispatch, commit }) {

        dispatch('FETCH_CURRRET_USER')
        .then((response)=>{
            this.state.currentUser.departments.forEach(function(department){
                //send == old_department_id
                let send = axios
                .get(`/api/v1/transfer?wherein=old_department_id,${department.id}&with=asset,asset.media,old_department,new_department`)

                //receive == new_department_id
                let receive = axios.get(`/api/v1/transfer?wherein=new_department_id,${department.id}&with=asset,asset.media,old_department,new_department`)

                Promise.all([send, receive]).then(function(transfers){

                    // console.log(transfers)

                    let data = {
                        send: transfers[0].data,
                        receive: transfers[1].data,
                        department: department
                    }


                    // console.log("Data", data)
                    commit("FETCH_ALL_TRANSFERS", data);
                    toastr.success("Transfers Loaded");
                })

            })




        })




    },

}

let store = new Vuex.Store({
    state,
    getters,
    mutations,
    actions
});

export default store;

