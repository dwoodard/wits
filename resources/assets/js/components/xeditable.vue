<template>
    <a class="editable" href="#"
    :data-name="field"
    :data-type="type"
    :data-pk="pk"
    :data-url="url"
    :data-title="title"
    :data-tpl="tpl"
    >
        <slot>{{value}}</slot>
    </a>
</template>


<script>
    require('./../vendor/xeditable/bs3-editable/js/bootstrap-editable.min.js');
    import select2, { styles } from 'select2/dist/js/select2.js';

    /**
     Main attributes you should define are:

     type - type of input (text, textarea, select, etc)
     url - url to server-side script to process submitted value (/post, post.php etc)
     pk - primary key of record to be updated (ID in db)
     id/name - name of field to be updated (column in db). Taken from id or data-name attribute
     value - initial value. Usefull for select, where value is integer key of text to be shown. If empty - will be taken from element html contents

     */

    export default {
        props: {
            field: {
                type: String,
                required:true
            },
            pk: {
                type: Number,
                required:true
            },
            url: {
                type: String,
                required:true
            },
            title: {
                type: String,
                'default': ''
            },
            type: {
                type: String,
                'default': 'text'
            },
            tpl:{
                type: String
            },
            value: {
                type: [String, Number],
                'default': ''
            },
            datatemplate:{
                type: String,
                'default': ''
            },
            options: {
                type: Object,
                'default': function () { return {} }
            },

        },

        data: function () {
            return {}
        },
        mounted: function () {
            let vm = this;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.fn.editable.defaults.ajaxOptions = {type: "PUT"};
            $.fn.editable.defaults.mode = 'inline';



            $(this.$el)
            .on('shown', function(e, editable) {
                switch (vm.type) {
                  case 'date':
                    editable.input.options.tpl =  '<div class="input-append date"><input type="date"/><span class="add-on"><i class="icon-th"></i></span></div>'
                    break;
                  case 'select':
                    // editable.input.options.tpl =  '<select class="select2"></select>'
                    $(editable.input.$input[0]).select2();
                  break;
                }
            });




            $(this.$el).editable(this.options).on('save', function(e, params) {
                let data = {field: vm.field,value: params.newValue, id: vm.pk, response: params.response, event: e}
                vm.$events.emit('updateInventory', data);
            });



        },
        beforeDestroy: function() {
            $(this.$el).editable('destroy')
        }

    }
</script>


<style>
</style>


