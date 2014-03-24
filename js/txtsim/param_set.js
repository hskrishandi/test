// Handle parameter sets

(function($) {

var DISCONNECT_MSG = "Cannot retrieve data from server. Either the server is down or your computer is not connected to the Internet. Please try again later.";

function error(msg) {
	alert(msg);
	window.location.reload();
}

function prompt_for_name(success) {
	var defaults = {
		modal		: false,
		resizable	: false,
		buttons		: {
			OK : function() {
				var name = $("#prompt input#user_param_set_name").val();
				if (name != null && name != "") {
					success(name);
					$(this).dialog('close');
				} else {
					alert(
						"<p>The name cannot be empty</p>",
						$('#tab_container')
					);
				}
			},
			Cancel : function() {				
				$(this).dialog('close');
			}
		},
		show		: 'fade',
		hide		: 'fade',
		width		: 400,
		minHeight	: 150,
		dialogClass	: 'alert-box prompt-box',
		title		: 'Please enter a name for the parameter set'
	};
	
	var promptBox = $('#prompt');
	if (!promptBox.length) {
	 	promptBox = $('<div id="prompt">Parameter set name: <input id="user_param_set_name" type="text" maxlength="30"/></div>').hide().appendTo('body');		
	}
	
	promptBox.dialog(defaults);
}

function load_default_param_list(pset) {
	$('#param-sets div.param-set-list .param-set').remove();
	if (pset.length > 0) {
		$('#param-sets div.no-param-set').addClass('hidden');
	} else {
		$('#param-sets div.no-param-set').removeClass('hidden');
	}	
	for (var i in pset) {
		$('<div data-model-id="'+pset[i].id+'" class="param-set" title="Load this parameter set">'+pset[i].name+'</div>').appendTo('#param-sets div.param-set-list');
	}
}

function load_default_set(id) {
	$.ajax({
		url: CI_ROOT + "simulation/param_set/get/" + model_id,
		type: "post",
		dataType: "json",
		data: {id: id},
		success: function (data) {
			if (data.success) {
				var tab = $('#params');
				for (var i in data.result) {
					tab.find('[name="'+data.result[i].name+'"]').val(data.result[i].value).change();
				}
			} else {
				error(data.result);
			}			
		},
		error: function() {
			error(DISCONNECT_MSG);
		}
	});
}

function load_param_list(target, pset) {
	target.find('li:has(.param-set)').remove();
	for (var i in pset) {
		$('<li><a href="#" data-model-id="'+pset[i].id+'" class="param-set" title="Select this parameter set">'+pset[i].name+'</a>'+'</li>').appendTo(target);
	}
}

function load_set(id, onSuccess) {
	$.ajax({
		url: CI_ROOT + "simulation/user_param_set/get/" + model_id,
		type: "post",
		dataType: "json",
		data: {id: id},
		success: function (data) {
			if (data.success) {
				var tab = $('#params');
				for (var i in data.result) {
					tab.find('[name="'+data.result[i].name+'"]').val(data.result[i].value).change();
				}		
				onSuccess();
			} else {
				error(data.result);
			}			
		},
		error: function() {
			error(DISCONNECT_MSG);
		}
	});
}	







$(document).ready(function() {
/*
	$.ajax({
		url: CI_ROOT + "simulation/param_set/list/" + 2,
		dataType: "json",
		success: function (data) {
			if (data.success) {
				load_default_param_list(data.result);
				console.log(data.result);
			} else {
				error(data.result);
			}			
		},
		error: function() {
			error(DISCONNECT_MSG);
		}
	});
	*/

	$('.simulation_block ul#model-list li').each(function(index){
		var model_id =$(this).attr("data-id");
		
		var model_item = $('.simulation_block ul#model-list li[data-id="'+model_id+'"]');
	
		$.ajax({
			url: CI_ROOT + "simulation/user_param_set/list/" + model_id,
			dataType: "json",
			success: function (data) {
				if (data.success) {
					load_param_list(model_item.find('.user-params'), data.result);
          if (data.result.length == 0){
            model_item.hide();
          }
				} else {
					error(data.result);
					return false;
				}			
			},
			error: function() {
				error(DISCONNECT_MSG);
				return false;
			}
		});
		
	});

	
	$('.simulation_block ul#model-list a.param-set').click(function(){
		event.preventDefault();
		console.log("123");
	});

	




	

});

})(jQuery);
