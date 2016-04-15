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
<img id="slideImage" src="<?php echo resource_url('img', 'home/newslider.jpg'); ?>" class="slide" />
<?php endblock(); ?>

<?php startblock('content'); ?>
<div id="home">
    <!-- Introduction - Start -->
    <div id="IntroBox" class="clearfix">
        <div>
            <div id="introTextBox" class="clearfix">
                <p>
                    <span class="textTitle">The i-MOS Project&nbsp;
                        <br />An Open Platform for Device Modeling
                        <br />and Circuit Simulation</span>
                    <span>
                        <br />
                        <br />
                        <br />
                    </span>
                    <span>i-MOS is an open platform for model developers and circuit designers to interact. Model developers can implement their models over the i-MOS platform to promote their acceptance and obtain user feedback. Circuit designers can use the
                        platform to try out the most recent models of many newly developed devices before they are released by EDA vendors. The platform provides a standard interface so that users can evaluate and compare models easily. Standard benchmark
                        tests can also be performed on the models. Currently, the platform can only output the characteristics of models. In phase II of the project, an online simulation engine will be provided and users can directly perform simulation
                        over the i-MOS server any time and anywhere as long as they can get connected to the Internet.
                        <br />
                        <br />Please note that the site is lightly moderated. We&#x27;ll honor all the postings, but we will exercise our right to remove spam, hostile, irrelevant and offending postings.</span>
                    <span>
                        <br />
                        <br />
                        <br />
                    </span>
                    <a href="<?php echo base_url('resources/news'); ?>">&gt; BROWSE NEWS ABOUT iMOS</a>
                    <br />
                </p>
            </div>
            <div id="IconBox">
                <div id="Icon1Box" class="iconBoxes">
                    <img src="<?php echo resource_url('img', 'home/OPicon.png'); ?>" class="introBoxIcon" />
                    <p class="introBoxIconText">
                        Online Platform
                    </p>
                </div>
                <div id="Icon2Box" class="iconBoxes">
                    <img src="<?php echo resource_url('img', 'home/IPicon.png'); ?>" class="introBoxIcon" />
                    <p class="introBoxIconText">
                        Interactive Platform
                    </p>
                </div>
                <div id="Icon3Box" class="iconBoxes">
                    <img src="<?php echo resource_url('img', 'home/RTSicon.png'); ?>" class="introBoxIcon" />
                    <p class="introBoxIconText">
                        Real Time Simulation
                    </p>
                </div>
            </div>
        </div>
        <div id="ScreenShotBox" class="clearfix">
            <img id="imageSS1" src="<?php echo resource_url('img', 'home/Screen%20Dummy%20Template%20B1.png'); ?>" class="screenShotImage" />
            <img id="ImageSS2" src="<?php echo resource_url('img', 'home/Screen%20Dummy%20Template%20B3.png'); ?>" class="screenShotImage" />
        </div>
    </div>
    <!-- Introduction - End -->
    <!-- Model Library - Start -->
    <div id="ModelLibraryIntroBox" class="clearfix">
        <div id="ModelLibraryIntroBoxContainer" class="clearfix">
            <div id="MLIconBox" class="clearfix">
                <img id="MLBigicon" src="<?php echo resource_url('img', 'home/MLBigicon.png'); ?>" />
            </div>
            <div id="MLTextBox" class="clearfix">
                <p>
                    <span class="textTitle">Expanding model library</span>
                    <span>
                        <br />
                        <br />
                    </span>
                    <span>It is the intention of iMOS to provide an authoring tool for model developer to upload their model implemented in Verilog-A code directly to iMOS for users to test and evaluate. Currently we are using the Automatic Device Model Synthesizer
                        &#x28;ADMS&#x29; together with experienced programmers to help the compilation of worthwhile models to the i-MOS platform.</span>
                    <span>
                        <br />
                        <br />
                    </span>
                    <a href="<?php echo base_url(); ?>">&gt; Launch Model Library</a>
                    <br />
                </p>
            </div>
            <div id="MLitemBox" class="clearfix">
                <?php foreach ($top_models as $key => $model) : ?>
                <a href="<?php echo base_url('modelsim/model/' . $model->id);?>">
                    <div class="clearfix modelBoxContainer">
                        <div class="modelBoxes">
                            <img alt="<?php echo $model->name; ?>" src="<?php echo resource_url('img', 'simulation/' . $model->name . '.png');?>" class="modelImage" />
                            <p class="modelInfo">
                                <span>
                                    <?php echo $model->icon_name . '<br/>' . $model->desc_name . '<br/>by ' . $model->organization; ?>
                                </span>
                            </p>
                            <div class="clearfix modelGreyBox">
                                <img src="<?php echo resource_url('img', 'home/messageIcon.svg'); ?>" class="MessageIcon" />
                                <font class="MessageNumber">
                                    <?php echo $model->countComment; ?>
                                </font>
                                <div class="modelRatingStars">
                                    <?php for ($i=0; $i<round($model->rate); $i++) : ?>
                                    <img src="<?php echo resource_url('img', 'home/yellowStar.svg'); ?>" class="ratingStar ratingLightStar" />
                                    <?php endfor; ?>
                                    <?php for ($i=round($model->rate); $i<5; $i++) : ?>
                                    <img src="<?php echo resource_url('img', 'home/greyStar.svg'); ?>" class="ratingStar ratingDimStar" />
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Model Library - End -->
    <!-- User Experience & News HighLights - Start -->
    <div id="UENHBox" class="clearfix">
        <div id="UserExperienceBox" class="clearfix">
            <p id="User_ExperienceTitle" class="textTitle">
                <span>User Experience</span>
                <br />
            </p>
            <div id="ExperienceBox" class="clearfix">
                <?php if (!empty($user_experience) && count($user_experience) > 0) $entry = $user_experience[0]; ?>
                <div id="EBox" class="clearfix">
                    <p class="EMessageText">
                        <span>“
                            <?php echo htmlspecialchars($entry->comment); ?> ”</span>
                        <br />
                    </p>
                    <p class="EMessageNameText">
                        <span>
                            <?php echo htmlspecialchars($entry->first_name . ' ' . $entry->last_name . ', ' . $entry->organization); ?>
                        </span>
                        <br />
                    </p>
                </div>
                <? endif; ?>
                    <?php if (!empty($user_experience) && count($user_experience) > 1) :
                                $entry = $user_experience[1]; ?>
                    <div id="E2Box" class="clearfix">
                        <p class="EMessageText">
                            <span>“
                                <?php echo htmlspecialchars($entry->comment); ?> ”</span>
                            <br />
                        </p>
                        <p class="EMessageNameText">
                            <span>
                                <?php echo htmlspecialchars($entry->first_name . ' ' . $entry->last_name . ', ' . $entry->organization); ?>
                            </span>
                            <br />
                        </p>
                    </div>
                    <?php endif; ?>
                    <a href="<?php echo base_url('home/user_experience'); ?>">&gt; More User Experiences</a>
                    <br/>
                    <a href="<?php echo base_url('home/post_experience'); ?>">&gt; Post a User Experience</a>
            </div>
        </div>
        <div id="NewsHighlightsBox" class="clearfix">
            <p class="textTitle">
                <span>News Highlights</span>
                <br />
            </p>
            <div id="NLimageBox" class="clearfix">
                <img id="NLimage1" src="<?php echo resource_url('img', 'home/NLimage1.jpg'); ?>" class="NLimage" />
                <img id="NLImage2" src="<?php echo resource_url('img', 'home/NLimage2.jpg'); ?>" class="NLimage" />
                <img id="NLImage3" src="<?php echo resource_url('img', 'home/NLimage3.jpg'); ?>" class="NLimage" />
            </div>
            <div id="iMosActivitiesBox" class="clearfix">
                <div id="iMOSActivitiesTitleTextBox" class="clearfix">
                    <p id="iMOSActivitiesTitleText">
                        iMOS Activities
                    </p>
                    <a id="iMOSActivitiesMore" href="<?php echo base_url('home/activities'); ?>">&gt; more</a>
                </div>
                <div id="iMOSActivitiesTextBox" class="clearfix">
                    <p class="iMosActivityColumn1">
                        <?php for ($i=0; $i<min(3,count($activities)); $i++) : ?>
                        <?php $entry = $activities[$i]; ?>
                        <span class="iMosActivityTitle">
                            <?php echo date('d M Y', $entry->date); ?>
                        </span>
                        <br />
                        <span class="iMosActivityContent">
                            <?php echo $entry->content; ?>
                        </span>
                        <br />
                        <br />
                        <?php endfor; ?>
                    </p>
                    <p class="iMosActivityColumn2">
                        <?php for ($i=3; $i<min(6,count($activities)); $i++) : ?>
                        <?php $entry = $activities[$i]; ?>
                        <span class="iMosActivityTitle">
                            <?php echo date('d M Y', $entry->date); ?>
                        </span>
                        <br />
                        <span class="iMosActivityContent">
                            <?php echo $entry->content; ?>
                        </span>
                        <br />
                        <br />
                        <?php endfor; ?>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <!-- User Experience & News HighLights - End -->
    </div<?php endblock(); ?>

    <?php end_extend(); ?>
