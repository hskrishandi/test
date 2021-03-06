;(function ($) {

	/**
	 * LOCAL STORAGE LIBRARY
	 **/
	
	var LS_SUPPORT = (typeof(localStorage) !== "undefined");
	
	var _storage = {
		save: function(options) {
			options = options || {};
			
			var key = options.key || null;
			var val = options.val || null;
			if(LS_SUPPORT)
				if(val === null)
					localStorage.setItem(key, "");
				else
					localStorage.setItem(key, val);
		},
		load: function(options) {
			options = options || {};
			
			var key = options.key || null;
			if(LS_SUPPORT)
				return localStorage.getItem(key);
		}
	}
	
	$.fn.storage = $.extend({ }, _storage);
	$.storage = $.fn.storage;
	
	/**
	 * FILE UPLOAD LIBRARY
	 **/
	
	$(function() { 
		FILE_FRAME = $('<iframe name="uploadframe" id="uploadframe" />')
		.appendTo('body').hide();
		FILE_FORM = $('<form name="uploadform" action="" method="POST" target="uploadframe" enctype="multipart/form-data" />')
		.appendTo('body').hide();
	});
	 
	$.fn.fileupload = function(options) {
		return $(this).each(function() {
			if($(this).html().indexOf("type=\"file\"") != -1) return $(this);
			options = options || {};
			
			var name = options.name || null;
			var url = options.url || null;
			var load = options.load || null;
			var uploadStart = options.uploadStart || null;
			var uploadComplete = options.uploadComplete || null;
			var that = $(this);
			var form = FILE_FORM;

			var input = $('<input type="file" name="' + name + '" />')
			//.appendTo(that)
			.css({
				position: "absolute",
				opacity: 0.0,
				"z-index": 12,
				cursor: "pointer",
				top: "0px",
				right: "0px"
			})
			.change(function() {
				if($.isFunction(uploadStart))	//confirm upload file, fire uploadstart
					uploadStart();
				FILE_FRAME.unbind("load").bind("load", function() {
					var result;
					var callback = load;
					try {
						result = JSON.parse($(this).contents().text());
					} catch (err) {
						result = $(this).contents().text();
					}
					if($.isFunction(callback))
						callback(result);
					if($.isFunction(uploadComplete))
						uploadComplete();
				});
				form.html(input);				//put the file input into form
				form.attr("action", url + "?_=" + $.microtime(true));
				form.submit();
				that.prepend($(this));
				//$(this).appendTo(that);			//put the file input back to current control
				//$(this).val("");				//reset the file input value
				$(this).replaceWith(input = $(this).clone(true));
			})
			.mouseup(function() {
				if(!($.isIE() < 8))
					return;
				var that = $(this);
		                    $(document).hover(function() {
					while ((that = that.parent()) && that.length > 0)
						that.click();
					$(this).unbind("hover");
		                    });
			});
			
			that.css({
				overflow: "hidden",
				position: "relative",
				cursor: "pointer"
			})
			.prepend(input)
			.mousemove(function(e) {			//fix the ie problem, that invoke file dialog only clicking button
				var relX = $(this).width() - (e.pageX - $(this).offset().left);
				input.css({
					right: (relX - 32) + "px"
				})
			})
			.mouseleave(function() {
				input.css({
					right: "0px"
				});
			})
			.click(function(e) {
				if($.isIE() < 8)
					e.stopPropagation();
			});
			
			return $(this);
		});
	};
	
	/**
	 * OTHER LIBRARY
	 **/
	$.microtime = function(get_as_float) {
		var unixtime_ms = new Date().getTime();
		var sec = parseInt(unixtime_ms / 1000);
		return get_as_float ? (unixtime_ms/1000) : (unixtime_ms - (sec * 1000))/1000 + ' ' + sec;
	};
	
	$.isIE = function(){
		var undef,rv = -1; // Return value assumes failure.
		if (navigator.appName == 'Microsoft Internet Explorer')
		{
			var ua = navigator.userAgent;
			var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null)
			rv = parseFloat( RegExp.$1 );
		}
		return ((rv > -1) ? rv : undef);
	};
	
	$.copyEvents = function(elem1, elem2) {
		var events = elem1.data('events');
		if(events)
			for(var eventType in events)
				for(var idx in events[eventType])
					elem2[eventType](events[eventType][idx].handler);
	};

	/* Code Mirror Extension */
	var cmDefault = {
		mode: "text/plain",
		smartIndent: true,
		indentWithTabs: true,
		lineWrapping: true,
		lineNumbers: true,
		styleActiveLine: true,
	};

	var cmUIDefault = {
		path : 'js/library/codemirror',
		//searchMode : 'popup',
		buttons : ['search', 'undo', 'redo', 'jump'],
	};

	$.fn.cmInit = function(options) {
		$(this).each(function(i, elem) {
			if(!$(elem).next().hasClass("CodeMirror")) {
				var codemirrorUI = new CodeMirrorUI($(elem)[0],$.extend({ }, cmUIDefault),$.extend({ }, cmDefault));
				var codemirror = codemirrorUI.mirror;
				var self = $(elem);

				codemirror.on("change", function() {
					self.val(codemirror.getValue());
					if(self.hasClass("data-persist")) {
						self.storage.save({
							key: self.attr("id"),
							val: self.val()
						});
					}
					//the div count will be less than expected
					//grow the codemirror to get maxlinenumber
					// codemirror.setSize(null, 10000);
					var maxLineNumbers = self.next().find(".CodeMirror-code > div").length;
					if(maxLineNumbers<=30)
						codemirror.setSize(null, maxLineNumbers * 14+40);
				});

				$(elem).change(function() {
					codemirror.setValue(self.val());
				});

				$(elem).change();

				var toolbar = $(elem).prev().find(".codemirror-ui-button-frame");
				toolbar.css({ display: "none" });

				CodeMirror.on(codemirror, "keydown", function(e, k) {
					if((k.altKey) && k.which == 84) {
						if(toolbar.length > 0) {
							var display = toolbar.css("display");
							if(display == "none")
								toolbar.css({ display: "" });
							else
								toolbar.css({ display: "none" });
						}
						k.preventDefault();
					}
				});
			}
		});
	};

	$.fn.cmApply = function(fn) {
		return $(this).each(function(i, elem) {
			if($(elem).next().hasClass("CodeMirror")) {
				fn($(elem).next()[0].CodeMirror);
			}
		});
	};


	 
}(jQuery));

$(function() {

	//each button corresponding to several area identified by id
	//let's say clear-button-0 will clear clear-area-0
	//clear-button-1 will clear clear-area-1 etc..
	$("a[class*=clear-button-]").click(function() {
		var that = this;
		confirm("Do you wish to clear all the input data?", function(e) {
			if(e)
			{
				var classes = $(that).attr('class').split(' ');
				var group = 0;
				for(var i = 0; i < classes.length; i++)
					if(/clear-button-[0-9]+/.test(classes[i]))
						group = classes[i].split('-')[2];
				$(".clear-area-" + group).each(function() {	
					$(this).val("");
					$(this).change();
				});
			}
		});
	});
	
	//We find out which area is marked data-persist
	//and look through whether the localstorage already has val
	//if so, assign the value
	//Be care, the id must be unique!
	$(".data-persist").each(function() {
		$(this).val($(this).storage.load({
			key: $(this).attr("id")
		}));
	});

	$(".svg-persist").each(function(){
		if($(this).storage.load({key:$(this).attr("id")})!=null){
			$(this).html($(this).storage.load({
				key: $(this).attr("id")
			}));
		}
	});
	
	//When the data has changed, stored the changed value to localstorage with key = their id
	$(".data-persist").change(function() {
		$(this).storage.save({
			key: $(this).attr("id"),
			val: $(this).val()
		});
	});

	$(".svg-persist").bind({
		DOMSubtreeModified:function(){
			$(this).storage.save({
				key: $(this).attr("id"),
				val: $(this).html()
			});
		}
	});
	
	//for saving library as
	$(".model-library-save-as").click(function() {
		prompt('Filename: ', function(filename) {
			if(filename == '') return;
			$.submit({
				url: ROOT + "/modelLibrary/DOWNLOADAS",
				type: 'POST',
				data: {"saveas_name": filename},
				complete: function() {  }
			});
					
		}, {
			note: downloadAsNote
		});
		return;
	});
	
	//for removing model library entry
	$(document).on("click", ".model-lib-entry-remove", function() {
		var $entry = $(this).parent();
		var $entry_id = $entry.attr("model-id");
		var $entry_name = $entry.attr("model-name");
		confirm("Do you wish to delete the model card \"" + $entry_name + "\" ?", function(load) {
			if (load) {
				viewModels.lib.isLoading(true);
				$.ajax({
					url: ROOT + "/modelLibrary/DELETE/" + $entry_id,
					success: function(result) {
					if (result) {
						viewModels.lib.load();
						}
					}, 
					complete: function() { viewModels.lib.isLoading(false); }
				});
			}
		});	
		return;
	});

	$(document).on("click", ".model-page-direct", function() {
		var href = (typeof CI_ROOT !== "undefined" ? CI_ROOT : "") + "modelsim/model/" + $(this).attr("href");
		$.storage.save({
			key: "M#" + $(this).attr("href") + "TABINDEX",
			val: "0"
		});
		document.location.href = href;
	});
	
	$(".model-library-upload").fileupload({
		name: "file",
		url: (typeof ROOT !== "undefined" ? ROOT : "") + "/modelLibrary/UPLOAD",
		load: function(data) {
			if (data.success)
				viewModels.lib.load();
			else
				alert(failUploadMsg);
		}
	});
	
	//Prevent ajax caching
	$.ajaxSetup({ cache: false });
});
