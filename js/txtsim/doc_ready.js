/**
 *	i-mos.org Simlution fontend
 *	@fileOverview Controller scripts
 */
var data_return = null;
var position;
var netlist2;

//communicate with others
// function startf() {
//     simdappear();
//     var o = document.getElementById('targetbox');
//     o.contentWindow.postMessage('Hello World', '*');
//    	}
// make the library change
/*
 * Show Schemetic tab and side component selection box contents
 */
function simappear() {
	$("#userlib").attr({
		// "style": "z-index:50;visibility:hidden;position:absolute;"
		"style": "display:none;"
	});
	$("#targetbox").attr({
		// "style": "visibility:visible;z-index:500;position:absolute;"
	});
	$("#SClib").attr({
		// "style": "z-index:50;visibility:visible;position:absolute;"
		"style": "display:block;float:left;clear:both;"
	});
}

/*
 * Hide Schemetic tab and side component selection box contents
 */
function simdappear() {
	$("#userlib").attr({
		// "style": "z-index:50;visibility:visible;position:absolute;"
		"style": "display:block;float:left;clear:both;"
	});
	$("#targetbox").attr({
		// "style": "visibility:hidden;z-index:500;position:absolute;"
		"style": "display:none;"
	});
	$("#SClib").attr({
		// "style": "z-index:50;visibility:hidden;position:absolute;"
		"style": "display:none;"
	});
}

$(document).ready(function() {

	/*
		jQuery UI Tab Function
	*/
	// blockUI plugin (blur the page while simulating) config
	$.extend(true, $.blockUI.defaults, {
		fadeOut: 200,
		css: {
			border: 'none',
			backgroundColor: '#FFF'
		},
		overlayCSS: {
			backgroundColor: '#FFF',
			opacity: 0.8
		}
	});

	// tabs
	var tabcontainer = $('#tab_container');
	tabcontainer.tabs();
	tabcontainer.bind('tabsshow', function(event, ui) {
		//Event for clicking output tab. Callback the server program.
		if (ui.index == 2) {
			$("#textModeList").cmApply(function(cm) {
				cm.refresh();
			}).change();
		}
		if (ui.index == 4) {
			//Display the graph if there is any
			if (jqPlotObject.length > 0) {
				$('.graph-container').show();
				for (var i in jqPlotObject) {
					jqPlotObject[i].plot.replot({
						resetAxes: true
					});
					if (i != position)
						$('.graph-container:eq(' + i + ')').hide();
					else if (jqPlotObject[i].log_en) {
						$('#log_plot').show();
						if (jqPlotObject[i].log) {
							$('#log_plot i').addClass("icon-check").removeClass("icon-check-empty");
						} else
							$('#log_plot i').addClass("icon-check-empty").removeClass("icon-check");
					} else {
						$('#log_plot i').addClass("icon-check-empty").removeClass("icon-check");
						$('#log_plot').hide();
					}
				}
				//make the pull down menu same as the graph
				$('#graph')[0].selectedIndex = position;
			} else {
				$('#graphResult').html("");
			}
		}

	});

	//handling analyses Mode windows.

	//Initial the AnalyesMode first selection when page loaded
	$('#analyses_mode').buttonset();
	$('#analyses_mode input:first').each(function() {
		var id = $(this).attr("id");
		analysesMode($("#analyses_details #" + id));
	});
	$('#analyses_mode input').change(function() {
		var id = $(this).attr("id");
		analysesMode($("#analyses_details #" + id));
	});

	//Every textarea will autosize pressing enter
	$('.editorCommonDesign').autosize({
		append: "\n"
	});

	$('button.src_define').button()
		.click(function(event) {
			event.preventDefault();
		});


	/*
		Simlution Run
	*/
	var shandler = new SimulationHandler({
		interval: 2000
	});
	shandler.instance(shandler);
	$('.runSim').click(function(event) {
		//Clearing the Result from Last Simlution
		shandler.cleardata(jqPlotObject);
		//Analyze which "Run Simlution" clicked (Netlist or RAW input?)
		if ($(this).attr('id') == "runNetlistModeSim") {
			shandler.submitData = $('#netlistModeForm').serialize();
			shandler.submitpath = "txtsim/runNetlistSIM";
			shandler.simmode = 0;
		} else {
			shandler.submitData = $('#RAWModeForm').serialize();
			shandler.submitpath = "txtsim/runRAWSIM";
			shandler.simmode = 1;
		}
		//Create AJAX connection
		shandler.runsimulation();
		return;
	});

	$(".stop-simulation").click(function() {
		shandler.killsimulation();
		return;
	});

	//Conv the GUI to the netlist
	$('#functionConv').click(function(event) {
		shandler.convNetlist();
		return;
	});


	// window.addEventListener("message", function (e) {
	$("#schematicConv").click(function() {
		netlist2 = get_netlist();
		shandler.convNetlist2();
		return;
	});
	// }, false);
	/*$('#craw').click(function(event){
				shandler.convNetlist2();
				return;
	});*/


	$(".raw-input-load").fileupload({
		name: "RAWupload",
		url: CI_ROOT + "txtsim/loadRAW",
		load: function(data) {
			console.log(data);
			if (!data.error) {
				$('#textModeList').val(data.netlist);
				//$("#textModeList").trigger('autosize');
				$(".data-persist").change();
			} else
				alert(failUploadMsg);
		}
	});

	$("#functionRAWSave").click(function() {
		$('#RAWModeForm').formAndDownload(CI_ROOT + "/txtsim/saveRAW");
		//event.preventDefault();
		return false;
	});

	$(".raw-input-save-as").click(function() {
		prompt("Filename: ", function(filename) {
			if (filename == '') return;
			if (!$('.raw-saveas-name').length) {
				$('<input/>', {
					type: 'hidden',
					name: 'saveas_name',
					value: filename
				}).appendTo('#RAWModeForm').addClass('raw-saveas-name');
			} else
				$('.raw-saveas-name').val(filename);
			$('#RAWModeForm').formAndDownload(CI_ROOT + "/txtsim/saveasRAW");
		}, {
			note: downloadAsNote
		});
		return;
	});

	$(".netlist-load").fileupload({
		name: "Netlistupload",
		url: CI_ROOT + "txtsim/loadNetlist",
		load: function(data) {
			try {
				result = _safelyParseJSON(data.netlist);
				$('#srcNetlist').val(result.netlist);
				$("#srcNetlist").trigger('autosize');
				$('#srcAnalyses').val(result.analyses);
				$("#srcAnalyses").trigger('autosize');
				$('#srcDefination').val(result.source);
				$("#srcDefination").trigger('autosize');
				$('#txtOutVar').val(result.outvar);
				$("#txtOutVar").trigger('autosize');
				$('.data-persist').change();
			} catch (err) {
				alert(failUploadMsg);
			}
		}
	});

	//Netlist Save
	$("#functionNetlistSave").click(function() {
		console.log($('#netlistModeForm').serialize());
		$('#netlistModeForm').formAndDownload(CI_ROOT + "/txtsim/saveNetlist");
		event.preventDefault();
		return false;
	});

	//Netlist Save as
	$(".netlist-save-as").click(function() {
		prompt("Filename: ", function(filename) {
			if (filename == '') return;
			if (!$('.netlist-saveas-name').length) {
				$('<input/>', {
					type: 'hidden',
					name: 'saveas_name',
					value: filename
				}).appendTo('#netlistModeForm').addClass('netlist-saveas-name');
			} else
				$('.netlist-saveas-name').val(filename);
			$('#netlistModeForm').formAndDownload(CI_ROOT + "/txtsim/saveasNetlist");
		}, {
			note: downloadAsNote
		});
		return;
	});

	/* initialize CodeMirror*/
	$(".code-mirror").cmInit();
	$("div.CodeMirror.CodeMirror-wrap").attr("style", "height:350px");

	$("<iframe name='my_iframe' style='display:none'></iframe>").appendTo('BODY');
});
var CSVDownload = function(url, item_no) {
	var CSV = $("<form>").attr('method', 'POST').attr('target', 'my_iframe').addClass("hidden").attr('action', url);
	$("<input>").attr('name', 'uuid').val(data_return.uuid).appendTo(CSV);
	$("<input>").attr('name', 'file').val(data_return.dataset[item_no].filename).appendTo(CSV);
	CSV.appendTo($("body"));
	CSV.submit();
	CSV.remove();
	return false;
}
$.fn.RAWUpload = function(url, callback) {
	this.attr('action', url).attr('method', 'POST').attr('target', 'my_iframe').attr('enctype', "multipart/form-data").submit();
	$('iframe[name=my_iframe]').html("").unbind("load").load(function() {
		var result = $('iframe[name=my_iframe]').contents().text();
		try {
			result = _safelyParseJSON(result);
			callback(result);
		} catch (err) {};
	});
	return false;
}

$.fn.formAndDownload = function(url) {
	this.attr('action', url).attr('method', 'POST').attr('target', 'my_iframe').submit();
	return false;
}
var confirm;
var ROOT = CI_ROOT + "modelsim";
var MODEL_ID = 0;
(function($) {

	$(document).ready(function() {
		MODEL_ID = $("#model-lib-list").data("current");

		viewModels = {
			lib: new ModelLibrary()
				//sim: new ModelSimulation()
		};

		viewModels.lib.load();
		//viewModels.sim.init();

		ko.applyBindings(viewModels.lib, $(".model-library")[0]);
		//ko.applyBindings(viewModels.sim, $("#model-page")[0]);
		/*
		$("#model-page").on('change', "#param-tab-model input", function() {
			viewModels.sim.selectedSet(null);		// invalidated selection
			return false;
		});
		*/
	});

	// Model library menu
	ko.bindingHandlers.modelLibMenu = {
		init: function(element, valueAccessor) {
			var $menu = $(valueAccessor()).menu().hide();
			var $ele = $(element);
			var pos = $ele.position();
			pos.top += $ele.height() - $menu.offset().top + 3;
			pos.left -= $menu.offset().left + 1;
			$menu.offset(pos);

			$ele.click(function() {
				if ($menu.is(":visible")) {
					$ele.removeClass("active");
					$menu.hide();
				} else {
					$menu.show();
					$ele.addClass("active");
					$("html").one("click", function() {
						if ($menu.is(":visible")) {
							$ele.click();
						}
					});
				}

				return false;
			});

			ko.bindingHandlers.modelLibMenu.initActions(valueAccessor());
		},
		initActions: function(element) {
			var $ele = $(element);

			// Download
			$ele.find('.download').click(function() {
				$.submit({
					url: ROOT + "/modelLibrary/DOWNLOAD",
					type: 'GET',
					load: function(data) {
						if (!data.success) {
							console.log("Error: " + data.error);
						}
					}
				});
				return false;
			});

			// New library
			$ele.find('.new').click(function() {
				confirm("Do you wish to create a new model library? Your existing library will be erased.", function(load) {
					if (load) {
						$.ajax({
							url: ROOT + "/modelLibrary/NEW",
							success: function(result) {
								viewModels.lib.load();
							},
							error: function(jqXHR, textStatus, errorThrown) {
								console.log("Error: " + textStatus + "; " + errorThrown);
							}
						});
					}
				});
				return false;
			});
		}
	};

	ko.bindingHandlers.modelLibEntry = {
		init: function(element, valueAccessor, allBindingsAccessor, entry, bindingContext) {
			$(element).attr("model-name", entry.name);
			$(element).attr("model-id", entry.id);
		}
	};

	confirm = function(message, callback, options) {
		var defaultActions = {
			buttons: {
				Confirm: function() {
					callback(true);
					$(this).dialog('close');
				},
				Cancel: function() {
					callback(false);
					$(this).dialog('close');
				}
			}
		};
		var confirmBox = $('#confirm');
		if (!confirmBox.length) {
			confirmBox = $('<div id="confirm"><i class="icon-info-sign icon-4x pull-left"></i><div class="confirm-message"></div></div>').hide().appendTo('body');
		}

		$("div", confirmBox).html(message);

		confirmBox.dialog($.extend({}, confirm.defaults, defaultActions, options));
	};

	SimulationHandler = function(options) {
		/* private member */
		var _instance = null;
		var _interval = options.interval;
		//var position = 0;
		var _session = "";
		var _running = false;
		var _simulationTimeout = 600000;
		var _timeoutInstance;

		window.onunload = function() {
			_instance.killsimulation();
		};
		//callback function
		var running = function(b) {
			_running = b;
			if (b) {
				/* BLOCK */
				_instance.block();
				_timeoutInstance = setTimeout(function() {
					_instance.killsimulation();
				}, _simulationTimeout);
			} else {
				clearTimeout(_timeoutInstance);
				_instance.unblock();
			}
		};
		var _plotdata = function(sender, data) {
			running(false);
			data_return = data;
			if (!_errmsg(data)) {
				//check for the simulation type
				if (data.netlist.match(/[\n\r]\.?tran( [0-9\.]+[a-zA-Z]*)+/i))
					for (var i in data.dataset)
						data.dataset[i].xlabel = "tran";
				else if (data.netlist.match(/[\n\r]\.?ac lin [0-9]+/i))
					for (var i in data.dataset)
						data.dataset[i].xlabel = "ac_lin";
				//else if(data.netlist.match(/[\n\r].?AC DEC [^\n\r] /i))
				else if (data.netlist.match(/[\n\r]\.?ac dec/i))
					for (var i in data.dataset)
						data.dataset[i].xlabel = "ac_dec";
				else {
					//var dc_string = data.netlist.match(/[\n\r]\.?dc(.+)[\n\r]/ig);

					for (var i in data.dataset)
						data.dataset[i].xlabel = "dc";
				}
				//Graph Result Plot and Display
				console.log(data.dataset);
				if (data.dataset) plot_graph($('#graphResult'), data.dataset);
				$("#graph").change(function() {
					var str = $("#graph").val();
					$('.graph-container:eq(' + position + ')').hide();
					for (var i in jqPlotObject) {
						if (jqPlotObject[i].name === str) {
							$('.graph-container:eq(' + i + ')').show();
							position = i;
							if (jqPlotObject[i].log) {
								$('#log_plot i').addClass("icon-check").removeClass("icon-check-empty");
							} else {
								$('#log_plot i').addClass("icon-check-empty").removeClass("icon-check");
							}
						}
					}
				});
				//Disable right click menu on the plot
				$(".graph-container").bind("contextmenu", function(e) {
					return false;
				});
				//RAW Result Display
				var string = "";
				//Genrating dynamic page for display RAW data
				var pull_down_form = $("<div>").attr("id", "pull_down").attr("class", "button").html("<B>Dataset</B> ");
				var csv_download = $("<a>").attr("id", "csv_download").addClass("csv_download").html("<i class='icon-download-alt'></i>Save as file");
				var pull_down_select = $("<select>").attr("id", "pull_down_menu").appendTo(pull_down_form);
				csv_download.appendTo(pull_down_form);
				var result_form = $("<div>").attr("id", "result_form");
				for (var key in data.dataset) {
					if (data.dataset[key].error == "true") {
						//string = string + "Error: The item(s) " + data.dataset[key].ylabel +" not found.<br />";
						continue;
					} else {
						$('<option>').attr("id", "dataset_select" + key).attr("value", key).html(data.dataset[key].ylabel).appendTo(pull_down_select);
						$("<div>").attr("id", "dataset" + key).addClass("hidden").html(_rawtable(data.dataset[key].table_data)).appendTo(result_form);
					}
				}
				result_form.children().first().removeClass("hidden");
				if (data.dataset != null && data.dataset.length > 0)
					$('#rawResult').append(pull_down_form).append(result_form);
				pull_down_select.change(function(object) {
					result_form.children().addClass("hidden");
					result_form.children("#dataset" + $(this).val()).removeClass("hidden");
				});

				$("#csv_download").click(function() {
					CSVDownload("txtsim/CSVDownload", pull_down_select.val());
				});
				$('#log').html(data.log);
			}
		};
		var _rawtable = function(data) {
			var string = "";
			string = string + "<table style='margin-left:15px'>"
			for (var cols in data) {
				string = string + "<tr>"
				for (var rows in data[cols]) {
					if (rows == 0) {
						string = string + "<td style='padding-right:10px;'>";
						string = string + data[cols][rows].toExponential(7) + "  &nbsp&nbsp";
						string = string + "</td>";
					} else if (rows % 2 == 1) {
						string = string + "<td style='padding-right:10px;'>";
						string = string + data[cols][rows].toExponential(7) + "  &nbsp&nbsp";
						string = string + "</td>";
					}
				}
				string = string + "<tr />"
			}
			string = string + "</table>"
			return string;
		};
		var _checkstatus = function(sender) {
			$.ajax({
				url: CI_ROOT + "txtsim/simulationStatus",
				type: "POST",
				data: {
					session: _session
				},
				success: function(data) {
					try {
						data = _safelyParseJSON(data);
					} catch (err) {}
					if (_statushandler(sender, data)) {
						console.log(data);
						_plotdata(sender, data);
						_simerr($("#log").html());
					}
				}
			}).fail(function(jqXHR, textStatus) {
				_failhandler(sender, {
					jqXHR: jqXHR,
					textStatus: textStatus
				});
			});
		};
		/* ajax run simulation handler */
		var _statushandler = function(sender, data) {
			if (data.status) {
				if (data.status == "RUNNING") {
					setTimeout(function() {
						_checkstatus(sender);
					}, _interval);
				} else if (data.status == "KILL") {
					alert("The simulation has been stopped.");
					running(false);
				} else if (data.status == "FINISHED") {
					return true;
				}
			}
			return false;
		};
		var _failhandler = function(sender, options) {
			running(false);
			var jqXHR = options.jqXHR;
			var textStatus = options.textStatus;
			if (jqXHR.status == 500) {
				//$('#log').html("Error: " + jqXHR.status + " "+ jqXHR.statusText + "<br />");
				$('#log').html("Your simulation results in too much data points, please reduce the step value and try it again.");
			} else if (jqXHR.status == 404) {
				$('#log').html("Error: " + jqXHR.status + " " + jqXHR.statusText + "<br />");
			} else {
				$('#log').html("Error: " + jqXHR.status + " " + jqXHR.statusText + "<br />Please check the connect to the server.");
			}
		};
		/* message handler */
		var _simerr = function(log) {
			var reg_err = new Array();
			reg_err[0] = /error/i;
			reg_err[1] = /warning/i;
			reg_err[2] = /fail/i;
			for (var x in reg_err) {
				if (reg_err[x].test(log)) {
					alert("Error/Warning may occurred.\nPlease check the log.");
					break;
				}
			}
		};
		var _errmsg = function(data) {
			if (data.error == false) {
				return false;
			} else {
				if (data.type == "model") {
					alert("Error: " + "Model not found - " + data.obj);
					return true;
				}
				if (data.type == "library") {
					alert("Error: " + "Library not found - " + data.obj);
					return true;
				}
			}
			return true;
		}

		/* public member */
		return {
			instance: function(that) {
				if (_instance == null)
					_instance = that;
			},
			block: function() {
				$(".stop-simulation").css("display", "inherit");
				$('#tab_container').block({
					message: $('#loading'),
					css: {
						backgroundColor: 'transparent'
					}
				});
			},
			unblock: function() {
				$(".stop-simulation").css("display", "none");
				$('#tab_container').unblock();
			},
			cleardata: function(jqdata) {
				for (var i in jqPlotObject) {
					delete jqPlotObject[i];
				}
				jqPlotObject = new Array();
				$('#rawResult').html("");
				$('#log').html("");
			},
			runsimulation: function() {
				var self = this;
				running(true);
				$.ajax({
					url: CI_ROOT + this.submitpath,
					type: "POST",
					data: this.submitData,
					dataType: "json"
				}).done(function(data) {
					try {
						console.log(data);
						data = _safelyParseJSON(data);
					} catch (err) {
						console.log("fail!!!");
					}
					if (data.id) {
						_session = data.id;
						_checkstatus(self);
					}
				});
			},
			killsimulation: function() {
				if (!_running) return;
				$(".stop-simulation").css("display", "none");
				$.ajax({
					url: CI_ROOT + "txtsim/simulationStop",
					type: "POST",
					data: {
						session: _session
					}
				});
			},
			convNetlist: function() {
				$.ajax({
					url: CI_ROOT + "txtsim/convNetlistToRAW",
					type: "POST",
					data: $('#netlistModeForm').serialize(),
					dataType: "json"
				}).done(function(data) {
					console.log(data);
					if (!_simerr(data)) {
						$("#textModeList").val(data.netlist);
						//$("#textModeList").trigger('autosize');
						$(".data-persist").change();
					}
				});
				$("div.CodeMirror.CodeMirror-wrap").attr("style", "height:350px");
			},
			convNetlist2: function() {
				$('#tab_container').tabs({
					active: 2
				});
				$("#textModeList").val(netlist2);
				$(".data-persist").change();
				$("div.CodeMirror.CodeMirror-wrap").attr("style", "height:350px");
			}
		};
	};

}(jQuery));

function _safelyParseJSON(json) {
    let parsed = null
    try {
        // if it is json string
        parsed = JSON.parse(json)
    } catch (e) {
        // if it is json object
        parsed = json
    }
    return parsed
}
