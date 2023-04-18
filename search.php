<?php
/*
Plugin Name: Search slug
Description: Search slug
Version: 0.1
Requires PHP: 7.4
Text Domain: search-slug
*/

/**
 * @param $search
 * @param $query
 *
 * @return mixed|string|void
 */
function search_slug($search, $query)
{
    global $wpdb;

    if (false === empty($search) &&
        true === is_admin() &&
        true === isset($query->query_vars['s']) &&
        true === str_starts_with($query->query_vars['s'], 'slug:')) {
        $slug_name = str_replace('slug:', '', $query->query_vars['s']);

        if (true === empty($slug_name)) {
            return $search;
        }

        $slug_name = ' \'%' . $slug_name . '%\'';
        $search    = $wpdb->prepare(
            " AND {$wpdb->posts}.post_name LIKE {$slug_name}"
        );
    }

    return $search;
}

add_filter('posts_search', 'search_slug', 500, 2);
