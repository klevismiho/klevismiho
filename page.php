<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
                the_content();

            endwhile; // End of the loop.
            ?>
        </article>

	</main><!-- #main -->

<?php
get_footer();
