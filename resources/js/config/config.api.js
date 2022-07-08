import { httpClient,SET_AUTH_TOKEN } from './httpClient';



const login = (user) => httpClient.post('auth/login',user);


SET_AUTH_TOKEN(localStorage.usertoken);

const logout = () =>httpClient.post('auth/logout');

const getUser = (options) => httpClient.get(`/users?page=${options.page}&search=${options.search}&role_id=${options.role_id}&key=${options.key}&type=${options.type}`);
const createUser = (user) => httpClient.post('/users/create',user);
const editUser = (id,user) => httpClient.post(`/users/edit/${id}`,user);
const deleteUser = (id,user) => httpClient.delete(`/users/delete/${id}`);
const deleteUsers = (selected) => httpClient.delete(`/users/delete-multi/`,{ data: { selected: selected } });
const exportUsers = (options) => httpClient.post('users/export',options ,{responseType:'arraybuffer'});

export {
    login, getUser,createUser,logout,editUser,deleteUser,deleteUsers,exportUsers
}
