<?php /* Template Name: Curso */ ?>

<?php
/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

$contact_form_7 = false;
// check for plugin using plugin name
if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
  //plugin is activated
  $contact_form_7 = true;
}
?>

<?php get_header(); ?>
<main id="cs-main">
  <?php if ( has_post_thumbnail() ) : ?>
  <header id="cs-header" class="cs-header" style="background-image: url('<?= get_the_post_thumbnail_url(); ?>');">
  <?php else : ?>
  <header id="cs-header" class="cs-header">
  <?php endif; ?>
    <div class="cs-header-wrapper grid-container">
      <h1 class="cs-section__header cs-section__header--white"><?php the_title(); ?></h1>
      <div class="cs-header__course-information grid-x">
        <div class="cell medium-4">
          <strong>Data: </strong>
          <span><?= csacademy_get_date_sentence(); ?></span>
        </div>

        <div class="cell medium-4">
          <strong>Horário: </strong>
          <span><?= get_post_meta( get_the_ID(), '_cs_course_time', true ); ?></span>
        </div>

        <div class="cell medium-4">
          <strong>Local: </strong>
          <a href="#cs-signup"><?= get_post_meta( get_the_ID(), '_cs_course_place', true ); ?></a>
        </div>
      </div>
      <div class="cs-header__signup">
        <a href="<?= get_post_meta( get_the_ID(), '_cs_course_cta_link', true ); ?>" class="button large"><?= get_post_meta( get_the_ID(), '_cs_course_cta_text', true ); ?></a>
      </div>
    </div>
  </header>
  <nav class="cs-course-navigation">
    <ul class="vertical medium-horizontal menu align-center">
      <li><a href="#cs-about"><?= __( 'Sobre o curso', 'csacademy' ); ?></a></li>
      <li><a href="#cs-speakers"><?= __( 'Instrutores', 'csacademy' ); ?></a></li>
      <li><a href="#cs-modules"><?= __( 'Módulos', 'csacademy' ); ?></a></li>
      <li><a href="#cs-signup"><?= __( 'Inscreva-se', 'csacademy' ); ?></a></li>
    </ul>
  </nav>
  <section id="cs-about">
    <div class="cs-content-wrapper cs-content-wrapper--center grid-container">
      <?php
  		while ( have_posts() ) : the_post();
  			the_content();
      endwhile;
      ?>
      <div class="cs-section__cta">
        <a href="#cs-modules" class="hollow button large">Saiba mais sobre a formação</a>
      </div>
    </div>
  </section>
  <section id="cs-speakers">
    <div class="cs-content-wrapper cs-content-wrapper--center grid-container">
      <h2>Conte com o apoio de experts em sua jornada</h2>
      <?php
        $speaker_values;
        if ( metadata_exists( 'post', get_the_ID(), '_cs_course_speaker' ) ) $speaker_values = explode( ' ', get_post_meta( get_the_ID(), '_cs_course_speaker', true ) );

        global $post;
  			$outer_loop = $post;

  			$args = array(
  				'post_type' => 'speaker',
  				'post_status' => 'publish'
  			);

  			$speakers = new WP_Query( $args );

  			if( is_array( $speaker_values ) && $speakers->have_posts() ) :
          while( $speakers->have_posts() ) : $speakers->the_post();
            if ( in_array( get_the_ID(), $speaker_values ) ) :
      ?>
      <div class="cs-speakers__speaker grid-x">
        <?php if ( has_post_thumbnail() ) : ?>
        <div class="cs-speakers__speaker-picture cell large-3">
          <img src="<?= get_the_post_thumbnail_url(); ?>" alt="<?= get_the_title(); ?>">
        </div>
        <div class="cs-speakers__speaker-minibio cell large-auto">
        <?php else : ?>
        <div class="cs-speakers__speaker-minibio cell">
        <?php endif; ?>
          <?php if ( metadata_exists( 'post', get_the_ID(), '_cs_speaker_linkedin' ) && !empty( get_post_meta( get_the_ID(), '_cs_speaker_linkedin', true ) ) ) : ?>
            <a href="<?= get_post_meta( get_the_ID(), '_cs_speaker_linkedin', true ); ?>" target="_blank"><h3 class="cs-speakers__speaker-name"><?= get_the_title(); ?></h3></a>
          <?php else: ?>
            <h3 class="cs-speakers__speaker-name"><?= get_the_title(); ?></h3>
          <?php endif; ?>
          <strong class="cs-speakers__speaker-job-title"><?= get_post_meta( get_the_ID(), '_cs_speaker_job_role', true ); ?></strong>
        <?php the_content(); ?>
        </div>
      </div>
      <?php
            endif;
          endwhile;
          $post = $outer_loop;
        else :
      ?>
      <div class="grid-x">
        <div class="cell">
          <p>Selecione ao menos um instrutor.</p>
        </div>
      </div>
      <?php
        endif;
      ?>
    </div>
  </section>
  <section id="cs-modules">
    <div class="cs-content-wrapper cs-content-wrapper--center grid-container">
      <h2>Saiba o que será abordado nesta formação</h2>
      <div class="grid-x">
        <div class="cell">

      <?php
        $module_values;
        if ( metadata_exists( 'post', get_the_ID(), '_cs_course_module' ) ) $module_values = explode( ' ', get_post_meta( get_the_ID(), '_cs_course_module', true ) );

        global $post;
        $outer_loop = $post;

        $args = array(
          'post_type' => 'module',
          'post_status' => 'publish'
        );

        $modules = new WP_Query( $args );

        if( is_array( $module_values ) && $modules->have_posts() ) :
      ?>
      <ul class="cs-modules__container accordion" data-accordion data-allow-all-closed="true">
      <?php
        while( $modules->have_posts() ) : $modules->the_post();
          if ( in_array( get_the_ID(), $module_values ) ) :
      ?>
        <li class="cs-modules__item accordion-item" data-accordion-item>
          <a href="#" class="accordion-title"><strong><?= get_the_title(); ?></strong><span><?= get_post_meta( get_the_ID(), '_cs_module_speaker', true ); ?></span></a>
          <div class="accordion-content" data-tab-content>
            <?php the_content(); ?>
          </div>
        </li>
      <?php
          endif;
        endwhile;
        $post = $outer_loop;
      ?>
      </ul>
      <?php
        else :
      ?>
      <p>Selecione pelo menos um módulo.</p>
      <?php
        endif;
      ?>
        </div>
      </div>
    </div>
  </section>
  <section id="cs-signup">
    <div class="cs-content-wrapper cs-content-wrapper--center grid-container">
      <h2>Aprenda a criar um time de customer success com experts</h2>
      <div class="grid-x grid-margin-x">
        <div class="cell large-6">
          <div class="cs-signup__info">
            <?php if ( metadata_exists( 'post', get_the_ID(), '_cs_course_location_address' ) ) : ?>
            <p class="cs-signup__info-address"><strong><?= __( 'Endereço: ', 'csacademy' ); ?></strong><?= get_post_meta( get_the_ID(), '_cs_course_location_address', true ); ?></p>
            <?php endif; ?>
            <?php if ( metadata_exists( 'post', get_the_ID(), '_cs_course_price' ) ) : ?>
            <p class="cs-signup__info-price"><strong><?= __( 'Preço: ', 'csacademy' ); ?></strong><?= get_post_meta( get_the_ID(), '_cs_course_price', true ); ?></p>
            <?php endif; ?>
          </div>
          <?php if ( metadata_exists( 'post', get_the_ID(), '_cs_course_location_map' ) && !empty( get_post_meta( get_the_ID(), '_cs_course_location_map', true ) ) ) : ?>
          <div class="cs-signup__map">
            <?=  html_entity_decode ( get_post_meta( get_the_ID(), '_cs_course_location_map', true ) ); ?>
          </div>
          <?php endif; ?>
        </div>
        <div class="cell large-6 text-center">
          <div class="cs-signup__cta">
            <p class="lead"><?= get_post_meta( get_the_ID(), '_cs_course_cta_bottom_call', true ); ?></p>
            <a href="<?= get_post_meta( get_the_ID(), '_cs_course_cta_bottom_link', true ); ?>" class="button large"><?= get_post_meta( get_the_ID(), '_cs_course_cta_bottom_text', true ); ?></a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
