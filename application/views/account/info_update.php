<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		Account Update
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'info_update.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo resource_url('js', 'library/ajaxfileupload.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'info_update.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
        <div class="form">
            <h2>Account Update</h2>
            <h4>Personal Information:</h4>
            <form class="form-horizontal" action="<?php echo base_url('account/infoUpdate')?>" method="post" enctype='multipart/form-data'>
                <div id="form-group-lastname" class="form-group">
                    <label for="last-name" class="col-sm-2 control-label">Last Name <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input id="last-name" name="last_name" type="text" class="form-control required" placeholder="Last Name, required" value="<?php echo set_value('last_name', $userinfo->last_name); ?>">
                    </div>
                </div>
                <div id="form-group-firstname" class="form-group">
                    <label for="first-name" class="col-sm-2 control-label">First Name <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input id="first-name" name="first_name" type="text" class="form-control required" placeholder="First Name, required" value="<?php echo set_value('first_name', $userinfo->first_name); ?>">
                    </div>
                </div>
                <div id="form-group-displayname" class="form-group">
                    <label for="display-name" class="col-sm-2 control-label">Display Name <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input id="display-name" name="displayname" type="text" class="form-control required" placeholder="Display Name, required" value="<?php echo set_value('displayname',$userinfo->displayname); ?>">
                    </div>
                </div>
                <div id="form-group-organization" class="form-group">
                    <label for="organization" class="col-sm-2 control-label">Company <sup>*</sup></label>
                    <div class="col-sm-10">
                        <input id="organization" name="organization" type="text" class="form-control required" placeholder="Company, required" value="<?php echo set_value('organization', $userinfo->organization); ?>">
                    </div>
                </div>
                <div id="form-group-position" class="form-group">
                    <label for="position" class="col-sm-2 control-label">Position Title</label>
                    <div class="col-sm-10">
                        <input id="position" name="position" type="text" class="form-control" placeholder="Position Title" value="<?php echo set_value('position', $userinfo->position); ?>">
                    </div>
                </div>
                <div id="form-group-address" class="form-group">
                    <label for="address" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10">
                        <input id="address" name="address" type="text" class="form-control" placeholder="Address" value="<?php echo set_value('address', $userinfo->address); ?>">
                    </div>
                </div>
                <div id="form-group-tel" class="form-group">
                    <label for="tel" class="col-sm-2 control-label">Tel</label>
                    <div class="col-sm-10">
                        <input id="tel" name="tel" type="text" class="form-control" placeholder="Tel" value="<?php echo set_value('tel', $userinfo->tel); ?>">
                    </div>
                </div>
                <div id="form-group-fax" class="form-group">
                    <label for="fax" class="col-sm-2 control-label">Fax</label>
                    <div class="col-sm-10">
                        <input id="fax" name="fax" type="text" class="form-control" placeholder="Fax" value="<?php echo set_value('fax', $userinfo->fax); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="user-picture" class="col-sm-2 control-label">User Picture</label>
                    <div id="user-picture" class="pic col-sm-10">
                        <?php
                            if ($userinfo->photo_path !== ""){
                        ?>
                            <img src="<?php echo resource_url('user_image', $userinfo->photo_path.'_n'.$userinfo->photo_ext);?>" />
                        <?php
                            }else{
                        ?>
                            <div class="no_pic">No Picture Submitted</div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <input type="file" name="photo" value="<?php if(isset($photo_value)) echo $photo_value?>">
                    </div>
                </div>
                <input type="hidden" name="submited" value="1">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
	<?php endblock(); ?>

<?php end_extend(); ?>
