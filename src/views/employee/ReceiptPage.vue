<template>
  <div class="receipt-container">
    <div class="receipt-header">
      <div class="text-bold q-pt-md q-px-md row q-pb-sm  text-h6 justify-center">
        Anahaw
      </div>
      <div class="q-px-md row  text-caption justify-center text-center">
        Anahaw Address, Calapan, Oriental Mindoro <br>
        (+63)900-000-0000 <br>
        AnahawEmail@email.com <br>
      </div>
      <q-separator></q-separator>
      <div class="q-px-md row  text-caption justify-center text-center">
        Served by: {{ OrderData.cashier_name }}
      </div>
    </div>

    <!-- Loop through ReceiptItems -->
    <div v-for="(item, index) in ReceiptItems" :key="index">
      <div class="text-bold q-pt-md q-px-md row text-subtitle2">
        {{ item.menu_item }}
        <q-space></q-space>
        {{ item.subtotal }}
      </div>
      <div class="text-italic q-px-md text-caption">
        {{ item.quantity }} x {{ item.menu_item.price }}
      </div>
    </div>

    <div class="text-bold row  text-subtitle1">
      <div class="justify-center q-pa-md col-4 "></div>
      <div class="justify-center q-pa-md col-4 ">TOTAL: </div>
      <div class="justify-end text-right q-pa-md col-4">Php {{ OrderData.total_order_price }} </div>
    </div>
    <div class="text-bold row  text-subtitle2">
      Payment Method <q-space></q-space>Tendered
    </div>
    <div class="text-bold row  text-subtitle1 ">
      <div class="justify-center q-pa-md col-4 "></div>
      <div class="justify-center q-pa-md col-4 ">CHANGE: </div>
      <div class="text-right q-pa-md col-4">Php {{ OrderData.change1 }} </div>
    </div>
    <div class="text-bold q-px-md row  text-subtitle2">
      VAT <q-space></q-space>Vat %
    </div>
    <div class="justify-center row">
      QR siguro
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const OrderData = ref({});
const ReceiptItems = ref([]);

</script>

<style scoped>
.receipt-container {
  width: 58mm;
  height: 100mm;
  overflow-y: auto;
  padding: 10px;
}

.receipt-header {
  font-weight: bold;
  margin-bottom: 10px;
}
</style>
