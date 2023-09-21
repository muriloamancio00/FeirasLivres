<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio do card de Busca -->
                <card-component titulo="Busca de Bancas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <encapsular-component
                                    titulo="ID"
                                    id="InputId"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID da Banca">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                           placeholder="ID do Banca">
                                </encapsular-component>
                            </div>
                        </div>
                        <encapsular-component
                            titulo="Nome do Banca"
                            id="InputNome"
                            id-help="NomeHelp"
                            texto-ajuda="Opcional. Informe o Nome da Banca">

                            <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp"
                                   placeholder="Nome da Banca">
                        </encapsular-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right " data-toggle="modal" data-target="#modalBanca">Adicionar</button></template>
                </card-component>
                <!-- Fim do card de Busca -->

                <!-- Inicio do card de Listagem de Categorias -->
                <card-component titulo="Todas os Bancas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right">Proximo</button>
                    </template>
                </card-component>
                <!-- Fim da Listagem de Categorias -->
            </div>
        </div>
        <!-- Button trigger modal -->
        <modal-component id="modalBanca" titulo="Adicionar Banca">
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="Nome do Banca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do banca">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Nome do banca">
                    </encapsular-component>
                    <br>
                    <p>Opcionais:</p>
                    <encapsular-component titulo="Nome do Banca" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe o descricao da banca">
                        <input type="text" class="form-control" id="novoDescricao" aria-describedby="novoDescricaoHelp"
                               placeholder="Descricao do banca">
                    </encapsular-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Salvar</button>
            </template>
        </modal-component>
    </div>

</template>

<script>
    import {defineComponent} from "vue";
    import Card from "./CardComponent.vue";

    export default defineComponent({
        components: {Card}
    })
</script>
