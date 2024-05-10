<section class="section-skills">
    <h2 class="section-title">
        <span>Skills</span>
    </h2>
    <div class="container">
        <p class="section-description">The skills, tools and technologies I am really good at:</p>
        <div class="skills-grid">
            <?php
            $args = array(
                'post_type' => 'skill',
                'posts_per_page' => 100,
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

    </div>
</section>