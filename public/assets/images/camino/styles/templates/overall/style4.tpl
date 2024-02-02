<section class="header6 cid-qJt6THruDK mbr-fullscreen" data-bg-video="{$video_bacground}" id="header6-8">
  <div class="mbr-overlay" style="opacity: {$opacidad}; background-color: rgb({$colorvideo});"></div>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="mbr-white col-md-10">
        <h1 class="mbr-section-title align-center mbr-bold pb-3 mbr-fonts-style display-1">
          {if $mostrar_titulo == 1}{$titulo}{else if $mostrar_titulo == 0}{/if}
        </h1>
          <p class="mbr-text align-center pb-3 mbr-fonts-style display-5">
            {if $mostrar_texto == 1}{$texto}{else if $mostrar_texto == 0}{/if}
          </p>
      </div>
    </div>
  </div>
</section>
<script src="styles/assets/web/assets/jquery/jquery2.min.js"></script>
<script src="styles/assets/theme/js/script2.js"></script>
<script src="styles/assets/ytplayer/jquery.mb.ytplayer.min.js"></script>
