<div id="wpjmsq-post-job-dynamic-loader" class="wpjmsq-job-questions-wrapper">
    <?php
    if ( isset( $_GET['job_id'] ) ) {
        $job_id = intval( $_GET['job_id'] );
        $questions = wpjmsq_get_job_linked_questions( $job_id );

        if ( $questions ) {
            foreach ( $questions as $question_id ) {
                $item = wpjmsq_get_question( $question_id );

                if ( $item ) {
                    ?>

                    <fieldset class="screening-question">
                        <div class="input-cell">
                            <input type="text" class="input-text" name="suggested_question[<?php echo $item['ID']; ?>]" value="<?php echo esc_attr( $item['question'] ); ?>">
                        </div>

                        <div class="button-cell">
                            <button type="button" class="remove_question_item">&times;</button>
                        </div>
                    </fieldset>

                    <?php
                }
            }
        }
    }
    ?>
</div><!-- #wpjmsq-post-job-dynamic-loader -->

<div class="wpjmsq-new-question-trigger-wrapper">
    <div class="wpjmsq-add-question-repeater-wrapper">
        <a href="javascript:void(0)" id="wpjmsq-add-question-repeater-trigger" class="<?php echo apply_filters( 'add_screening_question_button_class', 'button' ); ?>">
            <?php echo apply_filters( 'add_screening_question_button_text', esc_html__( 'Add Screening Question', 'screening-questions-for-wp-job-manager' ) ); ?>
        </a>

        <ul class="add_screening_question_button_options hidden">
            <li>
                <a data-trigger="wpjmsq-popup" href="<?php echo admin_url( 'admin-ajax.php?action=wpjmsq_get_suggested_questions_html' ); ?>">
                    <?php echo esc_html__( 'Select from suggested', 'screening-questions-for-wp-job-manager' ); ?>
                </a>
            </li>
            <li>
                <a data-trigger="wpjmsq-popup" href="<?php echo admin_url( 'admin-ajax.php?action=wpjmsq_get_add_question_form' ); ?>">
                    <?php echo esc_html__( 'Create my own', 'screening-questions-for-wp-job-manager' ); ?>
                </a>
            </li>
        </ul>
    </div>
</div>

<?php load_wpjmsq_view( 'wpjmsq-popup' ); ?>
