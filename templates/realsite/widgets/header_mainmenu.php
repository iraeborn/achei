   <div class="container">
       <div class="header-inner">
           <div class="header-main">
               <div class="header-title">
                   <a href="{homepage_url_lang}">
                       <img src="<?php echo $website_logo_url; ?>" alt="{settings_websitetitle}">

                        <span style="display: none;visibility: hidden;">{settings_websitetitle}</span>
                   </a>
               </div><!-- /.header-title -->

               <div class="header-navigation">
                   <div class="nav-main-wrapper">
    <div class="nav-main-title visible-xs">
        <a href="{homepage_url_lang}">
            <img src="<?php echo $website_logo_url; ?>" alt="{settings_websitetitle}">
             <span>{settings_websitetitle}</span>
        </a>
    </div><!-- /.nav-main-title -->

    <div class="nav-main-inner">
        <nav>
              <?php _widget('menu'); ?>
            <!-- /.nav -->
        </nav>
    </div><!-- /.nav-main-inner -->
</div><!-- /.nav-main-wrapper -->
<button type="button" class="navbar-toggle">
    <span class="sr-only"><?php _l('Toggle navigation');?></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</button>
               </div><!-- /.header-navigation -->
           </div><!-- /.header-main -->
            <?php if(config_db_item('property_subm_disabled')==FALSE):  ?>
                <?php if(config_db_item('enable_qs') == 1): ?>
                    <a class="header-action" href="<?php echo site_url('fquick/submission/'.$lang_code); ?>" title="<?php echo lang_check('Quick add listing');?>">
                        <i class="fa fa-plus"></i>
                    </a><!-- /.header-action -->
                <?php else: ?>
                    <a class="header-action" href="{myproperties_url}" title="{lang_Addproperty}">
                        <i class="fa fa-plus"></i>
                    </a><!-- /.header-action -->
                <?php endif; ?>
           <?php endif;?>
       </div><!-- /.header-inner -->
   </div><!-- /.container -->