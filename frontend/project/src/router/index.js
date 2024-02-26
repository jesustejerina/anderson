/* eslint-disable */
import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import axios from "axios";
import { useStore } from "../store/pinia";
var Autenticado = false;
const login = {
  path: "/login",
  name: "login",
  component: () => import("../views/LoginView.vue"),
};
const register = {
  path: "/register",
  name: "register",
  component: () => import("../views/RegisterView.vue"),
};
const dashboard = {
  path: "/dashboard",
  name: "dashboard",
  beforeEnter: (to,from,next) => {
    if (Autenticado) {
      next();
    } else {
      next("/");
    }
  },
  component: () => import("../views/DashboardView.vue"),
};
const clientes = {
  path: "/clientes",
  name: "clientes",
  beforeEnter: (to,from,next) => {
    if (Autenticado) {
      next();
    } else {
      next("/");
    }
  },
  component: () => import("../views/ClientesView.vue"),
};
const pagos = {
  path: "/pagos",
  name: "pagos",
  beforeEnter: (to,from,next) => {
    if (Autenticado) {
      next();
    } else {
      next("/");
    }
  },
  component: () => import("../views/PagosView.vue"),
};
const routes = [
  dashboard,
  register,
  login,
  clientes,
  pagos,
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/about",
    name: "about",
    component: () => import("../views/AboutView.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach(async (to, from, next) => {
  const store = useStore();
  let user_token = store.access_token;
  let apiURL = process.env.VUE_APP_URL_AUTENTICADO;
  let config = {
    headers: {
      Authorization: `Bearer ${user_token}`,
      "Access-Control-Allow-Origin": "*",
    },
  };
  axios
    .get(apiURL, config)
    .then((response) => {
      let r = response.data;
      if (r.status == "OK") {
        store.Autenticado = r.autenticado;
      }
    })
    .catch((error) => {
      let r = error.response.data;
      console.log(r);
      store.Autenticado = false;
      store.access_token = "";
    });
  Autenticado = store.Autenticado;
  next();
});
export default router;
