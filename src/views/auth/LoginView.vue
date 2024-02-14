<template>
    <q-layout view="lHh Lpr lFf">
        <q-page-container>
            <q-page class="flex flex-center bg-yellow-2">
                <q-card class="q-pa-md shadow-2 my_card" bordered>
                    <q-card-section class="text-center">
                        <div class="text-grey-9 text-h5 text-weight-bold">Sign in</div>
                        <div class="text-grey-8">Sign in below to access your account</div>
                    </q-card-section>
                    <q-card-section>
                        <q-input dense outlined v-model="email" label="Email Address"></q-input>
                        <q-input dense outlined class="q-mt-md" v-model="password" type="password"
                            label="Password"></q-input>
                    </q-card-section>
                    <q-card-section>
                        <q-btn style="border-radius: 8px;" color="green" rounded size="md" label="Sign in" no-caps
                            class="full-width" @click="loginUser"></q-btn>

                    </q-card-section>
                    <q-card-section class="text-center q-pt-none">
                        <div class="text-grey-8">Don't have an account yet?
                            <a href="/register" class="text-dark text-weight-bold" style="text-decoration: none">Sign
                                up.</a>
                        </div>
                    </q-card-section>

                </q-card>
            </q-page>
        </q-page-container>
    </q-layout>
</template>


<style>
.my_card {
    width: 25rem;
    border-radius: 8px;
    box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}
</style>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';



const router = useRouter();

const email = ref('');
const password = ref('');

const loginUser = async () => {
    // Validate input data (add your validation logic)

    // Prepare data for login
    const userData = {
        email: email.value,
        password: password.value,
    };

    try {
        // Send login data to the server using Axios
        const response = await axios.post('/login', userData);

        // Check the response and handle accordingly
        if (response.data.success) {
            // Login successful
            console.log(response.data.message);

            // Redirect to another route (change '/dashboard' to the desired route)
            router.push('/website/home');
        } else {
            // Login failed
            console.error(response.data.message);
            // You may want to show an error message to the user
        }
    } catch (error) {
        console.error('Error during login:', error);
        // Handle error (e.g., show an error message to the user)
    }
};
</script>
