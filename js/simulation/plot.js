/**
 * Chart plotting module
 * This module is responsible for plotting the output
 * acquired from the simulation module
 */ 
 
// Export the plotGraphs function 
var plotGraphs;
 
(function($) {

	/**
	 * plotGraphs function
	 * This function plots the graphs to a container from an array of outputs
	 */
	plotGraphs = function(container, bias, output)
	{
		var resetAxes = true;
		
		container.html("");
		
		function resizeHandler(e) {
			var w = $(window).width(), h = $(window).height();
			$('div.blockMsg').css({
				top: 0.1 * h / 2 + 'px',
				left: 0.1 * w / 2 + 'px',
				width: 0.9 * w + 'px',
				height: 0.9 * h + 'px'
			});
			e.data.plot.replot({ resetAxes: resetAxes });
		}
			
		function clickHandler(e) {			
			$.blockUI({ 
				message: $(this),
				css: { cursor: 'auto' },
				overlayCSS:  { opacity: 1.0 },
				onBlock: (function(target) {
					return function() { 
						$("div.blockOverlay").css('cursor', 'default');
						$("div.blockMsg").append('<a href="#" class="close">&#215;</a>');
										/* .append('<a href="#" class="btn-upload-data">Load data to graph</a>')
										 .append('<a class="dl-link-big" href="'+e.data.dl_link+'">Save tabulated data</a>') */
						$("div.blockMsg .close").click(function(e) {
							target.dblclick();
						});
						resizeHandler(e);
					};
				})($(this))
			}); 
			
			e.data.plot = $(this).data('plot');
			e.data.plot.plugins.highlighter.show = true;
								
			$(window).resize({plot: e.data.plot}, resizeHandler);
			resizeHandler(e);	
			
			$(this).one('dblclick', {plot: e.data.plot}, function(e) {
				$.unblockUI({
					onUnblock: (function(plot, target) {
						return function() {	
							plot.plugins.highlighter.show = false;
							plot.replot({ resetAxes: resetAxes });
							target.one('click', {plot: plot}, clickHandler);
						};
					})(e.data.plot, $(this))
				});	
				
				$(window).unbind('resize', resizeHandler);
				
				return false;
			});
			
			$(document).one('keyup', {target: $(this)}, function(e) {
				if (e.keyCode == 27) {	// Esc key
					e.data.target.dblclick();
				}
				return 0;
			});

			return false;
		}		
			
		for(var i = 0; i < output.length; i++){
			for (var scale in output[i].plot) {
				if (!output[i].plot[scale]) continue;
				
				var id = 'graph-v1-'+i+'-'+scale;
				var output_name = (scale == 'log' ? 'log ' : '') + output[i].name.replace(/\[[^\]]+\]/gi,"");
				container.append('<div class="graph-container" data-output="' + output_name + '" data-canvas="' + id + '"><a href="#" class="graph-area" id="' + id + '"></a></div>');		
				
				var graphDiv = container.find('.graph-container:last');
				$('<a href="#" class="btn-upload-data">Load data to graph</a>').appendTo(graphDiv);
				$('<a class="dl-link" href="'+output[i].downloadLink+'">Save Tabulated Data</a>').appendTo(graphDiv);
				
				var p = plot(id, bias, output[i], scale);
				if (p) {
					var $canvas = $('#'+id);
					$canvas.one('click', {dl_link : output[i].downloadLink}, clickHandler).data('plot', p);
				} else {
					$('div.graph-container:has(#'+id+')').remove();
				}
			}
		}	
		
		container.find('.graph-container').wrapAll('<div class="clearfix"></div>');
	}

	/**
	 * Plot one graph to a container of given id
	 * scale: can be "linear" or "log"
	 */
	function plot(id, bias, output, scale)
	{
		String.prototype.capitalize = function() {
			return this.charAt(0).toUpperCase() + this.slice(1);
		}
		
		var $target = $('#' + id);		
		var renderer = function() {
			var data = $target.data('data');
			var userdata = $target.data('userdata');			
			return data.concat(userdata);
		};

		var xlabel = (bias.v1.type +  "[V]").capitalize(), ylabel = output.name;
		
		var options = { 
			seriesDefaults: {
				shadow: false, 
				markerOptions: {
					size: 7, 
					shadow: false
				},
				showMarker: false,
				lineWidth: 2
			},
			grid: {
				drawGridlines: false, shadow: false, background: '#FFFFFF'
			},
			dataRenderer: renderer,
			highlighter: { useAxesFormatters: false },
			axesDefaults: {	
				showTickMarks: true,
				tickRenderer: $.jqplot.CanvasAxisTickRenderer,
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
				labelOptions: { 
					fontSize: '12pt',
					pt2px: 2
				},
				tickOptions: { 
					fontSize: '8pt',
					pt2px: 2
				}
			}
		};

		if (scale === 'linear') {	
			var sf;
			if (!output.data.length) {
				output.data = [[[0, null]]];
				sf = 2;
			} else {			
				var max = Math.abs(output.data[0][0][1]), min = max;		
				for (var i = 0; i < output.data.length; ++i) {
					for (var j = 0; j < output.data[i].length; ++j) {
						var entry = Math.abs(output.data[i][j][1]);
						max = Math.max(max, entry);
						min = Math.min(min, entry);				
					}
				}
				sf = Math.round(Math.log(max)/Math.LN10) - Math.round(Math.log((max-min)/5)/Math.LN10)+1;
				if (!isFinite(sf)) {
					sf = 2;
				}
			}
			
			$target.data('data', output.data);
			$target.data('userdata', []);
			$target.data('plotOptions', $.extend(true, {}, options, { 
				axes: {
					xaxis: {
						label: xlabel, 
						pad: 1.0,
						min: bias.v1.init, 
						max: bias.v1.end
					},
					yaxis: {
						label: ylabel,
						tickOptions: { 
							formatter: (function() {
								return function (sf, val) {
									var exp = $.jqplot.sprintf('%.'+(sf > 0 ? sf-1 : sf)+'e', val);
									var fix = $.jqplot.sprintf('%.'+sf+'g', val);
									var result = (exp.length <= fix.length ? exp : fix);
									return result;
								};							
							})(),
							formatString: Math.min(Math.max(sf, 2), 10)
						}
					}
				}
			}));
			return $.jqplot(id, [], $target.data('plotOptions'));
		} else if (scale === 'log') {										
			Math.log = (function(log) {
				return function(x) {
					if (x > 0) return log(x);
					return null;
				}
			})(Math.log);
			
			var max = 0 , min = Number.MAX_VALUE;		
			var data = [];
			for (var i = 0; i < output.data.length; ++i) {
				var arr = [];
				for (var j = 0; j < output.data[i].length; ++j) {
					if(output.data[i][j][1] > 0) {
						arr.push(output.data[i][j]);
						
						var entry = output.data[i][j][1];
						max = Math.max(max, entry);
						min = Math.min(min, entry);	
					}	
				}
				if (arr.length) data.push(arr);
			}

			if (!data.length) {
				data = [[[0, null]]];
			}
			
			var ticks = [];
			var lmax = Math.ceil(Math.log(max)/Math.LN10), lmin = Math.floor(Math.log(min)/Math.LN10);
			var tickCount = Math.max(2, Math.min(6, lmax-lmin+1));
			for (var i = 0; i < tickCount; ++i) {
				ticks.push(Math.pow(10, lmin + Math.max(Math.ceil((lmax-lmin)/tickCount),1)*i));
			}
			
			$target.data('data', data);
			$target.data('userdata', []);
			$target.data('plotOptions', $.extend(true, {}, options, { 
				highlighter: { useAxesFormatters: true },
				axes: {
					xaxis: {
						label: xlabel, 
						pad: 1.0,
						min: bias.v1.init, 
						max: bias.v1.end
					},
					yaxis: {
						renderer: $.jqplot.LogAxisRenderer,
						label: 'log ' + ylabel,
						ticks: ticks,
						tickOptions: { 
							formatString: '%.1e'
						}
					}
				}
			}));
			return $.jqplot(id, [], $target.data('plotOptions'));
		}
		
		return false;
	}

})(jQuery);
