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
        <div class="row q-gutter-md justify-center col-12 q-mt-lg" style="height: 79vh;">

            <div class="col-2 method-list" style=" display: flex; flex-direction: column;">
                <div class="row text-h6 text-bold">
                    <div class="col-auto">
                        Payment Method
                    </div>
                </div>
                <div class="method-body" style="flex: 1; overflow-y: auto;">
                </div>
            </div>

            <div class=" col-5 method-list " style=" display: flex; flex-direction: column;">
                <div class="row    text-h6 text-white q-gutter-sm">
                    <div class="col-12 bg-white" style="height: 20vh;">
                        Total Due
                    </div>
                    <div class="col-12 bg-white" style="height: 54vh">
                        adsd
                    </div>
                </div>
                <div class="method-body" style="flex: 1; overflow-y: auto;">
                </div>
            </div>

            <div class="bg-white col-4  method-list" style=" display: flex; flex-direction: column;">
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