// Handle parameter sets

(function($) {

var DISCONNECT_MSG = "Cannot retrieve data from server. Either the server is down or your computer is not connected to the Internet. Please try again later.";

function error(msg) {
	alert(msg, $('#tab_container'), { 
		title: "Error in handling parameter sets",
		close: function() {
			window.location.reload();
		}
	}); 
}

function prompt_for_name(success) {
	var defaults = {
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
		title		: 'Please enter a name for the model library'
	};
	
	var promptBox = $('#prompt');
	if (!promptBox.length) {
	 	promptBox = $('<div id="prompt">Model library name: <input id="user_param_set_name" type="text" maxlength="30"/></div>').hide().appendTo('body');		
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
		$('<li><a href="#" data-model-id="'+pset[i].id+'" class="param-set" title="Select this parameter set">'+pset[i].name+'</a>'+'<a href="#" class="circle delete" title="Delete this parameter set">&#215;</a>'+'</li>').appendTo(target);
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

function delete_set(id) {
	$.ajax({
		url: CI_ROOT + "simulation/user_param_set/del/" + model_id,
		dataType: "json",
		type: "post",
		data: {id: id},
		success: function (data) {
			if (data.success) {
				$.ajax({
					url: CI_ROOT + "simulation/user_param_set/list/" + model_id,
					dataType: "json",
					success: function (data) {
						if (data.success) {
							var model_item = $('.simulation_block ul#model-list li[data-id="'+model_id+'"]');
							load_param_list(model_item.find('.user-params'), data.result);
						} else {
							error(data.result);
						}			
					},
					error: function() {
						error(DISCONNECT_MSG);
					}
				});
			} else {
				error(data.result);
			}			
		},
		error: function() {
			error(DISCONNECT_MSG);
		}
	});
}

function save_set(id) {
	if (id != null && id > 0) {
		$.ajax({
			url: CI_ROOT + "simulation/user_param_set/set/" + model_id,
			dataType: "json",
			type: "post",
			data: {id: id, data: JSON.stringify($('#params input, #params select').serializeArray())},
			success: function (data) {
				if (!data.success) {
					error(data.result);
				}
			},
			error: function() {
				error(DISCONNECT_MSG);
			}
		});
	} else {
		prompt_for_name(function(name) {
			$.ajax({
				url: CI_ROOT + "simulation/user_param_set/add/" + model_id,
				dataType: "json",
				type: "post",
				data: {name: name, data: JSON.stringify($('#params input, #params select').serializeArray())},
				success: function (data) {
					if (!data.success) {
						error(data.result);
					} else {
						// TODO: cleanup the code
						var model_item = $('.simulation_block ul#model-list li[data-id="'+model_id+'"]');
						$.ajax({
							url: CI_ROOT + "simulation/user_param_set/list/" + model_id,
							dataType: "json",
							success: function (data) {
								if (data.success) {
									load_param_list(model_item.find('.user-params'), data.result);
								} else {
									error(data.result);
								}			
							},
							error: function() {
								error(DISCONNECT_MSG);
							}
						});
					}		
				},
				error: function() {
					error(DISCONNECT_MSG);
				}
			});	
		});
	}
}

function reset_params() {
	$('#params input, #params select').each(function() {			
		$(this).focus();
		$(this).val($(this).prop('defaultValue'));
		$(this).blur();
	});
}

$(document).ready(function() {
	$.ajax({
		url: CI_ROOT + "simulation/param_set/list/" + model_id,
		dataType: "json",
		success: function (data) {
			if (data.success) {
				load_default_param_list(data.result);
			} else {
				error(data.result);
			}			
		},
		error: function() {
			error(DISCONNECT_MSG);
		}
	});
	
	var set_list = $('#param-sets div.param-set-list')
	set_list.on("click", ".param-set", function() {
		var target = $(this);
		var id = parseInt(target.attr('data-model-id'));
		load_default_set(id);
	});

	var model_item = $('.simulation_block ul#model-list li[data-id="'+model_id+'"]');

	$.ajax({
		url: CI_ROOT + "simulation/user_param_set/list/" + model_id,
		dataType: "json",
		success: function (data) {
			if (data.success) {
				load_param_list(model_item.find('.user-params'), data.result);
				model_item.addClass("current")
			} else {
				error(data.result);
			}			
		},
		error: function() {
			error(DISCONNECT_MSG);
		}
	});	
	
	set_list = $('#model-list li[data-id="'+model_id+'"]');
	set_list.on("click", ".param-set", function() {
		var target = $(this);
		var id = parseInt(target.attr('data-model-id'));
		load_set(id, function() {
			// TODO: notify success
		});
		return false;
	});
	
	set_list.on("click", ".user-params .delete", function(e) {
		var target = $(this).closest('li').find(".param-set");
		confirm("Do you wish to delete the library \"" + target.text() + "\" ?", function(del) {
			if (del) {
				delete_set(parseInt(target.attr('data-model-id')));
			}
		}, $('#tab_container'));		
		return false;
	});
	
	// Save to user library button
	$('.save_set').click(function(e) {
		save_set();
		e.preventDefault();
		return false;
	});
	
	// Download parameters button
	$('.dl_params').click(function(e) {
		var clones = $('#params input, #params select').clone();
        $('#params input, #params select').filter("select").each(function(i) {
			clones.filter("select").eq(i).val($(this).val());
        });
		$.submit(CI_ROOT + "simulation/download", clones, "post");
		e.preventDefault();
		return false;
	});
	
	// Upload parameters controls
	$('<input type="file" name="paramFile" style="visibility:hidden; height: 0" />').appendTo('#tab_container');
	$('<iframe name="upload_result" style="visibility:hidden; height: 0" />').appendTo('#tab_container');
	$('input[name="paramFile"]').change(function() {
		var target = $(this);
		target.clone(true).insertAfter(target);   
		$.submit(CI_ROOT + "simulation/upload", target, "post", "upload_result", function(data) {
			if (data.success) {
				for (var key in data.result) {
					$('#params [name='+key+']').val(data.result[key]);
				}
			} else {
				alert(data.result, $('#tab_container'), { 
					title: "Error in loading parameters",
					close: function() {
						window.location.reload();
					}
				}); 
			}
		});
	});
	
	$('.load_params').click(function(e) {
		$('input[name="paramFile"]').click();
		e.preventDefault();
		return false;
	});
});

})(jQuery);
