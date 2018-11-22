<template>

    <div :ref="'container'" tabindex="0" v-show="departmentUsers">

        <datalist id="departmentUsersList" >
            <option v-for="(departmentUser, index) in departmentUsers" :value="departmentUser.value">{{departmentUser.text}}</option>
        </datalist>


        <input @change="onChange" v-model="steward" type="text" :ref="'departmentUsersInput'" list="departmentUsersList">
    </div>
</template>

<script>
    import Vue from "vue";
    import store from '../../../../vuex/store.js'

    export default Vue.extend({
        data() {
            return {
                steward: null
                // departmentUsers: this.departmentUsersComputed
            }
        },
        store,
        methods: {
            getValue() {
                let user = this.departmentUsers.find(i => i.value == this.steward)
                if(user){
                    return this.departmentUsers.find(i => i.value == this.steward).text;
                }
                else{
                    return this.params.value
                }

            },

            isPopup() {
                return true;
            },

            onChange() {
                // console.log("onChange", this.params)
                let myParams = this.params
                let value = this.departmentUsers.find(i => i.value == this.steward).text

                axios
                .put(this.params.column.colDef.url + this.params.node.data.id, {
                    pk: this.params.node.data.id,
                    name: 'user_id',
                    value: this.steward
                })

                this.params.api.stopEditing();
            },

        },
        computed: {
            departmentUsers: function(){
                let departmentUsers = this.$store.getters.departmentUsersSuggestionsById(this.params.node.data.department_id)
                if(departmentUsers){
                    return departmentUsers.data
                }
                return null
            }
        },

        beforeMount() {
            // console.log(this.params.node.data)
            // if store doesn't have department user go get them
            if(!this.$store.state.suggestions.departmentUsers.find( i => i.departmentid === this.params.node.data.department_id)){
                this.$store.dispatch('FETCH_DEPARTMENTS_USERS_SUGGESSTIONS',this.params.node.data.department_id)
            }

        },
        mounted() {
            Vue.nextTick(() => {
                this.$refs.departmentUsersInput.focus();
                this.$refs.departmentUsersInput.click();
            });
        }
    })
</script>
