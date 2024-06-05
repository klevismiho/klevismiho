<section class="section-work">
    <div class="container">
        <h2 class="section-title">
            <span>Work</span>
        </h2>
        <p class="section-description">A list of what I have done:</p>
        <div class="work-list">
            <?php
            $args = array(
                'post_type' => 'work',
                'posts_per_page' => 10,
            );
            $query = new WP_Query($args);
            ?>
            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

                @php $work_video = get_post_meta(get_the_ID(), 'work_video', true); @endphp

                    <div class="item">
                        <div class="item-media">
                            @if ($work_video)
                                <video src="{!! $work_video !!}" controls autopla loop poster="{!! get_the_post_thumbnail_url(get_the_ID(), 'full') !!}"></video>
                            @else 
                                <?php the_post_thumbnail(); ?>
                            @endif
                        </div>
                        <div class="item-description">
                            <h3><?php the_title(); ?></h3>
                            <?php the_content(); ?>
                            <?php
                            $skills = get_post_meta(get_the_ID(), 'work_skills', true);
                            if (!empty($skills)) {
                                echo '<div class="work-skills">';
                                foreach ($skills as $skill_id) {
                                    $skill = get_post($skill_id);
                                    if ($skill) {
                                        echo '<div class="skill">';
                                        if (has_post_thumbnail($skill_id)) {
                                            echo get_the_post_thumbnail($skill_id, 'thumbnail');
                                        }
                                        echo '<span class="skill-title">' . esc_html($skill->post_title) . '</span>';
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>