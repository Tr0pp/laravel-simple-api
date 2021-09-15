<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller;

class FirebaseController extends Controller
{
    protected $_firebase;
    protected $_type;

    /**
     * Retorna todas informçaões
     */
    public function index(Request $request)
    {
        $this->setRequest($request);

        return Http::get("https://vlance-firebase-dev-$this->_firebase.firebaseio.com/$this->_type.json")->json();
    }

    /**
     * Retorna a informação com base na identificação do leilão
     */
    public function show(Request $request, $id)
    {
        $this->setRequest($request);

        if($id == ''){
            $this->index();
        }

        return Http::get("https://vlance-firebase-dev-$this->_firebase.firebaseio.com/$this->_type/{$id}.json")->json();
    }

    public function setRequest($request){
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
    }

}
