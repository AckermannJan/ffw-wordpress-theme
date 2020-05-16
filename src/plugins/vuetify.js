// src/plugins/vuetify.js

import Vue from 'vue'
import Vuetify from 'vuetify/lib'

Vue.use(Vuetify)

const opts = {
  treeShake: true,
  breakpoint: {
    thresholds: {
      xs: 600
    }
  },
}

export default new Vuetify(opts)