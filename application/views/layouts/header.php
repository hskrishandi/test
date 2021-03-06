<?php start_block_marker('header'); ?>
<div class="header">

    <div class="logo">
        <a href="<?php echo base_url(); ?>">
			<img src="<?php echo resource_url('img', 'home/Logo.png'); ?>" />
		</a>
    </div>

    <div class="menu">
        <ul>
            <li>
                <a href="<?php echo base_url('modelsim'); ?>">
                    <img class="menu-image" src="<?php echo resource_url('img', 'home/icon_ML.png'); ?>" />
                    <span class="menu-title">Model Library</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('txtsim'); ?>">
                    <img class="menu-image" src="<?php echo resource_url('img', 'home/icon_SP.png'); ?>" />
                    <span class="menu-title">Simulation Platform</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="submenu">
        <ul>
            <li>
                <div class="submenu-title-box">
                    <a id="sitemenu" class="submenu-title">Site Menu</a>
                </div>


                <ul id="sitemenu-box" class="submenu-box">
                    <li>
                        <a href="<?php echo base_url('news_event'); ?>">News and Events</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('discussion'); ?>">Discussion</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('documents'); ?>">Documents</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('resources'); ?>">Resources</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('activities'); ?>">Activities</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('contributors'); ?>">Contributors</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('developer'); ?>">Developers</a>
                    </li>
                </ul>

            </li>

            <li>
                <a class="separate-line"> &#x7c; </a>
            </li>

            <li>
                <a id="contact" class="submenu-title">Contact Us</a>

                <div id="contact-box" class="submenu-box contact-box">
                    <div class="contact-title">
                        <h1>Contact Us</h1>
                        <a id="contact-close">&times</a>
                        <div class="clearFloat"></div>
                    </div>

                    <div class="contact-content">
                        <p>
                            If you have any questions or suggestions concerning the i-MOS platform, you are welcome to contact us. For more general questions concerning compact modeling, you may register as a member and post the messages in the discussion and experience pages.
                        </p>
                    </div>

                    <div class="contact-info">
                        <h1>Send a Message</h1>
                        <div class="clearFloat">

                        </div>
                        <form class="form-horizontal" action="<?php echo base_url('contacts/submit')?>" method="post" >
                            <div class="form-group">
                                <label for="contactInputName" class="col-sm-2 control-label">Name<sup>*</sup></label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="contactInputName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactInputAffiliation" class="col-sm-2 control-label">Affiliation</label>
                                <div class="col-sm-10">
                                    <input type="text" name="aff" class="form-control" id="contactInputAffiliation" placeholder="Affiliation">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactInputEmail" class="col-sm-2 control-label">Email<sup>*</sup></label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" class="form-control" id="contactInputEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactInputSubject" class="col-sm-2 control-label">Subject<sup>*</sup></label>
                                <div class="col-sm-10">
                                    <input type="text" name="subject" class="form-control" id="contactInputSubject" placeholder="Subject">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactInputMessage" class="col-sm-2 control-label">Message<sup>*</sup></label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="msg" class="form-control" id="contactInputMessage" placeholder="Message" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </li>
        </ul>

    </div>

    <div id="user" class="user">
        <ul id="notlogined">
            <li>
                <a id="login" class="user-title">Login</a>
                <div id="login-box" class="login-box">
                    <div class="login-field">
                        <div class="login-box-title">
                            Login
                        </div>
                        <div id="login-progress" class="progress" style="display:none;">
                            <div id="login-progressbar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                <span class="sr-only">45%</span>
                            </div>
                        </div>
                        <!-- <form action="<?php echo base_url('account/login')?>" method="post" > -->
                            <div id="user-login-group" class="user-login-group">
                                <input id="login-username" type="email" name="email" class="form-control form-control-left" placeholder="Email">
                                <input id="login-password" type="password" name="pwd" class="form-control form-control-right" placeholder="Password">
                            </div>
                            <button id="login-submit" type="button" class="btn btn-default login-button">Login</button>
                            <div class="clearFloat"></div>
                        <!-- </form> -->
                    </div>
                    <div class="forget-field">
                        <div class="login-box-title">
                            Request New Password
                        </div>
                        <div class="login-box-description">
                            <small>Please enter your Email address to receive a new password.</small>
                        </div>
                        <!-- <form  action="<?php echo base_url('account/newPass_en')?>" method="post" > -->
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                            <button type="button" class="btn btn-default">Submit</button>
                            <div class="clearFloat"></div>
                        <!-- </form> -->
                    </div>
                </div>
            </li>

            <li>
                <a class="separate-line"> | </a>
            </li>

            <li>
                <a id="register" class="user-title">Register</a>
                <div id="register-box" class="register-box">
                    <div class="register-title">
                        Registration
                    </div>
                    <div class="register-info">
                        <form>
                            <div class="register-info-title">
                                Personal Information
                            </div>
                            <div class="register-name-group">
                                <div id="register-first_name-group">
                                    <input id="register-first_name" type="text" name="first_name" class="form-control form-control-left" placeholder="First Name*">
                                </div>
                                <div id="register-last_name-group">
                                    <input id="register-last_name" type="text" name="last_name" class="form-control form-control-right" placeholder="Last Name*">
                                </div>
                            </div>
                            <div id="register-displayname-group">
                                <input id="register-displayname" type="text" name="displayname" class="form-control" placeholder="Display Name*">
                            </div>
                            <div id="register-organization-group">
                                <input id="register-organization" type="text" name="organization" class="form-control" placeholder="Company*">
                            </div>
                            <div class="register-position-group">
                                <input id="register-position" type="text" name="position" class="form-control" placeholder="Position Title">
                            </div>
                            <div class="register-address-group">
                                <input id="register-address" type="text" name="address" class="form-control" placeholder="Address">
                            </div>
                            <div class="register-contact-group">
                                <input id="register-tel" type="text" name="tel" class="form-control form-control-left" placeholder="Telephone">
                                <input id="register-fax" type="text" name="fax" class="form-control form-control-right" placeholder="Fax">
                            </div>
                            <div class="register-info-title">
                                Account Information
                            </div>
                            <div id="register-email-group">
                                <input id="register-email" type="text" name="email" class="form-control" placeholder="Email Address*">
                            </div>
                            <div class="register-info-description">
                                The EMAIL ADDRESS is for log-in use. Please make sure the EMAIL ADDRESS is correct.
                            </div>
                            <div id="register-password-group">
                                <input id="register-password" type="password" name="password" class="form-control" placeholder="Password*">
                                <input id="register-retypepassword" type="password" name="retypepassword" class="form-control" placeholder="Retype Password*">
                                <div class="register-info-description">
                                    At least 6 charaters or numbers are required.
                                </div>
                            </div>

                            <button id="register-submit" type="button" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
        <ul id="logined" class="logined">
            <li>
                <a id="logined-username" class="user-title"></a>
                <div id="logined-user-box" class="user-box">
                    <div class="welcome-login">
                        You are login as:
                        <div id="logined-username-detail" unselectable="on" style="-moz-user-select:none;" onselectstart="return false;"></div>
                    </div>
                    <div class="user-menu">
                        <ul>
                            <li>
                                <a href="<?php echo base_url('account/infoUpdate')?>">Update Account</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('account/changePass')?>">Change Password</a>
                            </li>
                            <li>
                                <a id="logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                    <div class="clearFloat"></div>
                    <div id="logout-progress" class="progress"  style="display:none;margin-top:20px;">
                        <div id="logout-progressbar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                            <span class="sr-only">0%</span>
                        </div>
                    </div>
                </div>

            </li>
        </ul>
        <img class="userlogo" src="<?php echo resource_url('img', 'icons/userIcon_white_large.png'); ?>" />
    </div>

    <div class="search">
        <form  accept-charset="UTF-8" id="searchForm" method="get" action="<?php echo base_url('search') ?>">
            <img src="<?php echo resource_url('img', 'icons/searchIcon.svg'); ?>" />
            <input type="text" maxlength="128" value="<?php echo htmlspecialchars($this->input->get('q', TRUE)); ?>" placeholder="Search" name="q"></input>
        </form>
    </div>
</div>
<div class="header-placeholder"></div>

<script type="text/javascript">
    $("#sitemenu").click(function() {
        $("#sitemenu-box").toggle();
        $("#contact-box").hide();
        $("#login-box").hide();
        $("#register-box").hide();
        $("#logined-user-box").hide();
    });
    $("#contact").click(function() {
        $("#contact-box").toggle();
        $("#sitemenu-box").hide();
        $("#login-box").hide();
        $("#register-box").hide();
        $("#logined-user-box").hide();
    });
    $("#contact-close").click(function() {
        $("#contact-box").hide();
    });
    $("#login").click(function() {
        $("#login-box").toggle();
        $("#sitemenu-box").hide();
        $("#contact-box").hide();
        $("#register-box").hide();
        $("#logined-user-box").hide();
    });
    $("#register").click(function() {
        $("#register-box").toggle();
        $("#login-box").hide();
        $("#sitemenu-box").hide();
        $("#contact-box").hide();
        $("#logined-user-box").hide();
    });
    $("#logined-username").click(function() {
        $("#logined-user-box").toggle();
        $("#sitemenu-box").hide();
        $("#contact-box").hide();
        $("#login-box").hide();
        $("#register-box").hide();
    });
    $("a").attr({
         'unselectable': 'on',
         'style': '-moz-user-select:none;',
         'onselectstart': 'return false;'
    });
    var RecaptchaOptions = {
        lang : 'fr',
        theme : 'white'
    };
    /**
     * Solve the position fixed problem.
     * When scroll horizontally, makes the header scroll as well.
     */
    $(window).scroll(function(){
            $('.header').css('left', 0 - $(this).scrollLeft());
    });
</script>
<?php end_block_marker(); ?>
