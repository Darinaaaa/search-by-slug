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
        $search_slug = ' \'%' . str_replace('slug:', '', $query->query_vars['s']) . '%\'';
        $search      = $wpdb->prepare(
            " AND {$wpdb->posts}.post_name LIKE {$search_slug}"
        );
    }

    return $search;
}

add_filter('posts_search', 'search_slug', 500, 2);
