import api from '../../api';
import * as types from '../mutation-types';

// initial state
const state = {
  isLoading: false,
  data: [],
};

// getters
const getters = {
  isLoading: state => state.isLoading,
  latestAlarm: state => state.data.latestAlarm,
  nextThreeMeetings: state => state.data.nextThreeMeetings,
  sideBar: state => state.data.sideBar,
};

// actions
const actions = {
  getSidebarInfo({ commit }) {
    commit(types.UPDATE_LOADING_STATE, true)
    api.getSidebarInfo(info => {
      console.log(info)
      commit(types.STORE_FETCHED_SIDEBAR, info);
      commit(types.UPDATE_LOADING_STATE, false);
    });
  },
};

// mutations
const mutations = {
  [types.STORE_FETCHED_SIDEBAR](state, data) {
    state.data = data;
  },

  [types.UPDATE_LOADING_STATE](state, val) {
    state.isLoading = val;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
