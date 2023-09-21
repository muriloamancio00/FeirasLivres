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
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right ">Pesquisar</button></template>
                </card-component>
                <!-- Fim do card de Busca -->

                <!-- Inicio do card de Listagem de Categorias -->
                <card-component titulo="Todas os Produtos">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalProduto">Adicionar</button>
                    </template>
                </card-component>
                <!-- Fim da Listagem de Categorias -->
            </div>
        </div>
        <!-- Button trigger modal -->
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

        <button type="button" @click="carregarLista()">Teste</button>
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
                nomeProduto: '',
                descricaoProduto: '',
                arquivoImagem: [],
                //variavel para salvar o estado da instancia do vue
                transacaoStatus: '',
                transacaoDetalhes: {},
            }
        },
        methods: {
            carregarLista() {
                axios.get(this.urlBase)
                    .then(response => {
                        console.log(response.data)
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
    }
</script>
