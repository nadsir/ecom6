$(document).ready(function () {
    /*$("#sort").on('change',function () {
    this.form.submit();
    });*/
    $(".fabric").on('click', function () {

        var fabric = get_filter(this.className);
        var sort=$("#sort option:selected").text();
        var url=$("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: {fabric: fabric,sort:sort,url:url},
            success: function (data) {
                $('.filter_products').html(data);
            }
        })

    });

    function get_filter(class_name) {
        var filter=[];
        $('.'+class_name+':checked').each(function () {
            filter.push($(this).val());
        });

        return filter;
    }

});
