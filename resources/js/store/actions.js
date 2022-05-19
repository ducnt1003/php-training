import { getUser,createUser,editUser } from "../config/config.api";

export default  {
    setUsers({commit}) {
        getUser()
            .then((res) => {
                commit('setUsers', res.data)
            });
    },
    createUser({commit},user){
        createUser(user)
        .then((res)=>{
            console.log(res.data)
            commit('createUser', res.data)
        });
    },
    editUser({commit},id){
        commit('selectUser',id);
        commit('setActiveEdit');
    },
    updateUser({commit},user){
        editUser(user.id,user).then((res)=>{
            console.log(res.data)
            commit('updateUser', res.data);
            commit('setActiveEdit');
        });

    }
}
