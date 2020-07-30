import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VueAxios from 'vue-axios'
import vuetify from './plugins/vuetify';
import { TiptapVuetifyPlugin } from 'tiptap-vuetify'
// don't forget to import CSS styles
import 'tiptap-vuetify/dist/main.css'
// Vuetify's CSS styles
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'

const axiosBase = require('axios');
const axios = axiosBase.create({
  baseURL: 'http://localhost:8080', // バックエンドB のURL:port を指定する
  headers: {
    'Content-Type': 'application/json',
  },
  responseType: 'json'
})
Vue.use(VueAxios, axios)

// const tiptapvuetify = new vuetify()
Vue.use(TiptapVuetifyPlugin, {
  // the next line is important! You need to provide the Vuetify Object to this place.
  vuetify, // same as "vuetify: vuetify"
  // optional, default to 'md' (default vuetify icons before v2.0.0)
  iconsGroup: 'mdi'
})

Vue.config.productionTip = false

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
