<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@section('scripts2')
@show
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>@yield('title')</title>

	<meta name="description" content="" />

	<link rel="shortcut icon" href="{{ asset('images/logo-ico.png')}}" type="image/x-icon">

	<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css')}}" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	@section('csslau')
	@show
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/css/ui.jqgrid.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/css/fonts.googleapis.com.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/font-awesome/4.5.0/css/font-awesome.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="{{ asset('assets/css/ace-skins.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/css/ace-rtl.min.css')}}" />
	<script src="{{ asset('assets/js/ace-extra.min.js')}}"></script>
</head>

<body class="no-skin">
	@if (session('Fact_Dian') == 1 || session('Fact_Dian_cr') == 1)

	<div style="background-color: yellow; color: black; font-weight: bold; padding: 10px; border: 2px solid black; text-align: center; animation: blink 1s infinite;">
		Hay Facturas para enviar a la DIAN
	</div>

	<style>
		@keyframes blink {
			0%, 50%, 100% {
				opacity: 1;
			}
			25%, 75% {
				opacity: 0;
			}
		}
	</style>

	@endif

	

	<!--    NAV   -->
	<div id="navbar" class="navbar navbar-default  ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<div class="navbar-header pull-left">
				<a href="/home" class="navbar-brand">
					<small>
						<i><img src="{{ asset('assets/images/logo-ico.png')}} " width="30px" height="30px"/></i>
						Alpha - Notarial
					</small>
				</a>
			</div>





			<nav role="navigation" class="navbar-menu pull-left collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							Reportes
							&nbsp;
							<i class="ace-icon fa fa-angle-down bigger-110"></i>
						</a>

						<ul id="reportes-menu" class="dropdown-menu dropdown-light-blue dropdown-caret">
							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Informes Administrativos
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="mensualcaja">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación de Facturas Mensuales 
										</a>
									</li>
									<li>
										<a href="javascript://" id="estadisticonotarial">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Estadístico Notarial 
										</a>
									</li>
									<li>
										<a href="javascript://" id="relacionnotascreditomensual">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación Notas Crédito Mensual
										</a>
									</li>
									
									<li>
										<a href="javascript://" id="ingresosporconceptomensual">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe de Conceptos
										</a>
									</li>
									<li>
										<a href="javascript://" id="informerecaudos">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe de Recaudos 
										</a>
									</li>
									<li>
										<a href="javascript://" id="ingresporescrituradores">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Ingresos por Escrituradores
										</a>
									</li>
									<li>
										<a href="javascript://" id="retefuentesaplicadas">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe Retefuentes Aplicadas
										</a>
									</li>
									<li>
										<a href="javascript://" id="informederetefuentes">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe Retefuentes
										</a>
									</li>
									<li>
										<a href="javascript://" id="informeimptimbre">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe Timbre
										</a>
									</li>
									<li>
										<a href="javascript://" id="informedegastos">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe de Gastos
										</a>
									</li>
								</ul>
							</li>


							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Informes de Caja
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="diariocaja">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación de Facturas Diarias 
										</a>
									</li>
									<li>
										<a href="javascript://" id="relacionnotascreditodiario">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación Nota Crédito Diario 
										</a>
									</li>
									<li>
										<a href="javascript://" id="ingresosporconcepto">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación de Facturas Diarias por Conceptos 
										</a>
									</li>
									<li>
										<a href="javascript://" id="informerecaudosdiario">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación de Facturas Diarias por Recaudos 
										</a>
									</li>
								</ul>
							</li>


							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Informes de Escrituración
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="actos_notariales_escritura">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Actos Jurídicos Notariales  
										</a>
									</li>
									<li>
										<a href="javascript://" id="enlaces">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Enlaces  
										</a>
									</li>
									<li>
										<a href="javascript://" id="libroindice">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Libro Índice de Escrituras  
										</a>
									</li>
									<li>
										<a href="javascript://" id="librorelaciondeescrituras">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Libro Relación de Escrituras  
										</a>
									</li>
									<li>
										<a href="javascript://" id="ron">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Reporte de Operaciones Notariales (RON)  
										</a>
									</li>
									<li>
										<a href="javascript://" id="escrisinfact">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Escrituras pendientes de Factura 
										</a>
									</li>
								</ul>
							</li>



							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Informes de Cartera
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="informecarteracliente">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación Cartera por Cliente  
										</a>
									</li>
									<li>
										<a href="javascript://" id="informecarterames">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación Cartera por Mes  
										</a>
									</li>
									<li>
										<a href="javascript://" id="informecarterafacturasactivas">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Relación Cartera Facturas Activas 
										</a>
									</li>

								</ul>
							</li>


							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Informe de Bonos
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="cuentasdecobrogeneradas">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Cuentas de cobro generadas  
										</a>
									</li>
									<li>
										<a href="javascript://" id="carterabonoscliente">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Trazabilidad X Cliente  
										</a>
									</li>
									<li>
										<a href="javascript://" id="informecarterabonomes">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Trazabilidad X Fecha 
										</a>
									</li>
									<li>
										<a href="javascript://" id="informecarterabonosactiva">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe de Cartera Bonos  
										</a>
									</li>
								</ul>
							</li>



							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Certificados
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="certificadortf">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Retención en la Fuente   
										</a>
									</li>

								</ul>
							</li>



							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Actas de Depósito
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="informedepositos">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe de Depósitos    
										</a>
									</li>

									<li>
										<a href="javascript://" id="informeegresos">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe de Egresos     
										</a>
									</li>

								</ul>
							</li>


							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Informes para la DIAN
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="informeingresos_dian">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe de Ingresos por Cliente     
										</a>
									</li>

									<li>
										<a href="javascript://" id="enajenaciones">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Informe de Enajenaciones      
										</a>
									</li>

								</ul>
							</li>


							<li style="position: relative;">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<i class="ace-icon fa fa-angle-down bigger-110 blue"></i>
									Informes consolidados
								</a>
								<ul class="dropdown-menu" style="position: absolute; left: 100%; top: 0;">
									<li>
										<a href="javascript://" id="consolidadocaja">
											<i class="ace-icon fa fa-file-text-o bigger-110 green"></i>
											Consolidado de Caja 
										</a>
									</li>
								</ul>
							</li>


						</ul>
					</li>
				</ul>
			</nav>

			<div class="navbar-header pull-left">
				<a href="/ayuda" class="navbar-brand">
					<small>
						<img src="{{ asset('images/ayuda1.png')}} " width="30px" height="30px"/>						
					</small>
				</a>
			</div>


			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<ul class="nav ace-nav">
					<li class="light-blue dropdown-modal">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<span class="user-info">
								<small>Hola,</small>
								{{ Auth::user()->name }} <span class="caret"></span>
							</span>
							<i class="ace-icon fa fa-caret-down"></i>
						</a>
						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li>
								<a href="#">
									<i class="ace-icon fa fa-user"></i>
									Perfil
								</a>
							</li>

							<li class="divider"></li>

							<li>
								<a class="dropdown-item" href="{{ route('logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								{{ __('Logout') }}
							</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div><!-- /.navbar-container -->
</div>

<div class="main-container ace-save-state" id="main-container">

	<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse  ace-save-state">
		<script type="text/javascript">
			try{ace.settings.loadState('sidebar')}catch(e){}
		</script>

		<!--  Top Menu  -->

		<div class="sidebar-shortcuts" id="sidebar-shortcuts">


			<div >
				<a href="javascript://" id="validarfacturacion">
					<img src="{{ asset('images/facturar.png') }}" width="174 px" height="70 px">
				</a>
			</div>
		</div><!-- /.sidebar-shortcuts -->

		<ul class="nav nav-list">
						<!--<li>
							<a href="/cpanelreportes">
					    	<i class="menu-icon"><img src="{{ asset('images/reportes.png') }}" width="30 px" height="30 px"></i>
					    	<span class="menu-text"> Reportes</span>
					     </a>
				       <b class="arrow"></b>
				     </li>-->

				     <li>
				     	<a href="/cartera">
				     		<i class="menu-icon"><img src="{{ asset('images/facturacion.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Cartera </span>
				     		<b class="arrow fa fa-angle-down"></b>
				     	</a>
				     </li>

				     <li>
				     	<a href="/bonos">
				     		<i class="menu-icon"><img src="{{ asset('images/bonos.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Cuentas X C  </span>
				     		<b class="arrow fa fa-angle-down"></b>
				     	</a>
				     </li>

				     <li>
				     	<a href="/actasdeposito">
				     		<i class="menu-icon"><img src="{{ asset('images/cartera.png') }}" width="30 px" height="30 px" alt="Actas de depósito"></i>
				     		<span class="menu-text"> Actas </span>
				     		<b class="arrow fa fa-angle-down"></b>
				     	</a>
				     </li>

				     <li>
				     	<a href="/cpanelcertificados">
				     		<i class="menu-icon"><img src="{{ asset('images/certificados.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Certificados</span>
				     	</a>
				     	<b class="arrow"></b>
				     </li>

				     <li>
				     	<a href="/panel_protocolistas">
				     		<i class="menu-icon"><img src="{{ asset('images/protocolistas.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Protocolistas </span>
				     		<b class="arrow fa fa-angle-down"></b>
				     	</a>
				     </li>

				     <li>
				     	<a href="/consultas">
				     		<i class="menu-icon"><img src="{{ asset('images/lupa.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Consultar </span>
				     	</a>
				     	<b class="arrow"></b>
				     </li>

				     <li>
				     	<a href="/mantenimiento">
				     		<i class="menu-icon"><img src="{{ asset('images/mantenimiento.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Mantenimiento </span>
				     	</a>
				     	<b class="arrow"></b>
				     </li>

				     <li>
				     	<a href="/configuracion">
				     		<i class="menu-icon"><img src="{{ asset('images/configuracion.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Configuración </span>
				     	</a>
				     	<b class="arrow"></b>
				     </li>

				     <li>
				     	<a href="/seguimientoescrituras">
				     		<i class="menu-icon"><img src="{{ asset('images/trazabilidad.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text">Traza Escr</span>
				     	</a>
				     	<b class="arrow"></b>
				     </li>

				     <li>
				     	<a href="/gastos_notaria">
				     		<i class="menu-icon"><img src="{{ asset('images/gastos.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Gastos </span>
				     	</a>
				     	<b class="arrow"></b>
				     </li>

				      <li>
				     	<a href="/registro">
				     		<i class="menu-icon"><img src="{{ asset('images/registro.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Registro </span>
				     	</a>
				     	<b class="arrow"></b>
				     </li>

				     <li>
				     	<a href="/cpanelcajarapida">
				     		<i class="menu-icon"><img src="{{ asset('images/presupuesto.png') }}" width="30 px" height="30 px"></i>
				     		<span class="menu-text"> Caja Rápida </span>
				     	</a>
				     	<b class="arrow"></b>
				     </li>
				   </ul>
				 </div>


				 <!--CONTENIDO*/-->

				 <div class="main-content">
				 	<div class="main-content-inner">
				 		<div class="page-content">
				 			<div class="row">
				 				<div class="col-xs-12">
				 					<!-- PAGE CONTENT BEGINS -->
				 					<div class="invisible">
				 						<button data-target="#sidebar2" type="button" class="pull-left menu-toggler navbar-toggle">
				 							<span class="sr-only">Toggle sidebar</span>

				 							<i class="ace-icon fa fa-dashboard white bigger-125"></i>
				 						</button>

				 						<!--  Menu Left -->

				 						<div id="sidebar2" class="sidebar responsive menu-min ace-save-state">
				 							<ul class="nav nav-list">
				 								<li>
				 									<a href="/radicacion/create">
				 										<i class="menu-icon"><img src="{{ asset('images/radicacion1.png') }}" width="20 px" height="20 px"></i>
				 										<span class="menu-text"> Radicación</span>
				 									</a>
				 									<b class="arrow"></b>
				 								</li>

				 								<li>
				 									<a href="javascript://" id="validarradicacion">
				 										<i class="menu-icon"><img src="{{ asset('images/liquidacion.png') }}" width="20 px" height="20 px"></i>
				 										<span class="menu-text">Liquidación</span>
				 									</a>
				 									<b class="arrow"></b>
				 								</li>

				 								<div class="sidebar-toggle sidebar-collapse">
				 									<i id="sidebar3-toggle-icon" class="ace-icon fa fa-angle-double-right ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				 								</div>
				 							</div><!-- .sidebar -->

				 						</div>

				 						@yield('content')

				 						<!-- PAGE CONTENT ENDS -->
				 					</div><!-- /.col -->
				 				</div><!-- /.row -->
				 			</div><!-- /.page-content -->
				 		</div>
				 	</div><!-- /.main-content -->


				 	<!-- Footer     -->

				 	<div class="footer">
				 		<div class="footer-inner">
				 			<div class="footer-content">
				 				<span class="bigger-120">
				 					<span class="blue bolder"><img src="{{ asset('assets/images/logo-ico-black.png')}} " width="30px" height="30px"/></span>
				 					Application &copy; <span id="anio"></span>
				 				</span>

				 				&nbsp; &nbsp;

				 			</div>
				 		</div>
				 	</div>

				 	<script type="text/javascript">
				 		var fecha = new Date();
				 		var ano = fecha.getFullYear();
				 		document.getElementById('anio').innerHTML  =  ano+' - '+ parseInt(ano+1);
				 	</script>

				 	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				 		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
				 	</a>
				 </div><!-- /.main-container -->

				 <script src="{{ asset('assets/js/jquery-2.1.4.min.js')}}"></script>

				 <script type="text/javascript">
				 	if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js')}}'>"+"<"+"/script>");
				 </script>
				 <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
				 <script src="{{ asset('assets/js/jquery-ui.min.js')}}"></script>

				 <script src="{{ asset('assets/js/ace-elements.min.js')}}"></script>
				 <script src="{{ asset('assets/js/ace.min.js')}}"></script>
				 <script src="{{ asset('js/validaradicacion.js')}}"></script>
				 <script src="{{ asset('js/__AJAX.js')}}"></script>
				 <script src="{{ asset('js/reportes/script.js')}}"></script>


				 <script>
				 	$(document).ready(function(){
				 		$('#reportes-menu').on('click', function(event){
            // Evita el comportamiento predeterminado del enlace
				 			event.preventDefault();
            // Muestra o oculta el submenú al hacer clic en "Informes Administrativos"
				 			$(this).toggleClass('show');
				 		});
				 	});
				 </script>

				 <script type="text/javascript">
				 	jQuery(function($) {
				 		$('#sidebar2').insertBefore('.page-content');
				 		$('#navbar').addClass('h-navbar');
				 		$('.footer').insertAfter('.page-content');

				 		$('.page-content').addClass('main-content');

				 		$('.menu-toggler[data-target="#sidebar2"]').insertBefore('.navbar-brand');


				 		$(document).on('settings.ace.two_menu', function(e, event_name, event_val) {
				 			if(event_name == 'sidebar_fixed') {
				 				if( $('#sidebar').hasClass('sidebar-fixed') ) $('#sidebar2').addClass('sidebar-fixed')
				 					else $('#sidebar2').removeClass('sidebar-fixed')
				 			}
				 		}).triggerHandler('settings.ace.two_menu', ['sidebar_fixed' ,$('#sidebar').hasClass('sidebar-fixed')]);

				 		$('#sidebar2[data-sidebar-hover=true]').ace_sidebar_hover('reset');
				 		$('#sidebar2[data-sidebar-scroll=true]').ace_sidebar_scroll('reset', true);
				 	})
				 </script>

				 @section('scripts')
				 @show

				</body>
				</html>
