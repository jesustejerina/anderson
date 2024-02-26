/* eslint-disable */
import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import AutenticadoLayout from "../layouts/AutenticadoLayout.vue";
import menu_autenticado from "../components/MenuAutenticado.vue";
import menu_publico from "../components/MenuPublico.vue";
import axios from "axios";
import { useStore } from "../store/pinia";
var Autenticado = false;
const login = {
  path: "/login",
  name: "login",
  beforeEnter: (to, from, next) => {
    if (Autenticado) {
      next("/autenticados/dashboard");
    } else {
      next();
    }
  },
  components: {
    default: () => import("../views/LoginView.vue"),
    menu_activo: menu_publico
  }
};
const register = {
  path: "/autenticados/register",
  name: "register",
  beforeEnter: (to,from,next) => {
    if (Autenticado) {
      next();
    } else {
      next("/");
    }
  },
  components:{
    default: () => import("../views/RegisterView.vue"),
    menu_activo: menu_autenticado
  }
};
const dashboard = {
  path: "/autenticados/dashboard",
  name: "dashboard",
  beforeEnter: (to,from,next) => {
    if (Autenticado) {
      next();
    } else {
      next("/");
    }
  },
  components:{
    default: () => import("../views/DashboardView.vue"),
    menu_activo: menu_autenticado
  }
};
const clientes = {
  path: "/autenticados/clientes",
  name: "clientes",
  beforeEnter: (to,from,next) => {
    if (Autenticado) {
      next();
    } else {
      next("/");
    }
  },
  components:{
    default: () => import("../views/ClientesView.vue"),
    menu_activo: menu_autenticado
  }
};
const pagos = {
  path: "/autenticados/pagos",
  name: "pagos",
  beforeEnter: (to,from,next) => {
    if (Autenticado) {
      next();
    } else {
      next("/");
    }
  },
  components: {
    default: () => import("../views/PagosView.vue"),
    menu_activo: menu_autenticado
  }
};
const home = {
  path: "/",
  name: "home",
  components: {
    default: HomeView,
    menu_activo: menu_publico
  }
};
const about = {
  path: "/about",
  name: "about",
  components: {
    default: () => import("../views/AboutView.vue"),
    menu_activo: menu_publico
  }
};
const autenticados = {
  path: "/autenticados",
  name: "autenticados",
  redirect: "/autenticados/dashboard",
  components: {
    default: AutenticadoLayout,
    menu_activo: menu_autenticado
  },
  children: [
    dashboard,
    clientes,
    pagos,
    register
  ]
};
const routes = [
  home,
  login,
  about,
  autenticados
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
