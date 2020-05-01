
<?php
$field_id =80 ;
?>
<?php if(isset(${'estate_data_option_'.$field_id}) && $options_obj_80->type=='SCHEDULING_TABLE' && strripos(${'estate_data_option_'.$field_id},'cal_') !== FALSE):?>
<div class="mb30">
    <h2 class="page-header"></h2>
        <?php
            $field_value = ${'estate_data_option_'.$field_id};

            $field_value_json = false;
            if(!empty($field_value)) {
                 @$obj = json_decode($field_value,true); 

                 if(!json_last_error()) {
                     $field_value_json = $obj;
                 }
            }
            
            $scheduling_days = array('cal_sunday','cal_monday','cal_tuesday','cal_wednesday','cal_thursday','cal_friday','cal_saturday');
            $scheduling_type = array('from','to');
            $col_list_explode = range(0, 23);
            $col_list_explode_2 = array('00','15','30','45');
            $scheduling_values = array();
            $scheduling_values['']='-';
            foreach($col_list_explode as $val)
            {
                foreach ($col_list_explode_2 as $key => $value) {
                    $scheduling_values[$val.':'.$value]=$val.':'.$value;
                }
            }
        ?>
        <table class="scheduling_table table table-bordered">
            <thead>
            <tr>
            <th><?php echo ${'options_name_'.$field_id};?></th>
            <?php foreach($scheduling_days as $col_val): ?>
                <th><?php echo lang_check($col_val); ?></th>
            <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach($scheduling_type as $type): ?>
            <tr>
            <td>
                <?php if($type=='from'):?>
                <?php echo lang_check('Open');?>
                <?php elseif($type=='to'):?>
                <?php echo lang_check('Close');?>
                <?php endif;?>
            </td>
            <?php foreach($scheduling_days as $col_val): ?>
                <td>
                    <?php
                    $drop_selected = ' - ';
                    $scheduling_values_cur = array();
                    if($field_value_json && isset($field_value_json[trim($col_val.'_'.$type)]) && !empty($field_value_json[trim($col_val.'_'.$type)]))
                        $drop_selected = $field_value_json[$col_val.'_'.$type];
                    else 
                        $drop_selected = " - ";
                    
                    echo $drop_selected;
                    ?>
                </td>
            <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
</div>
<?php endif;?>