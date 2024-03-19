import axios from "axios";

export default {
  namespaced: true,

  state: {
    userData: null,
  },

  getters: {
    user: state => state.userData,
  },

  mutations: {
    setUserData(state, user) {
      state.userData = user;
    },
  },

  actions: {
    getUserData({ commit }) {
      axios
        .get(process.env.VUE_APP_API_URL + "/getUserData")
        .then(response => {
          commit("setUserData", response.data.data);
          
          if (response.data.success && response.data) {
            localStorage.setItem("user_name", response.data.data.name);
            localStorage.setItem("user_id", response.data.data.id);
            commit("setUserData", response.data.data);
          }
          else {
            localStorage.removeItem("user_name");
            localStorage.removeItem("permissions");
          }
        })
        .catch(() => {
          localStorage.removeItem("authToken");
        });
    },
    sendLoginRequest({ commit, dispatch }, data) {
      commit("setErrors", {}, { root: true });
      return axios
        .post(process.env.VUE_APP_API_URL + "/login", data)
        .then(response => {
          if (response.data.success) {
            console.log(response.data.data.token); // Logging auth token
            if (response.data.data.name !== "") {
              commit("setUserData", response.data);
              dispatch("getUserData");
    
              localStorage.setItem("authToken", response.data.data.token);
              return response;
            } else {
              return response;
            }
          } else {
            console.error("Login failed: ", response.data.message); // Log the error message
            return response;
          }
        })
        .catch(error => {
          if (error.response.status === 500) {
            alert(error.response.data.message);
          }
        });
    },
    sendRegisterRequest({ commit, dispatch }, data) {
      commit("setErrors", {}, { root: true });
      return axios
        .post(process.env.VUE_APP_API_URL + "/register", data)
        .then(response => {
          if (response.data.statusCode === 200) {
            localStorage.setItem("authToken", response.data.token);
            dispatch("getUserData");

          }
          return response;
        })
        .catch(error => {
          if (error.response.status === 500) {
            alert(error.response.data.message);
          }
        });
    },
    
    
    
   
    sendLogoutRequest({ commit }) {
      return axios.post(process.env.VUE_APP_API_URL + "/logout")
        .then(response => {
          if (response.data.statusCode === 200) {
            commit("setUserData", null);
            localStorage.removeItem("authToken");
            localStorage.removeItem("user_name");
            localStorage.removeItem("user_id");
          }
          return response;
        });
    },


  }
};
