/**
 * @fileOverview Useful utility functions and settings 
 */

// Exports
var alert;
var confirm;
var prompt;
var exampleDialog;
var isNum;
var error;

if (typeof console === "undefined" || !console) {
    console = {
        dir: function () { },
        log: function () { }
    };
}

(function ($) {
	// Override tooltip
	$( document ).tooltip({
      track: true
    });
	
    // Override BlockUI defaults
    $.extend(true, jQuery.blockUI.defaults, {
	    fadeOut:  200,
	    css: { border: 'none', backgroundColor: '#FFF' }, 
	    overlayCSS:  { backgroundColor: '#FFF', opacity: 0.5 }
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
	prompt = function(message, success, options) {
		options = typeof options !== 'undefined' ? options : { };
		
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
		
		var moremessage = options.note || null;
		moremessage = (moremessage == null ? "" : ("<br /><br />" + moremessage));
		
		var promptBox = $('#prompt');
		if (!promptBox.length) {
			promptBox = $('<div id="prompt">' + message + ' <input id="prompt-input" type="text" />' + moremessage + '</div>').hide().appendTo('body');		
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
	 * In-page button plugin for showing the example parameters files.
	 */
	
	exampleDialog = function(message, fileList, options) {
		options = typeof options !== 'undefined' ? options : { };
		fileList = fileList instanceof Array ? fileList : [];
	
		var creatList = function(parent, fileList){
			parent.append('<br/><ul id="exampleDialog-menu"></ul>');
			var ul = $("#exampleDialog-menu",parent);
			$('#exampleDialog-menu').on('click', 'li',function(){
				$.ajax({
				beforeSend: function(){ viewModels.sim.isLoading(true);},
				url: ROOT + "/readExampleFiles/"+MODEL_ID+"/"+$(this).text(),
				type: 'GET',
				success: function(data) {
					try {
						data = JSON.parse(data);
					} catch(err) { alert("Sorry. Fail to parse!");}
					if (data.success)
					{
						var params = viewModels.sim.loadParams(data.data);
						params.error += data.error.length;
					
						if (params.error == 0) {
							var msg = "File uploaded and parsed successfully!";	
						} else {
							var msg = "File uploaded successfully with " + params.error + " parameters using default value: <br /><br />";
							
							msg += "<blockquote>";
						
							if (data.error.length > 0) {
								$(data.error).each(function() {
									msg += "<li>";
									msg += this;
									msg += "</li>";									
								});
							
							}
							
							if (params.missing.length > 0) {
								msg += "<li>" + params.missing.length + " parameter(s) missing: ";
								msg += viewModels.sim.paramSelectList(params.missing, "missingParamList");
								msg += "</li>";
								
								// Switch to the tab of the first missing parameter
								viewModels.sim.paramSelect(params.missing[0], false);
							}
							if (params.extra.length > 0) {
								msg += "<li>" + params.extra.length + " extra parameter(s) detected: ";
								msg += viewModels.sim.paramSelectList(params.extra, "extraParamList"); 
								msg += "</li>";	
							}
							
							msg += "</blockquote>";
						
						}
						
						alert("<br />" + msg);
						
						$("#missingParamList").change(function() {
							viewModels.sim.paramSelect($(this).val());
						});
					}
					else
						alert(failUploadMsg);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
				}, 
				complete: function(){viewModels.sim.isLoading(false);}
				});
				$('#exampleBox').dialog("close");
			});
			for(var i=0; i<fileList.length; ++i)
			{
				var str = '<li><a href="#">'+fileList[i]+'</a></li>';
				ul.append(str);
			}
		}
		
		var exampleBox = $('#exampleBox');
		if (!exampleBox.length) {
			exampleBox = $('<div id="exampleBox">' + message + '</div>').hide().appendTo('body');
			creatList($('#exampleBox'), fileList)
		}
		$("#exampleDialog-menu").menu();
		exampleBox.dialog($.extend({}, exampleDialog.defaults, options));
	}
	
	exampleDialog.defaults = {
		resizable	: false,
		show		: 'fade',
		hide		: 'fade',
		position: [200,150],
		width		: 250,
		minHeight	: 200,
		maxHeight	: 300,
		dialogClass	: 'dialog-box prompt-box',
		title		: 'Example Library'
	};
	
	
		
	/** 
	 * In-page form submit plugin for file upload / download
	 */
	$.submit = function(options) {
		var opts = $.extend(true, {}, $.submit.defaults, options);
		
		//url option required
		if(opts.url) { 		
			//send request
			var iframe = $('iframe[name="fileupload"]');
			console.log(iframe);
			if(iframe.length == 0)
				iframe = $('<iframe name="fileupload" />').uniqueId().appendTo('body').hide();
				
			var target = iframe.attr('id');
			var form = $('<form name="uploadform" action="' + opts.url
				+ '" method="' + (opts.type||'post')
				+ '" target="' + "fileupload" //target
				+ '" enctype="multipart/form-data" />').appendTo('body').hide();
			
			var input = opts.input || null;
			if(input !== null) input.appendTo(form);
				
			if (opts.data) {
				$('<input type="hidden" name="data" />')
					.val(JSON.stringify(opts.data))
					.appendTo(form);
			}
			
			iframe.unbind('load').load(function() {
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

			form.submit();
			//form.appendTo('body').submit();
			//if (!opts.form) {
			//if(form)
			//	form.remove();		
			//}
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
