import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';

axios.defaults.baseURL = import.meta.env.VITE_API_URL;
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const useAuthorshipStore = defineStore('authorship', () => {
  const loader = ref(false)
  const authorships = ref([])
  const currentAuthorship = ref(null)
  const isChecked = ref(false); // Флаг проверки авторства
  const error = ref(null);



  const hasSubmittedAuthorship = computed(() => !!currentAuthorship.value && currentAuthorship.value.length > 0);

  const getCsrfToken = async () => {
    if (!document.cookie.includes('XSRF-TOKEN')) {
      // Если куки с CSRF токеном еще нет, только тогда запрашиваем его
      try {
        await axios.get('/sanctum/csrf-cookie');
      } catch (error) {
        console.error("Ошибка получения CSRF токена", error);
      }
    }
  };

  const getApprovedAuthorship = async () => {
    loader.value = true;
    try {
      await getCsrfToken();
      const res = await axios.get('/api/authorship');
      authorships.value = res.data.data;
      console.log(res.data);
      console.log(authorships);
      console.log(res.data.data);
    } catch (error){
      console.log('При получении authorship на подтверждение произошла ошибка: ', error)
    } finally {
      loader.value = false;
    }
  }

  const checkAuthorship = async (id) => {
    loader.value = true;
    try {
      await getCsrfToken();
      const res = await axios.get(`/api/authorship/check/${id}`);
      currentAuthorship.value = res.data.data;
      isChecked.value = true;
      console.log(res.data.data);
    } catch (error){
      console.log('При получении authorship произошла ошибка: ', error)
    } finally {
      loader.value = false;
    }
  }

  // const setApprovedAuthorship = (authorship) => {
  //   currentAuthorship.value = authorship;  // Устанавливаем выбранный NFT
  // }

  const sendApprovedAuthorship = async (formData) => {
    try {
      await getCsrfToken();
      const res = await axios.post(`/api/authorship/create/`, formData);
      console.log('Заявка успешно отправлена', res.data);
      // await getNftApprove();
    } catch (err) {
      error.value = err.response?.data?.message || err.response?.data?.error; // Логируем ошибку
      console.log('Ошибка при отправке заявки: ', err);
      throw err;
    }
  }

  const approveAuthorship = async (authorshipId) => {
    try {
      await getCsrfToken();  // Получаем CSRF токен
      const res = await axios.post(`/api/authorship/approve/${authorshipId}`);
      console.log('Authorship успешно подтверждено', res.data);
      await getApprovedAuthorship();
    } catch (error) {
      console.log('Ошибка при подтверждении авторства: ', error);
    }
  };


  const rejectNft = async (Id) => {
    try {
      await getCsrfToken();
      await axios.delete(`/api/authorship/delete/${Id}`);
      console.log('NFT успешно отклонено');
      await getApprovedAuthorship();
    } catch (error) {
      console.log('Ошибка при отклонении NFT: ', error);
    }
  }


  return { loader, authorships, currentAuthorship, hasSubmittedAuthorship, isChecked, error,
    getApprovedAuthorship, checkAuthorship, sendApprovedAuthorship, approveAuthorship, rejectNft, }
})
