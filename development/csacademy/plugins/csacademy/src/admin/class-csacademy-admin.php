<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://henriquefreitas.com.br
 * @since      1.0.0
 *
 * @package    Csacademy
 * @subpackage Csacademy/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Csacademy
 * @subpackage Csacademy/admin
 * @author     Henrique Freitas Souza <henrique@henriquefreitas.com>
 */
class Csacademy_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Csacademy_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Csacademy_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'jquery-ui-datepicker-style' , '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/csacademy-admin.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Csacademy_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Csacademy_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'jquery-ui-core', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery-ui-core' ) );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/csacademy-admin.min.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), $this->version, true );

	}

	public function cs_add_course_cpt() {
		$cpt = 'course';
		$name = 'Turmas';
		$singular_name = 'Turma';
		$description = 'Administre datas, horários, banner de fundo da página, locais e descrição da turma';

		$options['public'] = true;
		$options['description'] = __( $description, 'csacademy' );
		$options['register_meta_box_cb'] = array( $this, 'cs_add_course_meta_box' );
		$options['rewrite'] = ['slug' => $cpt];
		$options['menu_position'] = 25;
		$options['menu_icon'] = 'dashicons-tickets-alt';
		$options['supports'] = ['title', 'editor', 'thumbnail'];

		$options['labels']['name'] = __( $name, 'csacademy' );
		$options['labels']['singular_name'] = __( $singular_name, 'csacademy' );
		$options['labels']['add_new'] = __( "Adicionar {$singular_name}", 'csacademy' );
		$options['labels']['add_new_item'] = __( "Adicionar nova {$singular_name}", 'csacademy' );
		$options['labels']['edit_item'] = __( "Editar {$singular_name}", 'csacademy' );
		$options['labels']['new_item'] = __( "Nova {$singular_name}", 'csacademy' );
		$options['labels']['view_item'] = __( "Ver {$singular_name}", 'csacademy' );
		$options['labels']['view_items'] = __( "Ver {$name}", 'csacademy' );
		$options['labels']['search_items'] = __( "Buscar {$name}", 'csacademy' );
		$options['labels']['not_found'] = __( "Não há {$name}", 'csacademy' );
		$options['labels']['not_found_in_trash'] = __( "Não há {$name} no lixo", 'csacademy' );
		$options['labels']['all_items'] = __( "Todas as {$name}", 'csacademy' );
		$options['labels']['archives'] = __( "Arquivo de {$name}", 'csacademy' );
		$options['labels']['attributes'] = __( "Informações da {$singular_name}", 'csacademy' );
		$options['labels']['insert_into_item'] = __( "Adicionar a {$singular_name}", 'csacademy' );
		$options['labels']['upload_to_this_item'] = __( "Adicionar", 'csacademy' );
		$options['labels']['featured_image'] = __( "Imagem de fundo da página de curso", 'csacademy' );
		$options['labels']['set_featured_image'] = __( "Escolher uma imagem", 'csacademy' );
		$options['labels']['remove_featured_image'] = __( "Apagar esta imagem", 'csacademy' );
		$options['labels']['use_featured_image'] = __( "Usar esta imagem", 'csacademy' );

		register_post_type( $cpt, $options );

	}

	public function cs_add_page_course_meta_box() {
		$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];

		add_meta_box( 'cs_course_meta_box', __( 'Informações sobre o curso', 'csacademy' ), function() use ( $post_id ) {
			wp_nonce_field( basename( __FILE__ ), 'cs_course_meta_box_nonce' );

			$course_date_start = get_post_meta( $post_id, '_cs_course_date_start', true) ;
			$course_date_end = get_post_meta( $post_id, '_cs_course_date_end', true );
			$course_time = get_post_meta( $post_id, '_cs_course_time', true );
			$course_place = get_post_meta( $post_id, '_cs_course_place', true );
			$course_location_address = get_post_meta( $post_id, '_cs_course_location_address', true );
			$course_price = get_post_meta( $post_id, '_cs_course_price', true );
			?>
			<div class="cs-input__group">
				<div><label for="cs_course_date_start"><?= __( 'Data de início', 'csacademy' ); ?>:</label></div>
				<input type="text" name="cs_course_date_start" id="cs_course_date_start" value="<?= $course_date_start; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_course_date_end"><?= __( 'Data de término', 'csacademy' ); ?>:</label></div>
				<input type="text" name="cs_course_date_end" id="cs_course_date_end" value="<?= $course_date_end; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_course_time"><?= __( 'Horário', 'csacademy' ); ?>:</label></div>
				<input type="text" name="cs_course_time" id="cs_course_time" value="<?= $course_time; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_course_place"><?= __( 'Local', 'csacademy' ); ?>:</label></div>
				<input type="text" name="cs_course_place" id="cs_course_place" value="<?= $course_place; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_course_location_address"><?= __( 'Endereço', 'csacademy' ); ?></label></div>
				<input type="text" name="cs_course_location_address" id="cs_course_location_address" value="<?= $course_location_address; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_course_price"><?= __( 'Valor do curso', 'csacademy' ); ?>:</label></div>
				<input type="text" name="cs_course_price" id="cs_course_price" value="<?= $course_price; ?>">
			</div>
			<?php
		}, 'page', 'side' );

		add_meta_box( 'cs_course_cta_meta_box', __( 'Botão do banner', 'csacademy' ), function() use ( $post_id ) {
			wp_nonce_field( basename( __FILE__ ), 'cs_course_cta_meta_box_nonce' );

			$button_text = get_post_meta( $post_id, '_cs_course_cta_text', true );
			$button_link = get_post_meta( $post_id, '_cs_course_cta_link', true );
			?>
			<div class="cs-input__group">
				<div><label for="cs_course_cta_text"><?= __( 'Texto do botão', 'csacademy' ); ?></label></div>
				<input type="text" name="cs_course_cta_text" id="cs_course_cta_text" value="<?= $button_text; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_course_cta_link"><?= __( 'Link do botão', 'csacademy' ); ?></label></div>
				<input type="text" name="cs_course_cta_link" id="cs_course_cta_link" value="<?= $button_link; ?>">
			</div>
			<?php
		}, 'page', 'side' );

		add_meta_box( 'cs_course_cta_bottom_meta_box', __( 'Botão do final da página', 'csacademy' ), function() use ( $post_id ) {
			wp_nonce_field( basename( __FILE__ ), 'cs_course_cta_bottom_meta_box_nonce' );

			$lead_text = get_post_meta( $post_id, '_cs_course_cta_bottom_call', true );
			$button_text = get_post_meta( $post_id, '_cs_course_cta_bottom_text', true );
			$button_link = get_post_meta( $post_id, '_cs_course_cta_bottom_link', true );

			?>
			<div class="cs-input__group">
				<div><label for="cs_course_cta_bottom_call"><?= __( 'Texto da chamada', 'csacademy' ); ?></label></div>
				<input type="text" name="cs_course_cta_bottom_call" id="cs_course_cta_bottom_call" value="<?= $lead_text; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_course_cta_bottom_text"><?= __( 'Texto do botão', 'csacademy' ); ?></label></div>
				<input type="text" name="cs_course_cta_bottom_text" id="cs_course_cta_bottom_text" value="<?= $button_text; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_course_cta_bottom_link"><?= __( 'Link do botão', 'csacademy' ); ?></label></div>
				<input type="text" name="cs_course_cta_bottom_link" id="cs_course_cta_bottom_link" value="<?= $button_link; ?>">
			</div>
			<?php
		}, 'page', 'side' );

		add_meta_box( 'cs_course_location_map_meta_box', __( 'Mapa do local no Google', 'csacademy' ), function() use ( $post_id ) {
			wp_nonce_field( basename( __FILE__ ), 'cs_course_location_map_nonce' );

			$location_map = get_post_meta( $post_id, '_cs_course_location_map', true );
			?>
			<div class="cs-input__group">
				<div><label for="cs_course_location_map"><?= __( 'Código do mapa (procure o endereço do local no Google Maps, clique em "share" e acesse a aba "embed a map". Copie o código que aparece e cole neste campo)', 'csacademy' ); ?></label></div>
				<textarea name="cs_course_location_map" id="cs_course_location_map"><?= $location_map; ?></textarea>
			</div>
			<?php
		}, 'page', 'side' );

		add_meta_box( 'cs_course_short_description_meta_box', __( 'Descrição curta do curso', 'csacademy' ), function() use ( $post_id ) {
			wp_nonce_field( basename( __FILE__ ), 'cs_course_short_description_nonce' );

			$short_description = get_post_meta( $post_id, '_cs_course_short_description', true );
			?>
			<div class="cs-input__group">
				<div><label for="cs_course_short_description"><?= __( 'Descrição curta do curso para ser exibida na home', 'csacademy' ); ?></label></div>
				<textarea name="cs_course_short_description" id="cs_course_short_description"><?= $short_description; ?></textarea>
			</div>
			<?php
		}, 'page' );

		add_meta_box( 'cs_course_speaker_meta_box', __( 'Instrutores', 'csacademy' ), function() use ( $post_id ) {
			wp_nonce_field( basename( __FILE__ ), 'cs_course_speaker_meta_box_nonce' );

			$speaker_values = explode( ' ', get_post_meta( $post_id, '_cs_course_speaker', true ) );
			?>
				<div class="cs-input__group">

			<?php
			global $post;
			$outer_loop = $post;

			$args = array(
				'post_type' => 'speaker',
				'post_status' => 'publish'
			);

			$speakers = new WP_Query( $args );

			if( $speakers->have_posts() ) :
				while( $speakers->have_posts() ) : $speakers->the_post();

				if ( is_array( $speaker_values ) && in_array( get_the_ID(), $speaker_values ) ) $checked = 'checked="checked"';
				else $checked = null;
			?>
					<div class="cs-input__group-checkbox">
						<input type="checkbox" name="cs_course_speaker[]" id="cs_course_speaker[]" value="<?= get_the_ID(); ?>" <?= $checked; ?>>
						<span><?= the_title(); ?></span>
					</div>
			<?php
				endwhile;
				$post = $outer_loop;
			else:
			?>
					<span>Cadastre pelo menos um instrutor</span>
			<?php
			endif;
			?>
				</div>
			<?php
		}, 'page' );

		add_meta_box( 'cs_course_module_meta_box', __( 'Módulos', 'csacademy' ), function() use ( $post_id ) {
			wp_nonce_field( basename( __FILE__ ), 'cs_course_module_meta_box_nonce' );

			$module_values = explode( ' ', get_post_meta( $post_id, '_cs_course_module', true ) );
			?>
			<div class="cs-input__group">

			<?php
			global $post;
			$outer_loop = $post;

			$args = array(
			'post_type' => 'module',
			'post_status' => 'publish'
			);

			$modules = new WP_Query( $args );

			if( $modules->have_posts() ) :
			while( $modules->have_posts() ) : $modules->the_post();

				if ( is_array( $module_values ) && in_array( get_the_ID(), $module_values ) ) $checked = 'checked="checked"';
				else $checked = null;
			?>
				<div class="cs-input__group-checkbox">
					<input type="checkbox" name="cs_course_module[]" id="cs_course_module[]" value="<?= get_the_ID(); ?>" <?= $checked; ?>>
					<span><?= the_title(); ?></span>
				</div>
			<?php
			endwhile;
			$post = $outer_loop;
			else:
			?>
				<span>Cadastre pelo menos um módulo</span>
			<?php
			endif;
			?>
			</div>
			<?php
		}, 'page' );

		/*
		add_meta_box( 'cs_course_form_meta_box', __( 'Formulário de contato', 'csacademy' ), function() use ( $post_id ) {
			wp_nonce_field( basename( __FILE__ ), 'cs_course_form_meta_box_nonce' );

			$form_shortcode = get_post_meta( $post_id, '_cs_course_form_shortcode', true );

			?>
			<div class="cs-input__group">
				<div><label for="cs_course_form_shortcode"><?= __( 'Código do formulário Contact Form 7', 'csacademy' ); ?></label></div>
				<input type="text" name="cs_course_form_shortcode" id="cs_course_form_shortcode" value="<?= $form_shortcode; ?>">
			</div>
			<?php
		}, 'page' );
		*/
	}

	public function cs_save_page_course_cpt( $post_id ) {
		$template_file = get_post_meta( $post_id, '_wp_page_template', true );

		if ( ! 'page-templates/curso.php' == $template_file ) return;
		if ( ! wp_verify_nonce( $_POST['cs_course_meta_box_nonce'], basename( __FILE__ ) ) ) return;
		if ( ! current_user_can( 'edit_others_posts' ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! isset( $_POST['cs_course_meta_box_nonce'] ) || ! isset( $_POST['cs_course_cta_meta_box_nonce'] ) || ! isset( $_POST['cs_course_speaker_meta_box_nonce'] ) || ! isset( $_POST['cs_course_module_meta_box_nonce'] ) ) return;
		if ( isset( $_POST['cs_course_date_start'] ) ) update_post_meta( $post_id, '_cs_course_date_start', sanitize_text_field( $_POST['cs_course_date_start'] ) );
		if ( isset( $_POST['cs_course_date_end'] ) ) update_post_meta( $post_id, '_cs_course_date_end', sanitize_text_field( $_POST['cs_course_date_end'] ) );
		if ( isset( $_POST['cs_course_time'] ) ) update_post_meta( $post_id, '_cs_course_time', sanitize_text_field( $_POST['cs_course_time'] ) );
		if ( isset( $_POST['cs_course_place'] ) ) update_post_meta( $post_id, '_cs_course_place', sanitize_text_field( $_POST['cs_course_place'] ) );
		if ( isset( $_POST['cs_course_location_address'] ) ) update_post_meta( $post_id, '_cs_course_location_address', sanitize_text_field( $_POST['cs_course_location_address'] ) );
		if ( isset( $_POST['cs_course_price'] ) ) update_post_meta( $post_id, '_cs_course_price', sanitize_text_field( $_POST['cs_course_price'] ) );
		if ( isset( $_POST['cs_course_cta_text'] ) ) update_post_meta( $post_id, '_cs_course_cta_text', sanitize_text_field( $_POST['cs_course_cta_text'] ) );
		if ( isset( $_POST['cs_course_cta_link'] ) ) update_post_meta( $post_id, '_cs_course_cta_link', sanitize_text_field( $_POST['cs_course_cta_link'] ) );
		if ( isset( $_POST['cs_course_cta_bottom_call'] ) ) update_post_meta( $post_id, '_cs_course_cta_bottom_call', sanitize_text_field( $_POST['cs_course_cta_bottom_call'] ) );
		if ( isset( $_POST['cs_course_cta_bottom_text'] ) ) update_post_meta( $post_id, '_cs_course_cta_bottom_text', sanitize_text_field( $_POST['cs_course_cta_bottom_text'] ) );
		if ( isset( $_POST['cs_course_cta_bottom_link'] ) ) update_post_meta( $post_id, '_cs_course_cta_bottom_link', sanitize_text_field( $_POST['cs_course_cta_bottom_link'] ) );
		if ( isset ($_POST['cs_course_location_map'] ) ) update_post_meta( $post_id, '_cs_course_location_map', htmlentities( $_POST['cs_course_location_map'] ) );
		if ( isset ($_POST['cs_course_short_description'] ) ) update_post_meta( $post_id, '_cs_course_short_description', sanitize_text_field( $_POST['cs_course_short_description'] ) );

		if ( isset( $_POST['cs_course_speaker'] ) && ! empty( $_POST['cs_course_speaker'] ) ) {
			$speaker_values = '';
			if ( is_array( $_POST['cs_course_speaker'] ) ) $speaker_values = implode( ' ', $_POST['cs_course_speaker'] );
			else $speaker_values = $_POST['cs_course_speaker'];

			update_post_meta( $post_id, '_cs_course_speaker', sanitize_text_field( $speaker_values ) );
		} else delete_post_meta( $post_id, '_cs_course_speaker' );

		if ( isset( $_POST['cs_course_module'] ) && ! empty( $_POST['cs_course_module'] ) ) {
			$module_values = '';
			if ( is_array( $_POST['cs_course_module'] ) ) $module_values = implode( ' ', $_POST['cs_course_module'] );
			else $module_values = $_POST['cs_course_module'];

			update_post_meta( $post_id, '_cs_course_module', sanitize_text_field( $module_values ) );
		} else delete_post_meta( $post_id, '_cs_course_module' );

		// if ( isset( $_POST['cs_course_form_shortcode'] ) ) update_post_meta( $post_id, '_cs_course_form_shortcode', htmlentities( $_POST['cs_course_form_shortcode'] ) );
	}

	public function cs_add_speaker_cpt() {
		$cpt = 'speaker';
		$name = 'Instrutores';
		$singular_name = 'Instrutor';
		$description = 'Administre os instrutores dos cursos';

		$options['public'] = true;
		$options['description'] = __( $description, 'csacademy' );
		$options['register_meta_box_cb'] = array( $this, 'cs_add_speaker_meta_box' );
		$options['rewrite'] = ['slug' => $cpt];
		$options['menu_position'] = 25;
		$options['menu_icon'] = 'dashicons-businessman';
		$options['supports'] = ['title', 'editor', 'thumbnail'];

		$options['labels']['name'] = __( $name, 'csacademy' );
		$options['labels']['singular_name'] = __( $singular_name, 'csacademy' );
		$options['labels']['add_new'] = __( "Adicionar {$singular_name}", 'csacademy' );
		$options['labels']['add_new_item'] = __( "Adicionar novo {$singular_name}", 'csacademy' );
		$options['labels']['edit_item'] = __( "Editar {$singular_name}", 'csacademy' );
		$options['labels']['new_item'] = __( "Novo {$singular_name}", 'csacademy' );
		$options['labels']['view_item'] = __( "Ver {$singular_name}", 'csacademy' );
		$options['labels']['view_items'] = __( "Ver {$name}", 'csacademy' );
		$options['labels']['search_items'] = __( "Buscar {$name}", 'csacademy' );
		$options['labels']['not_found'] = __( "Não há {$name}", 'csacademy' );
		$options['labels']['not_found_in_trash'] = __( "Não há {$name} no lixo", 'csacademy' );
		$options['labels']['all_items'] = __( "Todos os {$name}", 'csacademy' );
		$options['labels']['archives'] = __( "Arquivo de {$name}", 'csacademy' );
		$options['labels']['attributes'] = __( "Informações do {$singular_name}", 'csacademy' );
		$options['labels']['insert_into_item'] = __( "Adicionar ao {$singular_name}", 'csacademy' );
		$options['labels']['upload_to_this_item'] = __( "Adicionar", 'csacademy' );
		$options['labels']['featured_image'] = __( "Foto do {$singular_name}", 'csacademy' );
		$options['labels']['set_featured_image'] = __( "Escolher uma foto", 'csacademy' );
		$options['labels']['remove_featured_image'] = __( "Apagar esta foto", 'csacademy' );
		$options['labels']['use_featured_image'] = __( "Usar esta foto", 'csacademy' );

		register_post_type( $cpt, $options );
	}

	public function cs_add_speaker_meta_box(WP_Post $post) {
		add_meta_box( 'cs_speaker_meta_box', __( 'Informações sobre o instrutor', 'csacademy' ), function() use ($post) {
			wp_nonce_field( basename( __FILE__ ), 'cs_speaker_meta_box_nonce' );

			$speaker_job_role = get_post_meta( $post->ID, '_cs_speaker_job_role', true );
			$speaker_company = get_post_meta( $post->ID, '_cs_speaker_company', true );
			$speaker_linkedin = get_post_meta( $post->ID, '_cs_speaker_linkedin', true );
			?>
			<div class="cs-input__group">
				<div><label for="cs_speaker_job_role"><?= __( 'Cargo', 'csacademy' ); ?>:</label></div>
				<input type="text" name="cs_speaker_job_role" id="cs_speaker_job_role" value="<?= $speaker_job_role; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_speaker_company"><?= __( 'Empresa', 'csacademy' ); ?>:</label></div>
				<input type="text" name="cs_speaker_company" id="cs_speaker_company" value="<?= $speaker_company; ?>">
			</div>
			<div class="cs-input__group">
				<div><label for="cs_speaker_linkedin"><?= __( 'LinkedIn (link completo)', 'csacademy' ); ?>:</label></div>
				<input type="text" name="cs_speaker_linkedin" id="cs_speaker_linkedin" value="<?= $speaker_linkedin; ?>">
			</div>
			<?php
		}, 'speaker', 'side' );
	}

	public function cs_save_speaker_cpt( $post_id ) {
		if ( ! isset( $_POST['cs_speaker_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['cs_speaker_meta_box_nonce'], basename( __FILE__ ) ) ) return;
		if ( ! current_user_can( 'edit_others_posts' ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		if ( isset( $_POST['cs_speaker_job_role'] ) ) update_post_meta( $post_id, '_cs_speaker_job_role', sanitize_text_field( $_POST['cs_speaker_job_role'] ) );
		if ( isset( $_POST['cs_speaker_company'] ) ) update_post_meta( $post_id, '_cs_speaker_company', sanitize_text_field( $_POST['cs_speaker_company'] ) );
		if ( isset( $_POST['cs_speaker_linkedin'] ) ) update_post_meta( $post_id, '_cs_speaker_linkedin', sanitize_text_field( $_POST['cs_speaker_linkedin'] ) );
	}

	public function cs_add_module_cpt() {
		$cpt = 'module';
		$name = 'Módulos';
		$singular_name = 'Módulo';
		$description = 'Administre os módulos dos cursos';

		$options['public'] = true;
		$options['description'] = __( $description, 'csacademy' );
		$options['register_meta_box_cb'] = array( $this, 'cs_add_module_meta_box' );
		$options['rewrite'] = ['slug' => $cpt];
		$options['menu_position'] = 25;
		$options['menu_icon'] = 'dashicons-book';
		$options['supports'] = ['title', 'editor'];

		$options['labels']['name'] = __( $name, 'csacademy' );
		$options['labels']['singular_name'] = __( $singular_name, 'csacfotoademy' );
		$options['labels']['add_new'] = __( "Adicionar {$singular_name}", 'csacademy' );
		$options['labels']['add_new_item'] = __( "Adicionar novo {$singular_name}", 'csacademy' );
		$options['labels']['edit_item'] = __( "Editar {$singular_name}", 'csacademy' );
		$options['labels']['new_item'] = __( "Novo {$singular_name}", 'csacademy' );
		$options['labels']['view_item'] = __( "Ver {$singular_name}", 'csacademy' );
		$options['labels']['view_items'] = __( "Ver {$name}", 'csacademy' );
		$options['labels']['search_items'] = __( "Buscar {$name}", 'csacademy' );
		$options['labels']['not_found'] = __( "Não há {$name}", 'csacademy' );
		$options['labels']['not_found_in_trash'] = __( "Não há {$name} no lixo", 'csacademy' );
		$options['labels']['all_items'] = __( "Todos os {$name}", 'csacademy' );
		$options['labels']['archives'] = __( "Arquivo de {$name}", 'csacademy' );
		$options['labels']['attributes'] = __( "Informações do {$singular_name}", 'csacademy' );
		$options['labels']['insert_into_item'] = __( "Adicionar ao {$singular_name}", 'csacademy' );
		$options['labels']['upload_to_this_item'] = __( "Adicionar", 'csacademy' );
		$options['labels']['featured_image'] = __( "Imagem em destaque", 'csacademy' );
		$options['labels']['set_featured_image'] = __( "Escolher esta imagem", 'csacademy' );
		$options['labels']['remove_featured_image'] = __( "Apagar esta imagem", 'csacademy' );
		$options['labels']['use_featured_image'] = __( "Usar esta imagem", 'csacademy' );

		register_post_type( $cpt, $options );
	}

	public function cs_add_module_meta_box( WP_Post $post ) {
		add_meta_box( 'cs_module_meta_box', __( 'Informações sobre o módulo', 'csacademy' ), function() use ($post) {
			wp_nonce_field( basename( __FILE__ ), 'cs_module_meta_box_nonce' );

			$module_speaker = get_post_meta( $post->ID, '_cs_module_speaker', true );

			?>
			<div class="cs-input__group">
				<div><label for="cs_module_speaker"><?= __( 'Instrutor', 'csacademy' ); ?>:</label></div>
			<?php

			global $post;
			$outer_loop = $post;

			$args = array(
				'post_type' => 'speaker',
				'post_status' => 'publish'
			);

			$speakers = new WP_Query( $args );

			if( $speakers->have_posts() ) :
			?>
				<select name="cs_module_speaker" id="cs_module_speaker">
			<?php
				while( $speakers->have_posts() ) : $speakers->the_post();
			?>
					<option value="<?= get_the_title(); ?>" <?php if ( $module_speaker == get_the_title() ) echo 'selected'; ?>><?= get_the_title(); ?></option>
			<?php
				endwhile;
				$post = $outer_loop;
			?>
				</select>
			<?php
			else :
			?>
				<span>Cadastre pelo menos um instrutor</span>
			<?php
			endif;
			?>
			</div>

			<?php
		}, 'module', 'side' );
	}

	public function cs_save_module_cpt( $post_id ) {
		if ( ! isset( $_POST['cs_module_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['cs_module_meta_box_nonce'], basename( __FILE__ ) ) ) return;
		if ( ! current_user_can( 'edit_others_posts' ) ) return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		if ( isset( $_POST['cs_module_speaker'] ) ) update_post_meta( $post_id, '_cs_module_speaker', sanitize_text_field( $_POST['cs_module_speaker'] ) );
	}

}
