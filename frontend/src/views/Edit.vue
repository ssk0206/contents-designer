<template>
  <div class="edit">
    <button @click="addComponent(1)">+</button>
    <draggable v-model="components" handle=".handle">
      <v-card
        v-for="(component, index) in computedComponent" :key="component.id"
        class="mx-auto card"
        max-width="600"
        outlined
      >
        <div class="handle" style="background-color:#eee;">
          <v-icon medium style="float:left;">mdi-drag</v-icon>
          <v-btn icon small style="float:right;" height="23" width="23" @click="deleteComponent(index)">
            <v-icon color="grey lighten-1" style="float:right;" small>mdi-delete</v-icon>
          </v-btn>
          <div style="margin:0 5px 0 0;float:right;">
            <editor :componentId="component.id" :propsContent="componentData(component.columns)" @clickOK="displayContent($event, component.id)"></editor>
          </div>
        </div>
        <!-- <div v-if="component.columns.length != 0">{{ component.columns[0].content }}</div> -->
        <div style="padding:0 35px 0 25px">
          <div v-if="!isEmptyComponent(component)" v-html="component.columns[0].content"></div>
          <div v-else>コンテンツがありません</div>
        </div>
      </v-card>
    </draggable>
    <div>
      <div><pre>{{formattedItems1}}</pre></div>
      <v-btn
        color="teal"
        dark
        absolute
        bottom
        right
        fixed
        @click="saveComponents"
      >
        <v-icon>mdi-floppy</v-icon> 下書き保存
      </v-btn>
    </div>
  </div>
</template>

<script>
import draggable from 'vuedraggable'
import Editor from '../components/Editor.vue'

function dumpObj(obj) {
  return JSON.stringify(obj, null, 2)
}

function getComponentIndex(components, componentId) {
  return components.findIndex((comp) => {
    return (comp.id === componentId);
  })
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
    computedComponent() {
      return this.components
    },

  },
  methods: {
    componentData(columns) {
      if (columns.length != 0) {
        return columns[0].content
      } else {
        this.content
      }
    },
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
    displayContent: function(content, componentId) {
      const index = getComponentIndex(this.components, componentId)

      if (this.components[index].columns.length == 0) {
        this.components[index].columns.push({
          component_id: componentId,
          content: content,
          order: 1
        })
      } else {
        this.components[index].columns[0].content = content
      }
    },
    isEmptyComponent: function(component) {
      if (component.columns.length == 0) {
        return true
      } else {
        const ans = component.columns.filter(column => {
          return column.content === "" || column.content === "<p></p>"
        })
        return ans.length > 0
      }
      return false
    },
    saveComponents() {
      this.axios.put('/api/pages/' + this.$route.params.id + '/components',
        this.components
      ).then((res) => {
        console.log(res.data)
      })
    }
  },
  created() {
    this.axios.get('/api/pages/' + this.$route.params.id + '/edit' ).then((res) => {
      this.components = res.data.components.sort(function(a, b) {
        return a.order-b.order
      })
      this.lastId = this.components.length
    })
  }
}
</script>

<style scoped>
.card {
  text-align: left;
}
</style>