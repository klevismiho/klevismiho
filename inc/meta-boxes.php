<?php

/**
 * Add meta boxes for the 'work' post type
 */

/**
 * Add meta box for skills
 */
function add_skills_meta_box()
{
    add_meta_box(
        'work_skills_meta_box',
        'Skills',
        'render_skills_meta_box',
        'work',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_skills_meta_box');

/**
 * Render the skills meta box
 */
function render_skills_meta_box($post)
{
    $skills = get_posts(array(
        'post_type'      => 'skill',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ));

    $selected_skills = get_post_meta($post->ID, 'work_skills', true);
    if (!is_array($selected_skills)) {
        $selected_skills = array(); // Ensure it's an array
    }

    echo '<label for="work_skills">Select Skills:</label>';
    echo '<select id="work_skills" name="work_skills[]" multiple>';
    foreach ($skills as $skill) {
        $selected = in_array($skill->ID, $selected_skills) ? 'selected' : '';
        echo '<option value="' . $skill->ID . '" ' . $selected . '>' . $skill->post_title . '</option>';
    }
    echo '</select>';
}

/**
 * Save the selected skills
 */
function save_work_skills($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['work_skills'])) {
        $skills = array_map('intval', $_POST['work_skills']);
        update_post_meta($post_id, 'work_skills', $skills);
    } else {
        delete_post_meta($post_id, 'work_skills');
    }
}
add_action('save_post', 'save_work_skills');

/**
 * Enqueue Selectize.js
 */
function enqueue_selectize()
{
    wp_enqueue_script('selectize', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js', array('jquery'), '0.13.3', true);
    wp_enqueue_style('selectize', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css', array(), '0.13.3');
}
add_action('admin_enqueue_scripts', 'enqueue_selectize');


/**
 * Meta box for video upload
 */
function add_video_meta_box()
{
    add_meta_box(
        'work_video_meta_box',
        'Video',
        'render_video_meta_box',
        'work',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_video_meta_box');


/**
 * Render the video meta box
 */
function render_video_meta_box($post)
{
    wp_nonce_field('save_work_video', 'work_video_nonce');
    $video_url = get_post_meta($post->ID, 'work_video', true);
?>
    <label for="work_video">Upload Video:</label>
    <input type="text" id="work_video" name="work_video" value="<?php echo esc_attr($video_url); ?>" style="width:80%;" />
    <button id="upload_video_button" class="button">Upload Video</button>
<?php
}

/**
 * Save the video URL
 */
function enqueue_media_uploader()
{
    wp_enqueue_media();
    wp_enqueue_script('work-video-uploader', get_template_directory_uri() . '/js/video-uploader.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');

/**
 * Save the video URL
 */
function save_work_video($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST['work_video_nonce']) || !wp_verify_nonce($_POST['work_video_nonce'], 'save_work_video')) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['work_video'])) {
        update_post_meta($post_id, 'work_video', esc_url($_POST['work_video']));
    } else {
        delete_post_meta($post_id, 'work_video');
    }
}
add_action('save_post', 'save_work_video');


/**
 * Enqueue scripts for the video uploader
 */
function init_video_upload()
{
?>
    <script>
        jQuery(document).ready(function($) {
            $("#upload_video_button").click(function(e) {
                e.preventDefault();

                var videoUploader = wp.media({
                        title: "Upload Video",
                        button: {
                            text: "Use this video"
                        },
                        multiple: false
                    })
                    .on("select", function() {
                        var attachment = videoUploader.state().get("selection").first().toJSON();
                        $("#work_video").val(attachment.url);
                    })
                    .open();
            });
        });
    </script>
<?php
}
add_action('admin_footer', 'init_video_upload');



// Add the meta box for the 'work' post type.
function add_company_description_meta_box()
{
    add_meta_box(
        'company_description_meta_box', // Meta box ID
        'Company Description', // Meta box Title
        'company_description_meta_box_callback', // Callback function
        'work', // Post type ('work' in this case)
        'normal', // Context ('normal', 'side', or 'advanced')
        'default' // Priority
    );
}
add_action('add_meta_boxes', 'add_company_description_meta_box');

// Callback to display the meta box.
function company_description_meta_box_callback($post)
{
    // Retrieve the current value.
    $company_description = get_post_meta($post->ID, 'company_description', true);

    // Add a nonce field for security.
    wp_nonce_field('company_description_meta_box_nonce_action', 'company_description_meta_box_nonce');

    // Display the meta box form.
    echo '<label for="company_description_field">Enter the company description:</label>';
    echo '<textarea id="company_description_field" name="company_description_field" rows="5" style="width: 100%;">' . esc_textarea($company_description) . '</textarea>';
}

// Save the meta box value.
function save_company_description_meta_box($post_id)
{
    // Verify the nonce.
    if (! isset($_POST['company_description_meta_box_nonce']) || ! wp_verify_nonce($_POST['company_description_meta_box_nonce'], 'company_description_meta_box_nonce_action')) {
        return;
    }

    // Check for autosave.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions.
    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sanitize and save the data.
    if (isset($_POST['company_description_field'])) {
        update_post_meta($post_id, 'company_description', sanitize_textarea_field($_POST['company_description_field']));
    }
}
add_action('save_post', 'save_company_description_meta_box');
