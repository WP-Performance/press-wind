import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { plugin, defaultConfig } from '@formkit/vue'

import panel from './panel/main.vue'

document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('gm-options-app')
  if (container) {
    const pinia = createPinia()
    const app = createApp(panel, {})
    app.use(pinia)
    app.use(plugin, defaultConfig)
    app.mount('#gm-options-app')
  }
})
