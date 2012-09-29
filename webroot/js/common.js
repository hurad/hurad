function toggleChecked(status) {
    $(":checkbox").each( function() {
        $(this).attr("checked",status);
    })
}