<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio Busca -->
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
                                           placeholder="ID do Produto" v-model="busca.id">
                                </encapsular-component>
                            </div>
                        </div>
                        <encapsular-component
                                titulo="Nome do Produto"
                                id="InputNome"
                                id-help="NomeHelp"
                                texto-ajuda="Opcional. Informe o Nome do Produto">

                            <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp"
                                   placeholder="Nome do Produto" v-model="busca.nome">
                        </encapsular-component>
                        <encapsular-component
                                titulo="Categoria do Produto"
                                id="InputCategoria"
                                id-help="CategoriaHelp"
                                texto-ajuda="Opcional. Informe a Categoria do Produto">

                            <input type="int" class="form-control" id="inputCategoria" aria-describedby="CategoriaHelp"
                                   placeholder="Categoria do Produto" v-model="busca.category_id">
                        </encapsular-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button></template>
                </card-component>
                <!-- Fim Busca -->

                <!-- Inicio Lista -->
                <card-component titulo="Todas os Produtos">
                    <template v-slot:conteudo>
                        <!--os dados precisma ser um array de obj, e os titulos coincidir com os atributos do obj-->
                        <table-component
                                :dados="produtos.data"
                                :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoVizualizar'}"
                                :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoAtualizar'}"
                                :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoRemover'}"
                                :titulos="{
                                id: {titulo: 'ID', tipo:'text'},
                                nome: {titulo: 'Nome', tipo:'text'},
                                descricao: {},
                                category_id: {},
                                created_at: {titulo: 'Data Criação', tipo:'data'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <!-- percorrendo todos os links dentro-->
                                    <li v-for="l, key in produtos.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label">
                                            <!-- {{l}}, dentro dele cada um possui um unico label -->
                                        </a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalProduto">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim Lista -->
            </div>
        </div>

        <!-- Modal Adiciona -->
        <modal-component id="modalProduto" titulo="Adicionar Produto">

            <template v-slot:alerta>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso!" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro, Produto não cadastrado!" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="Nome do Produto" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Produto">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Nome do produto" v-model:id="nomeProduto">
                    </encapsular-component>
                    <encapsular-component titulo="Categoria do Produto" id="novoCategory_id" id-help="novoCategory_idHelp" texto-ajuda="Informe a Categoria do Produto">
                        <input type="number" class="form-control" id="novoCategory_id" aria-describedby="novoCategory_idHelp"
                               placeholder="Seleciona a Categoria" v-model:id="category_idProduto">
                    </encapsular-component>
                    <hr><p>Opcional</p>
                    <encapsular-component titulo="Descrição do Produto" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe a Descricao do Produto">
                        <input type="text" class="form-control" id="novoDescricao" aria-describedby="novoDescricaoHelp"
                               placeholder="Opcional. Descricao do Produto" v-model:id="descricaoProduto">
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
        <modal-component id="modalProdutoVizualizar" titulo="Visualizar Produto">
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
                <encapsular-component titulo="Categoria do Produto">
                    <input type="number" class ="form-control" :value="$store.state.item.category_id" disabled>
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

        <!-- Inicio modal Remove -->
        <modal-component id="modalProdutoRemover" titulo="Remover Produto">
            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <encapsular-component titulo="ID">
                    <input type="text" class ="form-control" :value="$store.state.item.id" disabled>
                </encapsular-component>
                <encapsular-component titulo="Nome do Produto">
                    <input type="text" class ="form-control" :value="$store.state.item.nome" disabled>
                </encapsular-component>
            </template>
            <template v-slot:rodape >
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>

        </modal-component>
        <!-- Fim Modal Remove -->

        <!-- Modal Alterar -->
        <modal-component id="modalProdutoAtualizar" titulo="Alterar Produto">

            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="ID">
                        <input type="text" class ="form-control" :value="$store.state.item.id" disabled>
                    </encapsular-component>
                    <encapsular-component titulo="Nome do Produto" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o Nome do Produto">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp"
                               placeholder="Nome do produto" v-model:id="$store.state.item.nome">
                    </encapsular-component>
                    <encapsular-component titulo="Categoria do Produto" id="atualizarCategory_id" id-help="atualizarCategory_idHelp" texto-ajuda="Informe a Categoria do Produto">
                        <input type="number" class="form-control" id="atualizarategory_id" aria-describedby="atualizarCategory_idHelp"
                               placeholder="Seleciona a Categoria" v-model:id="$store.state.item.category_id">
                    </encapsular-component>
                    <hr><p>Opcional</p>
                    <encapsular-component titulo="Descrição do Produto" id="atualizarDescricao" id-help="atualizarDescricaoHelp" texto-ajuda="Informe a Descricao do Produto">
                        <input type="text" class="form-control" id="atualizarDescricao" aria-describedby="atualizarDescricaoHelp"
                               placeholder="Opcional. Descricao do Produto" v-model:id="$store.state.item.descricao">
                    </encapsular-component>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>
        <!-- Fim Modal Alterar -->
    </div>

</template>

<script>
export default{
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/product/',
            urlPaginacao: '',
            urlFiltro: '',
            nomeProduto: '',
            descricaoProduto: '',
            category_idProduto: '',
            //variavel para salvar o estado da instancia do vue
            transacaoStatus: '',
            transacaoDetalhes: {},
            //definindo para vazio, ao invez de indefinido antes do meto assincrono for realizado
            produtos: {data: []},
            busca: {id: '', nome: '', category_id: ''},
        }
    },
    methods: {
        carregarLista() {

            let url = this.urlBase +'?' + this.urlPaginacao + this.urlFiltro

            axios.get(url)
                .then(response => {
                    //dentro de response.data, temos os parametros de paginação
                    this.produtos = response.data // então buscamos os arrays contidos
//                      //this.produtos = response.data.data // podendo ser chamado assim, ou por meio do :dados"x.data"
//                        console.log(this.produtos.data)
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

            //preparando o post com os tipos de parametros que
            //a api espera receber
            let formData = new FormData();
            formData.append('nome', this.nomeProduto)
            formData.append('descricao', this.descricaoProduto)
            formData.append('category_id', this.category_idProduto)

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    //fluxo cadastro correto
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do registro: ' + response.data.id
                    }
                    this.carregarLista()
                })
                .catch(errors => {
                    //fluxo de erro ao cadastrar
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })
        },
        atualizar(){
            let url = this.urlBase + this.$store.state.item.id

            let formData = new FormData();
            formData.append('_method', 'patch')
            formData.append('nome', this.$store.state.item.nome)
            formData.append('category_id', this.$store.state.item.category_id)
            formData.append('descricao', this.$store.state.item.descricao)

            axios.post(url, formData)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro de produto atualizado com sucesso!'
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.dados = errors.response.data.errors
                })
        },
        remover() {
            let url = this.urlBase + this.$store.state.item.id

            let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

            if(!confirmacao) {
                return false
            }

            let formData = new FormData();
            formData.append('_method', 'delete')

            console.log(this.$store.state.transacao)

            axios.post(url, formData)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = response.data.msg
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    //padrao da api
                    this.$store.state.transacao.mensagem = errors.response.data.errors
                    //adicionando uma mensagem direta
                    // this.$store.state.transacao.mensagem = 'Erro ao Remover Registro!'
                })
        },
        pesquisar(){
            let filtro = ''

            for(let chave in this.busca) {
                if(this.busca[chave]) {
                    if(filtro != '') {
                        filtro +=";"
                    }filtro += chave + ':like:' + this.busca[chave]
                }
            }
            if(filtro != ''){
                this.urlPaginacao = 'page=1'
                this.urlFiltro = '&filtro='+filtro
            } else {
                this.urlFiltro = ''
            }
            //dinamicamente envia filtro atualizado quando atualizar lista
            this.carregarLista()
        },
    },
    mounted(){
        this.carregarLista()
    }
}
</script>
