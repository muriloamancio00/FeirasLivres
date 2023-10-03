<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio Busca -->
                <card-component titulo="Busca de Eventos">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <encapsular-component
                                    titulo="ID"
                                    id="InputId"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID do Evento">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                           placeholder="ID do Evento" v-model="busca.id">
                                </encapsular-component>
                            </div>
                        </div>
                        <encapsular-component
                            titulo="Nome do Evento"
                            id="InputNome"
                            id-help="NomeHelp"
                            texto-ajuda="Opcional. Informe o Nome do Evento">

                            <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp"
                                   placeholder="Nome do Evento" v-model="busca.nome">
                        </encapsular-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button></template>
                </card-component>
                <!-- Fim Busca -->

                <!-- Inicio Lista -->
                <card-component titulo="Todos os Evento">
                    <template v-slot:conteudo>
                        <!--os dados precisma ser um array de obj, e os titulos coincidir com os atributos do obj-->
                        <table-component
                            :dados="eventos.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalEventoVizualizar'}"
                            :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalEventoAtualizar'}"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalEventoRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo:'text'},
                                nome: {titulo: 'Nome', tipo:'text'},
                                descricao: {},
                                created_at: {},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <!-- percorrendo todos os links dentro-->
                                    <li v-for="l, key in eventos.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label">
                                        </a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalEvento">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim Lista -->

            </div>
        </div>

        <!-- Inicio Modal Adiciona -->
        <modal-component id="modalEvento" titulo="Adicionar Evento">

            <template v-slot:alerta>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso!" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro, Evento não cadastrado!" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="Nome do Evento" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Evento">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Nome do Evento" v-model:id="nomeEvento">
                    </encapsular-component>
                    <hr><p>Opcional</p>
                    <encapsular-component titulo="Descrição do Evento" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe a Descricao do Evento">
                        <input type="text" class="form-control" id="novoDescricao" aria-describedby="novoDescricaoHelp"
                               placeholder="Opcional. Descricao do Evento" v-model:id="descricaoEvento">
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
        <modal-component id="modalEventoVizualizar" titulo="Visualizar Evento">
            <template v-slot:alerta></template>
            <template v-slot:conteudo>
                <encapsular-component titulo="ID">
                    <input type="text" class ="form-control" :value="$store.state.item.id" disabled>
                </encapsular-component>
                <encapsular-component titulo="Nome do Evento">
                    <input type="text" class ="form-control" :value="$store.state.item.nome" disabled>
                </encapsular-component>
                <encapsular-component titulo="Descricao do Evento">
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
        <modal-component id="modalEventoRemover" titulo="Remover Evento">
            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <encapsular-component titulo="ID">
                    <input type="text" class ="form-control" :value="$store.state.item.id" disabled>
                </encapsular-component>
                <encapsular-component titulo="Nome do Evento">
                    <input type="text" class ="form-control" :value="$store.state.item.nome" disabled>
                </encapsular-component>
            </template>
            <template v-slot:rodape >
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>

        </modal-component>
        <!-- Fim modal Remove -->


        <!-- Inicio Modal Alterar -->
        <modal-component id="modalEventoAtualizar" titulo="Alterar Evento">

            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="ID">
                        <input type="text" class ="form-control" :value="$store.state.item.id" disabled>
                    </encapsular-component>
                    <encapsular-component titulo="Nome do Evento" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o Nome do Evento">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp"
                               placeholder="Nome do Evento" v-model:id="$store.state.item.nome">
                    </encapsular-component>
                    <hr><p>Opcional</p>
                    <encapsular-component titulo="Descrição do Evento" id="atualizarDescricao" id-help="atualizarDescricaoHelp" texto-ajuda="Informe a Descricao do Evento">
                        <input type="text" class="form-control" id="atualizarDescricao" aria-describedby="atualizarDescricaoHelp"
                               placeholder="Opcional. Descricao do Evento" v-model:id="$store.state.item.descricao">
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
export default {
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/event/',
            urlPaginacao: '',
            urlFiltro: '',
            nomeEvento: '',
            descricaoEvento: '',
            //variavel para salvar o estado da instancia do vue
            transacaoStatus: '',
            transacaoDetalhes: {},
            //definindo para vazio, ao invez de indefinido antes do meto assincrono for realizado
            eventos: {data: []},
            busca: {id: '', nome: ''},
        }
    },
    methods: {
        carregarLista() {
            let url = this.urlBase +'?' + this.urlPaginacao + this.urlFiltro

            axios.get(url)
                .then(response => {
                    this.eventos = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        paginacao(l){
            if(l.url){
                this.urlPaginacao = l.url.split('?')[1]
                this.carregarLista()
            }
        },
        salvar() {
            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }
            let formData = new FormData();
            formData.append('nome', this.nomeEvento)
            formData.append('descricao', this.descricaoEvento)

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
            formData.append('descricao', this.$store.state.item.descricao)

            axios.post(url, formData)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro de evento atualizado com sucesso!'
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
                    if (errors.response.status === 500) {
                        // Categoria possui produtos vinculados
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = 'Evento está programado para ocorrer em alguma Feira. Não pode ser removido.';
                    } else {
                        // Outro tipo de erro
                        this.$store.state.transacao.status = 'erro';
                        this.$store.state.transacao.mensagem = errors.response.data.errors;
                    }
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
            this.carregarLista()
        },
    },
    mounted(){
        this.carregarLista()
    }
}
</script>
