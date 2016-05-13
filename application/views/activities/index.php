<?php extend('layouts/layout.php'); ?>
<?php startblock('title'); ?>
    Activities
<?php endblock(); ?>

<?php startblock('css'); ?>
    <?php echo get_extended_block(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'activities.css'); ?>" media="all" />
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
<?php endblock(); ?>

<?php startblock('content'); ?>
    <h2>Activities</h2>

    <div class="page-subtitle">
        <span class="page-subtitle-title">Recent Activities</span>
    </div>

    <ul class="item-list">
        <?php foreach($activities as $entry): ?>
        <li>
            <p>
                <span class="date"><?php echo date('d M Y', $entry->date); ?></span> <?php echo $entry->content; ?>
            </p>
        </li>
        <?php endforeach; ?>
    </ul>
<?php endblock(); ?>

<?php end_extend(); ?>
