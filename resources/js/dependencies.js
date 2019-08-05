window.$ = window.jQuery = require("jquery");
window.Popper = require('popper.js').default;

import isEmpty from 'lodash/isEmpty';
import includes from 'lodash/includes';
window._ = window.lodash = {isEmpty,includes};

import __ from "bootstrap/dist/js/bootstrap.min";
import ___ from '@fortawesome/fontawesome-free/js/fontawesome.min'

import Vue from "vue";
import {Form,HasError} from 'vform/dist/vform.umd.min';
import VueProgressBar from "vue-progressbar";
import Spinner from "vue-simple-spinner"
import swal from 'sweetalert2';
import Pagination from 'laravel-vue-pagination'

Vue.component(HasError.name,HasError);
Vue.component(Spinner.name,Spinner);
Vue.component("pagination",Pagination);

Vue.use(VueProgressBar,{
    color: "rgb(143,255,199)",
    failedColor: "rgb(255,0,0)",
    height: "6px",
});

window.Form = Form;
window.Fire = new Vue();

window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;

window.axios = require("axios");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
Vue.prototype.$http = window.axios;
