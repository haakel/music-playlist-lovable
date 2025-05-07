
<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$unique_id = 'music-playlist-' . $playlist_id . '-' . uniqid();
$show_cover = $atts['show_cover'] === 'true';
$theme_class = 'music-playlist-theme-' . sanitize_html_class($atts['theme']);
?>

<div class="music-playlist-container <?php echo esc_attr($theme_class); ?>" id="<?php echo esc_attr($unique_id); ?>" data-playlist-id="<?php echo esc_attr($playlist_id); ?>">
    <div class="music-playlist-player">
        <?php if ($show_cover) : ?>
            <div class="music-playlist-cover">
                <?php 
                $cover_image = '';
                if (!empty($tracks[0]['cover_image'])) {
                    $cover_image = $tracks[0]['cover_image'];
                } elseif (has_post_thumbnail($playlist_id)) {
                    $cover_image = get_the_post_thumbnail_url($playlist_id, 'medium');
                }
                
                if (!empty($cover_image)) : 
                ?>
                    <img src="<?php echo esc_url($cover_image); ?>" alt="<?php echo esc_attr($playlist->post_title); ?>" class="music-playlist-active-cover">
                <?php else : ?>
                    <img src="<?php echo esc_url(MUSIC_PLAYLIST_PLUGIN_URL . 'assets/images/default-cover.png'); ?>" alt="<?php echo esc_attr($playlist->post_title); ?>" class="music-playlist-active-cover">
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="music-playlist-controls">
            <div class="music-playlist-info">
                <div class="music-playlist-track-title"><?php echo esc_html($tracks[0]['title']); ?></div>
                <div class="music-playlist-track-artist"><?php echo esc_html($tracks[0]['artist']); ?></div>
            </div>
            
            <div class="music-playlist-progress">
                <div class="music-playlist-time-current">0:00</div>
                <div class="music-playlist-progress-bar">
                    <div class="music-playlist-progress-played"></div>
                </div>
                <div class="music-playlist-time-total">0:00</div>
            </div>
            
            <div class="music-playlist-buttons">
                <button class="music-playlist-prev" aria-label="<?php echo esc_attr__('Previous track', 'music-playlist'); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 20L9 12L19 4V20Z" fill="currentColor"/>
                        <path d="M5 4H7V20H5V4Z" fill="currentColor"/>
                    </svg>
                </button>
                
                <button class="music-playlist-play" aria-label="<?php echo esc_attr__('Play/Pause', 'music-playlist'); ?>">
                    <svg class="music-playlist-icon-play" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 5V19L19 12L8 5Z" fill="currentColor"/>
                    </svg>
                    <svg class="music-playlist-icon-pause hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 4H10V20H6V4Z" fill="currentColor"/>
                        <path d="M14 4H18V20H14V4Z" fill="currentColor"/>
                    </svg>
                </button>
                
                <button class="music-playlist-next" aria-label="<?php echo esc_attr__('Next track', 'music-playlist'); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 4L15 12L5 20V4Z" fill="currentColor"/>
                        <path d="M19 4H17V20H19V4Z" fill="currentColor"/>
                    </svg>
                </button>
                
                <div class="music-playlist-volume">
                    <button class="music-playlist-volume-toggle" aria-label="<?php echo esc_attr__('Mute/Unmute', 'music-playlist'); ?>">
                        <svg class="music-playlist-icon-volume" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 10V14H7L12 19V5L7 10H3Z" fill="currentColor"/>
                            <path d="M16.5 12C16.5 10.23 15.48 8.71 14 7.97V16.02C15.48 15.29 16.5 13.77 16.5 12Z" fill="currentColor"/>
                            <path d="M14 3.23V5.29C16.89 6.15 19 8.83 19 12C19 15.17 16.89 17.85 14 18.71V20.77C18.01 19.86 21 16.28 21 12C21 7.72 18.01 4.14 14 3.23Z" fill="currentColor"/>
                        </svg>
                        <svg class="music-playlist-icon-mute hidden" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 10V14H7L12 19V5L7 10H3Z" fill="currentColor"/>
                            <path d="M19 12L21 14L19 16L17 14L15 16L13 14L15 12L13 10L15 8L17 10L19 8L21 10L19 12Z" fill="currentColor"/>
                        </svg>
                    </button>
                    
                    <div class="music-playlist-volume-slider">
                        <div class="music-playlist-volume-progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="music-playlist-playlist">
        <h3 class="music-playlist-playlist-title"><?php echo esc_html($playlist->post_title); ?></h3>
        <ul class="music-playlist-tracks">
            <?php foreach ($tracks as $index => $track) : ?>
                <li class="music-playlist-track <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo esc_attr($index); ?>" data-id="<?php echo esc_attr($track['id']); ?>">
                    <?php if (!empty($track['cover_image'])) : ?>
                        <img src="<?php echo esc_url($track['cover_image']); ?>" alt="<?php echo esc_attr($track['title']); ?>" class="music-playlist-track-cover">
                    <?php else : ?>
                        <img src="<?php echo esc_url(MUSIC_PLAYLIST_PLUGIN_URL . 'assets/images/default-cover.png'); ?>" alt="<?php echo esc_attr($track['title']); ?>" class="music-playlist-track-cover">
                    <?php endif; ?>
                    
                    <div class="music-playlist-track-info">
                        <div class="music-playlist-track-title"><?php echo esc_html($track['title']); ?></div>
                        <div class="music-playlist-track-artist"><?php echo esc_html($track['artist']); ?></div>
                    </div>
                    
                    <div class="music-playlist-track-duration">
                        <?php 
                        if (!empty($track['duration'])) {
                            $minutes = floor($track['duration'] / 60);
                            $seconds = $track['duration'] % 60;
                            echo esc_html(sprintf('%d:%02d', $minutes, $seconds));
                        } else {
                            echo '0:00';
                        }
                        ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <audio id="<?php echo esc_attr($unique_id); ?>-audio" class="music-playlist-audio-element" preload="auto">
        <source src="<?php echo esc_url($tracks[0]['file_url']); ?>" type="audio/mpeg">
        <?php echo esc_html__('Your browser does not support the audio element.', 'music-playlist'); ?>
    </audio>
    
    <script type="text/javascript">
        // Tracks data for the player
        window.musicPlaylistData = window.musicPlaylistData || {};
        window.musicPlaylistData['<?php echo esc_js($unique_id); ?>'] = <?php echo json_encode($tracks); ?>;
    </script>
</div>
