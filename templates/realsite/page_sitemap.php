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
                    <div class="content">
                        <h1 class="page-header">{page_title}</h1>
                        <div class="post box treefield_sitemap">
                            <div class="">{page_body}</div>
                            <div style="padding: 20px 0;">
                                <?php if(file_exists(APPPATH.'controllers/admin/treefield.php')):?>
                                <?php echo treefield_sitemap(64, $lang_id, 'ul'); ?> 
                                <br/>
                                <?php endif;?>
                                <h2>  <?php echo lang_check('Website sitemap');?> </h2>
                                <?php echo website_sitemap($lang_id, 'ul'); ?>
                            </div>
                        </div><!-- /.post -->
                        <?php _widget('center_imagegallery'); ?>
                    </div><!-- /.content -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div><!-- /.main -->
        <?php _subtemplate( 'footers', _ch($subtemplate_footer, 'standart')); ?>
    </div><!-- /.page-wrapper-->
    <?php _widget('custom_javascript');?>
</body>
</html>
