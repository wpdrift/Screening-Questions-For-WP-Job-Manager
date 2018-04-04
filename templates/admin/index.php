<?php
global $wpdb;
$table_name = $wpdb->prefix . 'sq_questions';
$per_page = 10;
$current_page = 1;
if(isset($_GET['pageno'])){
	$current_page = $_GET['pageno'];
}

$start_from = ($current_page-1) * $per_page;
$total_records = $wpdb->get_results("SELECT COUNT(ID) as count FROM {$table_name}");
$results = $wpdb->get_results("SELECT * FROM {$table_name} ORDER BY `ID` DESC LIMIT $start_from,$per_page");
$total_pages = ceil($total_records[0]->count / $per_page);
?>
<div class="wrap">
<h1 class="wp-heading-inline">Screening Questions</h1>

 <a href="<?= admin_url('admin.php?page=wp-job-manager-screening-questions&action=add'); ?>" class="page-title-action">Add New</a>
<hr class="wp-header-end">


<h2 class="screen-reader-text">Filter pages list</h2>
	
<ul class="subsubsub">
	<li class="all"><a href="edit.php?post_type=page" class="current">All Questions</a>
</ul>
	
<form id="posts-filter" method="get">



<input type="hidden" name="post_status" class="post_status_page" value="all">
<input type="hidden" name="post_type" class="post_type_page" value="page">



	
<h2 class="screen-reader-text">Pages list</h2><table class="wp-list-table widefat fixed striped pages">
	<thead>
	<tr>
		<th><strong>Question</strong></th>
		<th><strong>Question type</strong></th>
	</tr>
	</thead>

	<tbody id="the-list">
<?php foreach($results as $result): ?>
<tr>
<td>
			
<strong>
<a class="row-title" href="<?= admin_url('admin.php?page=wp-job-manager-screening-questions&action=edit&id='.$result->ID); ?>"><?= $result->question; ?></a>
</strong>

	<div class="row-actions">

	<span class="edit"><a href="<?= admin_url('admin.php?page=wp-job-manager-screening-questions&action=edit&id='.$result->ID); ?>">Edit</a> | </span>

	<span class="trash"><a href="<?= admin_url('admin.php?page=wp-job-manager-screening-questions&action=delete&id='.$result->ID); ?>" class="submitdelete">Delete</a> </span>

	</div>
</td>	
<td><?= ucfirst($result->question_type); ?></td>
</tr>
<?php endforeach; ?>				
				
				
				
				
				
		</tbody>


</table>
	

</form>
<br class="clear"/>
<div class="pagination">
	<?php
	if($total_pages>1):
		for ($i=1; $i<=$total_pages; $i++) {  
             $pagLink .= "<a style='padding:5px;margin:3px;background:#ccc;text-decoration:none;color:#000;' href='".admin_url('admin.php?page=wp-job-manager-screening-questions&')."pageno=".$i."'>".$i."</a>";  
		} 
	echo $pagLink;
	endif;
	?>
</div>
	

<div id="ajax-response"></div>
<br class="clear">
</div>