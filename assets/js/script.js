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