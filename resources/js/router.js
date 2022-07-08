import Vue from "vue";
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import store from './store/store';

import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import UserComponent from './components/User/UserComponent.vue';
import Error404Component from './components/errors/404Component.vue';
import Error403Component from './components/errors/403Component.vue';
import Error500Component from './components/errors/500Component.vue';
const routes = [{
        name: 'home',
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
        component: UserComponent,
        meta: {
            role: ["SuperAdmin","Admin"]
        }
    },
    {
        name: 'error403',
        path: '/error403',
        component: Error403Component,

    },
    {
        name: 'error500',
        path: '/error500',
        component: Error500Component,

    },
    {
        path: '/:pathMatch(.*)*',
        name: '/error404',
        component: Error404Component
    },
];

export const router = new VueRouter({
    mode: 'history',
    routes: routes
});
router.beforeEach((to, from, next) => {
    // chuyển đến trang login nếu chưa được login
    const role  = to.meta.role|| [];
    const user = JSON.parse(localStorage.getItem('user'));
    //const role_user = localStorage.getItem('roleuser');
    const publicPages = ['/login'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('usertoken');

    if (authRequired && !loggedIn) {
        localStorage.setItem("redirectPath", to.path);
        return next('/login');
    }
    if(loggedIn){
        if (role.length && !role.includes(user.role)) {
            return next({name:'error403'});
        }
    }

    next();
})
