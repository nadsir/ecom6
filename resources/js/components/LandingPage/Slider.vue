<template>
    <div class="container-fluid slider-bg" style="border-radius: 10px 10px 10px 10px;padding: 0px!important;margin-top: 30px" >
        <div class="row">
            <div class="col headerText" style="margin: 10px"> Feature Product</div>
        </div>
        <carousel  align="center" class="carousel"   :autoplay="true" :loop="true"  :scrollPerPage="false" :perPageCustom="[[1200,5],[992,3]]" :paginationEnabled="false"  :autoplayTimeout="2000" >

            <slide class="slider" style="" >
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
            <slide class="slider">
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
            <slide class="slider">
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
            <slide class="slider">
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
            <slide class="slider">
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
            <slide class="slider">
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
            <slide class="slider">
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
            <slide class="slider">
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
            <slide class="slider">
                <div class="card ">
                    <img v-bind:src="'../images/front_images/products/2.jpg'" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <h4 style="text-align:center">
                            <button type="button" class="btn btn-secondary">Details   <i class="fas fa-info"></i></button>

                            <a class="btn btn-primary" href="#">Rs.1000</a>
                        </h4>
                    </div>
                </div>
            </slide>
        </carousel>

    </div>
</template>

<script>
    import { Carousel, Slide } from 'vue-carousel';
    export default {
        name: "Slider",
        components: {
            Carousel,
            Slide
        }
    }
</script>

<style scoped>
.slider-bg{

}
    .carousel{



    }
    .slider-container{

    }
    .headerText{
        font-size: 30px;
        font-family: "B Nazanin";
    }
    .slider{
        margin: 30px;
        background-color: white;
        width: 300px;
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 0px solid #000000;
        -webkit-box-shadow: -1px 4px 14px 5px rgba(0,0,0,0.75);
        -moz-box-shadow: -1px 4px 14px 5px rgba(0,0,0,0.75);
        box-shadow: -1px 4px 14px 5px rgba(0,0,0,0.75);

    }

    .card{
        border: 0px!important;


    }
    .card-body{

    }
    .btn{

        border: 0px!important;
    }


</style>
