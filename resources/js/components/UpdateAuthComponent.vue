<template>
    <div class="container">
        <div class="row justify-content-center">

            <!-- Esquerda -->
            <div class="col-md-4">
                <!-- Alterar Auth -->

                <card-component titulo="Atualizar informações">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col">
                                <encapsular-component
                                    titulo="Alterar informações"
                                    texto-ajuda="Seção para alterar informações">
                                </encapsular-component>
                            </div>
                            <div class="col">
                                <img src="../../../public/storage/imagens/update.png" alt="UpdateAuth"
                                     class="img-fluid"/>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" @click="toggleUpdate">
                            Exibir/Ocultar
                        </button>
                    </template>
                </card-component>

                <!-- Alterar Auth -->

                <!-- Cadastrar Feirante -->

                <card-component titulo="Solicitação de Cadastros">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col">
                                <encapsular-component
                                    titulo="Todos os Cadastros"
                                    texto-ajuda="Manter Feirantes">
                                </encapsular-component>
                            </div>
                            <div class="col">
                                <img src="../../../public/storage/imagens/feiranteAuth.jpg" alt="CadastrarFeirante"
                                     class="img-fluid"/>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary btn-sm float-right" @click="toggleInputs">
                            Exibir/Ocultar
                        </button>
                    </template>
                </card-component>

                <!-- Cadastrar Feirante -->

                <!-- Meus Dados -->

                <button type="button" class="btn btn-primary btn-sm float-right" @click="toggleDados">
                    Exibir/Ocultar
                </button>

                <!-- Meus Dados -->
            </div>

            <!-- Esquerda -->

            <!-- Direita -->

            <div class="col-md-8" v-if="mostrarInputs || mostrarInputs1 || mostrarDados">

                <!-- Atualizar Auth -->

                <div class="col-md-6" v-if="mostrarInputs">
                    <card-component titulo="Atualizar Perfil">
                        <template v-slot:alerta>
                            <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                            <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
                        </template>
                        <template v-slot:conteudo>
                            <div class="form-group">
                                <encapsular-component titulo="Nome" id="InputNome" id-help="NomeHelp" texto-ajuda="Opcional. Informe o novo nome">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp" placeholder="Novo Nome de Usuario" v-model="$store.state.item.name">
                                </encapsular-component>
                            </div>

                            <div class="form-group">
                                <encapsular-component titulo="Email" id="InputEmail" id-help="EmailHelp" texto-ajuda="Opcional. Informe o novo email">
                                    <input type="text" class="form-control" id="inputEmail" aria-describedby="EmailHelp" placeholder="Novo Email de Usuario" v-model="$store.state.item.email">
                                </encapsular-component>
                            </div>

                            <div class="form-group">
                                <encapsular-component titulo="Senha" id="InputSenha" id-help="SenhaHelp" texto-ajuda="Opcional. Informe a nova senha">
                                    <input type="password" class="form-control" id="inputSenha" aria-describedby="SenhaHelp" placeholder="Nova Senha de Usuario" v-model="$store.state.item.password">
                                </encapsular-component>
                            </div>

                            <div class="form-group">
                                <encapsular-component titulo="Confirmar Senha" id="InputSenha" id-help="SenhaHelp" texto-ajuda="Confirme sua nova senha">
                                    <input type="password" class="form-control" id="inputSenha" aria-describedby="SenhaHelp" placeholder="Nova Senha de Usuario" v-model="$store.state.item.password_confirmation">
                                </encapsular-component>
                            </div>
                        </template>
                        <template v-slot:rodape>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="this.mostrarInputs = false">Fechar</button>
                            <button type="button" class="btn btn-primary btn-sm float-right" @click="atualizar()">Update</button>
                        </template>
                    </card-component>
                </div>

                <!-- Atualizar Auth -->

                <!-- Listar Feirante Cadastro -->

                <div class="col-md-6" v-if="mostrarInputs1">
                    <card-component titulo="Aceitar Cadastros">
                        <template v-slot:conteudo>
                            <div class="form-row">
                                <div class="col">
                                    <encapsular-component
                                        titulo="Listar todos os Feirantes">
                                    </encapsular-component>
                                </div>

                            </div>
                        </template>
                        <template v-slot:rodape>
                            <button type="button" class="btn btn-primary btn-sm float-right">
                                Listar
                            </button>
                        </template>
                    </card-component>
                </div>

                <!-- Listar Feirante Cadastro -->

                <!-- Meus Dados -->

                <div class="col-md-6" v-if="mostrarDados">
                    <div v-if="userData">
                        <input v-model="userData.name" type="text" placeholder="Nome">
                        <input v-model="userData.email" type="email" placeholder="Email">
                        <!-- E assim por diante... -->
                    </div>
                    <div v-else>
                        <p>Usuário não autenticado</p>
                    </div>
                </div>



            </div>

            <!-- Direita -->

            <!-- Footer -->
            <!-- Possivel numero de feirantes cadastrados. -->
            <!-- Footer -->

        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/',
            urlPaginacao: '',
            urlFiltro: '',
            //atributos
            userData: null,
            nome: this.$store.state.item.nome,
            email: this.$store.state.item.email,
            password: this.$store.state.item.password,
            password_confirmation: this.$store.state.item.password_confirmation,
            //Cards
            mostrarInputs: false, // Inicialmente os inputs não são visíveis
            mostrarInputs1: false, // Inicialmente os inputs não são visíveis
            mostrarDados: false, // Inicialmente os inputs não são visíveis
            //
            transacaoStatus: '',
            transacaoDetalhes: {},
            update: {name: '', email: '', password: '', password_confirmation: ''},
        };
    }, methods: {
        toggleUpdate() {
            this.mostrarInputs = !this.mostrarInputs;
            this.mostrarInputs1 = false;
            this.mostrarDados = false;
        },
        toggleInputs() {
            this.mostrarInputs1 = !this.mostrarInputs1;
            this.mostrarInputs = false;
            this.mostrarDados = false;
        },
        toggleDados() {
            this.mostrarDados = !this.mostrarDados;
            this.mostrarInputs = false;
            this.mostrarInputs1 = false;
        },
        atualizar(){
            let url = this.urlBase + 'update_auth/'

            let formData = new FormData();
            formData.append('_method', 'post')
            formData.append('name', this.$store.state.item.name)
            formData.append('email', this.$store.state.item.email)
            formData.append('password', this.$store.state.item.password)
            formData.append('password_confirmation', this.$store.state.item.password_confirmation)

            console.log(formData)


            axios.post(url, formData)
                .then(response => {
                    console.log(response)
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro atualizado!'
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.dados = errors.response.data.errors
                })
        },
        async fetchUserData() {
            try {
                const response = await fetch(this.urlBase + 'me', {
                    method: 'POST',
                });

                if (!response.ok) {
                    throw new Error('Não foi possível obter os dados do usuário');
                }

                const userData = await response.json();
                this.userData = userData;
            } catch (error) {
                console.error(error);
            }
        }
    },
};
</script>

