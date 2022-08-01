/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 require('./bootstrap');
 
 window.Vue = require('vue').default;
 
import vuetify from './router/vuetify';
import router from './router/router'; 
import 'vuetify/dist/vuetify.min.css'

Vue.component('example-component', require('./App.vue').default);


const app = new Vue({
    el: '#app',
    router,
    vuetify
});
