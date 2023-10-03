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
                                horarioInicio: {titulo: 'Inicia', tipo:'text'},
                                horarioFim: {titulo: 'Acaba', tipo:'text'},
                                created_at: {},
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

        <!-- Fim Modal Adiciona -->


        <!-- Inicio Modal Visualizar -->

        <!-- Fim Modal Visualizar -->


        <!-- Inicio modal Remove -->

        <!-- Fim modal Remove -->


        <!-- Inicio Modal Alterar -->

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
        salvar() {},
        atualizar(){},
        remover() {},
        pesquisar(){},
    },
    mounted(){
        this.carregarLista()
    }
}
</script>
