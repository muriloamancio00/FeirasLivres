<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio Busca -->
                <card-component titulo="Feiras - Categorias">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col">
                                <encapsular-component
                                    titulo="ID Categoria"
                                    id="inputCategoria"
                                    id-help="CategoriaHelp"
                                    texto-ajuda="Opcional. Informe o ID Categoria">

                                    <input type="text" class="form-control" id="inputCategoria" aria-describedby="CategoriaHelp"
                                           placeholder="ID Categoria" v-model="busca.category_id">
                                </encapsular-component>
                            </div>
                            <div class="col">
                                <encapsular-component
                                    titulo="ID Feira"
                                    id="inputFeira"
                                    id-help="FeiraHelp"
                                    texto-ajuda="Opcional. Informe o ID Feira">

                                    <input type="text" class="form-control" id="inputFeira" aria-describedby="FeiraHelp"
                                           placeholder="ID Feira" v-model="busca.fair_id">
                                </encapsular-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button></template>
                </card-component>
                <!-- Fim Busca -->

                <!-- Inicio Lista -->
                <card-component titulo="Todas os Relacionamentos">
                    <template v-slot:conteudo>
                        <!--os dados precisma ser um array de obj, e os titulos coincidir com os atributos do obj-->
                        <table-component
                            :dados="feiraCat.data"
                            :visualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalFeiraCatVizualizar'}"
                            :atualizar="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalFeiraCatAtualizar'}"
                            :remover="{ visivel: true, dataToggle: 'modal', dataTarget: '#modalFeiraCatRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo:'text'},
                                fair_id: {titulo: 'Feira', tipo:'text'},
                                category_id: {titulo: 'Categoria', tipo:'text'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <!-- percorrendo todos os links dentro-->
                                    <li v-for="l, key in feiraCat.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label">
                                        </a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalfeiraCat">Adicionar</button>
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
            urlBase: 'http://127.0.0.1:8000/api/v1/fairs_categories',
            urlPaginacao: '',
            urlFiltro: '',
            //atributos
            idFeiraCat: '',
            fair_idFeiraCat: '',
            category_idFeiraCat: '',
            //variavel para salvar o estado da instancia do vue
            transacaoStatus: '',
            transacaoDetalhes: {},
            //definindo para vazio, ao invez de indefinido antes do meto assincrono for realizado
            feiraCat: {data: []},
            busca: {category_id: '', fair_id: ''},
        }
    },
    methods: {
        carregarLista() {
            let url = this.urlBase +'?' + this.urlPaginacao + this.urlFiltro

            console.log(url)

            axios.get(url)
                .then(response => {
                    this.feiraCat = response.data
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
