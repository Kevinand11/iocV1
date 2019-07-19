const state = {
    auth: {id:"",name:"",email:"",password:""},
    token:""
};

const getters = {
    getAuth: state => state.auth,
    getToken: state => state.token
};

const actions = {
    setAuth({commit}, user){
        this._vm.$cookies.set("user",user,"0");
        commit("authorized", user);
    },
    setToken({commit}, token){
        this._vm.$cookies.set("oauth",token,"0");
        commit("oauth", token);
    },
    logout({commit}){
        this._vm.$cookies.remove("oauth");
        this._vm.$cookies.remove("user");
        commit("clearAuth");
    }
};

const mutations = {
    authorized: (state, user) => {
        state.auth = user;
    },
    oauth: (state, token) => {
        state.token = token;
    },
    clearAuth: (state) => {
        state.auth = {id:"",name:"",email:"",password:""};
    }
};

export default {
    state,
    getters,
    actions,
    mutations
};