<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Klevis_Miho
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function klevismiho_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'klevismiho_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function klevismiho_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'klevismiho_pingback_header' );



// Register Custom Post Type
function km_register_post_types()
{

    // Skills
    $skill_labels = array(
        'name'                  => _x('Skills', 'Post Type General Name', 'klevismiho'),
        'singular_name'         => _x('Skill', 'Post Type Singular Name', 'klevismiho'),
    );

    $skill_args = array(
        'label'                 => __('Skill', 'klevismiho'),
        'description'           => __('Post Type Description', 'klevismiho'),
        'labels'                => $skill_labels,
        'supports'              => array('title', 'thumbnail', 'editor'),
        'public'                => true,
    );

    register_post_type('skill', $skill_args);


    // Members
    $member_labels = array(
        'name'                  => _x('Member', 'Post Type General Name', 'klevismiho'),
        'singular_name'         => _x('Member', 'Post Type Singular Name', 'klevismiho'),
    );

    $member_args = array(
        'label'                 => __('Member', 'klevismiho'),
        'description'           => __('Post Type Description', 'klevismiho'),
        'labels'                => $member_labels, 
        'supports'              => array('title', 'thumbnail', 'editor'),
        'public'                => true,
    );

    register_post_type('member', $member_args);


    // Experience
    $experience_labels = array(
        'name'                  => _x('Experience', 'Post Type General Name', 'klevismiho'),
        'singular_name'         => _x('Experience', 'Post Type Singular Name', 'klevismiho'),
    );

    $experience_args = array(
        'label'                 => __('Experience', 'klevismiho'),
        'description'           => __('Post Type Description', 'klevismiho'),
        'labels'                => $experience_labels,
        'supports'              => array('title', 'thumbnail', 'editor'),
        'public'                => true,
    );

    register_post_type('experience', $experience_args);


    // Work
    $work_labels = array(
        'name'                  => _x('Work', 'Post Type General Name', 'klevismiho'),
        'singular_name'         => _x('Work', 'Post Type Siangular Name', 'klevismiho'),
    );

    $work_args = array(
        'label'                 => __('Work', 'klevismiho'),
        'description'           => __('Post Type Description', 'klevismiho'),
        'labels'                => $work_labels,
        'supports'              => array('title', 'thumbnail', 'editor'),
        'public'                => true,
        'show_in_rest'          => true,
    );

    register_post_type('work', $work_args);


    // Testimonial
    $testimonial_labels = array(
        'name'                  => _x('Testimonial', 'Post Type General Name', 'klevismiho'),
        'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'klevismiho'),
    );

    $testimonial_args = array(
        'label'                 => __('Testimonial', 'klevismiho'),
        'description'           => __('Post Type Description', 'klevismiho'),
        'labels'                => $testimonial_labels,
        'supports'              => array('title', 'thumbnail', 'editor'),
        'public'                => true,
    );

    register_post_type('testimonial', $testimonial_args);


}
add_action('init', 'km_register_post_types', 0);


/*
* Add meta boxes for the 'experience' post type
*/

add_action('add_meta_boxes', function () {
    add_meta_box(
        'experience_meta_box',
        'Experience Details',
        'render_experience_meta_box',
        'experience',
        'normal',
        'default'
    );
});

// Callback function to render meta box content
function render_experience_meta_box($post)
{
    // Retrieve existing values from the database
    $start_date = get_post_meta($post->ID, 'experience_start_date', true);
    $end_date = get_post_meta($post->ID, 'experience_end_date', true);
    $company_description = get_post_meta($post->ID, 'experience_company_description', true);
    $company_website = get_post_meta($post->ID, 'experience_company_website', true);

    // Add nonce field
    wp_nonce_field('experience_meta_box_nonce', 'experience_meta_box_nonce');
    ?>

    <!-- Display input fields for meta box -->
    <p>
        <label for="experience_start_date">Start Date:</label>
        <input type="date" id="experience_start_date" name="experience_start_date" value="<?php echo esc_attr($start_date); ?>">
    </p>

    <p>
        <label for="experience_end_date">End Date:</label>
        <input type="date" id="experience_end_date" name="experience_end_date" value="<?php echo esc_attr($end_date); ?>">
    </p>

    <p>
        <label for="experience_company_website">Company Website</label>
        <input type="text" id="experience_company_website" name="experience_company_website" value="<?php echo esc_attr($company_website); ?>">
    </p>

    <p>
        <label for="experience_company_description">Company Description:</label>
        <?php
        // WYSIWYG editor for Company Description
        wp_editor($company_description, 'experience_company_description', array(
            'textarea_name' => 'experience_company_description',
        ));
        ?>
    </p>

    <?php
}


// Save meta box data
add_action('save_post', function ($post_id) {
    // Check if nonce is set
    if (!isset($_POST['experience_meta_box_nonce'])) {
        return;
    }
    // Verify nonce
    if (!wp_verify_nonce($_POST['experience_meta_box_nonce'], 'experience_meta_box_nonce')) {
        return;
    }
    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    // Save meta data
    if (isset($_POST['experience_start_date'])) {
        update_post_meta($post_id, 'experience_start_date', sanitize_text_field($_POST['experience_start_date']));
    }
    if (isset($_POST['experience_end_date'])) {
        update_post_meta($post_id, 'experience_end_date', sanitize_text_field($_POST['experience_end_date']));
    }
    if (isset($_POST['experience_company_description'])) {
        update_post_meta($post_id, 'experience_company_description', sanitize_textarea_field($_POST['experience_company_description']));
    }
});


function init_selectize() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        $('#work_skills').selectize({
            plugins: ['remove_button', 'drag_drop'],
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                };
            }
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'init_selectize');


/**
 * Allow SVG uploads in WordPress
 */
function klevis_allow_svg_uploads($mimes) {
    // Add SVG mime type to allowed file types
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'klevis_allow_svg_uploads');


/**
 * Optional: Sanitize SVGs using the safe-svg library
 */
function klevis_sanitize_svg_uploads($file) {
    if ($file['type'] === 'image/svg+xml') {
        // Add any additional validation logic if necessary
    }
    return $file;
}
add_filter('wp_check_filetype_and_ext', 'klevis_sanitize_svg_uploads', 10, 4);
