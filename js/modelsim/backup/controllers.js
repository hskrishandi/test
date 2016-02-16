/**
 * @fileOverview Controller scripts
 */ 

 // Exports
 var ROOT = CI_ROOT + "modelsim";
 var MODEL_ID = 0;
 
 (function ($) {
	//var viewModels;		// view model collection
		
				
	// Entry point
	$(document).ready(function() {
		MODEL_ID = $("#model-lib-list").data("current");

		viewModels = {
			lib: new ModelLibrary(),
			sim: new ModelSimulation()
		};

		viewModels.lib.load();
		viewModels.sim.init();
		ko.applyBindings(viewModels.sim, $(".model-benchmark-side-menu")[0]);	
		ko.applyBindings(viewModels.lib, $(".model-library")[0]);
		ko.applyBindings(viewModels.sim, $("#model-page")[0]);
	
		
		$("#model-page").on('change', "#param-tab-model input", function() {			
			viewModels.sim.selectedSet(null);		// invalidated selection
			return false;
		});
						
		// Save As Parameters
		$(".param-save-as").click(function() {
			prompt("Filename: ", function(filename) {
				if(filename == "") return;
				var data = viewModels.sim.modelParams.getData();
				data.push({"filename" : filename});
				$.submit({
					url: ROOT + "/clientParamSet/DOWNLOADAS/" + MODEL_ID,
					type: 'POST',
					data: data
				});
			}, {
				note: downloadAsNote
			});
		});
		
		$(".model-param-load").fileupload({
			name: "file",
			uploadStart: function() {
				viewModels.sim.isLoading(true);
			},
			uploadComplete: function() {
				viewModels.sim.isLoading(false);
			},
			url: ROOT + "/clientParamSet/UPLOAD/" + MODEL_ID,
			load: function(data) {
				if (data.success) {
					var params = viewModels.sim.loadParams(data.data);
					params.error += data.error.length;
					
					if (params.error == 0) {
						var msg = "File uploaded and parsed successfully!";	
					} else {
						var msg = "File uploaded successfully with " + params.error + " minor error(s) during parsing: <br /><br />";
						
						msg += "<blockquote>";
					
						if (data.error.length > 0) {
							$(data.error).each(function() {
								msg += "<li>";
								msg += this;
								msg += "</li>";									
							});
						
						}
						
						if (params.missing.length > 0) {
							msg += "<li>" + params.missing.length + " parameter(s) missing: ";
							msg += viewModels.sim.paramSelectList(params.missing, "missingParamList");
							msg += "</li>";
							
							// Switch to the tab of the first missing parameter
							viewModels.sim.paramSelect(params.missing[0], false);
						}
						if (params.extra.length > 0) {
							msg += "<li>" + params.extra.length + " extra parameter(s) detected: ";
							msg += viewModels.sim.paramSelectList(params.extra, "extraParamList"); 
							msg += "</li>";	
						}
						
						msg += "</blockquote>";
					
					}
					
					alert("<br />" + msg);
					
					$("#missingParamList").change(function() {
						viewModels.sim.paramSelect($(this).val());
					});
				} else {
					alert(data.error);
				}


							
			}
		});

		// Search box
		$( "#search_param" ).click(function() {
			viewModels.sim.searchParamsInit();
		}).focus(function() {
			viewModels.sim.searchParamsInit();
		});

		$(document).ajaxComplete(function(e, xhr, settings) {
			$(".plot-custom-data-load").fileupload({
				name: "file",
				uploadStart: function() {
					viewModels.sim.isLoading(true);
				},
				uploadComplete: function() {
					viewModels.sim.isLoading(false);
				},
				url: ROOT + "/clientPlotData/UPLOAD",
				load: function (data) {
					if (data.success)
						viewModels.sim.selectedPlot().customData(data.data);
					else
						alert(failUploadMsg);
				}
			});
		});
		
		//clearup
		window.onunload = function() {
			if(viewModels.sim.isSimulating())
				viewModels.sim.stopSimulation();
		};
	});
		
	// jQuery UI tabs handler
	ko.bindingHandlers.tabs = {
		init: function(element, valueAccessor) {
			var tabIndex = valueAccessor();
			if (ko.isObservable(tabIndex)) {
				$(element).tabs({
					activate: function(event, ui){
						tabIndex(ui.newTab.index());
					}
				});
			} else {
				$(element).tabs();
			}
			$(element).tabs("option", "active", ko.utils.unwrapObservable(tabIndex));
		},
		update: function(element, valueAccessor) {
			$(element).tabs("option", "active", ko.utils.unwrapObservable(valueAccessor()));
		}
	};
	
	// loading animation handler
	ko.bindingHandlers.loadingWhen = {
		update: function(element, valueAccessor) {
			var isLoading = ko.utils.unwrapObservable(valueAccessor());
			if (isLoading) {
				$(element).block({
					message: $('#loading'),
					css: { backgroundColor: 'transparent' }
				});
			} else {
				$(element).unblock();
			}
		}
	};
	
	// Fancy Checkbox handler
	ko.bindingHandlers.checkbox = {
		init: function(element, valueAccessor) {
			var $ele = $(element);
			var observable = valueAccessor();
			var $checkbox = $ele.find("input[type=checkbox]");
			var $i = $("<i />").prependTo($ele).addClass("icon-checkbox");
			
			$ele.data("_checkHandler", function(value) {
				$i.remove();
				$i = $("<i />").prependTo($ele).addClass("icon-checkbox");
				if(ko.utils.unwrapObservable(value)) {
					$i.addClass("icon-check");
					$checkbox.attr('checked', true);
				} else {
					$i.addClass("icon-check-empty");
					$checkbox.attr('checked', false);
				}
			});
			
			$checkbox.change(function() {
				if ($(this).attr('checked')) {
					observable(true);
				} else {
					observable(false);
				}
			});
			
			$checkbox.css("opacity", 0);
			$ele.data("_checkHandler")(valueAccessor());
		},
		update: function(element, valueAccessor) {
			$(element).data("_checkHandler")(valueAccessor());
		}		
	};
	
	// Select all button handler
	ko.bindingHandlers.checkAll = {
		init: function(element, valueAccessor) {
			$(element).click(function() {
				$(valueAccessor()).each(function() {
					var data = ko.dataFor(this);
					data.linearPlot(true);
					data.logPlot(true);
				});
				return false;
			});
		}
	};
	
	// Deselect all button handler
	ko.bindingHandlers.uncheckAll = {		
		init: function(element, valueAccessor) {
			$(element).click(function() {
				$(valueAccessor()).each(function() {
					var data = ko.dataFor(this);
					data.linearPlot(false);
					data.logPlot(false);
				});
				return false;
			});
		}
	};
	
	// Add parameter set to model library
	ko.bindingHandlers.addToLib = {
		init: function(element) {
			$(element).click(function() {
				prompt("Name of model card: ", function(name) {
					if (name == '') return;
					
					var data = viewModels.sim.modelParams.getData();
					viewModels.lib.isLoading(true);
					
					$.ajax({
						url: ROOT + "/modelLibrary/ADD/",
						type: 'POST',
						data: { name: name, modelID: MODEL_ID, params: data },
						success: function(result) {
							if (result) {
								viewModels.lib.load();
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log("Error: " + textStatus + "; " + errorThrown);
						}, 
						complete: function() { viewModels.lib.isLoading(false); }
					}); 
				});
				
				return false;					
			});
		}
	};
	
	ko.bindingHandlers.showExamples = {
		init: function(element) {
			$.ajax({
				url: ROOT + "/getExampleFilenames/"+MODEL_ID,
				type: 'GET',
				success: function(data){
					try {
						data = JSON.parse(data);
					} catch(err) { alert("cannot parse");}
					if(data.length){
						//viewModels.sim.hasExampleBoxFileList(true);
						$(element).click(function() {
							exampleDialog(viewModels.sim.collection_info(),data);
						});
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
				}
			});
		}
	}
	
	// Load a parameter set
	ko.bindingHandlers.loadParams = {			
		update: function(element, valueAccessor) {
			var set = valueAccessor();
			if (!set()) return;
			
			confirm("Do you wish to load the parameter set \"" + set().name + "\" ?", function(load) {
				if (load) {
					$.ajax({
						url: ROOT + "/paramSet/GET/" + MODEL_ID + '/' + set().id,
						success: function(result) {
							viewModels.sim.loadParams(result);
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log("Error: " + textStatus + "; " + errorThrown);
						}, 
						complete: function() { viewModels.sim.isLoading(false); }
					}); 
				}
			});
		}
	};
	
	// Download parameters
	ko.bindingHandlers.downloadParams = {
		init: function(element) {
			$(element).click(function() {
				var data = viewModels.sim.modelParams.getData();
				$.submit({
					url: ROOT + "/clientParamSet/DOWNLOAD/" + MODEL_ID,
					type: 'POST',
					data: data,
					load: function(data) {
						if (!data.success) {
							console.log("Error: " + data.error);
						}
					}
				}); 
				return false;					
			});
		}
	};
	
	/*
	// Upload parameters
	ko.bindingHandlers.uploadParams = {
		init: function(element) {
			$(element).click(function() {
				if (!ko.bindingHandlers.uploadParams.input) {
					ko.bindingHandlers.uploadParams.input = $('<input type="file" name="file" />').appendTo("body").uniqueId().wrap("<form />");
				}
				var input = ko.bindingHandlers.uploadParams.input;
				input.parent().css("visibility", "hidden");
				
				input.change(function() {
					var that = $(this);
					confirm("Do you wish to upload the parameter set ?", function(load) {
						if (load) {
							viewModels.sim.isLoading(true);
							$.submit({
								control: that,
								url: ROOT + "/clientParamSet/UPLOAD",
								type: 'POST',
								form: input.parent(),
								load: function(data) {
									if (data.success) {	
										viewModels.sim.loadParams(data.data);
									} else {
										//console.log("Error: " + data.error);
									}
									viewModels.sim.isLoading(false);
									input.parent().remove();
								}
							}); 
						}
					});
				}).click();
				
				return false;				
			});
		}
	};
	*/
	
	// Upload parameters
	/*
	ko.bindingHandlers.uploadPlot = {
		init: function(element) {
			$(element).click(function() {
				if (!ko.bindingHandlers.uploadPlot.input) {
					ko.bindingHandlers.uploadPlot.input = $('<input type="file" name="file" />').appendTo("body").uniqueId().wrap("<form />");
				}
				var input = ko.bindingHandlers.uploadPlot.input;
				input.parent().css("visibility", "hidden");
				
				input.change(function() {
					viewModels.sim.isLoading(true);
					var that = $(this);
					$.submit({
						control: that,
						url: ROOT + "/clientPlotData/UPLOAD",
						type: 'POST',
						form: input.parent(),
						load: function(data) {
							if (data.success) {	
								viewModels.sim.selectedPlot().customData(data.data);
							} else {								
								console.log("Error: " + data.error);
							}
							viewModels.sim.isLoading(false);
							input.parent().remove();
						}
					}); 
				}).click();
				
				return false;				
			});
		}
	};
	*/
	
	ko.bindingHandlers.downloadPlot = {
		init: function(e) {
			$(e).click(function() {
				prompt("Filename:", function(e) {
					if(e == "") return;
					var data = viewModels.sim.selectedPlot().allData();
					$.submit({
							url: ROOT + "/clientPlotData/DOWNLOADAS",
							type: 'POST',
							data: {"data" : data, "saveas_name" : e}
					});
				}, {
					note: downloadAsNote
				});
			});
		}
	};
	
	// Display graphs
	ko.bindingHandlers.graph = {
		init: function(element, valueAccessor) {
			var data = ko.dataFor(element);
			$(element).graph(ko.toJS(data)).data("init", true);
		},
		update: function(element, valueAccessor) {	
			var selected = ko.utils.unwrapObservable(valueAccessor());
			if (ko.dataFor(element) == selected) {
				$(element).graph("replot");
			}
		}
	};
	
	// Replot graph button
	ko.bindingHandlers.replot = {
		update: function(element, valueAccessor) {	
			var graph = ko.dataFor(element);
			var show = valueAccessor();	
			if ($(element).data("init")) {
				$(element).graph("option", "customData", (show() ? graph.customData() : []));
			}
		}
	};

	// handler for setup the model library expandable item, must be used with observable
	ko.bindingHandlers.modelLibExpandable = {
		init: function(element, valueAccessor) {
			var expanded = valueAccessor();
			var $ele = $(element);

			if (!expanded()) {
				$ele.hide();
			}
			$ele.parent().on("click", ".tree-icon", function () {
				expanded(!expanded());
			});
		},
		update: function(element, valueAccessor) {
			var expanded = valueAccessor();
			if (!expanded()) {
				$(element).slideUp();
			} else {
				$(element).slideDown();
			}
		}
	};
	
	// Model library entry
	ko.bindingHandlers.modelLibEntry = {
		init: function(element, valueAccessor, allBindingsAccessor, entry, bindingContext) {	
			// Load model library entry
			var loadHandler;			
			if (entry.modelID == MODEL_ID) {
				loadHandler = function() {
					//confirm("Do you wish to load the model card \"" + entry.name + "\" ?", function(load) {
					confirm("The model parameters you are working on will be overwritten?", function(load) {
						if (load) {
							viewModels.sim.isLoading(true);
							$.ajax({
								url: ROOT + "/modelLibrary/GET/" + entry.id,
								success: function(result) {
									$("#model-tabs").tabs("option", "active", 1);
									$("#param-tabs").tabs("option", "active", 1);
									try {
										result = JSON.parse(result);
									} catch (err) {
									}
									viewModels.sim.loadParams(result);
								},
								error: function(jqXHR, textStatus, errorThrown) {
									console.log("Error: " + textStatus + "; " + errorThrown);
								}, 
								complete: function() { viewModels.sim.isLoading(false); }
							}); 					
						}
					});					
					return false;
				};
			} else {
				loadHandler = function() {	
					return false;
				};
			}
			$(element).find(".load").click(loadHandler);
			
			$(element).attr("model-name", entry.name);
			$(element).attr("model-id", entry.id);
			// Remove model library entry
			/*
			$(element).find(".delete").click(function() {
				confirm("Do you wish to delete the model card \"" + entry.name + "\" ?", function(load) {
						if (load) {
							viewModels.lib.isLoading(true);
							$.ajax({
								url: ROOT + "/modelLibrary/DELETE/" + entry.id,
								success: function(result) {
									if (result) {
										viewModels.lib.load();
									}
								},
								error: function(jqXHR, textStatus, errorThrown) {
									console.log("Error: " + textStatus + "; " + errorThrown);
								}, 
								complete: function() { viewModels.lib.isLoading(false); }
							});
						}
				});					
				return false;
			});
			*/
		}
	};
		
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
			
			/*
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
			*/
			
			// Upload
			/*
			$ele.find('.upload').click(function() {
				if (!ko.bindingHandlers.modelLibMenu.input) {
					ko.bindingHandlers.modelLibMenu.input = $('<input type="file" name="file" />').appendTo("body").uniqueId().wrap("<form />");
					ko.bindingHandlers.modelLibMenu.input.parent().css("visibility", "hidden");
				}
				var input = ko.bindingHandlers.modelLibMenu.input;
				
				var input = $("<input type='file' name='file' />")
				.appendTo('body')
				.change(function() {
					$.submit({
						input: input,
						url: ROOT + "/modelLibrary/UPLOAD",
						type: 'POST',
						form: input.parent(),
						load: function(data) {
							if (data.success) {	
								viewModels.lib.load();
							} else {								
								console.log("Error: " + data.error);
							}
							input.parent().remove();
						}
					});
				})
				.click();
				return false;				
			});
			*/
			
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
	
 } (jQuery));
 
