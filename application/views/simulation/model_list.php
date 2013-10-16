<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Models
	<?php endblock(); ?>
  
	<?php startblock('css'); ?>
		<?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'model.css'); ?>" media="all" />
	<?php endblock(); ?>

		
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('content'); ?>
		<div id="model-list">
			<h2 class="title">Device Models</h2>
			<ul class="models">
			<?php foreach ($model_list as $model): ?>
				<li>
					<a href="<?php echo base_url('modelsim/model/' . $model->id);?>" style="display: block">
						<b><?php echo $model->icon_name; ?></b>
						<div class="icon-img"><img alt="<?php echo $model->name; ?>" src="<?php echo resource_url('img', 'simulation/' . $model->name . '.png');?>"/></div>
						<b><?php echo $model->desc_name . '<br/>' . $model->organization; ?></b>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
