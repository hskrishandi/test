// Script for developer form

 var ROOT = CI_ROOT + "developer";
 var USER_ID = 1001;

(function ($) {
	ProgressModel =  function() {
		var self = this;
		self.models_info = ko.observableArray([]);
		self.init = function() {
			$.ajax({
				url: ROOT + "/modelsInProgressInfo",
				type: 'GET',
				success: function(result) {
					try{
						result = JSON.parse(result);
					} catch(err) {console.log("Parse Failed");}
					for(var i=0;i<result.length;i++)
					{
						 self.models_info.push({
						 	user_name: ko.observable(result[i].user_name),
							stage: ko.observable(result[i].stage*100/3.0),
							progressbar_id: ko.observable('progressbar'+i),
							model_name: ko.observable(result[i].model_name),
							description: ko.observable(result[i].description)
						 });
					}
					for(var i=0;i<result.length;i++)
					{
						$("#progressbar"+i).progressbar({value:self.models_info()[i].stage()});
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
	viewModels = new ProgressModel();
	viewModels.init();
	ko.applyBindings(viewModels,$("#progress-page")[0]);
	
	$("#newModel").click(function(){
		//window.location = ROOT+"/tos/0";
		$("<form method='get' action='"+ROOT+"/tos'><input type='hidden' name='model_id' value='0' /></form>").submit();
		/*$.ajax({
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
			});*/
	});
	$("#update").click(function(){window.location=ROOT+"/user_models";})
	
	
});

