function volumeToggle(button) {
  const muted = $(".previewVideo").prop("muted");
  $(".previewVideo").prop("muted", !muted);

  // Remove mute icon and add volume-up icon
  $(button).find("i").toggleClass("fa-volume-xmark");
  $(button).find("i").toggleClass("fa-volume-high");
}

// When preview video finishes playing, display the image
function previewEnded() {
  $(".previewVideo").toggle();  // Hide video
  $(".previewImage").toggle();  // Show image
}

// Used to go back one page
function goBack() {
  window.history.back();
}

// Show/hide video title and back button on video player
function startHideTimer() {
  let timeout = null;
  
  $(document).on("mousemove", function() {
    clearTimeout(timeout);
    $(".watchNav").fadeIn();

    timeout = setTimeout(function() {
      $(".watchNav").fadeOut();
    }, 2000);
  });
}

// Initializes the video. Does any set up we want to do when the page loads.
// Takes in videoID and the user logged in to keep track of video progress
function initVideo(videoID, username) {
  startHideTimer();
  updateProgressTimer(videoID, username);  
}

function updateProgressTimer(videoID, username) {
  addDuration(videoID, username);

  let timer;

  // Keeps track of each time the video is played.
  $("video").on("playing", function(event) {
    window.clearInterval(timer);
    timer = window.setInterval(function() {
      updateProgress(videoID, username, event.target.currentTime);
    }, 3000);
  })
  .on("ended", function() {
    window.clearInterval(timer);
  })
}

// Makes AJAX request to add duration to progress table in database
function addDuration(videoID, username) {
  $.post("ajax/addDuration.php", 
    { 
      videoID: videoID, 
      username: username
    }, 
    function(data) {
      if (data !== null && data !== "") {
        alert(data);
      }
    }
  );
}

// Makes AJAX request to update duration to progress table in database
function updateProgress(videoID, username, progress) {
  $.post("ajax/updateDuration.php", 
    { 
      videoID: videoID, 
      username: username,
      progress: progress
    }, 
    function(data) {
      if (data !== null && data !== "") {
        alert(data);
      }
    }
  );
}