<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">


                <!-- início do card de busca -->
                <card-component titulo="Busca de Categorias">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <encapsular-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da Categoria">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </encapsular-component>
                            </div>
                            <div class="col mb-3">
                                <encapsular-component titulo="Nome da Categoria" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da Categoria">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da Categoria" v-model="busca.nome">
                                </encapsular-component>
                            </div>

                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- fim do card de busca -->


                <!-- início do card de listagem de categorias -->
                <card-component titulo="Todas as Categorias">
                    <template v-slot:conteudo>
                        <!--os dados precisma ser um array de obj, e os titulos coincidir com os atributos do obj-->
                        <table-component
                            :dados="categorias.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalCategoriaVizualizar'}"
                            :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalCategoriaAtualizar'}"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalCategoriaRemover'}"
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
                <!-- fim do card de listagem de categorias -->
                </card-component>
            </div>
        </div>

        <!-- Modal Adiciona -->
        <modal-component id="modalCategoria" titulo="Adicionar Categoria">

            <template v-slot:alerta>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso!" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro, Categoria não cadastrada!" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="Nome da Categoria" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome da Categoria">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Nome da categoria" v-model:id="nomeCategoria">
                    </encapsular-component>
                    <hr><p>Opcional</p>
                    <encapsular-component titulo="Descrição da Categoria" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe a Descricao da Categoria">
                        <input type="text" class="form-control" id="novoDescricao" aria-describedby="novoDescricaoHelp"
                               placeholder="Opcional. Descricao da Categoria" v-model:id="descricaoCategoria">
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
                <encapsular-component titulo="Nome da Categoria">
                    <input type="text" class ="form-control" :value="$store.state.item.nome" disabled>
                </encapsular-component>
                <encapsular-component titulo="Descricao da Categoria">
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

        <!-- Inicio modal Remove -->
        <modal-component id="modalCategoriaRemover" titulo="Remover Categoria">
            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <encapsular-component titulo="ID">
                    <input type="text" class ="form-control" :value="$store.state.item.id" disabled>
                </encapsular-component>
                <encapsular-component titulo="Nome da Categoria">
                    <input type="text" class ="form-control" :value="$store.state.item.nome" disabled>
                </encapsular-component>
            </template>
            <template v-slot:rodape >
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>

        </modal-component>
        <!-- Fim Modal Remove -->

        <!-- Início Modal Atualiza -->
        <modal-component id="modalCategoriaAtualizar" titulo="Atualizar Categoria">

            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="Nome da Categoria" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o Nome da Categoria">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp" placeholder="Nome da Categoria" v-model="$store.state.item.nome">
                    </encapsular-component>
                    <encapsular-component titulo="Descrição da Categoria" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe a Descricao da Categoria">
                        <input type="text" class="form-control" id="novoDescricao" aria-describedby="novoDescricaoHelp"
                               placeholder="Opcional. Descricao da Categoria" v-model:id="$store.state.item.descricao">
                    </encapsular-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>
        <!-- Fim Modal Atualiza -->

    </div>
</template>

<script>
export default {
    computed: {
        token() {

            let token = document.cookie.split(';').find(indice => {
                return indice.includes('token=')
            })

            token = token.split('=')[1]
            token = 'Bearer ' + token

            return token
        }
    },
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/category/',
            urlPaginacao: '',
            urlFiltro: '',
            nomeCategoria: '',
            descricaoCategoria: '',
            //
            transacaoStatus: '',
            transacaoDetalhes: {},
            //
            categorias: {data: []},
            //campos para buscar categorias
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
        remover() {
            let url = this.urlBase + this.$store.state.item.id

            let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

            if(!confirmacao) {
                return false;
            }

            let formData = new FormData();
            formData.append('_method', 'delete')

            axios.post(url, formData)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = response.data.msg
                    this.carregarLista()
                })
                .catch(errors => {
                    if (errors.response.status === 500) {
                        // Categoria possui produtos vinculados
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = 'Esta categoria possui produtos vinculados e não pode ser removida.';
                    } else {
                        // Outro tipo de erro
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response.data.errors;
                    }
                });
        },
        atualizar() {

            let formData = new FormData();
            formData.append('_method', 'patch')
            formData.append('nome', this.$store.state.item.nome)
            formData.append('descricao', this.$store.state.item.descricao)

            let url = this.urlBase + this.$store.state.item.id

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }

            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro de Categorias atualizado com sucesso!'

                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = errors.response.data.message
                    this.$store.state.transacao.dados = errors.response.data.errors
                })
        },

    },
    mounted() {
        this.carregarLista()
    }
}
</script>
