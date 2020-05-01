<!DOCTYPE html>
<html>

<head>
     {template_head}
    <link rel="stylesheet" type="text/css" href="assets/css/realsite-admin.css">
    {has_color}
    <link href="assets/css/variants/admin_{color}.css" rel="stylesheet">
    {/has_color}
    
</head>

<body class="open hide-secondary-sidebar fullscreen">
    <div class="admin-wrapper">
        <div class="admin-navigation">
    <div class="admin-navigation-inner">
        <nav>
            <ul class="menu">
                <li class="avatar lang-menu">
                 {print_lang_menu}
                </li>
            </ul>
            <ul id="search_option_2" class="menu menu-onmap tabbed-selector_2">
                <li class="all-button">
                    <a class="filter-type" href="#"><strong><i class="glyphicon glyphicon-th"></i></strong> <span><?php echo lang_check('All'); ?></span></a>
                </li>
                <?php foreach ($options_values_arr_2 as $key=>$val): ?>
                 <li class=" cat_<?php echo $key;?>">
                       <a href="#" class="filter-type"><strong>
                       
                        <?php
                            // Fetch image if uploaded, in other case use standard from template
                            $type_img = '';
                            
                            if(!empty($options_obj_2->image_gallery))
                            {
                                $gallery_images = explode(',', $options_obj_2->image_gallery);
                                $value_index = $key;
                                if(isset($gallery_images[$value_index]) && !empty($gallery_images[$value_index]))
                                {
                                    $type_img = base_url('files/'.$gallery_images[$value_index]);
                                }
                            }
                            
                            if(empty($type_img))
                            {
                                $type_img = 'assets/img/markers/'.((file_exists('templates/'.$settings_template.'/assets/img/markers/type_'.  $key.'.png')) ? 'type_'.$key : 'house').'.png';
                            }
                        ?>
                        
                        <img src="<?php echo $type_img; ?>" />
                       
                       </strong><span><?php echo $val; ?></span></a>
                </li>
                <?php endforeach;?>
            </ul>
            
        </nav>
        
        <div class="projects">
            <h2>{options_name_4}</h2>
            <ul id="search_option_4" class="menu-onmap tabbed-selector">
            <li class="all-button"><a href="#"><?php echo lang_check('All'); ?></a></li>
            {options_values_li_4}
           </ul>
        </div><!-- /.projects -->
        <div class="layer"></div>
    </div><!-- /.admin-navigation-inner -->
</div><!-- /.admin-navigation -->

        <div class="admin-content">
            <div class="admin-content-inner">
                <div class="admin-content-header">
                    <div class="admin-content-header-inner">
                        <div class="container-fluid header-navigation">
                            <div class="admin-content-header-logo">
                                <a href="{homepage_url_lang}">
                                    <img src="assets/img/logo_black.png" alt="{settings_websitetitle}">
                                    {settings_websitetitle}
                                </a>
                            </div><!-- /admin-content-header-logo -->

                            <div class="admin-content-header-menu">
                            <div class="admin-content-header-menu">
                                <nav class="menu-dark">
                                 <?php _widget('menu'); ?>
                                </nav>
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-main">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            </div><!-- /.admin-content-header-menu  -->
                        </div><!-- /.container-fluid -->
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
                    </div><!-- /.admin-content-header-inner -->
                </div><!-- /.admin-content-header -->
                <div class="search-form hidden">
                    <form class="form-inline form-real">
                        <input id="search_option_is_featured" type="checkbox" class="form-control hidden" value="true<?php _l('is_featured'); ?>" <?php echo search_value('is_featured', 'checked'); ?> />
                    </form>
                </div>
                <div class="admin-content-main">
                    <div id="map" style="height: 100%" class="map"  data-transparent-marker-image="assets/img/transparent-marker-image.png"></div>
                </div><!-- /.container-fluid -->

 <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'small-footer')); ?>
            </div><!-- /.admin-content-main-inner -->
        </div><!-- /.admin-content -->
    </div><!-- /.admin-landing-wrapper -->

    <script type="text/javascript">

 $(document).ready(function(){
 
    $(document).ready(function(){
        // option
        if($('#map').length){

        <?php if(config_db_item('map_version') =='open_street'):?>

            map = L.map('map', {
                <?php if(config_item('custom_map_center') === FALSE): ?>
                center: [{all_estates_center}],
                <?php else: ?>
                center: [<?php echo config_item('custom_map_center'); ?>],
                <?php endif; ?>
                zoom: {settings_zoom}+1,
                scrollWheelZoom: scrollWheelEnabled,
                dragging: !L.Browser.mobile,
                tap: !L.Browser.mobile
            });     
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var positron = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png').addTo(map);

            <?php foreach($all_estates as $item): ?>
                <?php
                    if(!isset($item['gps']))break;
                    if(empty($item['gps']))continue;
                ?>
                var marker = L.marker(
                    [<?php _che($item['gps']); ?>],
                    {icon: L.divIcon({
                            html: '<img src="<?php _che($item['icon'])?>">',
                            className: 'open_steet_map_marker marker <?php _che($item['option_6']); ?>-mark-color',
                            iconSize: [40, 40],
                            popupAnchor: [55, -20],
                            iconAnchor: [20, 40],
                        })
                    }
                )/*.addTo(map)*/;
                marker.bindPopup("<?php echo _generate_popup($item, true); ?>", jpopup_customOptions);
                clusters.addLayer(marker);
                markers.push(marker);
            <?php endforeach; ?>
            map.addLayer(clusters);
        <?php else:?>

        var style_map = mapStyle || '';
        

        var mapOptions = {
            <?php if(config_item('custom_map_center') === FALSE): ?>
            center: new google.maps.LatLng({all_estates_center}),
            <?php else: ?>
            center: new google.maps.LatLng(<?php echo config_item('custom_map_center'); ?>),
            <?php endif; ?>
            zoom: {settings_zoom},
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: scrollwheelEnabled,
            mapTypeControlOptions: {
              mapTypeIds: c_mapTypeIds,
              position: google.maps.ControlPosition.TOP_RIGHT
            },
            styles: mapStyle
        };

        map_main = new google.maps.Map(document.getElementById('map'), mapOptions);

        <?php foreach($all_estates as $item): ?>
            <?php
                if(!isset($item['gps']))break;
                if(empty($item['gps']))continue;
            ?>

        var myLatlng = new google.maps.LatLng(<?php _che($item['gps']); ?>);
        var callback = {
                        'click': function(map, e){
                            var activemarker = e.activemarker;
                            jQuery.each(markers, function(){
                                this.activemarker = false;
                            })

                            sw_infoBox.close();
                            if(activemarker) {
                                e.activemarker = false;
                                return true;
                            }

                            var boxOptions = {
                                content: "<?php echo _generate_popup($item, true); ?>",
                                disableAutoPan: false,
                                alignBottom: true,
                                maxWidth: 0,
                                pixelOffset: new google.maps.Size(-85, -145),
                                zIndex: null,
                                closeBoxMargin: "0",
                                closeBoxURL: "",
                                infoBoxClearance: new google.maps.Size(1, 1),
                                isHidden: false,
                                pane: "floatPane",
                                enableEventPropagation: false,
                            };

                            sw_infoBox.setOptions( boxOptions);
                            sw_infoBox.open( map, e );

                            e.activemarker = true;
                        }
                };
                
        var marker_inner ='<img src="<?php _che($item['icon'])?>">';
        var arg = {'marker_classes':"marker <?php _che($item['option_6']); ?>-mark-color"};
        var marker = new CustomMarker(myLatlng,map_main,marker_inner,callback, arg);
        markers.push(marker);

        <?php endforeach; ?>

        marker_clusterer = new MarkerClusterer(map_main, markers, clusterConfig);

        if(myLocationEnabled){
            var controlDiv = document.createElement('div');
            controlDiv.index = 1;
            map_main.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv);
            HomeControl(controlDiv, map_main)
            }


        if(rectangleSearchEnabled)
         {
             var controlDiv2 = document.createElement('div');
             controlDiv2.index = 2;
             map_main.controls[google.maps.ControlPosition.RIGHT_TOP].push(controlDiv2);
             RectangleControl(controlDiv2, map_main)
         } 

        <?php endif;?>
        }
    })

})

$('document').ready(function(){
    $('#nav-main').addClass('collapse');
})

</script>

<?php _widget('custom_javascript');?>
</body>
</html>
