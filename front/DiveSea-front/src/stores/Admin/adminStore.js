import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const useAdminStore = defineStore('admin', () => {
  const loader = ref(null)
  const nfts = ref(null)
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
   try {
     await getCsrfToken();
     const res = await axios.get('/api/admin');
     nfts.value = res.data.data;
     console.log(res.data);
   } catch (error){
     console.log('При получении nft на подтверждение произошла ошибка: ', error)
   }
 }

  const setSelectedNft = (nft) => {
    currentNft.value = nft;  // Устанавливаем выбранный NFT
  }


  return { nfts, currentNft,
   getNftApprove, setSelectedNft }
})
