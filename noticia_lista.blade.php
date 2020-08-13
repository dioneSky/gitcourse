<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="{{ asset('images/img/favicon.png') }}" >

  <title>Post & Noticia | Lista</title>

  <!-- Bootstrap CSS -->
  <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}"  rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="{{ asset('admin_assets/css/bootstrap-theme.css') }}"  rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="{{ asset('admin_assets/css/elegant-icons-style.css') }}"  rel="stylesheet" />
  <link href="{{ asset('admin_assets/css/font-awesome.min.css') }}"  rel="stylesheet" />
  <!-- Custom styles -->
  <link href="{{ asset('admin_assets/css/style.css') }}"  rel="stylesheet">
  <link href="{{ asset('admin_assets/css/style_noticia.css') }}"  rel="stylesheet">
  <link href="{{ asset('admin_assets/css/style-responsive.css') }}"  rel="stylesheet" />

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
  <!--[if lt IE 9]>
      <script src="{{ asset('admin_assets/js/html5shiv.js') }}" ></script>
      <script src="{{ asset('admin_assets/js/respond.min.js') }}" ></script>
      <script src="{{ asset('admin_assets/js/lte-ie7.js') }}" ></script>
    <![endif]-->

    <!-- =======================================================
      Theme Name: NiceAdmin
      Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
      Author: BootstrapMade
      Author URL: https://bootstrapmade.com
    ======================================================= -->
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->
    <header class="header dark-bg">

@include('layouts/admin/header')

    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->

@include('layouts/admin/side-menu')


        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-4">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Paginas</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-image"></i><a href="{{ asset('index.php') }}" >Post & Noticia</a></li>
              <li><i class="fa fa-bars"></i>Lista</li>

            </ol>
          </div>

          <div class="col-lg-8">

                @include('layouts/admin/botao_accao_geral')

            </div>

        </div>
        <!-- page start-->

				<div class="row my-0">

                    @if(count($noticias))

                        @foreach($noticias as $noticia)

                            <div class="col-md-4 animate-box my-1">

                                <article class="article-entry">
                                    <a href="/cpanel/admin/informacao/{{ $noticia->id }}/0/6/listar?menu=informacao"  class="blog-img" style="background-image: url({{ $action }}/assets/img/article/{{ $noticia->imagem }});">
                                        <p class="meta"><span class="day">{{ explode(' ',explode('-',$noticia->data_publicacao)[2])[0] }}</span><span class="month">{{ $meses[(explode('-',$noticia->data_publicacao)[1]/1)-1] }}</span></p>
                                    </a>
                                    <div class="desc">
                                        <h2><a href="{{ $noticia->link }}" >{{ $noticia->titulo }}</a></h2>
                                        <p class="admin"><span>Publicado por:</span> <span>{{ $noticia->autor }}</span></p>
                                        <p>{{ $noticia->descricao_curta }}</p>
                                    </div>
                                    <div class="div_botao_individual">

                                        <footer class="entry-footer flex justify-content-between align-items-center">

                                            <label class="label_check" for="checkbox-01">
                                                <input  name="sample-checkbox-01"   class="check_conjunto_seleccionavel" id="checkbox-01" value="1" type="checkbox" noticia_id="{{ $noticia->id }}" checked />
                                            </label>

                                            <a class="" href="/cpanel/admin/noticia/{{ $noticia->id }}/editar?menu=noticia"><i class="dark-text fa fa-edit"></i></a>

                                            @if($noticia->galeria==1)
                                                <a class="" ><i id="" noticia_id="{{ $noticia->id }}" class="warning-text fa fa-film galeria_off"></i></a>
                                            @else
                                                <a class="" ><i id="" noticia_id="{{ $noticia->id }}" class="dark-text fa fa-image galeria_on"></i></a>
                                            @endif

                                            @if($noticia->estado==1)

                                                <a class="" ><i class="dark-text icon_close_alt2 desactivar_noticia" noticia_id="{{ $noticia->id }}"></i></a>

                                            @else

                                                <a class="" ><i class="dark-text fa fa-check activar_noticia" noticia_id="{{ $noticia->id }}"></i></a>

                                            @endif

                                            <a><i class="fa fa-trash-o dark-text remover_noticia" noticia_id="{{ $noticia->id }}"></i></a>

                                        </footer>

                                    </div>
                                </article>

                            </div>

                        @endforeach

                    @endif

				</div>

        <!-- page end-->
      </section>
    </section>
    <!--main content end-->

  </section>
  <!-- container section end -->
  <!-- javascripts -->
  <script src="{{ asset('admin_assets/js/jquery.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/bootstrap.min.js') }}" ></script>
  <!-- nice scroll -->
  <script src="{{ asset('admin_assets/js/jquery.scrollTo.min.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/jquery.nicescroll.js') }}"  type="text/javascript"></script>
  <!--custome script for all page-->
  <script src="{{ asset('admin_assets/js/scripts.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/script_noticia.js') }}" ></script>


</body>

</html>
