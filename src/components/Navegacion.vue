<template>
  <div>
    <v-navigation-drawer
      v-model="drawerShown"
      :temporary="alwaysClosed"
      app
      value="false"
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
          @click.stop.prevent="desactivar()"
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
  </div>
</template>