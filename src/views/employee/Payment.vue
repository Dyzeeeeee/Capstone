<template>
    <div class="q-pa-md row  ">
        <div class="row q-pl-lg ">
            <q-breadcrumbs class="text-green-9">
                <template v-slot:separator>
                    <q-icon size="1.5em" name="chevron_right" color="black" />
                </template>
                <q-breadcrumbs-el label="Restaurant" icon="home" class="text-black" />
                <q-breadcrumbs-el label="Payment" icon="account_balance_wallet" />
            </q-breadcrumbs>
        </div>

        <div class="col-12 row q-gutter-sm q-mt-md justify-center" style="height: 79vh;">
            <div class="bg-white receipt-container col-4" style="display: flex; flex-direction: column;">
                <div class="q-pa-sm text-h6  receipt-header">
                    <b>Order No:&nbsp</b> {{ orderId }}
                </div>
                <div class="receipt-body" style="flex: 1; overflow-y: auto;">
                    <q-table :rows="ReceiptItems" :columns="receiptColumns" row-key="id" hide-bottom
                        :pagination.sync="pagination" class="receipt-table" flat bordered="">
                        <template #body-cell-quantity="props">
                            <q-td :props="props">{{ props.row.quantity }}</q-td>
                        </template>
                        <template #body-cell-menu_item="props">
                            <q-td :props="props">{{ props.row.menu_item }}</q-td>
                        </template>
                        <template #body-cell-subtotal="props">
                            <q-td :props="props">{{ props.row.subtotal }}</q-td>
                        </template>
                        <template #body-cell-action="props">
                            <q-td :props="props">
                                <q-btn flat round icon="remove_circle_outline" color="secondary"
                                    @click="reduceOrder(props.row)" />
                                <q-btn flat round icon="cancel" color="negative" @click="removeOrder(props.row)" />
                            </q-td>
                        </template>
                    </q-table>
                </div>
                <q-separator />
                <div class=" q-pa-sm text-subtitle1 justify-end row ">
                    <b> Total: &nbsp</b>Php {{ totalOrderPrice }}
                </div>
                <q-separator />
                <div class=" q-px-sm text-subtitle1">
                    <b>Note:&nbsp</b> Sample Note
                </div>
                <div class="text-subtitle1  q-px-sm">
                    <b>Cashier:w</b> John Doe
                </div>
                <div class="q-px-sm text-subtitle1">
                    <b>Customer:&nbsp</b> Jane Doe
                </div>
            </div>
            <div class=" col-7">
                <div class="row text-h6">
                    <div class="col-12 bg-white q-pa-sm q-mb-sm" style="height: 25vh;">
                        <div class="">
                            <b>Total Price:&nbsp</b><span> Php {{ totalOrderPrice }}</span> <br>
                        </div>
                        <div>
                            <b>Tendered:&nbsp</b><span> Php {{ tendered }}.00</span>

                        </div>
                        <div class="row justify-end self-center">
                            <br>{{ totalDue <= 0 ? 'Change:' : 'Total Due:' }} &nbsp<span
                                :class="{ 'text-red': totalDue > 0, 'text-green': totalDue <= 0 }">
                                <br> Php {{ Math.abs(totalDue) }}.00
                                </span>
                        </div>
                    </div>

                    <div class="col-12 row" style="height: 54vh">

                        <div class="col-8  bg-white buttons">
                            <div class="row text-center q-mt-sm ">
                                <div class="col-3 ">
                                    <q-btn :class="{ 'bg-green-3': isPositive, 'bg-red-7': !isPositive }"
                                        style="height: 67px; width: 96%;" outline @click="() => plusValue(1)"><span
                                            :class="{ '': isPositive, 'text-white': !isPositive }">1</span></q-btn>
                                </div>
                                <div class="col-3">
                                    <q-btn :class="{ 'bg-green-3': isPositive, 'bg-red-7': !isPositive }"
                                        style="height: 67px; width: 96%;" outline @click="() => plusValue(10)"><span
                                            :class="{ '': isPositive, 'text-white': !isPositive }">10</span></q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn :class="{ 'bg-green-3': isPositive, 'bg-red-7': !isPositive }"
                                        style="height: 67px; width: 96%;" outline @click="() => plusValue(20)"><span
                                            :class="{ '': isPositive, 'text-white': !isPositive }">20</span></q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn :class="{ 'bg-green-3': isPositive, 'bg-red-7': !isPositive }"
                                        style="height: 67px; width: 96%;" outline @click="() => plusValue(50)"><span
                                            :class="{ '': isPositive, 'text-white': !isPositive }">50</span></q-btn>
                                </div>
                            </div>
                            <div class="text-center q-mt-sm row">
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue(1)">1</q-btn>
                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('2')">2</q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('3')">3</q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn :class="{ 'bg-green-3': isPositive, 'bg-red-7': !isPositive }"
                                        style="height: 67px; width: 96%;" outline @click="() => plusValue(100)"><span
                                            :class="{ '': isPositive, 'text-white': !isPositive }">100</span></q-btn>
                                </div>
                            </div>
                            <div class="text-center q-mt-sm row">
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('4')">4</q-btn>
                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('5')">5</q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('6')">6</q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn :class="{ 'bg-green-3': isPositive, 'bg-red-7': !isPositive }"
                                        style="height: 67px; width: 96%;" outline @click="() => plusValue(500)"><span
                                            :class="{ '': isPositive, 'text-white': !isPositive }">500</span></q-btn>
                                </div>
                            </div>
                            <div class="text-center q-mt-sm row">
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('7')">7</q-btn>
                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('8')">8</q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('9')">9</q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn :class="{ 'bg-green-3': isPositive, 'bg-red-7': !isPositive }"
                                        style="height: 67px; width: 96%;" outline @click="() => plusValue(1000)"><span
                                            :class="{ '': isPositive, 'text-white': !isPositive }">1000</span></q-btn>

                                </div>
                            </div>
                            <div class="text-center q-mt-sm row">
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" class="bg-red-7" @click="() => addValue('C')"
                                        outline><span class="text-white">C</span></q-btn>
                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="() => addValue('0')">0</q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline @click="toggleSign"><b><q-icon
                                                name="iso"></q-icon></b></q-btn>

                                </div>
                                <div class="col-3">
                                    <q-btn style="height: 67px; width: 96%;" outline
                                        @click="() => addValue('backspace')"><q-icon name="backspace"></q-icon></q-btn>

                                </div>
                            </div>

                        </div>
                        <div class="col-4 justify-center items-center bg-white methods">
                            <div class="col-auto q-pa-sm text-center">
                                <q-btn class="q-mt-sm" color="primary" style="width: 100%; height: 60px;" outline no-caps
                                    icon="payments">Cash</q-btn>
                                <q-btn class="q-mt-sm" color="primary" style="width: 100%; height: 60px;" outline no-caps
                                    icon="payment">Gcash</q-btn>
                                <q-btn class="q-mt-sm" color="primary" style="width: 100%; height: 60px;" outline no-caps
                                    icon="account_balance">Bank</q-btn>
                            </div>

                            <div class="row col-12 ">
                                <div class="row col-12 justify-between">
                                    <div class="col-6">
                                        <q-btn color="primary" icon="chevron_left" label="Return" no-caps
                                            class="q-mx-sm text-center" @click="goBack" />
                                    </div>

                                    <div class="col-6 ">
                                        <q-btn color="green" icon="chevron_right" no-caps label="Validate" class="q-mx-sm"
                                            @click="goToValidated" />
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
import { useRoute, useRouter } from 'vue-router';
const router = useRouter();

const route = useRoute();
const ReceiptItems = ref([]);
const tendered = ref(0);
const totalDue = computed(() => totalOrderPrice.value - tendered.value);
const isPositive = ref(true);

// Add a method to toggle the sign
const toggleSign = () => {
    isPositive.value = !isPositive.value;
};
const plusValue = (amount) => {
    tendered.value += isPositive.value ? amount : -amount;
    if (tendered.value === '' || tendered.value < 0) {
        tendered.value = 0;
    }
};

const goToValidated = async () => {
    if (totalDue.value <= 0) {
        await addPayment(); // Call addPayment function to add payment information
        const validatedRoute = `/employee/validated/${orderId.value}`;
        router.push(validatedRoute);
    }
};

const addPayment = async () => {
    try {
        const paymentData = {
            tendered: tendered.value,
            change1: Math.abs(totalDue.value), // Use Math.abs to get the absolute value
            status: "Paid",
        };

        const response = await axios.put(`orders/addPayment/${orderId.value}`, paymentData);
        console.log(response.data); // Log the response for debugging or handling if necessary
    } catch (error) {
        console.error('Error adding payment:', error);
        // Handle error appropriately
    }
};



const addValue = async (value) => {
    console.log("value clicked: ", value)
    if (value === 'backspace') {
        // Ensure tendered.value is greater than 0 before removing the last character
        if (tendered.value > 0) {
            // Convert tendered.value to string and remove the last character
            tendered.value = tendered.value.toString().slice(0, -1);
            tendered.value = parseInt(`${tendered.value || 0}${value}`, 10);

            if (tendered.value === '' || tendered.value < 0) {
                tendered.value = 0;
            }
            console.log(tendered.value)

        }
    } else if (value === 'C') {
        // Handle the "C" button to clear the tendered value
        tendered.value = 0;
        console.log(tendered.value)
    } else {
        // Add the entered value to tendered.value
        tendered.value = parseInt(`${tendered.value || 0}${value}`, 10);

    }
};



const totalOrderPrice = ref(0);
const orderId = ref(route.params.id);
const goBack = () => {
    router.back();
};

const receiptColumns = [
    { name: 'quantity', label: 'Quantity', align: 'center', field: 'quantity', sortable: true },
    { name: 'menu_item', label: 'Name', align: 'center', field: 'menu_item', sortable: true },
    { name: 'subtotal', label: 'Subtotal', align: 'center', field: 'subtotal', sortable: true },
];


const getOrderData = async () => {
    try {
        const response = await axios.get(`orders/getOrderData/${orderId.value}`);
        const orderData = response.data.data; // Assuming the order data is in the 'data' key

        // Update totalOrderPrice with the received total_order_price
        totalOrderPrice.value = orderData.total_order_price;
    } catch (error) {
        console.error('Error fetching order data:', error);
    }
};

const getOrderItems = async () => {
    try {
        if (orderId.value) {
            const response = await axios.get(`orders/getOrderItems/${orderId.value}`);
            ReceiptItems.value = response.data;
        }
    } catch (error) {
        console.error('Error fetching order items:', error);
    }
};

onMounted(async () => {
    getOrderItems(); // Fetch order items
    getOrderData();

    // If tendered is null, set it to 0

});
</script>
