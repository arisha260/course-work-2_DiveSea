import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';

axios.defaults.baseURL = import.meta.env.VITE_API_URL;
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const useAdminStore = defineStore('admin', () => {
  const loader = ref(false)
  const nfts = ref([])
  const currentNft = ref(null)

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

 const getNftApprove = async () => {
   loader.value = true;
   try {
     await getCsrfToken();
     const res = await axios.get('/api/admin');
     nfts.value = res.data.data;
     console.log(res.data);
   } catch (error){
     console.log('При получении nft на подтверждение произошла ошибка: ', error)
   } finally {
     loader.value = false;
   }
 }

  const setSelectedNft = (nft) => {
    currentNft.value = nft;  // Устанавливаем выбранный NFT
  }

  const sendApprovedNft = async (id, formData) => {
    try {
      await getCsrfToken();
      const res = await axios.post(`/api/admin/create/${id}`, formData);
      console.log('NFT успешно одобрено', res.data);
      console.log("Отправляемые данные: ", formData);
      await getNftApprove();
    } catch (error) {
      console.log('Ошибка при одобрении NFT: ', error);
    }
  }

  const rejectNft = async (nftId) => {
    try {
      await getCsrfToken();
      await axios.delete(`/api/admin/delete/${nftId}`);
      console.log('NFT успешно отклонено');
      await getNftApprove();
    } catch (error) {
      console.log('Ошибка при отклонении NFT: ', error);
    }
  }


  return { nfts, currentNft, loader,
   getNftApprove, setSelectedNft, sendApprovedNft, rejectNft }
})
