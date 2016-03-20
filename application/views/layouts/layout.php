<?php echo doctype('html5') ?>
<html>

<?php
$menu_items = array(
    'News and Events' => base_url('news'),
    'Discussion' => base_url('discussion'),
    'Documents' => base_url('documents'),
    'Resources' => base_url('resources'),
    'Contributiors' => base_url('contributors'),
    'Developers' => base_url('developer')
);
?>

    <head>
        <?php $this->load->view('layouts/meta'); ?>
        <?php $this->load->view('layouts/title'); ?>
        <?php $this->load->view('layouts/css'); ?>
        <?php $this->load->view('layouts/javascript'); ?>
    </head>

    <body>

        <div id="page">

            <!-- MenuBar - Start -->
            <div id="MenuBar">
                <?php start_block_marker('MenuBar'); ?>
                <a href="<?php echo base_url(); ?>">
                    <img id="logo" src="<?php echo resource_url('img', 'home/Logo.png'); ?>" />
                </a>

                <div id="Applications">
                    <a class="ApplicationButton" href="<?php echo base_url('modelsim'); ?>">
                        <img class="ApplicationIcon" src="<?php echo resource_url('img', 'home/icon_ML.png'); ?>" />
                        <p class="ApplicationName">
                            Model Library
                        </p>
                    </a>
                    <a class="ApplicationButton" href="<?php echo base_url('txtsim'); ?>">
                        <img class="ApplicationIcon" src="<?php echo resource_url('img', 'home/icon_SP.png'); ?>" />
                        <p class="ApplicationName">
                            Simulation Platform
                        </p>
                    </a>
                </div>

                <a id="SiteMenu" class="MenuButton" href="#">
                    <p>
                        Site Menu
                    </p>
                </a>
                <p class="separateLine">
                    &#x7c;
                </p>
                <a id="ContactUs" class="MenuButton" href="#">
                    <p>
                        Contact Us
                    </p>
                </a>

                <div id="SearchBox">
                    <form accept-charset="UTF-8" id="searchForm" method="get" action="<?php echo base_url('search') ?>">
                        <div id="searchFormGroup">
                            <input id="searchTextInput" type="text" maxlength="128" value="<?php echo htmlspecialchars($this->input->get('q', TRUE)); ?>" placeholder="Search" name="q"></input>
                        </div>
                    </form>
                </div>

                <a id="UserBox" class="clearfix" href="#">
                    <div id="UserIcon"></div>
                    <p id="UserName">Login</p>
                </a>

            </div>

            <!-- MenuDropDowns - Start -->
            <div id="MenuItemsBox" class="MenuDropDown" style="display:none;">
                <ul>
                    <?php foreach ($menu_items as $title => $url) : ?>
                    <il>
                        <a href="<?php echo $url; ?>">
                            <?php echo $title; ?>
                        </a>
                    </il>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php $this->load->view('menubar_contactbox'); ?>

            <div id="block-user" class="MenuDropDown" style="display:none;"></div>
            <!-- MenuDropDowns - End -->

            <?php end_block_marker(); ?>

            <!-- MenuBar - End -->

            <div id="main_content">
                <?php start_block_marker('main_content'); ?>
                <?php end_block_marker(); ?>

                <!--div id="side_menu">
			<//?php start_block_marker('side_menu'); ?>
			<//?php end_block_marker(); ?>
		</div-->

                <div id="content" style="clearfix">
                    <?php start_block_marker('content'); ?>
                    <?php end_block_marker(); ?>
                </div>

            </div>

            <!-- Footer - Start-->
            <?php start_block_marker('FooterBox'); ?>
            <div id="FooterBox" class="clearfix">
                <p id="footerLeftText" class="footerText">
                    <span>All rights reserved. &copy; 2015 i-MOS Team</span>
                    <br />
                </p>
                <p id="footerCenterText" class="footerText">
                    <span>&#x2a;&#x2a; Best viewed by Chrome 25&#x2b;, Firefox 15&#x2b; &amp; Safari 5&#x2b; with 1024x768&#x2b; screen resolution.</span>
                    <br />
                </p>
                <p id="footerRightText" class="footerText">
                    <span>
                        <a href="<?php echo base_url('page/terms');?>">Terms of Use</a> &nbsp;&nbsp; &#x7c; &nbsp;&nbsp;
                        <a href="<?php echo base_url('page/privacy');?>">Privacy Policy</a> &nbsp;&nbsp; &#x7c; &nbsp;&nbsp;
                        <a href="<?php echo base_url('page/disclaimers');?>">Disclaimers</a> &nbsp;&nbsp; &#x7c; &nbsp;&nbsp;
                        <a href="<?php echo base_url('page/sitemap');?>">Sitemap</a>
                    </span>
                    <br />
                </p>
            </div>
            <?php end_block_marker(); ?>

            <!-- Footer - End-->

        </div>

    </body>

</html>
