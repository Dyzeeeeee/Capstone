<template>
    <div class="q-pa-md">
        <div class="row items-center q-mb-md" style="display: flex; align-items: center;">

            <div class="col-4 q-pl-lg">
                <q-breadcrumbs class="text-green-9">
                    <template v-slot:separator>
                        <q-icon size="1.5em" name="chevron_right" color="black" />
                    </template>
                    <q-breadcrumbs-el label="Restaurant" icon="home" class="text-black" />
                    <q-breadcrumbs-el label="Menu" icon="menu_book" />
                </q-breadcrumbs>
            </div>

            <div class="col-8 row justify-end ">
                <div class="col-auto ">
                    <q-btn @click="onFilterClick" flat color="primary" icon="filter_alt" />
                </div>
                <div class="col-5 ">
                    <q-input borderless dense debounce="300" v-model="filter" placeholder="Search name">
                        <template v-slot:append>
                            <q-icon name="search" />
                        </template>
                    </q-input>
                </div>
                <div class="col-auto ">
                    <q-btn @click="openAddDialog" flat color="primary" icon="add" label="Add" no-caps />
                </div>
                <div class="col-auto ">
                    <q-btn flat color="secondary" icon="apps" />
                    <q-btn flat color="secondary" icon="view_list" />
                </div>
            </div>

        </div>

        <q-table flat bordered :rows="filteredRows" :columns="columns" row-key="name" v-model:pagination="pagination"
            hide-pagination>
            <template #body-cell-actions="props">
                <q-td :props="props">
                    <q-btn @click="onEditClick(props.row.name)" flat round icon="edit_note" color="secondary" />
                    <q-btn @click="onDeleteClick(props.row.name)" flat round icon="delete" color="negative" />
                </q-td>
            </template>
        </q-table>

        <div class="row justify-center q-mt-md">
            <q-pagination v-model="pagination.page" color="grey-8" :max="pagesNumber" size="sm"
                @input="onPaginationChange" />
        </div>
    </div>


    <q-dialog v-model="showAddDialog">
        <q-card class="my-card">
            <q-card-section>
                <div class="text-h6 text-bold">Add Menu</div>
            </q-card-section>

            <q-separator />
            <q-card-section class="q-pt-md ">
                <q-form @submit="addMenu">
                    <div class="q-gutter-md">
                        <q-input dense v-model="newName" label="Name" required />
                        <q-input dense v-model="newDescription" label="Description" required />
                        <q-input dense v-model="newPrice" label="Price" required />
                        <q-input dense v-model="newCategory" label="Category" required />

                        <!-- Use q-uploader for image input -->
                        <q-uploader v-model="newImage" label="Image" color="secondary" accept="image/*" @added="onFileAdded"   max-files="1"
                            @failed="onFileFailed" class="q-mt-md" />
                    </div>
                    <q-separator />
                    <q-card-actions align="right">
                        <q-btn outline @click="closeAddDialog" color="negative" label="Cancel" no-caps style="width: 85px;"/>
                        <q-btn outline type="submit" color="green" label="Confirm" no-caps style="width: 85px;" />
                    </q-card-actions>
                </q-form>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import axios from 'axios';

const showAddDialog = ref(false);
const newItemName = ref('');
const newItemDescription = ref('');
const newItemPrice = ref('');
const newItemCategory = ref('');
const openAddDialog = () => {
    showAddDialog.value = true;
};

const closeAddDialog = () => {
    // Clear the form fields when closing the dialog
    newItemName.value = '';
    newItemDescription.value = '';
    newItemPrice.value = '';
    newItemCategory.value = '';

    showAddDialog.value = false;
};

const addNewItem = () => {
    // Implement logic to add the new item to the data source
    // You can use newItemName, newItemDescription, newItemPrice, newItemCategory, etc.
    console.log('Adding new item:', {
        name: newItemName.value,
        description: newItemDescription.value,
        price: newItemPrice.value,
        category: newItemCategory.value,
    });

    // Close the dialog
    closeAddDialog();
};


const pagination = ref({
    sortBy: 'name',
    descending: false,
    page: 1,
    rowsPerPage: 10
});

const filter = ref('');
const filteredRows = ref([]);

const pagesNumber = computed(() => {
    return Math.ceil(filteredRows.value.length / pagination.value.rowsPerPage);
});

const fetchRows = async () => {
    try {
        const response = await axios.get('menu/getData');
        filteredRows.value = response.data.filter(row => row.name.toLowerCase().includes(filter.value.toLowerCase()));
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

const onPaginationChange = () => {
    fetchRows();
};

const onFilterChange = () => {
    pagination.value.page = 1;
    fetchRows();
};

const onFilterClick = () => {
    onFilterChange();
};

const onAddClick = () => {
    // Implement logic to show a form or navigate to the add page
    console.log('Add button clicked!');
};

watch(filter, onFilterChange);

onMounted(() => {
    fetchRows();
});

const columns = [
    {
        name: 'image',
        label: 'Image', // Adjust label based on your model field
        field: 'image',
        align: 'center',
        sortable: true
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
        name: 'description',
        label: 'Description', // Adjust label based on your model field
        field: 'description',
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

const onEditClick = (name) => {
    // Implement logic for editing the item
    console.log(`Edit button clicked for item: ${name}`);
};

const onDeleteClick = (name) => {
    // Implement logic for deleting the item
    console.log(`Delete button clicked for item: ${name}`);
};

</script>
