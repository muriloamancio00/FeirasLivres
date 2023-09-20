<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio do card de Busca -->
                <card-component titulo="Busca de Produtos">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <encapsular-component
                                    titulo="ID"
                                    id="InputId"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID do Produto">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                           placeholder="ID do Produto">
                                </encapsular-component>
                            </div>
                        </div>
                        <encapsular-component
                            titulo="Nome do Produto"
                            id="InputNome"
                            id-help="NomeHelp"
                            texto-ajuda="Opcional. Informe o Nome do Produto">

                            <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp"
                                   placeholder="Nome do Produto">
                        </encapsular-component>
                        <select id="Selecione a categoria" onchange="selecionarCategoria()">
                            <option value="1">Categoria 1</option>
                            <option value="2">Categoria 2</option>
                            <option value="3">Categoria 3</option>
                            <!-- Adicione mais opções conforme necessário -->
                        </select>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right " data-toggle="modal" data-target="#modalProduto">Adicionar</button></template>
                </card-component>
                <!-- Fim do card de Busca -->

                <!-- Inicio do card de Listagem de Categorias -->
                <card-component titulo="Todas os Produtos">
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
        <modal-component id="modalProduto" titulo="Adicionar Produto">
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Produto" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do produto">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Nome do produto">
                    </input-container-component>
                    <br>
                        <p>Opcionais:</p>
                    <input-container-component titulo="Nome do Produto" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe o descricao da produto">
                        <input type="text" class="form-control" id="novoDescricao" aria-describedby="novoDescricaoHelp"
                               placeholder="Descricao do produto">
                    </input-container-component>
                    <hr><p>Imagem do produto</p>
                    <div class="form-group">
                        <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                            <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                        </input-container-component>
                        {{ arquivoImagem }}
                    </div>
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
