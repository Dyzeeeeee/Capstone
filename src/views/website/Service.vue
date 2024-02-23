<template>
    <div class="py- page-title mb-5">


        <div>
            <h1 class="title-transition">SERVICES</h1>
        </div>



    </div>
    <div class="position-relative p-0 ">

        <service />

        <footer1 />

    </div>
</template>
  
<style scoped></style>


<script setup>

import Service from '@/components/website/service.vue';
import footer1 from '@/components/website/footer.vue';

window.addEventListener('load', function() {
        const pageTitle = document.querySelector('.page-title');
        pageTitle.classList.add('slide-down');
    });


</script>
