<div class="widget">
    <div class="widget-title">
        <h2>{lang_Agents}</h2>
    </div><!--/.widget-title -->
    <div class="widget-content widget">
        <form class="form-search agents search-box" action="<?php echo current_url().'#content'; ?>" method="get">
            <div class="control-group">
                <input name="search-agent" type="text" placeholder="{lang_CityorName}" value="<?php echo $this->input->get('search-agent'); ?>" class="form-control input-medium" />
                <button type="submit" class="btn"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
    <div class="widget-content">
        
    <?php if(!empty($paginated_agents)): foreach($paginated_agents as $item): ?>
        <div class="agent-small">
            <div class="agent-small-inner">
                <div class="agent-small-image">
                    <a href="<?php  _che($item['agent_url']);?>" class="agent-small-image-inner">
                       <img src="<?php echo _simg($item['image_url'], '90x90'); ?>" alt="<?php  _che($item['name_surname']);?>" />
                    </a><!-- /.agent-small-image-inner -->
                </div><!-- /.agent-small-image -->

                <div class="agent-small-content">
                    <h3 class="agent-small-title">
                        <a href="<?php  _che($item['agent_url']);?>"><?php  _che($item['name_surname']);?></a>
                    </h3>

                    <div class="agent-small-email">
                        <i class="fa fa-at"></i> <a href="mailto:<?php  _che($item['mail']);?>?subject={lang_Estateinqueryfor}: {page_title}"><?php  _che($item['mail']);?></a>
                    </div><!-- /.agent-small-email -->

                    <div class="agent-small-phone">
                        <i class="fa fa-phone"></i> <?php  _che($item['phone']);?>
                    </div><!-- /.agent-small-phone -->
                </div><!-- /.agent-small-content -->
            </div><!-- /.agent-small-inner -->
        </div><!-- /.agent-small -->       
      <?php endforeach;?>
        <?php else:?>
            <div class="alert alert-success">
            <?php echo lang_check('Not found');?>
            </div>
       <?php endif;?>
    </div><!-- /.widget-content -->
</div>