<section class="section-experience">
    <div class="container">
        <h2 class="section-title">
            <span>Experience</span>
        </h2>
        <p class="section-description">Full time work experience:</p>
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

                    @php $company_description = get_post_meta(get_the_ID(), 'experience_company_description', true); @endphp
                    @php $start_date = get_post_meta(get_the_ID(), 'experience_start_date', true); @endphp
                    @php $end_date = get_post_meta(get_the_ID(), 'experience_end_date', true); @endphp

                    <div class="item">
                        <div class="item-image">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div class="item-content">
                            <h3><?php the_title(); ?></h3>
                            @if ($company_description)
                                <div class="company-description">
                                    {!! $company_description !!}
                                </div>
                            @endif
                            <div class="what-did-i-do">
                                <h4>My role</h4>
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <div class="item-meta">
                            {{ $start_date }} - {{ $end_date }}
                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>