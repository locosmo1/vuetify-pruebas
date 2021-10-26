<template>
  <div>
    <!-- <v-container fill-height fluid>
      <v-row align="center" justify="center">
        <v-col cols="3">
          <form>
            <div align="center" justify="center">
              <img src="@/assets/logo.png"/>
            </div>

            :error-messages="nameErrors"
            <v-text-field
              v-model="usuario"
              :counter="10"
              label="Usuario"
              required
              @input="$v.name.$touch()"
              @blur="$v.name.$touch()"
            ></v-text-field>
            :error-messages="emailErrors"

            <v-text-field
              type="password"
              v-model="password"
              label="Contraseña"
              required
              @input="$v.email.$touch()"
              @blur="$v.email.$touch()"
            ></v-text-field>

            <v-row align="center" justify="center">
              <v-col cols="6">
                <v-btn dark color="primary" class="mr-4" @click="submit">
                  Entrar
                </v-btn>
                <v-btn dark color="primary" @click="clear"> Borrar </v-btn>
              </v-col>
            </v-row>
          </form>
        </v-col>
      </v-row>
    </v-container> -->

    <div class="text-xs-center">
      <!--<v-btn primary> texto </v-btn>-->
    </div>
    <v-card-actions class="justify-center">
      <div align="center" justify="center">
        <form>
          <v-img src="@/assets/logo.png"> </v-img>
          <v-text-field
            v-model="usuario"
            :counter="10"
            label="Usuario"
            required
            @input="$v.name.$touch()"
            @blur="$v.name.$touch()"
          ></v-text-field>
          <!-- :error-messages="emailErrors" -->

          <v-text-field
            type="password"
            v-model="password"
            label="Contraseña"
            required
            @input="$v.email.$touch()"
            @blur="$v.email.$touch()"
          ></v-text-field>
          <v-btn color="primary" dark class="mb-1" @click="submit">
            Entrar
          </v-btn>
          <v-btn color="blue" dark class="mb-1" @click="clear"> borrar </v-btn>
        </form>
      </div>
    </v-card-actions>
  </div>
</template>

<script>
//$v es para manipular los datos de vuelidate
/*$dirty | Este valor nos indica si el usuario toco el campo o el formulario al menos una vez
$invalid | Este valor muestra el estado de validación del modelo
$error | Valor que nos permite decidir si se muestra o no un error en el formulario
$pending | Indica si algún tipo de validación asíncrona está pendiente de resolverse. Por defecto es siempre false para validaciones síncronas
$model | Referencia al valor del modelo validado. $v.value.$model es lo mismo que this.value
Veamos a hora los métodos:

$touch | Setea de forma recursiva el valor de \$dirty, tanto del modelo como de todos sus elementos secundarios a true
$reset | Hace los mismo que $touch pero seteando el valor a false
mas informacion en https://www.antoniomasia.com/potencia-tus-formularios-con-vuelidate/*/

import { validationMixin } from "vuelidate";
import { required, maxLength, email } from "vuelidate/lib/validators";

export default {
  name: "Login",

  mixins: [validationMixin],

  validations: {
    name: { required, maxLength: maxLength(10) },
    email: { required, email },
    select: { required },
    checkbox: {
      checked(val) {
        return val;
      },
    },
  },

  data: () => ({
    conectado: false,
    password: "123",
    usuario: "stiwar",
    select: null,
    items: ["Item 1", "Item 2", "Item 3", "Item 4"],
    checkbox: false,
  }),

  mounted() {},

  computed: {
    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.maxLength &&
        errors.push("Name must be at most 10 characters long");
      !this.$v.name.required && errors.push("Name is required.");
      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("Necesita un email valido");
      !this.$v.email.required && errors.push("E-mail es requerido");
      return errors;
    },
  },

  methods: {
    submit() {
      if (this.usuario === "stiwar" && this.password === "123") {
        this.$store.state.conectado = true
        this.$router.push({ path: "consultas" });
        //pagina para averiguar mas sobre vue router
        //https://codingpotions.com/vue-router
      } else {
        this.$store.state.conectado = false
        this.usuario = "";
        this.password = "";
      }
    },
    clear() {
      this.$v.$reset();
      this.usuario = "";
      this.password = "";
    },
  },
};
</script>

//height: 150px;
<style scoped>
.login-container {
  /*IMPORTANTE*/
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>