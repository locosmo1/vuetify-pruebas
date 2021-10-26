<template>
  <div>
    <v-row xs="12" sm="11" md="10" lg="8" xl="8">
      <v-col class="d-lg-flex">
        <v-spacer>
          <v-card
            @mouseover="cardFocus(index)"
            width="1200px"
            class="my-1 mb-1 px-1 pb-1 mt-1"
            elevation="0"
          >
            <v-card elevation="0" class="my-1 mb-1 px-1 pb-1 mt-1">
              <div align="center" justify="center">
                <v-img src="@/assets/robotDañado.jpg"> </v-img>
              </div>
            </v-card>
            <v-card-title class="text-h6">
              <strong>Pagina no encontrada</strong>
            </v-card-title>
            <v-card-subtitle class="text-h6">
              <strong>
                No se pudo encontrar la página que está buscando.
              </strong>
            </v-card-subtitle>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue" dark class="mb-2" @click="goIndex()">
                Ir a la pagina de inicio
              </v-btn>
            </v-card-actions>
            <v-divider vertical> </v-divider>
          </v-card>
        </v-spacer>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      index: 0,
    };
  },
  methods: {
    cardFocus(index) {
      this.index = index;
    },
    goIndex() {
      if (this.$store.state.conectado == true) {
        this.$router.push({ name: "consultas" })
      } else {
        this.$router.push({ name: "Login" });
      }
    },
  },
};
</script>


<style scoped>
body {
  font: normal 16px/26px Arial, sans-serif;
}

.error-page {
  margin: 100px 0 40px;
  text-align: center;
}

.error-page__header-image {
  text-align: center;
}

.error-page__title {
  font-family: "Roboto", Arial, sans-serif;
  font-size: 31px;
}
</style>