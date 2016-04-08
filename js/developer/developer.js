// Script for developer form

 var ROOT = CI_ROOT + "developer";
 var MODEL_ID = window.location.href.split('/').pop();
 if(!$.isNumeric(MODEL_ID)) MODEL_ID = 0;

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
				url: ROOT + "/loadSavedModelInfo/" + MODEL_ID,
				type: 'GET',
				success: function(result) {
					try{
						result = JSON.parse(result);
					} catch(err) {console.log("Parse Failed");}
					if(!result.fieldname || !result.value || result.fieldname.length != result.value.length)
					{}	//load nothing
					else
					{
						for(var i=0;i<result.fieldname.length;i++)
						{
							if(result.fieldname[i] == 'model_id') continue;
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
	var forms = $("#developer .form-page .labels");
	var nextStepNum =2;
	//var save = $("<a class='save'>Save</a>");
	
	forms.addClass("hidden")
		 .eq(0).removeClass("hidden");	
	for(var nextStepNum=2;nextStepNum<5;nextStepNum++){
		var next = $("<a class='next nextsubmit' >Save and go to Step "+nextStepNum+"</a>"), submit = $("<a class='submitModelBut nextsubmit'>Submit Model</a>");
		switch(nextStepNum){
			case 2: 
			next.appendTo("#developer #page1 .labels");
			break;
			case 3:
			next.appendTo("#developer #page2 .labels");
			break;
			case 4:
			next.appendTo("#developer #page3 .labels");
			break;
		}
	}
	

	submit.appendTo("#developer .form-page:last .submit_area");
	var nextButton = $(".next");
	
	var submitButton = $(".nextsubmit");

	submitButton.click(function() {
		if (MODEL_ID == null) MODEL_ID=window.location.href.split('/').pop();
		$('.error_show').removeClass('error_show').addClass('error');
		isUploading = true;
		var stayOnCurrentPage = false;
		var formData = new FormData($("form#developer_form")[0]);
		formData.append('model_id',MODEL_ID);
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
						if(MODEL_ID == 0){
					 		MODEL_ID = result.model_id;
							console.log(result.model_id);
					 	}
						if(!result.success){
							stayOnCurrentPage = true;
							var hasError = [];
							if(result.error_info){
								$(".alert_button").addClass("hidden");
								$.each(result.error_info,function(step,element){
									$.each(element,function(key,value){
										if(value && value != ''){
											$('#'+key+'_error').text(value).removeClass('error').addClass('error_show');
											hasError[step] = true;
										}
									});
								if(hasError[step] && current_page+1 == 4){
									 $("#"+step+"_alert").removeClass("hidden").addClass("show").click(function(){
											
											$("#validation_alert").dialog("close");
											});
									 $("#validation_alert").dialog( "open" );
								 }
								});
							}
						}
						else if(current_page+1==4){
							window.location = ROOT;
						}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
					console.log("Response data: " + jqXHR.responseText);
				},
				complete: function(){
					isUploading = false;
					if(!stayOnCurrentPage){
					forms.eq(++current_page).removeClass("hidden");
					}
				}
			});
	});

//	save.appendTo("#developer .form-page")
//		.click(function() {

	$("#validation_alert").dialog({
		autoOpen: false,
		height: 150,
		width: 300,
		show: 'fade',
		hide: 'fade',
		title: 'Incomplete',
		dialogClass	: 'dialog-box alert-box'
	});

	/*
		Function By Grace 20160405
		display the file name that user uploaded

	*/
	$('input[type=file]').each(function(){
		$(this).change(function(){
			
			readURL(this);
			var filename=$(this).val().split(/(\\|\/)/g).pop();
			if($(this).parent().parent().find('.uploaded').is('.previewFileName')){
				$(this).parent().parent().find('.uploaded').html(filename);
				readURL(this);	
			}
			else{
				$(this).parent().parent().find('.uploaded').html('File "'+filename+'" successfully uploaded');
			}
			
		});
		
	});

	/*
		Function by Grace 20160408
		for image preview
	*/
	function readURL(input){
		 if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            $('#imagePreview').html("<div>test</div");
            reader.readAsDataURL(input.files[0]);
        }

	}
});

