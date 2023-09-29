<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <!-- início do card de busca -->
                <card-component titulo="Busca de Categorias">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da Categoria">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome da Categoria" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da Categoria">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da Categoria">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->


                <!-- início do card de listagem de categorias -->
                <card-component titulo="Relação de categorias">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="categorias"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalCategoriaVizualizar'}"
                            :atualizar="{ visivel: true}"
                            :remover="{ visivel: true}"
                            :titulos="{
                                id: {titulo: 'ID', tipo:'text'},
                                nome: {titulo: 'Nome', tipo:'text'},
                                descricao: {},
                                created_at: {titulo: 'Data Criação', tipo:'data'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in categorias.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalCategoria">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- fim do card de listagem de categorias -->
            </div>
        </div>

        <!-- Modal Adiciona -->
        <modal-component id="modalCategoria" titulo="Adicionar Categoria">

            <template v-slot:alerta>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso!" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro, Produto não cadastrado!" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="Nome do Produto" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Produto">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Nome do produto" v-model:id="nomeCategoria">
                    </encapsular-component>
                    <hr><p>Opcional</p>
                    <encapsular-component titulo="Descrição do Produto" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe a Descricao do Produto">
                        <input type="text" class="form-control" id="novoDescricao" aria-describedby="novoDescricaoHelp"
                               placeholder="Opcional. Descricao do Produto" v-model:id="descricaoCategoria">
                    </encapsular-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- Fim Modal Adiciona -->

        <!-- Inicio Modal Visualizar -->
        <modal-component id="modalCategoriaVizualizar" titulo="Visualizar Categoria">
            <template v-slot:alerta></template>
            <template v-slot:conteudo>
                <encapsular-component titulo="ID">
                    <input type="text" class ="form-control" :value="$store.state.item.id" disabled>
                </encapsular-component>
                <encapsular-component titulo="Nome do Produto">
                    <input type="text" class ="form-control" :value="$store.state.item.nome" disabled>
                </encapsular-component>
                <encapsular-component titulo="Descricao do Produto">
                    <input type="text" class ="form-control" :value="$store.state.item.descricao" disabled>
                </encapsular-component>
                <encapsular-component titulo="Data de Criação">
                    <input type="data" class ="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal" disabled>
                </encapsular-component>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>
        <!-- Fim Modal Visualizar -->

    </div>
</template>

<script>
export default {
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/category',
            urlPaginacao: '',
            urlFiltro: '',
            nomeCategoria: '',
            descricaoCategoria: '',
            //
            transacaoStatus: '',
            transacaoDetalhes: {},
            //
            categorias: [],
            busca: {id: '', nome: ''},
        }
    },
    methods: {
        carregarLista() {

            let url = this.urlBase +'?' + this.urlPaginacao + this.urlFiltro

            axios.get(url)
                .then(response => {
                    this.categorias = response.data
                    //console.log(this.categorias)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        paginacao(l){
            //se for valido
            if(l.url){
                this.urlPaginacao = l.url.split('?')[1] // ajustando a url com o paramêtro de pagina
                this.carregarLista() // requisita dnv para API
            }
        },
        salvar() {

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }

            let formData = new FormData();
            formData.append('nome', this.nomeCategoria)
            formData.append('descricao', this.descricaoCategoria)

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do registro: ' + response.data.id
                    }
                    this.carregarLista()
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })
        },

    },
    mounted() {
        this.carregarLista()
    }
}
</script>
