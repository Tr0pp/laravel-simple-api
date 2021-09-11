<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Dog;
use Illuminate\Http\Request;

class DogController extends Controller
{
    //Seria um select * from X, trás todos resultados
    public function index()
    {
        return Dog::all();
    }

    //Faz o insert via requisição
    public function store(Request $request)
    {
        return Dog::create($request->all());
    }

    //Trás um resultado por algum parâmetro, nesse caso o ID
    public function show($id)
    {
        return Dog::findOrFail($id);
    }

    //Atualiza os dados (que vem no $request) com base no ID do registro
    public function update(Request $request, $id)
    {
        $dog = Dog::findOrFail($id);
        $dog->update($request->all());

        return $dog;
    }

    //Deleta um registro pelo ID
    public function destroy($id)
    {
        $dog = Dog::findOrFail($id);
        $result = $dog->delete() ? 'success' : 'error';

        return response()->json($result);
    }
}
