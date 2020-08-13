<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Internauta;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use File;

class InternautaController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function index()
    {
        if (Auth::guest()) {
            return redirect('/cpanel/admin/login');
        }
        else
        {
            $internautas = Internauta::all();

            return view('/layouts/admin/internauta_lista', compact('internautas'));
        }

    }

    protected function internauta_lista()
    {
        if (Auth::guest()) {
            return redirect('cpanel/admin/login');
        }
        else
        {
            $internautas = Internauta::all();

            return view('/layouts/admin/internauta_usuario_lista', compact('internautas'));
        }

    }

     /* To check if internauta is logged in by Dione Sky */

     public static function checkLogin()
     {
         //return true;
     }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create()
    {
        $internauta = new Internauta();
        return view('/layouts/admin/internauta_form',compact('internauta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $data)
    {
        $rules = array(
            'name'    =>  'required',
            'email'     =>  'required',
            'password'     =>  'required'
        );

        $rules2 = array(
            'name'    =>  'required',
            'email'     =>  'required',
            'password'     =>  'required',
            'imagem'         =>  'required|image|max:2048'
        );

        $error = Validator::make($data->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $error2 = Validator::make($data->all(), $rules2);

        if($error2->fails())
            $new_name = "image_icon.png";
        else
        {
            $imagem = $data->file('imagem');
            $new_name = rand() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('assets/img/client/'), $new_name);
        }

        Internauta::create(['name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'telefone' => $data->telefone,
            'tipo' => $data->tipo,
            'facebook' => $data->facebook,
            'twitter' => $data->twitter,
            'instagram' => $data->instagram,
            'blog' => $data->blog,
            'nif' => $data->rua,
            'rua' => $data->nif,
            'pais' => $data->pais,
            'cidade' => $data->cidade,
            'caixa_postal' => $data->caixa_postal,
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
            'name'    =>  'required',
            'email'     =>  'required',
            'password'     =>  'required'
        );

        $rules2 = array(
            'name'    =>  'required',
            'email'     =>  'required',
            'password'     =>  'required',
            'imagem'         =>  'required|image|max:2048'
        );

        $error = Validator::make($data->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $error2 = Validator::make($data->all(), $rules2);

        if($error2->fails())
        {
            $new_name = $data->hidden_imagem;
        }
        else
        {
            $imagem = $data->file('imagem');
            $new_name = rand() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('assets/img/client/'), $new_name);
        }

        Internauta::whereId($data->hidden_id)->update(['name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'telefone' => $data->telefone,
            'tipo' => $data->tipo,
            'facebook' => $data->facebook,
            'twitter' => $data->twitter,
            'instagram' => $data->instagram,
            'blog' => $data->blog,
            'nif' => $data->nif,
            'rua' => $data->rua,
            'pais' => $data->pais,
            'cidade' => $data->cidade,
            'caixa_postal' => $data->caixa_postal,
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
        $internauta = Internauta::findOrFail($id);
        return view('/layouts/admin/internauta_form',compact('internauta'));

    }


    public function desactivar($id)
    {
        $internauta = Internauta::findOrFail($id);

        $internauta->estado = 0;

        if($internauta->update())
            return response()->json(['success' => 'Registo desactivado com sucesso!!!.']);
        else
            return response()->json(['errors' => 'Não foi possivel desactivar o registo!!!.']);

    }


    public function activar($id)
    {
        $internauta = Internauta::findOrFail($id);

        $internauta->estado = 1;

        if($internauta->update())
            return response()->json(['success' => 'Registo activado com sucesso!!!.']);
        else
            return response()->json(['errors' => 'Não foi possivel activar o registo!!!.']);

    }


    public function activar_desactivar_conjunto($array_id,$estado)
    {
        $myArray = (explode(",",$array_id));

        $internauta = Internauta::whereIn('id',$myArray)->update(['estado'=>$estado]);

        if($internauta)
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
        $internauta = Internauta::findOrFail($id);

        $new_name = $internauta->imagem;

        if($internauta->delete())
        {
            $image_path = public_path("assets/img/client/");
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

        $internauta = Internauta::whereIn('id',$myArray)->delete();

        if($internauta)
        {
            return response()->json(['success' => 'Registos eliminados com sucesso!!!']);
        }
        else
        {
            return response()->json(['errors' => 'Não foi possivel eliminar os registos!!!.']);
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

    }

}
