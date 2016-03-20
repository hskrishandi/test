<!-- MenuBar - Start -->
<div id="MenuBar" class="header">
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
