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
                            label="Print Receipt">

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
                <div class="bg-white q-ma-sm receipt" style="height: 74vh">
                    <div class="text-bold q-pt-md q-px-md row q-pb-sm  text-h6 justify-center">
                        Anahaw
                    </div>
                    <div class=" q-px-md row  text-caption justify-center text-center">
                        Anahaw Address, Calapan, Oriental Mindoro <br>
                        (+63)900-000-0000 <br>
                        AnahawEmail@email.com <br>
                    </div>
                    <q-separator></q-separator>
                    <div class=" q-px-md row  text-caption justify-center text-center">
                        Served by: Cashier Name
                    </div>
                    <!--Loop ReceiptItems from here-->
                    <div v-for="(item) in ReceiptItems" :key="index">
                        <div class="text-bold q-pt-md q-px-md row text-subtitle2">
                            {{ item.menu_item }} <!-- Assuming you want to display the index of the item -->
                            <q-space></q-space>
                            {{ item.subtotal }}
                        </div>
                        <div class="text-italic q-px-md text-caption">
                            {{ item.quantity }} x {{ item.menu_item.price }}
                        </div>
                    </div>
                    <!--Loop ReceiptItems to here-->


                    <div class="text-bold row  text-subtitle1">
                        <div class="justify-center q-pa-md col-4 "></div>
                        <div class="justify-center q-pa-md col-4 ">TOTAL: </div>
                        <div class="justify-end text-right q-pa-md col-4">Php {{ OrderData.total_order_price }} </div>
                    </div>
                    <div class="text-bold q-px-md row  text-subtitle2">
                        Payment Method <q-space></q-space>Tendered
                    </div>
                    <div class="text-bold row  text-subtitle1 ">
                        <div class="justify-center q-pa-md col-4 "></div>
                        <div class="justify-center q-pa-md col-4 ">CHANGE: </div>
                        <div class="text-right q-pa-md col-4">Php {{ OrderData.change1 }} </div>
                    </div>
                    <div class="text-bold q-px-md row  text-subtitle2">
                        VAT <q-space></q-space>Vat %
                    </div>
                    <div class="justify-center row">
                        QR siguro
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
const route = useRoute();
const router = useRouter();

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
</script>
