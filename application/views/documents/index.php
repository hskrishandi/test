<?php extend('layouts/layout.php'); ?>
	<?php startblock('title'); ?>
		Documents
	<?php endblock(); ?>

    <?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'documents.css'); ?>" media="all" />
    <?php endblock(); ?>

    <?php startblock('script'); ?>
        <?php echo get_extended_block(); ?>
            <script type="text/javascript" src="<?php echo resource_url('js', 'library/jquery.validate.min.js');?>"></script>
            <script type="text/javascript" src="<?php echo resource_url('js', 'resources.js'); ?>"></script>
            <script type="text/javascript" src="<?php echo resource_url('js', 'calendarDateInput.js'); ?>">
                /***********************************************
                * Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
                * Script featured on and available at http://www.dynamicdrive.com
                * Keep this notice intact for use.
                ***********************************************/
            </script>
    <?php endblock(); ?>

	<?php startblock('content'); ?>
        <div id="resources">
            <h2>Documents</h2>
            <div class="page-subtitle">
                <span class="page-subtitle-title">Manual Downloads</span>
            </div>
            <div class="documents">
                <div class="link2">
                    <a href="http://ngspice.sourceforge.net/docs.html" target="_blank">
                        <img src="<?php echo resource_url('img', 'download_ngspice.png'); ?>" alt="Ngspice Manual">
                    </a>
                </div>
                <div class="link1">
                    <a href="<?php echo base_url('home/manual'); ?>">
                        <img src="<?php echo resource_url('img', 'download_imos.png'); ?>" alt="i-Mos Users' Manual">
                    </a>
                </div>
                <div class="clearFloat"></div>
            </div>
            <?php if($display_list):?>
                <div class="page-subtitle">
                    <span class="page-subtitle-title">Articles</span>
                    <a class="page-subtitle-more" href="<?php echo base_url('resources/post/articles'); ?>">Post Article</a>
                </div>
                <ul class="item-list article">
                    <?php foreach($articles as $title => $entries): ?>
                        <?php $year=NULL; foreach($entries as $entry): ?>
                            <li>
                                <?php
                                    if($year!=$entry->year)
                                    echo '<span class="date" style="padding:10px 0px; font-size:20px;"> '.$entry->year.' </span>';
                                    echo '<a href="' . base_url('resources/articles/' . $entry->id) . '" class="entry" >' . $entry->name . ' ';
                                    echo '</a></br>';
                                    if ($entry->author != NULL) {
                                        echo  '．'. $entry->author;

                                    } else if ($entry->year != NULL) {
                                        echo  $entry->year;
                                    }
                                    if($entry->publisher !=NULL){
                                        echo '</br>．'. $entry->publisher;
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
                    <h2 class="title"><?php echo $articles_details_entry->name;?></h2>
                    <span class="user-detail"><?php echo $articles_details_entry->author;?><?php if($articles_details_entry->author!=NULL AND $articles_details_entry->year!=NULL) echo"&nbsp;-&nbsp;";?><?php echo $articles_details_entry->year;?></span>
                    <span><?php echo nl2br($articles_details_entry->summary);?></span>
                    <span class="website">
                        <?php if ($articles_details_entry->website != NULL) {
                            echo '<a href="' . $articles_details_entry->website . '" class="link"  target="_blank" >' .  strip_text($articles_details_entry->website, MAX_LINK_LENGTH) . '</a>'; }
                        ?>
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
                        <a class="return-link" href="<?php echo base_url('documents'); ?>" onclick="history.go(-1); return false;">Back</a>
                <?php endforeach; ?>
            <?php endif ?>
        </div>
        <?php endblock(); ?>
<?php end_extend(); ?>
