<?php
global $wpdb;
$questions_tbl = $wpdb->prefix . 'sq_questions';
$answers_tbl = $wpdb->prefix . 'sq_answers';
$application_id = get_the_ID();
$job_id = wp_get_post_parent_id($application_id);
$questions = get_post_meta($job_id,'wpjmsq_screening_questions',true);
if($questions):
for($i=0;$i<count($questions);$i++):
$question_id = $questions[$i];
$question_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $questions_tbl WHERE id = %d", $question_id), ARRAY_A);
if($question_data):
$answer_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $answers_tbl WHERE question_id = %d AND application_id = %d", $question_id,$application_id), ARRAY_A);
?>
<div style="margin:10px;background:#eee;border:1px solid #ddd;padding:10px;">
    <p><strong><?php echo $question_data['question']; ?></strong></p>
    <p style="color:#666;font-style:italic;font-size:11px;">
        <?php 
        if($answer_data){
            echo $answer_data['answer'];
        }
        ?>
    </p>
</div>
<?php
endif;
endfor;
endif; 
?>
