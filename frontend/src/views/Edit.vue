<template>
  <div class="edit">
      <v-navigation-drawer
        mini-variant
        fixed
        style="padding-top:49px;"
        clipped
      >
        <v-list
          nav
          dense
        >
          <v-list-item-group color="primary">
            <v-menu :offset-x="true">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item
                  link
                  v-bind="attrs"
                  v-on="on">
                  <v-list-item-icon>
                    <v-icon>mdi-plus-box</v-icon>
                  </v-list-item-icon>
                  <v-list-item-content style="">
                    <v-list-item-title>
                      コンポーネント追加
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </template>

              <v-list>
                <v-subheader>コンポーネントリスト</v-subheader>
                <draggable class="list-group" group="components" v-model="newComponents">
                  <v-list-item
                    dense
                    v-for="(item, index) in newComponents"
                    :key="index"
                  >
                    <v-list-item-avatar>
                      <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </draggable>
              </v-list>
            </v-menu>
          </v-list-item-group>
        </v-list>
      </v-navigation-drawer>
    <draggable v-model="components" handle=".handle" class="list-group" group="components">
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
            <editor :componentIndex="index" :propsContent="componentData(component.columns)" @clickOK="displayContent($event, index)"></editor>
          </div>
        </div>
        <div style="padding:0 35px 0 25px">
          <div v-if="!isEmptyComponent(component)" v-html="component.columns[0].content"></div>
          <div v-else>コンテンツがありません</div>
        </div>
      </v-card>
    </draggable>
    <v-btn icon @click="addComponent(1)">
      <v-icon>mdi-plus-box</v-icon>
    </v-btn>
    <div><pre>{{formattedItems1}}</pre></div>
    <div>
      <v-btn
        v-bind:disabled="isProcessing()"
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
import Processing from '../mixins/ButtonMixin'
import draggable from 'vuedraggable'
import Editor from '../components/Editor.vue'

function dumpObj(obj) {
  return JSON.stringify(obj, null, 2)
}

let id_cnt = 0

export default {
  mixins: [Processing],
  components: {
    draggable,
    Editor
  },
  data() {
    return {
      components: [],
      lastId: 0,
      newComponents: [
        {
          id: id_cnt--,
          page_id: this.$route.params.id,
          type: 1,
          order: 0,
          columns: [],
          title: '1 column',
          icon: 'mdi-format-align-justify'
        },
        {
          title: '2 columns',
          icon: 'mdi-format-columns'
        },
      ],
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
      this.components.push({
        "id": id_cnt--,
        "page_id": this.$route.params.id,
        "type": type,
        "order": this.components.length + 1,
        "columns": []
      })
    },
    deleteComponent: function (index) {
      this.components.splice(index, 1)
    },
    displayContent: function(content, index) {
      if (this.components[index].columns.length == 0) {
        this.components[index].columns.push({
          component_id: 0,
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
      } else if(!component.columns[0].content) {
        return true
      } else {
        const ans = component.columns.filter(column => {
          return column.content === "" || column.content === "<p></p>"
        })
        return ans.length > 0
      }
    },
    saveComponents() {
      this.startProcessing()
      this.axios.put('/api/pages/' + this.$route.params.id + '/components',
        this.components
      ).then((res) => {
        if (res.status === 201) {
          res.data.forEach(ele => {
            this.components[ele.order-1].id = ele.id
          });
        }
        this.components.forEach((ele, index) => {
          ele.order = index+1
        })
        this.endProcessing()
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