function volumeToggle(button) {
  const muted = $(".previewVideo").prop("muted");
  $(".previewVideo").prop("muted", !muted);
}