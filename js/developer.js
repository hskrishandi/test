// Script for developer form

 var ROOT = CI_ROOT + "developer";
 var USER_ID = 1001;

(function ($) {
	FormModel =  function() {
		var self = this;
		self.title = ko.observable("hello");
		//self.formData = ko.observable();
		self.authorList = ko.observable();
//		self.organization = ko.observable();
//		self.contact = ko.observable();
//		self.description = ko.observable();
//		a = [{name: "reference",value:"aaa"}];
//		self[a[0].name] = ko.observable(a[0].value);
		self.init = function() {
			$.ajax({
				url: ROOT + "/formData/" + USER_ID,
				type: 'GET',
				success: function(result) {
					try{
						result = JSON.parse(result);
					} catch(err) {alert("Parse Failed");}
					//self.formData = new FormModel.FormDataModel(result);
					self.title(result.title);
					self.authorList(result.authorList);
				},
				error: function(errorThrown) {
					console.log("Error:"+errorThrown);
				}
			});
		};
	};
	
	FormModel.FormDataModel = function(data) {
 		var that = this;
		that.title = ko.observable(data.title);
		that.authorList = ko.observable(data.authorList);
 	};

 
} (jQuery));

$(document).ready(function($) {
	viewModels = new FormModel();
	viewModels.init();
	ko.applyBindings(viewModels,$("#developer .form-page")[0]);
	var current_page = 0;
	var forms = $("#developer .form-page");
	var back = $("<a class='back'>Back</a>"), save = $("<a class='save'>Save</a>");
	var next = $("<a class='next'>Next</a>"), submit = $("<a class='next'>Submit</a>");
	forms.addClass("hidden")
		 .eq(0).removeClass("hidden");
	next.appendTo("#developer .form-page:not(:last)")
		.click(function() {
		forms.eq(current_page).addClass("hidden");
		forms.eq(++current_page).removeClass("hidden");
	});
	submit.appendTo("#developer .form-page:last")
		  .click(function() {
		current_page = 0;
		$("#developer form").submit();		
	});
	save.appendTo("#developer .form-page")
		.click(function() {
	});
	back.appendTo("#developer .form-page:not(:first)")
		.click(function() {
		forms.eq(current_page).addClass("hidden");
		forms.eq(--current_page).removeClass("hidden");
	});
});

