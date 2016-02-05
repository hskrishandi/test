/*
 * Functions for the menuBar
 */

jQuery( document ).ready(function( $ ) {
	// Fix multi recaptcha 1.0 on same page
	setTimeout(function(){ if ($('.recaptcha').exists()) $('.recaptcha').html($('#recaptcha').clone(true,true)); }, 1000);
	
	// Menu DropDown Block Control
	$('.MenuDropDown').hide();
	$('.boxCloseButton').click(function(){ $('.MenuDropDown').hide(); return false; });
	$('#SiteMenu').click(function(){ $('.MenuDropDown:not(#MenuItemsBox)').hide(); $('#MenuItemsBox').toggle(); return false; });
	$('#UserBox').click(function(){ $('.MenuDropDown:not(#block-user)').hide(); $('#block-user').toggle(); return false; });
	$('#ContactUs').click(function(){ $('.MenuDropDown:not(#ContactUsBox)').hide(); $('#ContactUsBox').toggle(); return false; });
	
	// Search by pressing Enter key
	$("#searchTextInput").keypress(function(event) {
		if (event.which == 13) {
			//event.preventDefault();
			$("searchForm").submit();
		}
	});
});