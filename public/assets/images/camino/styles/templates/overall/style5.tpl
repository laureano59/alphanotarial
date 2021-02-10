<br>

<section class="carousel slide cid-qJvce3assp" data-interval="false" id="slider1-j">
  <div class="full-screen">
    <div class="mbr-slider slide carousel" data-pause="true" data-keyboard="false" data-ride="carousel" data-interval="4000">
      <ol class="carousel-indicators">
        {if isset($slide)}
          {foreach from=$slide item=sl}
            {if $i==0}
              <li data-app-prevent-settings="" data-target="#slider1-j" class=" active" data-slide-to="{$i}"></li>
              {else if $i < $j}
              <li data-app-prevent-settings="" data-target="#slider1-j" data-slide-to="{$i}"></li>
            {else}
              <li data-app-prevent-settings="" data-target="#slider1-j"  data-slide-to="{$i}"></li>
            {/if}
            {$i=$i+1}
          {/foreach}
        {/if}
      </ol>

      <div class="carousel-inner" role="listbox">
        {if isset($slide)}{$i=0}
          {foreach from=$slide item=sl}
            {if $i==0}
              {if $sl.video == ''}
                <div class="carousel-item slider-fullscreen-image active" data-bg-video-slide="false" style="background-image: url(uploads/slides/{$sl.id}.{$sl.ext});">
                  <div class="container container-slide">
                    <div class="image_wrapper">
                      <div class="mbr-overlay" style="opacity: {$sl.opacidad}; background-color: rgb({$sl.backgroundcolor});"></div>
                        <img src="uploads/slides/{$sl.id}.{$sl.ext}">
                      <div class="carousel-caption justify-content-center">
                        <div class="col-10 align-center">
                          <h2 class="mbr-fonts-style display-1">{$sl.titulo_slide}</h2>
                          <p class="lead mbr-text mbr-fonts-style display-5">{$sl.texto_slide}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              {else}
                <div class="carousel-item slider-fullscreen-image active" data-bg-video-slide="{$sl.video}">
                  <div class="mbr-overlay" style="opacity: {$sl.opacidad}; background-color: rgb({$sl.backgroundcolor});"></div>
                  <div class="container container-slide">
                    <div class="image_wrapper">
                      <img src="uploads/slides/{$sl.id}.{$sl.ext}" style="opacity: 0;">
                      <div class="carousel-caption justify-content-center">
                        <div class="col-10 align-left">
                          <h2 class="mbr-fonts-style display-1">{$sl.titulo_slide}</h2>
                          <p class="lead mbr-text mbr-fonts-style display-5">{$sl.texto_slide}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              {/if}
            {else}
              {if $sl.video == ''}
                <div class="carousel-item slider-fullscreen-image" data-bg-video-slide="false" style="background-image: url(uploads/slides/{$sl.id}.{$sl.ext});">
                  <div class="container container-slide">
                    <div class="image_wrapper">
                      <div class="mbr-overlay" style="opacity: {$sl.opacidad}; background-color: rgb({$sl.backgroundcolor});"></div>
                      <img src="uploads/slides/{$sl.id}.{$sl.ext}">
                      <div class="carousel-caption justify-content-center">
                        <div class="col-10 align-right">
                          <h2 class="mbr-fonts-style display-1">{$sl.titulo_slide}</h2>
                          <p class="lead mbr-text mbr-fonts-style display-5">{$sl.texto_slide}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              {else}
                <div class="carousel-item slider-fullscreen-image" data-bg-video-slide="{$sl.video}">
                  <div class="mbr-overlay" style="opacity: {$sl.opacidad}; background-color: rgb({$sl.backgroundcolor});"></div>
                  <div class="container container-slide">
                    <div class="image_wrapper">
                      <img src="uploads/slides/{$sl.id}.{$sl.ext}" style="opacity: 0;">
                      <div class="carousel-caption justify-content-center">
                        <div class="col-10 align-left">
                          <h2 class="mbr-fonts-style display-1">{$sl.titulo_slide}</h2>
                          <p class="lead mbr-text mbr-fonts-style display-5">{$sl.texto_slide}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              {/if}
            {/if}
            {$i=$i+1}
          {/foreach}
        {/if}
      </div>

        <a data-app-prevent-settings="" class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#slider1-j">
          <span aria-hidden="true" class="mbri-left mbr-iconfont"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a data-app-prevent-settings="" class="carousel-control carousel-control-next" role="button" data-slide="next" href="#slider1-j">
          <span aria-hidden="true" class="mbri-right mbr-iconfont"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

</section>
