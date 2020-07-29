import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VueAxios from 'vue-axios'
import vuetify from './plugins/vuetify';
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
Vue.config.productionTip = false

new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
