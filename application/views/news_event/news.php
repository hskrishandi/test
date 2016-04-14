<?php extend('resources/layout.php'); ?>	
	<?php startblock('title'); ?>
		News
	<?php endblock(); ?>	
	
	<?php startblock('content'); ?>
		<div id="resources">
			<div id="resource-content">
            <?php if($display_list):?>
				<div class="title">News
					<a class="return-link" href="<?php echo base_url('news_event'); ?>" onclick="history.go(-1); return false;">
							Back to News and Event
					</a>
					<div class="postSeparateLine">
					&#x7c;
					</div>

					<a class="post" href="<?php echo base_url('resources/post/news'); ?>">Post News</a>
				</div>
                
				<ul class="item-list">
					<?php foreach($news as $entry): ?>
					<li> 
                    	<?php 
							echo '<a href="' . base_url('news_event/news/' . $entry->id) . '" class="entryTitle"  >' . $entry->title . '</a>';
						?>
                    	<span class="date"> <?php echo date('d M Y', $entry->post_date); ?> </span>
					</li>
					<?php endforeach; ?>
                 </ul>
                
                    <?php else:?>
                    <div class="title">News 
                    	<a class="return-link" href="<?php echo base_url('news_event'); ?>" onclick="history.go(-1); return false;">
							Back to News Page
						</a>
                    </div>
                    <div class="details">
                    	<?php foreach($news_details as $entry): ?>
   
                        
                    	<div class="newsTitle"><?php echo $entry->title;?></div>
                    	<br/>
                  		<span class="date"><?php echo date('d M Y', $entry->post_date); ?></span>
                  		<br/>
                        <div><?php echo nl2br($entry->content);?></div>
	      				<br /><br />
	      				<?php if($entry->source_link != "") { ?>
	      				Source: <a href="<?php echo $entry->source_link; ?>" target="_blank"><?php echo $entry->source_link; ?></a>
	      				<?php } ?>
	      				<br/><br/>
      					<a  href="<?php echo base_url('news_event'); ?>" onclick="history.go(-1); return false;">
							< Back to News Page
						</a>
        
                        
                    	<?php endforeach; ?>
                    	</div
                    <?php endif;?>
				
                 
			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
