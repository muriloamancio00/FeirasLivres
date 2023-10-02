<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    public function __construct(Category $category){
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categoryRepository = new CategoryRepository($this->category);

        if($request->has('atributos_products')){
            $atributos_products = 'products:id,'.$request->atributos_products;
            $categoryRepository->selecAtributosRegistrosRelacionados($atributos_products);
        } else {
            $categoryRepository->selecAtributosRegistrosRelacionados('products');
        }

        if($request->has('filtro')){
            $categoryRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $categoryRepository->selectAtributos($request->atributos);
        }
        return  response()->json( $categoryRepository->getResultadoPaginado(2),200);
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
        $request->validate($this->category->rules(), $this->category->feedback());

        $category = $this->category->create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return  response()->json( $category,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->category->with('products')->find($id);
        if($category === null){
            return response()->json(['erro' => 'Recurso pesquisado nao existe'], 404);
        }
        return  response()->json( $category,201);
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
        $category = $this->category->find($id);

        if($category === null){
            return response()->json(['erro' => 'O Recurso solicitado nao existe. Impossivel realizar a atualização'],404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($category->rules() as $input => $regra) {
                //input == nome , descrição se nao fosse nulo

                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    //metodo nativo que pesquisa se a regra for compativel com algum indice dentro do request
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $category->feedback());
            $category->fill($request->all())->save();
        }else {
            $request->validate($this->category->rules(), $this->category->feedback());
            $category->update($request->all());
        }

        return  response()->json( $category, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->category->find($id);
        if($category === null){
            return response()->json( ['erro' => 'Impossivel realizar a exclusão'],404);
        }
        $category->delete();
        return  response()->json( ['msg' => 'categoria removida'],200);
    }
}
