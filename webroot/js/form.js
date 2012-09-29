$(document).ready(function(){

if(!Modernizr.input.placeholder){

	$('[placeholder]').focus(function() {
	  var input = $(this);
	  if (input.val() == input.attr('placeholder')) {
		input.val('');
		input.removeClass('placeholder');
	  }
	}).blur(function() {
	  var input = $(this);
	  if (input.val() == '' || input.val() == input.attr('placeholder')) {
		input.addClass('placeholder');
		input.val(input.attr('placeholder'));
		
	  }
	}).blur();
	$('[placeholder]').parents('form').submit(function() {
	  $(this).find('[placeholder]').each(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
		  input.val('');
		}
	  })
	});

}})

// iterate over all the tables in the page
$("thead").find("tr").each(function() {
    // attach a click event on the checkbox in the header in each of table
    $(this).find("th:first input:checkbox").click(function() {
        var val = this.checked;
        // when clicked on a particular header, get the reference of the table & hence all the rows in that table, iterate over each of them.
        $(this).parents("tbody").find("tr").each(function() {
            // access the checkbox in the first column, and updates its value.
            $(this).find("td:first input:checkbox")[0].checked = val;
        });
    });
});


