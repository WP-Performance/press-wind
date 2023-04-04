<template>
  <div class="gm-theme_options-admin-panel wrap">
    <h1>Theme options</h1>
    <Spaces />
    <button
      @click="store.saveOptions"
      :disabled="store.loading || store.errors"
      class="button button-primary"
    >
      <span v-if="store.loading === true">processing...</span>
      <span v-else>Sauver</span>
    </button>
    <div v-show="store.loading === true" class="gm-theme_options-loader">
      <Loader />
    </div>
  </div>
</template>

<script setup>
import { useMainStore } from './stores'
import Loader from './components/Loader.vue'
import Spaces from './components/Spaces.vue'

const store = useMainStore()
</script>

<style>
.gm-theme_options-h1 {
  margin-bottom: 2rem;
}

.gm-theme_options-admin-panel {
  margin-top: 0rem;
  padding: 1rem 0.5rem;
  position: relative;
}

.gm-theme_options-loader {
  display: flex;
  align-items: center;
  justify-content: center;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  background-color: rgba(240, 240, 241, 0.4);
  color: var(--wc-blue);
}

.gm-theme_options-fieldset {
  margin: 1rem 0;
}

.gm-theme_options-fieldset legend {
  font-weight: bold;
  margin-bottom: 0.5rem;
  font-size: 1.2rem;
}
</style>
