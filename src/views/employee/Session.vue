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
              style="top: 0; right: 12px; transform: translateY(-50%);" @click="addOrder(menuItem)">
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
        </q-btn> <q-btn color="secondary" outline icon="add" rounded no-caps class="q-mx-sm" @click="newOrder">
          <div class="text-bold q-pl-sm">
            New Order
          </div>
        </q-btn>
      </div>

      <!--Receipt-->
      <div v-if="!showOrderList" class="bg-white q-mx-lg receipt-container"
        style="height: 71vh; display: flex; flex-direction: column;">
        <div class="q-pa-sm text-h6  receipt-header">
          <b>Order No:&nbsp</b> {{ orderId }}
        </div>
        <div class="receipt-body" style="flex: 1; overflow-y: auto;">
          <q-table :rows="ReceiptItems" :columns="receiptColumns" row-key="id" hide-bottom :pagination.sync="pagination"
            class="receipt-table" flat bordered="">
            <template #body-cell-quantity="props">
              <q-td :props="props">{{ props.row.quantity }}</q-td>
            </template>
            <template #body-cell-menu_item="props">
              <q-td :props="props">{{ props.row.menu_item }}</q-td>
            </template>
            <template #body-cell-subtotal="props">
              <q-td :props="props">{{ props.row.subtotal }}</q-td>
            </template>
            <template #body-cell-action="props">
              <q-td :props="props">
                <q-btn flat round icon="remove_circle_outline" color="secondary" @click="reduceOrder(props.row)" />
                <q-btn flat round icon="cancel" color="negative" @click="removeOrder(props.row)" />
              </q-td>
            </template>
          </q-table>
        </div>
        <q-separator />
        <div class=" q-pa-sm text-subtitle1 justify-end row ">
          <b> Total: &nbsp</b>Php {{ totalOrderPrice }}
        </div>
        <q-separator />
        <div class=" q-px-sm text-subtitle1">
          <b>Note:&nbsp</b> Sample Note
        </div>
        <div class="text-subtitle1  q-px-sm">
          <b>Cashier:&nbsp</b> John Doe
        </div>
        <div class="q-px-sm text-subtitle1">
          <b>Customer:&nbsp</b> Jane Doe
        </div>
      </div>
      <!--Receipt-->

      <!--order list-->
      <!--order list-->
      <div v-if="showOrderList" class="bg-white q-mx-lg order-list"
        style="height: 71vh; display: flex; flex-direction: column;">
        <div class="row q-pa-sm text-h6 text-white" style="background-color:#75a4b9;">
          <div class="col-auto">
            All Orders
          </div>
          <q-space></q-space>
          <div class="col-auto">
            <q-input borderless outlined dense debounce="300" v-model="filter" placeholder="Search order"
              class="bg-white">
              <template v-slot:append>
                <q-icon v-if="filter" color="white" name="clear" @click="clearSearch" />
                <q-icon v-else name="search" color="blue" />
              </template>
            </q-input>
          </div>
        </div>
        <div class="order-body" style="flex: 1; overflow-y: auto;">
          <q-table :rows="orderList" :columns="orderColumns" row-key="id" hide-bottom :pagination.sync="pagination"
            class="order-table" flat bordered="">
            <template #body-cell-action="props">
              <q-td :props="props">
                <q-btn flat round icon="delete" color="negative" @click="deleteOrder(props.row.id)" />
                <q-btn flat round icon="visibility" color="secondary" @click="viewOrderDetails(props.row.id)" />
              </q-td>
            </template>
          </q-table>
        </div>
      </div>
      <!--order list-->

      <!--order list-->

      <div class="row q-mt-sm ">
        <div class="col-3  q-ml-md">
          Register Cash
        </div>
        <q-space></q-space>
        <div class="col-auto ">
          <q-btn color="primary" icon="format_list_numbered_rtl" label="All Orders" no-caps class="q-mx-sm"
            @click="showAllOrders">
            <template v-if="badgeCount >= 1">
              <q-badge color="orange" rounded floating>{{ badgeCount }}</q-badge>
            </template>
          </q-btn>

          <q-btn color="green" icon="account_balance_wallet" icon-right="chevron_right" no-caps label="Payment"
            class="q-mx-sm" @click="goToPayment" />
        </div>
      </div>

    </div>
  </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const badgeCount = ref(0);
const showOrderList = ref(false);
const orderList = ref([]);

const totalOrderPrice = ref(0);
const filter = ref('');
const menuData = ref([]);
const orderId = ref('');
const orderItems = ref({
  order_id: orderId,
  menu_item: '',
  quantity: '',
  subtotal: '',
});

const deleteOrder = async (orderId) => {
  try {
    const confirmDelete = confirm(`Are you sure you want to delete Order No: ${orderId}?`);
    if (!confirmDelete) return;
    // Call your backend API to delete the order
    await axios.delete(`/orders/deleteOrder/${orderId}`);
    // Optionally, you can update the orderList or perform any other necessary actions
    updateBadgeCount(route.params.id);
    const sessionId = route.params.id;
    const response = await axios.get(`/orders/getDataBySession/${sessionId}`);
    getOrderItems();
    getOrderData();
    orderList.value = response.data;
  } catch (error) {
    console.error('Error deleting order:', error);
  }
};

const pagination = ref({ page: 1, rowsPerPage: 100 });
const selectedView = ref('grid');
const route = useRoute(); // Use useRoute to access the current route information

const receiptColumns = [
  { name: 'quantity', label: 'Quantity', align: 'center', field: 'quantity', sortable: true },
  { name: 'menu_item', label: 'Name', align: 'center', field: 'menu_item', sortable: true },
  { name: 'subtotal', label: 'Subtotal', align: 'center', field: 'subtotal', sortable: true },
  { name: 'action', label: 'Action', align: 'center', field: 'total', sortable: true },
];

const orderColumns = [
  { name: 'id', label: 'Order ID', align: 'center', field: 'id', sortable: true },
  { name: 'total', label: 'Total', align: 'center', field: 'total_order_price', sortable: true },
  { name: 'status', label: 'Status', align: 'center', field: 'status', sortable: true },
  { name: 'action', label: 'Action', align: 'center', field: 'total', sortable: true },
];

const switchToGridView = () => {
  selectedView.value = 'grid';
};
const showAllOrders = async () => {
  try {

    const sessionId = route.params.id;
    const response = await axios.get(`/orders/getDataBySession/${sessionId}`);
    orderList.value = response.data;
    showOrderList.value = !showOrderList.value;
  } catch (error) {
    console.error('Error fetching all orders:', error);
  }
};

const switchToListView = () => {
  selectedView.value = 'list';
};

const getOrderData = async () => {
  try {
    const response = await axios.get(`orders/getOrderData/${orderId.value}`);
    const orderData = response.data.data; // Assuming the order data is in the 'data' key

    // Update totalOrderPrice with the received total_order_price
    totalOrderPrice.value = orderData.total_order_price;
  } catch (error) {
    console.error('Error fetching order data:', error);
  }
};

const getData = async () => {
  try {
    const response = await axios.get('menu/getData');
    menuData.value = response.data;
  } catch (error) {
    console.error('Error fetching menu data:', error);
  }
};
import { useRouter } from 'vue-router';
const router = useRouter();

const goToPayment = async () => {
  router.push(`/employee/payment/${orderId.value}`);

}

const newOrder = async () => {

  const sessionId = route.params.id;

  const response = await axios.post('orders/addData', { session_id: sessionId });
  orderId.value = response.data;
  updateBadgeCount(route.params.id);
  getOrderItems(); // Fetch order items
  getOrderData();
}

const addOrder = async (menuItem) => {
  try {

    if (orderId.value == 0 || orderId.value == null) {
      // Extract session_id from the route parameters
      const sessionId = route.params.id;

      const response = await axios.post('orders/addData', { session_id: sessionId });
      orderId.value = response.data;
      addItemToOrder(menuItem);
      updateBadgeCount(route.params.id);
      getOrderData();
      // getOrderItems();
    } else {

      addItemToOrder(menuItem);
    }
  } catch (error) {
    console.error('Error adding order:', error);
  }
}

const addItemToOrder = async (menuItem) => {

  const orderItemData = {
    order_id: orderId.value,
    menu_item: menuItem.name, // Replace with actual menu item ID
    subtotal: menuItem.price, // Replace with the actual subtotal
  };
  await axios.post('orders/addItemToOrder', orderItemData);
  getOrderItems();
  getOrderData();

}
const reduceOrder = async (orderItem) => {
  try {
    const updatedQuantity = orderItem.quantity - 1;

    // Ensure the quantity doesn't go below 0
    if (updatedQuantity >= 0) {
      const updatedSubtotal = updatedQuantity * orderItem.menu_item.price;

      // Call your backend API to update the order item quantity and subtotal
      await axios.put(`orders/updateOrderItem/${orderItem.id}`, {
        quantity: updatedQuantity,
        subtotal: updatedSubtotal,
      });

      getOrderItems(); // Refresh order items after the update
      getOrderData();

    }
  } catch (error) {
    console.error('Error reducing order:', error);
  }
};


const removeOrder = async (orderItem) => {
  try {
    // Call your backend API to delete the order item
    await axios.delete(`orders/deleteOrderItem/${orderItem.id}`);
    getOrderItems(); // Refresh order items after the deletion
    getOrderData();

  } catch (error) {
    console.error('Error removing order:', error);
  }
};
onMounted(() => {
  getData();
  getOrderItems(); // Fetch order items
  getOrderData();
  updateBadgeCount(route.params.id);
  newOrder();


});
const getOrderItems = async () => {
  try {
    if (orderId.value) {
      const response = await axios.get(`orders/getOrderItems/${orderId.value}`);
      ReceiptItems.value = response.data;
    }
  } catch (error) {
    console.error('Error fetching order items:', error);
  }
};
const ReceiptItems = ref([]);

const updateBadgeCount = async (sessionId) => {
  try {
    const response = await axios.get(`orders/getOrderCount/${sessionId}`);
    const orderCount = response.data.count;
    // Update the badge count
    if ((orderId.value == 0)) {
      badgeCount.value = orderCount;
    } else {
      badgeCount.value = orderCount - 1;
    }
  } catch (error) {
    console.error('Error updating badge count:', error);
  }
};
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
  