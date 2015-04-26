	$(document).ready(function(){
		$('.newPass #submit').click(function(){
				var newPassAJAX = $.ajax({
					cache: false,
					type: "POST",
					url: CI_ROOT+'account/newPass_en',
					data:{
							email: $('.email').val()
						 }					
				})
				newPassAJAX.done(function(msg){
					alert(newPassMsg);
					location.href = CI_ROOT;
				});
				newPassAJAX.fail(function(msg){
					alert(LogConnectionFailure);
				})
		});
	});