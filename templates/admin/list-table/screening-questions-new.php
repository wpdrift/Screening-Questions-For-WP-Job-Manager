<div class="wrap">
    <h1><?php _e( 'Add New Screening Question', 'screening-questions-for-wp-job-manager' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-question">
                    <th scope="row">
                        <label for="question"><?php _e( 'Question', 'screening-questions-for-wp-job-manager' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="question" id="question" class="regular-text" placeholder="<?php echo esc_attr( 'Enter question here', 'screening-questions-for-wp-job-manager' ); ?>" value="" required="required" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( 'question-new' ); ?>
        <?php submit_button( __( 'Add New Screening Question', 'screening-questions-for-wp-job-manager' ), 'primary', 'submit_screening_question' ); ?>

    </form>
</div>
