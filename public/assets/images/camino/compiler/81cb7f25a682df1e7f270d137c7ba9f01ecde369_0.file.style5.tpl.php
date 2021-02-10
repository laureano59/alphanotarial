<?php /* Smarty version 3.1.27, created on 2018-02-19 05:20:40
         compiled from "C:\wamp\www\camino\styles\templates\overall\style5.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:255445a8a5098312759_83045946%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81cb7f25a682df1e7f270d137c7ba9f01ecde369' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\style5.tpl',
      1 => 1518496203,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '255445a8a5098312759_83045946',
  'variables' => 
  array (
    'slide' => 0,
    'i' => 0,
    'j' => 0,
    'sl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8a50985a6259_33532584',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8a50985a6259_33532584')) {
function content_5a8a50985a6259_33532584 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '255445a8a5098312759_83045946';
?>
<br>

<section class="carousel slide cid-qJvce3assp" data-interval="false" id="slider1-j">
  <div class="full-screen">
    <div class="mbr-slider slide carousel" data-pause="true" data-keyboard="false" data-ride="carousel" data-interval="4000">
      <ol class="carousel-indicators">
        <?php if (isset($_smarty_tpl->tpl_vars['slide']->value)) {?>
          <?php
$_from = $_smarty_tpl->tpl_vars['slide']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['sl'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['sl']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['sl']->value) {
$_smarty_tpl->tpl_vars['sl']->_loop = true;
$foreach_sl_Sav = $_smarty_tpl->tpl_vars['sl'];
?>
            <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
              <li data-app-prevent-settings="" data-target="#slider1-j" class=" active" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"></li>
              <?php } elseif ($_smarty_tpl->tpl_vars['i']->value < $_smarty_tpl->tpl_vars['j']->value) {?>
              <li data-app-prevent-settings="" data-target="#slider1-j" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"></li>
            <?php } else { ?>
              <li data-app-prevent-settings="" data-target="#slider1-j"  data-slide-to="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"></li>
            <?php }?>
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
          <?php
$_smarty_tpl->tpl_vars['sl'] = $foreach_sl_Sav;
}
?>
        <?php }?>
      </ol>

      <div class="carousel-inner" role="listbox">
        <?php if (isset($_smarty_tpl->tpl_vars['slide']->value)) {
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable(0, null, 0);?>
          <?php
$_from = $_smarty_tpl->tpl_vars['slide']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['sl'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['sl']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['sl']->value) {
$_smarty_tpl->tpl_vars['sl']->_loop = true;
$foreach_sl_Sav = $_smarty_tpl->tpl_vars['sl'];
?>
            <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
              <?php if ($_smarty_tpl->tpl_vars['sl']->value['video'] == '') {?>
                <div class="carousel-item slider-fullscreen-image active" data-bg-video-slide="false" style="background-image: url(uploads/slides/<?php echo $_smarty_tpl->tpl_vars['sl']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['sl']->value['ext'];?>
);">
                  <div class="container container-slide">
                    <div class="image_wrapper">
                      <div class="mbr-overlay" style="opacity: <?php echo $_smarty_tpl->tpl_vars['sl']->value['opacidad'];?>
; background-color: rgb(<?php echo $_smarty_tpl->tpl_vars['sl']->value['backgroundcolor'];?>
);"></div>
                        <img src="uploads/slides/<?php echo $_smarty_tpl->tpl_vars['sl']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['sl']->value['ext'];?>
">
                      <div class="carousel-caption justify-content-center">
                        <div class="col-10 align-center">
                          <h2 class="mbr-fonts-style display-1"><?php echo $_smarty_tpl->tpl_vars['sl']->value['titulo_slide'];?>
</h2>
                          <p class="lead mbr-text mbr-fonts-style display-5"><?php echo $_smarty_tpl->tpl_vars['sl']->value['texto_slide'];?>
</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } else { ?>
                <div class="carousel-item slider-fullscreen-image active" data-bg-video-slide="<?php echo $_smarty_tpl->tpl_vars['sl']->value['video'];?>
">
                  <div class="mbr-overlay" style="opacity: <?php echo $_smarty_tpl->tpl_vars['sl']->value['opacidad'];?>
; background-color: rgb(<?php echo $_smarty_tpl->tpl_vars['sl']->value['backgroundcolor'];?>
);"></div>
                  <div class="container container-slide">
                    <div class="image_wrapper">
                      <img src="uploads/slides/<?php echo $_smarty_tpl->tpl_vars['sl']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['sl']->value['ext'];?>
" style="opacity: 0;">
                      <div class="carousel-caption justify-content-center">
                        <div class="col-10 align-left">
                          <h2 class="mbr-fonts-style display-1"><?php echo $_smarty_tpl->tpl_vars['sl']->value['titulo_slide'];?>
</h2>
                          <p class="lead mbr-text mbr-fonts-style display-5"><?php echo $_smarty_tpl->tpl_vars['sl']->value['texto_slide'];?>
</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            <?php } else { ?>
              <?php if ($_smarty_tpl->tpl_vars['sl']->value['video'] == '') {?>
                <div class="carousel-item slider-fullscreen-image" data-bg-video-slide="false" style="background-image: url(uploads/slides/<?php echo $_smarty_tpl->tpl_vars['sl']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['sl']->value['ext'];?>
);">
                  <div class="container container-slide">
                    <div class="image_wrapper">
                      <div class="mbr-overlay" style="opacity: <?php echo $_smarty_tpl->tpl_vars['sl']->value['opacidad'];?>
; background-color: rgb(<?php echo $_smarty_tpl->tpl_vars['sl']->value['backgroundcolor'];?>
);"></div>
                      <img src="uploads/slides/<?php echo $_smarty_tpl->tpl_vars['sl']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['sl']->value['ext'];?>
">
                      <div class="carousel-caption justify-content-center">
                        <div class="col-10 align-right">
                          <h2 class="mbr-fonts-style display-1"><?php echo $_smarty_tpl->tpl_vars['sl']->value['titulo_slide'];?>
</h2>
                          <p class="lead mbr-text mbr-fonts-style display-5"><?php echo $_smarty_tpl->tpl_vars['sl']->value['texto_slide'];?>
</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } else { ?>
                <div class="carousel-item slider-fullscreen-image" data-bg-video-slide="<?php echo $_smarty_tpl->tpl_vars['sl']->value['video'];?>
">
                  <div class="mbr-overlay" style="opacity: <?php echo $_smarty_tpl->tpl_vars['sl']->value['opacidad'];?>
; background-color: rgb(<?php echo $_smarty_tpl->tpl_vars['sl']->value['backgroundcolor'];?>
);"></div>
                  <div class="container container-slide">
                    <div class="image_wrapper">
                      <img src="uploads/slides/<?php echo $_smarty_tpl->tpl_vars['sl']->value['id'];?>
.<?php echo $_smarty_tpl->tpl_vars['sl']->value['ext'];?>
" style="opacity: 0;">
                      <div class="carousel-caption justify-content-center">
                        <div class="col-10 align-left">
                          <h2 class="mbr-fonts-style display-1"><?php echo $_smarty_tpl->tpl_vars['sl']->value['titulo_slide'];?>
</h2>
                          <p class="lead mbr-text mbr-fonts-style display-5"><?php echo $_smarty_tpl->tpl_vars['sl']->value['texto_slide'];?>
</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            <?php }?>
            <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable($_smarty_tpl->tpl_vars['i']->value+1, null, 0);?>
          <?php
$_smarty_tpl->tpl_vars['sl'] = $foreach_sl_Sav;
}
?>
        <?php }?>
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
<?php }
}
?>