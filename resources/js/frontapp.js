/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/*Vue.component('example-component', require('./components/ExampleComponent.vue').default);*/

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue';
import {Tabs, Tab} from 'vue-tabs-component';
Vue.component('tabs', Tabs);
Vue.component('tab', Tab);
import 'vue-tabs-component/docs/resources/tabs-component.css';
const app = new Vue({
    el: '#frontapp',
    data() {
        return {
            activeItem: 'home',
            fabrics: [],
            sleeves: [],
            patterns: [],
            fits: [],
            occasions:[],
            sort: '',
            url: '',
            options: [
                {text: 'Latest Products', value: 'product_latest'},
                {text: 'Product name A - Z', value: 'product_name_a_z'},
                {text: 'Product name Z - A', value: 'product_name_z_a'},
                {text: 'Lowest Price First', value: 'product_lowest'},
                {text: 'Highest Price', value: 'product_highest'},
            ],
            selectSize:'',
            newPrice:''
        }
    },
    methods: {

        callToWatch: function () {
            this.url = $("#url").val();
            axios.post(this.url, {
                sort: this.sort,
                url: this.url,
                fabric: this.fabrics,
                sleeve: this.sleeves,
                pattern: this.patterns,
                fit:this.fits,
                occasion:this.occasions,
            })
                .then(response => {
                        $('.filter_products').html(response.data);
                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });
        },
        sendId:function (id) {

            axios.post('/get-product-price', {
                id: id,
                size: this.selectSize,
            })
                .then(response => {

                    if (response.data.discounted_price > 0){
                        $(".getAttrPrice").html("<del>Rs. "+response.data.product_price+"</del> Rs. "+response.data.discounted_price );
                    }else{
                        $(".getAttrPrice").html("Rs. "+response.data.product_price+"");
                    }

                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });
        },
        isActive (menuItem) {
            return this.activeItem === menuItem
        },
        setActive (menuItem) {
            this.activeItem = menuItem
        }
    },
    watch: {
        'sort': function () {
            this.callToWatch();
        },
        'fabrics': function () {
            this.callToWatch();
        },
        'sleeves': function () {
            this.callToWatch();
        },
        'patterns': function () {
            this.callToWatch();
        },
        'fits':function () {
            this.callToWatch();
        },
        'occasions':function () {
            this.callToWatch();
        },



    },

});

//confirm delete of record
