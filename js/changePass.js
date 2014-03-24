	$(document).ready(function(){
		$('.new_pass, .new_pass_re').keyup(function(){
			if($('.new_pass').val() == $('.new_pass_re').val()){
				$('.error').html('&nbsp');
			}else{
				$('.error').html('The New Password and Retype New Password must be same.');
			}
		})
		$('.change_pass #submit').click(function(){
			if($('.new_pass').val() == $('.new_pass_re').val()){
				if ($('.email').val() == "" || $('.old_pass').val() == ""){
					alert('Please enter E-mail and old password.');
					return;
				};
				if ($('.new_pass').val() == ""){
					alert('Please enter the new password.');
					return;
				};
				var changePass = $.ajax({
					cache: false,
					type: "POST",
					url: CI_ROOT+'account/changePass_en',
					data:{
							email: $('.email').val(),
							newpass: $('.new_pass').val(),
							oldpass: $('.old_pass').val()
						 }					
				})
				changePass.done(function(msg){
					if(msg.indexOf("ok") >= 0){
						alert(changePassSuccess);
					}else{
						alert(LogInEmailPassErrMsg);
					}
				})
			}
		});
	});