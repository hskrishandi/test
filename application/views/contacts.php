<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Contacts
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'contacts.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
		<div class="contacts">
			<div class="forms">
			<h2 class="title">Contact Us</h2>
			<p>If you have any questions or suggestions concerning the <I>i</I>-MOS platform, you are welcome to contact us. For more general questions concerning compact modeling, you may register as a member and post the messages in the discussion and experience pages.</p>
			<h3 class="title">Send a message</h3>
			<h4><?php if(isset($msg)) echo $msg ?></h4>
			<?php
				if (isset($msg)){
			?>
				<script>
					$(document).ready(function(){
						alert("<?php echo $msg ?>");
					});
				</script>
			<?php
				}	
			?>
			<script>
				$(document).ready(function(){
						$('#submit').click(function(){
							//alert("123");
							$('#contact_form').submit();
						})
				});
			</script>
			<form action="<?php echo base_url('contacts/submit')?>" method="post" class="form"  id="contact_form">
			<table class="form_table">
				<tr>
					<td class="title">NAME*:</th>
					<td><input type="text" name="name" class="<?php if (form_error('name') !=="") echo 'err' ?>" value="<?php echo set_value('name'); ?>"/><br />
					<h4 class="error"><?php echo form_error('name');?></h4>
					</th>
				</tr>
				<tr>
					<td class="title">AFFILIATION:</td>
					<td><input type="text" name="aff"  value="<?php echo set_value('aff'); ?>"/></td>
				</tr>
				<tr>
					<td class="title">E-MAIL*:</td>
					<td><input type="text" name="email" class="<?php if (form_error('email') !=="") echo 'err' ?>"  value="<?php echo set_value('email'); ?>"/>
					<h4 class="error"><?php echo form_error('email');?> </h4>
					</td>
				</tr>
				<tr>
					<td class="title">SUBJECT:</td>
					<td><input type="text" name="subject"  value="<?php echo set_value('subject'); ?>"/></td>
				</tr>
				<tr>
					<td  class="title" colspan="2">MESSAGE*:</td>
				</tr>
				<tr>
					<td colspan="2"><textarea rows="4" cols="50" name="msg" class="<?php if (form_error('msg') !=="") echo 'err' ?>"><?php echo set_value('msg')?></textarea>
					<h4 class="error"><?php echo form_error('msg');?></h4>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<div class="div_inline">
					Input verification code
	     			 <script type="text/javascript">
					 var RecaptchaOptions = {
						lang : 'fr',
						theme : 'white'
					 };
					 </script>
					<?php
						$publickey = "6LfKDtASAAAAADfqnqFzbxPZQRzzdA0wggu8GhkN"; // you got this from the signup page
						echo recaptcha_get_html($publickey);
					?>
					<h4 class="error"><?php if (isset($err['verification'])) echo $err['verification'] ?></h4>
					</div>
					<div class="form_submit">
					<a class="submit" id="submit">Submit</a>
					</div>
				</td>
				</tr>
			</table>
			</form>
			</div>
			<div class="team_info">
				<h2 class="title">The <?php echo imos_mark() ?> Team</h2>
				<h3 class="sub_title">Principal Investigator</h4>
				Prof. Mansun Chan<br />
				<br />
				<h4 class="sub_title">Project Manager</h4>
                                  Lining Zhang<br />
				<br />
				<h4 class="sub_title">Members</h4>
                                  Muthupandian Cheralathan<br />
				  Raju Salahuddin<br />
				  Aixi Zhang<br />
				  Ying Zhu<br />
				  Yin Sun<br />
			        <br />
				
			         <h4 class="sub_title">Programmers</h4>
			          Ngai Sing Ben Ng<br />
                                  Richeng Huang<br />
                                  Chun Ming Kenneth Au<br />
                                  Xiaodong Meng<br />
		               <br />
		                <h4 class="sub_title">Past Contributors</h4>
                                  Xiaoxu Cheng<br />
                                  Sai Kin Cheung<br />
                                  Ka Chun Cyrix Tam<br />
                                  Wing Hang Seifer Tsang<br />
                                  Hao Wang<br />
                                  Kwok Shiu Andy Wong<br />
                                  Hamza Zia<br />
                               <br />				
        <h4 class="sub_title">Collaborators</h4>
	Prof. Xinnan Lin <br />
        (Peking University Shenzhen) <br />
        Dr. Stanislav Markov<br />
        (The University of Hong Kong)<br />
          Prof. Yu Cao <br />(Arizona State University)<br />
          Prof. Jin He <br />(Peking University)<br />
          Prof. Yan Wang <br />(Tsinghua University)<br />
          Prof. Philip Wong <br />(Stanford University)
      <br />
				<br />
			</div>
		</div>
		
		
	<?php endblock(); ?>

<?php end_extend(); ?> 
