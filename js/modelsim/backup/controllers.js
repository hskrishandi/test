/**
 * @fileOverview Controller scripts
 */ 

 // Exports
 var ROOT = CI_ROOT + "modelsim";
 var MODEL_ID = 0;
 
 (function ($) {
	var viewModels;		// view model collection

	// Entry point
	$(document).ready(function() {
		MODEL_ID = $("#model-lib-list").data("current");

		viewModels = {
			lib: new ModelLibrary(),
			sim: new ModelSimulation()
		};

		viewModels.lib.load();
		viewModels.sim.init();

		ko.applyBindings(viewModels.lib, $(".model-library")[0]);
		ko.applyBindings(viewModels.sim, $("#model-page")[0]);
		
		$("#model-page").on('change', "#param-tab-model input", function() {			
			viewModels.sim.selectedSet(null);		// invalidated selection
			return false;
		});
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
				if(ko.utils.unwrapObservable(value)) {
					$i.addClass("icon-check").removeClass("icon-check-empty");
					$checkbox.attr('checked', true);
				} else {
					$i.removeClass("icon-check").addClass("icon-check-empty");
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
				prompt("Model library name: ", function(name) {
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
					confirm("Do you wish to upload the parameter set ?", function(load) {
						if (load) {
							viewModels.sim.isLoading(true);
							$.submit({
								url: ROOT + "/clientParamSet/UPLOAD",
								type: 'POST',
								form: input.parent(),
								load: function(data) {
									if (data.success) {	
										viewModels.sim.loadParams(data.data);
									} else {
										console.log("Error: " + data.error);
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
	
	// Download plot data
	ko.bindingHandlers.downloadPlot = {
		init: function(element) {
			$(element).click(function() {
				var data = viewModels.sim.selectedPlot().allData();
				$.submit({
					url: ROOT + "/clientPlotData/DOWNLOAD",
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
	
	// Upload parameters
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
					$.submit({
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
	
	// handler for loading parameter set
	ko.bindingHandlers.modelLibLoader = {
		init: function(element, valueAccessor) {
			var entry = valueAccessor();

			if (entry.modelID == MODEL_ID) {
				$(element).click(function() {
					confirm("Do you wish to load the library \"" + entry.name + "\" ?", function(load) {
						if (load) {
							viewModels.sim.isLoading(true);
							$.ajax({
								url: ROOT + "/modelLibrary/GET/" + entry.id,
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
					return false;
				});
			} else {
				$(element).click(function() {	
					return false;
				});
			}
		}
	};
	
	// handler for deleting parameter set
	ko.bindingHandlers.modelLibRemover = {
		init: function(element, valueAccessor) {
			var entry = valueAccessor();

			$(element).click(function() {
				confirm("Do you wish to delete the library \"" + entry.name + "\" ?", function(load) {
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
		}
	};
	
	// Download model library
	ko.bindingHandlers.downloadModelLib = {
		init: function(element) {
			$(element).click(function() {
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
		}
	};
	
	// Upload model library
	ko.bindingHandlers.uploadModelLib = {
		init: function(element) {
			$(element).click(function() {
				if (!ko.bindingHandlers.uploadModelLib.input) {
					ko.bindingHandlers.uploadModelLib.input = $('<input type="file" name="file" />').appendTo("body").uniqueId().wrap("<form />");
				}
				var input = ko.bindingHandlers.uploadModelLib.input;
				input.parent().css("visibility", "hidden");
				
				input.change(function() {
					$.submit({
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
				}).click();
				
				return false;				
			});
		}
	};
		
	// New model library
	ko.bindingHandlers.newModelLib = {
		init: function(element) {
			$(element).click(function() {
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
 