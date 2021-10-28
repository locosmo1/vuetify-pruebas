<template>
  <div>
    <!--   <v-chip-group> -->
    <!--<v-list-item
      :class="{ 'blue lighten-2': task.done }"
      v-for="(task, index) in tasks"
      :key="index"
    >-->

    <v-row xs="12" sm="11" md="10" lg="8" xl="8">
      <v-col v-for="(task, index) in tasks" :key="index" class="d-lg-flex">
        <!-- d-flex child-flex -->
        <!--Boton que sea una imagen y dentro de el tenga href -->
        <v-spacer>
          <!-- @click="comprar(index)" -->
          <v-hover v-slot="{ hover }">
            <v-card
              @mouseover="cardFocus(index)"
              hover
              width="320px"
              :elevation="hover ? 24 : 2"
              :class="{ 'on-hover': hover }"
              class="my-1 mb-1 px-1 pb-1 mt-1"
            >
              <v-card hover elevation="8" class="my-1 mb-1 px-1 pb-1 mt-1">
                <v-img :src="agregar_imagen_lista(index)"> </v-img>
              </v-card>
              <v-card-title class="text-h6">
                <strong>Precio: {{ task.precio }}</strong>
              </v-card-title>
              <v-card-subtitle class="text-h6">
                <strong> {{ task.titulo }} </strong>
              </v-card-subtitle>
              <v-card-text>
                <!--<ul>
              <input type="text" v-model="amigo_nuevo" />
              <button @click="add_amigo">agregar amigo</button>
              <li v-for="(amigo, index) in $store.state.amigos" :key="index">
                <h4> {{ amigo }} </h4>
              </li>
            </ul>-->
              </v-card-text>
              <v-card-actions>
                <v-row xs="12" sm="11" md="10" lg="8" xl="8">
                  <v-col class="d-lg-flex">
                    <!--<v-spacer></v-spacer>-->
                    <v-btn
                      color="blue"
                      dark
                      class="mb-0"
                      @click="comprar(index)"
                    >
                      Comprar
                    </v-btn>
                    <v-btn
                      color="blue"
                      dark
                      class="mb-0"
                      @click="accion_editar(index)"
                    >
                      Editar
                    </v-btn>
                    <v-btn
                      color="blue"
                      dark
                      class="mb-0"
                      @click="accion_borrar(index)"
                    >
                      Eliminar
                    </v-btn>
                  </v-col>
                </v-row>
              </v-card-actions>
              <v-divider vertical> </v-divider>
            </v-card>
          </v-hover>
        </v-spacer>
      </v-col>
    </v-row>
    <!--</v-list-item>-->
  </div>
</template>

<script>
export default {
  name: "movie-card",
  props: {
    tasks: Array,
  },
  data() {
    return {
      amigo_nuevo: "",
    };
  },
  methods: {
    cardFocus(id) {},

    add_amigo() {
      this.$store.state.amigo = this.amigo_nuevo;
      this.$store.dispatch("add_amigo_Action");
      this.amigo_nuevo = "";
    },

    agregar_imagen_lista(id) {
      return this.tasks[id].imagen;
    },

    comprar(id) {
      let indice = undefined;
      let unidades = 1;
      let i = 0;
      let iguales = false;
      let salir = false;
      let producto = {
        titulo: this.tasks[id].titulo,
        subtitulo: this.tasks[id].subtitulo,
        precio: this.tasks[id].precio,
        unidades: 1,
      };

      if (this.$store.state.comprados.length == 0) {
        this.$store.state.total_compra = producto.precio;
        //this.comprados.push(producto);
        this.$store.state.comprados.push(producto);
      } else {
        do {
          if (i < this.$store.state.comprados.length) {
            iguales = this.objetos_iguales(
              producto,
              this.$store.state.comprados[i]
            )
              ? true
              : false;
            i++;
            salir = iguales ? true : false;
          } else {
            salir = true;
          }
        } while (!salir);

        if (!iguales) {
          this.$store.state.comprados.push(producto);
        } else if (iguales) {
          indice = this.encontrar_indice(producto, this.$store.state.comprados);
          unidades = this.$store.state.comprados[indice].unidades + 1;
          this.$store.state.comprados[indice].unidades = unidades;
        }

        let valor2 = parseInt(this.$store.state.total_compra);
        let valor3 = parseInt(producto.precio);
        this.$store.state.total_compra = valor2 + valor3;
      }
      this.anadir_subtotal(producto.precio, 1);
      this.$store.state.dialog = false;
      this.$store.state.editar = false;
    },

    encontrar_indice(producto, arreglo) {
      let x, indice;
      for (x = 0; x < arreglo.length; x++) {
        if (arreglo[x].titulo == producto.titulo) {
          indice = x;
        }
      }
      return indice;
    },

    objetos_iguales(obj1, obj2) {
      return (
        obj1.titulo === obj2.titulo &&
        obj1.subtitulo === obj2.subtitulo &&
        obj1.precio === obj2.precio
      );
    },

    anadir_subtotal(a, b) {
      //this.subtotales.push(a * b);
    },

    accion_editar(id) {
      //this.indice_editar = id;
      this.$store.state.indice_editar = id;
      this.$store.state.dialog = true;
      this.$store.state.editar = true;
    },

    accion_borrar(id) {
      this.$store.state.editar = false;
      this.borrar_item(id);
    },

    borrar_item(id) {
      let newId = id + 1;
      let form = new FormData();
      form.append("id", newId);

      fetch(
        "https://epsasesp.com/wp-content/practicas_php_vuejs/eliminarProducto.php",
        {
          method: "POST",
          body: form,
        }
      )
        .then((data) => data.json())
        .then((respuesta) => {
          console.log(respuesta);
        })
        .catch((error) => console.log("Error: " + error));
      this.tasks.splice(id, 1);
    },
  },
};
</script>

<style scoped>
h4 {
  font-size: 15pt;
  font-family: cursive;
}
</style>