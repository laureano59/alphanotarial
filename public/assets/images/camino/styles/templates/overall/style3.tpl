<section class="cid-qJxKwSjeXd mbr-fullscreen" id="header2-k" style="background-image: url(uploads/fondos/{$nombrefoto}.{$ext});">
  <div class="mbr-overlay" style="opacity: {$opacidad}; background-color: rgb({$colorimage});"></div>
  <div class="container align-center">
    <div class="row justify-content-md-center">
      <div class="mbr-white col-md-10">
        <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">
          {if $mostrar_titulo == 1}{$titulo}{else if $mostrar_titulo == 0}{/if}
        </h1>
        <p class="mbr-text pb-3 mbr-fonts-style display-5">
          {if $mostrar_texto == 1}{$texto}{else if $mostrar_texto == 0}{/if}
        </p>
      </div>
    </div>
  </div>
  <div class="mbr-arrow hidden-sm-down" aria-hidden="true">
    <a href="#next">
      <i class="mbri-down mbr-iconfont"></i>
    </a>
  </div>
</section>
