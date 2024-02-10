<template>
  <div class="q-pa-md row">
    <div class="col-7">
      <div class="row items-center q-mb-md justify-around">
        <div class="col-auto">
          <q-btn @click="onFilterClick" flat color="primary" icon="filter_alt" />
        </div>
        <div class="col-6">
          <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </div>
        <div class="col-auto">
          <q-btn flat color="secondary" icon="apps" />
          <q-btn flat color="secondary" icon="view_list" />
        </div>
      </div>
      <div class="row q-gutter-sm scrollableq justify-center">
        <!-- Loop through menu items and create a card for each -->
        <q-card v-for="menuItem in menuData" :key="menuItem.id" class="my-card" flat bordered>
          <q-img :src="menuItem.image" height="100px" />
          <q-btn :ripple="false" fab-mini dense flat color="" icon="info" class="absolute" style="top: 0px; left: 0px;" />
          <q-card-section>
            <q-btn fab-mini dense color="secondary" icon="add" class="absolute"
              style="top: 0; right: 12px; transform: translateY(-50%);" />
            <div class="row items-center">
              <div class="col-12 text-subtitle1 text-bold">
                {{ menuItem.name }}
              </div>
              <div class="text-subtitle1 col-12">
                {{ menuItem.price }}
              </div>
              <div class="text-caption text-grey ellipsis">
                {{ menuItem.description }}
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
    <div class="col-5">
      receipt
    </div>
  </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const filter = ref('');
const menuData = ref([]);

const onFilterClick = () => {
  // Implement filtering logic here
  // For now, let's just console.log to indicate the click
  console.log('Filter button clicked!');
};

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
  

<style scoped>
.scrollableq {
  overflow-y: auto;
  max-height: 80vh;
}

.my-card {
  width: 100%;
  max-width: 150px;
}
</style>
