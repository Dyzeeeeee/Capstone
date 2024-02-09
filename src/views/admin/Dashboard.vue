<template>
  <div>
    <label for="imageInput" class="custom-file-label">{{ selectedFile ? selectedFile.name : 'Choose Image' }}</label>
    <input type="file" id="imageInput" @change="handleFileChange" style="display: none" />

    <div v-if="selectedFile">
      <img :src="imagePreview" alt="Selected Image" style="max-width: 100%" />
    </div>
    <button @click="uploadImage" :disabled="!selectedFile">Upload Image</button>

    <div v-if="imageUrls.length > 0">
      <h2>All Images:</h2>
      <div v-for="imageUrl in imageUrls" :key="imageUrl.url">
        <img :src="imageUrl.url" alt="Image" style="max-width: 100%" />
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const selectedFile = ref(null);
const imagePreview = ref(null);
const imageUrls = ref([]);

const handleFileChange = (event) => {
  selectedFile.value = event.target.files[0];
  previewImage();
};

const previewImage = () => {
  if (selectedFile.value) {
    const reader = new FileReader();
    reader.onload = () => {
      imagePreview.value = reader.result;
    };
    reader.readAsDataURL(selectedFile.value);
  }
};

const uploadImage = () => {
  const formData = new FormData();
  formData.append('image', selectedFile.value);

  // Replace '/upload' with the actual URL of your CodeIgniter API endpoint
  axios.post('/upload', formData, {
    headers: {
      'Content-Type': 'multipart/form-data',
    },
  })
    .then(response => {
      console.log(response.data);

      // If you want to handle the URL in your Vue.js component, you can access it here
      const imageUrl = response.data.message; // Assuming the URL is returned in the 'message' field
      console.log('Image URL:', imageUrl);

      // Fetch all images after a successful upload
      fetchAllImages();
    })
    .catch(error => {
      console.error(error);
    });
};

const fetchAllImages = () => {
  // Replace '/fetchAllImages' with the actual URL of your endpoint to fetch all images from the database
  axios.get('/fetchAllImages')
    .then(response => {
      console.log(response.data);

      // Assuming the URLs of all images are returned in the 'imageUrls' field
      imageUrls.value = response.data.imageUrls || [];
    })
    .catch(error => {
      console.error(error);
    });
};

// Fetch all images when the component is mounted
onMounted(() => {
  fetchAllImages();
});
</script>

<style scoped>
.custom-file-label {
  display: inline-block;
  padding: 6px 12px;
  cursor: pointer;
  border: 1px solid;
  border-radius: 4px;
  background-color: #fff;
}
</style>
