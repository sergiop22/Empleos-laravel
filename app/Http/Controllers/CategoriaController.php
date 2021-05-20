<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class CategoriaController extends Controller
{
    public function show(Categoria $categoria)
    {
    	$vacantes = Vacante::where('categoria_id', $categoria->id)->paginate(10);

    	return view('categorias.show', compact('vacantes', 'categoria'));
    }
}
