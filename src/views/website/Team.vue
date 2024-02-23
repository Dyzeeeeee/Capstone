<template>
    <div class="py-5 page-title mb-5">


        <div>
            <h1 class="title-transition">OUR BANDS</h1>
        </div>



    </div>
    <div class="position-relative p-0">

        <team />
        <footer1 />

    </div>
</template>
  
<style scoped></style>


<script setup>

import team from '@/components/website/team.vue';
import footer1 from '@/components/website/footer.vue';

window.addEventListener('load', function() {
        const pageTitle = document.querySelector('.page-title');
        pageTitle.classList.add('slide-down');
    });


</script>