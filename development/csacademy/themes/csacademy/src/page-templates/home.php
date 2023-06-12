<?php /* Template Name: Página Inicial */ ?>

<?php get_header(); ?>
<main id="cs-main">
  <?php if ( has_post_thumbnail() ) : ?>
  <header id="cs-header" class="cs-header" style="background-image: url('<?= get_the_post_thumbnail_url(); ?>');">
  <?php else : ?>
  <header id="cs-header" class="cs-header">
  <?php endif; ?>
    <div class="cs-header-wrapper grid-container">
      <?php
      $csacademy_description = get_bloginfo( 'description', 'display' );
      if ( $csacademy_description || is_customize_preview() ) :
      ?>
      <h1 class="cs-section__header cs-section__header--white"><?= $csacademy_description; ?></h1>
      <?php endif; ?>
      <div class="cs-header__signup">
        <a class="button large" href="#cs-courses"><?= __( 'Veja as formações em aberto', 'csacademy' ); ?></a>
      </div>
    </div>
  </header>
  <section id="cs-about">
    <div class="cs-content-wrapper cs-content-wrapper--center grid-container">
      <?php
  		while ( have_posts() ) : the_post();
  			the_content();
      endwhile;
      ?>
    </div>
  </section>
  <section id="cs-courses">
    <div class="cs-content-wrapper cs-content-wrapper--center grid-container">
      <h2><?= __( 'Próximas turmas', 'csacademy' ); ?></h2>
      <?php
        global $post;
  			$outer_loop = $post;

  			$args = array(
  				'post_type' => 'page',
  				'post_status' => 'publish',
          'meta_key' => '_wp_page_template',
          'meta_value' => 'page-templates/curso.php',
          'meta_query' => array(
            'order_by_date'  => array(
              'key' => '_cs_course_date_start'
            )
          ),
          'orderby' => array(
            'order_by_date' => get_theme_mod( 'course_order_setting' )
          )
  			);

  			$courses = new WP_Query( $args );

  			if( $courses->have_posts() ) :
          while( $courses->have_posts() ) : $courses->the_post();
      ?>
      <a class="cs-courses__course" href="<?= get_permalink(); ?>">
        <div class="cs-courses__course-info cs-speakers__speaker grid-x">
          <?php if ( has_post_thumbnail() ) : ?>
          <div class="cs-speakers__speaker-picture cell large-3">
            <img src="<?= get_the_post_thumbnail_url(); ?>" alt="<?= get_the_title(); ?>">
          </div>
          <div class="cs-speakers__speaker-minibio cell large-auto">
          <?php else : ?>
          <div class="cs-speakers__speaker-minibio cell">
          <?php endif; ?>
            <h3 class="cs-courses__course-info-title cs-speakers__speaker-name"><?= get_the_title(); ?></h3>
            <strong class="cs-courses__course-info-metadata"><?= csacademy_get_date_sentence(); ?></strong>
            <?php if ( metadata_exists( 'post', get_the_ID(), '_cs_course_short_description' ) ): ?><p class="cs-courses__course-info-content"><?= get_post_meta( get_the_ID(), '_cs_course_short_description', true ); ?></p><?php endif; ?>
          </div>
        </div>
      </a>
      <?php
          endwhile;
          $post = $outer_loop;
        else :
      ?>
      <div class="grid-x">
        <div class="cell">
          <p><?= __( 'Não há novas turmas abertas. Saiba mais sobre novas turmas em nosso <a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">blog</a>.', 'csacademy' ); ?></p>
        </div>
      </div>
      <?php
        endif;
      ?>
    </div>
  </section>
</main>
<?php get_footer(); ?>
