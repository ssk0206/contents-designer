import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VueAxios from 'vue-axios'

Vue.config.productionTip = false
const axiosBase = require('axios');
const axios = axiosBase.create({
  baseURL: 'http://localhost:8080', // バックエンドB のURL:port を指定する
  headers: {
    'Content-Type': 'application/json',
  },
  responseType: 'json'
})
Vue.use(VueAxios, axios)

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
