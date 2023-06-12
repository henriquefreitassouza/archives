(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(function() {
		 $('#cs_course_date_start').datepicker({
			 dateFormat: 'yy-mm-dd',
			 changeMonth: true,
			 changeYear: true
		 });

		 $('#cs_course_date_end').datepicker({
			 dateFormat: 'yy-mm-dd',
			 changeMonth: true,
			 changeYear: true
		 })

		 if ($('#page_template').val() != 'page-templates/curso.php') {
			 $('#cs_course_meta_box').hide();
			 $('#cs_course_cta_meta_box').hide();
			 $('#cs_course_cta_bottom_meta_box').hide();
			 $('#cs_course_speaker_meta_box').hide();
			 $('#cs_course_module_meta_box').hide();
			 $('#cs_course_form_meta_box').hide();
			 $('#cs_course_location_map_meta_box').hide();
			 $('#cs_course_short_description_meta_box').hide();
		 }

		 $('#page_template').change(function() {
			 if ($(this).val() == 'page-templates/curso.php') {
				 $('#cs_course_meta_box').show();
				 $('#cs_course_cta_meta_box').show();
				 $('#cs_course_cta_bottom_meta_box').show();
				 $('#cs_course_speaker_meta_box').show();
				 $('#cs_course_module_meta_box').show();
				 $('#cs_course_form_meta_box').show();
				 $('#cs_course_location_map_meta_box').show();
				 $('#cs_course_short_description_meta_box').show();
			 } else {
				 $('#cs_course_meta_box').hide();
				 $('#cs_course_cta_meta_box').hide();
				 $('#cs_course_cta_bottom_meta_box').hide();
				 $('#cs_course_speaker_meta_box').hide();
				 $('#cs_course_module_meta_box').hide();
				 $('#cs_course_form_meta_box').hide();
				 $('#cs_course_location_map_meta_box').hide();
				 $('#cs_course_short_description_meta_box').hide();
			 }
		 });
	 });

})( jQuery );
