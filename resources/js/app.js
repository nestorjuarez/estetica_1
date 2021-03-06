/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('Agenda', require('./components/Agenda.vue').default);

Vue.component('Categorias', require('./components/Categorias.vue').default);
Vue.component('Articulos', require('./components/Articulos.vue').default);
Vue.component('Patients', require('./components/Patients.vue').default);
Vue.component('nuevotrata', require('./components/NuevoTrata.vue').default);
Vue.component('editarservicio', require('./components/EditarServicio.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// import datatables from 'datatables'

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)
// Vue.use(datatables)

const app = new Vue({
    el: '#app',
    data: {
        menu: 0,
    },
});
