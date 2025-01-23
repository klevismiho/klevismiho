<?php get_header(); ?>

<section class="section-hero">
    <div class="container">
        <div class="hero-content">
            <h1>Hi, I'm Klevis</h1>
            <p>A SEO focused full stack Wordpress developer with over 14 years experience in frontend and backend coding languages, development frameworks and third-party libraries and have familiarity with various content management systems.</p>
            <p>Tirana, Albania</p>
        </div>
        <div class="hero-image">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/klevismiho.jpeg" alt="Klevis Miho">
        </div>
    </div>
</section>

<section class="section-skills">
    <h2 class="section-title">
        <span>Skills</span>
    </h2>
    <div class="container">
        <p class="section-description">The skills, tools and technologies that I use or have used in the past</p>
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


<section class="section-member">
    <h2 class="section-title">
        <span>Platforms</span>
    </h2>
    <p class="section-description">Platforms I am on:</p>
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

<section class="section-experience">
    <div class="container">
        <h2 class="section-title">
            <span>Experience</span>
        </h2>
        <p class="section-description">Work experience:</p>
        <div class="experience-list">
            <?php
            $args = array(
                'post_type' => 'experience',
                'posts_per_page' => 10,
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
            ?>

                    <?php 
                    $company_description = get_post_meta(get_the_ID(), 'experience_company_description', true);
                    $start_date = get_post_meta(get_the_ID(), 'experience_start_date', true);
                    $end_date = get_post_meta(get_the_ID(), 'experience_end_date', true);
                    $start_date_formatted = (new DateTime($start_date))->format('M Y');
                    $end_date_formatted = (new DateTime($end_date))->format('M Y');
                    ?>

                    <div class="item">
                        <div class="item-image">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div class="item-content">
                            <h3><?php the_title(); ?></h3>
                            <?php if ($company_description) : ?>
                                <div class="company-description">
                                    <?php echo $company_description; ?>
                                </div>
                            <?php endif; ?>
                            <div class="what-did-i-do">
                                <h4>My role</h4>
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <div class="item-meta">
                            <?php echo $start_date_formatted . ' - ' . $end_date_formatted; ?>
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>

<section class="section-work">
    <div class="container">
        <h2 class="section-title">
            <span>Work</span>
        </h2>
        <p class="section-description">Some projects I have done:</p>
        <div class="work-list">
            <?php
            $args = array(
                'post_type' => 'work',
                'posts_per_page' => 10,
            );
            $query = new WP_Query($args);
            ?>
            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

                <?php 
                $work_video = get_post_meta(get_the_ID(), 'work_video', true);
                $company_description = get_post_meta( get_the_ID(), 'company_description', true );
                ?>

                    <div class="item">
                        <div class="item-media">
                            <?php if ($work_video) : ?>
                                <video src="<?php echo $work_video; ?>" controls autopla loop poster="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"></video>
                            <?php else : ?>
                                <?php the_post_thumbnail(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="item-description">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php echo '<p>' . $company_description . '</p>'; ?>
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

<section class="section-get-in-touch">
    <div class="container">
        <h2 class="section-title">
            <span>Get in touch</span>
        </h2>
        <p>Feel free to reach out to me if you are looking for a developer or consultant. You will get a free consultation.</p>
        <p>klevisi@gmail.com</p>
        <p>You can find me also on: </p>
        <ul>
            <li><a href="https://github.com/klevismiho" target="_blank">Github</a></li>
            <li><a href="https://www.linkedin.com/in/klevis-miho-74a29211/?originalSubdomain=al" target="_blank">LinkedIn</a></li>
            <li><a href="https://x.com/klevismiho?lang=en" target="_blank">X</a>
        </ul>
    </div>
</section>

<?php get_footer(); ?>