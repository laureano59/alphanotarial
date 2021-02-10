{include 'overall/header.tpl'}
  <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalpredicas.css" type="text/css">
  <link href="styles/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="styles/assets/web/assets/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="styles/js/jquery.jplayer.min.js"></script>
  <script type="text/javascript" src="styles/add-on/jplayer.playlist.min.js"></script>
  <script type="text/javascript">
  //<![CDATA[
  $(document).ready(function(){

  	new jPlayerPlaylist({
  		jPlayer: "#jquery_jplayer_1",
  		cssSelectorAncestor: "#jp_container_1"
  	}, [

      {if isset($audios)}
        {foreach from=$audios item=au}
          {if $i > 0}
            {
        			title:"{$au.descripcion}",
        			mp3:"uploads/audios/{$au.idaudio}.{$au.ext}"
        		},
            {else}
            {
        			title:"{$au.descripcion}",
        			mp3:"uploads/audios/{$au.idaudio}.{$au.ext}"
        		}
          {/if}
          {$i=$i-1}
        {/foreach}
      {/if}
  	], {
  		swfPath: "dist/jplayer",
  		supplied: "oga, mp3",
  		wmode: "window",
  		useStateClassSkin: true,
  		autoBlur: false,
  		smoothPlayBar: true,
  		keyEnabled: true
  	});
  });
  //]]>
  </script>


</head>
<body>
{include 'overall/nav.tpl'}

<section class="header3 cid-qJy5ixHBqy mbr-fullscreen" id="header3-o" style="background-image: url(styles/assets/images/fondopredica.png);">



    <div class="mbr-overlay" style="opacity: 0.3; background-color: rgb(0, 0, 0);">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="mbr-figure" style="width: 70%;">
              <div id="jquery_jplayer_1" class="jp-jplayer"></div>
              <div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
                <div class="jp-type-playlist">
                  <div class="jp-gui jp-interface">
                    <div class="jp-controls">
                      <button class="jp-previous" role="button" tabindex="0">previous</button>
                      <button class="jp-play" role="button" tabindex="0">play</button>
                      <button class="jp-next" role="button" tabindex="0">next</button>
                      <button class="jp-stop" role="button" tabindex="0">stop</button>
                    </div>
                    <div class="jp-progress">
                      <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                      </div>
                    </div>
                    <div class="jp-volume-controls">
                      <button class="jp-mute" role="button" tabindex="0">mute</button>
                      <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                      <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                      </div>
                    </div>
                    <div class="jp-time-holder">
                      <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                      <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                    </div>
                    <div class="jp-toggles">
                      <button class="jp-repeat" role="button" tabindex="0">repeat</button>
                      <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>
                    </div>
                  </div>
                  <div class="jp-playlist">
                    <ul>
                      <li>&nbsp;</li>
                    </ul>
                  </div>
                  <div class="jp-no-solution">
                    <span>Update Required</span>
                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                  </div>
                </div>
              </div>
            </div>

            <div class="media-content">
                <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-1">Prédicas Online</h1>

                <div class="mbr-section-text mbr-white pb-3 ">
                    <p class="mbr-text mbr-fonts-style display-5">
                        Disfruta de la palabra de Dios.
                    </p>
                </div>

            </div>
        </div>
    </div>

</section>

{include 'overall/footer.tpl'}
