(function() {
	var e = document.createElement('script'); e.async = true;
	e.src = document.location.protocol + '//api.dmcdn.net/all.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(e, s);
}());

// This function init the player once the SDK is loaded
window.dmAsyncInit = function()
{
	var player = DM.player("player", {video: videoID, width: vWidth, height: vHeight});
	player.addEventListener("apiready", function(e)
	{
		e.target.pause();
	});
	
	player.addEventListener("play", function(e)
	{
		document.getElementById('clickforce_ad').style.display='none';
	});
	player.addEventListener("pause", function(e)
	{
		document.getElementById('clickforce_ad').style.display='block';
	});
	player.addEventListener("ended", function(e)
	{
		document.getElementById('clickforce_ad').style.display='block';
	});
};
