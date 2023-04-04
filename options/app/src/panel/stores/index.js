import { defineStore } from 'pinia'
import { onMounted, ref, watch } from 'vue'

/**
 * create random ID
 */
const createId = () => {
  return Math.floor((1 + Math.random()) * 0x10000)
    .toString(16)
    .substring(1)
}

/**
 *
 * @param ({data: any, action: string})
 * @returns json
 */
const fetchAPI = async ({ data, action } = { action: null }) => {
  if (!action) return

  const dataToSend = new FormData()
  dataToSend.append('action', action)
  if (data) {
    dataToSend.append('data', data)
  }
  try {
    const call = await fetch(window.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Cache-Control': 'no-cache',
      },
      body: new URLSearchParams(dataToSend),
    })
    const response = await call.text()
    return JSON.parse(response)
  } catch (error) {
    console.log(error)
  }
}

export const useMainStore = defineStore('main', () => {
  const loading = ref(false)
  const isFirstTime = ref(true)
  const errors = ref([])
  const spaces = ref([])
  const lang = ref()

  /**
   * add Space object
   */
  function addSpace() {
    const newSpace = {
      isDefault: spaces.value.length === 0,
      id: createId(),
      slug: '',
    }
    Object.keys(lang.value).forEach((l) => {
      newSpace[`name_${lang.value[l].slug}`] = ''
    })
    spaces.value.push(newSpace)
  }

  /**
   * remove Space object
   * @param {string} id
   */
  function removeSpace(id) {
    // remove date in days if start and end
    const i = spaces.value.findIndex((v) => v.id === id)

    if (spaces.value[i].isDefault) {
      spaces.value[0].isDefault = true
    }
    if (i > -1) {
      spaces.value.splice(i, 1)
    }
  }

  /**
   * complete date value in object holiday
   * @param {name} key
   * @param {Event} e
   * @param {string} id
   */
  function handlerSpace(key, e, id) {
    const { value } = e.currentTarget
    const i = spaces.value.findIndex((v) => v.id === id)
    if (i > -1) {
      spaces.value[i][key] = value
    }
    // remove isDefault from all other spaces
    if (key === 'isDefault') {
      spaces.value.forEach((v) => {
        v.isDefault = false
      })
      spaces.value[i].isDefault = true
    }
  }

  /**
   * fetch data on load
   */
  onMounted(async () => {
    loading.value = true
    const cleanRes = await fetchAPI({ action: 'get_gm_theme_options_settings' })
    const _lang = await fetchAPI({
      action: 'get_gm_theme_options_languages',
    })
    isFirstTime.value = !cleanRes
    lang.value = _lang
    spaces.value = cleanRes?.spaces || []
    loading.value = false
  })

  watch(
    spaces,
    () => {
      if (!spaces.value) return
      let _errors = false
      spaces.value?.forEach((v) => {
        Object.keys(v).forEach((k) => {
          if (v[k] === '') {
            _errors = true
          }
        })
      })
      errors.value = _errors
    },
    { deep: true },
  )
  /**
   * save the data
   */
  async function saveOptions() {
    loading.value = true

    await fetchAPI({
      action: 'save_gm_theme_options_settings',
      data: JSON.stringify({
        spaces: spaces.value,
      }),
    })
    loading.value = false
  }

  return {
    isFirstTime,
    loading,
    lang,
    spaces,
    saveOptions,
    addSpace,
    removeSpace,
    handlerSpace,
    errors,
  }
})
