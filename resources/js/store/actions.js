import {
    getUser,
    createUser,
    editUser,
    deleteUser
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
                console.log(res);
                commit('setUsers', res.data);
            });
    },
    createUser({
        commit
    }, user) {
        createUser(user)
            .then((res) => {
                console.log(res.data)
                commit('createUser', res.data);
                commit('setErrors','');
            }).catch((err) => {
                if (err.response.status === 403) console.log(err.response);
                if (err.response.status === 422) {
                    commit('setErrors',err.response.data.errors);
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
    }
}
