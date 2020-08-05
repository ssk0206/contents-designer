<template>
  <v-app>
    <v-app-bar
      src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
      dense
      dark
      fixed
      flat
      outlined
    >
      <v-toolbar-title>Contents Designer</v-toolbar-title>
      <v-spacer></v-spacer>
        <router-link to="/about">
        <v-btn icon>
          <v-icon>mdi-information</v-icon>
        </v-btn>
        </router-link>
        <router-link to="/topics">
          <v-btn icon>
            <v-icon>mdi-folder</v-icon>
          </v-btn>
        </router-link>
    </v-app-bar>
    <v-main>
    <v-container fluid>
      <router-view style="margin-top:49px;" />
    </v-container>
    </v-main>
  </v-app>
</template>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>