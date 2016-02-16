
<?php extend('layout.php'); ?>

<?php startblock('title'); ?>
		Discussion
	<?php endblock(); ?>
    
    
    	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'discussion.css'); ?>" media="all" />
    <?php endblock(); ?>

        
        <?php startblock('content'); ?>
        
            <div id="content-container" style="width:600px">
	<!-- replace this content with external page -->
</div>
 
<a href="javascript:void(0);" onclick="loadExternalContent();">
	Comments</a>
     <script>
function loadExternalContent() {
	jQuery('#content-container').load('<?php echo base_url("discussion/comment/10");?>', function() {
	});
}
</script>
	<?php endblock(); ?>

<?php end_extend(); ?> 