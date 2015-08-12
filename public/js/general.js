$(document).ready(function(){
    if (parseInt($('#balance').text()) < 0){
        $('#balance').css('color', 'red');
    }
});