<?php

namespace App\Repositories;
class FairsEventsRepository extends AbstractRepository{
    public function getResultadoPaginado($numeroRegistroPorPagina) {
        return $this->model->with(['fairs', 'events'])->paginate($numeroRegistroPorPagina);
    }
}
?>
