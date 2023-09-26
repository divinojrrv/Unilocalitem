<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit(int $id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return redirect()->route('usuario.telainicial');
        }
        return view('/Usuario/alteraruser', compact('usuario'));
        
    }


    public function editADM(int $id)
    {
        //dd($id);
        $usuario = User::find($id);
       

        if (!$usuario) {
            return redirect()->route('usuario.telainicial');
        }

        
        return view('/Usuario/alteraruserADM', compact('usuario'));
    }

    public function updateADM(Request $request, $ID)
    {

        $request->validate([
            'nome' => 'required|max:255', 
        ]);


        $usuario = User::find($ID);

       

        if (!$usuario) {
            return redirect()->route('usuario.telainicial')->with('error', 'Usuário não encontrado'); 
        }

        if ($request->filled('password') && $request->filled('password_confirmation')) {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);

            $usuario->password = Hash::make(trim($request->input('password')));
        }

        $usuario->nome = trim($request->input('nome'));

        $usuario->tipousuario = $request->has('tipousuario') ? 1 : 0;
        $usuario->status = $request->has('status') ? 0 : 1;

        if ($usuario->save()) {
            return redirect()->route('usuario.telainicial')->with('success', 'Usuário atualizado com sucesso');
        } else {
            return redirect()->route('usuario.telainicial')->with('error', 'Erro ao atualizar o usuário');
        }
    }





    public function update(Request $request, $ID)
    {
        $request->validate([
            'nome' => 'required|max:255', 
            'password' => 'required|min:8',
        ]);
    
        $usuario = User::find($ID);
    
        if (!$usuario) {
            return redirect()->route('usuario.telainicial')->with('error', 'Usuário não encontrado'); 
        }
    
        if (!Hash::check($request->input('password'), $usuario->password)) {
            return redirect()->route('usuario.telainicial')->with('error', 'Senha incorreta. Não foi possível atualizar o nome.');
        }
    
        $usuario->nome = trim($request->input('nome'));
    
        if ($usuario->save()) {
            return redirect()->route('usuario.telainicial')->with('success', 'Nome de usuário atualizado com sucesso');
        } else {
            return redirect()->route('usuario.telainicial')->with('error', 'Erro ao atualizar o nome de usuário');
        }
    }
    
}
