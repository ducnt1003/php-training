import axios from 'axios';

axios.defaults.baseURL = process.env.API_ENDPOINT;

export const login = axios.create({
    baseURL: `http://127.0.0.1:8000/api/auth/login`,

});

export const user = axios.create({
    baseURL: `http://127.0.0.1:8000/api/users/`,
    headers: {
        Authorization: `Bearer ${localStorage.usertoken}`,
    },
});
