<?php

namespace App\Repositories;

class FairRepository extends AbstractRepository{

    public function getResultadoPaginado($numeroRegistroPorPagina) {
        return $this->model->with(['events', 'categories'])->paginate($numeroRegistroPorPagina);
    }

}
