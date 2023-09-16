<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio do card de Busca -->
                <div class="card mb-3">
                    <div class="card-header">Busca de Categorias</div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col mb-3">

                                <encapsular-component
                                    titulo="ID"
                                    id="InputId"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID da Categoria">

                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                           placeholder="ID da categoria">

                                </encapsular-component>
                            </div>
                            <div class="col mb-3">
                                <encapsular-component
                                    titulo="Nome da Categoria"
                                    id="InputNome"
                                    id-help="NomeHelp"
                                    texto-ajuda="Opcional. Informe o Nome da Categoria">

                                    <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp"
                                           placeholder="Nome da categoria">

                                </encapsular-component>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                    </div>
                </div>
                <!-- Fim do card de Busca -->

                <!-- Inicio do card de Listagem de Categorias -->
                <div class="card">
                    <div class="card-header">Todas as Categorias</div>

                    <div class="card-body">
                        <table-component></table-component>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary btn-sm float-right">Adicionar</button>
                    </div>
                </div>
                <!-- Fim da Listagem de Categorias -->
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
