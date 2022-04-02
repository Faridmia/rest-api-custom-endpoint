<?php
/**
 * Plugin Name: Custom Api
 * Description: A tutorial plugin for rest api info
 * Plugin URI: https://farid.me
 * Author: Farid Mia
 * Author URI: https://farid.me
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function wl_posts() {
    $args = [
        'numberposts' => 99999,
        'post_type'   => 'post'
    ];

    $posts = get_posts($args);

    $data = [];

    $i = 0;

    foreach ($posts as $post) {
        
        $data[$i]['id']               = $post->ID;
        $data[$i]['title']            = $post->post_title;
        $data[$i]['content']          = $post->post_content;
        $data[$i]['slug']             = $post->post_name;
        $data[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID,'thumbnail');
        $data[$i]['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID,'medium');
        $data[$i]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID,'large');

        $i++;
    }

   return $data;
}

function wl_posts_two( $slug ) {
   // return $slug['slug'];

   $args = [
    'name' => $slug['slug'],
    'post_type'   => 'post'
    ];

    $post = get_posts($args);

    $data['id']               = $post[0]->ID;
    $data['title']            = $post[0]->post_title;
    $data['content']          = $post[0]->post_content;
    $data['slug']             = $post[0]->post_name;
    $data['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post[0]->ID,'thumbnail');
    $data['featured_image']['medium'] = get_the_post_thumbnail_url($post[0]->ID,'medium');
    $data['featured_image']['large'] = get_the_post_thumbnail_url($post[0]->ID,'large');

    return $data;

}

add_action('rest_api_init',function(){

    register_rest_route('classyaddons/v1','posts',[
        'method' => 'GET',
        'callback' => 'wl_posts',
    ]);

    register_rest_route('classyaddons/v1','posts/(?P<slug>[a-zA-Z0-9-]+)',[
        'method' => 'GET',
        'callback' => 'wl_posts_two',
    ]);
});



