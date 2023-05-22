<?php 
	if(isset($_GET['embed'])) {
		get_header("player");
    $db_name = $wpdb->dbname;
    $db_user = $wpdb->dbuser;
    $db_password = $wpdb->dbpassword;
    $db_host = $wpdb->dbhost;
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }

    $episode = getEpisode($_GET['embed']);
    $season = getSeason($episode->seasonId);

?>
<script>
  
// Add functions here

// togglePlay toggles the playback state of the video.
// If the video playback is paused or ended, the video is played
// otherwise, the video is paused
function togglePlay() {
  if (video.paused || video.ended) {
    video.play();
  } else {
    video.pause();
  }
}

// updatePlayButton updates the playback icon and tooltip
// depending on the playback state
function updatePlayButton() {
  playbackIcons.forEach((icon) => icon.classList.toggle('hidden'));

  if (video.paused) {
    playButton.setAttribute('data-title', 'Play (k)');
  } else {
    playButton.setAttribute('data-title', 'Pause (k)');
  }
}

// formatTime takes a time length in seconds and returns the time in
// minutes and seconds
function formatTime(timeInSeconds) {
  const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8);

  return {
    minutes: result.substr(3, 2),
    seconds: result.substr(6, 2),
  };
}

// initializeVideo sets the video duration, and maximum value of the
// progressBar
function initializeVideo() {
  const videoDuration = Math.round(video.duration);
  seek.setAttribute('max', videoDuration);
  progressBar.setAttribute('max', videoDuration);
  const time = formatTime(videoDuration);
  duration.innerText = `${time.minutes}:${time.seconds}`;
  duration.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`);
}

// updateTimeElapsed indicates how far through the video
// the current playback is by updating the timeElapsed element
function updateTimeElapsed() {
  const time = formatTime(Math.round(video.currentTime));
  timeElapsed.innerText = `${time.minutes}:${time.seconds}`;
  timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`);
}

// updateProgress indicates how far through the video
// the current playback is by updating the progress bar
function updateProgress() {
  seek.value = Math.floor(video.currentTime);
  progressBar.value = Math.floor(video.currentTime);
}

// updateSeekTooltip uses the position of the mouse on the progress bar to
// roughly work out what point in the video the user will skip to if
// the progress bar is clicked at that point
function updateSeekTooltip(event) {
  const skipTo = Math.round(
    (event.offsetX / event.target.clientWidth) *
      parseInt(event.target.getAttribute('max'), 10)
  );
  seek.setAttribute('data-seek', skipTo);
  const t = formatTime(skipTo);
  seekTooltip.textContent = `${t.minutes}:${t.seconds}`;
  const rect = video.getBoundingClientRect();
  seekTooltip.style.left = `${event.pageX - rect.left}px`;
}

// skipAhead jumps to a different point in the video when the progress bar
// is clicked
function skipAhead(event) {
  const skipTo = event.target.dataset.seek
    ? event.target.dataset.seek
    : event.target.value;
  video.currentTime = skipTo;
  progressBar.value = skipTo;
  seek.value = skipTo;
}

// updateVolume updates the video's volume
// and disables the muted state if active
function updateVolume() {
  if (video.muted) {
    video.muted = false;
  }

  video.volume = volume.value;
}

// updateVolumeIcon updates the volume icon so that it correctly reflects
// the volume of the video
function updateVolumeIcon() {
  volumeIcons.forEach((icon) => {
    icon.classList.add('hidden');
  });

  volumeButton.setAttribute('data-title', 'Mute (m)');

  if (video.muted || video.volume === 0) {
    volumeMute.classList.remove('hidden');
    volumeButton.setAttribute('data-title', 'Unmute (m)');
  } else if (video.volume > 0 && video.volume <= 0.5) {
    volumeLow.classList.remove('hidden');
  } else {
    volumeHigh.classList.remove('hidden');
  }
}

// toggleMute mutes or unmutes the video when executed
// When the video is unmuted, the volume is returned to the value
// it was set to before the video was muted
function toggleMute() {
  video.muted = !video.muted;

  if (video.muted) {
    volume.setAttribute('data-volume', volume.value);
    volume.value = 0;
  } else {
    volume.value = volume.dataset.volume;
  }
}

// animatePlayback displays an animation when
// the video is played or paused
function animatePlayback() {
  playbackAnimation.animate(
    [
      {
        opacity: 1,
        transform: 'scale(1)',
      },
      {
        opacity: 0,
        transform: 'scale(1.3)',
      },
    ],
    {
      duration: 500,
    }
  );
}

// toggleFullScreen toggles the full screen state of the video
// If the browser is currently in fullscreen mode,
// then it should exit and vice versa.
function toggleFullScreen() {
  if (document.fullscreenElement) {
    document.exitFullscreen();
  } else if (document.webkitFullscreenElement) {
    // Need this to support Safari
    document.webkitExitFullscreen();
  } else if (videoContainer.webkitRequestFullscreen) {
    // Need this to support Safari
    videoContainer.webkitRequestFullscreen();
  } else {
    videoContainer.requestFullscreen();
  }
}

// updateFullscreenButton changes the icon of the full screen button
// and tooltip to reflect the current full screen state of the video
function updateFullscreenButton() {
  fullscreenIcons.forEach((icon) => icon.classList.toggle('hidden'));

  if (document.fullscreenElement) {
    fullscreenButton.setAttribute('data-title', 'Exit full screen (f)');
  } else {
    fullscreenButton.setAttribute('data-title', 'Full screen (f)');
  }
}

// togglePip toggles Picture-in-Picture mode on the video
async function togglePip() {
  try {
    if (video !== document.pictureInPictureElement) {
      pipButton.disabled = true;
      await video.requestPictureInPicture();
    } else {
      await document.exitPictureInPicture();
    }
  } catch (error) {
    console.error(error);
  } finally {
    pipButton.disabled = false;
  }
}

// hideControls hides the video controls when not in use
// if the video is paused, the controls must remain visible
function hideControls() {
  if (video.paused) {
    return;
  }

  videoControls.classList.add('hide');
}

// showControls displays the video controls
function showControls() {
  videoControls.classList.remove('hide');
}

// keyboardShortcuts executes the relevant functions for
// each supported shortcut key
function keyboardShortcuts(event) {
  const { key } = event;
  switch (key) {
    case 'k':
      togglePlay();
      animatePlayback();
      if (video.paused) {
        showControls();
      } else {
        setTimeout(() => {
          hideControls();
        }, 2000);
      }
      break;
    case 'm':
      toggleMute();
      break;
    case 'f':
      toggleFullScreen();
      break;
    case 'p':
      togglePip();
      break;
  }
}
</script>
   <div class="embed-container">
    <div class="video-container" id="video-container">
      <div class="playback-animation" id="playback-animation">
        <svg class="playback-icons">
          <use class="hidden" href="#play-icon"></use>
          <use href="#pause"></use>
        </svg>
      </div>

      <video controls class="video" id="video" preload="metadata" onloadeddata="initializeVideo()" poster="<?=$season->cover?>">
        <source src="<?=$episode->video?>" type="video/mp4"></source>
        <source src="<?=$episode->video?>" type="video/x-matroska"></source>
      </video>

      <div class="video-controls hidden" id="video-controls">
        <div class="video-progress">
          <progress id="progress-bar" value="0" min="0"></progress>
          <input class="seek" id="seek" value="0" min="0" type="range" step="1">
          <div class="seek-tooltip" id="seek-tooltip">00:00</div>
        </div>

        <div class="bottom-controls">
          <div class="left-controls">
            <button data-title="Play (k)" id="play">
              <svg class="playback-icons">
                <use href="#play-icon"></use>
                <use class="hidden" href="#pause"></use>
              </svg>
            </button>

            <div class="volume-controls">
              <button data-title="Mute (m)" class="volume-button" id="volume-button">
                <svg>
                  <use class="hidden" href="#volume-mute"></use>
                  <use class="hidden" href="#volume-low"></use>
                  <use href="#volume-high"></use>
                </svg>
              </button>

              <input class="volume" id="volume" value="1"
              data-mute="0.5" type="range" max="1" min="0" step="0.01">
            </div>

            <div class="time">
              <time id="time-elapsed">00:00</time>
              <span> / </span>
              <time id="duration">00:00</time>
            </div>
          </div>

          <div class="right-controls">
            <button data-title="PIP (p)" class="pip-button" id="pip-button">
              <svg>
                <use href="#pip"></use>
              </svg>
            </button>
            <button data-title="Full screen (f)" class="fullscreen-button" id="fullscreen-button">
              <svg>
                <use href="#fullscreen"></use>
                <use href="#fullscreen-exit" class="hidden"></use>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <svg style="display: none">
    <defs>
      <symbol id="pause" viewBox="0 0 24 24">
        <path d="M14.016 5.016h3.984v13.969h-3.984v-13.969zM6 18.984v-13.969h3.984v13.969h-3.984z"></path>
      </symbol>

      <symbol id="play-icon" viewBox="0 0 24 24">
        <path d="M8.016 5.016l10.969 6.984-10.969 6.984v-13.969z"></path>
      </symbol>

      <symbol id="volume-high" viewBox="0 0 24 24">
      <path d="M14.016 3.234q3.047 0.656 5.016 3.117t1.969 5.648-1.969 5.648-5.016 3.117v-2.063q2.203-0.656 3.586-2.484t1.383-4.219-1.383-4.219-3.586-2.484v-2.063zM16.5 12q0 2.813-2.484 4.031v-8.063q1.031 0.516 1.758 1.688t0.727 2.344zM3 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6z"></path>
      </symbol>

      <symbol id="volume-low" viewBox="0 0 24 24">
      <path d="M5.016 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6zM18.516 12q0 2.766-2.531 4.031v-8.063q1.031 0.516 1.781 1.711t0.75 2.32z"></path>
      </symbol>

      <symbol id="volume-mute" viewBox="0 0 24 24">
      <path d="M12 3.984v4.219l-2.109-2.109zM4.266 3l16.734 16.734-1.266 1.266-2.063-2.063q-1.547 1.313-3.656 1.828v-2.063q1.172-0.328 2.25-1.172l-4.266-4.266v6.75l-5.016-5.016h-3.984v-6h4.734l-4.734-4.734zM18.984 12q0-2.391-1.383-4.219t-3.586-2.484v-2.063q3.047 0.656 5.016 3.117t1.969 5.648q0 2.203-1.031 4.172l-1.5-1.547q0.516-1.266 0.516-2.625zM16.5 12q0 0.422-0.047 0.609l-2.438-2.438v-2.203q1.031 0.516 1.758 1.688t0.727 2.344z"></path>
      </symbol>

      <symbol id="fullscreen" viewBox="0 0 24 24">
      <path d="M14.016 5.016h4.969v4.969h-1.969v-3h-3v-1.969zM17.016 17.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 9.984v-4.969h4.969v1.969h-3v3h-1.969zM6.984 14.016v3h3v1.969h-4.969v-4.969h1.969z"></path>
      </symbol>

      <symbol id="fullscreen-exit" viewBox="0 0 24 24">
      <path d="M15.984 8.016h3v1.969h-4.969v-4.969h1.969v3zM14.016 18.984v-4.969h4.969v1.969h-3v3h-1.969zM8.016 8.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 15.984v-1.969h4.969v4.969h-1.969v-3h-3z"></path>
      </symbol>

      <symbol id="pip" viewBox="0 0 24 24">
      <path d="M21 19.031v-14.063h-18v14.063h18zM23.016 18.984q0 0.797-0.609 1.406t-1.406 0.609h-18q-0.797 0-1.406-0.609t-0.609-1.406v-14.016q0-0.797 0.609-1.383t1.406-0.586h18q0.797 0 1.406 0.586t0.609 1.383v14.016zM18.984 11.016v6h-7.969v-6h7.969z"></path>
      </symbol>
    </defs>
  </svg>

  <script>

    // Select elements here
  const video = document.getElementById('video');
  const videoControls = document.getElementById('video-controls');
  const playButton = document.getElementById('play');
  const playbackIcons = document.querySelectorAll('.playback-icons use');
  const timeElapsed = document.getElementById('time-elapsed');
  const duration = document.getElementById('duration');
  const progressBar = document.getElementById('progress-bar');
  const seek = document.getElementById('seek');
  const seekTooltip = document.getElementById('seek-tooltip');
  const volumeButton = document.getElementById('volume-button');
  const volumeIcons = document.querySelectorAll('.volume-button use');
  const volumeMute = document.querySelector('use[href="#volume-mute"]');
  const volumeLow = document.querySelector('use[href="#volume-low"]');
  const volumeHigh = document.querySelector('use[href="#volume-high"]');
  const volume = document.getElementById('volume');
  const playbackAnimation = document.getElementById('playback-animation');
  const fullscreenButton = document.getElementById('fullscreen-button');
  const videoContainer = document.getElementById('video-container');
  const fullscreenIcons = fullscreenButton.querySelectorAll('use');
  const pipButton = document.getElementById('pip-button');

const videoWorks = !!document.createElement('video').canPlayType;
if (videoWorks) {
  video.controls = false;
  videoControls.classList.remove('hidden');
}


// Add eventlisteners here
playButton.addEventListener('click', togglePlay);
video.addEventListener('play', updatePlayButton);
video.addEventListener('pause', updatePlayButton);
// video.addEventListener('loadedmetadata', initializeVideo);
video.addEventListener('timeupdate', updateTimeElapsed);
video.addEventListener('timeupdate', updateProgress);
video.addEventListener('volumechange', updateVolumeIcon);
video.addEventListener('click', togglePlay);
video.addEventListener('click', animatePlayback);
video.addEventListener('mouseenter', showControls);
video.addEventListener('mouseleave', hideControls);
videoControls.addEventListener('mouseenter', showControls);
videoControls.addEventListener('mouseleave', hideControls);
seek.addEventListener('mousemove', updateSeekTooltip);
seek.addEventListener('input', skipAhead);
volume.addEventListener('input', updateVolume);
volumeButton.addEventListener('click', toggleMute);
fullscreenButton.addEventListener('click', toggleFullScreen);
videoContainer.addEventListener('fullscreenchange', updateFullscreenButton);
pipButton.addEventListener('click', togglePip);

document.addEventListener('DOMContentLoaded', () => {
  if (!('pictureInPictureEnabled' in document)) {
    pipButton.classList.add('hidden');
  }
});
document.addEventListener('keyup', keyboardShortcuts);

  </script>

<?php die("");} get_header(); ?>

<!-- <div class="AdvancedSearch">
	<div class="container">
		<span><i class="fa fa-search"></i><em>البحث المتقدم</span> </span>
		<form method="get" action="<?php bloginfo('url');?>">
            <input type="text" name="s" id="s" value="<?=the_search_query(); ?>" placeholder="<?=_e('ادخل كلمه البحث','Mekawadaity-Net')?>">
            <select name="category">
            	<option selected disabled value="">اختر القسم</option>
            	<?php
            		$catArgs = array(
            			'taxonomy' => 'category',
            			'hide_empty' => true,
            		);
            		$catArgs = get_categories($catArgs);
            		$catArgs = (is_array($catArgs)) ? $catArgs : array();
        		?>
            	<?php foreach ($catArgs as $cat) { ?>
            		<option value="<?=$cat->term_id?>"><?=$cat->name?></option>
            	<?php } ?>
            </select>
            <select name="year" class="year">
            	<option selected disabled value="">اختر السنه</option>
            	<?php
            		$yearsArgs = array(
            			'taxonomy' => 'year-cat',
            			'hide_empty' => true,
            		);
            		$yearsArgs = get_categories($yearsArgs);
            		$yearsArgs = (is_array($yearsArgs)) ? $yearsArgs : array();
        		?>
            	<?php foreach ($yearsArgs as $year) { ?>
            		<option value="<?=$year->slug?>"><?=$year->name?></option>
            	<?php } ?>
            </select>
            <select name="quality" class="year">
            	<option selected disabled value="">اختر الجوده</option>
            	<?php
            		$qualitiesArgs = array(
            			'taxonomy' => 'quality-cat',
            			'hide_empty' => true,
            		);
            		$qualitiesArgs = get_categories($qualitiesArgs);
            		$qualitiesArgs = (is_array($qualitiesArgs)) ? $qualitiesArgs : array();
        		?>
            	<?php foreach ($qualitiesArgs as $quality) { ?>
            		<option value="<?=$quality->slug?>"><?=$quality->name?></option>
            	<?php } ?>
            </select>
            <button type="submit" id="searchsubmit"><i class="fa fa-search"></i>بحث</button>
        </form>
	</div>
</div> -->

<!--:: Advanced Search Area ::-->
<!-- <div class="container">
	<div class="filterItems">
		<h1>
			<i class="fa fa-clock-o"></i>
			<span>المضاف حديثا</span>
		</h1>
		<ul>
			<li id="lastPosts" class="active"><i class="fa fa-clock-o"></i>المضاف حديثا</li>
			<li id="MostViews"><i class="fa fa-fire"></i>الاكثر مشاهده</li>
			<li id="MostDownload"><i class="fa fa-download"></i>الاكثر تحميلا</li>
		</ul>
		<div class="clr"></div>
	</div>
</div> -->
<script type="text/javascript">
	$(function() {
		$(".filterItems li").click(function() {
			$(this).addClass("active").siblings().removeClass("active");
		});
		$("li#lastPosts").click(function(){
			$("ul.tab-content").html('<div class="loader"></div>');
			$(".filterItems > h1").html('<i class="fa fa-clock-o"></i><span>المضاف حديثا</span>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/last-posts.php",
				data: "",
				type: "POST",
				success: function(RES) {
					$("ul.tab-content").html(RES)
				},
				error: function() {}
			})
		});
		$("li#MostViews").click(function(){
			$("ul.tab-content").html('<div class="loader"></div>');
			$(".filterItems > h1").html('<i class="fa fa-fire"></i><span>الاكثر مشاهده</span>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/most-views.php",
				data: "",
				type: "POST",
				success: function(RES) {
					$("ul.tab-content").html(RES)
				},
				error: function() {}
			})
		});
		$("li#MostDownload").click(function(){
			$("ul.tab-content").html('<div class="loader"></div>');
			$(".filterItems > h1").html('<i class="fa fa-cloud-download"></i><span>الاكثر تحميلا</span>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/most-download.php",
				data: "",
				type: "POST",
				success: function(RES) {
					$("ul.tab-content").html(RES)
				},
				error: function() {}
			})
		});
	})
</script>
<!--: Recent Posts :-->
<section class="posts-section recent-posts" id="recent-posts">
	<?php get_template_part('template', 'recent_posts'); ?>
</section>

<section class="posts-section ended-posts" id="ended-posts">
		
	<?php get_template_part('template', 'ended_posts'); ?>

</section>


<section class="posts-section movies-posts" id="movies-posts-anime">
		
<?php get_template_part('template', 'movie_posts'); ?>

</section>

<section class="posts-section movies-posts" id="movies-posts-cartoon">
		
	
<?php get_template_part('template', 'cartoon_posts'); ?>
</section>

<script>
			$(".showmorebutton").click(function(){
				var section = $(this).attr("for");
				$(this).find("i").attr("class" , "fa fa-spinner");
				var visible = false;
				setTimeout(() => {
					var posters = $("#"+section+" .visiblegroup-2").each(function(){
						if($(this).css("display") == "none"){
							$(this).css("display" , "unset");
							visible = true;
						} else {
							$(this).css("display" , "none");
							visible = false;
						}
					});

					if(visible){
						$(".showmorebutton .more").text("اخفاء");
						$(this).find("i").attr("class" , "fa fa-minus");
					}else{
						$(".showmorebutton .more").text("المزيد");
						$(this).find("i").attr("class" , "fa fa-plus");
					}
				}, 500);
				
				

				
				
				
				
			});
		</script>
<?php get_footer() ?>