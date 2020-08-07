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
                <draggable class="list-group"
                  :group="{ name: 'components', pull: 'clone', put: false }"
                  :clone="cloneComponent"
                  v-model="newComponents"
                >
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
        v-show="!component.trash"
      >
        <div class="handle" style="background-color:#eee;">
          <v-icon medium style="float:left;">mdi-drag</v-icon>
          <v-btn icon small style="float:right;" height="23" width="23" @click="addTrashFlag(index)">
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
        top
        right
        fixed
        @click="saveComponents"
        style="margin-top:50px;"
      >
        <v-icon>mdi-floppy</v-icon> 下書き保存
      </v-btn>
    </div>
    <div>
    </div>
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="grey darken-1"
          dark
          absolute
          x-large
          icon
          bottom
          right
          fixed
            v-bind="attrs"
            v-on="on"
        >
          <v-icon>mdi-delete</v-icon>
        </v-btn>
      </template>
      <v-card>
      <v-list>
        <v-list-item
          v-for="(component, index) in trashBox"
          :key="index"
        >
          <v-list-item-content>
            <v-list-item-title >{{ component.title }}</v-list-item-title>
            <v-list-item-subtitle v-if="!isEmptyComponent(component)" v-text="component.columns[0].content.substr( 0, 10 )"></v-list-item-subtitle>
            <v-list-item-subtitle v-else v-text="'空のコンポーネント'"></v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn text @click="menu = false">キャンセル</v-btn>
          <v-btn color="red" text @click="deleteTrash()">ゴミ箱を空にする</v-btn>
        </v-card-actions>
      </v-card>
    </v-menu>
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
          trash: 0,
          columns: [],
          title: '1 column',
          icon: 'mdi-format-align-justify'
        },
        {
          title: '2 columns',
          icon: 'mdi-format-columns'
        },
      ],
      trashBox: []
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
        id: id_cnt--,
        page_id: this.$route.params.id,
        type: type,
        trash: false,
        order: this.components.length + 1,
        columns: [],
        title: '1 column',
      })
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
    },
    cloneComponent() {
      return {
        id: id_cnt--,
        page_id: this.$route.params.id,
        type: 1,
        order: 0,
        trash: false,
        columns: [],
        title: '1 column',
        icon: 'mdi-format-align-justify'
      }
    },
    addTrashFlag(index) {
      this.components[index].trash = true
      this.trashBox.push(this.components[index])
    },
    deleteTrash() {
      const trash = this.components.filter(function(component){
        return component.trash == true
      })
      this.axios.delete('/api/pages/' + this.$route.params.id + '/components', { data: trash }).then(() => {
        this.trashBox = []
      })
    }
  },
  created() {
    this.axios.get('/api/pages/' + this.$route.params.id + '/edit' ).then((res) => {
      this.components = res.data.components.sort(function(a, b) {
        return a.order-b.order
      })
      this.lastId = this.components.length
      this.trashBox = this.components.filter(function(component){
        return component.trash == true
      })
    })
  }
}
</script>

<style scoped>
.card {
  text-align: left;
}
</style>