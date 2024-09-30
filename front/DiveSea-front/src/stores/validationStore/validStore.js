import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useValidStore = defineStore('valid', () => {

  const validateForm = (title, titleError, description, descriptionError, royalty, royaltyError, price, priceError, in_stock, inStockError) => {
    let isValid = true;

    // Проверка title
    if (!title.value) {
      titleError.value = 'Title is required';
      isValid = false;
    } else {
      titleError.value = '';
    }

    // Проверка description
    if (!description.value || description.value.length < 30) {
      descriptionError.value = 'Description must be at least 30 characters';
      isValid = false;
    } else {
      descriptionError.value = '';
    }

    // Проверка royalty
    if (royalty.value < 0) {
      royaltyError.value = 'Royalty must be 0 or higher';
      isValid = false;
    } else {
      royaltyError.value = '';
    }

    // Проверка price
    if (price.value < 0) {
      priceError.value = 'Price must be 0 or higher';
      isValid = false;
    } else {
      priceError.value = '';
    }

    // Проверка in_stock
    if (in_stock.value < 1) {
      inStockError.value = 'At least one item must be in stock';
      isValid = false;
    } else {
      inStockError.value = '';
    }

    return isValid;
  };

  return { validateForm }
})
