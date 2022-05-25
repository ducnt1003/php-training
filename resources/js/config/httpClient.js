import Vue from "vue";
import VueAxios from 'vue-axios';
import axios from 'axios';
import { router } from "../router";
import store from '../store/store';
Vue.use(VueAxios, axios);


const httpClient = axios.create({
    baseURL:process.env.MIX_PUSHER_API_ENDPOINT,
    // timeout: 3000,
    // headers: {
    //     "Content-Type": "application/json",
    // },
})


function SET_AUTH_TOKEN( accessToken) {
    if(accessToken){
    httpClient.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`;
    }else {
        httpClient.defaults.headers.common['Authorization'] = null;
    }

}

httpClient.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        console.log(error.response);
        router.push({name:"login"});
        store.state.errors=error.response.data;
        localStorage.removeItem('usertoken');
        localStorage.removeItem('user');
    } else if (error.response.status === 500){
        router.push({name:"error500"});
    }
    return Promise.reject(error);
});
export {httpClient,SET_AUTH_TOKEN}


