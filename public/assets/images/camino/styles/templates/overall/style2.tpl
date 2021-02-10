<section class="header7 cid-qJuTrd9uzP mbr-fullscreen" id="header7-h" style="background-image: url(uploads/fondos/{$nombrefoto}.{$ext});">
  <div class="mbr-overlay" style="opacity: {$opacidad}; background-color: rgb({$colorvideo});"></div>
  <div class="container">
    <div class="media-container-row">
      <div class="media-content align-right">
        <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-1">
          {if $mostrar_titulo == 1}{$titulo}{else if $mostrar_titulo == 0}{/if}
        </h1>
        <div class="mbr-section-text mbr-white pb-3">
          <p class="mbr-text mbr-fonts-style display-5">
            {if $mostrar_texto == 1}{$texto}{else if $mostrar_texto == 0}{/if}
          </p>
        </div>
      </div>
      <div class="mbr-figure" style="width: {$media_size}%;">{include 'overall/onlinetv.tpl'}</div>
    </div>
  </div>
</section>
