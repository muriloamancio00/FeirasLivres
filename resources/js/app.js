/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue'
//importando e configurando o vuex
import Vuex from 'Vuex'
Vue.use(Vuex)

//essa é uma forma de dizer onde esses atributos centralizados serao encontrados
const store = new Vuex.Store({
    state: {
        item: {},
        //de acordo com a situação da transação, irei alimentar o atributo e aplicar nas logicas de feedback
        transacao: {status: '', mensagem: '', dados: ''}
    },
});
export default store;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('update-component', require('./components/UpdateAuthComponent.vue').default);
Vue.component('category-component', require('./components/CategoryComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);
Vue.component('stand-component', require('./components/StandComponent.vue').default);
Vue.component('fair-component', require('./components/FairComponent.vue').default);
Vue.component('faircat-component', require('./components/FairsCategoriesComponent.vue').default);
Vue.component('event-component', require('./components/EventComponent.vue').default);
Vue.component('encapsular-component', require('./components/EncapsularComponent.vue').default);
Vue.component('table-component', require('./components/TableComponent.vue').default);
Vue.component('card-component', require('./components/CardComponent.vue').default);
Vue.component('modal-component', require('./components/ModalComponent.vue').default);
Vue.component('alert-component', require('./components/AlertComponent.vue').default);
Vue.component('paginate-component', require('./components/PaginateComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.filter('formataDataTempoGlobal', function(d) {
    if(!d) return ''

    d = d.split('T')
    let data = d[0]
    let tempo = d[1]

    // formatando data
    data = data.split('-')
    data = data[2] + '/' + data[1] + '/' + data[0]

    tempo = tempo.split('.')
    tempo = tempo[0]

    return data + ' ' + tempo
})

Vue.filter('formataDiasSemana', function(dias) {
    if (!dias || !Array.isArray(dias)) return ''

    const diasSemana = ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"]

    // Ordena os dias de acordo com a ordem da semana
    dias.sort((a, b) => diasSemana.indexOf(a) - diasSemana.indexOf(b))

    // Retorna os dias formatados
    return dias.join(', ')
})


const app = new Vue({
    el: '#app',
    store
});
