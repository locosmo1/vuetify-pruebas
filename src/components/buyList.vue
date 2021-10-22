<template>
  <div>
    <hr />
    <v-card elevation="5" shaped outlined>
      <v-list-item v-for="(task, index) in $store.state.comprados" :key="index">
        <v-list-item-content>
          <v-chip-group>
            <v-list-item-title
              :class="{ 'text-decoration-line-through': task.done }"
            >
              <h5>{{ task.titulo }}</h5>
              <v-spacer>
                <h5>Precio: {{ task.precio }}</h5>
              </v-spacer>
              <v-spacer>
                <h5>Unidades: {{ task.unidades }}</h5>
              </v-spacer>
            </v-list-item-title>
          </v-chip-group>
          <h5>Subtotal {{ task.precio * task.unidades }}</h5>

          <v-chip-group>
            <v-btn
              rounded
              color="primary"
              elevation="0"
              dark
              class="mr-2"
              @click="aumentar_cantidad(index)"
            >
              <v-icon> mdi-numeric-positive-1 </v-icon>
            </v-btn>

            <v-btn
              rounded
              color="primary"
              elevation="0"
              dark
              class="mr-2"
              @click="disminuir_cantidad(index)"
            >
              <v-icon> mdi-numeric-negative-1 </v-icon>
            </v-btn>

            <v-btn
              rounded
              color="primary"
              elevation="0"
              dark
              class="mr-2"
              @click="eliminar_producto(index)"
            >
              <v-icon> mdi-delete </v-icon>
            </v-btn>
          </v-chip-group>
        </v-list-item-content>
      </v-list-item>
      <hr />
      <strong> Totales: {{ $store.state.total_compra }} </strong>
      <hr />
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="cancelar"> Salir </v-btn>
      </v-card-actions>
      <hr />
    </v-card>
  </div>
</template>

<script>
export default {
  name: "buyList",
  data() {
    return {
      amigo_nuevo: "",
    };
  },
  methods: {
    cancelar() {
      this.$store.state.dialogProductos = false;
    },

    eliminar_producto(id) {
      /*this.total_compra -= this.comprados[id].precio * this.comprados[id].unidades;
      this.comprados.splice(id, 1);*/
      this.$store.state.total_compra -=
        this.$store.state.comprados[id].precio *
        this.$store.state.comprados[id].unidades;
      this.$store.state.comprados.splice(id, 1);
    },

    aumentar_cantidad(index) {
      /*let valor = this.comprados[index].unidades + 1; //Aumentar total_compra
      this.total_compra += this.comprados[index].precio;
      this.$set(this.comprados[index], "unidades", valor);*/
      let valor = this.$store.state.comprados[index].unidades + 1;
      let valor2 = parseInt(this.$store.state.total_compra);
      let valor3 = parseInt(this.$store.state.comprados[index].precio);
      //this.$store.state.total_compra += this.$store.state.comprados[index].precio
      this.$store.state.total_compra = valor2 + valor3;
      this.$store.state.comprados[index].unidades = valor;
    },

    disminuir_cantidad(index) {
      /*let valor = this.comprados[index].unidades - 1;
      if (valor >= 1) {
        this.total_compra -= this.comprados[index].precio;
        this.$set(this.comprados[index], "unidades", valor);
      }*/
      let valor = this.$store.state.comprados[index].unidades - 1;
      if (valor >= 1) {
        this.$store.state.total_compra -=
          this.$store.state.comprados[index].precio;
        this.$store.state.comprados[index].unidades = valor;
      }
    },
  },
};
</script>

<style scoped>
h5 {
  font-size: 12pt;
  font-family: "Times New Roman", Times, serif;
}
</style>
