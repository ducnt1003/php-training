
export default {
    setUsers(state,users){
        state.users = users;
    },
    createUser(state,user){
        state.users.push(user);
    },
    setActiveEdit(state){
      state.activeEdit = !state.activeEdit;
    },
    selectUser(state,id){
        state.user = state.users.find(user=> user.id == id);
    },
    updateUser(state,user){
        const index = state.users.findIndex((user)=> user.id === state.user.id);
        state.users[index] = user;
        state.user={};
    }
};
