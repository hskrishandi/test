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
    }
	
	ModelLibrary.DeviceModel = function(data) {
		var that = this;
        this.name = data.name;
        this.id = data.id;
		
        this.expanded = ko.observable(false);

        var mapped = $.map(data.library, function(item) { item.modelID = that.id; return item; });
        this.library = ko.observableArray(mapped);
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
		
        self.isLoading = ko.observable(false);
		self.selectedTab = ko.observable(0).extend({localPersist: { key: 'M#' + MODEL_ID + 'TABINDEX' } });
		
		self.instanceParams = ko.observableArray([]);
		self.instanceParams.getData = paramMapper(self.instanceParams);
		
		self.modelParams = ko.observableArray([]);
		self.modelParams.getData = paramMapper(self.modelParams);
		
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
					model: self.modelParams.getData()
				}
			});
		};
		
		self.loadParams = function(data) {
			var params = self.modelParams();
			for (var i = 0; i < data.length; ++i) {
				for (var j = 0; j < params.length; ++j) {
					if (data[i].name.toLowerCase() == params[j].name.toLowerCase()) {
						params[j].value(data[i].value);
						break;
					}
				}
			}
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
					data.token = result;
					data.outputs = self.selectedOutputs();
                    self.session(data);
					self.loadPlotData();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Error: " + textStatus + "; " + errorThrown);
					console.log("Response data: " + jqXHR.responseText);
                }, 
                complete: function() { self.isLoading(false); }
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
						url: ROOT + "/getData/" + session.token + '/' + output.column_id,
						success: function(result) {					
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
					self.instanceParams($.map(result.params.instance, function(item) { return new ModelSimulation.Parameter(item); }));
					self.modelParams($.map(result.params.model, function(item) { return new ModelSimulation.Parameter(item); }));
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
    }
		
	ModelSimulation.OutputVariable = function(data) {
		this.name = data.name;
		this.unit = data.unit;		
		this.column_id = data.column_id;
		
		this.linearPlot = ko.observable(false).extend({localPersist: { key: 'M#' + MODEL_ID + 'O#' + data.name + 'LIN' } });
		this.logPlot = ko.observable(false).extend({localPersist: { key:  'M#' + MODEL_ID + 'O#' + data.name + 'LOG' } });		
	};
		
	ModelSimulation.Parameter = function(data) {
		var that = this;
		
		this.name = data.name;
		this.unit = data.unit;		
		this.description = data.description;
		this.label = this.name + (this.unit ? ' [' + this.unit + ']' : '');
		this.default = data.default;
		
		this.value = ko.observable(data.default).extend({localPersist: { key: 'M#' + MODEL_ID + 'P#' + data.name } });
	};

} (jQuery));