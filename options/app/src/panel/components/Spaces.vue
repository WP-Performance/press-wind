<template>
  <fieldset class="gm-theme_options-fieldset">
    <legend class="gm-theme_options-legend">Spaces site</legend>
    <div>
      <div>
        <button @click="store.addSpace" class="button">Add space</button>
      </div>
      <ul>
        <li v-for="space in store.spaces" :key="space.id">
          <label class="gm-theme_options-label-radio">
            <span>Default</span>
            <input
              type="radio"
              :checked="space.isDefault"
              name="isDefault"
              required
              @input="(e) => store.handlerSpace('isDefault', e, space.id)"
            />
          </label>
          <label class="gm-theme_options-label">
            Internal Id
            <input
              type="text"
              :value="space.slug"
              name="slug"
              required
              :class="space.slug === '' ? 'error' : ''"
              @input="(e) => store.handlerSpace('slug', e, space.id)"
            />
          </label>
          <label
            v-for="lang of store.lang"
            :key="lang"
            class="gm-theme_options-label"
          >
            Name {{ lang.name }}
            <input
              type="text"
              :value="space[`name_${lang.slug}`]"
              required
              :name="`name_${lang.slug}`"
              :class="space[`name_${lang.slug}`] === '' ? 'error' : ''"
              @input="
                (e) => store.handlerSpace('name_' + lang.slug, e, space.id)
              "
            />
          </label>
          <button @click="handlerDelete($event, space.id)" class="button">
            Remove
          </button>
        </li>
      </ul>
    </div>
  </fieldset>
</template>

<script setup>
import { useMainStore } from '../stores'
const store = useMainStore()

const handlerDelete = (e, space) => {
  e.preventDefault()
  if (confirm('Are you sure you want to delete this space?')) {
    store.removeSpace(space)
  }
}
</script>

<style scoped>
li {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  border: 1px solid #999;
  background-color: #f7f7f7;
  padding: 0.5rem;
  border-radius: 4px;
}

li button.button {
  display: block;
  margin-left: auto;
}
li label {
  margin: 0.5rem;
  display: flex;
  flex-direction: column;
}
li label input.error {
  border: 1px solid red;
}
.gm-theme_options-label-radio {
  margin: -0.3rem 0 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: stretch;
}
.gm-theme_options-label-radio span {
  margin-bottom: 0.8rem;
}
</style>
