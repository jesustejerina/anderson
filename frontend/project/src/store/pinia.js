import { defineStore } from "pinia";
export const useStore = defineStore("useStore", {
  state: () => ({
    access_token: "ninguno",
    Autenticado: false,
    user: {
      id: 0,
      name: "",
      email: "",
      avatar_url: "",
      role: "",
      permissions: [],
    },
  }),
});
