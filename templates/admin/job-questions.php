<?php
$job_id = get_the_ID();
$job_questions = wpjmsq_get_job_questions( $job_id );
$job_linked_questions = wpjmsq_get_job_linked_questions( $job_id );

if ( $job_questions ) {
	foreach ( $job_questions as $question ) {
		$checked = ( $job_linked_questions && in_array( $question->ID, $job_linked_questions ) ) ? ' checked="checked"' : '';
		?>

		<p>
			<label>
				<input type="checkbox" name="suggested_question[<?php echo $question->ID; ?>]" value="<?php echo $question->ID; ?>" data-question="<?php echo esc_attr( $question->question ); ?>"<?php echo $checked; ?>>
				<?php echo esc_html( $question->question ); ?>
			</label>
		</p>

		<?php
	}
}
?>

<div id="new_question_reapeater_holder"></div>

<a href="javascript:void(0)" id="new_question_reapeater_trigger"><?php echo esc_html__( 'Add New Question', 'screening-questions-for-wp-job-manager' ); ?></a>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#new_question_reapeater_trigger').on('click', function(event) {
			var $repeater_holder = $('#new_question_reapeater_holder'),
				html = '<p><input type="text" name="new_question[]" class="input-regular" placeholder="<?php echo esc_attr__( 'New Question', 'screening-questions-for-wp-job-manager' ); ?>"><button class="new_question_reapeater_remove" type="button">&times</button></p>';

			$repeater_holder.append(html);
		});

		$(document).on('click', '.new_question_reapeater_remove', function(event) {
			event.preventDefault();
			$(this).parent('p').remove();
		});
	});
</script>
