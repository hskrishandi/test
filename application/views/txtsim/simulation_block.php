<div class="block">
	<div class="simulation_block">
		<h2>Model Library</h2>
		<br />
		<div>	
			<ul id="model-list">	
			<?php foreach ($models as $model): ?>
				<li data-id="<?php echo $model->id; ?>">
						<?php echo $model->short_name; ?>
					<ul class="user-params">
					</ul>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
		<p></p>
	</div>
</div>