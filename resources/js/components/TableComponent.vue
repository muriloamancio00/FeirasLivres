<template>
    <div>
        {{ $store.state.teste}}
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" v-for="t, key in titulos" :key="key">{{ t.titulo }}</th>
                <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'text'">{{valor}}</span>
                        <!-- buscar nome do atributo que possui int -->
                        <span v-if="titulos[chaveValor].tipo == 'int'">{{valor}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{valor | formataDataTempoGlobal}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="30" height="30">
                        </span>
                    </td>
                    <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                        <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget" @click="setStore(obj)">Visualizar</button>
                        <button v-if="atualizar.visivel" class="btn btn-outline-dark btn-sm" :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget"  @click="setStore(obj)">Atualizar</button>
                        <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-toggle="remover.dataToggle" :data-target="remover.dataTarget" @click="setStore(obj)">Remover</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['dados', 'titulos', 'visualizar', 'atualizar', 'remover'],
    methods: {
        setStore(obj) {
            //nesse contexto é preciso do this para referenciar
            this.$store.state.item = obj
            this.$store.state.transacao.status = ''
            this.$store.state.transacao.mensagem = ''
            this.$store.state.transacao.dados = ''
        }
    },
    computed: {
        dadosFiltrados() {
            let campos = Object.keys(this.titulos)
            let dadosFiltrados = []

            this.dados.map((item, chave) => { //chave de cada um dos elementos / objt

                let itemFiltrado = {}
                campos.forEach(campo => { //campos a serem apresentados
                    itemFiltrado[campo] = item[campo] //adição de indices, dentro de um indice do objeto
                })
                dadosFiltrados.push(itemFiltrado)

            })
            return dadosFiltrados // retornando um array de objetos
        }
    }
}
</script>
