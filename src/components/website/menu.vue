<template>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                <h1 class="mb-5">Most Popular Items</h1>
            </div>
            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <li v-for="(category, index) in categories" :key="index" class="nav-item">
                        <a class="nav-link q-mx-sm" :class="{ 'active': selectedCategory === category.category }" @click="selectedCategory = category.category">
                            <i class="fa" :class="categoryIcons[category.category]"></i>
                            <div class="ps-3">
                                <h6 class="mt-n1 mb-0">{{ category.category }}</h6>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div v-for="(category, index) in categories" :key="index" :id="`tab-${index + 1}`" class="tab-pane fade" :class="{ 'show active': selectedCategory === category.category }">
                        <div class="row g-4">
                            <div v-for="(menuItem, index) in filteredMenuItems" :key="index" class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <img class="flex-shrink-0 img-fluid rounded" :src="menuItem.image" alt="Menu item image" style="width: 80px;">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>{{ menuItem.name }}</span>
                                            <span class="text-primary">{{ menuItem.price }}</span>
                                        </h5>
                                        <small class="fst-italic">{{ menuItem.description }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const menuItems = ref([]);
const categories = ref([]);
const selectedCategory = ref('');

const getMenu = async () => {
    try {
        const response = await axios.get('menu/getData');
        menuItems.value = response.data;
    } catch (error) {
        console.error('Error:', error);
    }
}

const getCategories = async () => {
    try {
        const response = await axios.get('menu/getCategories');
        categories.value = response.data;
    } catch (error) {
        console.error('Error:', error);
    }
}

onMounted(() => {
    getMenu();
    getCategories();
});

const filteredMenuItems = computed(() => {
    if (!selectedCategory.value) {
        return menuItems.value;
    } else {
        return menuItems.value.filter(item => item.category === selectedCategory.value);
    }
});

// Mapping of category names to icon classes
const categoryIcons = {
    'Drinks': 'fa-coffee',
    'Family meals': 'fa-utensils',
    'Solo meals': 'fa-hamburger',
    'Desserts': 'fa-ice-cream',
    // Add more categories and corresponding icon classes as needed
};
</script>

<style scoped>
.nav-link {
    border-radius: 10px !important;
    width: 300px;
    cursor: pointer;
}

.nav-link:hover {
    background-color: #f8f9fa;
}

.nav-link.active {
    background-color: #FEA116;
}
</style>
