<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    //
    public function __construct()
    {   
        $this->middleware("auth");
    }

    public function index()
    {
        return view("perfil.index");
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'username' => 'required|unique:users|min:3|max:20'
            'username' => [
                'required',
                // Str::slug($request->username),
                // "unique:users,username,{auth()->user()->username}", 
                Rule::unique('users', 'username')->ignore(auth()->user()),
                'min:3', 
                'max:20', 
                'not_in:editar-perfil'
            ]
        ]);

            // Generar el slug del nombre de usuario
            $slug = Str::slug($request->username);

        if($request->imagen) {
            $imagen = $request->file("imagen");

            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);
    
            $imagenPath = public_path("perfiles") . "/" . $nombreImagen;
            $imagenServidor->save($imagenPath);
        } 

        // Guardar los cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $slug; // Utilizar el slug como nombre de usuario
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // Redireccionar
        return redirect()->route("posts.index", $slug);
    }
}
