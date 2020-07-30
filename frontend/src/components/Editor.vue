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
            <tiptap></tiptap>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="dialog = false">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import Tiptap from './Tiptap'
export default {
  components: {
    Tiptap
  },
  data: () => ({
    dialog: false,
  }),
}
</script>