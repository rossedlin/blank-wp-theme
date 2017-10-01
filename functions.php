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


/* BEGIN Custom User Contact Info */
function extra_contact_info($info)
{
	$info['facebook']  = 'Facebook';
	$info['twitter']   = 'Twitter';
	$info['linkedin']  = 'LinkedIn';
	$info['instagram'] = 'Instagram';
	$info['github']    = 'GitHub';

	return $info;
}

add_filter('user_contactmethods', 'extra_contact_info');

/**
 * @param WP_REST_Response $response
 * @param \stdClass        $user
 * @param WP_REST_Request  $request
 *
 * @return mixed
 */
function ag_filter_user_json($response, $user, $request)
{
	$response->data['contact'] = [
		'email'      => $user->data->user_email,
		'url'        => $user->data->user_url,
		'googleplus' => $user->googleplus,
		'facebook'   => $user->facebook,
		'twitter'    => $user->twitter,
		'linkedin'   => $user->linkedin,
		'instagram'  => $user->instagram,
		'github'     => $user->github,
	];

	return $response;
}

add_filter('rest_prepare_user', 'ag_filter_user_json', 10, 3);

add_image_size('blog-100x100', 100, 100);