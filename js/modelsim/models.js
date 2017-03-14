/**
 * @fileOverview View models
 */

// Exports
var ModelLibrary;
var ModelSimulation;
var temp_store_for_user_data;

(function($) {

	/** Model library view model */
	ModelLibrary = function() {
		var self = this;

		// Enablie blinding
		self.tree = ko.observableArray([]);
		self.isLoading = ko.observable(false);  //blind isLoading with init value of false

		// Load the data of User Libraries by ajax
		self.load = function() {
			self.isLoading(true);
			//ajax request
			$.ajax({
				url: ROOT + "/modelLibrary/GET",
				success: function(result) {
					//1. try parse json string to array
					try {
						result = JSON.parse(result);
					} catch (err) { }
					//2. ORM of DeviceModel
					var mapped = $.map(result, function(item) { return new ModelLibrary.DeviceModel(item); });
					var i = mapped.length;

					//3. blinding
					self.tree(mapped);
					mapped = self.tree();
					//4. exprend the library tree if the User Library == current model
					while (--i >= 0) {
						if (mapped[i].id == MODEL_ID) {  //controlers.js::MODEL_ID
							mapped[i].expanded(true);
							break;
						}
					}
				},
				// On error, console log error
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
				},
				// Finally, set loading to false
				complete: function() {
					self.isLoading(false);
				}
			});
		};
	};

	// POCO class of a DeviceModel (include Library objects)
	ModelLibrary.DeviceModel = function(data) {
		var that = this;
		this.name = data.name;
		this.id = data.id;

		this.expanded = ko.observable(false);

		var mapped = $.map(data.library, function(item) { item.modelID = that.id; return item; });  //ORM of librarys of a DeviceModel
		this.library = ko.observableArray(mapped);
	};

	// POCO class of a Library
	ModelLibrary.LibraryEntry = function(data) {
		this.modelID = data.modelID;
		this.name = data.name;
		this.id = this.id;
	};


	/** Model simulation page view model */
	ModelSimulation = function() {
		var self = this;
		// get the useful value only from the Parameters
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
		//for showing the Abort button
		self.isSimulating = ko.observable(false);
		self.simulationTime = ko.observable(0);
		self.simulationId = ko.observable(null);
		self.isSimulatingAlert = ko.observable(false);
		//for showing the Fixed bias table when pressing the Add fixed bias button in the Biasing tab
		self.b_hasFixed = ko.observable(false);

		//for custom binding function (loadingWhen) in the controller js
		self.isLoading = ko.observable(false);
		//saving the selected tab
		self.selectedTab = ko.observable(0).extend({localPersist: { key: 'M#' + MODEL_ID + 'TABINDEX' } });
		//saving the tab (Instance/Model) selected in the Parameters tab
		self.selectedParamTab = ko.observable(0).extend({localPersist: { key: 'MP#' + MODEL_ID + 'TABINDEX' } });
		//the Mode Choice (General Biasing/Benchmarking) of Biasing tab
		self.selectedBenchmarkingTab = ko.observable(0).extend({localPersist: {key: 'MB#' + MODEL_ID + 'TABINDEX'}});
		//params in Instance/Model tab of Parameters tab
		self.instanceParams = ko.observableArray([]);
		//get useful information only from instanceParams and save in variable (getData)
		self.instanceParams.getData = paramMapper(self.instanceParams);

		self.modelParams = ko.observableArray([]);
		self.modelParams.getData = paramMapper(self.modelParams);

		//This parameter is for remebering the index of 'type' parameter, initial value is -1, wait to be set until the data arrives from modelDetail's ajax
		self.typeIndex = ko.observable(-1);

		//for showing the Collection button next to the Load button in Parameters tab
		self.hasExampleBoxFileList = ko.observable(false);
		self.collection_info = ko.observable("");
		self.model_id = ko.observable(MODEL_ID);

		/* Search Parameter */
		// focus the target (a input field) and jump to the tab where the target is, mainly for searching
 		self.paramSelect = function(keyword, focus) {
			if (focus == null) focus = true;
			var target = $("#" + keyword);
			if (target == null) return;

			//jump to the tab where the focusing target is
			var index = $("#param-tabs div[role='tabpanel']").index($("#" + $(target).attr("parent")));
			$('#param-tabs').tabs({ active: index });
			if (focus) target.focus();  //jquery focus function
		};
		//jump to the parameter by the search result and show animation
 		self.searchParamsSelect = function(keyword) {
			var target = $("#" + keyword);
			// Text field value
			$( "#search_param" ).val(keyword).stop().css("backgroundColor", "#9f9").animate({backgroundColor: "none"}, 1000);
			self.paramSelect(keyword);
			target.stop().css("backgroundColor", "#9f9").animate({backgroundColor: "none"}, 1000);
		};
 		self.searchParams = ko.observableArray([]);  //the search result
 		// jquery autocomplete function for searhing parameters
		self.searchParamsInit = function() {
	 		// alert(self.searchParams().length == 0? "true":"false");
	 		self.searchParams().length = 0;
			if (self.searchParams().length == 0) {
				$("input.param_inputs").each(function() {
					self.searchParams.push({value: this.id, desc: $(this).attr("desc"), param_value: $(this).val()});
				});
				$("select.param_inputs").each(function() {
					self.searchParams.push({value: this.id, desc: $(this).attr("desc")});
				});

				// This is for search function
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


				// This is for add param to the equalizar
				$("#add_param").autocomplete({
					source: viewModels.sim.searchParams(),
					select: function( event, ui ) {
						var addable = true;
						$(".eq-name").each(function(){
							// alert($(this).text());
							if($(this).text() == ui.item.value){
								alert("You have already add the parameter!");
								addable = false;
							}
						})
						if(isNaN(ui.item.param_value)){
							alert("The parameter is not a number!");
							addable = false;
						}
						if(addable){
							add_eq_param(ui.item.value, ui.item.param_value);
						}
						$("#add_param").val("");
						return false;
					}
				}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
						var keyword = $("#add_param").val().toLowerCase();
						var pos = item.value.toLowerCase().indexOf(keyword);
						keyword = item.value.substr(pos, keyword.length);

						return $( "<li>" )
						.append( "<a><b>" + item.value.replace(new RegExp($("#add_param").val(),"i"),"<font color='#F00'>"+keyword+"</font>") + "</b><br>" + "<font class='desc'>" + item.desc + "</font>" + "</a>" )
						.appendTo( ul );
					};

				// When user press "Enter" for adding (Not recommended)
				$("#add_param_form").submit(function() {
					var keyword = $("#add_param").val(),
						searchable = false;
					$(viewModels.sim.searchParams()).each(function(){
						if (this.value.toLowerCase() == keyword.toLowerCase()) {
							// self.searchParamsSelect(this.value);
							searchable = true;
							return false;
						}
					});

					// // Fail search
					if (!searchable){
						$("#add_param").stop().css("backgroundColor", "#f88").animate({backgroundColor: "none"}, 1000);
						$("#add_param").val("");
					}

					// // No form submission
					return false;
				});
			}
		};
		/* ; Search Parameter */

		/* Equalizer */
		var eq_toggle = true;

		// Expand the equalizer by chicking the + icon
		$("#eq-icon-expand").click(function(){
			$('#results').animate({scrollTop: $("#equalizer-temp").offset().top}, 1500);
			if(eq_toggle){
				$("#eq-panel").slideToggle("slow");
				$("#equalizer-temp").css("height", "420px");
				eq_toggle = false;
			}
		})

		// Collapse the equalizer by chicking the - icon
		$("#eq-icon-close").click(function(){
			if(!eq_toggle){
				$("#eq-panel").slideToggle("slow");
				$("#equalizer-temp").css("height", "");
				eq_toggle = true;
			}
		})

		// Show of hide the equalizer by chicking the Equalizer link
		$("#eq-expand").click(function(){
			if(eq_toggle){
				$('#results').animate({scrollTop: $("#equalizer-temp").offset().top}, 1500);
				$("#eq-panel").slideToggle("slow");
				$("#equalizer-temp").css("height", "420px");
				$("#equalizer-temp").css("visibility", "visible");
				eq_toggle = false;
			} else {
				$("#eq-panel").slideToggle("slow");
				$("#equalizer-temp").css("height", "");
				$("#equalizer-temp").css("visibility", "hidden");
				eq_toggle = true;
			}
			return false;
		})

		$("#eq-run").click(function(){
			$('#results').animate({scrollTop: $("#result-container").offset().top}, 1500);
			return false;
		})

		$("#eq-deleteall").click(function(){
			$(".eq-slider").remove();
			eq_num = 0;
			eq_cnt = 0;
			$(".eq-changeable").css("visibility", "hidden");
		})

		var eq_num = 0;
		var eq_cnt = 0;
		function add_eq_param(param_name, param_value){
			var eq_exp = 1;
			eq_num++; eq_cnt++;
			if(eq_cnt > 8){
				alert("You have reach the max number of parameters!");
				eq_cnt = 8;eq_num--;
				return;
			}
			if (eq_cnt){
				$(".eq-changeable").css("visibility", "visible");
			}
			var $new_slider = $("<div class='eq-slider' id='eq-slider" + eq_num + "' ><b id='name" + eq_num + "' class='eq-name'><span>" + param_name + "</span></b><br>");
			$new_slider.appendTo("#equalizer");
			var $new_val = $("<input class='eq-val' id='eq-slider" + eq_num + "-val' /><br>");
			var $new_max = $("<input class='eq-max' id='eq-slider" + eq_num + "-max' /><br>");
			var $new_range = $("<div class='eq-range' id='eq-slider" + eq_num + "-range' /><br>");
			var $new_min = $("<input class='eq-min' id='eq-slider" + eq_num + "-min' /><br>");
			var $new_trash = $("<a href='#' class='delete_button eq-trash icon-trash' ></a>");
			$new_max.appendTo("#eq-slider" + eq_num);
			$new_min.appendTo("#eq-slider" + eq_num);
			$new_val.appendTo("#eq-slider" + eq_num);
			$new_range.appendTo("#eq-slider" + eq_num);
			$new_trash.appendTo("#eq-slider" + eq_num);

			if(param_value == 0){

			}
			else if(param_value < 10){
				var tmp = 10/param_value;
				tmp = Math.ceil(Math.log(tmp)/Math.log(10)) + 3;
				eq_exp = Math.pow(10,tmp);
			}
			$new_range.slider({
			range: "min",
			min: (param_value>0) ? param_value * eq_exp * 0.5 : param_value * eq_exp * 1.5,
			max: (param_value>0) ? param_value * eq_exp * 1.5 : param_value * eq_exp * 0.5,
			value: param_value * eq_exp,
			orientation: "vertical",
			slide: function (event, ui) {
				var slider_val = ("#" + $(this).attr("id").slice(0,-5) + "val");
				$(slider_val).val((ui.value / eq_exp).toExponential(3));
				$("#" + param_name).val(ui.value / eq_exp);
				$("#" + param_name).change();
			}
			});

			// Click trash button and delete the column
			$new_trash.click(function(){
				var slider_curr = $(this).parent().attr("id");
				$("#" + slider_curr).remove();
				eq_cnt--;
				if (eq_cnt == 0 ){
					$(".eq-changeable").css("visibility", "hidden");
				}
			});

			// Initial value for max, min, val
			var slider_selector = ("#eq-slider" + eq_num);
			$(slider_selector + "-max").val(($(slider_selector + "-range").slider("option", "max") / eq_exp).toExponential(3));
			$(slider_selector + "-min").val(($(slider_selector + "-range").slider("option", "min") / eq_exp).toExponential(3));
			$(slider_selector + "-val").val(($(slider_selector + "-range").slider("option", "value") / eq_exp).toExponential(3));

			// When textbox is changed, update the slider
			var curr_min = $(slider_selector + "-min").val() * eq_exp;
			var curr_max = $(slider_selector + "-max").val() * eq_exp;
			var curr_val = $(slider_selector + "-min").val() * eq_exp;
			$(slider_selector + "-max").change(function() {
				if((parseFloat($(this).val(),10) * eq_exp) < curr_min){
					alert("The number you typed is smaller than min value, please re-enter.");
					$(slider_selector + "-max").val(($(slider_selector + "-range").slider("option", "max") / eq_exp).toExponential(3));
					return;
				}
				$(slider_selector + "-range").slider("option", "max", parseFloat($(this).val(),10) * eq_exp);
				$(slider_selector + "-max").val(parseFloat($(this).val()).toExponential(3));
			})
			$(slider_selector + "-min").change(function() {
				if((parseFloat($(this).val(),10) * eq_exp) > curr_max){
					alert("The number you typed is larger than max value, please re-enter.");
					$(slider_selector + "-min").val(($(slider_selector + "-range").slider("option", "min") / eq_exp).toExponential(3));
					return;
				}
				$(slider_selector + "-range").slider("option", "min", parseFloat($(this).val(),10) * eq_exp);
				$(slider_selector + "-min").val(parseFloat($(this).val()).toExponential(3));
			})
			$(slider_selector + "-val").change(function() {
				if((parseFloat($(this).val(),10) * eq_exp) > curr_max
				|| (parseFloat($(this).val(),10) * eq_exp) < curr_min){
					alert("The number you typed is out of range, please re-enter.");
					$(slider_selector + "-val").val(($(slider_selector + "-range").slider("option", "value") / eq_exp).toExponential(3));
					return;
				}
				$(slider_selector + "-range").slider("option", "value", parseFloat($(this).val(),10) * eq_exp);
				$(slider_selector + "-val").val(parseFloat($(this).val()).toExponential(3));
				$("#" + param_name).val(parseFloat($(this).val(),10));
				$("#" + param_name).change();
			})
		};
		/* : Equalizer */


		//array of parameter array for all tabs.
		self.modelParamsForTabs = ko.observableArray([]);

		//this parameter is to manually set the type in netlist of model 9.
		if(MODEL_ID == 9 || MODEL_ID == 10 || MODEL_ID == 11){
			self.currentType = ko.computed(function(){
					return self.typeIndex()==-1? null: (!self.modelParams()[self.typeIndex()]? null : (self.modelParams()[self.typeIndex()].value() == 1 ? 'nmos' : 'pmos'));
			});
		}
		else{
			self.currentType = ko.computed(function(){
				return null;});
		}

		self.paramSet = ko.observableArray([]);
		self.selectedSet = ko.observable(null);

		self.biases = ko.observableArray([]);
		self.choice = ko.observableArray([{id:0,name:'General Biasing',expanded:ko.observable(false),b_name:ko.observableArray([])},{id:1,name:'Benchmarking',expanded:ko.observable(false),b_name:ko.observableArray([])}]);
		self.b_variableBias = ko.observableArray([{name:'',init:-0.5,end:0.5,step:0.01}]);
		self.b_fixedBias = ko.observableArray([{name:'',value:0}]);
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
		self.benchmarking = ko.observableArray([]);
		self.originalOutputs = [];

		self.availableMode = ko.observableArray([
		{name:'General Biasing',key:'0'},
		{name:'Benchmarking',key:'1'}

		]);
		self.img_src = [
			"images/simulation/benchmark1.jpg",
			"images/simulation/benchmark2.jpg",
			"images/simulation/benchmark3.jpg",
			"images/simulation/benchmark4.jpg"
		];
		self.selectedMode = ko.observable();

		//when different benchmarks are selected, output variables are changed
		self.changeBenchmark = function(data) {
			self.b_variableBias()[0].name = self.benchmarking()[data].user_input().vb_name();
			self.b_variableBias()[0].init = self.benchmarking()[data].user_input().init();
			self.b_variableBias()[0].end = self.benchmarking()[data].user_input().end();
			self.b_variableBias()[0].step = self.benchmarking()[data].user_input().step();
			if(self.benchmarking()[data].user_input().fb_name()!=null){
				self.b_fixedBias()[0].name = self.benchmarking()[data].user_input().fb_name();
			}
			self.b_fixedBias()[0].value=self.benchmarking()[data].user_input().value();
			if(self.benchmarking().length > 0 ){
				self.outputs.removeAll();
				self.outputs($.map(self.benchmarking()[data].filter, function(item) { return new ModelSimulation.OutputVariable(item); }));
			}
			self.checkFixed(self.benchmarking()[data].user_input().fb_name());
		};

		self.changeSelectedMode = function (data) {
			self.selectedMode().key = data;
			self.changeMode();
		}

		//selection between "general bias" and "benchmark"
		self.changeMode = function() {
			var gb = document.getElementById("general_biasing");
			var ben = document.getElementById("benchmarking");
			if(self.selectedMode().key == "0"){
				gb.style.display = 'block';
				ben.style.display = 'none';
			}else{
				gb.style.display = 'none';
				ben.style.display = 'block';
			}

			if(self.selectedMode().key =="0"){
				self.outputs($.map(self.originalOutputs, function(item) { return new ModelSimulation.OutputVariable(item); }));
			}else{
				self.outputs($.map(self.benchmarking()[self.selectedBenchmarkingTab()].filter, function(item) { return new ModelSimulation.OutputVariable(item); }));
			}
		};

		self.getData_fromBenchmarking = function() {
				return ko.toJS({
					modelID: MODEL_ID,
					biases: {
						variable: self.b_variableBias,
						fixed: self.b_fixedBias
					},
					params: {
						instance: self.instanceParams.getData(),
						model: self.modelParams.getData(),
						type: self.currentType()
					},
					biasingMode: "Benchmarking",
					benchmarkingId: self.benchmarking()[self.selectedBenchmarkingTab()].benchmarkingID
				});
		};

		self.sideMenuCtrl = function(data) {
			self.selectedBenchmarkingTab(data);
			self.changeBenchmark(data);
			self.selectedMode().key = 1;
			self.changeMode();
		}

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
				},
				biasingMode: "General Biasing"
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

		self.checkFixed = function(fixed){
			if(fixed==null){
				self.b_hasFixed(false);
			}else{
				self.b_hasFixed(true);
			}
		}

		self.simulate = function() {
			if (!self.validation.isValid()) {

				$("#eq-dialog")
				.dialog({
					autoOpen: false,
					title: "No Output Selected!",
					width: 400,
					buttons: {
						"Choose output": function(){
							$('#model-tabs').tabs({
								active: 3
							});
							$(this).dialog("close");
						},
						"Cancel": function(){
							$(this).dialog("close");
						}
					}
				})
				.dialog("open");
				return;
			}

			var data;


			if(self.selectedMode().key =="0"){
				data = self.getData();
			}else{
				data = self.getData_fromBenchmarking();
			}

			self.isLoading(true);

			// Notes: All the ajax must be synchronized, including every parts like 'checkSimulationStatus' and its containing ajax part.
            console.log(data);
			$.ajax({
				url: ROOT + "/simulate",
				type: 'POST',
				data: data,
				success: function(result) {
					try {
						result = JSON.parse(result);
					} catch(err) { }
                    console.log(result);
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
						simulation_upload();
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
						if(result.status != "KILL"){
							$("#alert").dialog('close');
						}
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
					var form = $("form[name=uploadform]").attr('action',CI_ROOT + "txtsim/savePNG");
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
					self.hasExampleBoxFileList(result.hasCollection=='1'?true:false);
					self.collection_info(result.collection_info);
					self.instanceParams($.map(result.params.instance, function(item) { return new ModelSimulation.Parameter(item); }));
					self.modelParams($.map(result.params.model, function(item,key) {
						if(item.name.toLowerCase()== 'type')
							self.typeIndex(key);
					  return new ModelSimulation.Parameter(item); }));

					self.modelParamsForTabs.push({
												modelParams: self.instanceParams,
												href: "#param-tab-model0",
												id: "param-tab-model0",
												title: result.paramsTabTitle[1]
												});
					var hasZeroTabId = false;
					for(var i = 0; i < self.modelParams().length; ++i){
						var tab_id = self.modelParams()[i].tab_id;
						var currentIndex = hasZeroTabId?tab_id:tab_id-1;
						if(tab_id == 0)
						{
							tab_id = 1;
							currentIndex = 1;
							hasZeroTabId = true;
						}

						if(!self.modelParamsForTabs()[currentIndex]){
								self.modelParamsForTabs.push({
										modelParams: ko.observableArray([]),
										href: "#param-tab-model"+tab_id.toString(),
										id: "param-tab-model"+tab_id.toString(),
										title: result.paramsTabTitle[self.modelParams()[i].tab_id]
								});
						}
						self.modelParamsForTabs()[currentIndex].modelParams.push(self.modelParams()[i]);
					}

					$("div#param-tabs").tabs("refresh");//.sliderTabs();
					$("div#param-tabs").tabs( "option", "active", self.selectedParamTab());
					if(self.modelParamsForTabs().length > 5){
						 $("div#param-tabs").tabs().scrollabletab();
				  }
					self.outputs($.map(result.outputs, function(item) { return new ModelSimulation.OutputVariable(item); }));
					self.biases(result.biases);
					self.originalOutputs = ko.toJS(self.outputs);  //newly added for benchmarking

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

			$.ajax({
				url: ROOT + "/benchmarking/GET"+ '/' + MODEL_ID,
				type: 'GET',
				success: function(result) {
					try {
						result = JSON.parse(result);
					} catch (err) { }

					for ($i=0; $i<result.length; $i++){
						self.benchmarking.push({
							order: $i,
							name: result[$i].display_name,
							href: "#tab-"+($i+1).toString(),
							id:"tab-"+($i+1).toString(),
							variable_bias:JSON.parse(result[$i].variable_bias),
							b_img:"b_img"+($i+1).toString(),
							user_input:ko.observable(
							{vb_name:ko.observable(),fb_name:ko.observable(),init:ko.observable(-0.5),end:ko.observable(0.5),step:ko.observable(0.01),value:ko.observable(0)}
							),
							fixed_bias:JSON.parse(result[$i].fixed_bias),
							filter:JSON.parse(result[$i].filter),
							benchmarkingID:result[$i].id
							}
						);
						if(self.benchmarking()[$i].variable_bias[0])
							self.benchmarking()[$i].user_input().vb_name(self.benchmarking()[$i].variable_bias[0].name);
						if(self.benchmarking()[$i].fixed_bias[0])
							self.benchmarking()[$i].user_input().fb_name(self.benchmarking()[$i].fixed_bias[0].name);
					}
					for($i=0; $i<self.img_src.length; $i++){
						$("#b_img"+($i+1).toString()).attr('src',$("#b_img"+($i+1).toString()).attr("src")+self.img_src[$i]);
					}

					self.changeBenchmark(self.selectedBenchmarkingTab()); //initialize b_vaibaleBias.name
					$("#benchmarking_tabs").tabs("refresh");
					$("#benchmarking_tabs").tabs("option","active",self.selectedBenchmarkingTab());
					self.selectedMode(self.availableMode()[0]);
				//	console.log(self.benchmarking());
					self.changeSelectedMode(0);
				}
			});
			self.choice()[1].b_name(self.benchmarking());
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
		this.showTypeExplanation = false;
		if(this.name.toUpperCase() == 'TYPE'/* && MODEL_ID == 9*/)
			this.showTypeExplanation = true;
	};
} (jQuery));
