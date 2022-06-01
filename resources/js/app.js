/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css'
Vue.use(Vuesax);

import 'material-icons/iconfont/material-icons.css';
import 'boxicons'

import App from './App.vue';
import store from './store/store';
import {router} from './router';
import i18n from './i18n';


const app = new Vue(Vue.util.extend({
    router,store,i18n
}, App)).$mount('#app');
