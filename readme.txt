
=== Music Playlist ===
Contributors: yourname
Tags: music, audio, playlist, player, mp3
Requires at least: 5.0
Tested up to: 6.2
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A lightweight WordPress Music Playlist plugin with an elegant player and easy playlist management.

== Description ==

Music Playlist is a lightweight yet powerful plugin that allows you to create and manage beautiful music playlists on your WordPress site. With an elegant player interface and easy-to-use admin controls, you can showcase your music collections in style.

= Features =
* Create multiple playlists
* Add unlimited tracks to each playlist
* Drag and drop track reordering
* Customizable player themes
* Responsive design for all devices
* Simple shortcode integration

= Usage =
1. Create a new playlist from the Music Playlist menu in your admin panel
2. Add tracks to your playlist with title, artist, audio file and optional cover image
3. Insert the playlist on any page or post using the shortcode: `[music_playlist id="123"]`

= Shortcode Options =
* `id`: Playlist ID (required)
* `theme`: Player theme - "default", "dark", or "minimal" (optional, default: "default")
* `show_cover`: Whether to show the cover image - "true" or "false" (optional, default: "true")

Example: `[music_playlist id="123" theme="dark" show_cover="true"]`

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/music-playlist` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Music Playlist menu to create playlists and add tracks
4. Use the shortcode `[music_playlist id="123"]` to display your playlist on any page or post

== Frequently Asked Questions ==

= What audio formats are supported? =

The plugin supports all audio formats that are supported by the HTML5 audio element, including MP3, WAV, and OGG.

= Can I customize the player appearance? =

Yes, you can choose from different themes using the shortcode parameter `theme`. Available themes are "default", "dark", and "minimal".

= Is the player mobile-friendly? =

Yes, the player is fully responsive and works well on all devices, including mobile phones and tablets.

== Screenshots ==

1. Frontend player with default theme
2. Admin playlist management interface
3. Track management screen

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release of the Music Playlist plugin.
