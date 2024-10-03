import { ref, computed } from 'vue'
import { defineStore, storeToRefs } from 'pinia'
import axios from 'axios';
import { useAuthorshipStore } from '@/stores/Authorship/authorshipStore.js'


axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null);
  const loading = ref(false);
  const authorshipStore = useAuthorshipStore();
  const { isChecked } = storeToRefs(authorshipStore);

  const getUserFromCache = () => {
    const cachedUser = localStorage.getItem('user');
    if (cachedUser) {
      user.value = JSON.parse(cachedUser);
    }
  };

  const getCsrfToken = async () => {
    if (!document.cookie.includes('XSRF-TOKEN')) {
      try {
        await axios.get('/sanctum/csrf-cookie');
      } catch (error) {
        console.error("Ошибка получения CSRF токена", error);
      }
    }
  };

  const login = async (email, password) => {
    try {
      await getCsrfToken(); // получаем CSRF токен
      await axios.post('/api/login', { email, password });
      await getUser(); // получаем информацию о пользователе
      localStorage.setItem('user', JSON.stringify(user.value));
    } catch (error) {
      console.error('Ошибка авторизации', error);
      throw error;
    }
  };

  const register = async (name, email, password, password_confirmation) => {
    try {
      await getCsrfToken();
      await axios.post('/api/register', { name, email, password, password_confirmation });
    } catch (error) {
      console.error('Ошибка регистрации', error);
      throw error;
    }
  };

  const logout = async () => {
    try {
      await getCsrfToken();
      await axios.post('/api/logout');
      user.value = null;
      localStorage.removeItem('user'); // Очищаем локальное хранилище при выходе
      isChecked.value = false;
    } catch (error) {
      console.error('Ошибка выхода', error);
      throw error;
    }
  };


  // Получение информации о текущем пользователе
  const getUser = async () => {
    // loading.value = true;
    // Если пользователь уже загружен в память (или из кэша), не делаем запрос
    if (user.value) {
      return;
    }
    try {
      // Делаем запрос только если пользователь аутентифицирован
      const response = await axios.get('/api/user');
      user.value = response.data;
      localStorage.setItem('user', JSON.stringify(user.value)); // Кэшируем данные
    } catch (error) {
      console.log('Пользователь не авторизован или сессия недействительна');
    } finally {
      // loading.value = false;
    }
  };

  const isAuthenticated = computed(() => !!user.value);
  const isAuthor = computed(() => user.value?.role === "author");
  const isAdmin = computed(() => user.value?.role === "admin");

  return {
    user, isAuthor, isAdmin, isAuthenticated, loading,
    login, register, logout, getUser, getUserFromCache,
  };
})
