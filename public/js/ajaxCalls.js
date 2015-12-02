$(document).ready(function () {
    $(".clickable-raw").click(function () {
        var id =$(this).closest('tr').attr('id');
                $.ajax({
                    url: '/notifications/seen/'+id,
                    data: '',
                    dataType: 'text',
                    success: function (data) {
                        
                    },
                });

    });
});

