// store/index.js
import { createStore } from 'vuex';

export default createStore({
  state: {
    activeItem: null,
  },
  mutations: {
    setActiveItem(state, item) {
      state.activeItem = item;
    },
  },
  actions: {
    setActiveItem({ commit }, item) {
      commit('setActiveItem', item);
    },
  },
  getters: {
    getActiveItem: (state) => state.activeItem,
  },
});
