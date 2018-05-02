<div class="wrap">
    <h2><?php esc_html_e( 'Screening Questions', 'screening-questions-for-wp-job-manager' ); ?> <a href="<?php echo admin_url( 'admin.php?page=wp-job-manager-screening-questions&action=new' ); ?>" class="add-new-h2"><?php esc_html_e( 'Add New', 'screening-questions-for-wp-job-manager' ); ?></a></h2>

    <?php
    if ( isset( $_REQUEST['message'] ) && $_REQUEST['message'] === 'question-delete-success' ) {
        echo '<div class="notice is-dismissible updated">';
        echo '<p>' . esc_html__( 'Screening question deleted successfully!', 'screening-questions-for-wp-job-manager' ) . '</p>';
        echo '</div>';
    }
    elseif ( isset( $_REQUEST['message'] ) && $_REQUEST['message'] === 'questions-delete-success' ) {
        echo '<div class="notice is-dismissible updated">';
        echo '<p>' . esc_html__( 'Screening questions deleted successfully!', 'screening-questions-for-wp-job-manager' ) . '</p>';
        echo '</div>';
    }
    elseif ( isset( $_REQUEST['message'] ) && $_REQUEST['message'] === 'question-delete-error' ) {
        echo '<div class="notice is-dismissible updated">';
        echo '<p>' . esc_html__( 'We couldn\'t delete that Screening question!', 'screening-questions-for-wp-job-manager' ) . '</p>';
        echo '</div>';
    }
    elseif ( isset( $_REQUEST['message'] ) && $_REQUEST['message'] === 'new-question-success' ) {
        echo '<div class="notice is-dismissible updated">';
        echo '<p>' . esc_html__( 'Screening question added successfully!', 'screening-questions-for-wp-job-manager' ) . '</p>';
        echo '</div>';
    }
    elseif ( isset( $_REQUEST['message'] ) && $_REQUEST['message'] === 'edit-question-success' ) {
        echo '<div class="notice is-dismissible updated">';
        echo '<p>' . esc_html__( 'Screening question updated successfully!', 'screening-questions-for-wp-job-manager' ) . '</p>';
        echo '</div>';
    }
    elseif ( isset( $_REQUEST['message'] ) && $_REQUEST['message'] === 'error' ) {
        echo '<div class="notice is-dismissible error">';
        echo '<p>' . esc_html__( 'Something went wrong.', 'screening-questions-for-wp-job-manager' ) . '</p>';
        echo '</div>';
    }
    elseif ( isset( $_REQUEST['error'] ) && ! empty( $_REQUEST['error'] ) ) {
        echo '<div class="notice is-dismissible error">';
        echo '<p>' . esc_html__( $_REQUEST['error'] ) . '</p>';
        echo '</div>';
    }

    $list_table = new WP_Job_Manager_Screening_Questions_List_Table();
    $list_table->prepare_items();
    ?>

    <form method="get">
        <input type="hidden" name="page" value="wp-job-manager-screening-questions" />
        <?php $list_table->search_box('search', 'search_id'); ?>
    </form>

    <form method="post">
        <input type="hidden" name="page" value="wp-job-manager-screening-questions" />
        <?php $list_table->display(); ?>
    </form>
</div>
