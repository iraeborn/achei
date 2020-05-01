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
        <?php _widget('top_mapcityguide');?>
        <div class="container" id='content'>
            <div class="type-property-block">
                <div class="properties-sort properties-sort-main">
                    <h2 class="real-h">{lang_Realestates} : <span id="count_row"> <?php echo $total_rows; ?></span></h2>
                    <div class="options">
                        <a class="view-type active hidden-phone" ref="grid" href="#"><img src="assets/img/glyphicons/glyphicons_156_show_thumbnails.png" />
                        </a>
                        <a class="view-type hidden-phone" ref="list" href="#"><img src="assets/img/glyphicons/glyphicons_157_show_thumbnails_with_lines.png" />
                        </a>
                        <div class="form-group col-sm-3 pull-right">
                            <select class="span3 selectpicker-small pull-right">
                                <option value="date ASC" {order_dateASC_selected}>{lang_DateASC}</option>
                                <option value="date DESC" {order_dateDESC_selected}>{lang_DateDESC}</option>
                                <option value="field_44_int ASC" {order_priceASC_selected}>{lang_BeacheDistance}</option>
                                <option value="field_56_int ASC" {order_priceASC_selected}>{lang_RatingASC}</option>
                                <option value="field_56_int DESC" {order_priceDESC_selected}>{lang_RatingDESC}</option>
                            </select>
                        </div>
                        <span class="pull-right hidden-xs">{lang_OrderBy}&nbsp;&nbsp;&nbsp;</span>
                    </div>
                </div>
            </div>
            <div class="mobileswap-box"></div>
            <div class="row main-row">
                <div class="content col-sm-8 col-md-9">
                    <?php _widget('center_recentproperties'); ?>  
                    <!-- /.property-carousel-wrapper -->
                    <div class="content">
                        <h1 class="page-header">{page_title}</h1>
                        <div class="post box">
                            <div class="">{page_body}</div>
                            <div style="padding: 20px 0;">
                                <?php if(false): ?>
                                    <br />
                                    <script type='text/javascript'>
                                    var ws_wsid = '';
                                    <?php
                                    $address = $page_navigation_title;
                                    if(!empty($page_address))
                                        $address = $page_address;
                                    $address = strip_tags($address);

                                    echo "var ws_address = '$address';";
                                    ?>
                                    var ws_width = '500';
                                    var ws_height = '336';
                                    var ws_layout = 'horizontal';
                                    var ws_commute = 'true';
                                    var ws_transit_score = 'true';
                                    var ws_map_modules = 'all';
                                    </script><style type='text/css'>#ws-walkscore-tile{position:relative;text-align:left}#ws-walkscore-tile *{float:none;}#ws-footer a,#ws-footer a:link{font:11px/14px Verdana,Arial,Helvetica,sans-serif;margin-right:6px;white-space:nowrap;padding:0;color:#000;font-weight:bold;text-decoration:none}#ws-footer a:hover{color:#777;text-decoration:none}#ws-footer a:active{color:#b14900}</style><div id='ws-walkscore-tile'><div id='ws-footer' style='position:absolute;top:318px;left:8px;width:488px'><form id='ws-form'><a id='ws-a' href='http://www.walkscore.com/' target='_blank'>What's Your Walk Score?</a><input type='text' id='ws-street' style='position:absolute;top:0px;left:170px;width:286px' /><input type='image' id='ws-go' src='http://cdn2.walk.sc/2/images/tile/go-button.gif' height='15' width='22' border='0' alt='get my Walk Score' style='position:absolute;top:0px;right:0px' /></form></div></div><script type='text/javascript' src='http://www.walkscore.com/tile/show-walkscore-tile.php'></script>
                                    <?php endif; ?>

                                <?php _widget('center_imagegallery');?>

                                {has_page_documents}
                                <h2>{lang_Filerepository}</h2>
                                <ul>
                                {page_documents}
                                <li>
                                    <a href="{url}">{filename}</a>
                                </li>
                                {/page_documents}
                                </ul>
                                {/has_page_documents}
                            </div>
                        </div><!-- /.post -->
                    </div><!-- /.content -->
                </div>
                <!-- /.content -->
                <div class="sidebar col-sm-4 col-md-3">
                    <?php _widget("right_search"); ?>
                    <?php _widget("right_facebooklike"); ?>
                    <?php _widget("right_agents"); ?>
                    <!-- /.widget -->
                    
                    <?php _widget('right_adsverticalsmall'); ?>

                    <?php _widget( "right_recentproperties");?>
                    <!-- /.widget -->
                </div>
                <!-- /.sidebar -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->

       <?php _widget( "bottom_partners"); ?>
        <!-- /.widget -->

        <?php _widget( "bottom_choosecolor"); ?>
        <!-- /.widget -->
    </div>
    <!-- /.main -->
    <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'standart')); ?>
</div>
<!-- /.page-wrapper-->
<?php _widget('custom_javascript');?>
</body>
</html>