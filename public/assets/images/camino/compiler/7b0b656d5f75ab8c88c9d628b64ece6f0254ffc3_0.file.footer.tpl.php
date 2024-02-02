<?php /* Smarty version 3.1.27, created on 2019-04-04 18:54:08
         compiled from "C:\wamp\www\camino\styles\templates\overall\footer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:309935ca636b0a14af8_01061828%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b0b656d5f75ab8c88c9d628b64ece6f0254ffc3' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\footer.tpl',
      1 => 1554396820,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '309935ca636b0a14af8_01061828',
  'variables' => 
  array (
    'direccion' => 0,
    'ciudad' => 0,
    'email' => 0,
    'telefono' => 0,
    'movil' => 0,
    'copyright' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5ca636b11d3c00_10076097',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5ca636b11d3c00_10076097')) {
function content_5ca636b11d3c00_10076097 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '309935ca636b0a14af8_01061828';
?>
<section class="cid-qJ0RX5koyH" id="social-buttons3-f">
      <div class="container">
        <div class="media-container-row">
            <div class="col-md-8 align-center">
                <h2 class="pb-3 mbr-section-title mbr-fonts-style display-2">
                    SIGUENOS!
                </h2>
                <div>
                    <div class="mbr-social-likes">
                      <a href="https://www.facebook.com/pages/elcaminocali" target="_blank">
                        <span class="btn btn-social socicon-bg-facebook facebook mx-2" title="Síguenos en Facebook">
                          <i class="socicon socicon-facebook"></i>
                        </span>
                      </a>
                      <a href="https://twitter.com/elcaminocali" target="_blank">
                        <span class="btn btn-social twitter socicon-bg-twitter mx-2" title="Síguenos en Twitter">
                          <i class="socicon socicon-twitter"></i>
                        </span>
                      </a>
                      <a href="https://www.youtube.com/channel/UC9mf0ja6GXipTLeBDPSiSJw" target="_blank">
                        <span class="btn btn-social plusone socicon-bg-googleplus mx-2" title="Síguenos en Youtu">
                            <i class="socicon socicon-youtube"></i>
                        </span>
                      </a>
                      <a href="https://instagram.com/elcaminocali" target="_blank">
                        <span class="btn btn-social plusone socicon-bg-odnoklassniki mx-2" title="Síguenos en Instagram">
                            <i class="socicon socicon-instagram"></i>
                        </span>
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="cid-qJ0SvmUEaO" id="footer2-g">
  <div class="container">
    <div class="media-container-row content mbr-white">
      <div class="col-12 col-md-3 mbr-fonts-style display-7">
        <p class="mbr-text">
          <strong>Dirección</strong>
          <br>
          <br><?php echo $_smarty_tpl->tpl_vars['direccion']->value;?>

          <br><?php echo $_smarty_tpl->tpl_vars['ciudad']->value;?>
,
          <br>
          <br>
          <br><strong>Contactos</strong>
          <br>
          <br>Email: <?php echo $_smarty_tpl->tpl_vars['email']->value;?>

          <br>Teléfonos: <?php echo $_smarty_tpl->tpl_vars['telefono']->value;?>

          <br>Móvil: <?php echo $_smarty_tpl->tpl_vars['movil']->value;?>

        </p>
      </div>
      <div class="col-12 col-md-3 mbr-fonts-style display-7">
        <p class="mbr-text">
          <strong>Links</strong>
          <br>
          <br><a class="text-primary" href="?view=predicas">Prédicas</a>
          <br><a class="text-primary" href="?view=radioelcamino">Radio</a>
          <br><a class="text-primary" href="?view=tvonline">Televisión</a>
          <br>
        </p>
      </div>
      <div class="col-12 col-md-6">
        <div class="google-map"><iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.4459333724703!2d-76.52339668587666!3d3.483630051978357!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e30a89e1f35fc5f%3A0xdb3f8bfca6f34268!2sIglesia+El+Camino+Cali!5e0!3m2!1ses!2sco!4v1519143291845&amp;q=place_id:EixDbC4gNDcgTnRlLiwgQ2FsaSwgVmFsbGUgZGVsIENhdWNhLCBDb2xvbWJpYQ" allowfullscreen=""></iframe></div>
      </div>
    </div>
    <div class="footer-lower">
      <div class="media-container-row">
        <div class="col-sm-12">
          <hr>
        </div>
      </div>
      <div class="media-container-row mbr-white">
        <div class="col-sm-6 copyright">
          <p class="mbr-text mbr-fonts-style display-7">
            © Copyright 2018 :  <?php echo $_smarty_tpl->tpl_vars['copyright']->value;?>

          </p>
        </div>
        <div class="col-md-6">
          <div class="social-list align-right">
            <div class="soc-item">
              <a href="https://twitter.com/elcaminocali" target="_blank">
                <span class="socicon-twitter socicon mbr-iconfont mbr-iconfont-social"></span>
              </a>
            </div>
            <div class="soc-item">
              <a href="https://www.facebook.com/pages/elcaminocali" target="_blank">
                <span class="socicon-facebook socicon mbr-iconfont mbr-iconfont-social"></span>
              </a>
            </div>
            <div class="soc-item">
              <a href="https://www.youtube.com/c/elcaminocali" target="_blank">
                <span class="socicon-youtube socicon mbr-iconfont mbr-iconfont-social"></span>
              </a>
            </div>
            <div class="soc-item">
              <a href="https://instagram.com/elcaminocali" target="_blank">
                <span class="socicon-instagram socicon mbr-iconfont mbr-iconfont-social"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



  <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/touchswipe/jquery.touch-swipe.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="styles/assets/smoothscroll/smooth-scroll.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/popper/popper.min.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="styles/assets/web/assets/jquery/jquery.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/tether/tether.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/smooth-scroll/SmoothScroll.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/viewportChecker/jquery.viewportchecker.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/dropdown/js/script.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/touchSwipe/jquery.touchSwipe.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/jarallax/jarallax.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/masonry/masonry.pkgd.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/imagesloaded/imagesloaded.pkgd.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/bootstrap-carousel-swipe/bootstrap-carousel-swipe.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/theme/js/script.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/mobirise-gallery/player.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/mobirise-gallery/script.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/assets/formoid/formoid.min.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/js/bootstrap-datepicker.js"><?php echo '</script'; ?>
>

  <?php echo '<script'; ?>
 src="styles/js/longitudtexto.js"><?php echo '</script'; ?>
>



  <input name="animation" type="hidden">



  </body>

</html>

<?php }
}
?>