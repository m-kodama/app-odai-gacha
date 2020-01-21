import Vue from "vue";
import App from './App.vue';
import '@mdi/font/css/materialdesignicons.css'
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify);

new Vue({
  el: "#app",
  vuetify: new Vuetify({
    icons: {
      iconfont: 'mdi',
    },
  }),
  template: "<App/>",
  components: { App: App }
});
