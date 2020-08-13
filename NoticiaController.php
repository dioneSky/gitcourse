<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Noticia;
use App\Imagem;
use App\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use File;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()) {
            return redirect('cpanel/admin/login');
        }
        else
        {

            $noticias = Noticia::all();
            $categorias = Categoria::all();
            $action = 'http://'.request()->getHttpHost();            

            $meses = array('JAN','FEV','MAR','ABR','MAI','JUN','JUL','AGO','SET','OUT','NOV','DEZ');

            return view('/layouts/admin/noticia_lista', compact('noticias','categorias', 'meses','action'));

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $noticia = new Noticia();
        $categorias = Categoria::all();

        return view('/layouts/admin/noticia_form',compact('noticia','categorias'));
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
            'titulo'    =>  'required',
            'descricao_curta'     =>  'required',
            'autor'     =>  'required',
            'data_publicacao'     =>  'required'
        );

        $rules2 = array(
            'imagem'         =>  'required|image|max:2048'
        );

        $rules3 = array(
            'video'         =>  'required'
        );

        $error = Validator::make($data->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $error2 = Validator::make($data->all(), $rules2);
        $error3 = Validator::make($data->all(), $rules3);

        if($error2->fails())
            $new_name = "image_icon.png";
        else
        {
            $imagem = $data->file('imagem');
            $new_name = rand() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('assets/img/article/'), $new_name);
        }

        if($error3->fails())
            $new_video = "";
        else
        {
            $video = $data->file('video');
            $new_video = rand() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('video/'), $new_video);
        }

        Noticia::create(['titulo' => $data->titulo,
            'descricao_curta' => $data->descricao_curta,
            'descricao_longa' => $data->descricao_longa,
            'autor' => $data->autor,
            'endereco' => $data->endereco,
            'link' => $data->link,
            'data_publicacao' => $data->data_publicacao,
            'data_inicio' => $data->data_inicio,
            'data_fim' => $data->data_fim,
            'categoria_id' => $data->categoria_id,
            'tipo' => $data->tipo,
            'video' => $new_video,
            'imagem' => $new_name]);

        return response()->json(['success' => 'Dado inserido com sucesso!!!.']);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $data)
    {
        $rules = array(
            'titulo'    =>  'required',
            'descricao_curta'     =>  'required',
            'autor'     =>  'required',
            'data_publicacao'     =>  'required'
        );

        $rules2 = array(
            'imagem'         =>  'required|image|max:2048'
        );

        $rules3 = array(
            'video'         =>  'required'
        );

        $error = Validator::make($data->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $error2 = Validator::make($data->all(), $rules2);
        $error3 = Validator::make($data->all(), $rules3);

        if($error2->fails())
            $new_name = $data->hidden_imagem;
        else
        {
            $imagem = $data->file('imagem');
            $new_name = rand() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('assets/img/article/'), $new_name);
        }

        if($error3->fails())
            $new_video = $data->hidden_video;
        else
        {
            $video = $data->file('video');
            $new_video = rand() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('video/'), $new_video);
        }

        Noticia::whereId($data->hidden_id)->update(['titulo' => $data->titulo,
            'descricao_curta' => $data->descricao_curta,
            'descricao_longa' => $data->descricao_longa,
            'autor' => $data->autor,
            'endereco' => $data->endereco,
            'link' => $data->link,
            'data_publicacao' => $data->data_publicacao,
            'data_inicio' => $data->data_inicio,
            'data_fim' => $data->data_fim,
            'categoria_id' => $data->categoria_id,
            'tipo' => $data->tipo,
            'video' => $new_video,
            'imagem' => $new_name]);

        return response()->json(['success' => 'Dado actualizado com sucesso!!!.']);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        $categorias = Categoria::all();
        $imagens = Imagem::where('tipo_id','=',$id)->where('tipo','=',2)->orderBy('id')->get();


        return view('/layouts/admin/noticia_form',compact('noticia','categorias','imagens'));

    }



    public function activar_desactivar($id,$estado)
    {
        $noticia = Noticia::findOrFail($id);

        $noticia->estado = $estado;

        if($noticia->update())
        {
            if($estado==1)
                return response()->json(['success' => 'Registo activado com sucesso!!!.']);
            else
                return response()->json(['success' => 'Registo desactivado com sucesso!!!.']);
        }
        else
        {
            if($estado==1)
                return response()->json(['errors' => 'Não foi possivel activar o registo!!!.']);
            else
                return response()->json(['errors' => 'Não foi possivel desactivar o registo!!!.']);
        }


    }


    public function activar_desactivar_conjunto($array_id,$estado)
    {
        $myArray = (explode(",",$array_id));

        $noticia = Noticia::whereIn('id',$myArray)->update(['estado'=>$estado]);

        if($noticia)
        {
            if($estado==1)
                return response()->json(['success' => 'Registos activados com sucesso!!!']);
            else
                return response()->json(['success' => 'Registos desactivados com sucesso!!!']);
        }
        else
        {

            if($estado==1)
                return response()->json(['errors' => 'Não foi possivel activar os registos!!!.']);
            else
                return response()->json(['errors' => 'Não foi possivel desactivar os registos!!!.']);
        }


    }

    public function remover($id)
    {
        $noticia = Noticia::findOrFail($id);

        $new_name = $noticia->imagem;

        if($noticia->delete())
        {
            $image_path = public_path("assets/img/article/");
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

        $noticia = Noticia::whereIn('id',$myArray)->delete();

        if($noticia)
        {
            return response()->json(['success' => 'Registos eliminados com sucesso!!!']);
        }
        else
        {
            return response()->json(['errors' => 'Não foi possivel eliminar os registos!!!.']);
        }

    }


    public function galeria_on_off($id,$estado)
    {
        $noticia = Noticia::findOrFail($id);

        $noticia->galeria = $estado;

        if($noticia->update())
        {
            if($estado==1)
                return response()->json(['success' => 'Registo colocado na gealeria com sucesso!!!.']);
            else
                return response()->json(['success' => 'Registo retirado da gealeria com sucesso!!!.']);
        }
        else
        {
            if($estado==1)
                return response()->json(['errors' => 'Não foi possivel colocar os registos na galeria!!!.']);
            else
                return response()->json(['errors' => 'Não foi possivel retirar os registos da galeria!!!.']);
        }


    }


    public function galeria_on_off_conjunto($array_id,$estado)
    {
        $myArray = (explode(",",$array_id));

        $noticia = Noticia::whereIn('id',$myArray)->update(['galeria'=>$estado]);

        if($noticia)
        {
            if($estado==1)
                return response()->json(['success' => 'Registos colocados na gealeria com sucesso!!!']);
            else
                return response()->json(['success' => 'Registos retirados da gealeria com sucesso!!!']);
        }
        else
        {

            if($estado==1)
                return response()->json(['errors' => 'Não foi possivel colocar os registos na galeria!!!.']);
            else
                return response()->json(['errors' => 'Não foi possivel retirar os registos da galeria!!!.']);
        }


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
