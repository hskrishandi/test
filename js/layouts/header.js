$(document).ready(function() {
    /*
     * Format the username when display, to prevent that the username is too long,
     * we fix the max length here and return the name.
     * Leon 20160511
     */
    String.prototype.formatUsername = function() {
        var length = 18;
        return this.length < length ? this : this.substr(0, length) + "...";
    };
    $.ajax({
        cache: false,
        type: "POST",
        url: CI_ROOT + 'account/isLogin',
        success: function(data) {
            if (data != "") {
                $('#logined-username').text(data.formatUsername());
                $('#logined-username-detail').text(data.formatUsername());
                $('#notlogined').hide();
                $('#logined').show();
            } else {
                $('#notlogined').show();
                $('#logined').hide();
            }
        }
    });
    $('#login-username').keypress(function(e) {
        if (e.which == 13) {
            $('#login-submit').click();
        }
    });
    $('#login-password').keypress(function(e) {
        if (e.which == 13) {
            $('#login-submit').click();
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
                        $('#logined-username').text(msg.formatUsername());
                        $('#logined-username-detail').text(msg.formatUsername());
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
    $('#register-submit').click(function() {
        var register = $.ajax({
            cache: false,
            type: "POST",
            url: CI_ROOT + 'account/create_submit',
            data: {
                first_name: $('#register-first_name').val(),
                last_name: $('#register-last_name').val(),
                displayname: $('#register-displayname').val(),
                organization: $('#register-organization').val(),
                position: $('#register-position').val(),
                address: $('#register-address').val(),
                tel: $('#register-tel').val(),
                fax: $('#register-fax').val(),
                email: $('#register-email').val(),
                password: $('#register-password').val(),
                retypepassword: $('#register-retypepassword').val()
            }
        });
        register.done(function(msg) {
            try {
                data = JSON && JSON.parse(msg) || $.parseJSON(msg);
                if (data.success) {
                    $('#register-first_name-group').removeClass('has-error');
                    $('#register-last_name-group').removeClass('has-error');
                    $('#register-displayname-group').removeClass('has-error');
                    $('#register-organization-group').removeClass('has-error');
                    $('#register-email-group').removeClass('has-error');
                    $('#register-password-group').removeClass('has-error');
                    $('#register-retypepassword-group').removeClass('has-error');
                    location.href = "account/createDone";
                } else {
                    $.each(data, function(key, value) {
                        if (key != "success" && value != "") {
                            $('#' + key).addClass('has-error');
                        } else {
                            $('#' + key).removeClass('has-error');
                        }
                        $('#' + key + ">input").focus(function() {
                            $('#' + key).removeClass('has-error');
                        });
                    });
                }
            } catch (e) {

            }
        });
        register.fail(function(jqXHR, textStatus) {
            alert(LogConnectionFailure)
        });
    });
    $('#login-username').focus(function() {
        $('#user-login-group').removeClass('has-error');
    });
    $('#login-password').focus(function() {
        $('#user-login-group').removeClass('has-error');
    });
});
