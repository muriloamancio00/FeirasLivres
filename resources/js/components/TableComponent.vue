<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" v-for="t, key in titulos" :key="key">{{ t.titulo }}</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'text'">{{valor}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'int'">{{valor}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="30" height="30">
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['dados', 'titulos'],
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
