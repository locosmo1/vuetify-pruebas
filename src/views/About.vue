<template>
  <div class="about pa-2 ma-4">
    <v-list two-line flat>
      <v-divider></v-divider>
      <v-text-field
        @click:append="anadir_Tarea(titulo_tarea)"
        @keyup.enter="anadir_Tarea(titulo_tarea)"
        v-model="titulo_tarea"
        clearable
        hide-details
        outlined
        label="Añadir tarea"
        append-icon="mdi-plus"
      ></v-text-field>

      <v-chip-group>
        <!-- Boton 1 -->
        <v-dialog v-model="dialog" max-width="500px">
          <v-card elevation="5" shaped outlined>
            <!-- Opciones de editar y nuevo producto -->
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.name"
                      label="Producto"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.calories"
                      label="Calorias"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.fat"
                      label="Fat (g)"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.carbs"
                      label="Carbohidratos"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.protein"
                      label="Proteinas"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="cancelar">
                Cancelar
              </v-btn>
              <v-btn color="blue darken-1" text @click="guardar">
                Guardar
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-chip-group>

      <v-list-item
        @click="donetask(task.id)"
        :class="{ 'blue lighten-2': task.done }"
        v-for="task in tasks"
        :key="task.id"
      >
        <template>
          <v-list-item-action>
            <v-checkbox :input-value="task.done" color="primary"></v-checkbox>
          </v-list-item-action>

          <v-list-item-content>
            <v-chip-group>
              <v-list-item-title
                :class="{ 'text-decoration-line-through': task.done }"
                >{{ task.titulo }}
              </v-list-item-title>
            </v-chip-group>
            <v-list-item-subtitle>{{ task.subtitulo }}</v-list-item-subtitle>
          </v-list-item-content>
        </template>
        <v-chip-group>
          <v-icon class="mr-2" @click="editar_item(task.id)">
            mdi-pencil
          </v-icon>
          <v-icon class="mr-2" @click="borrar_item(task.id)">
            mdi-delete
          </v-icon>
        </v-chip-group>
      </v-list-item>

      <v-divider></v-divider>
    </v-list>
  </div>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    tarjetas: false,
    tasks: [
      {
        id: 0,
        titulo: "1",
        subtitulo: "Indice 1",
        done: false,
      },
      {
        id: 1,
        titulo: "2",
        subtitulo: "Indice 2",
        done: false,
      },
      {
        id: 2,
        titulo: "3",
        subtitulo: "Indice 3",
        done: false,
      },
    ],
    titulo_tarea: "",
    indice: 3,
    settings: [],
    editedItem: {
      name: "",
      calories: 0,
      carbs: 0,
      protein: 0,
    },
  }),
  created() {},
  computed: {
    aumenta: function () {
      return console.log(this.tasks[this.indice].indice++);
    },
  },
  methods: {
    donetask(id) {
      let taks = this.tasks.filter((variable) => variable.id === id)[0];
      taks.done = !taks.done;
    },
    borrar_item(id) {
      this.tasks = this.tasks.filter((task) => task.id !== id);
      this.indice--;
    },
    anadir_Tarea() {
      if (this.titulo_tarea !== "") {
        let nueva = {
          id: this.indice,
          titulo: this.titulo_tarea,
          subtitulo: "Indice: " + (this.indice + 1),
          done: false,
        };
        this.tasks.push(nueva);
        this.indice++;
        this.titulo_tarea = "";
      }
    },
    editar_item(id) {
      let new_item;
      this.indice = id;
      if (this.titulo_tarea != "") {
        new_item = {
          id: this.indice,
          titulo: this.titulo_tarea,
          subtitulo: this.titulo_tarea,
          done: false,
        };
        Object.assign(this.tasks[id], new_item);
        //Crear una nueva variable reactiva a partir de someobject
        this.$set(this.someObject, "b", 2);
      }
    },
    cancelar() {
      this.dialog = false;
    },
    guardar() {
      this.dialog = false;
    },
  },
};
</script>
