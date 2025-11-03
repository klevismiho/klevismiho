<?php get_header(); ?>

<main id="main-content">

    <section class="section-hero" id="section-hero" tabindex="0">
        <div class="container">
            <div class="hero-content">
                <h1>Hi, I'm Klevis</h1>
                <p>I've spent 15 years building WordPress websites that work. I take your designs and turn them into fast, functional sites that people can actually use.
                    My work includes converting Figma mockups to WordPress themes, fixing slow e-commerce sites, and building custom functionality. I make sure every site loads quickly, ranks well in search engines, and works for users with disabilities.
                    I've worked with startups and large companies, led remote development teams, and handled projects across different time zones. When clients see their sites finally perform the way they need them to, that's what makes the work worthwhile.
                    If you need a WordPress site built right, or want to fix problems with your current one, I can help.</p>
            </div>
            <div class="hero-image">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/klevismiho.webp" alt="Klevis Miho" width="500" height="500">
            </div>
        </div>
    </section>

    <section class="section-member" tabindex="0">
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

                        <?php
                        $thumbnail_id = get_post_thumbnail_id();
                        if ($thumbnail_id) {
                            $image_data = wp_get_attachment_image_src($thumbnail_id, 'full');
                            $image_url = $image_data[0];

                            echo '<img src="' . esc_url($image_url) . '" width="100" height="100" alt="Klevis Miho on ' . get_the_title() . '">';
                        }
                        ?>
                        <div class="skill-name"><?php the_title(); ?></div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </section>

    <section class="section-skills" tabindex="0">
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
                            <?php
                            $thumbnail_id = get_post_thumbnail_id();
                            if ($thumbnail_id) {
                                $image_data = wp_get_attachment_image_src($thumbnail_id, 'full');
                                $image_url = $image_data[0];

                                echo '<img src="' . esc_url($image_url) . '" width="100" height="100" alt="Klevis Miho knows ' . get_the_title() . '">';
                            }
                            ?>
                            <div class="skill-name"><?php the_title(); ?></div>
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>

        </div>
    </section>

    <section class="section-certification-membership" tabindex="0">
        <h2 class="section-title">
            <span>Certifications & Memberships</span>
        </h2>
        <p class="section-description">My professional affiliations and certifications.</p>
        <div class="member-grid">
            <div class="skill">
                <a href="https://www.credly.com/badges/6d27f144-208c-49c4-ac35-897e71123812/public_url" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/member/iaap-professional-member.png" width="200" height="200" alt="IAAP Professional Member"></a>
                <div class="skill-name">IAAP Professional Member</div>
            </div>
            <div class="skill">
                <a href="<?php echo get_template_directory_uri(); ?>/images/member/accesstia-accessibility-fundamentials.pdf" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/member/accesstia-accessibility.webp" width="200" height="200" alt="IAAP Professional Member"></a>
                <div class="skill-name">Accesstia Accessibility Fundamentals</div>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/services'); ?>

    <section class="section-experience" tabindex="0">
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
                                <?php
                                $thumbnail_id = get_post_thumbnail_id();
                                if ($thumbnail_id) {
                                    $image_data = wp_get_attachment_image_src($thumbnail_id, 'full');
                                    $image_url = $image_data[0];
                                    $alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

                                    echo '<img src="' . esc_url($image_url) . '" width="100" height="100" alt="Klevis Miho on ' . get_the_title() . '">';
                                }
                                ?>
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
                        </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </div>
    </section>

    <section class="section-work" tabindex="0">
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
                                <?php echo '<p>' . get_the_excerpt() . '</p>'; ?>
                                <?php
                                $skills = get_post_meta(get_the_ID(), 'work_skills', true);
                                if (!empty($skills)) {
                                    echo '<div class="work-skills">';
                                    foreach ($skills as $skill_id) {
                                        $skill = get_post($skill_id);
                                        if ($skill) {
                                            echo '<div class="skill">';
                                            if (has_post_thumbnail($skill_id)) {
                                                // Get the image URL
                                                $image_url = get_the_post_thumbnail_url($skill_id, 'thumbnail');

                                                // Use the skill title as alt text
                                                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($skill->post_title) . '">';
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

    <section class="section-get-in-touch" tabindex="0">
        <div class="container">
            <h2 class="section-title">
                <span>Get in touch</span>
            </h2>
            <p>Feel free to reach out to me if you are looking for a web developer. Initial consultation is free.</p>
            <p>Email: klevisi@gmail.com</p>
            <p>You can find me also on: </p>
            <ul>
                <li><a href="https://github.com/klevismiho" target="_blank">Github</a></li>
                <li><a href="https://www.linkedin.com/in/klevis-miho-74a29211/?originalSubdomain=al" target="_blank">LinkedIn</a></li>
                <li><a href="https://x.com/klevismiho?lang=en" target="_blank">X</a>
            </ul>
        </div>
    </section>

</main>

<?php get_footer(); ?>