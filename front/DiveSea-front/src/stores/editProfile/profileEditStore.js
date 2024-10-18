import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';

axios.defaults.baseURL = import.meta.env.VITE_API_URL;
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const useEditProfileStore = defineStore('editProfile', () => {
  const loader = ref(false);
  const error = ref(null)
  const avatarError = ref(null)
  const nickBioErr = ref(null)


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

 const editProfileAvatar = async (formData) => {
   loader.value = true;
   error.value = null;
   try {
     await getCsrfToken();
     const res = await axios.post('/api/edit/user_avatar', formData);
     console.log(res.data);
   } catch (err){
     error.value = err.response?.data?.errors?.img;
     console.log('При попытку отправить аватар произошла ошибка: ', err)
     throw err;
   } finally {
     loader.value = false;
   }
 }

  const editProfileBackground = async (formData) => {
    loader.value = true;
    error.value = null;
    try {
      await getCsrfToken();
      const res = await axios.post('/api/edit/user_background', formData);
      console.log(res.data);
    } catch (err){
      error.value = err.response?.data?.errors?.background;
      console.log('При попытку отправить фон произошла ошибка: ', err);
      throw err;
    } finally {
      loader.value = false;
    }
  }

  const editProfileNicknameBio = async (nickname, bio) => {
    loader.value = true;
    nickBioErr.value = null;
    try {
      await getCsrfToken();
      const res = await axios.post('/api/edit/user_nickname_bio', {
        nickname: nickname,
        bio: bio,
      });
      console.log(res.data);
    } catch (err){
      nickBioErr.value = err.response?.data?.message;
      console.log('При попытку отправить ник и био произошла ошибка: ', err);
      throw err;
    } finally {
      loader.value = false;
    }
  }




  return { error, nickBioErr, avatarError,
    editProfileAvatar, editProfileBackground, editProfileNicknameBio }
})
