<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WP_Job_Manager_Company_Listings_Ajax class.
 */
class WP_Job_Manager_Screening_Questions_Ajax {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action(
			'wp_ajax_nopriv_wpjmsq_get_suggested_questions_html',
			array( $this, 'get_questions' )
		);
		
		add_action(
			'wp_ajax_wpjmsq_get_suggested_questions_html',
			array( $this, 'get_questions' )
		);
		
		add_action(
			'wp_ajax_nopriv_wpjmsq_get_add_question_form',
			array( $this, 'get_add_question_form' )
		);
		
		add_action(
			'wp_ajax_wpjmsq_get_add_question_form',
			array( $this, 'get_add_question_form' )
		);
	}
	
	
	function get_questions(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'sq_questions';
		$results = $wpdb->get_results("SELECT * FROM {$table_name} WHERE question_type = 'suggested' ORDER BY `ID` DESC");
		if($results){
			?>
				<div class="wpjmsq-modal-heading">
                <h2><?php echo __('Select Questions','wpjmsq'); ?></h2>
				</div>
				<div class="wpjmsq-modal-body">
					<div class="form">
                    <ul>
						<?php foreach($results as $result): ?>
                        <li>
                        <label>
                        	<input type="checkbox" name="suggested_question[]" 
							value="<?php echo $result->ID; ?>" 
							data-question="<?php echo $result->question; ?>"
							/> 
							<?php echo $result->question; ?>
						</label>
						</li>
						<?php endforeach; ?>
                    </ul>
						<button type="button" class="button choose-suggested-questions">
							<?php echo __('Choose','wpjmsq'); ?>
						</button>
                	</div>
				</div>
			<?php
			die();
		}
		else{
		?>
			<div class="wpjmsq-modal-heading">
                <h2><?php echo __('There are no suggested questions','wpjmsq'); ?></h2>
            </div>
            <div class="wpjmsq-modal-body">
            </div>
		<?php
			die();
		}
	}
	
	
	
	function get_add_question_form(){
	?>
				<div class="wpjmsq-modal-heading">
                <h2><?php echo __('Add New Question','wpjmsq'); ?></h2>
				</div>
				<div class="wpjmsq-modal-body">
					<p>
						<textarea name="new_question" rows="4" style="display:block;" placeholder="<?php echo 'Type your question here'; ?>"></textarea>
					</p>
					<p>
						<button type="button" class="button create_question_btn">
							<?php echo __('Add Question','wpjmsq'); ?>
						</button>
					</p>
				</div>
			<?php
			die();
	}

	
}

new WP_Job_Manager_Screening_Questions_Ajax();