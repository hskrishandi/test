<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Node Management
	<?php endblock(); ?>

	<?php startblock('script'); ?>
		<?php echo get_extended_block(); ?>
		<script src="<?php echo resource_url('js', 'info_update.js'); ?>" type="text/javascript"></script>
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
        <?php $this->load->view('account/account_block'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'info_update.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>

<H2>Node Managment</H2>
<br /><br />
<form action="" method="post" class="form_update">


<?php if(isset($add) && $add) { ?>
<table class="form_table">

	<tr>
		<td>Nodename :<br /><br /></td>
		<td><input type="text" name="nodename" value="" /><br /><br /></td>
	</tr>
	<tr>
		<td>Hostname :<br /><br /></td>
		<td><input type="text" name="hostname" value="" /><br /><br /></td>
	</tr>
	<tr>
		<td>Path :<br /><br /></td>
		<td><input type="text" name="path" value="" /><br /><br /></td>
	</tr>
	<tr>
		<td>&nbsp;<br /><br /></td>
		<td><input type="submit" name="add" value="Add" /><br /><br /></td>
	</tr>
</table>

<?php } else if(isset($edit) && $edit) { ?>
<table class="form_table">	
	<tr>
		<td>Nodename :<br /><br /></td>
		<td><input type="text" name="nodename" value="<?php echo $node->nodename; ?>" /><br /><br /></td>
	</tr>
	<tr>
		<td>Hostname :<br /><br /></td>
		<td><input type="text" name="hostname" value="<?php echo $node->hostname; ?>" /><br /><br /></td>
	</tr>
	<tr>
		<td>Path :<br /><br /></td>
		<td><input type="text" name="path" value="<?php echo $node->path; ?>" /><br /><br /></td>
	</tr>
	<tr>
		<td>&nbsp;<br /><br /></td>
		<td><input type="submit" name="edit" value="Edit" /><br /><br /></td>
	</tr>
</table>

<input type="hidden" name="id" value="<?php echo $node->id; ?>" />


<?php } ?>
</form>
		
	<?php endblock(); ?>

<?php end_extend(); ?> 
