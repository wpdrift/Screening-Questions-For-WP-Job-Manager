<?php do_action('wpjmsq_before_screening_questions'); 
$questions = get_post_meta(get_the_ID(),'wpjmsq_screening_questions',true);
if($questions):
for($i=0;$i<count($questions);$i++):
$question_id = $questions[$i];
global $wpdb;
$table_name = $wpdb->prefix . 'sq_questions';
$item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $question_id), ARRAY_A);
?>
<fieldset>
    <label><?php echo $item['question']; ?></label>
    <div class="field required-field">
        <textarea cols="20" rows="3" class="<?php echo  apply_filters('wpjmsq_answer_field_class','input-text'); ?>" name="answer[<?php echo $question_id; ?>]" placeholder="<?php _e('Answer goes here','wpjmsq'); ?>" required></textarea>
    </div>
</fieldset>
<?php
endfor;
endif;
do_action('wpjmsq_after_screening_questions'); ?>