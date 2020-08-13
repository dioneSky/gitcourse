<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="{{ asset('images/img/favicon.png') }}" >

  <meta name="_token" content="{{ csrf_token() }}" />

  <title>Noticia & Publicações | Formulario</title>

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
  <link href="{{ asset('admin_assets/css/style_slider_list.css') }}"  rel="stylesheet">
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
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Paginas</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-user"></i><a href="{{ asset('index.php') }}" >Noticia & publiacações</a></li>
              <li><i class="fa fa-edit"></i>Formulario</li>
            </ol>
          </div>
        </div>
        <!-- page start-->

        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Preencha o formulario
              </header>
              <div class="panel-body">
                <div class="form">
                  <form class="form-validate form-horizontal " id="register_form" method="post" action="">

                  <div class="form-group">
                      <label class="control-label col-lg-2" for="inputSuccess">Tipo</label>
                      <div class="col-lg-10">
                          <select class="form-control m-bot15" name="tipo">
                              <option {{ $noticia->tipo==1?' selected ':'' }} value="1">Publicação Comum</option>
                              <option {{ $noticia->tipo==2?' selected ':'' }} value="2">Noticia</option>
                              <option {{ $noticia->tipo==3?' selected ':'' }} value="3">Evento</option>
                          </select>
                      </div>
                  </div>

                  <div class="form-group">
                        <label class="control-label col-lg-2">Data Publicação</label>
                        <div class="col-lg-10">
                          <input id="data_publicacao" type="text" value="{{ $noticia->data_publicacao }}" name="data_publicacao" size="16" class="form-control data_tempo">
                        </div>
                    </div>

                  <div class="form-group">
                        <label class="control-label col-lg-2">Data Inicio</label>
                        <div class="col-lg-10">
                          <input id="dp2" type="text" value="{{ $noticia->data_inicio }}" name="data_inicio" size="16" class="form-control data_tempo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">Data Fim</label>
                        <div class="col-lg-10">
                          <input id="dp3" type="text" value="{{ $noticia->data_fim }}" name="data_fim" size="16" class="form-control data_tempo">
                        </div>
                    </div>

                    <div class="form-group ">
                      <label for="titulo" class="control-label col-lg-2">Titulo  <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class=" form-control" id="titulo" name="titulo" value="{{ $noticia->titulo }}" type="text" />
                      </div>
                    </div>

                    <div class="form-group ">
                      <label for="descricao" class="control-label col-lg-2">Descrição curta  <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="descricao_curta" name="descricao_curta" value="{{ $noticia->descricao_curta }}" type="text" />
                      </div>
                    </div>

                    <div class="form-group ">
                      <label for="endereco" class="control-label col-lg-2">Endereço  <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="endereco" name="endereco" value="{{ $noticia->endereco }}" type="text" />
                      </div>
                    </div>

                    <div class="form-group ">
                      <label for="autor" class="control-label col-lg-2">Autor  <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="autor" name="autor" value="{{ $noticia->autor }}" type="text" />
                      </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-lg-2" for="inputSuccess">Categoria do Post</label>
                    <div class="col-lg-10">
                      <select class="form-control m-bot15" name="categoria_id">

                          @if(count($categorias))

                              @foreach($categorias as $categoria)

                                  <option {{ $noticia->categoria_id==$categoria->id?' selected ':' ' }} value="{{ $categoria->id }}">{{ $categoria->titulo }}</option>

                              @endforeach

                          @endif

                      </select>
                    </div>
                  </div>

                    <div class="form-group ">
                      <label for="link" class="control-label col-lg-2">Link  <span class="required">*</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="link" name="link" value="{{ $noticia->link }}" type="text" />
                      </div>
                    </div>

                    <div class="form-group ">
                      <label for="imagem_input" class="control-label col-lg-2">Imagem <span class="required"></span></label>
                      <input type="file" id="imagem_input" name="imagem" class="imagem_input">

                        <div class="col-lg-8">
                          <label for="imagem_input" class="control-label col-lg-2"><img width="100px" heigth="100px" src="{{ asset($noticia->imagem==''?'assets/img/article/image_icon.png':'assets/img/article/'.$noticia->imagem) }}"  /></label>
                        </div>

                    </div>

                    <div class="form-group ">
                      <label for="video_input" class="control-label col-lg-2">Video <span class="required"></span></label>
                      <input type="file" id="video_input" name="video" class="imagem_input">

                        <div class="col-lg-8">
                          <label for="video_input"  class="control-label col-lg-2"><img width="100px" heigth="100px" src="{{ asset($noticia->imagem==''?'assets/video/image_icon.png':'assets/video/'.$noticia->imagem) }}"  /></label>
                        </div>

                    </div>

                    <div class="form-group ">
                      <label for="editor" class="control-label col-lg-2">Descrição Longa <span class="required">*</span></label>
                      <div class="col-lg-10">

                      <textarea id="editor" name="descricao_longa" class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">{{ $noticia->descricao_longa }}</textarea>

                      </div>
                    </div>

                      <div class="form-group ">

                          <input class="form-control " id="hidden_id" name="hidden_id" type="hidden" value="{{ $noticia->id==''?'-1':$noticia->id }}" />
                          <input class="form-control " id="hidden_imagem" name="hidden_imagem" type="hidden" value="{{ $noticia->imagem }}" />
                          <input class="form-control " id="hidden_video" name="hidden_video" type="hidden" value="{{ $noticia->video }}" />

                      </div>

                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-warning dark-text" type="submit">Save</button>
                        <button class="btn btn-default" type="button">Cancel</button>
                      </div>
                    </div>
                  </form>


                  @if( $noticia->id !='' || $noticia->id != null)

<div class="form-group ">

</div>


<header class="panel-heading mt-5 mb-5">
    adicionar imagems ao item
</header>

<form class="form-validate form-horizontal" id="add_img_form" method="post" action="">

  <div class="form-group ">
      <label for="titulo" class="control-label col-lg-2">Titulo <span class="required">*</span></label>
      <div class="col-lg-10">
        <input class=" form-control" id="titulo" name="titulo" type="text" value="" />
      </div>
    </div>

    <div class="form-group ">
      <label for="descricao_img" class="control-label col-lg-2">Descrição <span class="required">*</span></label>
      <div class="col-lg-10">
        <input class=" form-control" id="descricao_img" name="descricao" value="" type="text" />
      </div>
    </div>

    <div class="form-group hand cursor">
    <label for="img_input" class="control-label col-lg-2">Carregue uma imagem <span class="required">*</span></label>
    <input type="file" id="img_input" class="hidden" name="img"  />

  </div>

    <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <input class="form-control " name="tipo" type="hidden" value="2" />
      <input class="form-control " name="tipo_id" type="hidden" value="{{ $noticia->id }}" />
      <button class="btn btn-warning dark-text" type="submit">adicionar</button>
    </div>
  </div>

</form>

@endif

  @if( $noticia->id !='' || $noticia->id != null)

<header class="panel-heading mt-5 mb-5">
    As imagens adicionadas
</header>

  <div id="feature">
      <div class="container">
          <div class="row">

  <!--== Partner Area Start ==-->
               @if(count($imagens))

                        @foreach($imagens as $imagem)

                          <div class="col-md-3 wow fadeInRight" data-wow-offset="0" data-wow-delay="0.3s">
                              <div class="text-center">
                                  <div class="hi-icon-wrap hi-icon-effect">
                                      <i class=""></i>
                                      <img width="100px" heigth="100px" src="{{ asset('assets/img/mais/'.$imagem->img) }}"  />

                                      <h2>{{ $imagem->titulo }}</h2>
                                      <p>{{ $imagem->descricao }}</p>
                                      <a class="remover_imagem" imagem_id="{{ $imagem->id }}"><i class="fa fa-trash-o dark-text"></i></a>

                                  </div>
                              </div>
                          </div>

                            @endforeach

                        @endif

                                </div>
                            </div>
                        </div>
                        <!--== Partner Area End ==-->

                       @endif


                  </div>
               </div>
            </section>
          </div>
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


 <!-- jquery ui -->
 <script src="{{ asset('admin_assets/js/jquery-ui-1.9.2.custom.min.js') }}" ></script>

<!--custom checkbox & radio-->
<script type="text/javascript" src="{{ asset('admin_assets/js/ga.js') }}" ></script>
<!--custom switch-->
<script src="{{ asset('admin_assets/js/bootstrap-switch.js') }}" ></script>
<!--custom tagsinput-->
<script src="{{ asset('admin_assets/js/jquery.tagsinput.js') }}" ></script>

<!-- colorpicker -->

 <!-- bootstrap-wysiwyg -->
 <script src="{{ asset('admin_assets/js/jquery.hotkeys.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/bootstrap-wysiwyg.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/bootstrap-wysiwyg-custom.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/moment.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/bootstrap-colorpicker.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/daterangepicker.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/bootstrap-datepicker.js') }}" ></script>
  <!-- ck editor -->
  <script type="text/javascript" src="{{ asset('bibliotecas/ckeditor/ckeditor.js') }}" ></script>
  <!-- custom form component script for this page-->
  <script src="{{ asset('admin_assets/js/form-component.js') }}" ></script>

  <!-- jquery validate js -->
  <script type="text/javascript" src="{{ asset('admin_assets/js/jquery.validate.min.js') }}" ></script>

  <!-- custom form validation script for this page-->
  <script src="{{ asset('admin_assets/js/form-validation-script.js') }}" ></script>

  <!--custome script for all page-->
  <script src="{{ asset('admin_assets/js/scripts.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/script_noticia.js') }}" ></script>


</body>

</html>
