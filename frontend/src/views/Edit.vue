<template>
  <div class="edit">
    <button v-on:click="addComponent(1)">+</button>
    <h1>This is an edit page {{ $route.params.id }}</h1>
    <draggable handle=".handle">
      <v-card
      v-for="component in components" :key="component.id"
      class="mx-auto"
      max-width="600"
      outlined>
        <div class="handle" style="background-color:#eee;">
          <v-icon medium style="float:left;">mdi-drag</v-icon>
          <v-icon color="grey lighten-1" style="float:right;">mdi-delete</v-icon>
          <v-icon color="grey lighten-1" style="float:right;">mdi-pencil</v-icon>
        </div>
        <v-divider></v-divider>
        <p>{{ component.columns[0].id }} {{ component.columns[0].content }}</p>
      </v-card>
    </draggable>
  </div>
</template>

<script>
import draggable from 'vuedraggable'
export default {
  components: {
    draggable
  },
  data() {
    return {
      components: [],
    }
  },
  methods: {
    addComponent: function(id) {
      console.log(id)
    }
  },
  created() {
    this.axios.get('/api/pages/' + this.$route.params.id + '/edit' ).then((res) => {
      this.components = res.data.components
    })
  },
}
</script>