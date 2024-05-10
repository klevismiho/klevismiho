<section class="section-member">
    <h2 class="section-title">
        <span>Part of</span>
    </h2>
    <p class="section-description">Top freelancing platforms I am vetted on:</p>
    <div class="member-grid">
        <?php
        $args = array(
            'post_type' => 'member',
            'posts_per_page' => 10,
        );
        $skills_query = new WP_Query($args);
        if ($skills_query->have_posts()) :
            while ($skills_query->have_posts()) : $skills_query->the_post();
        ?>
                <div class="skill">
                    <?php the_post_thumbnail(); ?>
                    <div class="skill-name"><?php the_title(); ?></div>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif; ?>
    </div>
</section>