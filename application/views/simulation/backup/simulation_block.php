<div class="block">
	<div class="simulation_block">
		<h2>Model Library</h2>
		<a id="new_model_lib" class="action" href="#" data-action="<?php echo base_url('simulation/model_library/new'); ?>">new</a> 
		<a id="load_model_lib" class="action" href="#"> load</a> 
		<a id="dl_model_lib" class="action" href="<?php echo base_url('simulation/model_library/download'); ?>">save</a>
		
		<div>	
			<ul id="model-list">	
			<?php foreach ($models as $model): ?>
				<li data-id="<?php echo $model->id; ?>">
					<a href="<?php echo base_url('simulation/model/' . $model->id);?>">
						<?php echo $model->short_name; ?>
					</a>
					<ul class="user-params">
					</ul>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
		<p></p>
	</div>
</div>