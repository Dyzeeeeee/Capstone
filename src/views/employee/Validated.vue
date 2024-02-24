<template>
    <div class="q-pa-md row q-gutter-sm ">
        <div class="row q-pl-lg col-12 ">
            <q-breadcrumbs class="text-green-9">
                <template v-slot:separator>
                    <q-icon size="1.5em" name="chevron_right" color="black" />
                </template>
                <q-breadcrumbs-el label="Restaurant" icon="home" class="text-black" />
                <q-breadcrumbs-el label="Validated" icon="check" />
            </q-breadcrumbs>
        </div>

        <div class="row justify-center col-12 text-h4 bg-white q-py-sm">
            Php {{ OrderData.total_order_price }}
        </div>
        <div class="row justify-center col-12">
            <div class="col-8">
                <div class="bg-white success q-pa-md"
                    style="height: 77vh; display: flex; flex-direction: column; justify-content: space-between;">
                    <div class="col-12 text-h4 q-mb-lg">
                        Payment Successful
                    </div>
                    <div class="col-12 q-mb-md  ">
                        <q-btn icon="print" color="secondary" style="width: 100%; height: 55px;" no-caps
                            label="Print Receipt" @click="printReceipt">
                        </q-btn>
                    </div>
                    <div class="col-12 q-mb-md">
                        <q-input label="Send Receipt via Email" outlined="" dense>
                            <template v-slot:after>
                                <q-btn icon="email" color="secondary" />
                            </template>
                        </q-input>
                    </div>
                    <div class="col-12">
                        <q-input label="Send Receipt via Messenger" outlined="" dense>
                            <template v-slot:after>
                                <q-btn icon="chat" color="secondary" />
                            </template>
                        </q-input>
                    </div>
                    <div class="" style="margin-top: auto;">
                        <q-btn color="green" style="width: 100%; height: 70px;" label="New Order" icon="grading" no-caps
                            @click="newOrder">

                        </q-btn>
                    </div>
                </div>


            </div>
            <div class="col-4 ">
                <div style="background-color: white; margin: 8px; padding: 1rem; height: 74vh;" id="receipt"
                    ref="receiptDiv">
                    <div
                        style="font-weight: bold; padding-top: 1rem; padding-left: 1rem; font-size: 1.25rem; text-align: center;">
                        Anahaw
                    </div>
                    <div style="padding-left: 1rem; text-align: center; margin-bottom: 1rem;">
                        Anahaw Address, Calapan, Oriental Mindoro <br>
                        (+63)900-000-0000 <br>
                        AnahawEmail@email.com <br>
                    </div>
                    <hr style="margin: 0;">
                    <div style="padding-left: 1rem; text-align: center;">
                        Served by: Cashier Name
                    </div>
                    <!-- Loop ReceiptItems from here -->
                    <div v-for="(item) in ReceiptItems" :key="index">
                        <div style=" display: flex; justify-content: space-between;">
                            <div style="flex-basis: 50%; font-size: 1rem;font-weight: bold; text-align: left; ">
                                {{
                                    item.menu_item }}
                            </div>
                            <div style="flex-basis: 50%; text-align: right; font-size: 1rem; ">Php {{
                                item.subtotal }} </div>
                        </div>
                        <div style="font-style: italic;">
                            {{ item.quantity }} x
                        </div>

                    </div>
                    <!-- Loop ReceiptItems to here -->
                    <div style=" display: flex; justify-content: space-between;">
                        <div style="flex-basis: 50%; font-size: 1rem;font-weight: bold; text-align: right;">TOTAL:
                        </div>
                        <div style="flex-basis: 33.3333%; text-align: right; font-size: 1rem;">Php {{
                            OrderData.total_order_price }} </div>
                    </div>
                    <div style="font-weight: ; display: flex; justify-content: space-between;">
                        <div style="flex-basis: 50%; font-size: 1rem; font-weight: bold; text-align: right;">CASH:
                        </div>
                        <div style="flex-basis: 33.3333%; text-align: right; font-size: 1rem;">Php {{ OrderData.tendered }}
                        </div>
                    </div>
                    <div style=" display: flex; justify-content: space-between;">
                        <div style="flex-basis: 50%; font-size: 1rem; text-align: right; font-weight: bold;">CHANGE:
                        </div>
                        <div style="flex-basis: 33.3333%; text-align: right; font-size: 1rem;">Php {{ OrderData.change1 }}
                        </div>
                    </div>
                    <!-- <div style="font-weight: bold; padding-left: 1rem; font-size: 1rem;">
                        VAT <span style="margin-right: 0.5rem;"></span> Vat %
                    </div>
                    <div style="text-align: center; padding: 1rem; font-size: 1rem;">
                        QR siguro
                    </div> -->
                </div>



            </div>
        </div>



    </div>
</template>

<script setup>
import { ref, onMounted, computed, createApp } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';
const route = useRoute();
const router = useRouter();
const receiptDiv = ref(null);
const orderId = ref(route.params.id);

const newOrder = () => {
    router.go(-2); // Go back two steps in the route history
}
const ReceiptItems = ref([]);

const OrderData = ref([]);
const getOrderData = async () => {
    try {
        const response = await axios.get(`orders/getOrderData/${orderId.value}`);
        OrderData.value = response.data.data; // Assuming the order data is in the 'data' key

        // Update totalOrderPrice with the received total_order_price
    } catch (error) {
        console.error('Error fetching order data:', error);
    }
};

const getOrderItems = async () => {
    try {
        if (orderId.value) {
            const response = await axios.get(`orders/getOrderItems/${orderId.value}`);
            ReceiptItems.value = response.data;
            console.log("here:", ReceiptItems.value);
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

const printReceipt = () => {
    // Create a new window with a specific size
    const printWindow = window.open('', '_blank',);

    // Append only the receipt div to the new window
    printWindow.document.body.innerHTML = `<html><head><title>Receipt</title></head><body>${receiptDiv.value.innerHTML}</body></html>`;

    // Trigger the print process in the new window
    printWindow.print();
    printWindow.close();
}
</script>

