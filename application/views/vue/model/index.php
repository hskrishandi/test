<?php extend('layouts/layout.php'); ?>

    <?php startblock('title'); ?>
        Models
    <?php endblock(); ?>

    <?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'sass/build/model.css'); ?>" media="all" />
    <?php endblock(); ?>

    <?php startblock('script'); ?>
        <?php echo get_extended_block(); ?>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"  type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo resource_url('js', 'vue/model/app.js'); ?>" type="text/javascript" charset="utf-8"></script>
    <?php endblock(); ?>

    <?php startblock('content'); ?>
    <div id="app">
        <div class="side-menu">
            <h4 class="top-title">
                {{ sideMenu.title }}
                <button class="top-button"><img src="<?php echo resource_url('img', 'modelpage_icon/Asset 2.png'); ?>" /></button>
            </h4>
            <h4 class="library-title">
                {{ library.default.title }}
                <button><img src="<?php echo resource_url('img', 'modelpage_icon/Asset 1.png'); ?>" /></button>
            </h4>
            <ul>
                <li v-for="m in model">{{ m.short_name }}</li>
            </ul>
            <h4 class="library-title">
                {{ library.user.title }}
                <button><img src="<?php echo resource_url('img', 'modelpage_icon/Asset 3.png'); ?>" /></button>
                <button><img src="<?php echo resource_url('img', 'modelpage_icon/Asset 4.png'); ?>" /></button>
            </h4>
            <ul class="mylibrary-item">
                <li><button><img src="<?php echo resource_url('img', 'modelpage_icon/Asset 5.png'); ?>" /></button>  eDouG</li>
                <li><button><img src="<?php echo resource_url('img', 'modelpage_icon/Asset 5.png'); ?>" /></button>  SNCNFET</li>
                <li><button><img src="<?php echo resource_url('img', 'modelpage_icon/Asset 5.png'); ?>" /></button>  e-HEMT</li>
                <li><button><img src="<?php echo resource_url('img', 'modelpage_icon/Asset 5.png'); ?>" /></button>  eNaW</li>
            </ul>
        </div>
        <div class="main-content">
            <div class="top-menu">Select model for viewing in the below panel</div>
            <div class="discription-comment">Description and Comments</div>
            <div class="clearfix MLitemBox">
              <div class="clearfix modelBoxContainer" v-for="m in model">
                  <div class="modelBoxes">
                      <div class="modelImage">
                          <img :src="m.imageUrl" />
                      </div>
                      <div class="modelInfo">
                              <div>{{{ m.icon_name }}}</div>
                              <div>{{ m.desc_name }}</div>
                              <div>by {{ m.organization }}</div>
                     </div>
                     <div class="clearFloat"></div>
                     <div class="clearfix modelGreyBox">
                         <img src="<?php echo resource_url('img', 'home/messageIcon.svg'); ?>" class="MessageIcon" />
                         <font class="MessageNumber">
                         </font>
                         <div class="modelRatingStars">
                             <img src="<?php echo resource_url('img', 'home/greyStar.svg'); ?>" class="ratingStar ratingDimStar" v-for="i in 5-Math.round(m.rate)"/>
                             <img src="<?php echo resource_url('img', 'home/yellowStar.svg'); ?>" class="ratingStar ratingLightStar" v-for="i in Math.round(m.rate)"/>
                         </div>
                    </div>
                 </div>
            </div>
          </div>
        </div>
    </div>
    <?php endblock(); ?>

<?php end_extend(); ?>
