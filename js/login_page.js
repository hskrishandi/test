	
	$(document).ready(function(){
		$('div.auth_err #login-password').keypress(function(e) {
			if(e.which == 13)
				$('div.auth_err #login-submit').click();
			});
		$('div.auth_err #login-submit').click(function(){
			$('.auth_err #login-name').removeClass("redborder");
			$('.auth_err #login-password').removeClass("redborder");
			if($('.auth_err #login-name').val() == "" || $('.auth_err #login-password').val() == ""){
				alert(LogInBlankEmailPass);
				if($('.auth_err #login-name').val() == ""){
					$('.auth_err #login-name').addClass("redborder");
				}
				if($('.auth_err #login-password').val() == ""){
					$('.auth_err #login-password').addClass("redborder");
				}
			}else{
				var login = $.ajax({
					cache: false,
					type: "POST",
					url: CI_ROOT+'account/login',
					data:{email: $('.auth_err #login-name').val(), pwd: $('.auth_err #login-password').val()}
				})
				login.done(function(msg){
					//$('#block-user-login').html(msg);
					//console.log(msg);
					if (msg.indexOf("ok") >= 0){						
						window.location = CI_ROOT+'account/authErrLoad';
					} else if(msg.indexOf("noactive") >= 0){
						//console.debug("Account No actived");
						alert(LogInAccInActMsg);
					} else if(msg.indexOf("noaccpass") >= 0){
						//console.debug("Login / Pass err");
						$('.auth_err #login-name').addClass("redborder");
						$('.auth_err #login-password').addClass("redborder");
						alert(LogInEmailPassErrMsg);
						
					}
				});
				login.fail(function(jqXHR, textStatus){
					//$('#block-user').html(msg);
					//console.debug(textStatus);
					alert(LogConnectionFailure)
				});
			}
			
		});

	});	
