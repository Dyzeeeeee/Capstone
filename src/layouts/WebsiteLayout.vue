<template>
    
    <q-layout view="hHh Lpr lff" container style="height: 100vh;" class="shadow-2 rounded-borders bg-light-blue-1">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0" style="margin-bottom: 300px;" >
            <a href="" class="navbar-brand p-0">
                <!-- <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restoran</h1> -->
                <img src="@/assets/img/logo.png" alt="Logo" style="max-height: 80px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0 pe-4">
                    <a href="home" class="nav-item nav-link active">Home</a>
                    <a href="about" class="nav-item nav-link">About</a>
                    <a href="service" class="nav-item nav-link">Service</a>
                    <a href="menu" class="nav-item nav-link">Menu</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0">
                            <a href="booking" class="dropdown-item">Booking</a>
                            <a href="team" class="dropdown-item">Our Team</a>
                            <a href="testimonial" class="dropdown-item">Testimonial</a>
                        </div>
                    </div>
                    <a href="contact" class="nav-item nav-link">Contact</a>
                </div>
                <a href="" class="btn btn-primary py-2 px-4">Book A Table</a>
            </div>
        </nav>
        <q-page-container>
            <Router-View />
        </q-page-container>
    </q-layout>
</template>

<script>
import '@/assets/lib/animate/animate.min.css';
import '@/assets/lib/owlcarousel/assets/owl.carousel.min.css';
import '@/assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css';
import '@/assets/css/bootstrap.min.css';
import '@/assets/css/style.css';

import { ref } from 'vue'

export default {
    setup() {
        const miniState = ref(false)
        const fullScreen = ref(false)

        return {
            drawer: ref(false),
            miniState,
            fullScreen,

            drawerClick(e) {
                if (miniState.value) {
                    miniState.value = false
                    e.stopPropagation()
                }
            },

            toggleFullScreen() {
                const elem = document.documentElement

                if (!document.fullscreenElement) {
                    elem.requestFullscreen().catch((err) => {
                        console.error(`Error attempting to enable full-screen mode: ${err.message}`)
                    })
                    fullScreen.value = true
                } else {
                    document.exitFullscreen()
                    fullScreen.value = false
                }
            },
        }
    },
}
</script>


<style scoped>


</style>