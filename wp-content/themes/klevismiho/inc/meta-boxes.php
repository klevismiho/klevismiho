<?php

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



/*
* Add meta boxes for the 'work' post type
*/

// Skills 

function add_skills_meta_box() {
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

function render_skills_meta_box($post) {
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

function save_work_skills($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['work_skills'])) {
        $skills = array_map('intval', $_POST['work_skills']);
        update_post_meta($post_id, 'work_skills', $skills);
    } else {
        delete_post_meta($post_id, 'work_skills');
    }
}
add_action('save_post', 'save_work_skills');


// Add better UI to the select dropdown
function enqueue_selectize() {
    wp_enqueue_script('selectize', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js', array('jquery'), '0.13.3', true);
    wp_enqueue_style('selectize', 'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css', array(), '0.13.3');
}
add_action('admin_enqueue_scripts', 'enqueue_selectize');


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


// Video Upload

// Add meta box for video upload
function add_video_meta_box() {
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


function render_video_meta_box($post) {
    wp_nonce_field('save_work_video', 'work_video_nonce');
    $video_url = get_post_meta($post->ID, 'work_video', true);
    ?>
    <label for="work_video">Upload Video:</label>
    <input type="text" id="work_video" name="work_video" value="<?php echo esc_attr($video_url); ?>" style="width:80%;" />
    <button id="upload_video_button" class="button">Upload Video</button>
    <?php
}

function enqueue_media_uploader() {
    wp_enqueue_media();
    wp_enqueue_script('work-video-uploader', get_template_directory_uri() . '/js/video-uploader.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');

function save_work_video($post_id) {
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





function init_video_upload() {
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