<template>
    <ul class="list-group" style="margin-top: 50px;">
        <li class="list-group-item active" id="openList" aria-current="true" v-on:click="change" style="padding: 0px">
            <p>Cras justo odio</p>
            <ul class="list-group" id="target" style="margin: 20px">
                <li class="list-group-item details" >1111111</li>
                <li class="list-group-item details" >22222222</li>
                <li class="list-group-item details">Morbi leo risus</li>
                <li class="list-group-item details">Porta ac consectetur ac</li>
                <li class="list-group-item details">Vestibulum at eros</li>
            </ul>
        </li>
        <li class="list-group-item">Dapibus ac facilisis in</li>
        <li class="list-group-item">Morbi leo risus</li>
        <li class="list-group-item">Porta ac consectetur ac</li>
        <li class="list-group-item">Vestibulum at eros</li>
    </ul>

</template>

<script>
export default {
name: "SideBar",
    methods: {

        change:function (){
            $( "#target").css("padding", "0px").css("transition-duration", " 1s").css("transition-timing-function", "linear");
            $( ".details")
                .css("height", "auto")
                .css("padding", "8px")
                .css("opacity", "1")
                .css("transition-duration", "0.5s")
                .css("transition-timing-function", "linear") ;
        }
    }
}
</script>

<style scoped>
p{
margin-top: 1rem!important;
    padding: 10px;
}
.list-group-item{
    color: black;
}
#target{
    padding: 0px;
    transition-duration:0.5s;
    transition-timing-function:linear;
}
.details{
    height: 0px;
    padding: 0px;
    opacity: 0;
    transition-duration:0.5s;
    transition-timing-function:linear;
}

</style>

