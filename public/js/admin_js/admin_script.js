/*
$(document).ready(function (){
    $("#current_pwd").keyup(function (){
        var current_pwd=$("#current_pwd").val();

        $.ajax({
            type:'post',
            url:'/admin/check-current-pwd',
            data:{current_pwd:current_pwd},
            success:function (resp){
             /!*   alert(resp);*!/
            },
            error:function (){
                /!*alert("error");*!/
            }
        });
    });
});
*/
