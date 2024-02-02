<?php /* Smarty version 3.1.27, created on 2018-02-16 03:28:12
         compiled from "C:\wamp\www\camino\styles\templates\overall\features.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:203105a8641bca4b0f8_82409162%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d60c7a1e2e98dfaa7d762795565772a3fedf351' => 
    array (
      0 => 'C:\\wamp\\www\\camino\\styles\\templates\\overall\\features.tpl',
      1 => 1518629568,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203105a8641bca4b0f8_82409162',
  'variables' => 
  array (
    'modulo' => 0,
    'descripcion_modulo' => 0,
    'direccion_video1' => 0,
    'imgvideo1' => 0,
    'extvideo1' => 0,
    'titulo_video1' => 0,
    'descripcion_video1' => 0,
    'direccion_video2' => 0,
    'imgvideo2' => 0,
    'extvideo2' => 0,
    'titulo_video2' => 0,
    'descripcion_video2' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5a8641bca849c0_83205166',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5a8641bca849c0_83205166')) {
function content_5a8641bca849c0_83205166 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '203105a8641bca4b0f8_82409162';
?>
<section class="mbr-section content5 cid-qJ0PGdhGzd " id="content5-a">
    <div class="container">
        <div class="media-container-row">
            <div class="title col-12 col-md-8">
                <h2 class="align-center mbr-bold mbr-white pb-3 mbr-fonts-style display-1">
                    <?php echo $_smarty_tpl->tpl_vars['modulo']->value;?>

                </h2>
                <h3 class="mbr-section-subtitle align-center mbr-light mbr-white pb-3 mbr-fonts-style display-5">
                    <?php echo $_smarty_tpl->tpl_vars['descripcion_modulo']->value;?>

                </h3>
            </div>
        </div>
    </div>
</section>

<section class="features2 cid-qJ0QiBveMX" id="features2-b">
    <div class="container">
        <div class="media-container-row">
            <div class="card p-3 col-12 col-md-6">
                <div class="card-wrapper">
                    <div class="card-img">
                      <a href="#"  data-toggle="modal" data-target="#videoModal" data-theVideo="<?php echo $_smarty_tpl->tpl_vars['direccion_video1']->value;?>
" ><img src="uploads/imgvideos/1/<?php echo $_smarty_tpl->tpl_vars['imgvideo1']->value;?>
.<?php echo $_smarty_tpl->tpl_vars['extvideo1']->value;?>
"></a>
                    </div>
                    <div class="card-box">
                        <h4 class="card-title pb-3 mbr-fonts-style display-7">
                          <?php echo $_smarty_tpl->tpl_vars['titulo_video1']->value;?>

                        </h4>
                        <p class="mbr-text mbr-fonts-style display-7">
                            <?php echo $_smarty_tpl->tpl_vars['descripcion_video1']->value;?>

                        </p>
                    </div>
                </div>
            </div>

            <div class="card p-3 col-12 col-md-6">
                <div class="card-wrapper">
                  <div class="card-img"><a href="#"  data-toggle="modal" data-target="#videoModal" data-theVideo="<?php echo $_smarty_tpl->tpl_vars['direccion_video2']->value;?>
" ><img src="uploads/imgvideos/2/<?php echo $_smarty_tpl->tpl_vars['imgvideo2']->value;?>
.<?php echo $_smarty_tpl->tpl_vars['extvideo2']->value;?>
"></a>
                </div>
                    <div class="card-box ">
                        <h4 class="card-title pb-3 mbr-fonts-style display-7">
                            <?php echo $_smarty_tpl->tpl_vars['titulo_video2']->value;?>

                        </h4>
                        <p class="mbr-text mbr-fonts-style display-7">
                            <?php echo $_smarty_tpl->tpl_vars['descripcion_video2']->value;?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php }
}
?>