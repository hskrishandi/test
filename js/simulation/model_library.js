(function($) {

$(document).ready(function(){
	$("#new_model_lib").on("click", function(e) {
		var $this = $(this);
		confirm("Do you wish to create a new model library? All existing models will be deleted.", function(del) {
			if (del) {
				window.location = $this.data("action");
			}			
		}, $('body'));	
		
		e.preventDefault();
		return false;
	});
	
	$('<input type="file" name="paramModelLibrary" style="visibility:hidden; height: 0" />').appendTo('#side_menu');
	$('<iframe name="upload_model_library" style="visibility:hidden; height: 0" />').appendTo('#side_menu');
	$('input[name="paramModelLibrary"]').change(function() {
		var target = $(this);
		target.clone(true).insertAfter(target);   
		$.submit(CI_ROOT + "simulation/model_library/upload", target, "post", "upload_model_library", function(data) {
			if (data.success) {
				window.location.reload();
			} else {
				alert(data.result, $('body'), { 
					title: "Error in loading model library",
					close: function() {
						window.location.reload();
					}
				}); 
			}
		});
	});
	
	
	$("#load_model_lib").on("click", function(e) {
		$('input[name="paramModelLibrary"]').click();
		e.preventDefault();
		return false;
	});
});

}(jQuery));