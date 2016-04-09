$(document).ready(function() {
    $.ajax({
        cache: false,
        type: "POST",
        url: CI_ROOT + 'account/isLogin',
        success: function(data) {
            if (data != "") {
                $('#logined-username').text(data);
                $('#logined-username-detail').text(data);
                $('#notlogined').hide();
                $('#logined').show();
            } else {
                $('#notlogined').show();
                $('#logined').hide();
            }
        }
    });
    $('#login-submit').click(function() {

        $('#login-progress').show();
        $('#login-progressbar').width('80%');

        setTimeout(function() {
            var login = $.ajax({
                cache: false,
                type: "POST",
                url: CI_ROOT + 'account/login',
                data: {
                    email: $('#login-username').val(),
                    pwd: $('#login-password').val()
                }
            });
            login.done(function(msg) {
                $('#login-progressbar').width('100%');
                setTimeout(function() {
                    if (msg.indexOf("noactive") >= 0) {
                        alert(LogInAccInActMsg);
                    } else if (msg.indexOf("noaccpass") >= 0) {
                        alert(LogInEmailPassErrMsg);
                        $('#user-login-group').addClass('has-error');
                    } else {
                        $('#logined-username').text(msg);
                        $('#logined-username-detail').text(msg);
                        $('#notlogined').hide();
                        $('#logined').show();
                    }
                    $('#login-progressbar').width('0%');
                    $('#login-progress').hide();
                }, 600);
            });
            login.fail(function(jqXHR, textStatus) {
                alert(LogConnectionFailure)
            });
        }, 600);
    });
    $('#logout').click(function() {
        $('#logout-progress').show();
        $('#logout-progressbar').width('100%');
        setTimeout(function() {
            var logout = $.ajax({
                cache: false,
                type: "POST",
                url: CI_ROOT + 'account/logout'
            });
            logout.done(function(msg) {
                $('#logined-username').text();
                $('#logined-username-detail').text();
                $('#notlogined').show();
                $('#logined').hide();
                $('#logout-progressbar').width('0%');
                $('#logout-progress').hide();
            });
            logout.fail(function(jqXHR, textStatus) {
                //$('#block-user').html(msg);
                //console.debug(textStatus);
                alert(LogConnectionFailure);
            });
        }, 800);
    });
    $('#login-username').focus(function() {
        $('#user-login-group').removeClass('has-error');
    });
    $('#login-password').focus(function() {
        $('#user-login-group').removeClass('has-error');
    });
});