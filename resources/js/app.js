require('./bootstrap');

import Vue from 'vue';

import App from "./layouts/App";



/**
 * create a fresh Vue application instance and attach it to the page.
 */
const app = new Vue({
    el: '#app',
    components: {App},
});
