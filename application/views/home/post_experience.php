<?php
	$title = 'Post Your Experience';
?>

<?php extend('layout.php'); ?>	
	<?php startblock('title'); ?>
		<?php echo $title; ?>
	<?php endblock(); ?>	
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'home.css'); ?>" media="all" />
    <?php endblock(); ?>

	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
		<div id="post-experience">
		<?php if(isset($msg)) echo '<h4>' . $msg . '</h4>'; ?>
		<h2 class="title"><?php echo $title; ?></h2>		
		<form id="post_experience_form" action="<?php echo base_url('home/post_experience')?>" method="post">
			Comment:
			<textarea rows="6" cols="50" name="comment" class="<?php if (form_error('comment') !=="") echo 'error'; ?>"><?php echo set_value('comment'); ?></textarea>
			<?php echo form_error('comment', '<h4 class="error-msg">', '</h4>'); ?>
            <span>* When posting comments to i-mos.org, your real name and organization will be displayed.</span>
			<label class="<?php if (form_error('quote_auth') !=="") echo 'error'; ?>">
            
			<input type="checkbox" name="quote_auth" value="quote_auth" <?php echo set_checkbox('quote_auth', 'quote_auth'); ?> />
			  I authorize i-mos.org to use my quote, display my real name and organization on the i-mos.org website.
			</label>
			<?php if (form_error('quote_auth') != "") echo '<h4 class="error-msg">' . 'You must authorize i-mos.org to use your quote.' . '</h4>'; ?>
			<label class="<?php if (form_error('contact_auth') !=="") echo 'error'; ?>">
			  <input type="checkbox" name="contact_auth" value="contact_auth" <?php echo set_checkbox('contact_auth', 'contact_auth'); ?> />
			  I authorize i-mos.org to contact me for further information.
			</label>
			<?php if (form_error('contact_auth') != "") echo '<h4 class="error-msg">' . 'You must authorize i-mos.org to contact you.' . '</h4>'; ?>
			<a class="submit" onclick="$('#post_experience_form').submit();">Submit</a>
			<!--<button name="submit" class="submit">Submit</button>-->
		</form>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
