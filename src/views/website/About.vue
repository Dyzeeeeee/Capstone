<template>
    <div class="py-5 page-title mb-5">
        <h1>ABOUT</h1>
    </div>
    <div class="position-relative p-0 ">

        <about />

        <footer1 />

    </div>
</template>
  
<style scoped></style>


<script setup>

import about from '@/components/website/about.vue';
import footer1 from '@/components/website/footer.vue';

document.addEventListener("DOMContentLoaded", function() {
    var title = document.querySelector(".title");
    title.classList.add("show");
});



</script>