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
              <q-input dense outlined class="q-mt-md" v-model="username" label="Username"></q-input>
              <q-input dense outlined class="q-mt-md" v-model="email" label="Email Address"></q-input>
              <q-input dense outlined class="q-mt-md" v-model="password" type="password" label="Password"></q-input>
              <q-input dense outlined class="q-mt-md" v-model="confirmPassword" type="password" label="Confirm Password"></q-input>
            </q-card-section>
            <q-card-section>
              <q-btn style="border-radius: 8px;" color="green" rounded size="md" label="Register" @click="registerUser" no-caps class="full-width"></q-btn>
            </q-card-section>
            <q-card-section class="text-center q-pt-none">
              <div class="text-grey-8">Already have an account? <router-link to="/login" class="text-dark text-weight-bold" style="text-decoration: none">Log in.</router-link></div>
            </q-card-section>
          </q-card>
        </q-page>
      </q-page-container>
    </q-layout>
  </template>
  
  <script>
  export default {
    data() {
      return {
        username: '',
        email: '',
        password: '',
        confirmPassword: '',
      };
    },
    methods: {
      registerUser() {
        // Implement your user registration logic here
        console.log('User registered:', this.username, this.email, this.password);
        // You may want to use a service to send registration data to your server
      },
    },
  };
  </script>
  
  <style>
  .my_card {
      width: 25rem;
      border-radius: 8px;
      box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
  }
  </style>
  