import Vue from "vue";
import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);


const httpClient = axios.create({
    baseURL:process.env.MIX_PUSHER_API_ENDPOINT,
    // timeout: 3000,
    // headers: {
    //     "Content-Type": "application/json",
    // },
});

function SET_AUTH_TOKEN( accessToken) {
    if(accessToken){
    httpClient.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`;
    }else {
        httpClient.defaults.headers.common['Authorization'] = null;
    }

}
//httpClient.interceptors.request.use(SET_AUTH_TOKEN(localStorage.usertoken));
export {httpClient,SET_AUTH_TOKEN}


