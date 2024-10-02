import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useValidStore = defineStore('valid', () => {

  const validateForm = (reason, reasonError) => {
    let isValid = true;

    // Проверка description
    if (!reason || reason.length < 10) {
      reasonError.value = 'Reason must be at least 0 characters';
      isValid = false;
    } else {
      reasonError.value = '';
    }

    return isValid;
  };

  return { validateForm }
})
