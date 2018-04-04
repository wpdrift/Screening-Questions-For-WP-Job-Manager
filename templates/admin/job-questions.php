<?php
global $wpdb;
$screen = get_current_screen();
$saved_questions = [];
$table_name = $wpdb->prefix . 'sq_questions';
$results = $wpdb->get_results("SELECT * FROM {$table_name} WHERE question_type = 'suggested' ORDER BY `ID` DESC");

if( 'add' != $screen->action ):
$id = get_the_ID();
$saved_questions = get_post_meta($id,'wpjmsq_screening_questions',true);

$results = $wpdb->get_results("SELECT * FROM {$table_name} WHERE question_type = 'suggested' OR job_id=$id ORDER BY `ID` DESC");

endif;

foreach($results as $result):
       if(in_array($result->ID,$saved_questions)){
              $selected = 'checked';
       }else{
              $selected = '';
       }
?>
<p>
<label>
    <input 
           type="checkbox" 
           name="suggested_question[<?php echo $result->ID; ?>]" 
           value="<?php echo $result->ID; ?>" 
           data-question="<?php echo $result->question; ?>" 
           <?php echo $selected; ?>
           /> 
	<?php echo stripslashes_deep($result->question); ?>
</label> 
</p>
<?php
endforeach;
?>
<div id="new_question_reapeater_holder"></div>
<a href="" id="new_question_reapeater_trigger">Add new question</a>
<script>
       jQuery(document).ready(function(){
              jQuery("#new_question_reapeater_trigger").on('click',function(e){
                     e.preventDefault();
                     var repeater_holder = jQuery("#new_question_reapeater_holder");
                     var html = '<p><input type="text" name="new_question[]" class="input-regular" placeholder="New question"/><button class="new_question_reapeater_remove" type="button">&times</button></p>';
                     repeater_holder.append(html);
              });
       });
       
       jQuery(document).on('click','.new_question_reapeater_remove',function(e){
              e.preventDefault();
              jQuery(this).parents('p').remove();
       });
</script>
