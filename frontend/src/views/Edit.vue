<template>
  <div class="edit">
    <button @click="addComponent(1)">+</button>
    <h1>This is an edit page {{ $route.params.id }}</h1>
    <draggable v-model="components" handle=".handle">
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
        <div>{{ component.columns[0].content }}</div>
      </v-card>
    </draggable>
    <div>
     <div><pre>{{formattedItems1}}</pre></div>
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable'

function dumpObj(obj) {
  return JSON.stringify(obj, null, 2)
}

export default {
  components: {
    draggable
  },
  data() {
    return {
      components: [],
    }
  },
  computed: {
    formattedItems1() {
      return dumpObj(this.components);
    },
  },
  methods: {
    addComponent: function(type) {
      this.components.push(
        {
          "id": this.components.length + 1,
          "page_id": this.$route.params.id,
          "type": type,
          "order": this.components.length + 1,
          "columns": [
            {
              "component_id": this.components.length + 1,
              "content": "コンテンツが入ります",
              "order": 1,
            }
          ]
        }
      );
    }
  },
  created() {
    this.axios.get('/api/pages/' + this.$route.params.id + '/edit' ).then((res) => {
      this.components = res.data.components
    })
  },
}
</script>