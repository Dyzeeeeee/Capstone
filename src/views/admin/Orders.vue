<template>
    <div class="q-pa-md">
        <div class="row items-center q-mb-md justify-end">
            <div class="col-auto">
                <q-btn @click="onFilterClick" flat color="primary" icon="filter_alt" />
            </div>
            <div class="col-4">
                <q-input borderless dense debounce="300" v-model="filter" placeholder="Search Order ID">
                    <template v-slot:append>
                        <q-icon name="search" />
                    </template>
                </q-input>
            </div>
            <div class="col-auto">
                <q-btn @click="onAddClick" flat color="primary" icon="add" label="Add" no-caps />
            </div>
            <div class="col-auto">
                <q-btn flat color="secondary" icon="apps" />
                <q-btn flat color="secondary" icon="view_list" />
            </div>

        </div>

        <q-table flat bordered title="Orders" :rows="filteredRows" :columns="columns" row-key="id"
            v-model:pagination="pagination" hide-pagination>
            <template #body-cell-actions="props">
                <q-td :props="props">
                    <q-btn @click="onEditClick(props.row.customer_id)" flat round icon="info" color="grey-8" />
                    <q-btn flat round icon="print" color="primary" />
                    <q-btn flat round icon="download" color="secondary" />
                </q-td>
            </template>
        </q-table>

        <div class="row justify-center q-mt-md ">
            <q-pagination v-model="pagination.page" color="grey-8" :max="pagesNumber" size="sm"
                @input="onPaginationChange" />
        </div>

    </div>
</template>


<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import axios from 'axios';

const pagination = ref({
    sortBy: 'id',
    descending: false,
    page: 1,
    rowsPerPage: 8
});

const filter = ref('');
const filteredRows = ref([]);

const pagesNumber = computed(() => {
    return Math.ceil(filteredRows.value.length / pagination.value.rowsPerPage);
});


const fetchRows = async () => {
    try {
        const response = await axios.get('orders/getData');
        filteredRows.value = response.data.filter(row => row.id.toLowerCase().includes(filter.value.toLowerCase()));
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
        name: 'id',
        required: true,
        label: 'Order ID',
        align: 'left',
        field: row => row.id,
        format: val => `${val}`,
        sortable: true
    },
    {
        name: 'order_date',
        label: 'Order Date',
        field: 'order_date',
        sortable: true
    },
    {
        name: 'total_order_price',
        label: 'Total Order Price',
        field: 'total_order_price',
        sortable: true
    },
    {
        name: 'actions',
        label: 'Actions',
        field: 'actions',
        align: 'center',
        sortable: false,
        bodySlot: 'actions',
    },
];

const onEditClick = (customer_id) => {
    // Implement logic for editing the order
    console.log(`Edit button clicked for order with Customer ID: ${customer_id}`);
};

const onDeleteClick = (customer_id) => {
    // Implement logic for deleting the order
    console.log(`Delete button clicked for order with Customer ID: ${customer_id}`);
};
</script>