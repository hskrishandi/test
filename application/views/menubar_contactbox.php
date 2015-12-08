	<div id="ContactUsBox" class="MenuDropDown clearfix" style="display:none;">
        <h1>Contact Us
			<img class="boxCloseButton" src="<?php echo resource_url('img', 'close_button.svg'); ?>" />
        </h1>
		<p>If you have any questions or suggestions concerning the i-MOS platform, you are welcome to contact us. For more general questions concerning compact modeling, you may register as a member and post the messages in the discussion and experience pages.</p>
        <br/>
		<div class="contentBox clearfix">
			<h1>Send a Message</h1>
			<?php get_instance()->load->helper('form'); ?>
			<form action="<?php echo base_url('contacts/submit')?>" method="post" id="contact_form">
				<label>
					<span>Name&#x2a;</span>
					<input type="text" name="name" placeholder="Your Name" class="<?php if (form_error('name') !=="") echo 'err' ?>" value="<?php echo set_value('name'); ?>" />
					<h4 class="error"><?php echo form_error('name');?></h4>
				</label>
				<label>
					<span>Affilation</span>
					<input type="text" name="aff" placeholder="Affilation" value="<?php echo set_value('aff'); ?>" />
				</label>
				<label>
					<span>Email&#x2a;</span>
					<input type="text" name="email" placeholder="Your Email Address" class="<?php if (form_error('email') !=="") echo 'err' ?>"  value="<?php echo set_value('email'); ?>" />
				</label>
				<label>
					<span>Subject&#x2a;</span>
					<input type="text" name="subject" placeholder="Subject" value="<?php echo set_value('subject'); ?>" />
				</label>
				<label>
					<span>Message&#x2a;</span>
					<textarea type="text" name="msg" placeholder="Your Messages" class="<?php if (form_error('msg') !=="") echo 'err' ?>"><?php echo set_value('msg')?></textarea>
					<h4 class="error"><?php echo form_error('msg');?></h4>
				</label>
				<label>
					<span>Validation&#x2a;</span>
					<script type="text/javascript">
						var RecaptchaOptions = {
							lang : 'fr',
							theme : 'white'
						};
					</script>
					<div id="recaptcha">
						<?php
							$publickey = "6LfKDtASAAAAADfqnqFzbxPZQRzzdA0wggu8GhkN"; // you got this from the signup page
							get_instance()->load->helper('recaptchalib_helper');
							echo recaptcha_get_html($publickey, null, TRUE);
						?>
					</div>
					<input type="submit" value="Submit">
				</label>
				<label>
					<span>&nbsp;</span>
				</label> 
			</form>
		</div>
    </div>