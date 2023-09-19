<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $produtos = array();

        //obtendo filtros de colunas especificas
        if($request->has('atributos_category')){
            $atributos_category = $request->atributos_category;
            $produtos = $this->product->with('category:id,'.$atributos_category);
        } else {
            //obter objeto da relação de produtos
            $produtos = $this->product->with('category');
        }

        //feita as atribuições dentro de produtos pela query
        //podemos adicionar essa nova informação e depois finalizamos com o metodo get
        if($request->has('filtro')){
            //dd(explode(':',$request->filtro)); como retorno temos um array com 3 colunas

            $filtros = explode(';',$request->filtro);

            foreach($filtros as $key=> $condicao) {
                //[0] nome do campo
                //[1] nome do operador
                //[2] o valor a ser comparado
                $c = explode(':',$condicao);
                $produtos = $produtos->where($c[0],$c[1],$c[2]);
            }
        }

        //obtendo apenas atributos base, e enviando pelo get
        if($request->has('atributos')) {
            $atributos = $request->atributos;
            $produtos = $produtos->selectRaw($atributos)->get();
        }else {
            $produtos = $produtos->get();
        }
        return  response()->json($produtos,201);
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
        return  response()->json( $product,201);
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

        return  response()->json( $product, 201);
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
        return  response()->json( ['msg' => 'Produto removido'],201);
    }
}
