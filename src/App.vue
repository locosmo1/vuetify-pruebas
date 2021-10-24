<!-- api key de fotos de pexels 563492ad6f917000010000017248196f0f5f40ec82d8a0b3a18955a7 -->  

<template>
  <v-app id="inspire">
    <v-navigation-drawer
      hide-overlay
      v-model="drawerShown"
      :temporary="alwaysClosed"
      app
      color="blue darken-4"
      clipped
      dark
    >
      <v-list>
        <v-list-item two-line>
          <v-list-item-avatar>
            <img
              src="https://scontent.fbog15-1.fna.fbcdn.net/v/t1.18169-9/16807548_1174372649298950_4288151154757326868_n.jpg?_nc_cat=104&ccb=1-5&_nc_sid=174925&_nc_eui2=AeFdpsTiBbc-9P5M72WzDODZHMQRXskdnZQcxBFeyR2dlGpF_DBEmk03fYJk8ktzatRu3j9dhfm40qJs7V5di14S&_nc_ohc=fk9TGTSrtOIAX-QY5pO&_nc_ht=scontent.fbog15-1.fna&oh=0e086079e48a9761c6ea3279d02e9977&oe=619A224B"
            />
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title>Jhonatan stiwar</v-list-item-title>
            <v-list-item-subtitle>Conectado</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>

        <v-list-item
          v-for="item in items"
          :key="item.title"
          :to="item.to"
          @click="desactivar()"
          link
        >
          <v-list-item-icon>
            <v-icon v-text="item.icon"></v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      v-model="bar"
      :clipped-left="true"
      app
      dark
      dense
      color="blue darken-4"
    >
      <!-- <v-app-bar-nav-icon @click="opciones_generales()"></v-app-bar-nav-icon>-->

      <v-toolbar-title>Mi Aplicacion</v-toolbar-title>

      <template v-slot:img="{ props }">
        <v-img
          v-bind="props"
          gradient="to top right, rgba(19,84,122,.5), rgba(128,208,199,.8)"
        ></v-img>
      </template>

      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon @click="opciones_usuario()">mdi-dots-vertical</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
export default {
  mounted() {
    console.log("Mounted created");
    if (this.$route.name === "Login" || this.$route.name === "Home") {
      this.bar = false;
      this.drawerShown = false;
    }else {
      this.bar = true;
      this.drawerShown = true;
    }
  },
  updated() {
    console.log("ruta actual: "+this.$route.name);
    if (this.$route.name === "Login" || this.$route.name === "Home") {
      this.bar = false;
      this.drawerShown = false;
    }else {
      this.bar = true;
      this.drawerShown = true;
    }
  },
  data: () => ({
    bar: true, //this.$store.getters.conectado
    drawerShown: true,
    colorChoose: false,
    drawer: null,
    alwaysClosed: false,
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