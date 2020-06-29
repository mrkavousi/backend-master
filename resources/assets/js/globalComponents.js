import CsrfField from './components/CsrfField.vue'

/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */

const GlobalComponents = {
  install (Vue) {
    Vue.component('csrf-field', CsrfField)
  }
}

export default GlobalComponents