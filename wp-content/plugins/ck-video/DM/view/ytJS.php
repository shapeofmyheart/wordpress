
var tag = document.createElement('script');
tag.src = "//www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
	  events: {
		'onReady': onPlayerReady,
		'onStateChange': onPlayerStateChange
	  }
	});
}

function onPlayerReady(event) {
	event.target.pauseVideo();
	document.getElementById('clickforce_ad').style.display='block';
}

function onPlayerStateChange(event) {
	if (event.data == YT.PlayerState.PAUSED) {
	  document.getElementById('clickforce_ad').style.display='block';
	}
	if (event.data == YT.PlayerState.ENDED) {
	  document.getElementById('clickforce_ad').style.display='block';
	}
	if (event.data == YT.PlayerState.PLAYING) {
	  document.getElementById('clickforce_ad').style.display='NONE';
	}
}
