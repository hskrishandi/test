<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		News
	<?php endblock(); ?>	
	
	<?php startblock('content'); ?>
		<div id="resources">
			<div id="resource-content">
            <?php if($display_list):?>
				<h2 class="title">News</h2>
                
				<ul class="item-list">
					<?php foreach($news as $entry): ?>
					<li> 
                    	<span class="date">[ <?php echo date('d M Y', $entry->post_date); ?> ]</span>
						<?php 
							echo '<a href="' . base_url('/resources/news/' . $entry->id) . '" class="entry"  >' . $entry->title . '</a>';
						?>
                    
					</li>
					<?php endforeach; ?>
                 </ul>
                    <?php else:?>
                    <h2 class="title">News</h2>
                    	<?php foreach($news_details as $entry): ?>
                        
                        
                        <span class="date">[ <?php echo date('d M Y', $entry->post_date); ?> ]</span>
                    	<h4 class="title"><?php echo $entry->title;?></h4>
                  
                        <div><?php echo nl2br($entry->content);?></div>
      
        <a class="return-link" href="<?php echo base_url('cms/resources'); ?>">
					Back
				</a>
                        
                    	<?php endforeach; ?>
                    <?php endif;?>
				
                 
			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
