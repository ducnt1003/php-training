
export default {
    setUsers(state,users){
        state.users = users;
    },
    createUser(state,user){
        state.users.push(user);
    }
};
