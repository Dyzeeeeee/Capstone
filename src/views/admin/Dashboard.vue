<template>
  <div class="q-pa-md">


    <div class="row items-center q-mb-md" style="display: flex; align-items: center;">
      <!--Breacrumb Title-->
      <div class="col-4 q-pl-lg">
        <q-breadcrumbs class="text-green-9">
          <template v-slot:separator>
            <q-icon size="1.5em" name="chevron_right" color="black" />
          </template>
          <q-breadcrumbs-el label="Dashboard" icon="speed" class="text-black" />
        </q-breadcrumbs>
      </div>
      <!--Breacrumb Title-->

      <!-- Actions-->

      <div class="col-8 row justify-end ">
        <div class="col-5 ">
          <q-input borderless outlined dense debounce="300" v-model="filter" placeholder="Search name">
            <template v-slot:append>
              <q-icon v-if="filter" name="clear" @click="clearSearch" />
              <q-icon v-else name="search" color="primary" />
            </template>
          </q-input>
        </div>
      </div>
      <!-- Actions-->
    </div>

    <div class="row q-gutter-sm justify-center q-pb-sm bg-white">
      <q-card class="my-qcard" bordered flat>
        <q-card-section class="bg-grey-9 text-white row">
          <div class="col-8" style="display: flex; flex-direction: column; justify-content: flex-end;">
            <div class="text-subtitle2">Total Earnings</div>
            <div class="text-h3 text-bold ">400</div>
          </div>
          <div class="col-4">
            <q-icon name="account_balance_wallet" size="80px"></q-icon>
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions align="left" class="bg-grey-1 text-black">
          More Details
        </q-card-actions>
      </q-card>





      <q-card class="my-qcard" bordered flat>
        <q-card-section class="bg-grey-9 text-white row">
          <div class="col-8" style="display: flex; flex-direction: column; justify-content: flex-end;">
            <div class="text-subtitle2">Profit</div>
            <div class="text-h3 text-bold ">400</div>
          </div>
          <div class="col-4">
            <q-icon name="payments" size="80px"></q-icon>
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions align="left" class="bg-grey-1 text-black">
          More Details
        </q-card-actions>
      </q-card>


      <q-card class="my-qcard" bordered flat>
        <q-card-section class="bg-grey-9 text-white row">
          <div class="col-8" style="display: flex; flex-direction: column; justify-content: flex-end;">
            <div class="text-subtitle2">Total Earnings</div>
            <div class="text-h3 text-bold ">400</div>
          </div>
          <div class="col-4">
            <q-icon name="account_balance" size="80px"></q-icon>
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions align="left" class="bg-grey-1 text-black">
          More Details
        </q-card-actions>
      </q-card>

    </div>

    <!-- <q-separator spaced></q-separator> -->

    <div class="row">
      <div class="col-6 row justify-center  ">
        <div class="col-12 row q-gutter-sm justify-center q-mt-sm bg-white q-mr-sm">
          <q-card class="cardy" bordered flat>
            <q-card-section class="bg-blue-8 text-white row">
              <div class="col-8">
                <div class="text-subtitle2">Total Orders</div>
                <div class="text-h3 text-bold ">{{ totalOrders }}</div>
              </div>
              <div class="col-4">
                <q-icon name="room_service" size="80px"></q-icon>
              </div>
            </q-card-section>

            <q-separator />

            <q-card-actions align="left">
              More Details
            </q-card-actions>
          </q-card>
          <q-card class="cardy" bordered flat>
            <q-card-section class="bg-primary text-white row">
              <div class="col-8">
                <div class="text-subtitle2">Total Customers</div>
                <div class="text-h3 text-bold ">400</div>
              </div>
              <div class="col-4">
                <q-icon name="groups" size="80px"></q-icon>
              </div>
            </q-card-section>

            <q-separator />

            <q-card-actions align="left">
              More Details
            </q-card-actions>
          </q-card>
          <div class="col-10  justify-center q-mt-lg">
            start date to end date
            <Vue3ApexCharts type="bar" :options="chartOptions" :series="chartSeries" height="300" />
          </div>
        </div>

      </div>

      <div class="col-6 row justify-center ">
        <div class="col-12 row q-gutter-sm justify-center q-mt-sm bg-white q-ml-sm">

          <q-card class="cardy" bordered flat>
            <q-card-section class="bg-blue-grey-6 text-white row">
              <div class="col-8">
                <div class="text-subtitle2">Total Reservations</div>
                <div class="text-h3 text-bold ">400</div>
              </div>
              <div class="col-4">
                <q-icon name="room_service" size="80px"></q-icon>
              </div>
            </q-card-section>

            <q-separator />

            <q-card-actions align="left">
              More Details
            </q-card-actions>
          </q-card>
          <q-card class="cardy" bordered flat>
            <q-card-section class="bg-blue-grey-6 text-white row">
              <div class="col-8">
                <div class="text-subtitle2">Total Guests</div>
                <div class="text-h3 text-bold ">400</div>
              </div>
              <div class="col-4">
                <q-icon name="groups" size="80px"></q-icon>
              </div>
            </q-card-section>

            <q-separator />

            <q-card-actions align="left">
              More Details
            </q-card-actions>
          </q-card>
          <div class="col-10 justify-center q-pt-sm">
            <Vue3ApexCharts type="bar" :options="chartOptions" :series="chartSeries" height="300" />
          </div>
        </div>

      </div>
    </div>

    <div class="row">

    </div>


  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Vue3ApexCharts from 'vue3-apexcharts';

const totalOrders = ref(0);
const orderDataByDate = ref({});

const getOrderData = async () => {
  try {
    const response = await axios.get("orders/getData");

    // Organize data by day of the week
    orderDataByDate.value = response.data.reduce((acc, order) => {
      const date = new Date(order.order_date);
      const dayOfWeek = date.toLocaleDateString('en-US', { weekday: 'long' });

      // Check if the date is within the desired range
      const { startDate, endDate } = getStartAndEndDates();
      if (date >= startDate && date <= endDate) {
        if (!acc[dayOfWeek]) {
          acc[dayOfWeek] = 1;
        } else {
          acc[dayOfWeek]++;
        }
      }

      return acc;
    }, {});

    // Update totalOrders
    totalOrders.value = Object.values(orderDataByDate.value).reduce((sum, count) => sum + count, 0);

    // Update chart data
    const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const data = weekdays.map(day => orderDataByDate.value[day] || 0);

    chartOptions.value.xaxis.categories = weekdays;
    chartSeries.value[0].data = data;
  } catch (error) {
    console.error("Error fetching order data:", error);
  }
};

const chartOptions = ref({
  chart: {
    height: 350,
    type: 'bar',
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%',
      endingShape: 'rounded',
      colors: {
        ranges: [{
          from: 0,
          to: 0,
          color: undefined
        }],
        backgroundBarColors: [],
        backgroundBarOpacity: 1,
        backgroundBarRadius: 0,
      }
    },
  },
  dataLabels: {
    enabled: true,
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent'],
  },
  xaxis: {
    categories: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    title: {
      text: 'Order Dates',
    },
    labels: {
      formatter: function (value) {
        // You can format the date as needed here
        return value;
      },
    },
  },
  yaxis: {
    title: {
      text: 'Number of Orders',
    },
  },
  fill: {
    opacity: 1,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val;
      },
    },
  },
});

const chartSeries = ref([
  {
    name: 'Total Orders',
    data: [], // Will be filled dynamically
  },
]);


// ... (your imports and other setup code) ...

onMounted(() => {
  getOrderData();
});

const getStartAndEndDates = () => {
  const currentDate = new Date();
  const startDate = new Date(currentDate);
  startDate.setDate(currentDate.getDate() - currentDate.getDay()); // Start from Sunday

  // If the start date is set to Sunday, adjust it to the previous Sunday
  if (startDate.getDay() === 0) {
    startDate.setDate(startDate.getDate() - 7);
  }

  const endDate = new Date(currentDate);
  endDate.setDate(currentDate.getDate() + (6 - currentDate.getDay())); // End on Saturday
  return { startDate, endDate };
};
</script>



<style>
.my-qcard {
  width: 100%;
  max-width: 500px;
}

.cardy {
  width: 380px;
}
</style>


