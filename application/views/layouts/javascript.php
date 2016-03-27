<?php start_block_marker('script'); ?>

<script type="text/javascript">
    var CI_ROOT = "<?php echo base_url();?>";
    var M_TIME = "<?php echo microtime(true); ?>";
</script>

<!-- <script src="https://code.jquery.com/jquery-1.8.2.min.js" type="text/javascript" charset="utf-8"></script> -->
<script src="<?php echo resource_url('js', 'jquery/jquery-2.1.4.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo resource_url('js', 'scripts.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo resource_url('js', 'menuBar.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo resource_url('js', 'login.js'); ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo resource_url('js', 'constant.js'); ?>" type="text/javascript" charset="utf-8"></script>

<?php end_block_marker(); ?>
