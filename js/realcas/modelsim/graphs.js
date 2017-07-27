/**
 * @fileOverview Graph plotting module
 */ 

//Exports
var Graph;

(function($) {
	
	// Workaround for undefined log values when using log plot
	Math.log = (function(log) {
		return function(x) {
			if (x > 0) {
				return log(x);
			}
			return null;
		}
	})(Math.log);
	
	// Model for use with knockout (optional)
	GraphModel = function(options) {
		var self = this;
		
		self.x = ko.observable(options.x);
		self.y = ko.observable(options.y);
		self.data = ko.observableArray(options.data || []);
		self.customData = ko.observableArray(options.customData || []);
		self.showCustomData = ko.observable(false);
		self.allData = ko.computed(function() {
			return self.data().concat(self.customData());
		});
		self.id = $.imos.graph.counter;
	};
	
	GraphModel.log = function(data) {
		var result = [];			
		for (var i = 0; i < data.length; ++i) {
			result.push([]);
			for (var j = 0; j < data[i].length; ++j) {
				result[i].push(data[i][j][0], Math.log(data[i][j][1]) / Math.LN10);
			}
		}
		return result;
	};
	
	// Pure jQuery UI graph widget
	$.widget("imos.graph", {
		options: {
			x: { name: '', unit: '', log: false },
			y: { name: '', unit: '', log: false },
			data: [],
			customData: []
		},
		
		_create: function() {
			var self = this;
			var $element = $(this.element).wrap('<div class="graph-wrapper" />');			
			this._btnClose = $('<a href="#" class="close"><i class="icon-remove-sign"></i> Close</a>')
					.appendTo($element.parent()).hide();
			this._btnDownloadAsPNG = $('<a class="saveas" href="#" onclick="viewModels.sim.downloadPlotData();"><i class="icon-download-alt"></i> Save as PNG</a>')
					.appendTo($element.parent()).hide();
					
			this._isOpen = false;
			this._jqplot = null;
			this._id = $(this.element).attr('id');
			this._jqPlotOptions = $.extend(true, {}, $.imos.graph.plotOptions);
								
			this._resizeHandler = function(e) {
				$element.graph("replot");
			};
			
			$element.one('click', function() { self.open(); });
			
			if (!this._id) {
				this._id = 'imos-graph-' + $.imos.graph.counter++;
				$element.attr('id', this._id);
			}
			
			this._ylabel = this._xlabel = '';
			if (this.options.x.name) {
				this._xlabel = this.options.x.name + (this.options.x.unit ? ' [' + this.options.x.unit + ']' : '')
			}
			
			if (this.options.y.name) {
				var name = this.options.y.name;
				if (this.options.y.log) {
					name = 'abs(' + name + ')';
				}
				this._ylabel = name + (this.options.y.unit ? ' [' + this.options.y.unit + ']' : '')
			}
			
			this._jqPlotOptions.axes.xaxis.label = this._xlabel;
			this._jqPlotOptions.axes.yaxis.label = this._ylabel;
			
			if (this.options.x.log) {
				this._jqPlotOptions.axes.xaxis.renderer = $.jqplot.LogAxisRenderer;
			}
			
			if (this.options.y.log) {
				this._jqPlotOptions.axes.yaxis.renderer = $.jqplot.LogAxisRenderer;
			}
		},
		
		_init: function() {
			this.clearPlot();
			this.plot();
		},
		
		plot: function() {
			var i;
			var data = this.options.data.concat(this.options.customData);
			var options = this._jqPlotOptions;
			
			if (this.options.y.log) {
				for (var i = 0; i < data.length; ++i) {
					for (var j = 0; j < data[i].length; ++j) {
						data[i][j][1] = (data[i][j][1] ? Math.abs(data[i][j][1]) : Math.MIN_VALUE);
					}
				}
			}
			
			options.series = [];			
			for (i = 0; i < this.options.data.length; ++i) {
				options.series.push({});
			}
			for (; i < data.length; ++i) {
				options.series.push($.imos.graph.customSeriesOptions);
			}
						
			options.axes.yaxis.tickOptions = { formatter: this._getFormatter(data) };

			this._jqplot = $.jqplot(this._id, data, options);
		},
		
		replot: function() {
			if (this._jqplot) {				
				this._jqplot.plugins.highlighter.show = this._isOpen;
				this._jqplot.replot({ resetAxes: true });
			}
		},
		
		open: function() {
			if( this._trigger("beforeopen") === false ){
				$element.one('click', function() { self.open() });
				return;
			}
			
			this._isOpen = true;

			var self = this;
			var $element = $(this.element);
			var container = $element.parent();

			$(window).resize(self._resizeHandler);
			container.addClass("full-screen-cover");
			self._graphParent = container.parent();
			container.appendTo("body");

			self._btnClose.show();
			self._btnDownloadAsPNG.show();
			self._btnClose.one('click', function() { self.close(); });
			self._resizeHandler();
			
			// trigger open event
			this._trigger("open");
			
			return this;
		},
		
		close: function() {
			var $element = $(this.element);
			var self = this;
			
			this._isOpen = false;
			this._trigger("close");
			
			$element.parent().removeClass("full-screen-cover")
			.appendTo(self._graphParent);
			$element.graph("replot");
			self._btnClose.hide();
			self._btnDownloadAsPNG.hide();
			$element.one('click', function() { self.open() });

			$(window).unbind('resize', self._resizeHandler);
	
			return this;
		},
		
		isOpen: function() {
			return this._isOpen;
		},
		
		destroy: function() {
			--$.imos.graph.counter;
			this._clearPlot();			
			$.Widget.prototype.destroy.call( this );
		},
		
		clearPlot: function() {					
			if (this._jqplot) {
				this._jqplot.destroy();
				$(this.element).empty();
				this._jqplot = null;
			}
		},
		
		_setOption: function(key, value) {
			this.options[key] = value;

			switch(key){
			case "customData":
				this.clearPlot();
				this.plot();
				break;
			}
		},
		
		_getFormatter: function(data) {
			var sf;
			if (!data.length) {
				sf = 2;
			} else {			
				var max = Math.abs(data[0][0][1]), min = max;		
				for (var i = 0; i < data.length; ++i) {
					for (var j = 0; j < data[i].length; ++j) {
						var y = Math.abs(data[i][j][1]);
						max = Math.max(max, y);
						min = Math.min(min, y);				
					}
				}
				sf = Math.round(Math.log(max) / Math.LN10) - Math.round(Math.log((max-min) / 5) / Math.LN10) + 1;
				if (!isFinite(sf)) {
					sf = 2;
				}
				sf = Math.min(Math.max(sf, 2), 10);		// 2 - 10 s.f.
			}
			
			return function (format, val) {
				var exp = $.jqplot.sprintf('%.'+sf+'e', val);
				var fix = $.jqplot.sprintf('%.'+sf+'g', val);
				var result = (exp.length <= fix.length ? exp : fix);
				return result;
			};	
		}
	});
 
	$.extend($.imos.graph, {
		counter: 0,
		selectedPlot: -1,
		plotOptions: { 
			axes: {
				xaxis: {
					pad: 1.0
				},
				yaxis: {
					pad: 1.1
				}
			},		
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
			highlighter: { useAxesFormatters: true },
			axesDefaults: {	
				showTickMarks: true,
				tickRenderer: $.jqplot.CanvasAxisTickRenderer,
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
				base: 10, 
				labelOptions: { 
					fontSize: '12pt',
					pt2px: 2
				},
				tickOptions: { 
					mark: 'inside',
					fontSize: '8pt',
					pt2px: 2
				}
			}
		},
		customSeriesOptions: {
			markerOptions: { style: "x" },
			showLine: false,
			showMarker: true
		}
	});

}(jQuery));