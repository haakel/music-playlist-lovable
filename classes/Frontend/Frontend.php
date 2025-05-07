
<?php

namespace MusicPlaylist\Frontend;

/**
 * Frontend functionality
 */
class Frontend
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Register shortcode
        add_shortcode('music_playlist', [$this, 'playlistShortcode']);
        
        // Enqueue frontend assets
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }
    
    /**
     * Enqueue frontend assets
     *
     * @return void
     */
    public function enqueueAssets()
    {
        // Only enqueue assets when the shortcode is used
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'music_playlist')) {
            wp_enqueue_style(
                'music-playlist-frontend',
                MUSIC_PLAYLIST_PLUGIN_URL . 'assets/css/frontend.css',
                [],
                MUSIC_PLAYLIST_VERSION
            );
            
            wp_enqueue_script(
                'music-playlist-frontend',
                MUSIC_PLAYLIST_PLUGIN_URL . 'assets/js/frontend.js',
                ['jquery'],
                MUSIC_PLAYLIST_VERSION,
                true
            );
        }
    }
    
    /**
     * Playlist shortcode callback
     *
     * @param array $atts
     * @return string
     */
    public function playlistShortcode($atts)
    {
        $atts = shortcode_atts([
            'id' => 0,
            'theme' => 'default',
            'show_cover' => 'true',
        ], $atts);
        
        $playlist_id = intval($atts['id']);
        
        if (!$playlist_id) {
            return '<p>' . __('Playlist ID is required', 'music-playlist') . '</p>';
        }
        
        // Check if playlist exists
        $playlist = get_post($playlist_id);
        
        if (!$playlist || $playlist->post_type !== 'music_playlist') {
            return '<p>' . __('Playlist not found', 'music-playlist') . '</p>';
        }
        
        // Get tracks
        $tracks = \MusicPlaylist\Database\Setup::getTracks($playlist_id);
        
        if (empty($tracks)) {
            return '<p>' . __('No tracks in this playlist', 'music-playlist') . '</p>';
        }
        
        // Start output buffering
        ob_start();
        
        // Include template
        include MUSIC_PLAYLIST_PLUGIN_DIR . 'templates/frontend/playlist.php';
        
        // Return the buffered content
        return ob_get_clean();
    }
}
