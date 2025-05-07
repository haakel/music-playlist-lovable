
<?php

namespace MusicPlaylist\Database;

/**
 * Database setup and management
 */
class Setup
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // Nothing to initialize currently
    }
    
    /**
     * Create database tables
     *
     * @return void
     */
    public static function createTables()
    {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Create tracks table
        $table_name = $wpdb->prefix . 'music_playlist_tracks';
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            playlist_id mediumint(9) NOT NULL,
            title varchar(255) NOT NULL,
            artist varchar(255) NOT NULL,
            file_url varchar(255) NOT NULL,
            cover_image varchar(255),
            duration int(11),
            position int(11) NOT NULL DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * Get tracks for a specific playlist
     *
     * @param int $playlist_id
     * @return array
     */
    public static function getTracks($playlist_id)
    {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'music_playlist_tracks';
        
        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $table_name WHERE playlist_id = %d ORDER BY position ASC",
                $playlist_id
            ),
            ARRAY_A
        );
    }
    
    /**
     * Add a track to a playlist
     *
     * @param array $track_data
     * @return int|false
     */
    public static function addTrack($track_data)
    {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'music_playlist_tracks';
        
        return $wpdb->insert($table_name, $track_data);
    }
    
    /**
     * Update a track
     *
     * @param int $track_id
     * @param array $track_data
     * @return int|false
     */
    public static function updateTrack($track_id, $track_data)
    {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'music_playlist_tracks';
        
        return $wpdb->update(
            $table_name,
            $track_data,
            ['id' => $track_id]
        );
    }
    
    /**
     * Delete a track
     *
     * @param int $track_id
     * @return int|false
     */
    public static function deleteTrack($track_id)
    {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'music_playlist_tracks';
        
        return $wpdb->delete(
            $table_name,
            ['id' => $track_id]
        );
    }
}
