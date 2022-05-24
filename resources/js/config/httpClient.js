import Vue from "vue";
import VueAxios from 'vue-axios';
import axios from 'axios';
import { router } from "../router";
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
        console.log(error.response.data.response)
        router.push({name:"login"});
        /* THIS WORKS BUT BREAKS THE LOGIN ERROR HANDLING */

    }
    return Promise.reject(error);
});
export {httpClient,SET_AUTH_TOKEN}


