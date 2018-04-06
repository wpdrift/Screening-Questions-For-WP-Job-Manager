<?php
$per_page = apply_filters( 'screening_questions_per_page', 10 );
$current_page = isset( $_GET['pageno'] ) ? intval( $_GET['pageno'] ) : 1;
$start_from = ( $current_page - 1 ) * $per_page;
$total_records = wpjmsq_count_questions();
$results = wpjmsq_get_paginated_questions( $start_from, $per_page );
$total_pages = ceil( $total_records[0]->count / $per_page );
$page_url = admin_url( 'admin.php?page=wp-job-manager-screening-questions' );
?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html__( 'Screening Questions', 'screening-questions-for-wp-job-manager' ); ?></h1>
	<a href="<?php echo $page_url . '&action=add'; ?>" class="page-title-action"><?php echo esc_html__( 'Add New', 'screening-questions-for-wp-job-manager' ); ?></a>

	<hr class="wp-header-end">

	<ul class="subsubsub">
		<li class="all"><a href="<?php echo $page_url; ?>" class="current"><?php echo esc_html__( 'All Questions', 'screening-questions-for-wp-job-manager' ); ?></a>
	</ul>

	<div style="clear: both; height: 6px; line-height: 6px;"></div>

	<form id="posts-filter" method="get">
		<table class="wp-list-table widefat fixed striped questions">
			<thead>
				<tr>
					<th><?php echo esc_html__( 'Question', 'screening-questions-for-wp-job-manager' ); ?></th>
					<th><?php echo esc_html__( 'Type', 'screening-questions-for-wp-job-manager' ); ?></th>
				</tr>
			</thead>

			<tbody id="the-list">
				<?php foreach( $results as $result ): ?>
					<tr>
						<td>
							<strong><a class="row-title" href="<?php echo $page_url . '&action=edit&id=' . $result->ID; ?>"><?php echo esc_html__( $result->question ); ?></a></strong>

							<div class="row-actions">
								<span class="edit"><a href="<?php echo $page_url . '&action=edit&id=' . $result->ID; ?>"><?php echo esc_html__( 'Edit', 'screening-questions-for-wp-job-manager' ); ?></a> | </span>
								<span class="trash"><a href="<?php echo $page_url . '&action=delete&id=' . $result->ID; ?>" class="submitdelete"><?php echo esc_html__( 'Delete', 'screening-questions-for-wp-job-manager' ); ?></a></span>
							</div>
						</td>
						<td><?php echo ucfirst( $result->question_type ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</form>

	<br class="clear"/>

	<div class="pagination">
		<?php
		$pagination = '';

		if ( $total_pages > 1 ) {
			for ( $i=1; $i <= $total_pages; $i++ ) {
				$pagination .= '<a style="display: inline-block; padding: 5px 10px; margin: 0 5px 0 0; background-color: #fff; text-decoration: none; color: #666; border: 1px solid #ddd;" href="' . $page_url . '&pageno=' . $i . '">' . $i . '</a>';
			}
		}

		echo $pagination;
		?>
	</div>
</div>
