<?php

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