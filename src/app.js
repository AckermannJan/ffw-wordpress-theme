import Vue from 'vue';
require('./bootstrap');
import './assets/css/styles.css';

import router from './router';
import App from './App.vue';
import store from './store';
import vuetify from './plugins/vuetify';

new Vue({
  vuetify,
  el: '#app',
  store,
  router,
  render: h => h(App),
  created() {
    this.$store.dispatch('index/getIndexInfo');
    this.$store.dispatch('sideBar/getSidebarInfo');
  },
});
