
<?php

namespace MusicPlaylist;

/**
 * Main plugin class using Singleton pattern
 */
class Core
{
    /**
     * Plugin instance
     *
     * @var Core
     */
    private static $instance = null;
    
    /**
     * Admin instance
     *
     * @var Admin\Admin
     */
    private $admin;
    
    /**
     * Front instance
     *
     * @var Frontend\Frontend
     */
    private $frontend;

    /**
     * Get plugin instance
     *
     * @return Core
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
        $this->init();
        $this->registerHooks();
    }
    
    /**
     * Initialize plugin components
     *
     * @return void
     */
    private function init()
    {
        // Initialize database
        new Database\Setup();
        
        // Initialize admin
        if (is_admin()) {
            $this->admin = new Admin\Admin();
        }
        
        // Initialize frontend
        $this->frontend = new Frontend\Frontend();
    }
    
    /**
     * Register core WordPress hooks
     *
     * @return void
     */
    private function registerHooks()
    {
        // Register activation hook
        register_activation_hook(MUSIC_PLAYLIST_PLUGIN_BASENAME, [$this, 'activate']);
        
        // Register deactivation hook
        register_deactivation_hook(MUSIC_PLAYLIST_PLUGIN_BASENAME, [$this, 'deactivate']);
        
        // Register init hook
        add_action('init', [$this, 'registerPostTypes']);
    }
    
    /**
     * Plugin activation
     *
     * @return void
     */
    public function activate()
    {
        // Create database tables
        Database\Setup::createTables();
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    
    /**
     * Plugin deactivation
     *
     * @return void
     */
    public function deactivate()
    {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    
    /**
     * Register custom post types
     *
     * @return void
     */
    public function registerPostTypes()
    {
        // Register Playlist post type
        register_post_type('music_playlist', [
            'labels' => [
                'name' => __('Playlists', 'music-playlist'),
                'singular_name' => __('Playlist', 'music-playlist'),
                'add_new' => __('Add New', 'music-playlist'),
                'add_new_item' => __('Add New Playlist', 'music-playlist'),
                'edit_item' => __('Edit Playlist', 'music-playlist'),
                'new_item' => __('New Playlist', 'music-playlist'),
                'view_item' => __('View Playlist', 'music-playlist'),
                'search_items' => __('Search Playlists', 'music-playlist'),
                'not_found' => __('No playlists found', 'music-playlist'),
                'not_found_in_trash' => __('No playlists found in Trash', 'music-playlist'),
            ],
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-playlist-audio',
            'supports' => ['title', 'thumbnail', 'excerpt'],
            'rewrite' => ['slug' => 'playlist'],
            'show_in_rest' => true,
        ]);
    }
}
