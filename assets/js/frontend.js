document.addEventListener("DOMContentLoaded", function () {
  "use strict";

  // Find all music playlist containers
  const playlistContainers = document.querySelectorAll(
    ".music-playlist-container"
  );

  // Initialize each playlist
  playlistContainers.forEach(function (container) {
    const playerId = container.id;

    // Get the elements
    const audioElement = document.getElementById(`${playerId}-audio`);
    const playButton = container.querySelector(".music-playlist-play");
    const prevButton = container.querySelector(".music-playlist-prev");
    const nextButton = container.querySelector(".music-playlist-next");
    const progressBar = container.querySelector(".music-playlist-progress-bar");
    const progress = container.querySelector(".music-playlist-progress-played");
    const currentTimeDisplay = container.querySelector(
      ".music-playlist-time-current"
    );
    const totalTimeDisplay = container.querySelector(
      ".music-playlist-time-total"
    );
    const tracks = container.querySelectorAll(".music-playlist-track");
    const volumeToggle = container.querySelector(
      ".music-playlist-volume-toggle"
    );
    const volumeSlider = container.querySelector(
      ".music-playlist-volume-slider"
    );
    const volumeProgress = container.querySelector(
      ".music-playlist-volume-progress"
    );
    const playIcon = container.querySelector(".music-playlist-icon-play");
    const pauseIcon = container.querySelector(".music-playlist-icon-pause");
    const volumeIcon = container.querySelector(".music-playlist-icon-volume");
    const muteIcon = container.querySelector(".music-playlist-icon-mute");

    // Get the tracks data from the global variable
    const tracksData = window.musicPlaylistData[playerId] || [];

    // Current track index
    let currentTrackIndex = 0;

    // Set volume to 80% by default
    audioElement.volume = 0.8;
    updateVolumeProgress();

    // Play/pause button
    playButton.addEventListener("click", function () {
      if (audioElement.paused) {
        audioElement.play();
      } else {
        audioElement.pause();
      }
    });

    // Previous button
    prevButton.addEventListener("click", function () {
      if (currentTrackIndex > 0) {
        loadTrack(currentTrackIndex - 1);
        audioElement.play();
      } else {
        // Loop back to last track
        loadTrack(tracks.length - 1);
        audioElement.play();
      }
    });

    // Next button
    nextButton.addEventListener("click", function () {
      if (currentTrackIndex < tracks.length - 1) {
        loadTrack(currentTrackIndex + 1);
        audioElement.play();
      } else {
        // Loop back to first track
        loadTrack(0);
        audioElement.play();
      }
    });

    // Progress bar click
    progressBar.addEventListener("click", function (e) {
      const rect = progressBar.getBoundingClientRect();
      const pos = (e.clientX - rect.left) / rect.width;
      audioElement.currentTime = pos * audioElement.duration;
    });

    // Volume toggle
    volumeToggle.addEventListener("click", function () {
      if (audioElement.muted) {
        audioElement.muted = false;
        volumeIcon.classList.remove("hidden");
        muteIcon.classList.add("hidden");
      } else {
        audioElement.muted = true;
        volumeIcon.classList.add("hidden");
        muteIcon.classList.remove("hidden");
      }
    });

    // Volume slider click
    volumeSlider.addEventListener("click", function (e) {
      const rect = volumeSlider.getBoundingClientRect();
      const pos = (e.clientX - rect.left) / rect.width;
      audioElement.volume = Math.max(0, Math.min(1, pos));
      updateVolumeProgress();

      // Unmute if muted
      if (audioElement.muted) {
        audioElement.muted = false;
        volumeIcon.classList.remove("hidden");
        muteIcon.classList.add("hidden");
      }
    });

    // Track click
    tracks.forEach(function (track, index) {
      track.addEventListener("click", function () {
        loadTrack(index);
        audioElement.play();
      });
    });

    // Audio events
    audioElement.addEventListener("play", function () {
      playIcon.classList.add("hidden");
      pauseIcon.classList.remove("hidden");
    });

    audioElement.addEventListener("pause", function () {
      playIcon.classList.remove("hidden");
      pauseIcon.classList.add("hidden");
    });

    audioElement.addEventListener("timeupdate", function () {
      const currentTime = audioElement.currentTime;
      const duration = audioElement.duration || 0;
      const progressPercent = (currentTime / duration) * 100;

      // Update progress bar
      progress.style.width = `${progressPercent}%`;

      // Update time displays
      currentTimeDisplay.textContent = formatTime(currentTime);
      totalTimeDisplay.textContent = formatTime(duration);
    });

    audioElement.addEventListener("ended", function () {
      // Play next track if available
      if (currentTrackIndex < tracks.length - 1) {
        loadTrack(currentTrackIndex + 1);
        audioElement.play();
      } else {
        // Back to first track (option to loop)
        loadTrack(0);
        audioElement.play();
      }
    });

    // Load a track by index
    function loadTrack(index) {
      // Check if index is valid
      if (index < 0 || index >= tracks.length) {
        return false;
      }

      // Update current track index
      currentTrackIndex = index;

      // Get track data
      const track = tracksData[index];

      // Update audio source
      audioElement.src = track.file_url;
      audioElement.load();

      // Update track info
      const titleElement = container.querySelector(
        ".music-playlist-player .music-playlist-track-title"
      );
      const artistElement = container.querySelector(
        ".music-playlist-player .music-playlist-track-artist"
      );
      const coverElement = container.querySelector(".music-playlist-cover img");

      if (titleElement) titleElement.textContent = track.title;
      if (artistElement) artistElement.textContent = track.artist;

      // Update cover image if available
      if (coverElement) {
        if (track.cover_image) {
          coverElement.src = track.cover_image;
        } else {
          // Set default cover
          coverElement.src =
            "../wp-content/plugins/music-playlist/assets/images/default-cover.png";
        }
      }

      // Reset progress
      progress.style.width = "0";
      currentTimeDisplay.textContent = "0:00";

      // Update active track in playlist
      tracks.forEach(function (trackElement, i) {
        if (i === index) {
          trackElement.classList.add("active");
        } else {
          trackElement.classList.remove("active");
        }
      });

      return true;
    }

    // Helper function to format time
    function formatTime(seconds) {
      seconds = Math.floor(seconds || 0);
      const minutes = Math.floor(seconds / 60);
      seconds = seconds % 60;
      return `${minutes}:${seconds < 10 ? "0" + seconds : seconds}`;
    }

    // Update volume progress bar
    function updateVolumeProgress() {
      volumeProgress.style.width = `${audioElement.volume * 100}%`;
    }
  });
});
