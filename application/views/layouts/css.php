<?php start_block_marker('css'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'reset.css'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php if (current_url() != base_url() && current_url() != base_url('home')) echo resource_url('css', 'style.css'); ?>" media="all" />
<!-- <==This is for transaction from old ui to new ui. Once the new ui is finished, this should be removed. -->
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'fonts.css'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'layout.css'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'layouts/style.css'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'layouts/header.css'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'layouts/footer.css'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'layouts/banner.css'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'layouts/content.css'); ?>" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'bootstrap/bootstrap.min.css'); ?>" media="all" />
<?php end_block_marker(); ?>
