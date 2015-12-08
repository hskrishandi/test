/**
 * Simulation module
 * This module is responsible for handling the communcation with backend server
 * to perform the simulation
 */ 

// Export the Simulation class 
var Simulation;

// document.ready
(function($) {
	/**
	 * Simulation class constructor
	 */
	Simulation = function(options) 
	{
		this.settings = $.extend(true, {},  Simulation.defaults, options || {});
		var token = null, params = null, modelID = options.modelID;
		
		$.jsonRPC.setup({
			endPoint: options.backendUrl
		});
		
		/**
		 * run method
		 * request the backend server to run the simulation
		 */
		this.run = function(options)
		{
			var defaults = {
				biases: {}, 
				params: {}, 
				success: function(token) {},
				error: function(msg) {}
			};
			var options = $.extend(true, {}, defaults, options || {});

			$.jsonRPC.request('simulate', {
				params: [modelID, options.params, options.biases],
				success: function(result) {
					token = result.result;
					options.success(token);
				},
				error: function(result) {
					options.error(result.result);
				}
			});	
		}

		/**
		 * getOutputs method
		 * get the output data from the server
		 * run() must be called for this method to be able to retrieve outputs
		 */		
		this.getOutputs = function(options)
		{
			var defaults = {
				outputFilter: [], 
				success: function(output) {},
				error: function(msg) {}
			};
			var options = $.extend(true, {}, defaults, options || {});
			
			var filter = options.outputFilter;
			var graphMap = this.settings.graphMap;
			
			if (!token) {
				optons.error("No output as simulation is not yet run");
				return;
			}
			
			var result = [];
			var count = 0;
			for(var i = 0; i < filter.length; i++) {
				(function() {
					var index = i;
					var plot_filter = filter[index];
					var y = graphMap[plot_filter.name];
					
					$.jsonRPC.request('get_output', {			
						params: [token, y.column],
						success: function(feedback) {
							var data = [];
							if (feedback.result.length > 0) {
								var init = feedback.result[0][0];
								data.push([feedback.result[0]]);
								
								for (var i = 0, j = 1; j < feedback.result.length; ++j) {
									if (feedback.result[j][0] != init) {
										data[i].push(feedback.result[j]);
									} else {
										++i;
										data.push([feedback.result[j]]);										
									}
								}
							}
							
							result[index] = {
								id: y.column,
								name: y.name,
								plot: {									
									linear: plot_filter.linear,
									log: plot_filter.log
								},
								data: data,
								downloadLink: 'output' + y.column + '.csv'
							};
							
							count++;
							if(count === filter.length){							
								options.success(result);
							}
						},
						error: function(result) {
							options.error(result.result);
						}
					});
				})();
			}
		}
	}
	
	// Default parameters for constructor
	Simulation.defaults = {
		backendUrl: "",
		graphMap: {},
		modelID: 0
	}; 	 

})(jQuery);