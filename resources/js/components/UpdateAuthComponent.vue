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
            </div>

            <!-- Esquerda -->

            <!-- Direita -->

            <div class="col-md-8" v-if="mostrarInputs || mostrarInputs1">

                <!-- Atualizar Auth -->

                <div class="col-md-6" v-if="mostrarInputs">
                    <card-component titulo="Atualizar Perfil">
                        <template v-slot:conteudo>
                            <div class="form-group">
                                <encapsular-component titulo="Nome" id="InputNome" id-help="NomeHelp" texto-ajuda="Opcional. Informe o novo nome">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="NomeHelp" placeholder="Novo Nome de Usuario" v-model="update.nome">
                                </encapsular-component>
                            </div>

                            <div class="form-group">
                                <encapsular-component titulo="Email" id="InputEmail" id-help="EmailHelp" texto-ajuda="Opcional. Informe o novo email">
                                    <input type="text" class="form-control" id="inputEmail" aria-describedby="EmailHelp" placeholder="Novo Email de Usuario" v-model="update.email">
                                </encapsular-component>
                            </div>

                            <div class="form-group">
                                <encapsular-component titulo="Senha" id="InputSenha" id-help="SenhaHelp" texto-ajuda="Opcional. Informe a nova senha">
                                    <input type="password" class="form-control" id="inputSenha" aria-describedby="SenhaHelp" placeholder="Nova Senha de Usuario" v-model="update.password">
                                </encapsular-component>
                            </div>

                            <div class="form-group">
                                <encapsular-component titulo="Confirmar Senha" id="InputSenha" id-help="SenhaHelp" texto-ajuda="Confirme sua nova senha">
                                    <input type="password" class="form-control" id="inputSenha" aria-describedby="SenhaHelp" placeholder="Nova Senha de Usuario" v-model="update.password_confirmation">
                                </encapsular-component>
                            </div>
                        </template>
                        <template v-slot:rodape>
                            <button type="button" class="btn btn-primary btn-sm float-right">Update</button>
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
            mostrarInputs: false, // Inicialmente os inputs não são visíveis
            mostrarInputs1: false, // Inicialmente os inputs não são visíveis
            update: {name: '', email: '', password: '', password_confirmation: ''},
        };
    }, methods: {
        toggleUpdate() {
            this.mostrarInputs = !this.mostrarInputs;
            this.mostrarInputs1 = false; // Garante que apenas um card seja exibido de cada vez
        },
        toggleInputs() {
            this.mostrarInputs1 = !this.mostrarInputs1;
            this.mostrarInputs = false; // Garante que apenas um card seja exibido de cada vez
        },
    },
    atualizar(){

    },
};
</script>

