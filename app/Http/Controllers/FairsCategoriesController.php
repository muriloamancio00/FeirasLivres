<?php

namespace App\Http\Controllers;

use App\Models\FairsCategories;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Fair;
use App\Repositories\FairsCategoriesRepository;

class FairsCategoriesController extends Controller
{
    public function __construct(FairsCategories $fairs_categories){
        $this->fairs_categories = $fairs_categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fairsCategoriesRepository = new FairsCategoriesRepository($this->fairs_categories);

        if($request->has('filtro')){
            $fairsCategoriesRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $fairsCategoriesRepository->selectAtributos($request->atributos);
        }
        return  response()->json( $fairsCategoriesRepository->getResultado(),200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate($this->fairs_categories->rules(), $this->fairs_categories->feedback());
        $fairs_categories = $this->fairs_categories->create([
            'fair_id' => $request->fair_id,
            'category_id' => $request->category_id,
        ]);

        return  response()->json( $fairs_categories,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fairs_categories = $this->fairs_categories->find($id);
        if($fairs_categories === null){
            return response()->json(['erro' => 'Recurso pesquisado nao existe'], 404);
        }
        return  response()->json( $fairs_categories,200);
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
        $fairs_categories = $this->fairs_categories->find($id);

        if($fairs_categories === null){
            return response()->json(['erro' => 'O Recurso solicitado nao existe. Impossivel realizar a atualização'],404);
        }

        if($request->method() === 'PATCH') {
            $regrasDinamicas = array();

            foreach($fairs_categories->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $fairs_categories->feedback());
            $fairs_categories->fill($request->all())->save();
        }else {
            $request->validate($fairs_categories->rules(), $fairs_categories->feedback());
            $fairs_categories->update($request->all());
        }

        return  response()->json( $fairs_categories, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fairs_categories = $this->fairs_categories->find($id);
        if($fairs_categories === null){
            return response()->json( ['erro' => 'Impossivel realizar a exclusão'],404);
        }
        $fairs_categories->delete();
        return  response()->json( ['msg' => 'fairs_categories removido'],200);
    }
}
