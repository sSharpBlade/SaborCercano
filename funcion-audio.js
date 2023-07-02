var audio = document.getElementById('miAudio');
var playButton = document.getElementById('playButton');
var progressBar = document.querySelector('.progress-bar');
var progress = document.querySelector('.progress');
var isPlaying = false;

playButton.addEventListener('click', function() {
  if (audio.paused) {
    audio.play();
    playButton.classList.add('playing');
    playButton.style.backgroundImage = 'url(img/player-pause.png)'; // Ruta de la imagen de pausa
    isPlaying = true;
  } else {
    audio.pause();
    playButton.classList.remove('playing');
    playButton.style.backgroundImage = 'url(img/player-play.png)'; // Ruta de la imagen de reproducción
    isPlaying = false;
  }
});