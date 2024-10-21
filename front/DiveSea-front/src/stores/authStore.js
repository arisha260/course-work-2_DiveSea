import { ref, computed } from 'vue'
import { defineStore, storeToRefs } from 'pinia'
import axios from 'axios';
import { useAuthorshipStore } from '@/stores/Authorship/authorshipStore.js'

axios.defaults.baseURL = import.meta.env.VITE_API_URL;
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null);
  const loading = ref(false);
  const authorshipStore = useAuthorshipStore();
  const { isChecked } = storeToRefs(authorshipStore);

  const saveUserToLocalStorage = (user) => {
    const expirationTime = Date.now() + 7 * 24 * 60 * 60 * 1000; // 7 дней в миллисекундах
    localStorage.setItem('user', JSON.stringify({ user, expirationTime }));
  };

  const getUserFromLocalStorage = () => {
    const cachedData = localStorage.getItem('user');
    if (cachedData) {
      const { user, expirationTime } = JSON.parse(cachedData);
      if (Date.now() < expirationTime) {
        return user;
      } else {
        // Данные истекли, удаляем из localStorage
        localStorage.removeItem('user');
      }
    }
    return null;
  };

  const getUserFromCache = () => {
    const cachedUser = getUserFromLocalStorage();
    if (cachedUser) {
      user.value = cachedUser;
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
      saveUserToLocalStorage(user.value);
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
    try {
      // Делаем запрос только если пользователь аутентифицирован
      const response = await axios.get('/api/user');
      user.value = response.data;
      saveUserToLocalStorage(user.value);
    } catch (error) {
      console.log('Пользователь не авторизован или сессия недействительна');
    } finally {
      // loading.value = false;ф
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
