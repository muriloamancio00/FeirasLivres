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
                <!-- Fim do card de Busca -->

                <!-- Inicio do card de Listagem de Categorias -->
                <card-component titulo="Todas os Produtos">
                    <template v-slot:conteudo>
                        <!--os dados precisma ser um array de obj, e os titulos coincidir com os atributos do obj-->
                        <table-component
                            :dados="produtos.data"
                            :visualizar="true"
                            :atualizar="true"
                            :remover="true"
                            :titulos="{
                                id: {titulo: 'ID', tipo:'text'},
                                nome: {titulo: 'Nome', tipo:'text'},
                                descricao: {titulo: 'Descrição', tipo:'text'},
                                category_id: {titulo: 'Categoria', tipo:'int'},
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
                                            <!--{{l}}, dentro dele cada um possui um unico label -->
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
                <!-- Fim da Listagem de Categorias -->
            </div>
        </div>

        <!-- Button modal Adição de Produtos -->
        <modal-component id="modalProduto" titulo="Adicionar Produto">

            <template v-slot:alerta>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso!" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro, Produto não cadastrado!" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="Nome do Produto" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome do produto">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Nome do produto" v-model:id="nomeProduto">
                    </encapsular-component>
                    {{ nomeProduto }}
                    <encapsular-component titulo="Descrição do Produto" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe o descricao da produto">
                        <input type="text" class="form-control" id="novoDescricao" aria-describedby="novoDescricaoHelp"
                               placeholder="Opcional. Descricao" v-model:id="descricaoProduto">
                    </encapsular-component>
                    {{ descricaoProduto }}
                    <hr><p>Imagem do produto</p>
                    <div class="form-group">
                        <encapsular-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">
                            <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                        </encapsular-component>
                        {{ arquivoImagem }}
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- Fim Button modal Adição de Produtos -->

        <!-- Button modal Visualização de Produtos -->
        <modal-component id="modalProdutoVisualizar" titulo="Visualizar Produto">
                <template v-slot:alerta></template>
                <template v-slot:conteudo>Teste</template>
                <template v-slot:rodape>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </template>

        </modal-component>
        <!-- Fim Button modal Visualização de Produtos -->
    </div>

</template>

<script>
    export default{
        computed: {
            token() {
                //separando valores do cookie
                let token = document.cookie.split(';').find(indice =>{
                    //busca busca o token
                    return indice.includes('token=')
                })

                //separa apenas o conteudo do token
                token = token.split('=') [1]
                token = 'Bearer ' + token

                //token formado
                return token
            }
        },
        data() {
            return {
                urlBase: 'http://127.0.0.1:8000/api/v1/product/',
                urlPaginacao: '',
                urlFiltro: '',
                nomeProduto: '',
                descricaoProduto: '',
                arquivoImagem: [],
                //variavel para salvar o estado da instancia do vue
                transacaoStatus: '',
                transacaoDetalhes: {},
                //definindo para vazio, ao invez de indefinido antes do meto assincrono for realizado
                produtos: {data: []},
                busca: {id: '', nome: '', category_id: ''},
            }
        },
        methods: {
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
            }
            ,
            paginacao(l){
                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization' : this.token,
                    }
                }
                //se for valido
                if(l.url){
                    this.urlPaginacao = l.url.split('?')[1] // ajustando a url com o paramêtro de pagina
                    this.carregarLista() // requisita dnv para API
                }
            }
            ,
            carregarLista() {

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization' : this.token,
                    }
                }
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
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {
                console.log(this.descricaoProduto,this.nomeProduto,this.arquivoImagem[0])

                //preparando o post com os tipos de parametros que
                //a api espera receber

                let formData = new FormData();
                formData.append('nome', this.nomeProduto)
                formData.append('descricao', this.descricaoProduto)
                formData.append('category_id', '2')
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Accept': 'application/json',
                        //compatibilidade com token vindo do backend
                        'Authorization' : this.token,
                    }
                }

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        //fluxo cadastro correto
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id
                        }
                    })
                    .catch(errors => {
                        //fluxo de erro ao cadastrar
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = {
                            mensagem: errors.response.data.message,
                            dados: errors.response.data.errors
                        }
                    })
            }
        },
        mounted(){
            this.carregarLista()
        }
    }
</script>
