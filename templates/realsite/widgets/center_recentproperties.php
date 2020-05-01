<div class="mytestresult">
<div class="row">
    {has_no_results}
        <div class="col-sm-12 ">
            <div class="alert alert-success">
                {lang_Noestates}
            </div>
        </div>
    {/has_no_results}
    
    <div class="row-flex">
    <?php foreach($results as $key=>$item): ?>
    <?php
       /* if($key==0)echo '<div class="row">';*/
    ?>
        <?php _generate_results_item(array('key'=>$key, 'item'=>$item)); ?>
    <?php
       /* if( ($key+1)%3==0 )
        {
            echo '</div><div class="row">';
        }
        if( ($key+1)==sw_count($results) ) echo '</div>';*/
        endforeach;
    ?>
    </div>
</div>
<!-- /.row -->
<div class="center">
    <div class="pagination properties">
        {pagination_links}
    </div>
</div>
</div>