/**
 * @fileOverview Useful utility functions and settings 
 */

// Exports
var alert;
var confirm;
var prompt;
var isNum;
var error;

if (typeof console === "undefined" || !console) {
    console = {
        dir: function () { },
        log: function () { }
    };
}

(function ($) {
    // Override BlockUI defaults
    $.extend(true, jQuery.blockUI.defaults, {
	    fadeOut:  200,
	    css: { border: 'none', backgroundColor: '#FFF' }, 
	    overlayCSS:  { backgroundColor: '#FFF', opacity: 0.8 }
    });
        
    isNum = function(val) {
      if(val === "") return false;
      else return !isNaN(val);
    }
        
    error = function(msg) {
	    alert(msg, $('body'), { 
		    title: "Error in handling parameter sets",
		    close: function() {
			    window.location.reload();
		    }
	    }); 
    }

    /**
     * Override javascript alert() and wrap it into a jQuery-UI Dialog box
     *
     * @param { String } the alert message
     * @param { jQuery Object } jQuery selector target to be blocked (optional)
     * @param { Object } jQuery Dialog box options (optional)
     */
    alert = function(message, target, options) { 
	    var events = {};
	    if (target) {
		    target.block({ message: null }); 
		    events = { 
			    close: (function(callback) {
				    return function(event, ui) { 
					    target.unblock();
					    if ($.isFunction(callback)) {
						    return callback(event, ui);
					    }
				    } 
			    })((options ? options.close : null))
		    };
	    }
	
	    var alertBox = $('#alert');
	    if (!alertBox.length) {
	 	    alertBox = $('<div id="alert"><i class="icon-warning-sign icon-4x pull-left"></i><div class="alert-message"></div></div>').hide().appendTo('body');		
	    }

	    $("div", alertBox).html(message);	
	
	    alertBox.dialog($.extend({}, alert.defaults, options, events));
    }

    alert.defaults = {
		modal		: false,
		resizable	: false,
		buttons		: {
			OK: function() {				
				$(this).dialog('close');
			}
		},
		show		: 'fade',
		hide		: 'fade',
		width		: 400,
		minHeight	: 150,
		dialogClass	: 'dialog-box alert-box',
		title		: 'Alert'
	};
	
	/**
	 * Override javascript confirm() and wrap it into a jQuery-UI Dialog box
	 *
	 * @param { String } the confirm message
	 * @param { Function (boolean confirm) } the callback function when confirmed / canceled
	 * @param { Object } jQuery Dialog box options (optional)
	 */
	confirm = function(message, callback, options) {
		var defaultActions = {
			buttons	: {
				Confirm : function() {
					callback(true);
					$(this).dialog('close');
				},
				Cancel : function() {
					callback(false);
					$(this).dialog('close');
				}
			}
		};
		var confirmBox = $('#confirm');
		if (!confirmBox.length) {
			confirmBox = $('<div id="confirm"><i class="icon-info-sign icon-4x pull-left"></i><div class="confirm-message"></div></div>').hide().appendTo('body');		
		}

		$("div", confirmBox).html(message);	
		
		confirmBox.dialog($.extend({}, confirm.defaults, defaultActions, options));
	}
	
	confirm.defaults = {
		modal		: true,
		resizable	: false,
		show		: 'fade',
		hide		: 'fade',
		width		: 400,
		minHeight	: 150,
		dialogClass	: 'dialog-box confirm-box',
		title		: 'Confirm'
	};
	
	
	/**
	 * Override javascript prompt() and wrap it into a jQuery-UI Dialog box
	 *
	 * @param { String } the prompt message
	 * @param { Function (string val) } the callback function when confirmed
	 * @param { Object } jQuery Dialog box options (optional)
	 */	
	prompt = function(message, success, target, options) {
		var defaultActions = {
			buttons		: {
				OK : function() {
					success($("#prompt input#prompt-input").val());
					$(this).dialog('close');
				},
				Cancel : function() {				
					$(this).dialog('close');
				}
			}
		};		
		
		var promptBox = $('#prompt');
		if (!promptBox.length) {
			promptBox = $('<div id="prompt">' + message + ' <input id="prompt-input" type="text" /></div>').hide().appendTo('body');		
		}
		
		promptBox.dialog($.extend({}, prompt.defaults, defaultActions, options));
	}
	
	prompt.defaults = {
		resizable	: false,
		show		: 'fade',
		hide		: 'fade',
		width		: 400,
		minHeight	: 150,
		dialogClass	: 'dialog-box prompt-box',
		title		: 'Prompt'
	};
		
	/** 
	 * In-page form submit plugin for file upload / download
	 */
	$.submit = function(options) {
		var opts = $.extend(true, {}, $.submit.defaults, options);
		
		//url option required
		if(opts.url) { 		
			//send request
			var iframe = $('<iframe />').uniqueId().appendTo('body').hide();
			var target = iframe.attr('id');
			iframe.attr('name', target);
			var form = opts.form || $('<form />');
			
			form.attr({
				action: opts.url,
				method: (opts.type||'post'),
				target: target,
				enctype: "multipart/form-data"			
			});
			
			if (opts.data) {
				$('<input type="hidden" name="data" />')
					.val(JSON.stringify(opts.data))
					.appendTo(form);
			}
			
			iframe.load(function() {
				var result;
				try {
					result = JSON.parse($(this).contents().text());
				} catch (err) {
					result = $(this).contents().text();
				}
				if ($.isFunction(opts.load)) {
					opts.load(result);
				}
				iframe.remove();
			});

			form.appendTo('body').submit();
			if (!opts.form) {
				form.remove();		
			}
		}
	};
	
	$.submit.defaults = {
		url: '',
		data: {},
		form: null,
		type: 'GET',
		load: null
	};

 } (jQuery));