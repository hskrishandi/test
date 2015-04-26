	$(document).ready(function(){
		refreshLogin = function(){
			//$('#block-user').html("<div>Loading</div>");
			$.ajax({
			  cache: false,
			  url: CI_ROOT+'account/login_block',
			  success: function(data) {
				$('#block-user').html(data);
					$('#block-user-login #login-password').keypress(function(e) {
						if(e.which == 13)
							$('#block-user-login #login-submit').click();
					});
					$('#block-user-login #login-submit').click(function(){
						$('#block-user-login #login-name').removeClass("redborder");
						$('#block-user-login #login-password').removeClass("redborder");
						if($('#block-user-login #login-name').val() == "" || $('#block-user-login #login-password').val() == ""){
							alert(LogInBlankEmailPass);
							if($('#block-user-login #login-name').val() == ""){
								$('#block-user-login #login-name').addClass("redborder");
							}
							if($('#block-user-login #login-password').val() == ""){
								$('#block-user-login #login-password').addClass("redborder");
							}
						}else{
							var login = $.ajax({
								cache: false,
								type: "POST",
								url: CI_ROOT+'account/login',
								data:{email: $('#block-user-login #login-name').val(), pwd: $('#block-user-login #login-password').val()}
							})
							login.done(function(msg){
								//$('#block-user-login').html(msg);
								//console.log(msg);
								if (msg.indexOf("ok") >= 0){
									//refreshLogin()					
									var patt=/authErr/i;
									//console.log("123"+location.pathname);
									if (patt.test(location.pathname)){
										location.replace(CI_ROOT);
									}else{
										location.reload();
									}
									//console.log("log");
								} else if(msg.indexOf("noactive") >= 0){
								//	console.debug("Account No actived");
									alert(LogInAccInActMsg);
								} else if(msg.indexOf("noaccpass") >= 0){
								//	console.debug("Login / Pass err");
									$('#block-user-login #login-name').addClass("redborder");
									$('#block-user-login #login-password').addClass("redborder");
									alert(LogInEmailPassErrMsg);
									
								}
							});
							login.fail(function(jqXHR, textStatus){
								//$('#block-user').html(msg);
								//console.debug(textStatus);
								alert(LogConnectionFailure)
							});
						}
						//refreshLogin();
					})
					$('.account_logout').click(function(){
						var logout = $.ajax({
								cache: false,
								type: "POST",
								url: CI_ROOT+'account/logout'
							});
						logout.done(function(msg){
							$('#block-user').html("Logout Succeed.").delay(3000);
							//console.log(msg);
							var t = setTimeout("refreshLogin()",0);
							location.reload();
						});
						logout.fail(function(jqXHR, textStatus){
							//$('#block-user').html(msg);
							//console.debug(textStatus);
							alert(LogConnectionFailure);
						});
					});
					/*
					$('#login-block-user li').hover(
					function(){$(this).addClass('hightlight')},
					function(){$(this).removeClass('hightlight')}
					)
					*/
				}
		})
	}
	
	refreshLogin();
	
	});	
