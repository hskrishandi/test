function isNum(val){
  if(val === "") return false;
  else return !isNaN(val);
}

if(typeof console === "undefined" || !console)
  console = {
    dir: function(){},
    log: function(){}
  };

// Override BlockUI defaults
$.extend(true, $.blockUI.defaults, {
	fadeOut:  200,
	css: { border: 'none', backgroundColor: '#FFF' }, 
	overlayCSS:  { backgroundColor: '#FFF', opacity: 0.8 }
});

$(document).ready(function(){
	var container = $('#tab_container');
	container.tabs();
	container.children(':not(#comments)').wrapAll('<form id="simulation-form" method="get" action="" />');	
	$('#param_tabs').tabs();
	
	// Save user state
	$('#simulation-form').cookie('restoreForm', model_name);	
	container.cookie('restoreTab', model_name);	
	if (container.tabs('option', 'selected') == 4) {
		container.tabs('select', 0);
	}		
	$(window).unload(function() {
		container.cookie('saveTab', model_name);
		$('#simulation-form').cookie('saveForm', model_name);
	});

	$('#simulation-form .btn_submit').click(function(e) {
		$('#simulation-form').submit();
		e.preventDefault();
		return false;
	});
	
	container.find("[name=v2]").change(function(e) {
		if(container.find('[name=v2]').val() === "constant"){	
			container.find('.v2_c').removeClass('hidden');
			container.find('.v2').addClass('hidden');
		} else{
			container.find('.v2_c').addClass('hidden');
			container.find('.v2').removeClass('hidden');
		}
	}).change();
});

	
var simulation = new Simulation({modelID: model_id, backendUrl: backend_url, graphMap: graph_map});

/** 
 * simulate(container) function
 * acquire the data and perform the simulation
 */
function simulate(container) {
	var params = getParams(container);
	var bias = getBiases(container);
	var outputs = getOutputs(container, graph_map);
	
	// disable the submit button
	var btnSubmit = container.find('.btn_submit');
	btnSubmit.attr('disabled', 'disabled');
	container.block({ 
		message: $('#loading'),
		css: { backgroundColor: 'transparent' }
	}); 
	
	var showError = function(err) {
		var msg = "An unknown error has occurred. Please try again later.";
		if (err != null) {
			msg = err;
		}
		
		alert(
			"<p>"+msg+"</p>",
			container, 
			{ title: "Error in running simulation"	}
		);
	};
	
	simulation.run({
		biases: bias,
		params: params,
		success: function(){
			simulation.getOutputs({
				outputFilter: outputs, 
				success: function(output) {
					container.unblock();
					container.tabs('select', 4);	
					btnSubmit.removeAttr('disabled');	
					console.log(output);
					var resultsTab = container.find('#result-container');
					plotGraphs(resultsTab, bias, output);
				},
				error: function(msg) {
					container.unblock();
					btnSubmit.removeAttr('disabled');
					console.log("Error in retrieving output data");
					showError(msg);
				}
			});
		},
		error: function(msg){
			container.unblock();
			btnSubmit.removeAttr('disabled');
			console.log("Error in initiating a simulation");
			showError(msg);
		}
	});
}
	
/** 
 * getParams(target) function
 * A function which gets input parameters
 * Can be overriden for more specific behavior
 */
function getParams(target) {
	var inputs = target.find('#params input, #params select');
	var data = {};
	
	for (var i = 0; i < inputs.length; ++i){
		var param = inputs.eq(i);
		data[param.attr("name")] = param.val();
		if (isNum(data[param.attr("name")])) {
			data[param.attr("name")] = parseFloat(data[param.attr("name")]);
		}
	}
	
	return data;
}
	
/** 
 * getBiases(target) function
 * A function which gets bias parameters
 * Can be overriden for more specific behavior
 */
function getBiases(target) {	
	function getByName(name){
		var val = target.find("[name=" + name + "]").val();
		return (isNum(val) ? parseFloat(val) : val);
	}
	
	var data = {};
	
	data.v1 = {
		type: getByName('v1'),
		init: getByName('v1init'),
		step: getByName('v1step'),
		end: getByName('v1end')
	};
	
	data.b1 = {
		type: getByName('b1'),
		value: getByName('b1_value')
	};
	
	if (getByName('v2') === 'constant') {
		data.b2 = {
			type: getByName('b2'),
			value: getByName('b2_value')
		};	
	} else {
		data.v2 = {
			type: getByName('v2'),
			init: getByName('v2init'),
			step: getByName('v2step'),
			end: getByName('v2end')
		};
	}

	return data;
}

/** 
 * getOutputs(target, graphMap) function
 * A function which gets the list of graphs to be plotted
 * Can be overriden for more specific behavior
 */
function getOutputs(target, graphMap){	
	var graphs = {};
	var linear = target.find('#output input[name="output[linear][]"]:checked');
	var log = target.find('#output input[name="output[log][]"]:checked');
	
	for(var i = 0; i < linear.length; i++){
		graphs[linear.eq(i).attr("value")] = { linear: true, log: false };
	}
	
	for(var i = 0; i < log.length; i++){
		var elem = log.eq(i);
		if (typeof(graphs[elem.attr("value")]) === 'undefined') {
			graphs[elem.attr("value")] = { linear: false, log: true };
		} else {
			graphs[elem.attr("value")].log = true;
		}
	}
	
	var result = [];
	for (var key in graphs) {
		var entry = graphs[key];
		entry.name = key;
		result.push(entry);
	}
		
	return result;
}
