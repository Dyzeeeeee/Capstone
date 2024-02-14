<template>
  <q-layout view="lHh Lpr lFf">
    <q-page-container>
      <q-page class="flex flex-center bg-yellow-2">
        <q-card class="q-pa-md shadow-2 my_card" bordered>
          <q-card-section class="text-center">
            <div class="text-grey-9 text-h5 text-weight-bold">Register</div>
            <div class="text-grey-8">Create a new account below</div>
          </q-card-section>
          <q-card-section>
            <q-input dense outlined class="q-mt-md" v-model="firstName" label="First Name"></q-input>
            <q-input dense outlined class="q-mt-md" v-model="lastName" label="Last Name"></q-input>
            <q-input dense outlined class="q-mt-md" v-model="email" label="Email Address"></q-input>
            <q-input dense outlined class="q-mt-md" v-model="password" type="password" label="Password"></q-input>
            <q-input dense outlined class="q-mt-md" v-model="confirmPassword" type="password"
              label="Confirm Password"></q-input>
          </q-card-section>
          <q-card-section>
            <q-btn style="border-radius: 8px;" color="green" rounded size="md" label="Register" @click="registerUser"
              no-caps class="full-width"></q-btn>
          </q-card-section>
          <q-card-section class="text-center q-pt-none">
            <div class="text-grey-8">Already have an account? <router-link to="/login" class="text-dark text-weight-bold"
                style="text-decoration: none">Log in.</router-link></div>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const firstName = ref('');
const lastName = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');

const registerUser = async () => {
  // Validate input data (add your validation logic)

  // Prepare data for registration
  const userData = {
    firstName: firstName.value,
    lastName: lastName.value,
    email: email.value,
    password: password.value,
  };

  try {
    // Send registration data to the server using Axios
    const response = await axios.post('/register', userData);

    // Check the response and handle accordingly
    if (response.data.success) {
      // Registration successful
      console.log(response.data.message);

      // Redirect to the login page
      router.push('/login');
    } else {
      // Registration failed
      console.error(response.data.message);
      // You may want to show an error message to the user
    }
  } catch (error) {
    console.error('Error during registration:', error);
    // Handle error (e.g., show an error message to the user)
  }
};
</script>

<style>
.my_card {
  width: 25rem;
  border-radius: 8px;
  box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}
</style>
