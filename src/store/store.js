// store.js
import { createStore } from 'vuex';

export default createStore({
  state: {
    aggregatedReceiptItems: [],
  },
  mutations: {
    addToReceipt(state, item) {
      const existingItem = state.aggregatedReceiptItems.find((ri) => ri.id === item.id);

      if (existingItem) {
        existingItem.quantity += 1;
      } else {
        state.aggregatedReceiptItems.push({ ...item, quantity: 1 });
      }
    },
  },
  actions: {
    // You can add other actions if needed
  },
  getters: {
    // You can add getters if needed
  },
});
