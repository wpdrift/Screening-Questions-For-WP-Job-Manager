<div class="wrap">
    <h1><?php esc_html_e( 'View Question', 'screening-questions-for-wp-job-manager' ); ?></h1>

    <?php $item = wpjmsq_list_table_get_question( $id ); ?>

    <table class="form-table">
        <tbody>
            <tr class="row-question">
                <th scope="row">
                    <label for="question"><?php esc_html_e( 'Question', 'screening-questions-for-wp-job-manager' ); ?>:</label>
                </th>
                <td>
                    <?php echo esc_html( $item->question ); ?>
                </td>
            </tr>
         </tbody>
    </table>
</div>
