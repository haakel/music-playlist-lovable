<?php
/**
 * Plugin Name: Music Playlist
 * Plugin URI: https://example.com/plugins/music-playlist
 * Description: A lightweight WordPress Music Playlist plugin
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Text Domain: music-playlist
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('MUSIC_PLAYLIST_VERSION', '1.0.0');
define('MUSIC_PLAYLIST_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MUSIC_PLAYLIST_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MUSIC_PLAYLIST_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Autoload classes
spl_autoload_register(function ($class_name) {
    // Check if the class belongs to our plugin namespace
    if (strpos($class_name, 'MusicPlaylist\\') === 0) {
        // Convert namespace to file path
        $class_file = str_replace('MusicPlaylist\\', '', $class_name);
        $class_file = str_replace('\\', DIRECTORY_SEPARATOR, $class_file);
        $class_file = MUSIC_PLAYLIST_PLUGIN_DIR . 'classes' . DIRECTORY_SEPARATOR . $class_file . '.php';
        
        // Include the file if it exists
        if (file_exists($class_file)) {
            require_once $class_file;
        }
    }
});

// Initialize the plugin
if (class_exists('MusicPlaylist\\Core')) {
    MusicPlaylist\Core::getInstance();
}