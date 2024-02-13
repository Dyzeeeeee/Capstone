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
          <template #body-cell-actions="props">
            <q-td :props="props">
              <q-btn round icon="add" color="secondary" />
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
            <q-btn fab-mini dense color="secondary" icon="add" class="absolute"
              style="top: 0; right: 12px; transform: translateY(-50%);" />
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
      <div class="receipt">
        <div class="receipt-header">
          <h2>Receipt</h2>
        </div>
        <div class="receipt-body">
          <!-- Add receipt content here -->
        </div>
        <div class="receipt-footer">
          
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
const pagination = ref({ page: 1, rowsPerPage: 15 });
const selectedView = ref('list'); // Default to list view

const switchToGridView = () => {
  selectedView.value = 'grid';
};

const switchToListView = () => {
  selectedView.value = 'list';
};

const columns = [
  // Define your columns based on menuData structure
  { name: 'image', label: 'Image', align: 'left', field: 'image', sortable: true },
  { name: 'name', label: 'Name', align: 'left', field: 'name', sortable: true },
  { name: 'price', label: 'Price', align: 'left', field: 'price', sortable: true },
  { name: 'description', label: 'Description', align: 'left', field: 'description', sortable: true },
  {
    name: 'actions',
    label: 'Action',
    field: 'actions',
    align: 'center',
    sortable: false,
    // Custom slot for rendering buttons
    bodySlot: 'actions',
  },
];

const getData = async () => {
  try {
    const response = await axios.get('menu/getData');
    menuData.value = response.data;
  } catch (error) {
    console.error('Error fetching menu data:', error);
  }
};

onMounted(() => {
  getData();
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
