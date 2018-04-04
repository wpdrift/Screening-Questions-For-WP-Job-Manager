(function($){
  $("#wpjmsq-add-question-repeater-trigger").on('click',function(e){
    e.preventDefault();
    $(".add_screening_question_button_options").toggleClass('hidden');
  });
  
  
  $('[data-trigger="wpjmsq-popup"]').on('click',function(e){
    e.preventDefault();
    $('#wpjmsq-popup').toggleClass('hidden');
    if($(this).hasClass('wpjmsq-modal-close-btn')){
      $('#wpjmsq-popup').find('.model-content').html('');
    }else{
      
      if($(this).attr('data-type') != 'undefined'){
        
        
        $('#wpjmsq-popup').find('.model-content').html('<p style="text-align:center;">Loading...</p>');
        
        var request_url = $(this).attr('href');
        $.get(request_url,function(data){
          $('#wpjmsq-popup').find('.model-content').html(data);
        });
      }
      
    }
  });
  
  
})(jQuery);



jQuery(document).on("click", function(e) {
    if (jQuery(e.target).is("#wpjmsq-add-question-repeater-trigger") === false) {
       if(! jQuery(".add_screening_question_button_options").hasClass('hidden')){
         jQuery(".add_screening_question_button_options").addClass('hidden');
       }
    }
  });
  
  
  jQuery(document).on("click", ".choose-suggested-questions" , function(e) {
            e.preventDefault();
            var ids = [];
            var question_html = '';
            var form = jQuery(this).parents('.form');
            var selected_questions = form.find('input[type="checkbox"]:checked').each(function() {
              //ids.push(this.value);
              var question_text = jQuery(this).attr('data-question');
              var question_id = jQuery(this).val();
              question_html = '<p><input type="text" name="suggested_question['+question_id+']" value="'+question_text+'" style="display:inline-block;padding:5px;width:80%;"/><button type="button" class="remove_question_item">&times;</button></p>';
              jQuery('#wpjmsq-post-job-dynamic-loader').prepend(question_html);
            });
            //console.log(ids);
            jQuery('.wpjmsq-modal-close-btn').trigger('click');
  });
  
  jQuery(document).on("click", ".create_question_btn" , function(e) {
            e.preventDefault(); 
            var btn = jQuery(this);
            var new_question = btn.parents('.wpjmsq-modal-body').find('textarea[name="new_question"]').val();
            //console.log(new_question);
            var question_html = '<p><input type="text" name="new_question[]" value="'+new_question+'" style="display:inline-block;padding:5px;width:80%;"/><button type="button" class="remove_question_item">&times;</button></p>';
    
            jQuery('#wpjmsq-post-job-dynamic-loader').prepend(question_html);
    
            jQuery('.wpjmsq-modal-close-btn').trigger('click');
  });

jQuery(document).on("click", ".remove_question_item" , function(e) {
            e.preventDefault();
            jQuery(this).parents("p").remove();
  });