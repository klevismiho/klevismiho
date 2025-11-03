<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Klevis_Miho
 */

get_header();
?>

	<main id="primary" class="site-main">

		<article class="small container">
            <?php
            while ( have_posts() ) :
                the_post();
                the_post_thumbnail(); 
                $company_description = get_post_meta( get_the_ID(), 'company_description', true );
                ?>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                <h2>Company Overview</h2>
                <p><?php echo esc_html( $company_description ); ?></p>
                <?php
                the_content();

            endwhile; // End of the loop.
            ?>
        </article>

	</main><!-- #main -->

<?php
get_footer();
