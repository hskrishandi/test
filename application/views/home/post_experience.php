<?php extend('layouts/layout.php'); ?>
	<?php startblock('title'); ?> Post Your Experience
	<?php endblock(); ?>

	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'home.css'); ?>" media="all" />
    <?php endblock(); ?>

	<?php startblock('content'); ?>
		<div class="post-experience">
		    <h2>Post Your Experience</h2>
            <form action="<?php echo base_url('home/post_experience')?>" method="post">
                <div id="post-experience-alert" class="alert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <span id="post-experience-alert-msg"></span>
                </div>

                <div class="form-group" id="form-group-comment">
                    <label for="postExperience">Comment</label>
                    <textarea id="postExperience" name="comment" class="form-control" rows="6" ><?php echo set_value('comment'); ?></textarea>
                    <span><small>* When posting comments to i-mos.org, your real name and organization will be displayed.</small></span>
                </div>
                <div class="checkbox" id="form-group-quote">
                    <label>
                        <input type="checkbox" name="quote_auth" value="quote_auth" <?php echo set_checkbox('quote_auth', 'quote_auth'); ?> />
                        I authorize i-mos.org to use my quote, display my real name and organization on the i-mos.org website.
                    </label>
                </div>
                <div class="checkbox" id="form-group-contact">
                    <label>
                        <input type="checkbox" name="contact_auth" value="contact_auth" <?php echo set_checkbox('contact_auth', 'contact_auth'); ?> />
                        I authorize i-mos.org to contact me for further information.
                    </label>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
                <script type="text/javascript">
                if ("<?php echo form_error('comment') ?>" !== "") {
                    $("#post-experience-alert").addClass('alert-danger');
                    $("#form-group-comment").addClass('has-error');
                    $("#post-experience-alert-msg").text("<?php echo form_error('comment') ?>".replace(/<(.*?)>/g , ""));
                    $("#post-experience-alert").show();
                } else if ("<?php echo form_error('quote_auth') ?>" != "") {
                    $("#post-experience-alert").addClass('alert-danger');
                    $("#form-group-quote").addClass('has-error');
                    $("#post-experience-alert-msg").text("<?php echo form_error('quote_auth') ?>".replace(/<(.*?)>/g , ""));
                    $("#post-experience-alert").show();
                } else if ("<?php echo form_error('contact_auth') ?>" != "") {
                    $("#post-experience-alert").addClass('alert-danger');
                    $("#form-group-contact").addClass('has-error');
                    $("#post-experience-alert-msg").text("<?php echo form_error('contact_auth') ?>".replace(/<(.*?)>/g , ""));
                    $("#post-experience-alert").show();
                } else if ("<?php echo $msg ?>" != "") {
                    $("#post-experience-alert").addClass('alert-success');
                    $("#post-experience-alert-msg").text("<?php echo $msg ?>".replace(/<(.*?)>/g , ""));
                    $("#post-experience-alert").show();
                } else {
                    $("#post-experience-alert").hide();
                }
                </script>
            </form>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
