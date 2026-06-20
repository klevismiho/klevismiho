<?php
/**
 * Block: KM Experience
 * Renders the work experience list from the experience CPT.
 */
$args = array(
    'post_type'      => 'experience',
    'posts_per_page' => 10,
);
$query = new WP_Query( $args );
?>
<section class="section-experience" tabindex="0">
    <div class="container">
        <h2 class="section-title"><span>Experience</span></h2>
        <p class="section-description">Work experience: <a href="https://www.linkedin.com/in/klevis-miho-74a29211/" target="_blank" style="text-decoration:underline;">Linkedin</a></p>
        <div class="experience-list">
            <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
                $company_description = get_post_meta( get_the_ID(), 'experience_company_description', true );
                $start_date          = get_post_meta( get_the_ID(), 'experience_start_date', true );
                $end_date            = get_post_meta( get_the_ID(), 'experience_end_date', true );
                $start_date_formatted = $start_date ? ( new DateTime( $start_date ) )->format( 'M Y' ) : '';
                $end_date_formatted   = $end_date   ? ( new DateTime( $end_date ) )->format( 'M Y' )   : '';
            ?>
                <div class="item">
                    <div class="item-image">
                        <?php
                        $thumbnail_id = get_post_thumbnail_id();
                        if ( $thumbnail_id ) {
                            $image_data = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                            echo '<img src="' . esc_url( $image_data[0] ) . '" width="100" height="100" alt="' . esc_attr( 'Klevis Miho at ' . get_the_title() ) . '">';
                        }
                        ?>
                    </div>
                    <div class="item-content">
                        <h3><?php the_title(); ?></h3>
                        <?php if ( $company_description ) : ?>
                            <div class="company-description"><?php echo wp_kses_post( $company_description ); ?></div>
                        <?php endif; ?>
                        <?php if ( $start_date_formatted || $end_date_formatted ) : ?>
                            <div class="experience-dates"><?php echo esc_html( $start_date_formatted ); ?> – <?php echo esc_html( $end_date_formatted ); ?></div>
                        <?php endif; ?>
                        <div class="what-did-i-do">
                            <h4>My role</h4>
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </div>
</section>
