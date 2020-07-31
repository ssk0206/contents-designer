<template>
  <div class="edit">
    <button @click="addComponent(1)">+</button>
    <h1>This is an edit page {{ $route.params.id }}</h1>
    <draggable v-model="comp" handle=".handle">
      <v-card
        v-for="(component, index) in comp" :key="component.id"
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
        <div v-if="component.columns.length != 0">{{ component.columns[0].content }}</div>
        <div v-else>コンテンツがありません</div>
      </v-card>
    </draggable>
    <div>
     <!-- <div><pre>{{formattedItems1}}</pre></div> -->
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
      lastId: 0,
    }
  },
  computed: {
    formattedItems1() {
      return dumpObj(this.components);
    },
    comp() {
      return this.components
    }
  },
  methods: {
    addComponent: function(type) {
      this.lastId++
      this.axios.post('/api/pages/' + this.$route.params.id + '/components', {
        "type": type,
        "order": this.components.length + 1,
      }).then((res) => {
        let resData = res.data
        this.components.push(
          {
            "id": resData.id,
            "page_id": resData.page_id,
            "type": resData.type,
            "order": resData.order,
            "columns": []
          }
        )
      })
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
      this.lastId = this.components.length
    })
  },
}
</script>