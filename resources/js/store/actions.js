import {
    getUser,
    createUser,
    editUser,
    deleteUser,
    deleteUsers,
    exportUsers,
} from "../config/config.api";
import {
    router
} from '../router';

export default {
    login({
        commit
    }, user) {
        commit('login', user);
    },
    setUsers({
        commit
    }) {
        getUser()
            .then((res) => {
                commit('setUsers', res.data);
            });
    },
    createUser({
        commit
    }, user) {
        createUser(user)
            .then((res) => {
                commit('createUser', res.data);
                commit('setErrors', '');
                commit('setSuccess', 'success');
            }).catch((err) => {
                if (err.response.status === 403) console.log(err.response);
                if (err.response.status === 422) {
                    commit('setErrors', err.response.data.errors);
                };
            });
    },
    editUser({
        commit
    }, id) {
        commit('selectUser', id);
        commit('setActiveEdit');
    },
    updateUser({
        commit
    }, user) {
        editUser(user.id, user).then((res) => {
            console.log(res.data)
            commit('updateUser', res.data);
            commit('setActiveEdit');
        });

    },
    deleteUser({
        commit
    }, id) {
        deleteUser(id).then((res) => {
            console.log(res.data)
        }).catch((err) => {
            console.log(err);
            router.push({
                name: 'errors500'
            });
        });
        commit('delete', id);
    },
    deleteUsers({
        commit
    }, selected) {
        deleteUsers(selected).then((res) => {
            console.log(res);
            commit('delete_multi', selected);
        })

    },
    exportUsers({
        commit
    }, options) {
        exportUsers(options).then((response) => {
            console.log(response)
            var fileURL = window.URL.createObjectURL(new Blob([response.data],{ type: 'application/vnd.ms-excel;charset=utf-8' }));
            var fileLink = document.createElement('a');
            fileLink.href = fileURL;
            fileLink.setAttribute('download', 'users.xlsx');
            document.body.appendChild(fileLink);
            fileLink.click();
        })
    },
    setSuccess({commit}){
        commit('setSuccess', '');
    }
}
