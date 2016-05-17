<?php extend('layouts/layout.php'); ?>

	<?php startblock('title'); ?>
		Models
	<?php endblock(); ?>

	<?php startblock('css'); ?>
		<?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'model.css'); ?>" media="all" />
	<?php endblock(); ?>

	<?php startblock('content'); ?>
		<div id="model-list">
			<h2>Device Models</h2>
				<div id="MLitemBox" class="clearfix" style="background-color:#C9C9C9; overflow:hidden;">
				<?php foreach ($model_list as $model) : ?>
					<a target="_blank" href="<?php echo base_url('modelsim/model/' . $model->id);?>">
					<div class="clearfix modelBoxContainer">
						<div class="modelBoxes">
                            <div class="modelImage">
                                <img alt="<?php echo $model->name; ?>" src="<?php echo resource_url('img', 'simulation/' . $model->name . '.png');?>"/>
                            </div>
							<p class="modelInfo">
								<span>
									<?php echo $model->icon_name . '<br/>' . $model->desc_name . '<br/>by ' . $model->organization; ?>
								</span>
							</p>
							<div class="clearfix modelGreyBox">
								<img src="<?php echo resource_url('img', 'home/messageIcon.svg'); ?>" class="MessageIcon" />
								<font class="MessageNumber">
									<?php echo $model->countComment; ?>
								</font>
								<div class="modelRatingStars">
								<?php for ($i=round($model->rate); $i<5; $i++) : ?>
									<img src="<?php echo resource_url('img', 'home/greyStar.svg'); ?>" class="ratingStar ratingDimStar" />
								<?php endfor; ?>
								<?php for ($i=0; $i<round($model->rate); $i++) : ?>
									<img src="<?php echo resource_url('img', 'home/yellowStar.svg'); ?>" class="ratingStar ratingLightStar" />
								<?php endfor; ?>
								</div>
							</div>
						</div>
					</div>
					</a>
				<?php endforeach; ?>
				</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
