var audio = document.getElementById('miAudio');
var playButton = document.getElementById('playButton');
var progressBar = document.querySelector('.progress');

playButton.addEventListener('click', function() {
  if (audio.paused) {
    audio.play();
    playButton.classList.add('playing');
  } else {
    audio.pause();
    playButton.classList.remove('playing');
  }
});

audio.addEventListener('timeupdate', function() {
  var progress = (audio.currentTime / audio.duration) * 100;
  progressBar.style.width = progress + '%';
});
