var audio = document.getElementById('miAudio');
var playButton = document.getElementById('playButton');
var progressBar = document.querySelector('.progress-bar');
var progress = document.querySelector('.progress');

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
  var progressPercentage = (audio.currentTime / audio.duration) * 100;
  progress.style.width = progressPercentage + '%';
});

progressBar.addEventListener('click', function(event) {
  var progressBarWidth = progressBar.offsetWidth;
  var clickX = event.clientX - progressBar.getBoundingClientRect().left;
  var duration = audio.duration;
  
  var currentTime = (clickX / progressBarWidth) * duration;
  audio.currentTime = currentTime;
});
