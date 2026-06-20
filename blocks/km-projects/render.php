<?php
/**
 * Block: KM Projects
 * Renders the projects list from the work CPT.
 */
$args = array(
    'post_type'      => 'work',
    'posts_per_page' => 10,
);
$query = new WP_Query( $args );
?>
<section class="section-work" tabindex="0">
    <div class="container">
        <h2 class="section-title"><span>Projects</span></h2>
        <p class="section-description">Some projects I have done:</p>
        <div class="work-list">
            <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                $work_video = get_post_meta( get_the_ID(), 'work_video', true );
            ?>
                <div class="item">
                    <div class="item-media">
                        <?php if ( $work_video ) : ?>
                            <video src="<?php echo esc_url( $work_video ); ?>" controls autoplay loop
                                   poster="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>">
                            </video>
                        <?php else : ?>
                            <?php the_post_thumbnail(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="item-description">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                        <?php
                        $skills = get_post_meta( get_the_ID(), 'work_skills', true );
                        if ( ! empty( $skills ) ) :
                            echo '<div class="work-skills">';
                            foreach ( $skills as $skill_id ) {
                                $skill = get_post( $skill_id );
                                if ( $skill ) {
                                    echo '<div class="skill">';
                                    if ( has_post_thumbnail( $skill_id ) ) {
                                        $image_url = get_the_post_thumbnail_url( $skill_id, 'thumbnail' );
                                        echo '<img src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $skill->post_title ) . '">';
                                    }
                                    echo '<span class="skill-title">' . esc_html( $skill->post_title ) . '</span>';
                                    echo '</div>';
                                }
                            }
                            echo '</div>';
                        endif;
                        ?>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </div>
</section>
