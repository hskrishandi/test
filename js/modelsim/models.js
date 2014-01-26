/**
 * @fileOverview View models
 */ 

// Exports
var ModelLibrary;
var ModelSimulation;

(function($) {

	/** Model library view model */
	ModelLibrary = function() {
		var self = this;

		self.tree = ko.observableArray([]);
		self.isLoading = ko.observable(false);

		self.load = function() {
			self.isLoading(true);
			$.ajax({
				url: ROOT + "/modelLibrary/GET",
				success: function(result) {
					try {
						result = JSON.parse(result);
					} catch (err) { }
					var mapped = $.map(result, function(item) { return new ModelLibrary.DeviceModel(item); });
					var i = mapped.length;
							
					self.tree(mapped);
					mapped = self.tree();
					while (--i >= 0) {
						if (mapped[i].id == MODEL_ID) {
							mapped[i].expanded(true);
							break;
						}
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
				}, 
				complete: function() {
					self.isLoading(false);
				}
			});
		};
	};
		
	ModelLibrary.DeviceModel = function(data) {
		var that = this;
		this.name = data.name;
		this.id = data.id;
			
		this.expanded = ko.observable(false);

		var mapped = $.map(data.library, function(item) { item.modelID = that.id; return item; });
		this.library = ko.observableArray(mapped);
	};
	
	ModelLibrary.LibraryEntry = function(data) {
		this.modelID = data.modelID;
		this.name = data.name;
		this.id = this.id;
	};

		
	/** Model simulation page view model */
	ModelSimulation = function() {
		var self = this;
		var paramMapper = function(observable) {			
			return function() {
				var arr = observable(), i = arr.length, ret = [];
				while (--i >= 0) {
					ret.push({ name: arr[i].name, value: arr[i].value()});
				}
				return ret;
			};
		};
		//var simuData = { running: false, session: "", exectime: 0 };
		self.isSimulating = ko.observable(false);
		self.simulationTime = ko.observable(0);
		self.simulationId = ko.observable(null);
		self.isSimulatingAlert = ko.observable(false);
		
		self.isLoading = ko.observable(false);
		self.selectedTab = ko.observable(0).extend({localPersist: { key: 'M#' + MODEL_ID + 'TABINDEX' } });
		self.selectedParamTab = ko.observable(0).extend({localPersist: { key: 'MP#' + MODEL_ID + 'TABINDEX' } });
		
		self.instanceParams = ko.observableArray([]);
		self.instanceParams.getData = paramMapper(self.instanceParams);
	
		self.modelParams = ko.observableArray([]);
		self.modelParams.getData = paramMapper(self.modelParams);
 
		self.hasExampleBoxFileList = ko.observable(false);
		
 		self.paramSelect = function(keyword, focus) {
			if (focus == null) focus = true;
			var target = $("#" + keyword);
			if (target == null) return;
			
			
			var index = $("#param-tabs div[role='tabpanel']").index($("#" + $(target).attr("parent")));
			$('#param-tabs').tabs({ active: index });
			if (focus) target.focus();
		};
		
 		self.searchParamsSelect = function(keyword) {
			var target = $("#" + keyword);
			// Text field value
			$( "#search_param" ).val(keyword).stop().css("backgroundColor", "#9f9").animate({backgroundColor: "none"}, 1000);
			self.paramSelect(keyword);
			target.stop().css("backgroundColor", "#9f9").animate({backgroundColor: "none"}, 1000);				
		};
 		self.searchParams = ko.observableArray([]);
		self.searchParamsInit = function() {
			if (self.searchParams().length == 0) {
				$("input.param_inputs").each(function() {
					self.searchParams.push({value: this.id, desc: $(this).attr("desc")});
				});
				$("select.param_inputs").each(function() {
					self.searchParams.push({value: this.id, desc: $(this).attr("desc")});
				});
		
				
				
				$("#search_param").autocomplete({
					source: viewModels.sim.searchParams(),
					select: function( event, ui ) {
						self.searchParamsSelect(ui.item.value);
						return false;
					}
				}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
						var keyword = $("#search_param").val().toLowerCase();
						var pos = item.value.toLowerCase().indexOf(keyword);
						keyword = item.value.substr(pos, keyword.length);
						
						return $( "<li>" )
						.append( "<a><b>" + item.value.replace(new RegExp($("#search_param").val(),"i"),"<font color='#F00'>"+keyword+"</font>") + "</b><br>" + "<font class='desc'>" + item.desc + "</font>" + "</a>" )
						.appendTo( ul );
				};		
				
				// When user press "Enter" for searching (Not recommended)
				$("#search_param_form").submit(function() {
					var keyword = $("#search_param").val(),
						searchable = false;
					$(viewModels.sim.searchParams()).each(function(){
						if (this.value.toLowerCase() == keyword.toLowerCase()) {
							self.searchParamsSelect(this.value);
							searchable = true;
							return false;
						}
					});
					
					// Fail search
					if (!searchable)
						$("#search_param").stop().css("backgroundColor", "#f88").animate({backgroundColor: "none"}, 1000);
					
					// No form submission
					return false;
				});
				
			}
		};
		
		
		//array of parameter array for all tabs.
		self.modelParamsForTabs = ko.observableArray([]);
	
		//this parameter is to manually set the type in netlist of model 9.
		if(MODEL_ID == 9){
			self.currentType = ko.computed(function(){
				if(self.modelParams()[2] && self.modelParams()[2].name == 'type'){
					return self.modelParams()[2].value() == 1 ? 'nmos' : 'pmos';
				}
				else
					return null;
			});
		}
		else{
			self.currentType = ko.computed(function(){
				return null;});
		}
 
		self.paramSet = ko.observableArray([]);
		self.selectedSet = ko.observable(null);

		self.biases = ko.observableArray([]);
		
		self.variablebias = ko.observableArray([]).extend({required: true});
		
		self.fixedbias = ko.observableArray([]);
		
		self.outputs = ko.observableArray([]);
		self.selectedOutputs = ko.computed(function() {
			var all = self.outputs(), selected = [];
			for (var i = 0; i < all.length; ++i) {
				if (all[i].linearPlot() || all[i].logPlot()) {
					selected.push(ko.toJS(all[i]));
				}
			}
			return selected;
		}).extend({ required: true });
			
		self.session = ko.observable(null);
		self.plotData = ko.observableArray([]);
		self.selectedPlot = ko.observable(null);
		
		// Validation group for all data
		self.validation = ko.validatedObservable(self);
		
		self.getData = function() {			
			return ko.toJS({
				modelID: MODEL_ID,
				biases: {
					variable: self.variablebias,
					fixed: self.fixedbias
				},
				params: {
					instance: self.instanceParams.getData(),
					model: self.modelParams.getData(),
					type: self.currentType()
				}
			});
		};
		
		self.errorParam = function(id) {
			$("#" + id).stop().css("backgroundColor", "#f88")
			.click(function() {
				$(this).animate({backgroundColor: "none"}, 1000);
			}).focus(function() {
				$(this).animate({backgroundColor: "none"}, 1000);
			})
		};
		
		self.paramSelectList = function(list, id) {
			var code = "<select id='" + id + "'>\n";
			code += "<option></option>";
			$(list).each(function() {
				code += "<option value='" + this + "'>" + this + "</option>\n";
			});
			code += "</select>\n";

			return code;
		}
		
		self.loadParams = function(data) {
			var mp = self.modelParams();
			var ip = self.instanceParams();
			var return_data = {error: 0, missing: [], extra: []};

			// Clear style
			$(".param_inputs").each(function() {
				$(this).animate({backgroundColor: "none"}, 200);
			});
			
			// Loop all model params (param matching & finding missing params)
			$(mp).each(function() {
				var param = this,
					assigned = false;
				$(data).each(function() {
					if (this.name.toLowerCase() == param.name.toLowerCase()) {
						param.value(this.value);
						assigned = true;
					}
				});
				
				if (!assigned) {
					return_data.error++;
					return_data.missing.push(param.name);	
					self.errorParam(param.name);
				}
			});
			
			// Finding extra params
			$(data).each(function() {
				var data_param = this,
					matched = false;
					
				$(mp).each(function() {
					if (this.name.toLowerCase() == data_param.name.toLowerCase()) {
						matched = true;
					}
				});
				
				if (!matched) {
					return_data.error++;
					return_data.extra.push(data_param.name);	
				}
			});
			
			return return_data;
			/* var assigned = false;
			for (var i = 0; i < data.length; ++i) {
				assigned = false;
				for (var j = 0; j < mp.length; ++j) {
					if (data[i].name.toLowerCase() == mp[j].name.toLowerCase()) {
						mp[j].value(data[i].value);
						assigned = true;						
						break;
					}
				}
				
				for (var j = 0; !assigned && j < ip.length; ++j) {
					if (data[i].name.toLowerCase() == ip[j].name.toLowerCase()) {
						ip[j].value(data[i].value);					
						break;
					}
				}
			}
			*/
		};
		
		self.addVariable = function() {
			if (self.variablebias().length < 2) {
				self.variablebias.push(ko.mapping.fromJS({name: '', init: 0, end: 1, step: 0.1}));
			}
		};
		self.addVariable();
		
		self.removeVariable = function(bias) {
			self.variablebias.remove(bias);
		};
		
		self.stepValueOnChange = function(data, e) {
			var that = $(e.target);
			var warning = function(msg) {
				alert(msg, null, {
					close: function() {
						self.selectedTab(2);
					}
				});
				that.val(that.attr("OldVal"));
				that.removeAttr("OldVal");
			};
			if(that.val() == 0)
				warning("The step value should be non-zero.");
			else if(Math.abs(that.val()) < 0.00001)
				warning("The step value should not be smaller than 0.00001.");
		};
		
		self.stepValueOnFocus = function(data, e) {
			var that = $(e.target);
			that.attr("OldVal", that.val());
		};
				
		self.addFixed = function() {
			if (self.fixedbias().length + self.variablebias().length < self.biases().length) {
				self.fixedbias.push(ko.mapping.fromJS({name: '', value: 0}));
			}
		};
		
		self.removeFixed = function(bias) {
			self.fixedbias.remove(bias);
		};
		
		self.simulate = function() {
			if (!self.validation.isValid()) {
				// TODO: display error
				return;
			}
		
			var data = self.getData();
			self.isLoading(true);
			$.ajax({
				url: ROOT + "/simulate",
				type: 'POST',
				data: data,
				success: function(result) {
					try {
						result = JSON.parse(result);
					} catch(err) { }
					self.simulationId(result.id);
					self.simulationTime(0);
					self.isSimulating(true);
					self.isSimulatingAlert(false);
					self.checkSimulationStatus(2, data);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
					console.log("Response data: " + jqXHR.responseText);
				}
			}); 
		};
		
		
		self.checkSimulationStatus = function(interval, data) {
			$.ajax({
				url: ROOT + "/simulationStatus",
				type: "POST",
				data: { session: self.simulationId() },
				success: function(result) {
					try {
						result = JSON.parse(result);
					} catch(err) { }
					console.log(result);
					if(result.status == "FINISHED") {
						self.isLoading(false);
						data.token = self.simulationId();
						data.outputs = self.selectedOutputs();
						self.session(data);
						self.loadPlotData();
						alert("Simulation finished. Waiting for plotting.",null,null);
					}
					else if(result.status == "RUNNING") {
						self.simulationTime(self.simulationTime() + 2);
						if(!self.isSimulatingAlert() && self.simulationTime() >= 20) {
							self.isLoading(false);
							alert("The simulation has taken 20 seconds. If you want to terminate it, please click \"abort\", or go to other pages.", null, {
								close: function() {
									if(self.isSimulating())
										self.isLoading(true);
								}
							});
							self.isSimulatingAlert(true);
						}
						setTimeout(function() {
							self.checkSimulationStatus(interval, data);
						}, 2000);
					}
					else if(result.status == "KILL") {
						self.isSimulating(false);
						self.isLoading(false);
						alert("The simulation has been stopped.");
					}
					if(result.status != "RUNNING") {
						self.isSimulating(false);
						if(result.status != "KILL")
							$("#alert").dialog('close');
					}
				}
			});
		};
		
		self.stopSimulationByClick = function(data, e) {
			$(e.target).css("display", "none");
			self.stopSimulation();
		};
		
		self.stopSimulation = function() {
			$.ajax({
				url: ROOT + "/simulationStop",
				type: "POST",
				data: { session: self.simulationId }
			});
		};
		
		self.loadPlotData = function() {
			var session = self.session();
			if (session == null) return;

			var outputs = session.outputs;
			var tasks = outputs.length;
			var xvar = session.biases.variable[0].name;
			self.plotData([]);
			self.isLoading(true);
			for (var i = 0; i < tasks; ++i) {				
				(function (output) {
					$.ajax({
						url: ROOT + "/getData/" + session.token.replace(/\"/g, "") + '/' + output.column_id,
						success: function(result) {
							try {
								result = JSON.parse(result);
							} catch(err) { }
							if (output.linearPlot) {
								self.plotData.push(new GraphModel({ 
									x: { name: xvar, unit: 'V' },
									y: { name: output.name, unit: output.unit },
									data: result
								}));
							}
							if (output.logPlot) {
								self.plotData.push(new GraphModel({ 
									x: { name: xvar, unit: 'V' },
									y: { name: output.name, unit: output.unit, log: true },
									data: result
								}));
							}
						},
						error: function(jqXHR, textStatus, errorThrown) {
							console.log("Error: " + textStatus + "; " + errorThrown);
							console.log("Response data: " + jqXHR.responseText);
						}, 
						complete: function() { 
							if (--tasks <= 0) {
								self.isLoading(false); 
							}
						}
					}); 
				}(outputs[i]));
			}
		};
		
		self.downloadPlotData = function() {
			prompt("Filename: ", function(filename) {
				if(filename) {
					var png = jqplotToImg("imos-graph-" + self.selectedPlot().id);
					if(png == "")	//FOR IE8 or lower version
						return;
					var form = $("form[name=uploadform]").attr('action',CI_ROOT + "/txtsim/savePNG");
					var input = $("<input />").attr('name', 'png').val(png).appendTo(form);
					var nameinput = $("<input />").attr("name", "filename").val(filename).appendTo(form);
					form.submit();
					input.remove();
					nameinput.remove();
				}
			}, {
				note: downloadAsNote,
				open: function() {
					$(this).parent().css("postion", "fixed").css("z-index", "1021", "important");
				}
			});
		};

		self.init = function() {
			var tasks = 2;
			var completeTask = function() {
				if (--tasks <= 0) {
					self.isLoading(false);
				}
			};			
			self.isLoading(true);
			$.ajax({
				url: ROOT + "/paramSet/GET/" + MODEL_ID,
				type: 'GET',
				success: function(result) {
					self.paramSet(result);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
				}, 
				complete: completeTask
			});
			$.ajax({
				url: ROOT + "/modelDetails/" + MODEL_ID,
				type: 'GET',
				success: function(result) { 
					try {
						result = JSON.parse(result);
					} catch(err) { alert(k);}
					
					self.instanceParams($.map(result.params.instance, function(item) { return new ModelSimulation.Parameter(item); }));
					self.modelParams($.map(result.params.model, function(item) { return new ModelSimulation.Parameter(item); }));

					self.modelParamsForTabs.push({
																				 modelParams: self.instanceParams,
																				 href: "#param-tab-model0",
																				 id: "param-tab-model0",
																				 title: result.paramsTabTitle[1]
																				 });
					for(var i = 0; i < self.modelParams().length; ++i){
						var tab_id = self.modelParams()[i].tab_id;
						if(tab_id == 0)
						 tab_id = 1;
						if(!self.modelParamsForTabs()[tab_id]){
								self.modelParamsForTabs.push({
										modelParams: ko.observableArray([]),
										href: "#param-tab-model"+tab_id.toString(),
										id: "param-tab-model"+tab_id.toString(),
										title: result.paramsTabTitle[self.modelParams()[i].tab_id]
								});
						}
						self.modelParamsForTabs()[tab_id].modelParams.push(self.modelParams()[i]);
					}
					$("div#param-tabs").tabs("refresh");//.sliderTabs();
					$("div#param-tabs").tabs( "option", "active", self.selectedParamTab());
					if(result.paramsTabTitle.length > 5){
						 $("div#param-tabs").tabs().scrollabletab();
				  }
					self.outputs($.map(result.outputs, function(item) { return new ModelSimulation.OutputVariable(item); }));
					self.biases(result.biases);
					self.variablebias.extend({localPersist: {
						key: 'M#' + MODEL_ID + 'VARBIAS',
						deserialize: ko.mapping.fromJSON
					}});	
					
					self.fixedbias.extend({localPersist: { 
						key: 'M#' + MODEL_ID + 'FIXBIAS',
						deserialize: ko.mapping.fromJSON
					}});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
				}, 
				complete: completeTask
			}); 
					
		};
	};
			
	ModelSimulation.OutputVariable = function(data) {
		this.name = data.name;
		this.unit = data.unit;		
		this.column_id = data.column_id;
		
		this.linearPlot = ko.observable(false).extend({localPersist: { key: 'M#' + MODEL_ID + 'O#' + data.name + 'LIN' } });
		this.logPlot = ko.observable(false).extend({localPersist: { key:  'M#' + MODEL_ID + 'O#' + data.name + 'LOG' } });		
	};
		
	ModelSimulation.Parameter = function(data) {
		var that = this;
		
		this.tab_id = data.instance;
		this.name = data.name;
		this.unit = data.unit;
		this.description = data.description;
		this.label = this.name + (this.unit ? ' [' + this.unit + ']' : '');
		this["default"] = data["default"];
		try{
		var valueArr = JSON.parse(data["default"]);
		}catch(e){
			//do nothing, just prevent the exception terminate the script.
		}
		this.valueArr = undefined;
		if(valueArr instanceof Array && valueArr.length > 0)
		{
			this.valueArr = valueArr;
			this.value = ko.observable(valueArr[0]).extend({localPersist: { key: 'M#' + MODEL_ID + 'P#' + data.name } });
		}
		else{
			this.value = ko.observable(this["default"]).extend({localPersist: { key: 'M#' + MODEL_ID + 'P#' + data.name } });
		}		//this.value = ko.observable(this["default"]);
	};
} (jQuery));
