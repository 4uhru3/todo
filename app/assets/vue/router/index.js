import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";
import Tasks from "../components/Tasks";
import Login from "../views/Login";


Vue.use(VueRouter);

let router = new VueRouter({
  mode: "history",
  routes: [
    { path: "/tasks", component: Tasks, meta: { requiresAuth: true } },
    { path: "/login", component: Login },
    { path: "*", redirect: "/tasks" }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters["security/isAuthenticated"]) {
      next();
    } else {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      });
    }
  } else {
    next();
  }
});

export default router;
