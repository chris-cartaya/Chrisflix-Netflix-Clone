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
  setStartTime(videoID, username);
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
    setFinished(videoID, username);
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

// When video is finished playing, makes AJAX request to update finished to 1 
// (true) in progress table in database
function setFinished(videoID, username) {
  $.post("ajax/setFinished.php", 
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

// Gets progress time from database of where user left off in the video and 
// resume video from that time
function setStartTime(videoID, username) {
  $.post("ajax/getProgress.php", 
    { 
      videoID: videoID, 
      username: username
    }, 
    function(data) {
      if (isNaN(data)) {
        alert(data);
        return;
      }

      // When the video can play, set video current time to data from database
      $("video").on("canplay", function() {
        this.currentTime = data;
        $("video").off("canplay");
      });

    }
  );
}

// Restarts the video from the beginning and fades out the replay button
function restartVideo() {
  $("video")[0].currentTime = 0;
  $("video")[0].play();
  $(".upNext").fadeOut();
}

// Plays the video which is passed into the function
function watchVideo(videoID) {
  window.location.href = `watch.php?id=${videoID}`;
}

// Displays the upNext overlay when video is over
function showUpNext() {
  $(".upNext").fadeIn();
}