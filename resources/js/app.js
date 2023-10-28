require('./bootstrap');
//Geo location
import VueGeolocation from 'vue-browser-geolocation';
Vue.use(VueGeolocation);
//Google map
import * as VueGoogleMaps from "vue2-google-maps";
Vue.config.productionTip = false;
// AIzaSyDTu0r25qqbH8iInFC2BZN1uVJoEyYAQuM
Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyAKU24WtK0iYrH_BjzFp4jxw7IhZR0eB08",
    libraries: "places"
  },
});
import Vue from 'vue'
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import routes from './routes';
import VueProgressBar from 'vue-progressbar';
import {
    Form,
    // HasError,
    // AlertError
} from 'vform';
// import objectToFormData from 'object-to-formdata';
import Swal from 'sweetalert2';
import Vue2Filters from 'vue2-filters'
import { ValidationProvider, extend } from 'vee-validate';
import Datepicker from 'vuejs-datepicker';
import Datetime from 'vue-datetime';
import moment from 'moment';
import 'moment/locale/fr';
// import Gate from './gate'
import vSelect from 'vue-select'
import '@mdi/font/css/materialdesignicons.css'; // Ensure you are using css-loader
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

//Vuetify
Vue.use(Vuetify);

//Alerts
window.swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});
window.toast = toast;

//Router
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
});

//Form
window.form = Form;

//ProgressBar
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});

//Filters
Vue.use(Vue2Filters);

// //Component Communication
window.Fire = new Vue();

//Pagination
Vue.component('pagination', require('laravel-vue-pagination'));

//Validation
Vue.component('ValidationProvider', ValidationProvider);

//Vue-Select
Vue.component('v-select', vSelect);

//Date
Vue.component('datepicker', Datepicker);

Vue.use(Datetime);

//multiple Images selections
import VueLazyload from 'vue-lazyload';

Vue.use(VueLazyload);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({
        icons: {
          iconfont: 'mdi', // default - only for display purposes
        },
      }),
    router
});