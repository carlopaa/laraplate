/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import store from 'scripts/store';
import ajaxify from 'scripts/modules/ajaxify';

window.Vue = require('vue');

/**
 * Use VueStash for easy state management
 */
import VueStash from 'vue-stash';
Vue.use(VueStash);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        store
    }
});

const form = document.querySelector('.form-ajax');
if (form) {
    form.addEventListener('submit', e => {
        e.preventDefault();

        ajaxify(form);
    });
}
