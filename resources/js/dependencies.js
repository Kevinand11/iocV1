window.$ = window.jQuery = require("jquery");
window._ = require("lodash");
window.Popper = require('popper.js').default;

require("bootstrap");

import Vue from "vue";
import _ from "@fortawesome/fontawesome-free";
import Moment from "moment";
import {Form,HasError} from "vform";
import VueProgressBar from "vue-progressbar";
import Spinner from "vue-simple-spinner"
import swal from 'sweetalert2'
import Pagination from 'laravel-vue-pagination'

Vue.component(HasError.name,HasError);
Vue.component(Spinner.name,Spinner);
Vue.component("pagination",Pagination);

Vue.use(VueProgressBar,{
    color: "rgb(143,255,199)",
    failedColor: "red",
    height: "6px",
})

window.moment = Moment;
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