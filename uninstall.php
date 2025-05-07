
<?php
/**
 * Uninstall Music Playlist Plugin
 */

// Exit if accessed directly
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options
delete_option('music_playlist_settings');

// Delete custom post type posts
$playlists = get_posts([
    'post_type' => 'music_playlist',
    'numberposts' => -1,
    'fields' => 'ids',
]);

if ($playlists) {
    foreach ($playlists as $playlist) {
        wp_delete_post($playlist, true);
    }
}

// Drop custom database table if exists
global $wpdb;
$table_name = $wpdb->prefix . 'music_playlist_tracks';

if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name) {
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
