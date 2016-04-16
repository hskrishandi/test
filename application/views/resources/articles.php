<?php extend('resources/layout.php'); ?>
	<?php startblock('title'); ?>
		Articles
	<?php endblock(); ?>

	<?php startblock('side_menu'); ?>
	<?php endblock(); ?>

	<?php startblock('content'); ?>
		<div id="resources">
			<div id="resource-content">
            	<?php if($display_list):?>
                <h2 class="title">Articles</h2>

                        <ul class="item-list">
                        <?php foreach($articles as $title => $entries): ?>
                            <?php $year=NULL; foreach($entries as $entry): ?>
                            <li>
                                <?php
									if($year!=$entry->year)
									echo '<span class="date" style="padding-top:10px">[ '.$entry->year.' ]</span>';
                                    echo '<a href="' . base_url('resources/articles/' . $entry->id) . '" class="entry" >' . $entry->name . ' ';
                                    echo '</a></br>';
                                    if ($entry->author != NULL) {
                                        echo  '- '. $entry->author;

                                    } else if ($entry->year != NULL) {
                                         echo  $entry->year;
                                    }
									if($entry->publisher !=NULL){
										echo '</br>- '. $entry->publisher;
									}

									if($entry->website !=NULL){
										echo '<a href="' . $entry->website . '" class="link"  target="_blank" >' .  strip_text($entry->website, MAX_LINK_LENGTH) . '</a>';
									}

                  				$year=$entry->year;
                                ?>

                            </li>

                            <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>


                <?php else:?>


                <?php foreach($articles_details as $articles_details_entry): ?>
                    	<h2 class="page-subtitle"><?php echo $articles_details_entry->name;?></h2>
                        <span class="user-detail"><?php echo $articles_details_entry->author;?><?php if($articles_details_entry->author!=NULL AND $articles_details_entry->year!=NULL) echo"&nbsp;-&nbsp;";?><?php echo $articles_details_entry->year;?></span>
                        <span><?php echo nl2br($articles_details_entry->summary);?></span>
                        <span class="website"><?php if ($articles_details_entry->website != NULL) {
                                       echo '<a href="' . $articles_details_entry->website . '" class="link"  target="_blank" >' .  strip_text($articles_details_entry->website, MAX_LINK_LENGTH) . '</a>'; }?>
                         </span>
                         <?php if($articles_details_entry->article_name != NULL) { ?>
                         <br />
                         <br />
                         <span class="website">Article available: &nbsp;&nbsp;
                                <?php
                                echo '<a href="' . $articles_details_entry->article_link . '" class="link">' . $articles_details_entry->article_name . '</a>';
                                ?>
                         </span>
                         <?php } ?>


                        <a class="return-link" href="<?php echo base_url('articles'); ?>" onclick="history.go(-1); return false;">
					Back
				</a>

                    	<?php endforeach; ?>

                <?php endif ?>
			</div>
		</div>
	<?php endblock(); ?>

<?php end_extend(); ?>
