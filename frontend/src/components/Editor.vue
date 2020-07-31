<template>
  <v-row justify="center" style="max-height:1000px">
    <v-dialog v-model="dialog" persistent max-width="1000px" max-height="1000px;">
      <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            small
            style="float:right;"
            v-bind="attrs"
            v-on="on"
            height="23"
            width="23"
          >
            <v-icon color="grey lighten-1" small >mdi-pencil</v-icon>
          </v-btn>
      </template>
      <v-card>
        <v-card-text>
          <v-container>
            <tiptap-vuetify v-model="content" :extensions="extensions" placeholder="コンテンツがありません"  />
            <div class="mt-3">{{ content }}</div>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">戻る</v-btn>
          <v-btn color="blue darken-1" text @click="dialog = false, $emit('clickOK', content)">OK</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import {
  // component
  TiptapVuetify,
  // extensions
  Heading,
  Bold,
  Italic,
  Strike,
  Underline,
  Code,
  Paragraph,
  BulletList,
  OrderedList,
  ListItem,
  Link,
  Blockquote,
  HardBreak,
  HorizontalRule,
  History,
  Image,
  TodoList,
  TodoItem,
  Table,
  TableCell,
  TableHeader,
  TableRow
} from 'tiptap-vuetify'

export default {
  components: {
    TiptapVuetify,
  },
  props: {
    componentId: Number
  },
  data() {
    return {
      dialog: false,
      extensions: [
        History,
        Table,
        TableCell,
        TableHeader,
        TableRow,
        Blockquote,
        Link,
        Underline,
        Strike,
        Italic,
        ListItem, // if you need to use a list (BulletList, OrderedList)
        BulletList,
        OrderedList,
        Image,
        [
          Heading,
          {
            // Options that fall into the tiptap's extension
            options: {
              levels: [1, 2, 3]
            }
          }
        ],
        Bold,
        Code,
        HorizontalRule,
        TodoList,
        [TodoItem, {
          options: {
            nested: true
          }
        }],
        Paragraph,
        HardBreak // line break on Shift + Ctrl + Enter
      ],
      content: ``,
    }
  },
}
</script>

<style>
.tiptap-vuetify-editor__content {
  text-align: left;
}
</style>