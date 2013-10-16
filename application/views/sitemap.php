<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
	Sitemap
	<?php endblock(); ?>
    
    
        <?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'sitemap.css'); ?>" media="all" />
    	<?php endblock(); ?>
     
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('account/account_block'); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
<div id="static-page">
  <h2 class="title">Sitemap</h2>
  <div class="sitemap">
  <div class="left_table">
  <table>
    <tr>
      <td class="thead"><span class="thead"><a href="<?php echo base_url('home');?>">Home</a></span></td>
    </tr>
    <tr>
      <td><ul>
        <li><a href="<?php echo base_url('home/activities');?>">i-MOS Activities</a></li>
        <li><a href="<?php echo base_url('home/user_experience');?>">User Experience</a></li>
      </ul></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="thead"><a href="<?php echo base_url('simulation');?>">Simulation</a></td>
    </tr>
    <tr>
      <td><ul>
      <?php foreach($model_info as $row):?>
        <li><a href="<?php echo base_url('simulation/model/'.$row->id);?>"><?php echo $row->short_name; ?></a></li>
      <?php endforeach;?>
      </ul></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="thead"><a href="<?php echo base_url('developer');?>">Developer</a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="thead"><a href="<?php echo base_url('discussion');?>">Discussion</a></td>
    </tr>
    <tr>
      <td><ul>
        <li><a href="<?php echo base_url('discussion/posting');?>">Post</a></li>
        <li><a href="<?php echo base_url('discussion/blog');?>">Blog</a></li>
      </ul></td>
    </tr>
  </table>
  </div>
  <div class="right_table">
  <table>
    <tr>
      <td class="thead"><span class="thead"><a href="<?php echo base_url('resources');?>">Resources</a><a href="<?php echo base_url('home');?>"></a></span></td>
    </tr>
    <tr>
      <td><ul>
        <li><a href="<?php echo base_url('resources/news');?>">News</a></li>
        <li><a href="<?php echo base_url('resources/events');?>">Events</a></li>
        <li><a href="<?php echo base_url('resources/articles');?>">Articles</a></li>
        <li><a href="<?php echo base_url('resources/groups');?>">Organizations</a></li>
        <li><a href="<?php echo base_url('resources/models');?>">Device Models</a></li>
        <li><a href="<?php echo base_url('resources/tools');?>">Tools</a></li>
      </ul></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="thead"><a href="<?php echo base_url('account');?>">Accounts</a><a href="<?php echo base_url('simulation');?>"></a></td>
    </tr>
    <tr>
      <td><ul>
        <li><a href="<?php echo base_url('account/create');?>">Registration</a></li>
        <li><a href="<?php echo base_url('account/newPass');?>">Request new password</a></li>
        <li><a href="<?php echo base_url('account/infoUpdate');?>">Account Update</a></li>
        <li><a href="<?php echo base_url('account/changePass');?>">Change Password</a></li>
      </ul></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="thead"><a href="<?php echo base_url('contacts');?>">Contacts</a><a href="<?php echo base_url('developer');?>"></a></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  </div>
  </div>
</div>
	<?php endblock(); ?>

<?php end_extend(); ?> 
