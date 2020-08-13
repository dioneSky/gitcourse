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

    <title>Captura | Lista</title>

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
    <link href="{{ asset('admin_assets/css/style_produto.css') }}"  rel="stylesheet">
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
                        <li><i class="fa fa-image"></i><a href="/cpanel/admin/captura/lista?menu=captura" >Captura recente</a></li>
                        <li><i class="fa fa-bars"></i>Lista</li>

                    </ol>
                </div>

                <div class="col-lg-8">

                    @include('layouts/admin/botao_accao_geral')

                </div>

            </div>

            {{--          <div class="course-warp">--}}

            <div class="row course-items-area">

                <div class="col-lg-12">
                    <section class="panel">

                        <table class="table table-striped table-advance table-hover">
                            <tbody>
                            <a id="button_excel" consultar="{{ isset($request)?1:-1 }}" class="btn td_bg_success">
                                <i class="fa fa-file-excel-o"></i> - Excel
                            </a>
                            <a id="button_pdf" estado="0" class="btn  td_bg_danger">
                                <i class="fa fa-file-pdf-o"></i> - PDF
                            </a>
                            <tr>
                                <th id="select_carrinhos" class="text-primary"><i class="fa fa-check-circle text-dark"></i></th>
                                <th id="select_carrinhos" class="text-primary">#</th>
                                <th colspan="2" class="text-primary"><i class="fa fa-list text-dark"></i> EMBARCAÇÃO</th>
                                <th class="text-primary"><i class="fa fa-calendar text-dark"></i>DATA</th>
                                <th class="text-primary"><i class="fa fa-calendar text-dark"></i> HR INICIO</th>
                                <th class="text-primary"><i class="fa fa-calendar text-dark"></i> HR FINAL</th>
                                <th class="text-primary" align="left"><i class="fa fa-list text-dark"></i> SONDA</th>
                                <th class="text-primary" align="left"><i class="fa fa-list text-dark"></i> LAT 1</th>
                                <th class="text-primary" align="left"><i class="fa fa-list text-dark"></i> LONG 1</th>
                                <th class="text-primary" align="left"><i class="fa fa-list text-dark"></i> LAT 2</th>
                                <th class="text-primary" align="left"><i class="fa fa-list text-dark"></i> LONG 2</th>
                                <th class="text-primary" align="left"><i class="fa fa-inbox text-dark"></i>ESPECIE</th>
                                <th class="text-primary" align="left"><i class="fa fa-inbox text-dark"></i>QTD</th>
                                <th class="text-primary"><i class="fa fa-cogs text-dark"></i> OPERAÇÕES</th>
                            </tr>

                            @if(count($capturas_array))

                                @foreach($capturas_array as  $key => $captura)

                                    <tr>
                                        <td>
                                            @if($key+1<count($capturas_array))
                                            <input  name="sample-checkbox-01"   class="check_conjunto_seleccionavel" id="checkbox-01" value="1" type="checkbox" captura_id="{{ $captura['id'] }}"  />
                                            @endif
                                        </td>
                                        <td>
                                            {{ $captura['num']}}
                                        </td>
                                        <td colspan="2">
                                            {{ $captura['embarcacao_nome'] }}
                                        </td>
                                        <td align="left" class="td_editavel td_deposito" captura_id="{{ $captura['id'] }}" >
                                            {{ $captura['data'] }}
                                        </td>
                                        <td class="td_editavel td_data" captura_id="{{ $captura['id'] }}">
                                            {{ $captura['hr_inicio'] }}
                                        </td>
                                        <td align="left" title="">
                                            {{ $captura['hr_final'] }}
                                        </td>
                                        <td align="left">
                                            {{ number_format($captura['sonda'],2,',','.') }}
                                        </td>
                                        <td align="left">
                                            {{    $captura['lat1'] }}
                                        </td>
                                        <td align="left">
                                            {{    $captura['long1'] }}
                                        </td>
                                        <td align="left">
                                            {{    $captura['lat2'] }}
                                        </td>
                                        <td align="left">
                                            {{   $captura['long2'] }}
                                        </td>
                                        <td align="left" class="td_editavel td_deposito" captura_id="{{ $captura['id'] }}" >
                                            {{ $captura['especie_nome'] }}
                                        </td>
                                        <td align="left"  class="{{ $key==count($capturas_array)-1?' td_bg_info ':' ' }}">
                                            {{    number_format($captura['qtd'],2,',','.') }}
                                        </td>
                                        <td>
                                            @if($key+1<count($capturas_array))
                                            <div class="btn-group">
                                                <a class="btn btn-info editar_captura" captura="{{ $captura['captura_object_string'] }}" ><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger remover_captura" captura_id="{{ $captura['id'] }}" ><i class="fa fa-trash-o"></i></a>
                                            </div>
                                            @endif

                                        </td>

                                    </tr>

                                @endforeach

                                @endif

                                @if(count($capturas_array))

                                @else

                                    <tr>
                                        <td align="center" colspan="14">Nenhum registo foi encontrado</td>
                                    </tr>

                                @endif

                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <!--main content end-->

            <!-- <form action="/cpanel/admin/captura/filtro_android" method="post" >
                @csrf
                <input type="text" value="01-07-2020" name="data1" />
                <input type="text" value="31-07-2020" name="data2" />
                <input type="text" value="" name="pesquisa" />
                <input type="submit" value="enviar" />

            </form> -->


            <!-- Start modal processar entrada -->

            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal-2" class="modal fade modal-800">
                <div class="modal-dialog ">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title text-secondary">Processar entrada de Captura</h4>
                        </div>

                        <div class="modal-body">

                            <form id="register_form" >
                                @csrf

                                <table class="table table-striped table-advance table-hover">
                                    <tbody>
                                            <tr title="A data deve ter ano-mes-dia ou dia-mes-ano">
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="data">DATA</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="data" name="data" value="" type="date"  />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td align="left">
                                                    <label class="control-label col-lg-2" for="embarcacao_id">EMBARCAÇÃO</label>
                                                </td>
                                                <td align="left">
                                                            <select class="form-control m-bot15" id="embarcacao_id" name="embarcacao_id">

                                                            <option  value="-1"> - || - </option>

                                                                @if(count($embarcacoes))

                                                                        @foreach($embarcacoes as $embarcacao)

                                                                            <option  value="{{ $embarcacao->id }}">{{ $embarcacao->nome }}</option>

                                                                        @endforeach

                                                                    @endif                                                         

                                                            </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left">
                                                    <label class="control-label col-lg-2" for="especie">ESPECIE</label>
                                                </td>
                                                <td align="left">
                                                            <select class="form-control m-bot15" id="especie" name="especie">

                                                            <option  value="-1"> - || - </option>

                                                                @if(count($produtos))

                                                                        @foreach($produtos as $produto)

                                                                            <option  value="{{ $produto->id }}">{{ $produto->nome }}</option>

                                                                        @endforeach

                                                                    @endif                                                         

                                                            </select>
                                                </td>
                                            </tr>
                                            <tr title="A quantidade tem o formato numerico, para casas decimais pode usar virgula com duas casas decimais apenas">
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="qtd">QUANTIDADE (Kg)</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="qtd" name="qtd" value="" type="number" step=".01"   />
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="hr_inicio">HORA INICIO</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="hr_inicio" name="hr_inicio" value="" type="time"  />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="hr_final">HORA FINAL</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="hr_final" name="hr_final" value="" type="time"  />
                                                </td>
                                            </tr>
                                            <tr title="A sonda tem o formato numerico, para casas decimais pode usar virgula com duas casas decimais apenas">
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="sonda">SONDA</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="sonda" name="sonda" value="" type="number" step=".01"   />
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="latitude1">LATITUDE 1</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="latitude1" name="latitude1" value="" type="text" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="longitude1">LONGITUDE 1</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="longitude1" name="longitude1" value="" type="text" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="latitude2">LATITUDE 2</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="latitude2" name="latitude2" value="" type="text" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left">
                                                    <label class="control-label col-sm-12" for="longitude2">LONGITUDE 2</label>
                                                </td>
                                                <td align="left">
                                                    <input class=" form-control" id="longitude2" name="longitude2" value="" type="text" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="right">
                                               
                                                    <input type="hidden" id="data1_hidden" value="{{ (isset($request) && $request->chk_data!=null)?$request->data1:date('Y-m-d') }}" />
                                                    <input type="hidden" id="data2_hidden" value="{{ (isset($request) && $request->chk_data!=null)?$request->data2:date('Y-m-d') }}" />
                                                    
                                                    <input class="form-control " id="hidden_id" name="hidden_id" type="hidden" value="-1" />

                                                    <input type="submit" id="btn_submeter_captura" class="btn btn-info w-100" value="SALVAR" />
                                                </td>
                                            </tr>

                                    </tbody>
                                </table>

                            </form>

                        </div>

                    </div>
                </div>
            </div>

            <!-- End modal processar entrada  -->


            <!-- Start modal consultar entradas -->

            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="modal_consultar" class="modal fade modal-900">
                <div class="modal-dialog ">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                            <h4 class="modal-title text-secondary">FILTRAR CAPTURAS</h4>
                        </div>

                        <div class="modal-body">

                            <form id="consultar_entrada_form" action="/cpanel/admin/captura/consultar?menu=captura" method="post">
                            
                            @csrf

                            <table class="table table-striped table-advance table-hover">
                                <tbody>
                                        <tr>
                                            <td>
                                                <label class="control-label col-sm-12" for="embarcacao_filtro">Embarcação</label>
                                            </td>
                                            <td>
                                            <select class="form-control m-bot15" id="embarcacao_filtro" name="embarcacao_filtro">

                                                <option  value="-1"> - || - </option>

                                                    @if(count($embarcacoes))

                                                            @foreach($embarcacoes as $embarcacao)

                                                                <option  {{ (isset($request) && $request->embarcacao_filtro==$embarcacao->id)?' selected ':'' }}  value="{{ $embarcacao->id }}">{{ $embarcacao->nome }}</option>

                                                            @endforeach

                                                        @endif                                                         

                                                </select>
                                            </td>
                                            <td>
                                                <input  name="chk_embarcacao"   class="chk_filtro_consultar" id="chk_embarcacao" {{ (isset($request) && !$request->chk_embarcacao==null)?'checked':'' }} type="checkbox"    />
                                            <td>
                                        </tr>
                                        <tr>

                                        <td align="left">
                                            <label class="control-label col-lg-2" for="especie_filtro">Especie</label>
                                        </td>

                                        <td align="left">                                                       
                                                <select class="form-control m-bot15" id="especie_filtro" name="especie_filtro">

                                                <option  value="-1"> - || - </option>

                                                    @if(count($produtos))

                                                            @foreach($produtos as $produto)

                                                                <option {{ (isset($request) && $request->especie_filtro==$produto->id)?' selected ':'' }} value="{{ $produto->id }}">{{ $produto->nome }}</option>

                                                            @endforeach

                                                        @endif                                                         

                                                </select>

                                        </td>
                                        <td>
                                            <input  name="chk_especie"   class="chk_filtro_consultar" id="chk_especie"  {{ (isset($request) && !$request->chk_especie==null)?'checked':'' }} type="checkbox"  />
                                        <td>
                                        </tr>

                                        <tr>                                        
                                            <td align="left">
                                                <label class="control-label col-sm-12" for="data1">Data </label>
                                            </td>

                                            <td align="left">
                                                <input class=" form-filtro-input" id="data1" name="data1" class="date_input" value="{{ (isset($request) && $request->chk_data!=null)?$request->data1:date('Y-m-d') }}" type="date" />
                                                <label class="control-label">
                                                    á
                                                </label>
                                                <input class=" form-filtro-input" id="data2" name="data2" class="date_input" value="{{ (isset($request) && $request->chk_data!=null)?$request->data2:date('Y-m-d') }}" type="date" />
                                            </td>

                                            <td>
                                                <input  name="chk_data"   class="chk_filtro_consultar" id="chk_data" value="1"  {{ (isset($request) && !$request->chk_data==null)?'checked':'' }} type="checkbox"   />
                                            <td>

                                        </tr>

                                        <tr>
                                            <td align="left">
                                                <label class="control-label col-sm-12" for="qtd1">Quantidade</label>
                                            </td>
                                            <td align="left">
                                                <input class=" form-filtro-input" id="qtd1" name="qtd1" value="{{ isset($request)?$request->qtd1:0 }}" type="number" step=".01"   />
                                                <label class="control-label" for="qtd2">
                                                    á
                                                </label>
                                                <input class=" form-filtro-input" id="qtd2" name="qtd2" value="{{ isset($request)?$request->qtd2:0 }}" type="number" step=".01"   />
                                            </td>
                                            <td>
                                                <input  name="chk_qtd"   class="chk_filtro_consultar" id="chk_qtd" {{ (isset($request) && !$request->chk_qtd==null)?'checked':'' }} type="checkbox"   />
                                            <td>
                                        </tr>  


                                        <tr>
                                            <td align="left">
                                                <label class="control-label col-sm-12" for="sonda1">Sonda</label>
                                            </td>
                                            <td align="left">
                                                <input class=" form-filtro-input" id="sonda1" name="sonda1" value="{{ isset($request)?$request->sonda1:0 }}" type="number" step=".01"   />
                                                <label class="control-label" for="sonda2">
                                                    á
                                                </label>
                                                <input class=" form-filtro-input" id="sonda2" name="sonda2" value="{{ isset($request)?$request->sonda2:0 }}" type="number" step=".01"   />
                                            </td>
                                            <td>
                                                <input  name="chk_sonda"   class="chk_filtro_consultar" id="chk_sonda" {{ (isset($request) && !$request->chk_sonda==null)?'checked':'' }} type="checkbox"   />
                                            <td>
                                        </tr>  


                                        <tr>
                                            <td align="left">
                                                <label class="control-label col-sm-12" for="latitude">Lat. ou Long.</label>
                                            </td>
                                            <td align="left">
                                                <input class="form-control" id="latitude" name="latitude" value="{{ isset($request)?$request->latitude:0 }}" type="text"  />
                                            </td>
                                            <td>
                                                <input  name="chk_latitude"   class="chk_filtro_consultar" id="chk_latitude" {{ (isset($request) && !$request->chk_latitude==null)?'checked':'' }} type="checkbox"   />
                                            <td>
                                        </tr>                                      

                                        <tr>
                                            <td colspan="3" align="right">
                                                <input type="hidden" id="data1_hidden" value="{{ (isset($request) && $request->chk_data!=null)?$request->data1:date('Y-m-d') }}" />
                                                <input type="hidden" id="data2_hidden" value="{{ (isset($request) && $request->chk_data!=null)?$request->data2:date('Y-m-d') }}" />
                                                <input type="hidden" id="consulta_hidden" name="consulta" value="{{ (isset($request))?1:0 }}" />

                                                <input type="submit" class="btn btn-info m-3" id="btn_consultar_captura" value="CONSULTAR" />
                                            </td>
                                        </tr>


                                </tbody>
                            </table>

                            </form>

                        </div>

                    </div>
                </div>
            </div>

            <!-- End modal consultar entradas -->



            <input type="hidden" id="tipo_accao_formulario" value="1" />
            <input type="hidden" id="captura" value="1" />

        </section>
    </section>
</section>
<!-- container section end -->
<!-- javascripts -->

   <!-- container section end -->
  <!-- javascripts -->
  <script src="{{ asset('admin_assets/js/jquery.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/bootstrap.min.js') }}" ></script>
  <!-- nice scroll -->
  <script src="{{ asset('admin_assets/js/jquery.scrollTo.min.js') }}" ></script>
  <script src="{{ asset('admin_assets/js/jquery.nicescroll.js') }}"  type="text/javascript"></script>
<!--custome script for all page-->
<script src="{{ asset('admin_assets/js/scripts.js') }}" ></script>
<script src="{{ asset('admin_assets/js/script_captura.js') }}" ></script>
<script src="{{ asset('assets/js/moment.js') }}" ></script>


</body>

</html>
