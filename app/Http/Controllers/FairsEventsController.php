<?php

namespace App\Http\Controllers;

use App\Models\FairsEvents;
use Illuminate\Http\Request;
use App\Models\Fair;
use App\Repositories\FairsEventsRepository;

class FairsEventsController extends Controller
{
    public function __construct(FairsEvents $fairs_events){
        $this->fairs_events = $fairs_events;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fairsEventsRepository = new FairsEventsRepository($this->fairs_events);

        if($request->has('filtro')){
            $fairsEventsRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $fairsEventsRepository->selectAtributos($request->atributos);
        }
        return  response()->json( $fairsEventsRepository->getResultado(),200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->fairs_events->rules(), $this->fairs_events->feedback());
        $fairs_events = $this->fairs_events->create([
            'fair_id' => $request->fair_id,
            'event_id' => $request->event_id,
            'data' => $request->data,
            'status' => $request->status,
            'horarioInicio' => $request->horarioInicio,
            'horarioFim' => $request->horarioFim,
        ]);

        return  response()->json( $fairs_events,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fairs_events = $this->fairs_events->find($id);
        if($fairs_events === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404) ;
        }

        return response()->json($fairs_events, 200);
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
        $fairs_events = $this->fairs_events->find($id);

        if($fairs_events === null){
            return response()->json(['erro' => 'O Recurso solicitado nao existe. Impossivel realizar a atualização'],404);
        }

        if($request->method() === 'PATCH') {
            $regrasDinamicas = array();

            foreach($fairs_events->rules() as $input => $regra) {
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $fairs_events->feedback());
            $fairs_events->fill($request->all())->save();
        }else {
            $request->validate($fairs_events->rules(), $fairs_events->feedback());
            $fairs_events->update($request->all());
        }

        return  response()->json( $fairs_events, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fairs_events = $this->fairs_events->find($id);

        if($fairs_events === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }

        $fairs_events->delete();
        return response()->json(['msg' => 'A Evento de Feira foi removido com sucesso!'], 200);
    }
}
