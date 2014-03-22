// Script for developer form

 var ROOT = CI_ROOT + "developer";
 var USER_ID = 1005;

(function ($) {
	FormModel =  function() {
		var self = this;
		self.formDataStatus = ko.observable({
			title					: ko.observable(''),
			author_list		: ko.observable(''),
			organization	: ko.observable(''),
			contact				: ko.observable(''),
			description		: ko.observable(''),
			reference			: ko.observable(''),
			pre_simulator : ko.observable(''),
			is_author			: ko.observable(''),
			has_tested		: ko.observable(''),
			can_contacted : ko.observable(''),
			structure			: ko.observable(false),
			model_code		: ko.observable(false),
			parameter_list: ko.observable(false),
			output_list		: ko.observable(false)
			});
		self.authorList = ko.observable();
		self.clearFormDataStatus = function(){
			self.formDataStatus = ko.observable({
			title					: ko.observable(''),
			author_list		: ko.observable(''),
			organization	: ko.observable(''),
			contact				: ko.observable(''),
			description		: ko.observable(''),
			reference			: ko.observable(''),
			pre_simulator : ko.observable(''),
			is_author			: ko.observable(''),
			has_tested		: ko.observable(''),
			can_contacted : ko.observable(''),
			structure			: ko.observable(false),
			model_code		: ko.observable(false),
			parameter_list: ko.observable(false),
			output_list		: ko.observable(false)
			});
		};
	
		self.init = function() {
			$.ajax({
				url: ROOT + "/loadSavedModelInfo/" + USER_ID,
				type: 'GET',
				success: function(result) {
					try{
						result = JSON.parse(result);
					} catch(err) {alert("Parse Failed");}
					if(!result.fieldname || !result.value || result.fieldname.length != result.value.length)
					{}	//load nothing
					else
					{
						for(var i=0;i<result.fieldname.length;i++)
						{
							self.formDataStatus()[result.fieldname[i]](result.value[i]);
						}
					}
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
	ko.applyBindings(viewModels,$("#developer_form")[0]);
	var isUploading = false;
	var current_page = 0;
	var forms = $("#developer .form-page");
	var back = $("<a class='back'>Back</a>");
	//var save = $("<a class='save'>Save</a>");
	var next = $("<a class='next'>Save and Next</a>"), submit = $("<a class='next'>Submit</a>");
	forms.addClass("hidden")
		 .eq(0).removeClass("hidden");
	next.appendTo("#developer .form-page:not(:last)")
		.click(function() {
		isUploading = true;
		var stayOnCurrentPage = false;
		var formData = new FormData($("form#developer_form")[0]);
		viewModels.clearFormDataStatus();
		$.ajax({
				url: ROOT + "/submit/step"+(current_page+1),
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(result) {
					try {
						result = JSON.parse(result);
					} catch(err) { }
					if(!result.success){
						stayOnCurrentPage = true;
						$('.error_show').removeClass('error_show').addClass('error');
						if(result.error_info){
							$.each(result.error_info,function(key,value){
								if(value && value != ''){
									$('#'+key+'_error').text(value).removeClass('error').addClass('error_show');
								}
								else{
									$('#'+key+'_error').text('').removeClass('error_show').addClass('error');
								}
							});
						}
						
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
					console.log("Response data: " + jqXHR.responseText);
				},
				complete: function(){
					isUploading = false;
					if(!stayOnCurrentPage){
						forms.eq(current_page).addClass("hidden");
						forms.eq(++current_page).removeClass("hidden");
					}
				}
			});
	});
	submit.appendTo("#developer .form-page:last")
		  .click(function() {
		current_page = 0;
		$("#developer form").submit();		
	});
//	save.appendTo("#developer .form-page")
//		.click(function() {
//	});
	back.appendTo("#developer .form-page:not(:first)")
		.click(function() {
		forms.eq(current_page).addClass("hidden");
		forms.eq(--current_page).removeClass("hidden");
	});
});

