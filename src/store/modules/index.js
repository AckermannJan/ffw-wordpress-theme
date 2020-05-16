import api from '../../api';
import * as types from '../mutation-types';

// initial state
const state = {
  isLoading: false,
  pages: [],
};

// getters
const getters = {
  isLoading: state => state.isLoading,
  pages: state => state.pages,
};

// actions
const actions = {
  getIndexInfo({ commit }) {
    commit(types.UPDATE_LOADING_STATE, true)
    api.getIndexInfo(info => {
      console.log(info)
      commit(types.STORE_FETCHED_INDEX, info);
      commit(types.UPDATE_LOADING_STATE, false);
    });
  },
};

// mutations
const mutations = {
  [types.STORE_FETCHED_INDEX](state, pages) {
    state.pages = pages;
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
