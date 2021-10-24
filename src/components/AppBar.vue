<template>
    <div>
        <v-app-bar :clipped-left="true" app dark dense color="blue darken-4">
      <v-app-bar-nav-icon @click="opciones_generales()"></v-app-bar-nav-icon>

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
    </div>
</template>