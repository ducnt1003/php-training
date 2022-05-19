/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
Vue.use(VueRouter);

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

import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import UserComponent from './components/UserComponent.vue';
import Error404Component from './components/errors/404Component.vue';
import Error403Component from './components/errors/403Component.vue';
import Error500Component from './components/errors/500Component.vue';
import { httpClient } from './config/httpClient';
Vue.prototype.$httpClient = httpClient;
const routes = [{
        name: 'example',
        path: '/',
        component: ExampleComponent
    },
    {
        name: 'login',
        path: '/login',
        component: LoginComponent
    },
    {
        name: 'users',
        path: '/users',
        component: UserComponent
    },
    {
        path: '/:pathMatch(.*)*',
        name: '/errors404',
        component: Error404Component
    },

    {
        name: 'errors403',
        path: '/errors403',
        component: Error403Component,

    },
    {
        name: 'errors500',
        path: '/errors500',
        component: Error500Component,

    },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue(Vue.util.extend({
    router,store
}, App)).$mount('#app');
