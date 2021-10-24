<template>
  <v-app id="inspire">
    


    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
export default {
  mounted() {
    console.log("Estamos en dashboard.vue");
  },
  updated() {
    console.log("Actualizamos dashboard.vue");
  },
  data: () => ({
    colorChoose: false,
    drawer: null,
    alwaysClosed: false,
    drawerShown: true,
    dialog: false,
    nav: false,
    items: [
      { title: "Listas", icon: "mdi-playlist-star", to: "/about" },
      { title: "Tablas", icon: "mdi-table-plus", to: "/loginprueba" },
      { title: "Cards", icon: "mdi-card-multiple-outline", to: "/cards" },
      { title: "Base de datos", icon: "mdi-database", to: "/consultas" },
    ],
  }),
  methods: {
    persistantDrawer() {
      this.alwaysClosed = !this.alwaysClosed;
    },

    getUsers() {
      axios.get("http://localhost:8000/api/users").then((response) => {
        this.users = response.data.data;
      });
    },

    opciones_usuario() {
      this.drawer = this.drawer ? false : true;
      this.items = [
        { title: "Configuraciones", icon: "mdi-view-dashboard", to: "/" },
        { title: "Ayuda", icon: "mdi-home-circle-outline", to: "/" },
        {
          title: "Cerrar sesion",
          icon: "mdi-chevron-double-left",
          to: "/about",
        },
      ];
    },

    opciones_generales() {
      this.drawer = this.drawer ? false : true;
      this.items = [
        { title: "Listas", icon: "mdi-playlist-star", to: "/about" },
        { title: "Tablas", icon: "mdi-table-plus", to: "/loginprueba" },
        { title: "Cards", icon: "mdi-card-multiple-outline", to: "/cards" },
        { title: "Base de datos", icon: "mdi-database", to: "/consultas" },
      ];
    },

    desactivar() {
      this.drawer = false;
    },
  },
};
</script>