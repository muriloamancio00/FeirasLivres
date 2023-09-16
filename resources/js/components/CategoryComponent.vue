<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Busca de Categorias</div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col mb-3">

                                <encapsular-component
                                    titulo="ID"
                                    id="InputId"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID da Categoria">

                                    <input type="text" class="form-control" id="inputNome" aria-describedby="idNome"
                                           placeholder="ID da categoria">

                                </encapsular-component>
                            </div>
                                <div class="col mb-3">
                                    <label for="inputNome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="idNome"
                                           placeholder="Nome da Categoria">
                                    <div id="idNome" class="form-text text-muted">Opcional. Informe o Nome da
                                        Categoria
                                    </div>
                                </div>
                            </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
