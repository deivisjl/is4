/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require('vue');

window.$ = window.jQuery = require('jquery');
window.$.fn.DataTable = require( 'datatables.net' );
window.$.fn.DataTable = require( 'datatables.net-bs4' );

window.Swal = require('sweetalert2');
window.Toastr = require('toastr');

require('./bootstrap');

import VeeValidate from 'vee-validate';
import ChartKick from 'vue-chartkick';
import Chart from 'chart.js';


const VueValidationEs = require('vee-validate/dist/locale/es');

const config = {
  locale: 'es',
  validity: true,
  dictionary: {
    es: VueValidationEs
  },
  fieldsBagName: 'campos',
  errorBagName: 'errors', // change if property conflicts
};

Vue.use(VeeValidate, config);
Vue.use(ChartKick.use(Chart))

window.events = new Vue();

Vue.prototype.$eventHub = new Vue(); // Global event bus
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/* Vue.component('example-component', require('./components/ExampleComponent.vue').default); */
Vue.component('error-form', require('./components/shared/ErrorComponent').default);

Vue.component('loading', require('./components/shared/LoadingComponent.vue').default);
Vue.component('curso-docente-component', require('./components/curso-docente/CursoDocenteComponent.vue').default);

Vue.component('aula-detalle-component', require('./components/aula/AulaInscritoComponent.vue').default);

Vue.component('inscripcion-component', require('./components/inscrito/InscripcionComponent.vue').default);
Vue.component('curso-profesor-component', require('./components/notas/CursoProfesorComponent.vue').default);
Vue.component('actualizar-nota-component', require('./components/notas/ActualizarNotaComponent').default);

Vue.component('nota-aula-component', require('./components/reporte/notas/NotaAulaComponent.vue').default);

Vue.component('pago-component', require('./components/pagos/PagoComponent.vue').default);

Vue.component('ingreso-carrera-component',require('./components/graficos/IngresoCarreraComponent.vue').default);
Vue.component('ingreso-mes-component',require('./components/graficos/IngresoMesComponent.vue').default);

Vue.component('profesor-curso-component',require('./components/graficos/ProfesorCursoComponent.vue').default);
Vue.component('alumno-carrera-component',require('./components/graficos/AlumnoCarreraComponent.vue').default);
Vue.component('inscrito-genero-component',require('./components/graficos/InscritoGeneroComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
