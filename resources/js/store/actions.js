import { getUser,createUser } from "../config/config.api";

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
}
