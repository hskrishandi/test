<!--edited by Grace-->
<?php extend('layouts/layout.php'); ?>
<?php startblock('title'); ?>
    News
<?php endblock(); ?>

<?php startblock('css'); ?>
    <?php echo get_extended_block(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'news_event.css'); ?>" media="all" />
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

<?php startblock('banner'); ?>
    <img src="<?php echo resource_url('img', 'news/news.png'); ?>" />
<?php endblock(); ?>

<?php startblock('content'); ?>
<div id="resources">

	<?php if($display_list):?>
        <div class="page-subtitle">
            <span class="page-subtitle-title">News</span>
            <a class="page-subtitle-more" href="<?php echo base_url('news_event'); ?>" onclick="history.go(-1); return false;">Back to News and Event</a>
        </div>

	<ul class="item-list">
		<?php foreach($news as $entry): ?>
		<li class="item">
			<?php
			echo '<a href="' . base_url('news_event/news/' . $entry->id) . '" class="entryTitle"  >' . $entry->title . '</a>';
			?>
			<span class="date"> <?php echo date('d M Y', $entry->post_date); ?> </span>
		</li>
	<?php endforeach; ?>

</ul>

<?php else:?>
	<div class="page-subtitle">
        <span class="page-subtitle-title">News</span>
		<a class="page-subtitle-more" href="<?php echo base_url('news_event'); ?>" onclick="history.go(-1); return false;">
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
</div>
<?php endif;?>



</div>
<?php endblock(); ?>

<?php end_extend(); ?>
