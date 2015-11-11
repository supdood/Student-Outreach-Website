$(document).ready(function(){
    
    setDays();
    
    $("#formMonths").on("change", setDays);
    
});
    
function setDays() {
    
    clearDays();
    var length = 31;

    if ($('#formMonths').val() == "02")
        length = 29;
    else if ($.inArray($('#formMonths').val(), ['04', '06', '09', '11']) >= 0)
        length = 30;
    else
        length = 31;
    
    for (i = 1; i < length + 1; i++) {
        $('#formDays').append($('<option>', {
            value: i,
            text: i
        }));
    } 
    
}

function clearDays() {
    
    $('#formDays').find('option').remove().end();
    
}