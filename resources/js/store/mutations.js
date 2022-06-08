import {
    multiply
} from "lodash";

export default {
    login(state, user) {
        state.userLogin = user;
        state.isLogin = true;
    },
    logout(state) {
        state.userLogin = {};
        state.isLogin = false;
    },
    setUsers(state, users) {
        state.users = users;
    },
    setPaginate(state,data){
        state.paginate.page = data.page;
        state.paginate.max = data.max;
        state.paginate.length = data.length;
    },
    createUser(state, user) {
        state.users.push(user);
    },
    setActiveEdit(state) {
        state.activeEdit = !state.activeEdit;
    },
    selectUser(state, id) {
        const index = state.users.findIndex((user) => user.id == id);
        state.user = {
            id: state.users[index].id,
            name: state.users[index].name,
            email: state.users[index].email,
            role_id: state.users[index].role_id,
        }
    },
    updateUser(state, user) {
        const index = state.users.findIndex((user) => user.id === state.user.id);
        state.users[index].name = user.name;
        state.users[index].email = user.email;
        state.users[index].role_id = user.role_id;
        state.users[index].role = user.role;
        console.log(state.users);
        state.user = {};
    },
    delete(state, id) {
        const index = state.users.findIndex((user) => user.id == id);
        state.users.splice(index, 1);
    },
    delete_multi(state, selected) {
        selected.forEach(select => {
            let index = state.users.findIndex((user) => user.id == select.id);
            state.users.splice(index, 1);
        });
    },
    setErrors(state, errors) {
        state.errors = errors;
    },
    setSuccess(state, success) {
        state.success = success;
    },
    setLoading(state){
        state.isLoading = !state.isLoading;
    },

};
