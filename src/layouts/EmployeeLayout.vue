<template>

        <q-layout view="hHh Lpr lff" container style="height: 100vh;" class="shadow-2 rounded-borders bg-blue-grey-2">
            <q-header elevated :class="$q.dark.isActive ? 'bg-secondary' : 'bg-blue-grey-9'">
                <q-toolbar>
                    <q-btn flat @click="drawer = !drawer" round dense icon="menu" />
                    <q-toolbar-title>Anahaw Island View Resort</q-toolbar-title>
                    <div class="q-gutter-lg">
                        <q-btn flat dense icon="search" />
                        <q-btn flat dense icon="chat_bubble" />
                        <q-btn flat dense icon="notifications" />
                        <q-btn flat dense icon="storefront" to="/website/home"  />
                        <q-btn flat dense icon="settings" />
                        <q-btn flat dense :icon="fullScreen ? 'fullscreen_exit' : 'fullscreen'" @click="toggleFullScreen" />
                    </div>

                </q-toolbar>
            </q-header>


            <q-drawer v-model="drawer" show-if-above :mini="!drawer || miniState" @click.capture="drawerClick" :width="250"
                :breakpoint="500" bordered :class="$q.dark.isActive ? 'bg-grey-9' : 'bg-grey-3'">
                <q-scroll-area class="fit" :horizontal-thumb-style="{ opacity: 0 }">
                    <q-list padding>
                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-avatar>
                                    <img src="https://cdn.quasar.dev/img/boy-avatar.png">
                                </q-avatar>
                            </q-item-section>
                            <q-item-section>
                                <div class="text-subtitle1 ">
                                    Jan Dyze Malaluan
                                </div>
                                <div class="text-caption ellipsis">
                                    Admin
                                </div>
                            </q-item-section>
                        </q-item>
                        <q-separator spaced />
                        <router-link to="/admin/dashboard" style="  text-decoration: none; color: inherit;">

                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="insert_chart_outlined" />
                                </q-item-section>
                                <q-item-section>
                                    Dashboard
                                </q-item-section>
                            </q-item>
                        </router-link>
                        <q-item-label header>Restaurant</q-item-label>
                        <router-link to="/admin/menu" style="  text-decoration: none; color: inherit;">
                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="menu_book" />
                                </q-item-section>
                                <q-item-section>
                                    Menu
                                </q-item-section>
                            </q-item>
                        </router-link>

                        <router-link to="/admin/recipe" style="  text-decoration: none; color: inherit;">
                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="lunch_dining" />
                                </q-item-section>
                                <q-item-section>
                                    Recipe
                                </q-item-section>
                            </q-item>
                        </router-link>

                        <q-item-label header>Inventory</q-item-label>
                        <router-link to="/admin/stocks" style="  text-decoration: none; color: inherit;">

                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="inventory" />
                                </q-item-section>

                                <q-item-section>
                                    Stocks
                                </q-item-section>
                            </q-item>
                        </router-link>

                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-icon name="store" />
                            </q-item-section>

                            <q-item-section>
                                Suppliers
                            </q-item-section>
                        </q-item>

                        <q-item-label header>Point of Sale</q-item-label>
                        <router-link to="/admin/counter" style="  text-decoration: none; color: inherit;">

                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="room_service" />
                                </q-item-section>

                                <q-item-section>
                                    Counter
                                </q-item-section>
                            </q-item>
                        </router-link>

                        <router-link to="/admin/orders" style="  text-decoration: none; color: inherit;">

                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="receipt_long" />
                                </q-item-section>

                                <q-item-section>
                                    Orders
                                </q-item-section>
                            </q-item>
                        </router-link>

                        <q-item clickable v-ripple>
                            <q-item-section avatar>
                                <q-icon name="people" />
                            </q-item-section>

                            <q-item-section>
                                Customer
                            </q-item-section>
                        </q-item>

                        <q-item-label header>Room</q-item-label>
                        <router-link to="/admin/counter" style="  text-decoration: none; color: inherit;">

                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="night_shelter" />
                                </q-item-section>

                                <q-item-section>
                                    Rooms
                                </q-item-section>
                            </q-item>
                        </router-link>
                        <router-link to="/admin/counter" style="  text-decoration: none; color: inherit;">

                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="inbox" />
                                </q-item-section>

                                <q-item-section>
                                    Reservations
                                </q-item-section>
                            </q-item>
                        </router-link>



                        <q-item-label header>Accounts</q-item-label>

                        <router-link to="/admin/employee" style="  text-decoration: none; color: inherit;">

                            <q-item clickable v-ripple>
                                <q-item-section avatar>
                                    <q-icon name="badge" />
                                </q-item-section>

                                <q-item-section>
                                    Employee
                                </q-item-section>
                            </q-item>
                        </router-link>

                    </q-list>
                </q-scroll-area>

                <!--
            in this case, we use a button (can be anything)
            so that user can switch back
            to mini-mode
          -->
                <div class="q-mini-drawer-hide absolute" style="top: 15px; right: -17px">
                    <q-btn dense round unelevated color="primary" icon="chevron_left" @click="miniState = true" />
                </div>
            </q-drawer>

            <q-page-container style="height: 200;">
                <router-view />
            </q-page-container>
        </q-layout>
</template>
  
<script>
import { ref } from 'vue'


export default {
    setup() {
        const miniState = ref(false)
        const fullScreen = ref(false)

        return {
            drawer: ref(false),
            miniState,
            fullScreen,

            drawerClick(e) {
                if (miniState.value) {
                    miniState.value = false
                    e.stopPropagation()
                }
            },

            toggleFullScreen() {
                const elem = document.documentElement

                if (!document.fullscreenElement) {
                    elem.requestFullscreen().catch((err) => {
                        console.error(`Error attempting to enable full-screen mode: ${err.message}`)
                    })
                    fullScreen.value = true
                } else {
                    document.exitFullscreen()
                    fullScreen.value = false
                }
            },
        }
    },
}
</script>


