import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from "axios";
import "./assets/fonts/outfit.css";
import "./assets/fonts/opensans.css";
import "./assets/fonts/inter.css";
import "./assets/css/auth.css";
import "./assets/css/variable.css";
import "./assets/css/topnav.css";
import "./assets/css/typo.css";
import "./assets/css/mystyle.css";
import "./assets/css/sidebar.css";
import "./assets/css/responsive.css";
import Vuelidate from "vuelidate";
import Loading from "vue-loading-overlay";
import LoadingPlugin from 'vue-loading-overlay';
import "vue-loading-overlay/dist/vue-loading.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";



const options = {
  confirmButtonColor: "#41b882",
  cancelButtonColor: "#ff7674",
};

Vue.use(VueSweetalert2, options);
Vue.use(Loading);
Vue.use(LoadingPlugin);
Vue.use(Vuelidate);
Vue.use(require("vue-moment"));
Vue.component("v-select", vSelect);



axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status === 422) {
      store.commit("setErrors", error.response.data.errors);
    } else if (error.response.status === 401) {
      store.commit("auth/setUserData", null);
      localStorage.removeItem("authToken");
      router.push({ name: "Login" });
    } else {
      return Promise.reject(error);
    }
  }
);

Vue.directive("click-outside", {
  bind(el, binding, vnode) {
    el.clickOutsideEvent = (event) => {
      if (!(el === event.target || el.contains(event.target))) {
        vnode.context[binding.expression](event);
      }
    };
    document.body.addEventListener("click", el.clickOutsideEvent);
  },
  unbind(el) {
    document.body.removeEventListener("click", el.clickOutsideEvent);
  },
});

axios.interceptors.request.use(function(config) {
  config.headers.common = {
    Authorization: `Bearer ${localStorage.getItem("authToken")}`,
    "Content-Type": "application/json",
    Accept: "application/json",
  };

  return config;
});

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
