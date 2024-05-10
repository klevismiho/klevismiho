<section class="section-testimonials">
    <h2 class="section-title">
        <span>Testimonials</span>
    </h2>
    <div class="container">
        <div class="testimonials-grid">
            <?php
            $args = array(
                'post_type' => 'testimonial',
                'posts_per_page' => 10,
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
            ?>
                    <div class="testimonial">
                        <?php the_post_thumbnail(); ?>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>

    </div>
</section>