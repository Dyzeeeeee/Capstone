<template>
    <div class="q-pa-md">
        <div class="row items-center q-mb-md justify-end">
            <div class="col-auto">
                <q-btn @click="onFilterClick" flat color="primary" icon="filter_alt" />
            </div>
            <div class="col-4">
                <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
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

        <q-table flat bordered title="Stocks" :rows="filteredRows" :columns="columns" row-key="name"
            v-model:pagination="pagination" hide-pagination>
            <template #body-cell-actions="props">
                <q-td :props="props">
                    <q-btn @click="onEditClick(props.row.ingredient_name)" flat round icon="edit_note" color="secondary" />
                    <q-btn @click="onDeleteClick(props.row.ingredient_name)" flat round icon="delete" color="negative" />
                </q-td>
            </template>
            <template #body-cell-percentage="props">
                <q-td :props="props">
                    <q-linear-progress :value="calculatePercentage(props.row)"
                        :color="getPercentageColor(calculatePercentage(props.row))" />
                </q-td>
            </template>
        </q-table>

        <div class="row justify-center q-mt-md">
            <q-pagination v-model="pagination.page" color="grey-8" :max="pagesNumber" size="sm"
                @input="onPaginationChange" />
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import axios from 'axios';

const pagination = ref({
    sortBy: 'ingredient_name',
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
        const response = await axios.get('stocks/getData');
        filteredRows.value = response.data.filter(row => row.ingredient_name.toLowerCase().includes(filter.value.toLowerCase()));
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
    console.log('Add button clicked!');
};

watch(filter, onFilterChange);

onMounted(() => {
    fetchRows();
});

const calculatePercentage = (row) => {
    // Calculate the percentage based on quantity and ideal
    return (row.quantity / row.ideal);
};

const getPercentageColor = (percentage) => {
    if (percentage >= 0 && percentage <= .40) {
        return 'red';
    } else if (percentage > .40 && percentage <= .70) {
        return 'yellow';
    } else if (percentage > .70 && percentage <= 1.00) {
        return 'green';
    }
    return 'primary';
}

const columns = [
    {
        name: 'percentage',
        required: true,
        label: 'Percentage',
        align: 'left',
        sortable: true,
        field: (row) => calculatePercentage(row),
    },
    {
        name: 'ingredient_name',
        required: true,
        label: 'Ingredient Name',
        align: 'left',
        field: row => row.ingredient_name,
        format: val => `${val}`,
        sortable: true
    },
    {
        name: 'quantity',
        label: 'Quantity',
        field: 'quantity',
        sortable: true
    },
    {
        name: 'ideal',
        label: 'Ideal',
        field: 'ideal',
        sortable: true
    },
    {
        name: 'unit_of_measurement',
        label: 'Unit of Measurement',
        field: 'unit_of_measurement',
        sortable: true
    },
    {
        name: 'purchase_date',
        label: 'Purchase Date',
        field: 'purchase_date',
        sortable: true
    },
    {
        name: 'expiration_date',
        label: 'Expiration Date',
        field: 'expiration_date',
        sortable: true
    },
    {
        name: 'supplier_name',
        label: 'Supplier Name',
        field: 'supplier_name',
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

const onEditClick = (ingredientName) => {
    console.log(`Edit button clicked for ingredient: ${ingredientName}`);
};

const onDeleteClick = (ingredientName) => {
    console.log(`Delete button clicked for ingredient: ${ingredientName}`);
};

</script>
