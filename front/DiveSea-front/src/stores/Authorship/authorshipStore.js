import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const useAuthorshipStore = defineStore('authorship', () => {
  const loader = ref(false)
  const authorships = ref([])
  const currentAuthorship = ref(null)

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

  const setApprovedAuthorship = (authorship) => {
    currentAuthorship.value = authorship;  // Устанавливаем выбранный NFT
  }

  const sendApprovedAuthorship = async (formData) => {
    try {
      await getCsrfToken();
      const res = await axios.post(`/api/authorship/create/`, formData);
      console.log('Авторство успешно одобрено', res.data);
      // await getNftApprove();
    } catch (error) {
      console.log('Ошибка при одобрении Авторства: ', error);
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


  return { loader, authorships, currentAuthorship,
    getApprovedAuthorship, setApprovedAuthorship, sendApprovedAuthorship, approveAuthorship, rejectNft, }
})
