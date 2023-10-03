<?php

namespace App\Repositories;
class CategoryRepository extends AbstractRepository{
    public function getResultadoPaginado($numeroRegistroPorPagina) {
        return $this->model->with(['fairs', 'products'])->paginate($numeroRegistroPorPagina);
    }
}
?>
