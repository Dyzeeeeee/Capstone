<template>
    <!-- <div>
        <li>
            Update data dialog should be able to preview and upload new image
        </li>
        <li>
            Filter dialog still does not work
        </li>
        <li>
            Category should be a dropdown, not type. <br>
            -Also, there should be an add categ if it exists not  
        </li>
        <li>
            Mas magandang delete warning
        </li>
        <li>
            Breadcrumb might be changed for the better hahahhaha
        </li>
        <li>
            Dialog form validations
        </li>
    </div> -->
    <div class="q-pa-md">


        <div class="row items-center q-mb-md" style="display: flex; align-items: center;">
            <!--Breacrumb Title-->
            <div class="col-4 q-pl-lg">
                <q-breadcrumbs class="text-green-9">
                    <template v-slot:separator>
                        <q-icon size="1.5em" name="chevron_right" color="black" />
                    </template>
                    <q-breadcrumbs-el label="Restaurant" icon="home" class="text-black" />
                    <q-breadcrumbs-el label="Menu" icon="menu_book" />
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
                <div class="col-auto ">
                    <q-btn @click="openAddDialog" flat color="primary" icon="add" label="Add" no-caps />
                </div>

                <div class="col-auto ">
                    <q-btn @click="switchToGridView" flat color="secondary" icon="apps"
                        :class="{ 'selected': selectedView === 'grid' }" />
                    <q-btn @click="switchToListView" flat color="secondary" icon="view_list"
                        :class="{ 'selected': selectedView === 'list' }" />
                </div>


            </div>
            <!-- Actions-->
        </div>

        <!-- Table-->
        <div class="row justify-center q-mt-md ">
            <q-pagination v-model="pagination.page" color="grey-8" :max="gridPagesNumber" size="sm"
                @input="onPaginationChange" class="q-pb-lg" />
        </div>
        <div v-if="selectedView === 'list'">
            <q-table flat bordered :rows="tableData" :columns="columns" row-key="name" v-model:pagination="pagination"
                hide-pagination class="my-sticky-header-table">
                <template #body-cell-actions="props">
                    <q-td :props="props">
                        <q-btn @click="onEditClick(props.row.name)" flat round icon="edit_note" color="secondary" />
                        <q-btn @click="onDeleteClick(props.row.name, props.row.id)" flat round icon="delete"
                            color="negative" />
                    </q-td>
                </template>

                <!-- Custom slot for rendering the image in the 'image' column -->
                <template #body-cell-image="props">
                    <q-td :props="props">
                        <img :src="props.row.image" alt="Menu Image" style="max-width: 100px; height: 70px; " />
                    </q-td>
                </template>
            </q-table>
        </div>
        <!--Grid-->
        <div v-else-if="selectedView === 'grid'" class="row scrollable q-gutter-sm justify-center items-start">

            <q-card flat bordered v-for="item in paginatedGridData" :key="item.id" class="my-card items-start">

                <q-img :src="item.image" height="100px" />
                <q-btn :ripple="false" fab-mini dense flat color="" icon="info" class="absolute"
                    style="top: 0px; left: 0px;" />
                <q-card-section>

                    <div class="row items-center">
                        <div class="col-12 text-subtitle1 text-bold">
                            {{ item.name }}
                        </div>
                        <div class="text-subtitle1 col-12">
                            {{ item.price }}
                        </div>
                        <div class="text-caption text-grey ellipsis">
                            {{ item.description }}
                        </div>
                    </div>

                </q-card-section>
                <q-card-actions align="right">
                    <q-btn @click="onEditClick(item.name)" flat round icon="edit_note" color="secondary" />
                    <q-btn @click="onDeleteClick(item.name, item.id)" flat round icon="delete" color="negative" />
                </q-card-actions>
            </q-card>
        </div>


    </div>

    <!-- Add Dialog-->
    <q-dialog v-model="showAddDialog">
        <q-card class="my-card" style="width: 400px;">
            <q-card-section>
                <div class="text-h6 text-bold">Add Menu</div>
            </q-card-section>

            <q-separator />
            <q-card-section class="q-pt-md ">
                <div class="q-gutter-md">
                    <q-input dense v-model="data.name" label="Name" required />
                    <q-input dense v-model="data.description" label="Description" required />
                    <q-input dense v-model="data.price" label="Price" required />
                    <q-input dense v-model="data.category" label="Category" required />

                    <label for="imageInput" class="custom-file-label">{{ selectedFile ? selectedFile.name : 'Add Image'
                    }}</label>
                    <input type="file" id="imageInput" @change="handleFileChange" style="display: none; width: 400px;" />
                    <div v-if="selectedFile" class="row justify-center">
                        <img :src="imagePreview" alt="Selected Image" style="max-width: 200px" />
                    </div>
                </div>
                <q-separator />
                <q-card-actions align="right">
                    <q-btn outline @click="closeDialog" color="negative" label="Cancel" no-caps style="width: 85px;" />
                    <q-btn outline @click="addData" color="green" label="Confirm" no-caps style="width: 85px;" />
                </q-card-actions>
            </q-card-section>
        </q-card>
    </q-dialog>
    <!-- Add Dialog-->
    <!-- Filter Dialog-->
    <q-dialog v-model="showFilterDialog">
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6 text-bold">Select Filters</div>
            </q-card-section>

            <q-separator />
            <q-card-section class="q-pt-md ">
                <q-form @submit="FilterMenu">
                    <div class="q-gutter-md">
                        <div class="row justify-between">
                            <div class="col-5 ">
                                <q-input dense outlined v-model="minPrice" label="Min Price" type="number" required />
                            </div>
                            <div class="col-2 text-center self-center">
                                --
                            </div>
                            <div class="col-5 ">
                                <q-input dense outlined v-model="maxPrice" label="Max Price" type="number" required />
                            </div>
                        </div>
                        <q-input dense v-model="newCategory" label="Category" required />
                    </div>
                    <q-separator />
                    <q-card-actions align="right">
                        <q-btn outline @click="closeDialog" color="negative" label="Cancel" no-caps style="width: 85px;" />
                        <q-btn outline type="submit" color="green" label="Confirm" no-caps style="width: 85px;" />
                    </q-card-actions>
                </q-form>
            </q-card-section>
        </q-card>
    </q-dialog>
    <!-- Dialog-->
    <!-- Edit Dialog -->
    <q-dialog v-model="showEditDialog">
        <q-card class="my-card" style="width: 400px;">
            <q-card-section>
                <div class="text-h6 text-bold">Edit Menu</div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-md ">
                <div class="q-gutter-md">
                    <!-- Similar input fields as the Add Dialog -->
                    <q-input dense v-model="data.name" label="Name" required />
                    <q-input dense v-model="data.description" label="Description" required />
                    <q-input dense v-model="data.price" label="Price" required />
                    <q-input dense v-model="data.category" label="Category" required />

                    <!-- Add an input field to display the current image -->
                    <!-- Add an input field to display the current image -->
                    <label for="imageInput" class="custom-file-label">{{ data.image ? data.image : 'Add Image' }}</label>
                    <input type="file" id="imageInput" @change="editHandleFileChange"
                        style="display: none; width: 400px;" />
                    <div v-if="data.image" class="row justify-center">
                        <img :src="data.image" alt="Current Image" style="max-width: 200px" />
                    </div>


                </div>
                <q-separator />
                <q-card-actions align="right">
                    <q-btn outline @click="closeDialog" color="negative" label="Cancel" no-caps style="width: 85px;" />
                    <q-btn outline @click="updateData" color="green" label="Update" no-caps style="width: 85px;" />
                </q-card-actions>
            </q-card-section>
        </q-card>
    </q-dialog>
    <!-- Edit Dialog -->
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import axios from 'axios';

const gridPagesNumber = computed(() => {
    return Math.ceil(tableData.value.length / pagination.value.rowsPerPage);
});

const selectedView = ref('list'); // Default to grid view

const switchToGridView = () => {
    selectedView.value = 'grid';
};

const switchToListView = () => {
    selectedView.value = 'list';
};

const paginatedGridData = computed(() => {
    const startIndex = (pagination.value.page - 1) * pagination.value.rowsPerPage;
    const endIndex = startIndex + pagination.value.rowsPerPage;
    return tableData.value.slice(startIndex, endIndex);
});




const showAddDialog = ref(false);
const showFilterDialog = ref(false);
const selectedFile = ref(null);
const imagePreview = ref(null);
const imageUrls = ref([]);


const data = ref({
    name: '',
    description: '',
    price: '',
    category: '',
    image: '',
});


const clearSearch = () => {
    filter.value = '';
};

const handleFileChange = (event) => {
    console.log("selected:", selectedFile.value);
    selectedFile.value = event.target.files[0];
    previewImage();
};

const editHandleFileChange = (event) => {
    const selectedFile = event.target.files[0];

    if (selectedFile) {
        // Get only the name of the file
        const fileName = selectedFile.name;

        // Update the 'image' field in the data object with just the filename
        data.value.image = fileName;

        // Update imagePreview
        previewImage();
    }
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

const openAddDialog = () => {
    data.value = {
        name: '',
        description: '',
        price: '',
        category: '',
        image: '',

    };
    showAddDialog.value = true;
};

const openFilterDialog = () => {
    showFilterDialog.value = true;
};

const closeDialog = () => {
    showAddDialog.value = false;
    showFilterDialog.value = false;
    showEditDialog.value = false;
};


const pagination = ref({
    sortBy: 'name',
    descending: false,
    page: 1,
    rowsPerPage: 15
});


const filter = ref('');
const tableData = ref([]);

const pagesNumber = computed(() => {
    return Math.ceil(tableData.value.length / pagination.value.rowsPerPage);
});


const getData = async () => {
    try {
        const response = await axios.get('menu/getData');
        tableData.value = response.data.filter(row => row.name.toLowerCase().includes(filter.value.toLowerCase()));
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

const addData = async () => {
    try {
        // Send a POST request to add data
        const formData = new FormData();
        formData.append('image', selectedFile.value);

        // Replace '/upload' with the actual URL of your CodeIgniter API endpoint
        const uploadResponse = await axios.post('menu/uploadImage', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        // Assuming the filename is returned in the 'message' field
        const filename = uploadResponse.data.filename;
        console.log('Image Filename:', filename);

        // Update the 'image' field in the data object with just the filename
        data.value.image = filename;

        // Send the modified data object to the API
        await axios.post('menu/addData', data.value);

        // Fetch the updated data after adding
        const response = await axios.get('menu/getData');

        // Update the table data
        tableData.value = response.data;

        // Close the dialog
        showAddDialog.value = false;

        closeDialog();
    } catch (error) {
        console.error('Error adding menu:', error);

        // Log the specific error message
        if (error.response) {
            console.error('Response error:', error.response.data);
        } else if (error.request) {
            console.error('Request error:', error.request);
        } else {
            console.error('General error:', error.message);
        }
    }
};

const updateData = async () => {
    try {
        // Check if there's a new image to upload
        if (selectedFile.value) {
            // Upload the new image
            const formData = new FormData();
            formData.append('image', selectedFile.value);

            // Replace '/uploadImage' with the actual URL of your CodeIgniter image upload endpoint
            const uploadResponse = await axios.post('menu/uploadImage', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });

            // Assuming the filename is returned in the 'message' field
            const filename = uploadResponse.data.filename;
            console.log('Image Filename:', filename);

            // Update the 'image' field in the data object with the new filename
            data.value.image = filename;
        }

        // Send a PUT request to update data
        await axios.put(`menu/updateData/${data.value.id}`, data.value);

        // Fetch the updated data after updating
        const response = await axios.get('menu/getData');

        // Update the table data
        tableData.value = response.data;

        // Close the edit modal
        showEditDialog.value = false;

        // Close the dialog
        closeDialog();
    } catch (error) {
        console.error('Error updating menu:', error);
        // Handle errors as needed
    }
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

const onPaginationChange = () => {
    getData();
};

const onFilterChange = () => {
    pagination.value.page = 1;
    getData();
};

const onFilterClick = () => {
    onFilterChange();
};



watch(filter, onFilterChange);

onMounted(() => {
    getData();
    fetchAllImages();

});

const columns = [
    {
        name: 'image',
        label: 'Image', // Adjust label based on your model field
        field: 'image',
        align: 'center',
    },
    {
        name: 'name',
        required: true,
        label: 'Name', // Adjust label based on your model field
        align: 'left',
        field: row => row.name,
        format: val => `${val}`,
        sortable: true
    },
    {
        name: 'price',
        label: 'Price', // Adjust label based on your model field
        field: 'price',
        sortable: true
    },
    {
        name: 'category',
        label: 'Category', // Adjust label based on your model field
        field: 'category',
        sortable: true
    },
    {
        name: 'description',
        label: 'Description', // Adjust label based on your model field
        field: 'description',
        sortable: true
    },
    // Add other fields as needed
    {
        name: 'actions',
        label: 'Actions',
        field: 'actions',
        align: 'center',
        sortable: false,
        // Custom slot for rendering buttons
        bodySlot: 'actions',
    },
];


const openEditDialog = (name, id) => {
    // Find the item in the tableData array based on the provided name
    const selectedItem = tableData.value.find(item => item.name === name);

    // Populate the editData object with the selected item's data
    data.value = {
        id: selectedItem.id,
        name: selectedItem.name,
        description: selectedItem.description,
        price: selectedItem.price,
        category: selectedItem.category,
        image: selectedItem.image,
    };

    // Open the edit modal
    showEditDialog.value = true;
};

const showEditDialog = ref(false);

const onEditClick = (name) => {
    openEditDialog(name);
};

const onDeleteClick = async (name, id) => {
    try {
        const confirmDelete = confirm(`Are you sure you want to delete ${name}?`);
        if (!confirmDelete) return;

        // Make an API call to delete the record
        await axios.delete(`menu/deleteData/${id}`);

        // Fetch the updated data after deletion
        const response = await axios.get('menu/getData');

        // Update the table data
        tableData.value = response.data;

        console.log(`Deleted item: ${name}`);
    } catch (error) {
        console.error('Error deleting menu:', error);
    }
};

</script>


<style>
.my-sticky-header-table {
    height: 75vh;
}

.my-sticky-header-table .q-table__top,
.my-sticky-header-table .q-table__bottom,
.my-sticky-header-table thead tr:first-child th {
    background-color: #75a4b9;
    color: white;
    /* Set header text color to white */
    font-weight: bold;
    /* Set header text to bold */
}

.my-sticky-header-table thead tr th {
    position: sticky;
    z-index: 1;
}

.my-sticky-header-table thead tr:first-child th {
    top: 0;
}

.my-sticky-header-table.q-table--loading thead tr:last-child th {
    top: 48px;
}

.my-sticky-header-table tbody {
    scroll-margin-top: 48px;
}

.custom-file-label {
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
    color: white;
    background-color: #75a4b9;
    text-align: center;
}

my-list-view .q-table__row {
    display: block;
    margin-bottom: 16px;
}

/* .my-grid-view .q-table__row {
        display: flex;
        margin-bottom: 0;
    } */

.my-card {
    max-height: 300px;
    width: 100%;
    max-width: 250px;
    /* Set the maximum width of your cards */
}

.scrollable {
    overflow: auto;
    height: 75vh;
}

.selected {
    background-color: #75a4b9;
    /* Add your selected background color */
    color: white !important;
    /* Add your selected text color */
}
</style>
