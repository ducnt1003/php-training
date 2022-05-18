import { httpClient,SET_AUTH_TOKEN } from './httpClient';

const login = (user) => httpClient.post('auth/login',user);

SET_AUTH_TOKEN(localStorage.usertoken);

const getUser = () => httpClient.get('/users');
const createUser = (user) => httpClient.post('/users/create',user);

export {
    login, getUser,createUser
}
