<?php

namespace App\Repositories;
class FairsCategoriesRepository extends AbstractRepository{
    public function getResultadoPaginado($numeroRegistroPorPagina) {
        return $this->model->with(['fairs', 'categories'])->paginate($numeroRegistroPorPagina);
    }
}
?>
