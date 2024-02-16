<template>
  <div class="q-pa-md">
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

      <div class="col-8 row justify-end ">
        <div class="col-auto ">
          <q-btn @click="openFilterDialog" flat color="primary" icon="filter_alt" />
        </div>
        <div class="col-5 ">
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


        <div class="col-auto ">
          <!-- <q-btn @click="switchToGridView" flat color="secondary" icon="apps"
            :class="{ 'selected': selectedView === 'grid' }" />
          <q-btn @click="switchToListView" flat color="secondary" icon="view_list"
            :class="{ 'selected': selectedView === 'list' }" /> -->
        </div>
        <div class="col-auto q-mx-sm">
          <q-btn @click="openNewSessionDialog" color="green" icon="shopping_bag" label="New Session" no-caps />
        </div>
      </div>
      <!-- Actions-->
    </div>

    <div class="row col-12 ">
      <!-- Check if there are sessions to display -->
      <div v-if="sessions.length > 0" class="row q-gutter-md">
        <!-- Loop through sessions and render a card for each -->
        <div v-for="session in sessions" :key="session.id" class="col-auto">
          <q-card class="session-card">
            <q-card-section>
              <div class="text-h6 text-bold">Cashier Name</div>
              <div class="text-subtitle1">{{ formatDate(session.start_time) }}</div>
              <div class="text-subtitle2 text-italic">{{ formatTime(session.start_time) }}</div>
              <!-- Apply dynamic class based on session status -->
              <div :class="session.status === 'open' ? 'text-subtitle2 text-green' : 'text-subtitle2 text-red'">
                {{ session.status }}
              </div>
            </q-card-section>

            <!-- Additional sections or data as needed -->

            <q-card-actions align="right" class="q-gutter-sm">
              <!-- Button to view details or navigate to a specific page -->
              <q-btn @click="endSession(session.id)" flat color="negative" icon-right="stop" no-caps />
              <q-btn @click="viewSessionDetails(session.id)" color="secondary" icon-right="fast_forward" flat no-caps />
            </q-card-actions>
          </q-card>
        </div>
      </div>
      <!-- Display a message if no sessions are available -->
      <div v-else class="self-center text-h3 text-grey">
        No sessions to show :(
      </div>
    </div>


  </div>


  <q-dialog v-model="showNewSessionDialog">
    <q-card class="my-card" style="width: 400px;">
      <q-card-section>
        <div class="text-h6 text-bold">Opening Cash Control</div>
      </q-card-section>

      <q-separator />

      <q-card-section class="q-pt-md">
        <div class="q-gutter-md">
          <q-input outlined v-model="openingCash" label="Opening Cash">
            <template v-slot:prepend>
              <q-icon name="payments" />
            </template>
          </q-input>
          <q-input outlined v-model="openingNote" label="Opening Note" autogrow>
            <template v-slot:prepend>
              <q-icon name="description" />
            </template>
          </q-input>
        </div>
      </q-card-section>

      <q-separator />

      <q-card-section class="q-pt-md">
        <q-card-actions align="right">
          <q-btn outline @click="closeDialog" color="negative" label="Cancel" no-caps style="width: 85px;" />
          <q-btn outline @click="startNewSession" color="green" label="Open Session" no-caps style="width:140px;" />
        </q-card-actions>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const sessions = ref([]);

const getSessionsData = async () => {
  try {
    const response = await axios.get('/session/getSessions');
    sessions.value = response.data;
  } catch (error) {
    console.error('Error fetching sessions data:', error);
  }
};
const formatDate = (dateTimeString) => {
  const date = new Date(dateTimeString);
  const options = {
    month: 'long',
    day: 'numeric',
    year: 'numeric',
  };
  return date.toLocaleDateString('en-US', options);
};

const formatTime = (dateTimeString) => {
  const date = new Date(dateTimeString);
  const options = {
    hour: 'numeric',
    minute: 'numeric',
    hour12: true,
  };
  return date.toLocaleTimeString('en-US', options);
};


onMounted(() => {
  // Fetch sessions data when the component is mounted
  getSessionsData();
});

const endSession = async (sessionId) => {
  try {
    const response = await axios.post(`/session/end/${sessionId}`, {
      status: 'Closed',
    });

    console.log('Session ended:', response.data);

    // Optionally, you can update the sessions data after ending the session
    getSessionsData();
  } catch (error) {
    console.error('Error ending session:', error);
  }
};

const router = useRouter();

const showNewSessionDialog = ref(false);
const openingCash = ref('');
const openingNote = ref('');

const openNewSessionDialog = () => {
  // Reset values when opening the dialog
  openingCash.value = '';
  openingNote.value = '';
  showNewSessionDialog.value = true;
};

const closeDialog = () => {
  showNewSessionDialog.value = false;
};
const startNewSession = async () => {
  try {
    // Step 1: Create a new session
    const sessionResponse = await axios.post('/session/new', {
      status: 'open',
      opening_cash: openingCash.value,
    });

    console.log('Session Response:', sessionResponse.data);

    const createdSessionId = sessionResponse.data.id;
    console.log('Created Session ID:', createdSessionId);

    // Step 2: Create a new order associated with the session
    const orderResponse = await axios.post('/orders/addData', {
      session_id: createdSessionId,
      total_order_price: 0, // You can set the total_order_price based on your needs
    });

    // Check the actual response structure from the server
    const createdOrderId = orderResponse.data.id; // Adjust based on your server response

    console.log('Created Order ID:', createdOrderId);

    // Step 3: Redirect to the new session or do any other necessary actions
    router.push(`/employee/session/${createdSessionId}`);

    // Optionally, you can update the UI or perform other actions

    // Step 4: Close the dialog
    showNewSessionDialog.value = false;
  } catch (error) {
    console.error('Error:', error);
  }
};



const viewSessionDetails = (sessionId) => {
  // You can implement the logic to navigate to the details page or show a modal
  // For example, you can use the router if you're navigating to another page
  router.push(`session/${sessionId}`);
};
</script>

<style >
.session-card {
  width: 200px;
}
</style>