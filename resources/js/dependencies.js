window.$ = window.jQuery = require("jquery");
window._ = require("lodash");
window.Popper = require('popper.js').default;

require("bootstrap");
require("admin-lte");

import Vue from "vue";
import _ from "@fortawesome/fontawesome-free";
import Moment from "moment";
import {Form,HasError,AlertError} from "vform";
import VueProgressBar from "vue-progressbar";
import swal from 'sweetalert2'

Vue.component(HasError.name,HasError);
Vue.component(AlertError.name,AlertError);
Vue.use(VueProgressBar,{
    color: "rgb(143,255,199)",
    failedColor: "red",
    height: "4px",
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