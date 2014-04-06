// Script for developer form

 var ROOT = CI_ROOT + "developer";
 var USER_ID = 1001;

(function ($) {
	UserUploadModel =  function() {
		var self = this;
		self.models_info = {
			complete:ko.observableArray([]),
			incomplete:ko.observableArray([])
			};
		self.init = function() {
			$.ajax({
				url: ROOT + "/loadUserModelList",
				type: 'GET',
				success: function(result) {
					try{
						result = JSON.parse(result);
					} catch(err) {console.log("Parse Failed");}
					for(var i=0;i<result.complete.length;i++)
					{
						 self.models_info.complete.push({
						 		model_id: ko.observable(result.complete[i].id),
								model_name: ko.observable(result.complete[i].model_name),
								last_update_time: ko.observable(result.complete[i].last_update_time)
						 });
					}
					for(var i=0;i<result.incomplete.length;i++)
					{
						 self.models_info.incomplete.push({
						 		model_id: ko.observable(result.incomplete[i].id),
								model_name: ko.observable(result.incomplete[i].model_name),
								last_update_time: ko.observable(result.incomplete[i].last_update_time)
						 });
					}
					if(result.incomplete.length > 0){
						$(".update_button").click(function(){
							$model_id = $(this).attr('id');
							$("<form method='get' action='"+ROOT+"/tos'><input type='hidden' name='model_id' value='"+$model_id+"' /></form>").submit();
							/*$.ajax({
										 url: ROOT + "/loadUserModelList",
										 type: 'POST',
										 success: function(result) {},
										 error: function(errorThrown) {console.log("Error:"+errorThrown);}
							});*/
							});
						$(".delete_button").click(function(){
							if(confirm("Do you want to delete this model?")){
								$model_id = $(this).attr('id');
								$.ajax({
									url: ROOT + "/deleteModel/"+$model_id,
									type: 'POST',
									success: function(result){},
									complete: function(){
										window.location = ROOT + "/user_models";
									}
								});
							}
						});
					}
					else{
						$("#new_model_button").click(function(){
							$("<form method='get' action='"+ROOT+"/tos'><input type='hidden' name='model_id' value='0' /></form>").submit();
						})
					}
				},
				error: function(errorThrown) {
					console.log("Error:"+errorThrown);
				}
			});
		};
	};
	
} (jQuery));

$(document).ready(function($) {
	viewModels = new UserUploadModel();
	viewModels.init();
	ko.applyBindings(viewModels,$("#user_models")[0]);
	/*
	$("#newModel").click(function(){
		$.ajax({
				url: ROOT + "/checkSaved/",
				type: 'POST',
				data: {},
				success: function(result) {
					try {
						result = JSON.parse(result);
					} catch(err) { }
					if(result.hasSavedData){
						if(confirm("You have an incompleted model, do you want to resatart?"))
						{
							 $.ajax({
										url: ROOT + "/deleteSavedData/",
										type: 'POST',
										data: {},
										success: function(result){
											window.location=ROOT+"/tos";
										}
										});
						}
						else{}
					}
					else{window.location=ROOT+"/tos";}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("Error: " + textStatus + "; " + errorThrown);
				},
				complete: function(){
				}
			});
	});
	$("#update").click(function(){window.location=ROOT+"/user_models";})
	*/
	
});

