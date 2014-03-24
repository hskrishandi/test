// Useful utility functions

/**
 * Override javascript alert() and wrap it into a jQuery-UI Dialog box
 *
 * @param { String } the alert message
 * @param { jQuery Object } jQuery selector target to be blocked (optional)
 * @param { Object } jQuery Dialog box options (optional)
 */
function alert(message, target, options) { 
	var defaults = {
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
		dialogClass	: 'alert-box',
		title		: 'Alert'
	};
	
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
	 	alertBox = $('<div id="alert"><div class="alert-icon"></div></div>').hide().appendTo('body');		
	}

	$("div", alertBox).html(message);	
	
	alertBox.dialog($.extend({}, defaults, options, events));
}

/**
 * Override javascript confirm() and wrap it into a jQuery-UI Dialog box
 *
 * @param { String } the confirm message
 * @param { Function (boolean confirm) } the callback function when confirmed / canceled
 * @param { jQuery Object } jQuery selector target to be blocked (optional)
 * @param { Object } jQuery Dialog box options (optional)
 */
function confirm(message, callback, target, options) {
	var defaults = {
		modal		: true,
		resizable	: false,
		buttons		: {
			Confirm : function() {
				callback(true);
				$(this).dialog('close');
			},
			Cancel : function() {
				callback(false);
				$(this).dialog('close');
			}
		},
		show		: 'fade',
		hide		: 'fade',
		width		: 400,
		minHeight	: 150,
		dialogClass	: 'alert-box prompt-box',
		title		: 'Confirmation'
	};
	
	var confirmBox = $('#confirm');
	if (!confirmBox.length) {
	 	confirmBox = $('<div id="confirm"><div class="alert-icon"></div></div>').hide().appendTo('body');		
	}

	$("div", confirmBox).html(message);	
	
	confirmBox.dialog($.extend({}, defaults, options));
}

// Export the Cookie plugin
var Cookie = {};

(function($) {

/* Cookie plugin */

Cookie.get = function(name) {
	var i, x, y, cookies=document.cookie.split(";");

	for (i=0; i<cookies.length; i++) {
  		x = cookies[i].substr(0,cookies[i].indexOf("="));
 		y = cookies[i].substr(cookies[i].indexOf("=")+1);
		x = x.replace(/^\s+|\s+$/g,"");
		if (x == name){
			return unescape(y);
		}
	}
}

Cookie.set = function(name, value, exdays) {	
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value = escape(value) + (!exdays ? "" : "; expires=" + exdate.toUTCString());
	document.cookie=name + "=" + c_value;
}

/* Persistent user input plugin */
$.fn.cookie = function(method, options) { 
	var fx = {
		saveForm: function(prefix) {
			var excluded = this.find('.no-cookie');
			var data = this.serializeArray();
			var formData = {};				
			for (var i = 0; i < data.length; ++i) {
				if (excluded.has(':input[name="'+data[i].name+'"]').length) continue;
				if (formData[data[i].name]) {
					formData[data[i].name].push(data[i].value);
				} else {
					if (data[i].name.search(/\[\]/i) >= 0) {
						formData[data[i].name] = [data[i].value];
					} else {
						formData[data[i].name] = data[i].value;
					}
				}
			}
			Cookie.set(prefix+this.attr("id")+"f", JSON.stringify(formData));
			return this;
		},
		restoreForm: function(prefix) {
			var data = Cookie.get(prefix+this.attr("id")+"f");			
			if (data) {
				data = JSON.parse(data);
				for (var key in data) {
					this.find('[name="'+key+'"]').val(data[key]).change();
				}
			}			
			return this;
		},
		saveTab: function(prefix) {
			Cookie.set(prefix+this.attr("id")+"t", this.tabs('option', 'selected'));			
			return this;
		},
		restoreTab: function(prefix) {
			var index = parseInt(Cookie.get(prefix+this.attr("id")+"t"));			
			if (index) {
				this.tabs('select', index);
			}
			return this;
		}
	}; 
	
	if (fx[method]) {
		fx[method].call(this, options);
	} 
	
	return this;
};

/* input submit plugin (via forms) */
jQuery.submit = function(url, inputs, method, target, callback) {
	//url and inputs options required
	if( url && inputs ) { 		
		//send request
		$('<form action="'+ url +'" method="'+ (method||'post') +'" '+ (target? 'target="'+target+'"' : "") +' enctype="multipart/form-data"></form>')
		.append(inputs).appendTo('body').submit().remove();
		
		if (target && $.isFunction(callback)) {
			$('iframe[name='+target+']').load(function() {
				var result;
				try {
					result = JSON.parse($(this).contents().text());
				} catch (err) {
					result = {
						success: false,
						result: "The server has returned an invalid response. Please try again later."
					};
				}
				callback(result);
			});
		}
	}
};

})(jQuery);
