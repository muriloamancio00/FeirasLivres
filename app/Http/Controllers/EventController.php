<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class EventController extends Controller
{
    public function __construct(Event $event){
        $this->event = $event;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventRepository = new EventRepository($this->event);

        if($request->has('filtro')){
            $eventRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $eventRepository->selectAtributos($request->atributos);
        }
        return  response()->json( $eventRepository->getResultadoPaginado(3),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->event->rules(), $this->event->feedback());

        $event = $this->event->create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);

        return  response()->json( $event,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = $this->event->find($id);
        if($event === null){
            return response()->json(['erro' => 'Nenhum evento encontrado'],400);
        }
        return  response()->json($event,200);
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
        $event = $this->event->find($id);

        if($event === null){
            return response()->json(['erro' => 'O Recurso solicitado nao existe. Impossivel realizar a atualização'],404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($event->rules() as $input => $regra) {
                //input == nome , descrição se nao fosse nulo
                //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
                if(array_key_exists($input, $request->all())) {
                    //metodo nativo que pesquisa se a regra for compativel com algum indice dentro do request
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $event->feedback());
            $event->fill($request->all())->save();
        }else {
            $request->validate($this->event->rules(), $this->event->feedback());
            $event->update($request->all());
        }

        return  response()->json( $event, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = $this->event->find($id);
        if($event === null){
            return response()->json( ['erro' => 'Impossivel realizar a exclusão'],404);
        }
        $event->delete();
        return  response()->json( ['msg' => 'evento removido com sucesso!'],200);
    }
}
