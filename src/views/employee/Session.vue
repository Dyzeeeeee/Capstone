<template>
  <div class="q-pa-md row">
    <div class="col-7">
      <div class="row items-center q-mb-md" style="display: flex; align-items: center;">
        <!--Breacrumb Title-->
        <div class="col-4 q-pl-lg">
          <q-breadcrumbs class="text-green-9">
            <template v-slot:separator>
              <q-icon size="1.5em" name="chevron_right" color="black" />
            </template>
            <q-breadcrumbs-el label="Restaurant" icon="home" class="text-black" />
            <q-breadcrumbs-el label="Counter" icon="room_service" />
          </q-breadcrumbs>
        </div>
        <!--Breacrumb Title-->

        <!-- Actions-->
        <div class="col-8 row justify-end">
          <div class="col-auto">
            <q-btn @click="openFilterDialog" flat color="primary" icon="filter_alt" />
          </div>
          <div class="col-5">
            <q-input borderless outlined dense debounce="300" v-model="filter" placeholder="Search name">
              <template v-slot:append>
                <q-icon v-if="filter" name="clear" @click="clearSearch" />
                <q-icon v-else name="search" color="primary" />
              </template>
            </q-input>
          </div>
          <div class="col-auto q-mx-sm">
            <q-btn @click="switchToGridView" flat color="secondary" icon="apps"
              :class="{ 'selected': selectedView === 'grid', 'my-selected-button': selectedView === 'grid' }" />
            <q-btn @click="switchToListView" flat color="secondary" icon="view_list"
              :class="{ 'selected': selectedView === 'list', 'my-selected-button': selectedView === 'list' }" />
          </div>
        </div>
        <!-- Actions-->
      </div>

      <div v-if="selectedView === 'list'" class="q-mt-md scrollableq">
        <q-table :rows="menuData" :columns="columns" row-key="id" :pagination.sync="pagination" :filter="filter"
          :rows-per-page-options="[15, 30, 50]" hide-bottom class="my-sticky-header-table">
          <!-- Add image column -->
          <template #body-cell-image="props">
            <q-td :props="props">
              <q-img :src="props.row.image" style="max-width: 50px; max-height: 50px;" />
            </q-td>
          </template>
          <template #body-cell-name="props">
            <q-td :props="props">
              <div class="text-bold">{{ props.row.name }}</div>
            </q-td>
          </template>
        </q-table>
      </div>

      <!-- Grid view -->
      <div v-else-if="selectedView === 'grid'" class="row q-gutter-sm scrollableq justify-center">
        <!-- Loop through menu items and create a card for each -->
        <q-card v-for="menuItem in menuData" :key="menuItem.id" class="my-cardq" flat bordered>
          <q-img :src="menuItem.image" height="100px" />
          <q-btn :ripple="false" fab-mini dense flat color="" icon="info" class="absolute" style="top: 0px; left: 0px;" />
          <q-card-section>
            <q-btn :ripple="false" fab-mini dense color="secondary" icon="add" class="absolute"
              style="top: 0; right: 12px; transform: translateY(-50%);" @click="addToReceipt(menuItem)">
            </q-btn>
            <div class="row items-center">
              <div class="col-12 text-subtitle1 text-bold">{{ menuItem.name }}</div>
              <div class="text-subtitle1 col-12">{{ menuItem.price }}</div>
              <div class="text-caption text-grey ellipsis">{{ menuItem.description }}</div>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
    <div class="col-5">

      <div class="row q-mb-lg justify-center q-mx-md ">
        <q-btn color="primary" outline icon="person_add" rounded no-caps class="q-mx-sm">
          <div class="text-bold q-pl-sm">
            Customer
          </div>
        </q-btn>
        <q-btn color="secondary" outline icon="note_add" rounded no-caps class="q-mx-sm">
          <div class="text-bold q-pl-sm">
            Add Note
          </div>
        </q-btn> <q-btn color="secondary" outline icon="add" rounded no-caps class="q-mx-sm">
          <div class="text-bold q-pl-sm">
            New Order
          </div>
        </q-btn>
      </div>

      <div class="bg-white q-mx-lg receipt-container" style="height: 71vh; display: flex; flex-direction: column;">
        <div class="q-pa-sm text-h6  receipt-header">
          <b>Order No:&nbsp</b> {{ latestOrderId || 'OrderId' }}


        </div>
        <div class="receipt-body" style="flex: 1; overflow-y: auto;">
          <q-table :rows="aggregatedReceiptItems" :columns="receiptColumns" row-key="id" hide-bottom
            :pagination.sync="pagination" class="receipt-table" flat bordered="">
            <template #body-cell-quantity="props">
              <q-td :props="props">{{ props.row.quantity }}</q-td>
            </template>
            <template #body-cell-name="props">
              <q-td :props="props">{{ props.row.name }}</q-td>
            </template>
            <template #body-cell-subtotal="props">
              <q-td :props="props">{{ props.row.price * props.row.quantity }}</q-td>
            </template>
            <template #body-cell-action="props">
              <q-td :props="props">
                <q-btn flat round icon="remove_circle_outline" color="secondary"
                  @click="subtractFromReceipt(props.row)" />
                <q-btn flat round icon="cancel" color="negative" @click="removeFromReceipt(props.row)" />
              </q-td>
            </template>
          </q-table>

        </div>
        <q-separator />
        <div class="q-pa-sm text-subtitle1 justify-end row  ">
          <b> Total: &nbsp</b>Php {{ calculateTotalPrice() }}.00
        </div>
        <q-separator />

        <div class="q-px-sm text-subtitle1">
          <b>Note:&nbsp</b> Sample Note
        </div>
        <div class="text-subtitle1  q-px-sm">
          <b>Cashier:&nbsp</b> John Doe
        </div>
        <div class="q-px-sm text-subtitle1">
          <b>Customer:&nbsp</b> Jane Doe
        </div>
      </div>

      <div class="row q-mt-sm  q-mx-md ">
        <div class="col-4  q-ml-md">
          Register Cash
        </div>
        <q-space></q-space>
        <div class="col-auto ">
          <q-btn color="primary" icon="format_list_numbered_rtl" label="All Orders" no-caps class="q-mx-sm" />
          <q-btn color="green" icon-right="chevron_right" no-caps label="Payment" class="q-mx-sm" />
        </div>
      </div>

    </div>
  </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';


const filter = ref('');
const menuData = ref([]);
const pagination = ref({ page: 1, rowsPerPage: 100 });
const selectedView = ref('grid'); // Default to list view
const latestOrderId = ref(null);


const receiptColumns = [
  { name: 'quantity', label: 'Quantity', align: 'center', field: 'quantity', sortable: true },
  { name: 'name', label: 'Name', align: 'center', field: 'name', sortable: true },
  { name: 'subtotal', label: 'Subtotal', align: 'center', field: 'total', sortable: true },
  { name: 'action', label: 'Action', align: 'center', field: 'total', sortable: true },
];

const switchToGridView = () => {
  selectedView.value = 'grid';
};

const aggregatedReceiptItems = ref([]); // New ref to store aggregated items

const addToReceipt = (item) => {
  const existingItem = aggregatedReceiptItems.value.find((ri) => ri.id === item.id);

  if (existingItem) {
    existingItem.quantity += 1;
  } else {
    aggregatedReceiptItems.value.push({ ...item, quantity: 1 });
  }

  updateOrderTotalPrice(); // Update total price after adding an item
};


const removeFromReceipt = (item) => {
  const index = aggregatedReceiptItems.value.findIndex((ri) => ri.id === item.id);

  if (index !== -1) {
    aggregatedReceiptItems.value.splice(index, 1);
    updateOrderTotalPrice(); // Update total price after removing an item
  }
};
const switchToListView = () => {
  selectedView.value = 'list';
};

const getLatestOrderId = async () => {
  try {
    const response = await axios.get('orders/getLatestOrderId');
    latestOrderId.value = response.data.id;
  } catch (error) {
    console.error('Error fetching latest order ID:', error);
  }
};

const subtractFromReceipt = (item) => {
  const existingItem = aggregatedReceiptItems.value.find((ri) => ri.id === item.id);

  if (existingItem) {
    if (existingItem.quantity > 1) {
      existingItem.quantity -= 1;
    } else {
      // Remove the item if the quantity is 1 or less
      const index = aggregatedReceiptItems.value.findIndex((ri) => ri.id === item.id);
      if (index !== -1) {
        aggregatedReceiptItems.value.splice(index, 1);
      }
    }
    updateOrderTotalPrice(); // Update total price after subtracting an item
  }
};

const calculateTotalPrice = () => {
  return aggregatedReceiptItems.value.reduce((total, item) => {
    return total + item.price * item.quantity;
  }, 0);
};

const getData = async () => {
  try {
    const response = await axios.get('menu/getData');
    menuData.value = response.data;
  } catch (error) {
    console.error('Error fetching menu data:', error);
  }
};

const updateOrderTotalPrice = async () => {
  try {
    const totalOrderPrice = calculateTotalPrice();
    const orderId = latestOrderId.value; // Assuming latestOrderId is available in your component

    await axios.put(`orders/updateTotalOrderPrice/${orderId}`, {
      totalOrderPrice: totalOrderPrice,
    });

    console.log('Total order price updated successfully.');
  } catch (error) {
    console.error('Error updating total order price:', error);
  }
};




onMounted(() => {
  getData(); // Fetch menu data
  getLatestOrderId(); // Fetch latest order ID
});
</script>
  
<style>
.my-sticky-header-table {
  height: 80vh;
}

.my-sticky-header-table .q-table__top,
.my-sticky-header-table .q-table__bottom,
.my-sticky-header-table thead tr:first-child th {
  background-color: #75a4b9;
  color: white;
  /* Set header text color to white */
  font-weight: bold;
  /* Set header text to bold */
}

.my-sticky-header-table thead tr th {
  position: sticky;
  z-index: 1;
}

.my-sticky-header-table thead tr:first-child th {
  top: 0;
}

.my-sticky-header-table.q-table--loading thead tr:last-child th {
  top: 48px;
}

.my-sticky-header-table tbody {
  scroll-margin-top: 48px;
}


.scrollableq {
  overflow-y: auto;
  max-height: 80vh;
}

.my-cardq {
  width: 100%;
  max-width: 150px;
}

.my-selected-button {
  background-color: #75a4b9;
  /* Set the background color for the selected button */
  color: white !important;
  /* Set the text color for the selected button */
}
</style>
  