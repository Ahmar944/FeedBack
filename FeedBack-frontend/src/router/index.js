import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const guest = (to, from, next) => {
  localStorage.removeItem("authToken");
  if (!localStorage.getItem("authToken")) {
    localStorage.removeItem("authToken");
    return next(next);
  } else {
    return next("/");
  }
};
const auth = (to, from, next) => {
  
  if (localStorage.getItem("authToken") && localStorage.getItem("user_name") != "") {
      return next(); 
  }else {
    localStorage.removeItem("authToken");
    return next("/login");
  }  
};
// const simpleAuth = (to, from, next) => {
//   if (localStorage.getItem("authToken") && localStorage.getItem("permissions") !== '1') {
//       return next(next);
//   }
//   else {
//     localStorage.removeItem("authToken");
//     return next("/login");
//   }
// };
const routes = [
  {
    path: "/login",
    name: "Login",
    beforeEnter: guest,
    component: () =>
      import(/* webpackChunkName: "Login" */ "../views/Auth/Login.vue")
  },
  {
    path: "/register",
    name: "Register",
    beforeEnter: guest,
    component: () =>
      import(/* webpackChunkName: "Register" */ "../views/Auth/Register.vue")
  },
  {
    path: "/",
    name: "Home",
    beforeEnter: auth,
    component: () =>
      import(/* webpackChunkName: "Login" */ "../views/Home.vue")
  },
  {
    path: "/feedback",
    name: "Feedback",
    beforeEnter: auth,
    component: () =>
      import(
        /* webpackChunkName: "VerifyEmail" */ "../views/Feedback.vue"
      ),
  },
  
 
];
const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes
});
export default router;