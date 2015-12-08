/**
 * Chart plotting module
 * This module is responsible for plotting the output
 * acquired from the simulation module
 */ 
 
//used for storing the plots
var jqPlotObject=new Array();
//used to store which plot was displaying
var position = 0;
// Export the plotGraphs function 
var plotGraphs;
 
(function($) {

	/**
	 * plotGraphs function
	 * This function plots the graphs to a container from an array of outputs
	 */
	plotGraphs = function(container, output)
	{
		var resetAxes = true;
		
		container.html("")
		.append('<b>Graph:</b><select id="graph"></select>')
		.append('<a href="Javascript:void:(0)" id="log_plot" title="Log Y-axis" style="margin:0 10px"><i class="icon-check-empty"></i>Log Y-axis</a>');
				
		function resizeHandler(e) {
			e.data.plot.replot({ resetAxes: resetAxes});
		}
		
		function savePNG(id){
			prompt("Filename: ", function(filename) {
				if(filename) {
					var png = jqplotToImg(id);
					if(png == "")	//FOR IE8 or lower, png == ""
						return;
					var form;
		// 			if($.isIE() < 9)
		// 				form = $("<form>").attr('method', 'POST').attr('target', 'my_iframe').addClass("hidden").attr('action',CI_ROOT + "/txtsim/savePNGfromVML");
		// 			else
					form = $("<form>").attr('method', 'POST').attr('target', 'my_iframe').addClass("hidden").attr('action',CI_ROOT + "/txtsim/savePNG");
					$("<input/>").attr('name', 'png').val(png).appendTo(form);
					$("<input/>").attr("name", "filename").val(filename).appendTo(form);
					form.appendTo($("body"));
					form.submit();
					form.remove();
					return false;
				}
			}, {
				note: downloadAsNote,
				open: function() {
					$(this).parent().css("postion", "fixed").css("z-index", "1021");
				}
			});
		}		
		
		function clickHandler(e) {
			var graph_elem = $(e.data.elem || this);
			var graph_parent = graph_elem.parent();
			graph_elem.addClass("full-screen-cover");
			e.data.plot.plugins.highlighter.show = true;
			
			/*$("div.blockMsg").append('<a href="#" class="close">&#215;</a>')
			.append('<a class="dl-link-big action" href="#"><i class="icon-download-alt"></i>Save as PNG</a>');	*/	
			var topbar = $("<div class='graph-top full-screen-top' />").append('<a href="#" class="close close-big">&#215;</a>')
			.append('<a class="dl-link-big action" href="#"><i class="icon-download-alt"></i>Save as PNG</a>').appendTo("body");
			$(".close-big").click(function(e) {
				graph_elem.dblclick();
			});
			$(".dl-link-big").click(function(e){
				savePNG(graph_elem.attr("id"));
			});
			$("a.graph-area").bind("contextmenu",function(e){
				return false;
			}); 
			
			$(window).resize({plot: e.data.plot}, resizeHandler);
			resizeHandler(e);
			
			graph_elem.appendTo("body");
			
			$(this).one('dblclick', {plot: e.data.plot}, function(e) {
				topbar.remove();
				graph_parent.prepend(graph_elem);
				graph_elem.removeClass("full-screen-cover");
				e.data.plot.plugins.highlighter.show = false;
				e.data.plot.replot({ resetAxes: resetAxes });
				$(this).one('click', {plot: e.data.plot, elem: graph_elem}, clickHandler);
				
				
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
				container.append('<div class="graph-container"><a href="#" class="graph-area" id="'+id+'" style="display:block"></a></div>');		
				
				var graphDiv = container.find('.graph-container:last');
				$('<a class="dl-link action" href="#" ><i class="icon-download-alt"></i>Save as PNG</a>').appendTo(graphDiv);
				
				var p = plot(id, output[i].bias, output[i], scale);
				if (p) {
					$('#'+id).one('click', {plot : p, dl_link : output[i].downloadLink}, clickHandler);
					var abs_data = abs(output[i].data);
					jqPlotObject.push({plot: p, name: output[i].label, log_en: true, data: output[i].data, abs_data: abs_data, log: false, id: id});
					$('#graph').append('<option value="'+output[i].label+'">'+output[i].label+'</option>');
				} else {
					$('div.graph-container:has(#'+id+')').remove();
				}
			}
		}	
		console.log(jqPlotObject);
		
		$('.dl-link').click(function(){
			savePNG(jqPlotObject[position].id);
		});
		
		container.find('.graph-container').wrapAll('<div class="clearfix"></div>');
		//container.append('<b>Right click and drag on the plot to zoom.</b><b> Left click to reset.</b><b> Double click to full-screen display</b>');
		$('#log_plot').click(function(){
			if(jqPlotObject[position].log){
				jqPlotObject[position].log = false;
				$("#log_plot i").remove();
				$(this).prepend($("<i class='icon-check-empty' />"));
				//$('#log_plot i').addClass("icon-check-empty").removeClass("icon-check");
				jqPlotObject[position].plot.replot({data:[]});
				jqPlotObject[position].plot.replot({axes:{yaxis:{renderer: $.jqplot.LinearAxisRenderer},y2axis:{renderer: $.jqplot.LinearAxisRenderer}}});
				jqPlotObject[position].plot.replot({ resetAxes: true });
				jqPlotObject[position].plot.replot({data:jqPlotObject[position].data});
				}
			else{
				jqPlotObject[position].log = true;
				$("#log_plot i").remove();
				$(this).prepend($("<i class='icon-check' />"));
				//$('#log_plot i').addClass("icon-check").removeClass("icon-check-empty");
				jqPlotObject[position].plot.replot({data:[]});
				jqPlotObject[position].plot.replot({axes:{yaxis:{renderer: $.jqplot.LogAxisRenderer},y2axis:{renderer: $.jqplot.LogAxisRenderer}}}); 
				jqPlotObject[position].plot.replot({ resetAxes: true });
				jqPlotObject[position].plot.replot({data:jqPlotObject[position].abs_data});
				}
		});
		
		function abs(userData){
			var data = new Array();
			for(var i = 0; i < userData.length; i++){
				var temp = new Array();
				for(var j = 0; j < userData[i].length; j++){
					var data_point = new Array();	
					if(userData[i][j][1]<0){						
						data_point[0] = userData[i][j][0];
						data_point[1] = Math.abs(userData[i][j][1]);						
					}else if( -1e-15 < userData[i][j][1] && userData[i][j][1] < 1e-15 && userData[i][j][1] !=0){
						data_point[0] = userData[i][j][0];
						data_point[1] = 1e-15;
					}else if(userData[i][j][1]==0){

					}else{
						data_point[0] = userData[i][j][0];
						data_point[1] = userData[i][j][1];
					}
					temp.push(data_point);
				}
				data.push(temp);
			}
			return data;
		}
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

		var xlabel = (bias.v1.type).capitalize(), ylabel = output.name;
		var options = { 
			seriesDefaults: {
				shadow: false, 
				showMarker: false, 
				lineWidth: 2
			},
			grid: {
				drawGridlines: false, shadow: false, background: '#FFFFFF'
			},
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
					mark: 'inside',
					fontSize: '8pt',
					pt2px: 2
				}
			},
			/*cursor:{ 
					show: true,
					zoom: true, 
					clickReset: true,
					showTooltip: false
			},*/
			legend:{
				show: true,
				labels: output.series,
				placement: 'outsideGrid'
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
			
			var xndigit = Math.ceil(Math.abs(Math.log(bias.v1.end / 10) / Math.LN10));		//to find out the num. of digit of Xmax
			if(ylabel.length < 2){
				return $.jqplot(id, output.data, $.extend(true, {}, options, { 
					axes: {
						xaxis: {
							label: xlabel, 
							pad: 1.0,
							min: bias.v1.init, 
							max: bias.v1.end,
							tickOptions: { 
								formatter: function(sf, val) {
									if(val != 0) {
										val = $.jqplot.sprintf(xndigit <= 2 ? "%." + xndigit + "f" : "%.1e", val);
									}
									return val;
								}
							},
							autoscale: true
						},
						yaxis: {
							label: ylabel[0],
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
							},
							autoscale: true
						}
					}
					
				}));
			}else{
				return $.jqplot(id, output.data, $.extend(true, {}, options, { 
					series:[{yaxis:'y2axis'}],
					axes: {
						xaxis: {
							label: xlabel, 
							pad: 1.0,
							min: bias.v1.init, 
							max: bias.v1.end,
							tickOptions: { 
								formatter: function(sf, val) {
									if(val != 0) {
										val = $.jqplot.sprintf(xndigit <= 2 ? "%." + xndigit + "f" : "%.1e", val);
									}
									return val;
								}
							},
							autoscale: true
						},
						yaxis: {
							label: ylabel[1],
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
							},
							autoscale: true
						},
						y2axis: {
							label: ylabel[0],
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
							},
							autoscale: true
						}
					}					
				}));				
			}
			
			
		} else if (scale === 'log') {								
			Math.log = (function(log) {
				return function(x) {
					if (x > 0) return log(x);
					return null;
				}
			})(Math.log);
			//
			var max = 0 , min = Number.MAX_VALUE;		
			var data = [];
			for (var i = 0; i < output.data.length; ++i) {
				var arr = [];
				for (var j = 0; j < output.data[i].length; ++j) {
					if($.isNumeric(output.data[i][j][1])) {
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
			
			/*
			var min = bias.v1.init;			
			var max = bias.v1.end;			
		
			var ticks = [];
			var lmax = Math.ceil(Math.log(max)/Math.LN10), lmin = Math.floor(Math.log(min)/Math.LN10);
	
			var tickCount = Math.max(2, Math.min(6, lmax-lmin+1));
			
			for (var i = 0; i < tickCount; ++i) {
				ticks.push(Math.pow(10, lmin + Math.max(Math.ceil((lmax-lmin)/tickCount),1)*i));
			}*/
			

			if(ylabel.length < 2){
				return $.jqplot(id, data, $.extend(true, {}, options, {			
					highlighter: { useAxesFormatters: true },
					axes: {
						xaxis: {
							renderer: $.jqplot.LogAxisRenderer,
							label: xlabel, 
							pad: 1.0,
							tickDistribution:'power',
							//ticks: ticks,
							tickOptions: {
								formatter: function(sf, val) {
									if(val.toString().charAt(0) == "1")
										return $.jqplot.sprintf("%.0e", val);
									return "";
								}
							}
						},
						yaxis: {						
							label: ylabel[0]
						}
					}
				}));
			}else{
				return $.jqplot(id, data, $.extend(true, {}, options, {
					series:[{yaxis:'y2axis'}],				
					highlighter: { useAxesFormatters: true },
					axes: {
						xaxis: {
							renderer: $.jqplot.LogAxisRenderer,
							label: xlabel, 
							pad: 1.0,
							tickDistribution:'power',
							//ticks: ticks,
							tickOptions: {
								formatter: function(sf, val) {
									if(val.toString().charAt(0) == "1")
										return $.jqplot.sprintf("%.0e", val);
									return "";
								}
							}
						},
						yaxis: {						
							label: ylabel[1]
						},
						y2axis: {						
							label: ylabel[0]
						}
					}
				}));
			}
		}
		
		return false;
	}

})(jQuery);
