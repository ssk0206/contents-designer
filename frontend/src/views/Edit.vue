<template>
  <div class="edit">
    <button @click="addComponent(1)">+</button>
    <h1>This is an edit page {{ $route.params.id }}</h1>
    <draggable v-model="components" handle=".handle">
      <v-card
        v-for="(component, index) in components" :key="component.id"
        class="mx-auto"
        max-width="600"
        outlined
      >
        <div class="handle" style="background-color:#eee;">
          <v-icon medium style="float:left;">mdi-drag</v-icon>
          <v-btn icon small style="float:right;" height="23" width="23" @click="deleteComponent(index)">
            <v-icon color="grey lighten-1" style="float:right;" small>mdi-delete</v-icon>
          </v-btn>
          <div style="margin:0 5px 0 0;float:right;">
            <editor></editor>
          </div>
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
import Editor from '../components/Editor.vue'

function dumpObj(obj) {
  return JSON.stringify(obj, null, 2)
}

export default {
  components: {
    draggable,
    Editor
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
      )
    },
    deleteComponent: function (index) {
      this.components.splice(index, 1)
    },
    openModal: function (componentId) {
      return componentId
    }
  },
  created() {
    this.axios.get('/api/pages/' + this.$route.params.id + '/edit' ).then((res) => {
      this.components = res.data.components
    })
  },
}
</script>