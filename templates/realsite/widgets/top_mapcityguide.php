<style type="text/css">
    
    #mylocation {
        margin-top: 90px !important;
    }
    
    div .gmnoprint:last-child {
        margin-top: 100px !important;
    }
    
    .leaflet-top {
        top: 100px;
    }
    @media (max-width: 768px) {
        .leaflet-top {
            top: 0;
        }
        
        div .gmnoprint:last-child {
            margin-top: 10px !important;
        }

        #mylocation {
            margin-top: 0 !important;
        }
    }
    
</style>

<script>
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
                            
                            /* moved map */
                            if($('.map-filter-horizontal.search-select.top_map_search').length) {
                                var h = $('.map-filter-horizontal.search-select.top_map_search').get(0).getBoundingClientRect().top + 95;
                                setTimeout(function(){
                                    var p = $('.infobox').get(0).getBoundingClientRect();
                                    console.log(p.top);
                                    if(p.top<h) {
                                       var y = 0; 
                                       y = y + p.top - h;
                                       map.panBy(0, y);
                                   }
                                }, 200)
                            }
                           /* moved map */
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
</script>


<div class="map-wrapper">
    
    <?php if(config_item('tree_field_enabled') === TRUE && config_item('multiple_enabled') !== FALSE):?>
    <script>

        /* [START] TreeField */

        $(function() {
            $(".search-form .TREE-GENERATOR select").change(function(){
                var s_value = $(this).val();
                var s_name_splited = $(this).attr('name').split("_"); 
                var s_level = parseInt(s_name_splited[3]);
                var s_lang_id = s_name_splited[1];
                var s_field_id = s_name_splited[0].substr(6);
                // console.log(s_value); console.log(s_level); console.log(s_field_id);

                load_by_field($(this));

                // Reset child selection and value generator
                var generated_val = '';
                $(this).parent().parent()
                .find('select').each(function(index){
                    // console.log($(this).attr('name'));
                    if(index > s_level)
                    {
                        //$(this).html('<option value=""><?php echo lang_check('No values found'); ?></option>');

                        $(this).find("option:gt(0)").remove();
                        $(this).val('');
                        $(this).selectpicker('refresh');
                    }
                    else
                        generated_val+=$(this).find("option:selected").text()+" - ";
                });
                //console.log(generated_val);
                $("#sinputOption_"+s_lang_id+"_"+s_field_id).val(generated_val);

            });

        });

        function load_by_field(field_element, autoselect_next, s_values_splited)
        {
            if (typeof autoselect_next === 'undefined') autoselect_next = false;
            if (typeof s_values_splited === 'undefined') s_values_splited = [];

            var s_value = field_element.val();
            var s_name_splited = field_element.attr('name').split("_"); 
            var s_level = parseInt(s_name_splited[3]);
            var s_lang_id = s_name_splited[1];
            var s_field_id = s_name_splited[0].substr(6);
            // console.log(s_value); console.log(s_level); console.log(s_field_id);

            // Load values for next select
            var ajax_indicator = field_element.parent().parent().parent().find('.ajax_loading');
            var select_element = $("select[name=option"+s_field_id+"_"+s_lang_id+"_level_"+parseInt(s_level+1)+"]");
            if(select_element.length > 0 && s_value != '')
            {
                ajax_indicator.css('display', 'block');
                $.getJSON( "<?php echo site_url('api/get_level_values_select'); ?>/"+s_lang_id+"/"+s_field_id+"/"+s_value+"/"+parseInt(s_level+1), function( data ) {
                    //console.log(data.generate_select);
                    //console.log("select[name=option"+s_field_id+"_"+s_lang_id+"_level_"+parseInt(s_level+1)+"]");
                    ajax_indicator.css('display', 'none');

                    select_element.html(data.generate_select);
                    select_element.selectpicker('refresh');

                    if(autoselect_next)
                    {
                        if(s_values_splited[s_level+1] != '')
                        {
                            select_element.find('option').filter(function () { return $(this).html() == s_values_splited[s_level+1]; }).attr('selected', 'selected');
                            load_by_field(select_element, true, s_values_splited);


                        }
                    }
                });
            }
        }

        /* [END] TreeField */

    </script>

    <div class="map-filter-horizontal search-select top_map_search" style="top: 0;bottom: initial;z-index: 5;padding: 10px 0 0px 0;">
            <div class="container search-form">
                <form class="form-inline form-real">
                    <div class="row">

                    <!-- [START] TreeSearch -->
                    <?php if(config_item('tree_field_enabled') === TRUE):?>
                    <?php

                        $CI =& get_instance();
                        $CI->load->model('treefield_m');
                        $field_id = 64;
                        $drop_options = $CI->treefield_m->get_level_values($lang_id, $field_id);
                        $drop_selected = array();
                        echo '<div class="tree TREE-GENERATOR">';
                        echo '<div class="field-tree form-group col-sm-3">';
                        echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_0', $drop_options, $drop_selected, 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_0'.'"');
                        echo '</div>';

                        $levels_num = $CI->treefield_m->get_max_level($field_id);

                        if($levels_num>0)
                        for($ti=1;$ti<=$levels_num;$ti++)
                        {
                            $lang_empty = lang('treefield_'.$field_id.'_'.$ti);
                            if(empty($lang_empty))
                                $lang_empty = lang_check('Please select parent');

                            echo '<div class="field-tree form-group col-sm-3">';
                            echo form_dropdown('option'.$field_id.'_'.$lang_id.'_level_'.$ti, array(''=>$lang_empty), array(), 'class="form-control selectpicker tree-input" id="sinputOption_'.$lang_id.'_'.$field_id.'_level_'.$ti.'"');
                            echo '</div>';
                        }
                        echo '</div>';

                    ?>
                    <?php endif; ?>
                    <!-- [END] TreeSearch -->
                    </div>

                    <br style="clear:both;" />
                    <div style="display:none;"><div id="tags-filters"> </div>

                    </div>
                    <div class="form-group" id='addit-search-start' style="display:none;">

                    <img id="ajax-indicator-1" src="assets/img/ajax-loader.gif" />
                    </div>

                </form>
            </div><!-- /.container -->
        </div>
    <?php endif; ?>   

    <div id="map" class="map cityguide-map" data-transparent-marker-image="assets/img/transparent-marker-image.png"></div>
    {template_search-filter-cityguide}<!-- /.map-filter-horizontal --> 
</div><!-- /.map-wrapper -->

<script type="text/javascript">

$(document).ready(function(){
    
    if(!$('#search-start').length){
        $('#addit-search-start').append('<button id="search-start" type="submit" class="btn hidden">&nbsp;&nbsp;{lang_Search}&nbsp;&nbsp;</button>')
        $('#search-start').click(function () { 
          manualSearch(0);
          return false;
        });
    }
    
    <?php if(config_item('auto_map_search')==TRUE):?>
    $(".search-form .TREE-GENERATOR select").change(function(){
        //$('#search-start').trigger('click');
        manualSearch(0, false);
    })
    <?php endif;?>
})

</script>
