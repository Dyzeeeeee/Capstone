import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Quasar, * as AllComponents from 'quasar/dist/quasar.umd.prod'
import 'quasar/dist/quasar.css'

import '@quasar/extras/material-icons/material-icons.css'
import { Quasar as QuasarExtras } from '@quasar/extras/material-icons'
import { QIcon } from 'quasar'
import axios from 'axios'
import './registerServiceWorker'

axios.defaults.baseURL = 'http://capstone.test/Backend/public/'

const app = createApp(App)

// Register Quasar components globally
for (const component in AllComponents) {
  app.component(component, AllComponents[component])
}

// Register Quasar icons
app.use(Quasar, {
  components: {
    // QIcon,
  },
  config: {
    // extras: ['material-icons'], // Add other icon sets if needed
  },
})

// Use Quasar
// app.use(QuasarExtras)
app.use(store)
app.use(router)
// Mount the app
app.mount('#app')
