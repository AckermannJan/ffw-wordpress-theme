import Vue from 'vue'
import Vuex from 'vuex'
import createPersist from 'vuex-localstorage'
import * as actions from './actions'
import * as getters from './getters'
import hub from './modules/hub'
import user from './modules/user'
import post from './modules/post'
import page from './modules/page'
import index from './modules/index'
import sideBar from './modules/sideBar'
import categories from './modules/categories'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

let localStorage = createPersist({
    namespace: 'YOUR_APP_NAMESPACE',
    initialState: {},
    expires: 1.21e+9 // Two Weeks
})

export default new Vuex.Store({
  namespaced: true,
  actions,
  getters,
  modules: {
    hub,
    user,
    post,
    sideBar,
    page,
    index,
    categories
  },
  strict: debug,
  plugins: [localStorage]
})
