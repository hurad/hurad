jQuery(document).ready(function($) {
    $("input[name='date_format']").click(function() {
        if ("DateFormatCustomRadioCUSTOM" !== $(this).attr("id"))
            $("input[name='data[General][date_format]']").val($(this).val());
    });
    $("input[name='data[General][date_format]']").focus(function() {
        $("#DateFormatCustomRadioCUSTOM").attr("checked", "checked");
    });

    $("input[name='time_format']").click(function() {
        if ("time_format_custom_radio" !== $(this).attr("id"))
            $("input[name='data[General][time_format]']").val($(this).val());
    });
    $("input[name='data[General][time_format]']").focus(function() {
        $("#time_format_custom_radio").attr("checked", "checked");
    });
});