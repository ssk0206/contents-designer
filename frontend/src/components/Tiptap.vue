<template>
  <div>
    <!-- Use the component in the right place of the template -->
    <tiptap-vuetify v-model="content" :extensions="extensions" placeholder="コンテンツがありません"  />
    <div class="mt-3">{{ content }}</div>
  </div>
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
  components: { TiptapVuetify },
  data() {
    return {
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
  }
}
</script>

<style>
.tiptap-vuetify-editor__content {
  text-align: left;
}
</style>