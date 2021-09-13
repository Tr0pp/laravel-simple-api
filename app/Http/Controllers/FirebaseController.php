<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FirebaseController extends Controller
{
    protected $_firebase;
    protected $_type;

    /**
     * Retorna todos leilões
     */
    public function index(Request $request)
    {
        if($request->input('name') == '' || $request->input('name') == null){
            $this->_firebase = "bomvalorjudicial";
        }else{
            $this->_firebase = $request->input('name');
        }

        if($request->input('type') == '' || $request->input('type') == null){
            $this->_type = "leilao";
        }else{
            $this->_type = $request->input('type');
        }

        return Http::get("https://vlance-firebase-dev-$this->_firebase.firebaseio.com/$this->_type.json")->json();
    }

    /**
     * Retorna um leilão especifico
     */
    public function show(Request $request, $id)
    {
        if($request->input('name') == '' || $request->input('name') == null){
            $this->_firebase = "bomvalorjudicial";
        }else{
            $this->_firebase = $request->input('name');
        }

        if($request->input('type') == '' || $request->input('type') == null){
            $this->_type = "leilao";
        }else{
            $this->_type = $request->input('type');
        }

        if($id == ''){
            $this->index();
        }

        return Http::get("https://vlance-firebase-dev-$this->_firebase.firebaseio.com/$this->_type/{$id}.json")->object();
    }

}
