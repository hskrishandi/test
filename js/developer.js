// Script for developer form

jQuery(document).ready(function($) {
	var current_page = 0;
	var forms = $("#developer .form-page");
	var next = $("<a class='next'>Next</a>"), submit = $("<a class='next'>Submit</a>");
	forms.addClass("hidden")
		 .eq(0).removeClass("hidden");
	next.appendTo("#developer .form-page:not(:last)")
		.click(function() {
		forms.eq(current_page).addClass("hidden");
		forms.eq(++current_page).removeClass("hidden");
	});
	submit.appendTo("#developer .form-page:last")
		  .click(function() {
		current_page = 0;
		$("#developer form").submit();		
	});
});

