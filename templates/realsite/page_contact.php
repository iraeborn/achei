<!DOCTYPE html>
<html>
<head>
    {template_head}

    <script>
        $(document).ready(function(){
        var map;
        
        if($('#map-contact').length){

            <?php if(config_db_item('map_version') =='open_street'):?>
            var contact_map;
            contact_map = L.map('map-contact', {
                center: [{settings_gps}],
                zoom: {settings_zoom}+7,
                scrollWheelZoom: scrollWheelEnabled,
            });     
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(contact_map);
            var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(contact_map);
            var property_marker = L.marker(
                [{settings_gps}],
                {icon: L.divIcon({
                        html: '<img src="assets/img/markers/house.png">',
                        className: 'marker apartment-mark-color',
                        iconSize: [40, 40],
                        popupAnchor: [+2, -40],
                        iconAnchor: [17, 47],
                    })
                }
            ).addTo(contact_map);

            property_marker.bindPopup("{settings_address},<br />{lang_GPS}: {settings_gps}");
            <?php else:?>
            var sw_infoBox = new google.maps.InfoWindow({
                content: ''
            });
            var myLocationEnabled = true;
            var style_map = '';
            var scrollwheelEnabled = false;
            var markers1 = new Array();
            var markers = new Array();
            var mapOptions = {
                center: new google.maps.LatLng({settings_gps}),
                zoom: {settings_zoom},
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: scrollwheelEnabled,
                styles: mapStyle
            };

            var map = new google.maps.Map(document.getElementById('map-contact'), mapOptions);

            var myLatlng = new google.maps.LatLng({settings_gps});
            var callback = {
                        'click': function(map, e){
                            var activemarker = e.activemarker;
                            jQuery.each(markers, function(){
                                this.activemarker = false;
                            })

                            if(activemarker) {
                                sw_infoBox.close();
                                e.activemarker = false;
                                return true;
                            }

                            sw_infoBox.setContent("<?php _jse($settings_websitetitle); ?> <br /><?php echo lang_check('Address');?>: <?php _jse($settings_address); ?> </a>");
                            sw_infoBox.open(map, e);

                            e.activemarker = true;
                        }
                };
            var marker_inner ='<img  src="assets/img/markers/house.png" alt="">';
            var arg = {'marker_classes':"marker apartment-mark-color"};
            var marker = new CustomMarker(myLatlng,map,marker_inner,callback, arg);
            
            <?php endif;?>
            
        }
        })

    </script>
</head>
<body>
<div class="page-wrapper">
     <div class="header header-standard">
        <?php _widget('header_loginmenu');?>
        <?php _widget('header_mainmenu');?>
    </div><!-- /.header-->
    <div class="main">
        <div id="map-contact"></div>
        <!-- /#map-contact -->
        <div class="container">
            <div class="content">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                {page_body}
                            </div>
                            <!-- /.col-* -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.col-* -->
                    <div class="col-sm-6">
                        <div class="box">
                            {has_settings_email}
                            <h2 class="mt0" id="form">{lang_Contactform}</h2>
                            <div id="contactForm" class="contact-form">
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
                                    <div class="form-group control-group {form_error_message}">
                                        <textarea id="message" name="message" rows="4" class="form-control" placeholder="{lang_Message}">{form_value_message}</textarea>
                                    </div>

                                    <?php if(config_item( 'captcha_disabled')===FALSE): ?>
                                    <div class="form-group control-group">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6" style="padding-top:14px;">
                                                <?php echo $captcha[ 'image']; ?>
                                            </div>
                                            <div class="col-lg-9 col-md-8 col-sm-7   col-xs-5 ">
                                                <input class="captcha form-control {form_error_captcha}" name="captcha" type="text" placeholder="{lang_Captcha}" value="" />
                                                <input class="hidden" name="captcha_hash" type="text" value="<?php echo $captcha_hash; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(config_item('recaptcha_site_key') !== FALSE): ?>
                                    <div class="form-group control-group" >
                                        <label class="control-label captcha"></label>
                                        <div class="">
                                            <?php _recaptcha(true); ?>
                                       </div>
                                    </div>
                                    <?php endif; ?>
                                    

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
                            </div>
                            {/has_settings_email}
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col-* -->
                </div>
                <!-- /.row -->
                <?php _widget('center_imagegallery'); ?> 
            </div>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.main -->
    <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'standart')); ?>
</div>
<!-- /.page-wrapper-->
 <?php _widget('custom_javascript');?>
</body>
</html>