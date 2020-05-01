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
    <div id="map" class="map cityguide-map" data-transparent-marker-image="assets/img/transparent-marker-image.png"></div>
    {template_search-filter-cityguide}<!-- /.map-filter-horizontal --> 

</div><!-- /.map-wrapper -->