<div id="wpjmsq-post-job-dynamic-loader">
    <?php 
    if(isset($_GET['job_id'])){
        $job_id = $_GET['job_id'];
        $questions = get_post_meta($job_id,'wpjmsq_screening_questions',true); 
        if($questions){
            for($i=0;$i<count($questions);$i++):
            $question_id = $questions[$i];
            global $wpdb;
            $table_name = $wpdb->prefix . 'sq_questions';
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $question_id), ARRAY_A);
            ?>
            <p>
                
            <input type="text" name="suggested_question[<?= $item['ID']; ?>]" value="<?= $item['question']; ?>" style="display:inline-block;padding:5px;width:80%;"/>
              <button type="button" class="remove_question_item">&times;</button>  
            </p>
            <?php
            endfor;
        }
    }
    ?>
</div>
<div>
    <ul class="wpjsq-dropdown-options">
        <li><a id="wpjmsq-add-question-repeater-trigger" href="" class="<?php echo apply_filters('add_screening_question_button_class','button button-default'); ?>">
            <?php 
                echo apply_filters('add_screening_question_button_text','Add Screening Questions'); 
            ?>
        </a>
            <ul class="add_screening_question_button_options hidden">
                <li><a data-trigger="wpjmsq-popup" href="<?php echo admin_url('admin-ajax.php?action=wpjmsq_get_suggested_questions_html') ?>">
                    <?php echo __('Select from suggested','wpjmsq'); ?>
                </a></li>
                <li><a data-trigger="wpjmsq-popup" href="<?php echo admin_url('admin-ajax.php?action=wpjmsq_get_add_question_form'); ?>">
                    <?php echo __('Create my own','wpjmsq'); ?>
                </a></li>
            </ul>
        </li>
    </ul>
</div>
<?php load_wpjmsq_view('wpjmsq-popup'); ?>
