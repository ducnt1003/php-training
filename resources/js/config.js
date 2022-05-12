import axios from 'axios';

const api = {
    'login':'http://127.0.0.1:8000/api/auth/login',
    'user':'http://127.0.0.1:8000/api/users/',
}
export default api;
// export const login = axios.create({
//     baseURL: `http://127.0.0.1:8000/api/auth/login`,

// });

// export const user = axios.create({
//     baseURL: `http://127.0.0.1:8000/api/users/`,
//     headers: {
//         Authorization: 'Bearer {usertoken}'
//       }
// });


