<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(Product $product){
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productRepository = new ProductRepository($this->product);

        if($request->has('atributos_category')){
            $atributos_category = 'category:id,'.$request->atributos_category;
            $productRepository->selecAtributosRegistrosRelacionados($atributos_category);
        } else {
            $productRepository->selecAtributosRegistrosRelacionados('category');
        }

        if($request->has('filtro')){
            $productRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $productRepository->selectAtributos($request->atributos);
        }
        return  response()->json( $productRepository->getResultadoPaginado(3),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->product->rules(), $this->product->feedback());

        $product = $this->product->create([
            'nome' => $request->nome,
            'product_id'=>$request->product_id,
            'descricao' => $request->descricao,
            'category_id' => $request->category_id,
        ]);

        return  response()->json( $product,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->with('category')->find($id);
        if($product === null){
            return response()->json(['erro' => 'Recurso pesquisado nao existe'], 404);
        }
        return  response()->json( $product,200);
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
        $product = $this->product->find($id);

        if($product === null){
            return response()->json(['erro' => 'O Recurso solicitado nao existe. Impossivel realizar a atualização'],404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            foreach($product->rules() as $input => $regra) {

                if(array_key_exists($input, $request->all())) {

                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $product->feedback());

            $product->fill($request->all())->save();

        }else {
            $request->validate($this->product->rules(), $this->product->feedback());
            $product->update($request->all());
        }

        return  response()->json( $product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->product->find($id);
        if($product === null){
            return response()->json( ['erro' => 'Impossivel realizar a exclusão'],404);
        }
        $product->delete();
        return  response()->json( ['msg' => 'Produto removido'],200);
    }
}
