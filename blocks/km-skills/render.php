<?php
/**
 * Block: KM Skills
 * Renders the skills grid from the skill CPT.
 */
$args = array(
    'post_type'      => 'skill',
    'posts_per_page' => 100,
);
$query = new WP_Query( $args );
?>
<section class="section-skills" tabindex="0">
    <h2 class="section-title"><span>Skills</span></h2>
    <div class="container">
        <p class="section-description">The skills, tools and technologies that I use or have used in the past</p>
        <div class="skills-grid">
            <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="skill">
                    <?php
                    $thumbnail_id = get_post_thumbnail_id();
                    if ( $thumbnail_id ) {
                        $image_data = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                        echo '<img src="' . esc_url( $image_data[0] ) . '" width="100" height="100" alt="' . esc_attr( 'Klevis Miho knows ' . get_the_title() ) . '">';
                    }
                    ?>
                    <div class="skill-name"><?php the_title(); ?></div>
                </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </div>
</section>
