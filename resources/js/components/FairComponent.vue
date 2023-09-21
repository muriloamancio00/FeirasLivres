<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio do card de Busca -->
                <card-component titulo="Busca de Feiras">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <encapsular-component
                                    titulo="ID"
                                    id="InputId"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID da Feira">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                           placeholder="ID da feira">
                                </encapsular-component>
                            </div>

                            <div class="col mb-3">
                                <encapsular-component
                                    titulo="Nome da Feira"
                                    id="InputNome"
                                    id-help="NomeHelp"
                                    texto-ajuda="Opcional. Informe o Nome da Feira">

                                    <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp"
                                           placeholder="Nome da feira">

                                </encapsular-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right " data-toggle="modal" data-target="#modalFeira">Adicionar</button></template>
                </card-component>
                <!-- Fim do card de Busca -->

                <!-- Inicio do card de Listagem de Feiras -->
                <card-component titulo="Todas as Feiras">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right">Adicionar</button>
                    </template>
                </card-component>
                <!-- Fim da Listagem de Feiras -->
            </div>
        </div>
        <!-- Button trigger modal -->
        <modal-component id="modalFeira" titulo="Adicionar Feira">
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="Nome da Feira" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome da feira">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Nome da feira">
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
