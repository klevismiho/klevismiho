<?php
/**
 * Block: KM Platforms
 * Renders the platforms grid from the member CPT.
 */
$args = array(
    'order'          => 'ASC',
    'posts_per_page' => 10,
    'post_type'      => 'member',
    'orderby'        => 'menu_order',
);
$query = new WP_Query( $args );
?>
<section class="section-member" tabindex="0">
    <h2 class="section-title"><span>Platforms</span></h2>
    <p class="section-description">Platforms I am on:</p>
    <div class="member-grid">
        <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
            <div class="skill">
                <?php
                $thumbnail_id = get_post_thumbnail_id();
                if ( $thumbnail_id ) {
                    $image_data = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                    echo '<img src="' . esc_url( $image_data[0] ) . '" width="100" height="100" alt="' . esc_attr( 'Klevis Miho on ' . get_the_title() ) . '">';
                }
                ?>
                <div class="skill-name"><?php the_title(); ?></div>
            </div>
        <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
</section>
