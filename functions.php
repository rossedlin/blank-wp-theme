<?php
/**
 * Created by PhpStorm.
 *
 * @author Ross Edlin <contact@rossedlin.com>
 *
 * Date: 20/09/2017
 * Time: 16:40
 */

add_theme_support('post-thumbnails');

function ag_filter_post_json($response, $post, $context)
{
	/**
	 * Author
	 */
	$response->data['author_meta'] = [
		'id'           => get_the_author_meta('id', $post->author),
		'display_name' => get_the_author_meta('display_name', $post->author),
	];

	/**
	 * Tags
	 */
	$tags                        = wp_get_post_tags($post->ID);
	$response->data['tag_names'] = [];

	foreach ($tags as $tag)
	{
		$response->data['tag_names'][] = $tag->name;
		$response->data['tag_slugs'][] = $tag->slug;
	}

	return $response;
}

add_filter('rest_prepare_post', 'ag_filter_post_json', 10, 3);