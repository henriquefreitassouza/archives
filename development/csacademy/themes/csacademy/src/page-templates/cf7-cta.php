<!--
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
<div class="cell large-6">
  <p>Preencha o formulário e agende sua entrevista</p>
  <?php if ( $contact_form_7 ) : ?>
    <?php if ( metadata_exists( 'post', get_the_ID(), '_cs_course_form_shortcode' ) ) : ?>
      <?= do_shortcode( html_entity_decode ( get_post_meta( get_the_ID(), '_cs_course_form_shortcode', true ) ) ); ?>
    <?php else: ?>
      <p>Crie um formulário usando o plugin Contact Form 7. Depois, copie e cole o ID e o título do formulário nos campos indicados da página de curso.</p>
    <?php endif; ?>
  <?php else : ?>
    <p>Instale e ative o plugin Contact Form 7 para usar a fumcionalidade de formulários.</p>
  <?php endif; ?>
</div>
-->
