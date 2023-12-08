import { createApp } from 'vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { clickaway } from '@/directives'
import App from './App.vue'

createApp(App)
  .component('icon', FontAwesomeIcon)
  .directive('charon-clickaway', clickaway)
  .mount('#app')
