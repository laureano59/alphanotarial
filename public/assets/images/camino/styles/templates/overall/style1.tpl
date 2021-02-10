<br><br>

<section class="engine"><a href="https://mobirise.ws/n">best website builder app</a></section>
<section class="header3 cid-qJ0LXHV7Vf mbr-fullscreen" id="header3-9" style="background-image: url(uploads/fondos/{$nombrefoto}.{$ext});">


    <div class="mbr-overlay" style="opacity:  {$opacidad}; background-color: rgb({$colorimage});">
    </div>

    <div class="container">
        <div class="media-container-row">
            <div class="mbr-figure" style="width: {$media_size}%;">
                {include 'overall/onlinehome.tpl'}
            </div>

            <div class="media-content">
                <h1 class="mbr-section-title mbr-white pb-3 mbr-fonts-style display-1">
                      {if $mostrar_titulo == 1}{$titulo}{else if $mostrar_titulo == 0}{/if}
                </h1>

                <div class="mbr-section-text mbr-white pb-3 ">
                    <p class="mbr-text mbr-fonts-style display-5">
                        {if $mostrar_texto == 1}{$texto}{else if $mostrar_texto == 0}{/if}
                    </p>
                </div>

            </div>
        </div>
    </div>

</section>
