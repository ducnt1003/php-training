import { httpClient,SET_AUTH_TOKEN } from './httpClient';

const login = (user) => httpClient.post('auth/login',user);


SET_AUTH_TOKEN(localStorage.usertoken);
const logout = () =>httpClient.post('auth/logout');

const getUser = () => httpClient.get('/users');
const createUser = (user) => httpClient.post('/users/create',user);
const editUser = (id,user) => httpClient.post(`/users/edit/${id}`,user);
const deleteUser = (id,user) => httpClient.delete(`/users/delete/${id}`);

export {
    login, getUser,createUser,logout,editUser,deleteUser
}
