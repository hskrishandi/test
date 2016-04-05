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
            if (msg.indexOf("noactive") >= 0) {
                alert(LogInAccInActMsg);
            } else if (msg.indexOf("noaccpass") >= 0) {
                alert(LogInEmailPassErrMsg);
            } else {
                $('#logined-username').text(msg);
                $('#logined-username-detail').text(msg);
                $('#notlogined').hide();
                $('#logined').show();
            }
        });
        login.fail(function(jqXHR, textStatus) {
            alert(LogConnectionFailure)
        });
    });
    $('#logout').click(function() {
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
        });
        logout.fail(function(jqXHR, textStatus) {
            //$('#block-user').html(msg);
            //console.debug(textStatus);
            alert(LogConnectionFailure);
        });
    });
});
