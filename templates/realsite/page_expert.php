<!DOCTYPE html>
<html>
<head>
    {template_head}
</head>
<body>
<div class="page-wrapper">
     <div class="header header-standard">
        <?php _widget('header_loginmenu');?>
        <?php _widget('header_mainmenu');?>
    </div><!-- /.header-->
    <div class="main">
        <div class="container">
            <div class="row">
                <?php if(file_exists(APPPATH.'controllers/admin/expert.php')):?>
                <div class="content col-sm-8 col-md-9">
                <?php else:?>
                <div class="col-md-12">  
                <?php endif;?>
                    <h1 class="page-header">{page_title}</h1>
                    <div class="">{page_body}</div>
                    <br style="clear: both;" />
                    <?php _widget( 'center_imagegallery'); ?>
            <?php if(file_exists(APPPATH.'controllers/admin/expert.php')):?>
            <?php foreach($expert_module_all as $key=>$row):?> 
                      <div class="faq-item box">
            <div class="faq-item-question">
                <h2><?php echo $row->question; ?></h2>
            </div><!-- /.faq-item-question -->

            <div class="faq-item-answer">
                <p>
                  <?php echo $row->answer; ?>
                </p>
            </div><!-- /.faq-item-answer -->

            <!-- <div class="faq-item-meta">
                Was this answer helpful?
                <span class="rate">
                    <a href="pages-faq.html#">Yes</a><span class="separator">/</span><a href="pages-faq.html#">No</a>
                </span>
            </div> --><!-- /.faq-item-meta -->
        </div><!-- /.faq-item -->
            <?php endforeach;?>
            <?php endif;?>
        
                </div>
                <!-- /.content -->
                <?php if(file_exists(APPPATH.'controllers/admin/expert.php')):?>
                <div class="sidebar col-sm-4 col-md-3">
                                          <div class="widget">
    <div class="widget-title">
        <h2><?php _l('Custom Menu');?></h2>
    </div><!-- /.widget-title -->
    <div class="widget-content">
        <ul class="menu">
                 <?php foreach($categories_expert as $id=>$category_name):?>
            <?php if($id != 0): ?>
                <li><a href="{page_current_url}?cat=<?php echo $id; ?>#news"><?php echo $category_name; ?></a></li>
            <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div><!-- /.widget-content -->
    
                   <div class="widget">
    <div class="widget-title">
        <h2 id="form">{lang_AskExpert}</h2>
    </div><!-- /.widget-title -->

    <div class="widget-content">
                                {validation_errors} {form_sent_message}
                                <form method="post" class="property-form" action="{page_current_url}#form">
                                    <!-- The form name must be set so the tags identify it -->
                                    <input type="hidden" name="form" value="contact" />
                                    
                                    <div class="control-group {form_error_firstname}">
                                        <input class="form-control" id="firstname" name="firstname" type="text" placeholder="{lang_FirstLast}" value="{form_value_firstname}" />
                                    </div>
                                    <div class="control-group {form_error_email}">
                                        <input class="form-control" id="email" name="email" type="text" placeholder="{lang_Email}" value="{form_value_email}" />
                                    </div>
                                    <div class="control-group {form_error_phone}">
                                        <input class="form-control" id="phone" name="phone" type="text" placeholder="{lang_Phone}" value="{form_value_phone}" />
                                    </div>
                                    
                                    <?php if(config_item( 'captcha_disabled')===FALSE): ?>
                                    <div class="control-group ">
                                        <div class="row">
                                            <div class="col-lg-6" style="padding-top:14px;">
                                                <?php echo $captcha[ 'image']; ?>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                                                <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(config_item('recaptcha_site_key') !== FALSE): ?>
                                    <div class="control-group" >
                                        <label class="control-label captcha"></label>
                                        <div class="">
                                            <?php _recaptcha(true); ?>
                                       </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-group control-group {form_error_question}">
                                        <textarea id="question" name="question" rows="4" class="form-control" type="text" placeholder="{lang_Question}">{form_value_question}</textarea>
                                    </div>
                                    

                                <?php if(config_db_item('terms_link') !== FALSE): ?>
                                <?php
                                    $site_url = site_url();
                                    $urlparts = parse_url($site_url);
                                    $basic_domain = $urlparts['host'];
                                    $terms_url = config_db_item('terms_link');
                                    $urlparts = parse_url($terms_url);
                                    $terms_domain ='';
                                    if(isset($urlparts['host']))
                                        $terms_domain = $urlparts['host'];

                                    if($terms_domain == $basic_domain) {
                                        $terms_url = str_replace('en', $lang_code, $terms_url);
                                    }
                                ?>
                                <div class="control-group control-gt-terms">
                                  
                                  <div class="">
                                    <?php echo form_checkbox('option_agree_terms', 'true', set_value('option_agree_terms', false), 'class="ezdisabled" id="inputOption_terms"')?>
                                  <a target="_blank" href="<?php echo $terms_url; ?>"><?php echo lang_check('I Agree To The Terms & Conditions'); ?></a>
</div>
                                </div>
                                <?php endif; ?>
                                



                                <?php if(config_db_item('privacy_link') !== FALSE && sw_count($not_logged)>0): ?>
                                                            <?php

                                $site_url = site_url();
                                $urlparts = parse_url($site_url);
                                $basic_domain = $urlparts['host'];
                                $privacy_url = config_db_item('privacy_link');
                                $urlparts = parse_url($privacy_url);
                                $privacy_domain ='';
                                if(isset($urlparts['host']))
                                    $privacy_domain = $urlparts['host'];

                                if($privacy_domain == $basic_domain) {
                                    $privacy_url = str_replace('en', $lang_code, $privacy_url);
                                }
                            ?>
                                <div class="control-group control-gt-terms">
                                  
                                  <div class="">
                                    <?php echo form_checkbox('option_privacy_link', 'true', set_value('option_privacy_link', false), 'class="ezdisabled" id="inputOption_privacy_link"')?>
                                 <a target="_blank" href="<?php echo $privacy_url; ?>"><?php echo lang_check('I Agree The Privacy'); ?></a>
 </div>
                                </div>
                                <?php endif; ?>
                                    <button class="btn" type="submit">{lang_Send}</button>
                                </form>
    </div><!-- /.widget-content -->
    
   <?php _widget('best-agents'); ?>
</div><!-- /.widget -->

    
</div><!-- /.widget -->
                    
                </div>
                <!-- /.sidebar -->
                <?php endif;?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.main -->
    <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'standart')); ?>
<?php _widget('custom_javascript');?>
</div>
<!-- /.page-wrapper-->
</body>
</html>