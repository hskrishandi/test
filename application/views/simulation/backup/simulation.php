<?php extend('layout.php'); ?>

  <?php startblock('title'); ?>
    Models
  <?php endblock(); ?>
  
  <?php startblock('script'); ?>
	<?php echo get_extended_block(); ?>
	<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js" type="text/javascript"></script>
	<script src="<?php echo resource_url('js', 'library/json2.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo resource_url('js', 'simulation/utilities.js'); ?>" type="text/javascript"></script>
	<script src="<?php echo resource_url('js', 'simulation/model_library.js'); ?>" type="text/javascript"></script>
  <?php endblock(); ?>
  
  <?php startblock('css'); ?>
		<?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'simulation.css'); ?>" media="all" />
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'node_sim.css'); ?>"/>
	<?php endblock(); ?>

  <?php startblock('side_menu'); ?>
	  <?php echo get_extended_block(); ?>
	  <?php $this->load->view('simulation/simulation_block', array('models' => $models)); ?>
  <?php endblock(); ?>

  <?php startblock('content'); ?>
	<div id="simulation">
	<h2 class="title">Device Models</h2>
    <ul class="models">
	<?php foreach ($model_list as $model): ?>
      <li>
        <a href="<?php echo base_url('simulation/model/' . $model->id);?>">
          <div class="icon_img"><img src="<?php echo resource_url('img', 'simulation/' . $model->name . '.png');?>"/></div>
          <b><?php echo $model->organization . '<br/>' . $model->short_name; ?></b>
        </a>
      </li>
	<?php endforeach; ?>
    </ul>
    </div>
  <?php endblock(); ?>

<?php end_extend(); ?>
