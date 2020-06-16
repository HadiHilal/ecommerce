// vue
window.Vue = require("vue");
// vue router
import VueRouter from "vue-router";
Vue.use(VueRouter);

// moment js
import moment from "moment";
// sweat alert
import Swal from "sweetalert2";
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});


window.Toast = Toast;

//fire
window.Fire = new Vue();

// gate
import Gate from './gate'
Vue.prototype.$gate = new Gate(window.user)

// pagination
Vue.component('pagination', require('laravel-vue-pagination'));

import { Form, HasError, AlertError } from "vform";
window.Form = Form;

// components
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
import Users    from "./components/admin/Users.vue";
import Categos   from "./components/admin/Categos.vue";
import Products from "./components/admin/Products.vue";
import Orders   from "./components/admin/Orders.vue";
import Home  from "./components/admin/Home.vue";
import Reviews  from "./components/admin/Reviews.vue";
import Ordershow   from "./components/admin/Ordershow.vue";
import Notfound from "./components/Notfound.vue";
import Welcome from "./components/Welcome.vue";
import Mains from "./components/Mains.vue";
import StarRating from 'vue-star-rating';

Vue.component("Users", Users);
Vue.component("Categos", Categos);
Vue.component("Products", Products);
Vue.component("Orders", Orders);
Vue.component("Ordershow", Ordershow);
Vue.component("Notfound", Notfound);
Vue.component("welcome", Welcome);
Vue.component("Home", Home);
Vue.component("Reviews", Reviews);
Vue.component("Mains", Mains);



Vue.component('star-rating', StarRating);

// progress bar
import VueProgressBar from "vue-progressbar";

// progress bar
const options = {
    color: "#bffaf3",
    failedColor: "#874b4b",
    thickness: "5px",
    transition: {
        speed: ".8s",
        opacity: "0.6s",
        termination: 300
    },
    autoRevert: true,
    location: "top",
    inverse: false
};

Vue.use(VueProgressBar, options);

// cabital filters
Vue.filter("upText", function(txt) {
    return txt.charAt(0).toUpperCase() + txt.slice(1);
});

// humun date filters
Vue.filter("hmDate", function(crt) {
    return moment(crt)
        .startOf("hour")
        .fromNow();
});

// routs
const routes = [

    { path: "/users",    component: Users },
    { path: "/categos",   component: Categos },
    { path: "/products", component: Products},
    { path: "/orders",   component: Orders },
    { path: "/Home",   component: Home },
    { path: "/reviews",   component: Reviews },
    { path: "*",         component: Notfound }
];9

const router = new VueRouter({
    routes: routes,
    mode: "history"
});

const app = new Vue({
    el: '#app',
    router,
    components:{
        Welcome ,
        Mains
    },
    data:{
        search : ''
    },
    methods:{
        searchit : _.debounce(() => {
            Fire.$emit('searching')
        }, 700)
    }
});
