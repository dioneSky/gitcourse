<?php

namespace App\Http\Controllers;

use App\Captura;
use App\Exports\CapturaExport;
use App\Exports\CapturaPorEmbarcacaoExport;
use App\Exports\CapturaPorEspecieExport;
use App\Exports\CapturaAnualPorEntidadeExport;
use App\Embarcacao;
use App\Produto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use File;
use Maatwebsite\Excel\Facades\Excel;

class CapturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            $data1 = "".date("Y")."-".date("m")."-01"."";
            $data2 = "".date("Y")."-".date("m")."-31"."";

            $capturas = Captura::where('id','>','0')->take(100)->orderBy('data','desc')->get();
            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;
            

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $embarcacao_nome = $embarcacoes->find($captura->embarcacao_id)->nome;
                $especie_nome = $produtos->find($captura->especie)->nome;

                $total = $total + $captura->qtd;

                array_push($capturas_array, ['num' => $key+1,
                        'id' => $captura->id,
                        'data' => $captura->data,
                        'hr_inicio' => $captura->hr_inicio,
                        'hr_final' => $captura->hr_final,
                        'sonda' => $captura->sonda,
                        'lat1' => $captura->latitude1,
                        'long1' => $captura->longitude1,
                        'lat2' => $captura->latitude2,
                        'long2' => $captura->longitude2,
                        'especie' => $captura->especie,
                        'especie_nome' => $especie_nome,
                        'qtd' => $captura->qtd,
                        'embarcacao_id' => $captura->embarcacao_id,
                        'embarcacao_nome' => $embarcacao_nome,
                        'captura_object_string' => $captura
                    ]
                );

            }

            array_push($capturas_array, ['num' => '',
            'id' => '',
            'data' => '',
            'hr_inicio' => '',
            'hr_final' => '',
            'sonda' => '0',
            'lat1' => '',
            'long1' => '',
            'lat2' => '',
            'long2' => '',
            'especie' => '',
            'especie_nome' => '',
            'qtd' => $total,
            'embarcacao_id' => '',
            'embarcacao_nome' => ''
                ]
            );

            return view('/layouts/admin/captura_lista', compact('capturas','embarcacoes','capturas_array','data1','data2','consulta','embarcacoes','produtos'));
        }
    }

    public function app_captura_lista()
    {
        $data1 = "".date("Y")."-".date("m")."-01"."";
            $data2 = "".date("Y")."-".date("m")."-31"."";

            $capturas = Captura::where('id','>','0')->take(100)->orderBy('data','desc')->get();
            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;
            

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $embarcacao_nome = $embarcacoes->find($captura->embarcacao_id)->nome;
                $especie_nome = $produtos->find($captura->especie)->nome;

                $total = $total + $captura->qtd;

                array_push($capturas_array, [
                        'id' => $captura->id,
                        'data' => $captura->data,
                        'hr_inicio' => $captura->hr_inicio,
                        'hr_final' => $captura->hr_final,
                        'sonda' => $captura->sonda,
                        'latitude1' => $captura->latitude1,
                        'longitude1' => $captura->longitude1,
                        'latitude2' => $captura->latitude2,
                        'longitude2' => $captura->longitude2,
                        'especie' => $produtos->find($captura->especie),
                        'embarcacao' => $embarcacoes->find($captura->embarcacao_id),
                        'qtd' => $captura->qtd,
                        'created_at' => $captura->created_at,
                        'updated_at' => $captura->updated_at
                    ]
                );

            }


        return $capturas_array;
    }

    public function app_especie_lista()
    {
        $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
        $especie_array = array();

        if(count($produtos))
        foreach($produtos as $key => $produto)
        {
            array_push($especie_array, [
                    'id' => $produto->id,
                    'nome' => $produto->nome,
                    'descricacao_curta' => $produto->descricacao_curta,
                    'descricacao_longa' => $produto->descricacao_longa,
                    'preco' => $produto->preco,
                    'disponivel' => $produto->disponivel,
                    'pontuacao' => $produto->pontuacao,
                    'imagem' => $produto->imagem,
                    'galeria' => $produto->galeria,
                    'estado' => $produto->estado
                ]
            );

        }


        return $especie_array;
    }

    public function filtro_android(Request $request)
    {
            $data1 = $request->data1; 
            $data2 = $request->data2;
            $pesquisa = $request->pesquisa;

            $primeira_data = explode("-", $data1);
            $dia1 = $primeira_data[2];
            $mes1 = $primeira_data[1];
            $ano1 = $primeira_data[0];

            $segunda_data = explode("-", $data2);
            $dia2 = $segunda_data[2];
            $mes2 = $segunda_data[1];
            $ano2 = $primeira_data[0];

            $data1 = $ano1.'-'.$mes1.'-'.$dia1;
            $data2 = $ano2.'-'.$mes2.'-'.$dia2;

            $capturas =  DB::select('SELECT * FROM captura where (data>=\''.$data1.'\' and data<=\''.$data2.'\') ORDER BY data desc');

            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;
            
            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $embarcacao_nome = $embarcacoes->find($captura->embarcacao_id)->nome;
                $especie_nome = $produtos->find($captura->especie)->nome;

                if($pesquisa == '' || (strpos(strtoupper($especie_nome), strtoupper($pesquisa)) !== false || strpos(strtoupper($embarcacao_nome), strtoupper($pesquisa)) !== false || strpos(strtoupper($captura->sonda), strtoupper($pesquisa)) !== false))
                {
                    $total = $total + $captura->qtd;

                    array_push($capturas_array, [
                            'id' => $captura->id,
                            'data' => $captura->data,
                            'hr_inicio' => $captura->hr_inicio,
                            'hr_final' => $captura->hr_final,
                            'sonda' => $captura->sonda,
                            'latitude1' => $captura->latitude1,
                            'longitude1' => $captura->longitude1,
                            'latitude2' => $captura->latitude2,
                            'longitude2' => $captura->longitude2,
                            'especie' => $produtos->find($captura->especie),
                            'embarcacao' => $embarcacoes->find($captura->embarcacao_id),
                            'qtd' => $captura->qtd,
                            'created_at' => '2020-01-01',
                            'updated_at' => '2020-01-01'
                        ]
                    );
    
                }

            }


        return $capturas_array;
    }

    public function containsWord($str, $word)
    {
        return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
    }

    public function consultar(Request $request)
    {
        if (Auth::guest()) {
            return redirect('cpanel/admin/login');
        }
        else
        {
            if($request->chk_embarcacao==null)
            {
                $request->embarcacao_filtro = 'embarcacao_id';
            }
            else $consulta = 1;

            if($request->chk_especie==null)
            {
                $request->especie_filtro = 'especie';
            }
            else $consulta = 1;

            if($request->chk_sonda==null)
            {
                $request->sonda1 = 'sonda';
                $request->sonda2 = 'sonda';
            }
            else $consulta = 1;

            if($request->chk_qtd==null)
            {
                $request->qtd1 = 'qtd';
                $request->qtd2 = 'qtd';
            }
            else $consulta = 1;

            if($request->chk_data==null)
            {
                $request->data1 = 'data';
                $request->data2 = 'data';
            }
            else
            {
                $request->data1 = "'".$request->data1."'";
                $request->data2 = "'".$request->data2."'";
                $consulta = 1;
            }

            if($request->chk_latitude==null)
            {
                $request->latitude = '';
            }
            else $consulta = 1;
            
            $capturas =  DB::select('SELECT * FROM captura where especie='.$request->especie_filtro.' AND embarcacao_id='.$request->embarcacao_filtro.' AND (data>='.$request->data1.' and data<='.$request->data2.') and (sonda>='.$request->sonda1.' and sonda<='.$request->sonda2.') and (latitude1 like "%'.$request->latitude.'%" OR latitude2 like "%'.$request->latitude.'%" OR longitude1 like "%'.$request->latitude.'%" OR longitude2 like "%'.$request->latitude.'%") ORDER BY data desc');

            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;            

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $embarcacao_nome = $embarcacoes->find($captura->embarcacao_id)->nome;
                $especie_nome = $produtos->find($captura->especie)->nome;

                $total = $total + $captura->qtd;

                array_push($capturas_array, ['num' => $key+1,
                        'id' => $captura->id,
                        'data' => $captura->data,
                        'hr_inicio' => $captura->hr_inicio,
                        'hr_final' => $captura->hr_final,
                        'sonda' => $captura->sonda,
                        'lat1' => $captura->latitude1,
                        'long1' => $captura->longitude1,
                        'lat2' => $captura->latitude2,
                        'long2' => $captura->longitude2,
                        'especie' => $captura->especie,
                        'especie_nome' => $especie_nome,
                        'qtd' => $captura->qtd,
                        'embarcacao_id' => $captura->embarcacao_id,
                        'embarcacao_nome' => $embarcacao_nome,
                        'captura_object_string' => json_encode($captura)
                    ]
                );

            }

            array_push($capturas_array, ['num' => '',
            'id' => '',
            'data' => '',
            'hr_inicio' => '',
            'hr_final' => '',
            'sonda' => '0',
            'lat1' => '',
            'long1' => '',
            'lat2' => '',
            'long2' => '',
            'especie' => '',
            'especie_nome' => '',
            'qtd' => $total,
            'embarcacao_id' => '',
            'embarcacao_nome' => ''
                ]
            );

            return view('/layouts/admin/captura_lista', compact('capturas','embarcacoes','capturas_array','consulta','embarcacoes','produtos','request'));
           
        }
    }

    public function excel_capturas(Request $request)
    {
        if (Auth::guest()) {
            return redirect('cpanel/admin/login');
        }
        else
        {
            if($request->chk_embarcacao==null)
            {
                $request->embarcacao_filtro = 'embarcacao_id';
            }
            else $consulta = 1;

            if($request->chk_especie==null)
            {
                $request->especie_filtro = 'especie';
            }
            else $consulta = 1;

            if($request->chk_sonda==null)
            {
                $request->sonda1 = 'sonda';
                $request->sonda2 = 'sonda';
            }
            else $consulta = 1;

            if($request->chk_qtd==null)
            {
                $request->qtd1 = 'qtd';
                $request->qtd2 = 'qtd';
            }
            else $consulta = 1;

            if($request->chk_data==null)
            {
                $request->data1 = 'data';
                $request->data2 = 'data';
            }
            else
            {
                $request->data1 = "'".$request->data1."'";
                $request->data2 = "'".$request->data2."'";
                $consulta = 1;
            }

            if($request->chk_latitude==null)
            {
                $request->latitude = '';
            }
            else $consulta = 1;
            
            if($request->consulta==1)
                $capturas =  DB::select('SELECT * FROM captura where especie='.$request->especie_filtro.' AND embarcacao_id='.$request->embarcacao_filtro.' AND (data>='.$request->data1.' and data<='.$request->data2.') and (sonda>='.$request->sonda1.' and sonda<='.$request->sonda2.') and (latitude1 like "%'.$request->latitude.'%" OR latitude2 like "%'.$request->latitude.'%" OR longitude1 like "%'.$request->latitude.'%" OR longitude2 like "%'.$request->latitude.'%") ORDER BY data desc');
            else
                $capturas = Captura::where('id','>','0')->take(100)->orderBy('data','desc')->get(); 

            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;            

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $embarcacao_nome = $embarcacoes->find($captura->embarcacao_id)->nome;
                $especie_nome = $produtos->find($captura->especie)->nome;

                $total = $total + $captura->qtd;

                array_push($capturas_array, ['num' => $key+1,
                        'embarcacao_nome' => $embarcacao_nome,
                        'data' => $captura->data,
                        'hr_inicio' => $captura->hr_inicio,
                        'hr_final' => $captura->hr_final,
                        'sonda' => $captura->sonda,
                        'lat1' => $captura->latitude1,
                        'long1' => $captura->longitude1,
                        'lat2' => $captura->latitude2,
                        'long2' => $captura->longitude2,
                        'especie_nome' => $especie_nome,
                        'qtd' => $captura->qtd
                    ]
                );

            }

            array_push($capturas_array, ['num' => '',
            'embarcacao_nome' => '',
                        'data' => '',
                        'hr_inicio' => '',
                        'hr_final' => '',
                        'sonda' => '',
                        'lat1' => '',
                        'long1' => '',
                        'lat2' => '',
                        'long2' => '',
                        'especie_nome' => '',
                        'qtd' => $total
                ]
            );

            $export = new CapturaExport($capturas_array);

            return Excel::download($export,'Capturas.xlsx');

        }
    }

    public function captura_por_embarcacao()
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            $data1 = "'".date("Y")."-".date("m")."-01"."'";
            // $data1 = "'2020-1-1'";
            // $data2 = "'2020-6-31'";
            $data2 = "'".date("Y")."-".date("m")."-31"."'";

            $capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where (data>='.$data1.' and data<='.$data2.') GROUP BY embarcacao_id');
            //$capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where especie='.$request->especie_filtro.' AND embarcacao_id='.$request->embarcacao_filtro.' AND (data>='.$request->data1.' and data<='.$request->data2.') and (sonda>='.$request->sonda1.' and sonda<='.$request->sonda2.') and (latitude1 like "%'.$request->latitude.'%" OR latitude2 like "%'.$request->latitude.'%" OR longitude1 like "%'.$request->latitude.'%" OR longitude2 like "%'.$request->latitude.'%") ORDER BY data desc');

            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $embarcacao_nome = $embarcacoes->find($captura->embarcacao_id)->nome;
                $total = $total + $captura->total;

                array_push($capturas_array, ['num' => $key+1,
                        'embarcacao_id' => $captura->embarcacao_id,
                        'embarcacao_nome' => $embarcacao_nome,
                        'total' => $captura->total
                    ]
                );

            }

            array_push($capturas_array, ['num' => '',
                        'embarcacao_id' => '',
                        'embarcacao_nome' => '',
                        'total' => $total
                    ]
                );


            return view('/layouts/admin/captura_por_embarcacao', compact('capturas','embarcacoes','capturas_array','data1','data2','consulta','embarcacoes','produtos'));
        }

    }

    public function consultar_captura_por_embarcacao(Request $request)
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            if($request->chk_embarcacao==null)
            {
                $request->embarcacao_filtro = 'embarcacao_id';
            }
            else $consulta = 1;

            if($request->chk_especie==null)
            {
                $request->especie_filtro = 'especie';
            }
            else $consulta = 1;

            if($request->chk_sonda==null)
            {
                $request->sonda1 = 'sonda';
                $request->sonda2 = 'sonda';
            }
            else $consulta = 1;

            if($request->chk_qtd==null)
            {
                $request->qtd1 = 'qtd';
                $request->qtd2 = 'qtd';
            }
            else $consulta = 1;

            if($request->chk_data==null)
            {
                $request->data1 = 'data';
                $request->data2 = 'data';
                $data1 = date('Y-m-')."01";
                $data2 = date('Y-m-d')."31";
            }
            else
            {
                $data1 = $request->data1;
                $data2 = $request->data2;
                $request->data1 = "'".$request->data1."'";
                $request->data2 = "'".$request->data2."'";
                $consulta = 1;
            }

            if($request->chk_latitude==null)
            {
                $request->latitude = '';
            }
            else $consulta = 1;
            

            //$capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where (data>='.$data1.' and data<='.$data2.') GROUP BY embarcacao_id');
            $capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where especie='.$request->especie_filtro.' AND embarcacao_id='.$request->embarcacao_filtro.' AND (data>='.$request->data1.' and data<='.$request->data2.') and (sonda>='.$request->sonda1.' and sonda<='.$request->sonda2.') and (latitude1 like "%'.$request->latitude.'%" OR latitude2 like "%'.$request->latitude.'%" OR longitude1 like "%'.$request->latitude.'%" OR longitude2 like "%'.$request->latitude.'%") GROUP BY embarcacao_id');

            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $embarcacao_nome = $embarcacoes->find($captura->embarcacao_id)->nome;
                $total = $total + $captura->total;

                array_push($capturas_array, ['num' => $key+1,
                        'embarcacao_id' => $captura->embarcacao_id,
                        'embarcacao_nome' => $embarcacao_nome,
                        'total' => $captura->total
                    ]
                );

            }

            array_push($capturas_array, ['num' => '',
                        'embarcacao_id' => '',
                        'embarcacao_nome' => '',
                        'total' => $total
                    ]
                );


            return view('/layouts/admin/captura_por_embarcacao', compact('capturas','embarcacoes','capturas_array','data1','data2','consulta','embarcacoes','produtos','request'));
        }

    }

    public function excel_consultar_captura_por_embarcacao(Request $request)
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            if($request->chk_embarcacao==null)
            {
                $request->embarcacao_filtro = 'embarcacao_id';
            }
            else $consulta = 1;

            if($request->chk_especie==null)
            {
                $request->especie_filtro = 'especie';
            }
            else $consulta = 1;

            if($request->chk_sonda==null)
            {
                $request->sonda1 = 'sonda';
                $request->sonda2 = 'sonda';
            }
            else $consulta = 1;

            if($request->chk_qtd==null)
            {
                $request->qtd1 = 'qtd';
                $request->qtd2 = 'qtd';
            }
            else $consulta = 1;

            if($request->chk_data==null)
            {
                $request->data1 = 'data';
                $request->data2 = 'data';
                $data1 = date('Y-m-')."01";
                $data2 = date('Y-m-d')."31";
            }
            else
            {
                $data1 = $request->data1;
                $data2 = $request->data2;
                $request->data1 = "'".$request->data1."'";
                $request->data2 = "'".$request->data2."'";
                $consulta = 1;
            }

            if($request->chk_latitude==null)
            {
                $request->latitude = '';
            }
            else $consulta = 1;
            

            if($request->consulta==1)
                $capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where especie='.$request->especie_filtro.' AND embarcacao_id='.$request->embarcacao_filtro.' AND (data>='.$request->data1.' and data<='.$request->data2.') and (sonda>='.$request->sonda1.' and sonda<='.$request->sonda2.') and (latitude1 like "%'.$request->latitude.'%" OR latitude2 like "%'.$request->latitude.'%" OR longitude1 like "%'.$request->latitude.'%" OR longitude2 like "%'.$request->latitude.'%") GROUP BY embarcacao_id');
            else
            {
                $data1 = "'".date("Y")."-".date("m")."-01"."'";
                // $data1 = "'2020-1-1'";
                // $data2 = "'2020-6-31'";
                $data2 = "'".date("Y")."-".date("m")."-31"."'";
    
                $capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where (data>='.$data1.' and data<='.$data2.') GROUP BY embarcacao_id');
     
            }
               
            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $embarcacao_nome = $embarcacoes->find($captura->embarcacao_id)->nome;
                $total = $total + $captura->total;

                array_push($capturas_array, ['num' => $key+1,
                        'embarcacao_nome' => $embarcacao_nome,
                        'data_inicio' => $data1,
                        'data_fim' => $data2,
                        'total' => $captura->total
                    ]
                );

            }

            array_push($capturas_array, ['num' => '',
                    'embarcacao_nome' => '',
                    'data_inicio' => '',
                    'data_fim' => '',
                    'total' => $total
                    ]
                );


                $export = new CapturaPorEmbarcacaoExport($capturas_array);

                return Excel::download($export,'Capturas_por_embarcacao.xlsx');
        }

    }

    public function captura_por_especie()
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            $data1 = "'".date("Y")."-".date("m")."-01"."'";
            // $data1 = "'2020-1-1'";
            // $data2 = "'2020-6-31'";
            $data2 = "'".date("Y")."-".date("m")."-31"."'";

            $capturas =  DB::select('SELECT especie, sum(qtd) as total FROM captura where (data>='.$data1.' and data<='.$data2.') GROUP BY especie');
            //$capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where especie='.$request->especie_filtro.' AND embarcacao_id='.$request->embarcacao_filtro.' AND (data>='.$request->data1.' and data<='.$request->data2.') and (sonda>='.$request->sonda1.' and sonda<='.$request->sonda2.') and (latitude1 like "%'.$request->latitude.'%" OR latitude2 like "%'.$request->latitude.'%" OR longitude1 like "%'.$request->latitude.'%" OR longitude2 like "%'.$request->latitude.'%") ORDER BY data desc');

            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $especie_nome = $produtos->find($captura->especie)->nome;
                $total = $total + $captura->total;

                array_push($capturas_array, ['num' => $key+1,
                        'especie_id' => $captura->especie,
                        'especie_nome' => $especie_nome,
                        'total' => $captura->total
                    ]
                );
            }

            array_push($capturas_array, ['num' => '',
                        'especie_id' => '',
                        'especie_nome' => '',
                        'total' => $total
                    ]
                );


            return view('/layouts/admin/captura_por_especie', compact('capturas','embarcacoes','capturas_array','data1','data2','consulta','embarcacoes','produtos'));
        }

    }

    public function consultar_captura_por_especie(Request $request)
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            if($request->chk_embarcacao==null)
            {
                $request->embarcacao_filtro = 'embarcacao_id';
            }
            else $consulta = 1;

            if($request->chk_especie==null)
            {
                $request->especie_filtro = 'especie';
            }
            else $consulta = 1;

            if($request->chk_sonda==null)
            {
                $request->sonda1 = 'sonda';
                $request->sonda2 = 'sonda';
            }
            else $consulta = 1;

            if($request->chk_qtd==null)
            {
                $request->qtd1 = 'qtd';
                $request->qtd2 = 'qtd';
            }
            else $consulta = 1;

            if($request->chk_data==null)
            {
                $request->data1 = 'data';
                $request->data2 = 'data';
                $data1 = date('Y-m-')."01";
                $data2 = date('Y-m-d')."31";
            }
            else
            {
                $data1 = $request->data1;
                $data2 = $request->data2;
                $request->data1 = "'".$request->data1."'";
                $request->data2 = "'".$request->data2."'";
                $consulta = 1;
            }

            if($request->chk_latitude==null)
            {
                $request->latitude = '';
            }
            else $consulta = 1;
            

            //$capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where (data>='.$data1.' and data<='.$data2.') GROUP BY embarcacao_id');
            $capturas =  DB::select('SELECT especie, sum(qtd) as total FROM captura where especie='.$request->especie_filtro.' AND embarcacao_id='.$request->embarcacao_filtro.' AND (data>='.$request->data1.' and data<='.$request->data2.') and (sonda>='.$request->sonda1.' and sonda<='.$request->sonda2.') and (latitude1 like "%'.$request->latitude.'%" OR latitude2 like "%'.$request->latitude.'%" OR longitude1 like "%'.$request->latitude.'%" OR longitude2 like "%'.$request->latitude.'%") GROUP BY especie');

            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $especie_nome = $produtos->find($captura->especie)->nome;
                $total = $total + $captura->total;

                array_push($capturas_array, ['num' => $key+1,
                        'especie_nome' => $especie_nome,
                        'data_inicio' => $data1,
                        'data_fim' => $data2,
                        'total' => $captura->total
                    ]
                );
            }

            array_push($capturas_array, ['num' => '',
                        'especie_nome' => '',
                        'embarcacao_nome' => '',
                        'total' => $total
                    ]
                );


            return view('/layouts/admin/captura_por_especie', compact('capturas','embarcacoes','capturas_array','data1','data2','consulta','embarcacoes','produtos','request'));
        }

    }

    public function excel_consultar_captura_por_especie(Request $request)
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            if($request->chk_embarcacao==null)
            {
                $request->embarcacao_filtro = 'embarcacao_id';
            }
            else $consulta = 1;

            if($request->chk_especie==null)
            {
                $request->especie_filtro = 'especie';
            }
            else $consulta = 1;

            if($request->chk_sonda==null)
            {
                $request->sonda1 = 'sonda';
                $request->sonda2 = 'sonda';
            }
            else $consulta = 1;

            if($request->chk_qtd==null)
            {
                $request->qtd1 = 'qtd';
                $request->qtd2 = 'qtd';
            }
            else $consulta = 1;

            if($request->chk_data==null)
            {
                $request->data1 = 'data';
                $request->data2 = 'data';
                $data1 = date('Y-m-')."01";
                $data2 = date('Y-m-d')."31";
            }
            else
            {
                $data1 = $request->data1;
                $data2 = $request->data2;
                $request->data1 = "'".$request->data1."'";
                $request->data2 = "'".$request->data2."'";
                $consulta = 1;
            }

            if($request->chk_latitude==null)
            {
                $request->latitude = '';
            }
            else $consulta = 1;
            

            if($request->consulta==1)
                $capturas =  DB::select('SELECT especie, sum(qtd) as total FROM captura where especie='.$request->especie_filtro.' AND embarcacao_id='.$request->embarcacao_filtro.' AND (data>='.$request->data1.' and data<='.$request->data2.') and (sonda>='.$request->sonda1.' and sonda<='.$request->sonda2.') and (latitude1 like "%'.$request->latitude.'%" OR latitude2 like "%'.$request->latitude.'%" OR longitude1 like "%'.$request->latitude.'%" OR longitude2 like "%'.$request->latitude.'%") GROUP BY especie');
            else
            {
                $data1 = "'".date("Y")."-".date("m")."-01"."'";
                // $data1 = "'2020-1-1'";
                // $data2 = "'2020-6-31'";
                $data2 = "'".date("Y")."-".date("m")."-31"."'";
    
                $capturas =  DB::select('SELECT especie, sum(qtd) as total FROM captura where (data>='.$data1.' and data<='.$data2.') GROUP BY especie');
     
            }
               
            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $capturas_array = array();
            $contador = 0;

            if(count($capturas))
            foreach($capturas as $key => $captura)
            {
                $especie_nome = $produtos->find($captura->especie)->nome;
                $total = $total + $captura->total;

                array_push($capturas_array, ['num' => $key+1,
                        'especie_nome' => $especie_nome,
                        'data_inicio' => $data1,
                        'data_fim' => $data2,
                        'total' => $captura->total
                    ]
                );

            }

            array_push($capturas_array, ['num' => '',
                    'especie_nome' => '',
                    'data_inicio' => '',
                    'data_fim' => '',
                    'total' => $total
                    ]
                );


                $export = new CapturaPorEspecieExport($capturas_array);

                return Excel::download($export,'Capturas_por_especie.xlsx');
        }

    }

    public function captura_anual()
    {
        if (Auth::guest()) {
            return redirect('cpanel/admin/login');
        }
        else
        {
            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            $ano = date('Y');
            $contador = 0;

            $array_captura_anual = array();
            $janT=0; $fevT=0; $marT=0; $abrT=0; $maiT=0; $junT=0; $julT=0; $agoT=0; $setT=0; $outT=0; $novT=0; $dezT=0;

            if(count($produtos))
                foreach($produtos as $key => $produto)
                {
                    $jan = $this->total_por_mes_ano_categoria('01',$ano,'especie',$produto->id);
                    $fev = $this->total_por_mes_ano_categoria('02',$ano,'especie',$produto->id);
                    $mar = $this->total_por_mes_ano_categoria('03',$ano,'especie',$produto->id);
                    $abr = $this->total_por_mes_ano_categoria('04',$ano,'especie',$produto->id);
                    $mai = $this->total_por_mes_ano_categoria('05',$ano,'especie',$produto->id);
                    $jun = $this->total_por_mes_ano_categoria('06',$ano,'especie',$produto->id);
                    $jul = $this->total_por_mes_ano_categoria('07',$ano,'especie',$produto->id);
                    $ago = $this->total_por_mes_ano_categoria('08',$ano,'especie',$produto->id);
                    $set = $this->total_por_mes_ano_categoria('09',$ano,'especie',$produto->id);
                    $out = $this->total_por_mes_ano_categoria('10',$ano,'especie',$produto->id);
                    $nov = $this->total_por_mes_ano_categoria('11',$ano,'especie',$produto->id);
                    $dez = $this->total_por_mes_ano_categoria('12',$ano,'especie',$produto->id);

                    $janT = $janT + $jan; $fevT = $fevT + $fev; $marT = $marT + $mar; $abrT = $abrT + $abr; $maiT = $maiT + $mai; $junT = $junT + $jun;
                    $julT = $julT + $jul; $agoT = $agoT + $ago; $setT = $setT + $set; $outT = $outT + $out; $novT = $novT + $nov; $dezT = $dezT + $dez;

                    $soma_parceiro = $jan + $fev + $mar + $abr + $mai + $jun + $jul + $ago + $set + $out + $nov + $dez;

                    $contador = $contador + 1;

                    array_push($array_captura_anual, ['num' => $key+1,
                            'especie' => $produto->nome,
                            'jan' => $jan,
                            'fev' => $fev,
                            'mar' => $mar,
                            'abr' => $abr,
                            'mai' => $mai,
                            'jun' => $jun,
                            'jul' => $jul,
                            'ago' => $ago,
                            'set' => $set,
                            'out' => $out,
                            'nov' => $nov,
                            'dez' => $dez,
                            'total' => $soma_parceiro,
                        ]
                    );
                }

            $soma_parceiroT = $janT + $fevT + $marT + $abrT + $maiT + $junT + $julT + $agoT + $setT + $outT + $novT + $dezT;
            $contador = $contador + 1;

            array_push($array_captura_anual, ['num' => '',
                    'especie' => '',
                    'jan' => $janT,
                    'fev' => $fevT,
                    'mar' => $marT,
                    'abr' => $abrT,
                    'mai' => $maiT,
                    'jun' => $junT,
                    'jul' => $julT,
                    'ago' => $agoT,
                    'set' => $setT,
                    'out' => $outT,
                    'nov' => $novT,
                    'dez' => $dezT,
                    'total' => $soma_parceiroT,
                ]
            );

            return view('/layouts/admin/captura_anual', compact('array_captura_anual','consulta','embarcacoes','produtos','contador','ano'));
        }
    }

    public function total_anual_consulta(Request $request)
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            if($request->chk_embarcacao==null)
            {
                $request->embarcacao_filtro = 'id';
            }
            else $consulta = 1;

            if($request->chk_especie==null)
            {
                $request->especie_filtro = 'id';
            }
            else $consulta = 1;

            if($request->chk_data==null)
            {
                $request->data1 = 'data';
                $request->data2 = 'data';
                $data1 = date('Y-m-')."01";
                $data2 = date('Y-m-d')."31";
            }
            else
            {
                $data1 = $request->data1;
                $data2 = $request->data2;
                $request->data1 = "'".$request->data1."'";
                $request->data2 = "'".$request->data2."'";
                $consulta = 1;
            }
            
            $consulta = 1;
            $ano = $request->ano;

            if($request->tipo_filtro=='especie')
            {
                $produtos_lista =  DB::select('SELECT * FROM produto where id='.$request->especie_filtro.' ');
                $array_captura_anual = $this->array_captura_anual_por_especie($produtos,$ano,$request->tipo_filtro);
            }
            else
            {
                $embarcacao_lista =  DB::select('SELECT * FROM embarcacao where id='.$request->embarcacao_filtro.' ');
                $array_captura_anual = $this->array_captura_anual_por_embarcacao($embarcacao_lista,$ano,$request->tipo_filtro);
            }

            $contador = count($array_captura_anual);

            return view('/layouts/admin/captura_anual', compact('array_captura_anual','consulta','embarcacoes','produtos','contador','ano','request'));
        }
    }

    public function total_anual_consulta_excel(Request $request)
    {
        if (Auth::guest()) 
        {
            return redirect('cpanel/admin/login');
        }
        else
        {
            $embarcacoes = Embarcacao::where('id','>','0')->orderBy('nome','asc')->get();
            $produtos = Produto::where('id','>','0')->orderBy('nome','asc')->get();
            $consulta = 0;
            $total = 0;

            if($request->chk_embarcacao==null)
            {
                $request->embarcacao_filtro = 'id';
            }
            else $consulta = 1;

            if($request->chk_especie==null)
            {
                $request->especie_filtro = 'id';
            }
            else $consulta = 1;

            if($request->chk_data==null)
            {
                $request->data1 = 'data';
                $request->data2 = 'data';
                $data1 = date('Y-m-')."01";
                $data2 = date('Y-m-d')."31";
            }
            else
            {
                $data1 = $request->data1;
                $data2 = $request->data2;
                $request->data1 = "'".$request->data1."'";
                $request->data2 = "'".$request->data2."'";
                $consulta = 1;
            }
            
            $consulta = 1;
            $ano = $request->ano;

            if($request->tipo_filtro=='especie')
            {
                $produtos_lista =  DB::select('SELECT * FROM produto where id='.$request->especie_filtro.' ');
                $array_captura_anual = $this->array_captura_anual_por_especie($produtos,$ano,$request->tipo_filtro);
            }
            else
            {
                $embarcacao_lista =  DB::select('SELECT * FROM embarcacao where id='.$request->embarcacao_filtro.' ');
                $array_captura_anual = $this->array_captura_anual_por_embarcacao($embarcacao_lista,$ano,$request->tipo_filtro);
            }

            $contador = count($array_captura_anual);

            if($request->tipo_filtro=='especie')
            {
                $export = new CapturaAnualPorEntidadeExport($array_captura_anual);
                return Excel::download($export,'Capturas_anual_por_especie.xlsx');
            }
            else
            {
                $export = new CapturaAnualPorEntidadeExport($array_captura_anual);
                return Excel::download($export,'Capturas_anual_por_embarcacao.xlsx');
            }
            
        }
    }

    public function array_captura_anual_por_especie($especies_lista,$ano,$categoria)
    {
        $array_captura_anual = array();

        $janT=0; $fevT=0; $marT=0; $abrT=0; $maiT=0; $junT=0; $julT=0; $agoT=0; $setT=0; $outT=0; $novT=0; $dezT=0;

        $contador = 0;

        if(count($especies_lista))
            foreach($especies_lista as $key => $especie_lista)
            {
                $jan = $this->total_por_mes_ano_categoria('01',$ano,$categoria,$especie_lista->id);
                $fev = $this->total_por_mes_ano_categoria('02',$ano,$categoria,$especie_lista->id);
                $mar = $this->total_por_mes_ano_categoria('03',$ano,$categoria,$especie_lista->id);
                $abr = $this->total_por_mes_ano_categoria('04',$ano,$categoria,$especie_lista->id);
                $mai = $this->total_por_mes_ano_categoria('05',$ano,$categoria,$especie_lista->id);
                $jun = $this->total_por_mes_ano_categoria('06',$ano,$categoria,$especie_lista->id);
                $jul = $this->total_por_mes_ano_categoria('07',$ano,$categoria,$especie_lista->id);
                $ago = $this->total_por_mes_ano_categoria('08',$ano,$categoria,$especie_lista->id);
                $set = $this->total_por_mes_ano_categoria('09',$ano,$categoria,$especie_lista->id);
                $out = $this->total_por_mes_ano_categoria('10',$ano,$categoria,$especie_lista->id);
                $nov = $this->total_por_mes_ano_categoria('11',$ano,$categoria,$especie_lista->id);
                $dez = $this->total_por_mes_ano_categoria('12',$ano,$categoria,$especie_lista->id);

                $janT = $janT + $jan; $fevT = $fevT + $fev; $marT = $marT + $mar; $abrT = $abrT + $abr; $maiT = $maiT + $mai; $junT = $junT + $jun;
                $julT = $julT + $jul; $agoT = $agoT + $ago; $setT = $setT + $set; $outT = $outT + $out; $novT = $novT + $nov; $dezT = $dezT + $dez;

                $soma_parceiro = $jan + $fev + $mar + $abr + $mai + $jun + $jul + $ago + $set + $out + $nov + $dez;

                $contador = $contador + 1;

                array_push($array_captura_anual, ['num' => $key+1,
                        'especie' => $especie_lista->nome,
                        'jan' => $jan,
                        'fev' => $fev,
                        'mar' => $mar,
                        'abr' => $abr,
                        'mai' => $mai,
                        'jun' => $jun,
                        'jul' => $jul,
                        'ago' => $ago,
                        'set' => $set,
                        'out' => $out,
                        'nov' => $nov,
                        'dez' => $dez,
                        'total' => $soma_parceiro,
                    ]
                );
            }

        $soma_parceiroT = $janT + $fevT + $marT + $abrT + $maiT + $junT + $julT + $agoT + $setT + $outT + $novT + $dezT;

        $contador = $contador + 1;

        array_push($array_captura_anual, ['num' => '',
                'especie' => '',
                'jan' => $janT,
                'fev' => $fevT,
                'mar' => $marT,
                'abr' => $abrT,
                'mai' => $maiT,
                'jun' => $junT,
                'jul' => $julT,
                'ago' => $agoT,
                'set' => $setT,
                'out' => $outT,
                'nov' => $novT,
                'dez' => $dezT,
                'total' => $soma_parceiroT,
            ]
        );

        return $array_captura_anual;
    }

    public function array_captura_anual_por_embarcacao($embarcacoes_lista,$ano,$categoria)
    {
        $array_captura_anual = array();

        $janT=0; $fevT=0; $marT=0; $abrT=0; $maiT=0; $junT=0; $julT=0; $agoT=0; $setT=0; $outT=0; $novT=0; $dezT=0;

        $contador = 0;

        if(count($embarcacoes_lista))
            foreach($embarcacoes_lista as $key => $embarcacao_lista)
            {
                $jan = $this->total_por_mes_ano_categoria('01',$ano,$categoria,$embarcacao_lista->id);
                $fev = $this->total_por_mes_ano_categoria('02',$ano,$categoria,$embarcacao_lista->id);
                $mar = $this->total_por_mes_ano_categoria('03',$ano,$categoria,$embarcacao_lista->id);
                $abr = $this->total_por_mes_ano_categoria('04',$ano,$categoria,$embarcacao_lista->id);
                $mai = $this->total_por_mes_ano_categoria('05',$ano,$categoria,$embarcacao_lista->id);
                $jun = $this->total_por_mes_ano_categoria('06',$ano,$categoria,$embarcacao_lista->id);
                $jul = $this->total_por_mes_ano_categoria('07',$ano,$categoria,$embarcacao_lista->id);
                $ago = $this->total_por_mes_ano_categoria('08',$ano,$categoria,$embarcacao_lista->id);
                $set = $this->total_por_mes_ano_categoria('09',$ano,$categoria,$embarcacao_lista->id);
                $out = $this->total_por_mes_ano_categoria('10',$ano,$categoria,$embarcacao_lista->id);
                $nov = $this->total_por_mes_ano_categoria('11',$ano,$categoria,$embarcacao_lista->id);
                $dez = $this->total_por_mes_ano_categoria('12',$ano,$categoria,$embarcacao_lista->id);

                $janT = $janT + $jan; $fevT = $fevT + $fev; $marT = $marT + $mar; $abrT = $abrT + $abr; $maiT = $maiT + $mai; $junT = $junT + $jun;
                $julT = $julT + $jul; $agoT = $agoT + $ago; $setT = $setT + $set; $outT = $outT + $out; $novT = $novT + $nov; $dezT = $dezT + $dez;

                $soma_parceiro = $jan + $fev + $mar + $abr + $mai + $jun + $jul + $ago + $set + $out + $nov + $dez;

                $contador = $contador + 1;

                array_push($array_captura_anual, ['num' => $key+1,
                        'embarcacao_nome' => $embarcacao_lista->nome,
                        'jan' => $jan,
                        'fev' => $fev,
                        'mar' => $mar,
                        'abr' => $abr,
                        'mai' => $mai,
                        'jun' => $jun,
                        'jul' => $jul,
                        'ago' => $ago,
                        'set' => $set,
                        'out' => $out,
                        'nov' => $nov,
                        'dez' => $dez,
                        'total' => $soma_parceiro,
                    ]
                );
            }

        $soma_parceiroT = $janT + $fevT + $marT + $abrT + $maiT + $junT + $julT + $agoT + $setT + $outT + $novT + $dezT;

        $contador = $contador + 1;

        array_push($array_captura_anual, ['num' => '',
                'embarcacao_nome' => '',
                'jan' => $janT,
                'fev' => $fevT,
                'mar' => $marT,
                'abr' => $abrT,
                'mai' => $maiT,
                'jun' => $junT,
                'jul' => $julT,
                'ago' => $agoT,
                'set' => $setT,
                'out' => $outT,
                'nov' => $novT,
                'dez' => $dezT,
                'total' => $soma_parceiroT,
            ]
        );

        return $array_captura_anual;
    }
 
    public static function total_por_mes_ano_categoria($mes,$ano,$categoria,$id)
    {
            $total = 0;
            $data1 = "'".$ano."-".$mes."-01'";
            $data2 = "'".$ano."-".$mes."-31'";

            if($categoria=='embarcacao')
                $capturas =  DB::select('SELECT embarcacao_id, sum(qtd) as total FROM captura where (data>='.$data1.' and data<='.$data2.') AND embarcacao_id='.$id.' GROUP BY embarcacao_id');        
            else 
                $capturas =  DB::select('SELECT especie, sum(qtd) as total FROM captura where (data>='.$data1.' and data<='.$data2.') AND especie='.$id.' GROUP BY especie'); 
         
            if(count($capturas))
            {
                foreach($capturas as $captura)
                {
                    $total = $total + $captura->total;
                }
            }

            return $total;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {
        //
        $rules = array(
            'embarcacao_id'    =>  'required',
            'data'     =>  'required',
            'hr_inicio'     =>  'required',
            'hr_final'     =>  'required',
            'sonda'     =>  'required',
            'latitude1'     =>  'required',
            'longitude1'     =>  'required',
            'latitude2'     =>  'required',
            'longitude2'     =>  'required',
            'especie'     =>  'required',
            'qtd'     =>  'required',
        );

        $error = Validator::make($data->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Captura::create(['embarcacao_id' => $data->embarcacao_id,
            'especie' => $data->especie,
            'data' => $data->data,
            'hr_inicio' => $data->hr_inicio,
            'hr_final' => $data->hr_final,
            'sonda' => $data->sonda,
            'latitude1' => $data->latitude1,
            'longitude1' => $data->longitude1,
            'latitude2' => $data->latitude2,
            'longitude2' => $data->longitude2,
            'qtd' => $data->qtd            
            ]);

        return response()->json(['success' => 'Dado inserido com sucesso!!!.']);
    }

    public function update(Request $data)
    {
        //
        $rules = array(
            'embarcacao_id'    =>  'required',
            'data'     =>  'required',
            'hr_inicio'     =>  'required',
            'hr_final'     =>  'required',
            'sonda'     =>  'required',
            'latitude1'     =>  'required',
            'longitude1'     =>  'required',
            'latitude2'     =>  'required',
            'longitude2'     =>  'required',
            'especie'     =>  'required',
            'qtd'     =>  'required',
        );
        
        $error = Validator::make($data->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Captura::whereId($data->hidden_id)->update(['embarcacao_id' => $data->embarcacao_id,
            'especie' => $data->especie,
            'data' => $data->data,
            'hr_inicio' => $data->hr_inicio,
            'hr_final' => $data->hr_final,
            'sonda' => $data->sonda,
            'latitude1' => $data->latitude1,
            'longitude1' => $data->longitude1,
            'latitude2' => $data->latitude2,
            'longitude2' => $data->longitude2,
            'qtd' => $data->qtd            
            ]);

        return response()->json(['success' => 'Dado actualizado com sucesso!!!.']);
    }

    public function remover($id)
    {
        $captura = Captura::findOrFail($id);

        $new_name = $captura->imagem;

        if($captura->delete())
        {
            $image_path = public_path("admin_assets/images/captura");
            if(File::exists($image_path.$new_name))
            {
                File::delete($image_path.$new_name);
            }

            return response()->json(['success' => 'Registo removido com sucesso!!!.']);
        }
        else
            return response()->json(['errors' => 'Não foi possivel remover o registo!!!.']);

    }

    public function remover_conjunto($array_id)
    {
        $myArray = (explode(",",$array_id));

        $captura = Captura::whereIn('id',$myArray)->delete();

        if($captura)
        {
            return response()->json(['success' => 'Registos eliminados com sucesso!!!']);
        }
        else
        {
            return response()->json(['errors' => 'Não foi possivel eliminar os registos!!!.']);
        }

    }

}
