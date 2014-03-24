var Validator = { obj: null };

jQuery.validator.addMethod('numeric',
	function (value, element, param) { 
		if (param) {
			return isNum(value);
		}
		return true;
}, 'Please enter a valid number.');

jQuery.validator.addMethod('biasSelected',
	function (value, element, param) {
		if (param) {
			return value != 'none';
		}
		return true;
}, 'Please select the variable.');

Validator.setup = function() {	
	var check_const_v2 = function() {
		return $('#bias [name="v2"]').val() == 'constant';
	};
	var biasSelected = function(name) {
		return function() {
			return $('#bias [name="'+name+'"]').val() != 'none';
		};
	}
	
	var rules = {
		'output[linear][]': { required: function(element) { return !$('input[name="output[linear][]"]:checked, input[name="output[log][]"]:checked').length; } },
		'output[log][]': { required: function(element) { return !$('input[name="output[linear][]"]:checked, input[name="output[log][]"]:checked').length; } },
		'v1': { biasSelected: true },
		'v1init': { numeric: biasSelected('v1') },
		'v1step': { numeric: biasSelected('v1') },
		'v1end': { numeric: biasSelected('v1') },
		'v2': { biasSelected: true },
		'v2init': { numeric: function(element) { return biasSelected('v2') && !check_const_v2(); } },
		'v2step': { numeric: function(element) { return biasSelected('v2') && !check_const_v2(); } },
		'v2end': { numeric: function(element) { return biasSelected('v2') && !check_const_v2(); } },
		'b1': { biasSelected: true },
		'b1_value': { numeric: biasSelected('b1') },
		'b2': { biasSelected: check_const_v2 },
		'b2_value': { numeric: function(element) { return biasSelected('b2') && check_const_v2(); }	}	
	};

	var messages = {
		'output[linear][]': "Please select some output filters to proceed.",
		'output[log][]': "Please select some output filters to proceed.",
		'v1': "Please select the first variable.",
		'v1init': "Please enter a valid number for the initial value of the first variable.",
		'v1step': "Please enter a valid number for the step value of the first variable.",
		'v1end': "Please enter a valid number for the end value of the first variable.",
		'v2': "Please select the second variable.",
		'v2init': "Please enter a valid number for the initial value of the second variable.",
		'v2step': "Please enter a valid number for the step value of the second variable.",
		'v2end': "Please enter a valid number for the end value of the second variable.",
		'b1': "Please select the fixed bias.",
		'b1_value': "Please enter a valid number for the fixed bias value.",
		'b2': "Please select the constant type for the second variable.",
		'b2_value': "Please enter a valid number for the value of the constant second variable."
	};	
	
	var groups = { 
		output: 'output[linear][] output[log][]',
		params: []
	};		
	
	$("#params input").each(function (item) {
		var name = $(this).attr('name');
		rules[name] = {
			numeric: true
		};
		messages[name] = "Please enter or select a valid number for each of the parameters.";
		groups.params.push(name);
	});	
	
	$("#params select").each(function (item) {
		var name = $(this).attr('name');
		rules[name] = {
			required: true
		};
		messages[name] = "Please enter or select a valid number for each of the parameters.";
		groups.params.push(name);
	});		
	
	groups.params = groups.params.join(" ");
	
	
	$('#params, #output, #bias').each(function() {
		$(this).prepend('<div class="error_box ui-state-error ui-corner-all hidden"><span class="ui-icon ui-icon-alert" style="float: left;"></span></div>');
	});
	
	Validator.obj = $("#simulation-form").validate({
		rules : rules,
		messages: messages,
		groups: groups,
		ignore: '.ignore',
		errorElement: "p",	
		submitHandler: function(form) {
			// Do the simulation
			simulate($('#tab_container'));
		},
		invalidHandler: function(form, validator) {
			var errors = validator.numberOfInvalids();
			if (errors) {
				var errTabs = [];
				var invalidPanels = $(validator.invalidElements()).closest(".ui-tabs-panel", form);
				if (invalidPanels.length > 0) {
					$.each($.unique(invalidPanels.get()), function(){
						$(this).find('div.error_box').show("pulsate", { times: 2 });
						var errTab = $(this).siblings(".ui-tabs-nav").find("a[href='#" + $(this).attr('id') + "']");
						errTab.parent().show("pulsate",{times: 2});
						errTabs.push(errTab.text() + " Tab");
					});
					
					alert(
						"<p>System has detected invalid input. Please correct the fields in the following tabs to proceed: </p><p>" + errTabs.join(', ')+"</p>",
						$('#tab_container'), 
						{ title: "Error in running simulation"	}
					);
				}
			}
		},
		showErrors: function(errorMap, errorList) {
			this.defaultShowErrors();
			$('.ui-tabs-panel:not(.ui-tabs-hide)').find('div.error_box').each(function() {
				if ($(this).find(".error:visible").length == 0) {
					$(this).hide();
				}
			});
		},
		errorPlacement: function(error, element) {
			var err_box = element.closest('div.ui-tabs-panel').find('div.error_box');
			err_box.show();
			error.appendTo(err_box);	
		},
		highlight: function(element, errorClass, validClass) {		
			$(element).closest('div.ui-tabs-panel').find('div.error_box').show();
			if (!$('#output').find(element).length) {
				if (!$(element).siblings('span.'+errorClass).length) {
					$('<span class="'+errorClass+'">*</span>').insertBefore(element);
				}
			}
		},
	    unhighlight: function(element, errorClass, validClass) {
			if (!$('#output').find(element).length) {
				$(element).siblings('span.'+errorClass).remove();
			}
		}
	});
};

Validator.validate = function() {
	if (Validator.obj) {
		return  Validator.obj.form();
	}
	return false;
};

$(document).ready(function(){
	Validator.setup();
});
