<template>
  <div>
    <v-chip-group>
      <v-spacer></v-spacer>

      <v-dialog absolute v-model="terminarCompra" max-width="500px">
        <!-- Boton de terminar compras -->
        <template v-slot:activator="{ on, attrs }">
          <v-card-actions class="px-3 pb-3">
            <v-spacer></v-spacer>
            <v-btn
              rounded
              color="primary"
              elevation="24"
              dark
              v-bind="attrs"
              v-on="on"
            >
              <v-icon left> mdi-skip-next </v-icon>
              Terminar compras
            </v-btn>
          </v-card-actions>
        </template>

        <v-card elevation="5" shaped outlined>
          <!-- Opciones de editar y nuevo producto -->
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field v-model="nombre" label="Nombre"></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field v-model="pais" label="Pais"></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="departamento"
                    label="Departamento"
                  ></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="municipio"
                    label="Municipio"
                  ></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="direccion"
                    label="Direccion"
                  ></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="telefono"
                    label="Telefono"
                  ></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="tarjeta"
                    label="Numero de la tarjeta"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions>
            
            <v-spacer> </v-spacer>
            
            <v-btn color="primary" class="mb-2" dark @click="terminarCompra = false"> Cancelar </v-btn>

            
            <!-- Boton guardar datos del usuario supermasivo -->
            <v-dialog absolute v-model="botonGuardar" max-width="500px">
              <template v-slot:activator="{ on, attrs }">
                <v-card-actions class="px-3 pb-3">
                  <v-spacer></v-spacer>
                  <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                  >
                    Guardar
                  </v-btn>
                </v-card-actions>
              </template>

              <v-card elevation="5" shaped outlined>
                <!-- datos de los productos a comprar -->
                <v-card-text>
                  <v-container>
                    <v-row cols="10" sm="4" md="10" class="d-flex child-flex">
                      <v-alert type="success">
                        <h4>Productos a comprar</h4>
                      </v-alert>
                    </v-row>

                    <v-row
                      cols="10"
                      sm="4"
                      md="10"
                      v-for="(elemento, indice) in $store.state.comprados"
                      :key="indice"
                      class="d-flex child-flex"
                    >
                      <v-alert type="success">
                        {{ getDatos(indice) }} <br />
                      </v-alert>
                    </v-row>
                    <v-alert
                      color="primary"
                      dark
                      icon="mdi-vuetify"
                      border="left"
                      prominent
                    >
                      <strong> Total: {{ $store.state.total_compra }} </strong>
                    </v-alert>
                  </v-container>
                </v-card-text>

                <!-- Datos del cliente que quiere comprar -->
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="10" sm="4" md="10">
                        <v-alert
                          color="primary"
                          dark
                          icon="mdi-vuetify"
                          border="left"
                          prominent
                        >
                          <strong>
                            <h4>Datos de la persona</h4>
                            Nombre: {{ nombre }} <br />
                            Pais: {{ pais }} <br />
                            Departamento: {{ departamento }} <br />
                            Municipio: {{ municipio }} <br />
                            Direccion: {{ direccion }} <br />
                            Telefono: {{ telefono }} <br />
                            Tarjeta: {{ tarjeta }} <br />
                          </strong>
                        </v-alert>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="terminarCompra = false">
                    Salir
                  </v-btn>
                </v-card-actions>
              </v-card>
              <v-divider></v-divider>
            </v-dialog>

            

          </v-card-actions>
        </v-card>
        <v-divider></v-divider>
      </v-dialog>
    </v-chip-group>
  </div>
</template>

<script>
export default {
  data: () => ({
    terminarCompra: false,
    botonGuardar: false,
    nombre: "stiwar",
    pais: "Colombia",
    departamento: "Caqueta",
    municipio: "Florencia",
    direccion: "Calle 10a",
    telefono: "3508426005",
    tarjeta: "1651610321321",
  }),
  methods: {

    getDatos(indice) {
      return (
        this.$store.getters.comprados[indice].titulo +
        ", " +
        "Precio: " +
        this.$store.getters.comprados[indice].precio +
        ", " +
        "Unidades: " +
        this.$store.getters.comprados[indice].unidades +
        "."
      );
      /*let acum = ""
      for(let indice = 0; indice<this.$store.getters.comprados.length; indice++){
        acum += " "+this.$store.getters.comprados[indice].titulo + " " +
        "Precio: " + this.$store.getters.comprados[indice].precio + " " +
        "Unidades: " + this.$store.getters.comprados[indice].unidades + "."
      }
      return acum*/
    },
  },
};
</script>