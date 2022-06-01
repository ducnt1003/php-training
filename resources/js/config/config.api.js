import { httpClient,SET_AUTH_TOKEN } from './httpClient';



const login = (user) => httpClient.post('auth/login',user);


SET_AUTH_TOKEN(localStorage.usertoken);

const logout = () =>httpClient.post('auth/logout');

const getUser = () => httpClient.get('/users');
const createUser = (user) => httpClient.post('/users/create',user);
const editUser = (id,user) => httpClient.post(`/users/edit/${id}`,user);
const deleteUser = (id,user) => httpClient.delete(`/users/delete/${id}`);
const deleteUsers = (selected) => httpClient.delete(`/users/delete-multi/`,{ data: { selected: selected } });
const exportUsers = (options) => httpClient.post('users/export',options ,{responseType:'arraybuffer'});
// function exportUsers(options){
//     let http = httpClient;
//     http.interceptors.request.use(
//         config => {
//             config.responseType = `blod`;
//           return config;
//         },

//         error => Promise.reject(error)
//       );
//     return http.post('users/export',{ options: options });
// }

export {
    login, getUser,createUser,logout,editUser,deleteUser,deleteUsers,exportUsers
}
