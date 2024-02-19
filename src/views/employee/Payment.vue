<template>
    <div class="q-pa-md row">
        <div class="row col-12  q-pl-lg">
            <q-breadcrumbs class="text-green-9">
                <template v-slot:separator>
                    <q-icon size="1.5em" name="chevron_right" color="black" />
                </template>
                <q-breadcrumbs-el label="Restaurant" icon="home" class="text-black" />
                <q-breadcrumbs-el label="Payment" icon="account_balance_wallet" />
            </q-breadcrumbs>
        </div>
        <div class="row justify-around col-12 q-mt-lg" style="height: 79vh;">

            <div class="col-2 method-list">
                <div class="row text-h6 text-bold">
                    <div class="col-auto q-pa-sm text-center">
                        Payment Method
                    </div>
                    <div class="col-12 q-pt-md text-subtitle1">
                        <q-list bordered separator>
                            <q-item clickable v-ripple>
                                <q-item-section avatar top>
                                    <q-avatar icon="payment" color="primary" text-color="white" />
                                </q-item-section>

                                <q-item-section>
                                    <q-item-label>Cash</q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item clickable v-ripple>
                                <q-item-section avatar top>
                                    <q-avatar icon="monetization_on" color="primary" text-color="white" />
                                </q-item-section>

                                <q-item-section>
                                    <q-item-label>GCash</q-item-label>
                                </q-item-section>
                            </q-item>
                            <q-item clickable v-ripple>
                                <q-item-section avatar top>
                                    <q-avatar icon="account_balance" color="primary" text-color="white" />
                                </q-item-section>

                                <q-item-section>
                                    <q-item-label>Bank</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>

                </div>
                <div class="method-body" style="flex: 1; overflow-y: auto;">
                </div>
            </div>


            <div class=" col-5   method-list ">
                <div class="row text-h6 text-bold">
                    <div class="col-12 bg-white q-pa-sm q-mb-lg" style="height: 25vh;">
                        Total Due: 
                    </div>
                    <div class="col-12 bg-white" style="height: 54vh">
                        
                    </div>
                </div>
                <div class="method-body" style="flex: 1; overflow-y: auto;">
                </div>
            </div>

            <div class="bg-white col-4  method-list">
                <div class="row q-pa-sm text-h6 text-bold">
                    <div class="col-auto">
                        Order ID:
                    </div>
                </div>
                <q-separator></q-separator>

                <div class="method-body" style="flex: 1; overflow-y: auto;">
                </div>
            </div>

        </div>

    </div>
</template>

<script setup>

</script >