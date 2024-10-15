import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useValidStore = defineStore('valid', () => {

  const validateForm = (reason, reasonError) => {
    if (!reasonError.value) {
      reasonError.value = '';
    }
    let isValid = true;

    // Проверка description
    if (!reason.value || reason.value.length < 10) { // Используем reason.value
      reasonError.value = 'Reason must be at least 10 characters'; // Исправляем текст ошибки
      isValid = false;
    } else {
      reasonError.value = '';
    }

    return isValid;
  };

  return { validateForm }
})
