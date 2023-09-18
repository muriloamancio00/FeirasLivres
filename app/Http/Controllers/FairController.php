<?php

namespace App\Http\Controllers;

use App\Models\Fair;
use Illuminate\Http\Request;

class FairController extends Controller
{
    public function __construct(Fair $fair){
        $this->fair = $fair;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->fair->all(),201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->fair->rules(), $this->fair->feedback());

        $fair = $this->fair->create([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'horarioInicio' => $request->horarioInicio,
            'horarioFim' => $request->horarioFim,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        return  response()->json( $fair,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fair = $this->fair->find($id);
        if($fair === null){
            return response()->json(['erro' => 'Recurso pesquisado nao existe'], 404);
        }
        return  response()->json( $fair,201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fair = $this->fair->find($id);

        if($fair === null){
            return response()->json(['erro' => 'O Recurso solicitado nao existe. Impossivel realizar a atualização'],404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            foreach($fair->rules() as $input => $regra) {

                if(array_key_exists($input, $request->all())) {

                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $fair->feedback());
            $fair->fill($request->all())->save();
        }else {
            $request->validate($this->$fair->rules(), $this->$fair->feedback());
            $fair->update($request->all());
        }

        return  response()->json( $fair, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fair = $this->fair->find($id);
        if($fair === null){
            return response()->json( ['erro' => 'Impossivel realizar a exclusão'],404);
        }
        $fair->delete();
        return  response()->json( ['msg' => 'categoria removida'],201);
    }
}
