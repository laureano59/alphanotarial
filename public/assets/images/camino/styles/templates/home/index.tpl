{include 'overall/header.tpl'}
<link rel="stylesheet" href="styles/css/popuphome.css">

{if $styles==1}
  {if $posicion == 0}
    <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additional2.css" type="text/css">
    {else if $posicion == 1}
    <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additional.css" type="text/css">
  {/if}
{/if}

{if $styles==2}
  {if $posicion == 0}
    <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalstyle2izq.css" type="text/css">
    {else if $posicion == 1}
    <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalstyle2der.css" type="text/css">
  {/if}
{/if}

{if $styles==3}
  <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalstyle3.css" type="text/css">
{/if}

{if $styles==4}
  <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalstyle4.css" type="text/css">
{/if}

{if $styles==5}
  <link rel="stylesheet" href="styles/assets/mobirise/css/mbr-additionalstyle5.css" type="text/css">
{/if}

</head>
<body>

{include 'overall/nav.tpl'}

{if $styles==1}
  {include 'overall/style1.tpl'}
  {else if $styles==2}
  {include 'overall/style2.tpl'}
   {else if $styles==3}
   {include 'overall/style3.tpl'}
    {else if $styles==4}
    {include 'overall/style4.tpl'}
     {else if $styles==5}
     {include 'overall/style5.tpl'}
      {else if $styles==6}
      {include 'overall/style6.tpl'}
{/if}

{include 'overall/features.tpl'}



<section class="features8 cid-qJ0QOTn8tQ " id="features8-c" style="background-image: url(styles/assets/images/img-9815.jpg);">



    <div class="mbr-overlay" style="opacity: 0.2; background-color: rgb(35, 35, 35);">
    </div>

    <div class="container">
        <div class="media-container-row">

            <div class="card  col-12 col-md-6 col-lg-4">
                <div class="card-img">
                    <img src=styles/assets/images/icono1.png>
                </div>
                <div class="card-box align-center">
                    <h4 class="card-title mbr-fonts-style display-7">
                        Prédicas El Camino
                    </h4>
                    <p class="mbr-text mbr-fonts-style display-7">
                       Disfruta el mensaje de la palabra y deja que el Espíritu Santo transforme tu vida.
                    </p>
                    <div class="mbr-section-btn text-center">
                        <a href="?view=predicas" class="btn btn-secondary display-4">
                            Entrar
                        </a>
                    </div>
                </div>
            </div>

            <div class="card  col-12 col-md-6 col-lg-4">
                <div class="card-img">
                    <img src=styles/assets/images/icono2.png>
                </div>
                <div class="card-box align-center">
                    <h4 class="card-title mbr-fonts-style display-7">
                        Blog El Camino Cali
                    </h4>
                    <p class="mbr-text mbr-fonts-style display-7">
                       Encuentra las últimas noticias y entérate de todo lo que ocurre en la iglesia El Camino.
                    </p>
                    <div class="mbr-section-btn text-center">
                        <a href="#" class="btn btn-secondary display-4">
                            Entrar
                        </a>
                    </div>
                </div>
            </div>

            <div class="card  col-12 col-md-6 col-lg-4">
                <div class="card-img">
                  <img src=styles/assets/images/icono3.png>
                </div>
                <div class="card-box align-center">
                    <h4 class="card-title mbr-fonts-style display-7">
                        Emisora El Camino Cali
                    </h4>
                    <p class="mbr-text mbr-fonts-style display-7">
                       Conéctate con emisora El Camino y disfruta de toda nuestra programación.
                    </p>
                    <div class="mbr-section-btn text-center">
                        <a href="?view=radioelcamino" class="btn btn-secondary display-4">
                            Entrar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mbr-section content4 cid-qJ0RfEuqOW" id="content4-d">
    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center pb-3 mbr-fonts-style display-2">
                    {$titulogal}
                </h2>
                <h3 class="mbr-section-subtitle align-center mbr-light mbr-fonts-style display-5">
                    {$descripciongal}
                </h3>
            </div>
        </div>
    </div>
</section>

<section class="mbr-gallery mbr-slider-carousel cid-qJ0RueAMab" id="gallery1-e">
    <div class="container">
      <div><!-- Filter --><!-- Gallery -->
        <div class="mbr-gallery-row">
          <div class="mbr-gallery-layout-default">
            <div>
              <div>
                {if isset($gal)}
                  {foreach from=$gal item=gl}
                  <div class="mbr-gallery-item mbr-gallery-item--p1" data-video-url="false">
                    <div href="#lb-gallery1-e" data-slide-to="{$gl.id - 1}" data-toggle="modal">
                      <img alt="" src="uploads/gal/{$gl.id}.{$gl.ext}">
                      <span class="icon-focus"></span>
                    </div>
                  </div>
                  {/foreach}
                {/if}
              </div>
            </div>

            <div class="clearfix"></div>
          </div>
        </div><!-- Lightbox -->

        <div data-app-prevent-settings="" class="mbr-slider modal fade carousel slide" tabindex="-1" data-keyboard="true" data-interval="false" id="lb-gallery1-e">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <div class="carousel-inner">
                  {if isset($gal)}
                    {foreach from=$gal item=gl}
                      {if $i > 0}
                        <div class="carousel-item">
                          <img alt="" src="uploads/gal/{$gl.id}.{$gl.ext}">
                        </div>
                      {else}
                        <div class="carousel-item active">
                          <img alt="" src="uploads/gal/{$gl.id}.{$gl.ext}">
                        </div>
                      {/if}
                      {$j = $j + 1}
                      {$i = $i - 1}
                    {/foreach}
                  {/if}
                </div>

                <a class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#lb-gallery1-e">
                  <span class="mbri-left mbr-iconfont" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control carousel-control-next" role="button" data-slide="next" href="#lb-gallery1-e">
                  <span class="mbri-right mbr-iconfont" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
                <a class="close" href="#" role="button" data-dismiss="modal">
                  <span class="sr-only">Close</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

</section>

{include 'overall/footer.tpl'}
{include 'overall/modalvideos.tpl'}

<script>
function autoPlayYouTubeModal(){
  var trigger = $("body").find('[data-toggle="modal"]');
  trigger.click(function() {
    var theModal = $(this).data( "target" ),
    videoSRC = $(this).attr( "data-theVideo" ),
    videoSRCauto = videoSRC+"?autoplay=1" ;
    $(theModal+' iframe').attr('src', videoSRCauto);
    $(theModal+' button.close').click(function () {
        $(theModal+' iframe').attr('src', videoSRC);
    });
  });
}

$(document).ready(function(){
  autoPlayYouTubeModal();
});
</script>

<script>
$('.youtube').each(function() {
  $(this).append("<div></div>");
  $(this).click(function() {
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        window.location.href= $(this).attr('href');
     }
    else if(this.href.indexOf('vimeo') != -1) {
        var innerU =  $(this).attr('href').replace('vimeo.com/','player.vimeo.com/video/');
        $('body').append("<div class='youtube-back'><iframe width='{$ancho}' height='{$alto}' src='" + innerU + "?autoplay={$autoplay}' frameborder='0' allowfullscreen></iframe></div>");
        $('body').append("<div id='youtube-overlay'></div>");

        $("#youtube-overlay").click(function(){
          $("#youtube-overlay").remove();
          $(".youtube-back").remove();
        });
        return false;
    }
    else {
        var innerU =  $(this).attr('href').replace('watch?v=','embed/');
        $('body').append("<div class='youtube-back'><iframe width='{$ancho}' height='{$alto}' src='" + innerU + "?rel=0&amp;autoplay={$autoplay}' frameborder='0' allowfullscreen></iframe></div>");
        $('body').append("<div id='youtube-overlay'></div>");

        $("#youtube-overlay").click(function(){
          $("#youtube-overlay").remove();
          $(".youtube-back").remove();
        });
        return false;
    };
  });
});
  </script>
