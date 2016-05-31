<?php extend('layouts/layout.php'); ?>

<?php startblock('title'); ?> Home
<?php endblock(); ?>

<?php startblock('css'); ?>
<?php echo get_extended_block(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'home.css'); ?>" media="all" />
<?php endblock(); ?>

<?php startblock('script'); ?>
<?php echo get_extended_block(); ?>
<script src="<?php echo resource_url('js', 'home.js'); ?>" type="text/javascript" charset="utf-8"></script>
<?php endblock(); ?>

<?php startblock('banner'); ?>
<img id="slideImage" src="<?php echo resource_url('img', 'home/home.png'); ?>" class="slide" />
<?php endblock(); ?>

<?php startblock('content'); ?>
<div class="introduction">
    <div class="introduction-description">
        <h1>
            The i-MOS Project<br>
            An Open Platform for Device Modeling and Circuit Simulation
        </h1>
        <p>
            i-MOS is an open platform for model developers and circuit designers to interact. Model developers can implement their models over the i-MOS platform to promote their acceptance and obtain user feedback. Circuit designers can use the platform to try out the most recent models of many newly developed devices before they are released by EDA vendors. The platform provides a standard interface so that users can evaluate and compare models easily. Standard benchmark tests can also be performed on the models. Currently, the platform can only output the characteristics of models. In phase II of the project, an online simulation engine will be provided and users can directly perform simulation over the i-MOS server any time and anywhere as long as they can get connected to the Internet.
        </p>
        <p>
            Please note that the site is lightly moderated. We'll honor all the postings, but we will exercise our right to remove spam, hostile, irrelevant and offending postings.
        </p>
        <a href="<?php echo base_url('news_event'); ?>">&gt; Browse News About i-MOS</a>
    </div>
    <div class="introduction-icon">
        <div class="introduction-icon-group">
            <img src="<?php echo resource_url('img', 'home/OPicon.png'); ?>" />
            <label>Online Platform</label>
        </div>
        <div class="introduction-icon-group">
            <img src="<?php echo resource_url('img', 'home/IPicon.png'); ?>" />
            <label>Interactive Platform</label>
        </div>
        <div class="introduction-icon-group">
            <img src="<?php echo resource_url('img', 'home/RTSicon.png'); ?>" />
            <label>Real Time Simulation</label>
        </div>
    </div>
    <div class="clearFloat"></div>
    <div class="introduction-screenshot">
        <img src="<?php echo resource_url('img', 'home/imosScreenshot1.png'); ?>"/>
    </div>
    <div class="introduction-screenshot">
        <img src="<?php echo resource_url('img', 'home/imosScreenshot2.png'); ?>" />
    </div>
</div>
<div class="clearFloat"></div>
<div class="model-introduction">
    <div class="model-introduction-icon">
        <!-- Keep the image ratio in home.js-->
        <img id="model-introduction-icon-img" src="<?php echo resource_url('img', 'home/MLBigicon.png'); ?>" />
    </div>
    <div class="model-introduction-description">
        <h1>Expanding model library</h1>
        <p>It is the intention of i-MOS to provide an authoring tool for model developer to upload their model implemented in Verilog-A code directly to i-MOS for users to test and evaluate. Currently we are using the Automatic Device Model Synthesizer(ADMS) together with experienced programmers to help the compilation of worthwhile models to the i-MOS platform.</p>
        <a href="<?php echo base_url('modelsim'); ?>" target="_blank">&gt; Launch Model Library</a>
    </div>
    <div class="clearFloat"></div>
    <div class="mLitemBox" class="clearfix">
        <?php $modelCount = 0 ?>
        <?php foreach ($top_models as $key => $model) : ?>
        <a href="<?php echo base_url('modelsim/model/' . $model->id);?>">
            <div class="clearfix modelBoxContainer<?php echo $modelCount == 0 ? ' noLeftMargin' : ''?><?php echo $modelCount++ == 4 ? ' noRightMargin' : ''?>">
                <div class="modelBoxes">
                    <div class="modelImage">
                        <!-- Keep the image ratio in home.js-->
                        <img alt="<?php echo $model->name; ?>" src="<?php echo resource_url('img', 'simulation/' . $model->name . '.png');?>"/>
                    </div>
                    <p class="modelInfo">
                        <?php echo $model->icon_name . '<br/>' . $model->desc_name . '<br/>by ' . $model->organization; ?>
                    </p>
                    <div class="clearFloat"></div>
                    <div class="clearfix modelGreyBox">
                        <img src="<?php echo resource_url('img', 'home/messageIcon.svg'); ?>" class="MessageIcon" />
                        <font class="MessageNumber">
                            <?php echo $model->countComment; ?>
                        </font>
                        <div class="modelRatingStars">
                            <?php for ($i=round($model->rate); $i<5; $i++) : ?>
                            <img src="<?php echo resource_url('img', 'home/greyStar.svg'); ?>" class="ratingStar ratingDimStar" />
                            <?php endfor; ?>
                            <?php for ($i=0; $i<round($model->rate); $i++) : ?>
                            <img src="<?php echo resource_url('img', 'home/yellowStar.svg'); ?>" class="ratingStar ratingLightStar" />
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="clearFloat"></div>
    <div class="user-experience">
        <h1>User Experience</h1>
        <div class="user-experience-box noLeftMargin">
            <?php if (!empty($user_experience) && count($user_experience) > 0) $entry = $user_experience[0]; ?>
                <p class="user-experience-message">
                    “<?php echo htmlspecialchars($entry->comment); ?>”
                </p>
                <p class="user-experience-name">
                    <?php echo htmlspecialchars($entry->first_name . ' ' . $entry->last_name . ', ' . $entry->organization); ?>
                </p>
            <? endif; ?>
        </div>
        <div class="user-experience-box noRightMargin">
            <?php if (!empty($user_experience) && count($user_experience) > 0) $entry = $user_experience[1]; ?>
                <p class="user-experience-message">
                    “<?php echo htmlspecialchars($entry->comment); ?>”
                </p>
                <p class="user-experience-name">
                    <?php echo htmlspecialchars($entry->first_name . ' ' . $entry->last_name . ', ' . $entry->organization); ?>
                </p>
            <? endif; ?>
        </div>
        <div class="clearFloat"></div>
        <div class="user-experience-more">
            <a href="<?php echo base_url('home/user_experience'); ?>">More User Experiences <img src="<?php echo resource_url('img', 'icons/add.png'); ?>" width="15px;" /></a>
            <a href="<?php echo base_url('home/post_experience'); ?>">Post a User Experience <img src="<?php echo resource_url('img', 'icons/comment.png'); ?>" width="10px;" /></a>
        </div>
    </div>
    <div class="clearFloat"></div>
</div>
<div class="news-highlight">
    <h1>News and Event Highlights</h1>
    <div class="news-image">
        <img src="<?php echo resource_url('img', 'home/billboard1.png'); ?>" class="noLeftMargin"/>
        <img src="<?php echo resource_url('img', 'home/billboard2.png'); ?>" />
        <img src="<?php echo resource_url('img', 'home/billboard3.png'); ?>" class="noRightMargin"/>
    </div>
    <div class="page-subtitle">
        <span class="page-subtitle-title">i-MOS Activities</span>
         <a class="page-subtitle-more" href="<?php echo base_url('activities'); ?>">more</a>
    </div>
    <div class="news-box">
        <div class="news-box-column noLeftMargin">
            <?php for ($i=0; $i<min(3,count($activities)); $i++) : ?>
                <h6><?php echo date('d M Y', $activities[$i]->date); ?></h6>
                <p><?php echo $activities[$i]->content; ?></p>
            <?php endfor; ?>
        </div>
        <div class="news-box-column noRightMargin">
            <?php for ($i=3; $i<min(6,count($activities)); $i++) : ?>
                <h6><?php echo date('d M Y', $activities[$i]->date); ?></h6>
                <p><?php echo $activities[$i]->content; ?></p>
            <?php endfor; ?>
        </div>
    </div>
</div>
<div class="clearFloat"></div>
<?php endblock(); ?>
<?php end_extend(); ?>
