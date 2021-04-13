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

const app = new Vue({
    el: '#adminapp',
    data: {
        currentpw: '',
        result: '',
        color: '',
        par1: '',
        par2: '',
        catId: '',
        catStatus: '',
        getSectionId:'',
        getCategories:'',
        proId:'',
        proStatus:'',
        attrStatus:'',
        attrId:'',
        imgId:'',
        imgStatus:'',
        brandStatus:'',
        brandId:'',
        bannerId:'',
        bannerStatus:''
    },
    methods: {
        key: function (event) {
            this.currentpw + event.key;
            axios.post('/admin/check-current-pwd', {currentpw: this.currentpw})
                .then(response => {
                        this.result = response.data;
                        if (response.data == '') {
                            this.color = '';
                        }
                        if (response.data == true) {
                            this.color = 'green';
                        }
                        if (response.data !== '' && response.data != true) {
                            this.color = 'red';
                        }

                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });
        },
        changeStatus: function (par2) {
            this.par1 = $("#section-"+par2).children("i").attr("status");
            this.par2 = par2;
            axios.post('/admin/update-section-status', {par1: this.par1, par2: this.par2})
                .then(response => {
                        if (response.data.status == 0) {
                            $("#section-"+ response.data.section_id).children("i").attr("status",'Inactive');
                            $("#section-"+ response.data.section_id).children("i").attr("class",'fas fa-toggle-off');
                        } else {
                            $("#section-"+ response.data.section_id).children("i").attr("status",'Active');
                            $("#section-"+ response.data.section_id).children("i").attr("class",'fas fa-toggle-on');
                        }
                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });

        },
        changeCategoryStatus: function (catId) {
            this.catStatus = $("#category-"+catId).children("i").attr("status");
            this.catId = catId;
            axios.post('/admin/update-category-status', {catId: this.catId, catStatus: this.catStatus})
                .then(response => {
                        if (response.data.catStatus == 0) {
                            $("#category-"+ response.data.category_id).children("i").attr("status",'Inactive');
                            $("#category-"+ response.data.category_id).children("i").attr("class",'fas fa-toggle-off');
                        } else {
                            $("#category-"+ response.data.category_id).children("i").attr("status",'Active');
                            $("#category-"+ response.data.category_id).children("i").attr("class",'fas fa-toggle-on');
                        }
                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });

        },
        onChangeSection: function () {
            this.getSectionId = document.getElementById('section_id').value;
            alert(this.getSectionId);
            axios.post('/admin/append-categories-level', {getSectionId:this.getSectionId}).then(
                response => {
                    $('#appendCategoriesLevel').html(response.data);
                },
                response => {
                    this.error=1;
                    console.log('error');
                }
            );


        },
        confirmDelete:function (par1,par2){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href="/admin/delete-"+par2+"/"+par1;
                }
            })
        },
        changeProductStatus: function (proId) {
            this.proStatus = $("#product-"+ proId).children("i").attr("status");
            this.proId = proId;
            axios.post('/admin/update-product-status', {proId: this.proId, proStatus: this.proStatus})
                .then(response => {
                        if (response.data.proStatus == 0) {
                            $("#product-"+ response.data.product_id).children("i").attr("status",'Inactive');
                            $("#product-"+ response.data.product_id).children("i").attr("class",'fas fa-toggle-off');
                        } else {
                            $("#product-"+ response.data.product_id).children("i").attr("status",'Active');
                            $("#product-"+ response.data.product_id).children("i").attr("class",'fas fa-toggle-on');
                        }
                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });

        },
        changeAttributeStatus:function (attrId){
            this.attrStatus = document.getElementById('attribute-'+ attrId).innerText;
            this.attrId = attrId;

            axios.post('/admin/update-attribute-status', {attrId: this.attrId, attrStatus: this.attrStatus})
                .then(response => {
                        if (response.data.attrStatus == 0) {
                            document.getElementById('attribute-' + response.data.product_id).innerText = 'inactive';
                        } else {
                            document.getElementById('attribute-' + response.data.product_id).innerText = 'Active';
                        }
                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });
        },
        confirmDeleteProductStatus:function (par1,par2){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href="/admin/delete-"+par2+"/"+par1;
                }
            })
        },
        changeImageeStatus:function (imgId){
            this.imgStatus = document.getElementById('image-'+imgId).innerText;
            this.imgId = imgId;
            axios.post('/admin/update-image-status', {imgId: this.imgId, imgStatus: this.imgStatus})
                .then(response => {
                        if (response.data.attrStatus == 0) {
                            document.getElementById('image-' + response.data.image_id).innerText = 'inactive';
                        } else {
                            document.getElementById('image-' + response.data.image_id).innerText = 'Active';
                        }
                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });
        },
        confirmDeleteProductImage:function (par1,par2){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href="/admin/delete-"+par2+"/"+par1;
                }
            })
        },
        changeBrandsStatus:function (brandId){
            this.brandStatus=$("#brands-"+brandId).children("i").attr("status");
            console.log(this.brandStatus);
            this.brandId = brandId;
            axios.post('/admin/update-brands-status', {brandId: this.brandId, brandStatus: this.brandStatus})
                .then(response => {
                        if (response.data.brandStatus == 0) {
                            $("#brands-"+ response.data.brandId).children("i").attr("status",'Inactive');
                            $("#brands-"+ response.data.brandId).children("i").attr("class",'fas fa-toggle-off');
                        } else {
                            $("#brands-"+ response.data.brandId).children("i").attr("status",'Active');
                            $("#brands-"+ response.data.brandId).children("i").attr("class",'fas fa-toggle-on');
                        }
                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });
        },
        changeBannersStatus:function (bannerId){
            this.bannerStatus=$("#banners-"+bannerId).children("i").attr("status");
            console.log(this.bannerStatus);
            this.bannerId = bannerId;
            axios.post('/admin/update-banners-status', {bannerId: this.bannerId, bannerStatus: this.bannerStatus})
                .then(response => {
                        if (response.data.bannerStatus == 0) {
                            $("#banners-"+ response.data.bannerId).children("i").attr("status",'Inactive');
                            $("#banners-"+ response.data.bannerId).children("i").attr("class",'fas fa-toggle-off');
                        } else {
                            $("#banners-"+ response.data.bannerId).children("i").attr("status",'Active');
                            $("#banners-"+ response.data.bannerId).children("i").attr("class",'fas fa-toggle-on');
                        }
                    },
                    response => {
                        this.error = 1;
                        console.log('error');
                    });
        },
    },


});

//confirm delete of record
