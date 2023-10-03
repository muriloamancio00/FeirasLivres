<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio Busca -->
                <card-component titulo="Busca de Feiras">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col">
                                <encapsular-component
                                    titulo="ID"
                                    id="InputId"
                                    id-help="idHelp"
                                    texto-ajuda="Opcional. Informe o ID do Feira">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                           placeholder="ID do Feira" v-model="busca.id">
                                </encapsular-component>
                            </div>
                            <div class="col">
                                <encapsular-component
                                    titulo="Nome da Feira"
                                    id="InputNome"
                                    id-help="NomeHelp"
                                    texto-ajuda="Opcional. Informe o Nome da Feira">

                                    <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp"
                                           placeholder="Nome da Feira" v-model="busca.nome">
                                </encapsular-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button></template>
                </card-component>
                <!-- Fim Busca -->

                <!-- Inicio Lista -->
                <card-component titulo="Todas os Feiras">
                    <template v-slot:conteudo>
                        <!--os dados precisma ser um array de obj, e os titulos coincidir com os atributos do obj-->
                        <table-component
                            :dados="feiras.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalFeiraVizualizar'}"
                            :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalFeiraAtualizar'}"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalFeiraRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo:'text'},
                                nome: {titulo: 'Nome', tipo:'text'},
                                endereco: {},
                                horarioInicio: {titulo: 'Inicia', tipo:'text'},
                                horarioFim: {titulo: 'Acaba', tipo:'text'},
                                longitude: {},
                                latitude: {},
                                created_at: {},
                                updated_at: {},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <!-- percorrendo todos os links dentro-->
                                    <li v-for="l, key in feiras.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label">
                                        </a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalFeira">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim Lista -->

            </div>
        </div>

        <!-- Inicio Modal Adiciona -->
        <modal-component id="modalFeira" titulo="Adicionar Feira">

            <template v-slot:alerta>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso!" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro, Feira não cadastrada!" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <encapsular-component titulo="Nome do Feira" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Produto">
                                    <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                                           placeholder="Nome da Feira" v-model:id="nomeFeira">
                                </encapsular-component>
                            </div>
                            <div class="form-group">
                                <encapsular-component titulo="Endereço da Feira" id="novoEndereco" id-help="novoEnderecoHelp" texto-ajuda="Informe o Endereço da Feira">
                                    <input type="text" class="form-control" id="novoEndereco" aria-describedby="novoEnderecoHelp"
                                           placeholder="Endereço da Feira" v-model:id="enderecoFeira">
                                </encapsular-component>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <encapsular-component titulo="Horário de Início da Feira" id="novoHorarioInicio" id-help="novoHorarioInicioHelp" texto-ajuda="Informe o Horário de Início da Feira">
                                    <input type="text" class="form-control" id="novoHorarioInicio" aria-describedby="novoHorarioInicioHelp"
                                           placeholder="Horário, ex 12:00" v-model:id="horarioInicioFeira">
                                </encapsular-component>
                            </div>
                            <div class="form-group">
                                <encapsular-component titulo="Horário de Fim da Feira" id="novoHorarioFim" id-help="novoHorarioFimHelp" texto-ajuda="Informe o Horário de Fim da Feira">
                                    <input type="text" class="form-control" id="novoHorarioFim" aria-describedby="novoHorarioFimHelp"
                                           placeholder="Horário, ex 24:00" v-model:id="horarioFimFeira">
                                </encapsular-component>
                            </div>
                        </div>
                    </div>
                    <hr><p>Opcional</p>
                    <div class="row">
                        <div class="col-md-6">
                                <encapsular-component titulo="Longitude da Feira" id="novaLongitude" id-help="novaLongitudeHelp" texto-ajuda="Informe a Longitude da Feira">
                                    <input type="text" class="form-control" id="novaLongitude" aria-describedby="novaLongitudeHelp"
                                           placeholder="Opcional. Longitude da Feira" v-model:id="longitudeFeira">
                                </encapsular-component>
                        </div>
                        <div class="col-md-6">
                                <encapsular-component titulo="Latitude da Feira" id="novaLatitude" id-help="novaLatitudeHelp" texto-ajuda="Informe a Latitude da Feira">
                                    <input type="text" class="form-control" id="novaLatitude" aria-describedby="novaLatitudeHelp"
                                           placeholder="Opcional. Latitude da Feira" v-model:id="latitudeFeira">
                                </encapsular-component>
                        </div>
                    </div>
                </div>
            </template>


            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- Fim Modal Adiciona -->

        <!-- Inicio Modal Visualizar -->
        <modal-component id="modalFeiraVizualizar" titulo="Visualizar Feira">
            <template v-slot:alerta></template>
            <template v-slot:conteudo>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <encapsular-component titulo="ID">
                                <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                            </encapsular-component>
                            <encapsular-component titulo="Inicio da Feira">
                                <input type="text" class="form-control" :value="$store.state.item.horarioInicio" disabled>
                            </encapsular-component>
                            <encapsular-component titulo="Fim da Feira">
                                <input type="text" class="form-control" :value="$store.state.item.horarioFim" disabled>
                            </encapsular-component>
                        </div>
                        <div class="col-md-6">
                            <encapsular-component titulo="Nome da Feira">
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            </encapsular-component>
                            <encapsular-component titulo="Data de Criação">
                                <input type="data" class="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal" disabled>
                            </encapsular-component>
                            <encapsular-component titulo="Data de Atualização">
                                <input type="data" class="form-control" :value="$store.state.item.updated_at | formataDataTempoGlobal" disabled>
                            </encapsular-component>
                        </div>
                        <hr><p></p>
                        <div class="col-md-12">
                            <encapsular-component titulo="Endereço da Feira">
                                <input type="text" class="form-control" :value="$store.state.item.endereco" disabled>
                            </encapsular-component>
                            <encapsular-component titulo="Longitude">
                                <input type="text" class="form-control" :value="$store.state.item.longitude" disabled>
                            </encapsular-component>
                            <encapsular-component titulo="Latitude">
                                <input type="text" class="form-control" :value="$store.state.item.latitude" disabled>
                            </encapsular-component>
                        </div>
                    </div>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>

        </modal-component>
        <!-- Fim Modal Visualizar -->

        <!-- Inicio modal Remove -->
        <modal-component id="modalFeiraRemover" titulo="Remover Feira">
            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <encapsular-component titulo="ID">
                    <input type="text" class ="form-control" :value="$store.state.item.id" disabled>
                </encapsular-component>
                <encapsular-component titulo="Nome da Feira">
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
        <modal-component id="modalFeiraAtualizar" titulo="Alterar Feira">
            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <encapsular-component titulo="ID">
                        <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                    </encapsular-component>
                    <encapsular-component titulo="Nome do Feira" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o Nome da Feira">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp"
                               placeholder="Nome da Feira" v-model="$store.state.item.nome">
                    </encapsular-component>
                    <encapsular-component titulo="Endereço da Feira" id="atualizarEndereco" id-help="atualizarEnderecoHelp" texto-ajuda="Informe o Endereço da Feira">
                        <input type="text" class="form-control" id="atualizarEndereco" aria-describedby="atualizarEnderecoHelp"
                               placeholder="Endereço da Feira" v-model="$store.state.item.endereco">
                    </encapsular-component>
                    <encapsular-component titulo="Horário de Início da Feira" id="atualizarHorarioInicio" id-help="atualizarHorarioInicioHelp" texto-ajuda="Informe o Horário de Início da Feira">
                        <input type="text" class="form-control" id="atualizarHorarioInicio" aria-describedby="atualizarHorarioInicioHelp"
                               placeholder="Horário de Início da Feira" v-model="$store.state.item.horarioInicio">
                    </encapsular-component>
                    <encapsular-component titulo="Horário de Fim da Feira" id="atualizarHorarioFim" id-help="atualizarHorarioFimHelp" texto-ajuda="Informe o Horário de Fim da Feira">
                        <input type="text" class="form-control" id="atualizarHorarioFim" aria-describedby="atualizarHorarioFimHelp"
                               placeholder="Horário de Fim da Feira" v-model="$store.state.item.horarioFim">
                    </encapsular-component>
                    <div class="row">
                        <div class="col-md-6">
                            <encapsular-component titulo="Longitude da Feira" id="atualizarLongitude" id-help="atualizarLongitudeHelp" texto-ajuda="Informe a Longitude da Feira">
                                <input type="text" class="form-control" id="atualizarLongitude" aria-describedby="atualizarLongitudeHelp"
                                       placeholder="Longitude da Feira" v-model="$store.state.item.longitude">
                            </encapsular-component>
                        </div>
                        <div class="col-md-6">
                            <encapsular-component titulo="Latitude da Feira" id="atualizarLatitude" id-help="atualizarLatitudeHelp" texto-ajuda="Informe a Latitude da Feira">
                                <input type="text" class="form-control" id="atualizarLatitude" aria-describedby="atualizarLatitudeHelp"
                                       placeholder="Latitude da Feira" v-model="$store.state.item.latitude">
                            </encapsular-component>
                        </div>
                    </div>
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
            urlBase: 'http://127.0.0.1:8000/api/v1/fair/',
            urlPaginacao: '',
            urlFiltro: '',
            //atributos
            nomeFeira: '',
            enderecoFeira: '',
            horarioInicioFeira: '',
            horarioFimFeira: '',
            longitudeFeira: '',
            latitudeFeira: '',
            //variavel para salvar o estado da instancia do vue
            transacaoStatus: '',
            transacaoDetalhes: {},
            //definindo para vazio, ao invez de indefinido antes do meto assincrono for realizado
            feiras: {data: []},
            busca: {id: '', nome: ''},
        }
    },
    methods: {
        carregarLista() {
            let url = this.urlBase +'?' + this.urlPaginacao + this.urlFiltro

            axios.get(url)
                .then(response => {
                    this.feiras = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        paginacao(l){
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
            formData.append('nome', this.nomeFeira)
            formData.append('endereco', this.enderecoFeira)
            formData.append('horarioInicio', this.horarioInicioFeira)
            formData.append('horarioFim', this.horarioFimFeira)
            formData.append('longitude', this.longitudeFeira)
            formData.append('latitude', this.latitudeFeira)

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
            formData.append('endereco', this.$store.state.item.endereco)
            formData.append('horarioInicio', this.$store.state.item.horarioInicio)
            formData.append('horarioFim', this.$store.state.item.horarioFim)
            formData.append('longitude', this.$store.state.item.longitude)
            formData.append('latitude', this.$store.state.item.latitude)


            axios.post(url, formData)
                .then(response => {
                    console.log(response)
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro de feira atualizado com sucesso!'
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
                    this.$store.state.transacao.mensagem = errors.response.data.errors
                })
        },
        pesquisar(){},
    },
    mounted(){
        this.carregarLista()
    }
}
</script>
