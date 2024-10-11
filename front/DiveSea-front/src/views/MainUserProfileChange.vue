<script setup>
  import { watch, ref } from 'vue'
  import { useAuthStore } from '@/stores/authStore.js';
  import { useEditProfileStore } from '@/stores/editProfile/profileEditStore.js'
  import { storeToRefs } from 'pinia';

  const AuthStore = useAuthStore();
  const store = useEditProfileStore();
  const { user } = storeToRefs(AuthStore);
  const { error, nickBioErr } = storeToRefs(store);

  const avatarFileInput = ref(null);
  const bgFileInput = ref(null);
  const bio = ref('');

  const showError = ref(false);

  watch(error, (newValue) => {
    if (newValue && newValue.length > 0) {
      showError.value = true;
      setTimeout(() => {
        showError.value = false;
      }, 3500);
    }
  });

  const editProfileAvatar = async () => {
    try {
      const formData = new FormData();
      const file = avatarFileInput.value.files[0]; // Используем ref для получения файла
      if (file) {
        formData.append('img', file); // Добавляем файл в FormData
      }
      const formDataObject = {};
      formData.forEach((value, key) => {
        formDataObject[key] = value;
      });
      await store.editProfileAvatar(formData);
      await AuthStore.getUser();
      console.log('Аватар отправлен:', formDataObject);
    } catch (error) {
      console.error('Ошибка при отправке данных:', error);
      console.log('Ошибка при отправке данных:', error.response.data);
    }
  }

  const editProfileBackground = async () => {
    try {
      const formData = new FormData();
      const file = bgFileInput.value.files[0]; // Используем ref для получения файла
      if (file) {
        formData.append('background', file); // Добавляем файл в FormData
      }
      const formDataObject = {};
      formData.forEach((value, key) => {
        formDataObject[key] = value;
      });
      await store.editProfileBackground(formData);
      await AuthStore.getUser();
      console.log('Фон отправлен:', formDataObject);
    } catch (err) {
      console.error('Ошибка при отправке фона:', err);
    } finally {
      bgFileInput.value.value = '';
    }
  }

  const editProfileNicknameBio = async () => {
    try {
      const newNickname = user.value.nickname;
      const newBio = bio.value;
      await store.editProfileNicknameBio(newNickname, newBio);
      await AuthStore.getUser();
      bio.value = '';
      console.log("Новый ник и био отправлены");
    } catch (err) {
      console.error('Ошибка при отправке ника и био:', err);
    }
  }
</script>

<template>
   <section class="change-profile">
     <transition name="fade" mode="out-in">
       <div v-if="showError && error && error.length" class="modal">
         <ul class="list-reset">
           <li v-for="(errMsg, index) in error" :key="index">{{ errMsg }}</li>
         </ul>
       </div>
     </transition>
<!--     <div class="loader change-profile__loader" v-if="isLoading"></div>-->
     <div class="container change-profile__container">
       <div class="change-profile__content">

         <div class="settings-upload">

           <div class="uploader">
             <label class="main-title change-profile__title" for="avatar">Avatar</label>
             <div class="change-profile__row">
               <label class="uploader-trigger">
                 <div class="uploader-trigger__caption">
                   <div class="uploader-trigger__icon">
                     <svg width="16px" height="16px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="currentColor" fill-rule="evenodd" d="M9 12a1 1 0 102 0V4.26l3.827 3.48a1 1 0 001.346-1.48l-5.5-5a1 1 0 00-1.346 0l-5.5 5a1 1 0 101.346 1.48L9 4.26V12zm-5.895-.796A1 1 0 001.5 12v3.867a2.018 2.018 0 002.227 2.002c1.424-.147 3.96-.369 6.273-.369 2.386 0 5.248.236 6.795.383a2.013 2.013 0 002.205-2V12a1 1 0 10-2 0v3.884l-13.895-4.68zm0 0L2.5 11l.605.204zm0 0l13.892 4.683a.019.019 0 01-.007.005h-.006c-1.558-.148-4.499-.392-6.984-.392-2.416 0-5.034.23-6.478.38h-.009a.026.026 0 01-.013-.011V12a.998.998 0 00-.394-.796z"></path> </g></svg>
                   </div>
                   <div class="change-profile__trigger-text">Click or drag the image to upload</div>
                 </div>
                 <input type="file" id="avatar" @change="editProfileAvatar" class="hidden" accept="image/*"
                        ref="avatarFileInput">
               </label>
               <img class="change-profile__img" :src="user.img" alt="Картинка профиля" width="120" height="120">
             </div>
           </div>

           <div class="uploader uploader_background">
             <label class="main-title change-profile__title" for="background">Profile background</label>
             <div class="change-profile__row">
               <label class="uploader-trigger">
                 <div class="uploader-trigger__caption">
                   <div class="uploader-trigger__icon">
                     <svg width="16px" height="16px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="currentColor" fill-rule="evenodd" d="M9 12a1 1 0 102 0V4.26l3.827 3.48a1 1 0 001.346-1.48l-5.5-5a1 1 0 00-1.346 0l-5.5 5a1 1 0 101.346 1.48L9 4.26V12zm-5.895-.796A1 1 0 001.5 12v3.867a2.018 2.018 0 002.227 2.002c1.424-.147 3.96-.369 6.273-.369 2.386 0 5.248.236 6.795.383a2.013 2.013 0 002.205-2V12a1 1 0 10-2 0v3.884l-13.895-4.68zm0 0L2.5 11l.605.204zm0 0l13.892 4.683a.019.019 0 01-.007.005h-.006c-1.558-.148-4.499-.392-6.984-.392-2.416 0-5.034.23-6.478.38h-.009a.026.026 0 01-.013-.011V12a.998.998 0 00-.394-.796z"></path> </g></svg>
                   </div>
                   <div class="change-profile__trigger-text">Click or drag the image to upload</div>
                 </div>
                 <input type="file" id="background" @change="editProfileBackground" class="hidden" accept="image/*" ref="bgFileInput">
               </label>
               <div class="uploader-preview">
                 <div class="uploader-preview__img" :style="{ backgroundImage: user.background ? `url(${user.background})` : 'url(/basic.jpg)' }">
                 </div>
               </div>
               </div>
           </div>
         </div>


          <form class="change-profile__form form" @submit.prevent="editProfileNicknameBio">
            <div class="form__container">
              <label class="main-title change-profile__title" for="nickname">Nickname</label>
              <input class="form__field" type="text" id="nickname" v-model="user.nickname" :placeholder="user.nickname" />
              <span class="error" v-if="nickBioErr">{{ nickBioErr }}</span>
            </div>
            <div class="form__container">
              <label class="main-title change-profile__title" for="bio">About yourself</label>
              <textarea class="form__field" type="text" id="bio" v-model="bio" placeholder="A few words about yourself" />
            </div>
            <div class="form__container">
              <button type="submit" class="btn-reset main-button form__btn">Save</button>
            </div>
          </form>
       </div>
     </div>
   </section>
</template>

<style scoped lang="scss">
  .change-profile{
    margin: 50px 0;
    &__container{
      max-width: 900px;
      padding: 20px;
      box-shadow: 39px 12px 59px 0 rgba(199, 199, 199, 0.6);

    }
    &__title{
      font-size: 20px;
    }
    &__trigger-text{
      font-family: var(--font-family);
      font-weight: 500;
      line-height: 125%;
      color: #000;
    }
    &__row{
      display: flex;
      gap: 20px;
      padding-top: 20px;
    }
    &__content{
      -webkit-box-flex: 1;
      -ms-flex-positive: 1;
      flex-grow: 1;
    }
  }

  .settings-upload{
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  .uploader{

    &-trigger{
      width: 120px;
      height: 120px;
      position: relative;
      min-height: 110px;
      min-width: 110px;
      border: 2px dashed #dcdcdc;
      border-radius: 3px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      cursor: pointer;
    }
    &-trigger__caption{
      pointer-events: none;
      text-align: center;
      font-size: 13px;
      padding: 10px;
    }

  }

  .form{
    margin-top: 30px;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    gap: 30px;
    &__container{
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 20px;
    }
    &__field{
      padding: 13px 16px;
      width: 100%;
      max-width: 100%;
      border-radius: 12px;
      background: #efefef;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 13px;
      line-height: 125%;
      color: #000;
      outline: none;
      border: 1px solid #efefef;
      &::-webkit-input-placeholder{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 13px;
        line-height: 125%;
        color: #9596a6;
      }
      &::-moz-placeholder{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 13px;
        line-height: 125%;
        color: #9596a6;
      }
      &:-moz-placeholder{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 13px;
        line-height: 125%;
        color: #9596a6;
      }
      &:-ms-input-placeholder{
        font-family: var(--font-family);
        font-weight: 400;
        font-size: 13px;
        line-height: 125%;
        color: #9596a6;
      }
    }

    &__btn{
      padding: 10px 40px;
    }
  }

  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s ease-in-out;
  }
  .fade-enter-from, .fade-leave-to {
    opacity: 0;
  }
</style>