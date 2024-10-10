<script setup>
  import { onMounted, ref, watchEffect } from 'vue'
  import Cropper from 'cropperjs';
  import { useAuthStore } from '@/stores/authStore.js';
  import { storeToRefs } from 'pinia';
  import { useRoute, useRouter } from 'vue-router';

  const AuthStore = useAuthStore();
  const { user } = storeToRefs(AuthStore);
  const route = useRoute();
  const router = useRouter();

  const nickname = ref(null);


  // refs для элементов изображения и cropper'а
  const avatarFileInput = ref(null);
  const cropperInstance = ref(null);
  const previewImage = ref(null);
  const croppedImageData = ref(null);

  // Логика обработки изображения
  const onAvatarChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        previewImage.value.src = e.target.result;

        // Если cropper уже существует, уничтожаем его перед созданием нового
        if (cropperInstance.value) {
          cropperInstance.value.destroy();
        }

        // Инициализация Cropper.js
        cropperInstance.value = new Cropper(previewImage.value, {
          aspectRatio: 1, // Квадратная рамка обрезки для аватара
          viewMode: 1,
          autoCropArea: 1,
          crop(event) {
            croppedImageData.value = cropperInstance.value.getCroppedCanvas().toDataURL();
          },
        });
      };
      reader.readAsDataURL(file);
    }
  };


</script>

<template>
   <section class="change-profile">
<!--     <div class="loader change-profile__loader" v-if="isLoading"></div>-->
     <div class="container change-profile__container">

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
               <input type="file" id="avatar" class="hidden" accept="image/*"
                      ref="avatarFileInput"
                      @change="onAvatarChange"
               >
             </label>
             <img class="change-profile__img" :src="user.img" alt="Картинка профиля" width="120" height="120">
           </div>
         </div>

         <div class="uploader">
           <label class="main-title change-profile__title" for="background">Profile background</label>
           <div class="change-profile__row">
             <label class="uploader-trigger">
               <div class="uploader-trigger__caption">
                 <div class="uploader-trigger__icon">
                   <svg width="16px" height="16px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="currentColor" fill-rule="evenodd" d="M9 12a1 1 0 102 0V4.26l3.827 3.48a1 1 0 001.346-1.48l-5.5-5a1 1 0 00-1.346 0l-5.5 5a1 1 0 101.346 1.48L9 4.26V12zm-5.895-.796A1 1 0 001.5 12v3.867a2.018 2.018 0 002.227 2.002c1.424-.147 3.96-.369 6.273-.369 2.386 0 5.248.236 6.795.383a2.013 2.013 0 002.205-2V12a1 1 0 10-2 0v3.884l-13.895-4.68zm0 0L2.5 11l.605.204zm0 0l13.892 4.683a.019.019 0 01-.007.005h-.006c-1.558-.148-4.499-.392-6.984-.392-2.416 0-5.034.23-6.478.38h-.009a.026.026 0 01-.013-.011V12a.998.998 0 00-.394-.796z"></path> </g></svg>
                 </div>
                 <div class="change-profile__trigger-text">Click or drag the image to upload</div>
               </div>
               <input type="file" id="background" class="hidden" accept="image/*">
             </label>
             <img class="change-profile__img" :src="user.img" alt="Картинка профиля" width="120" height="120">
           </div>
         </div>

       </div>



        <form class="change-profile__form form">






          <div class="form__container">
            <label class="main-title change-profile__title" for="nickname">Nickname</label>
            <input class="form__field" type="text" id="nickname" v-model="user.nickname" required />
          </div>

          <div class="form__container">
            <label class="main-title change-profile__title" for="bio">About yourself</label>
            <textarea class="form__field" type="text" id="bio" v-model="bio" placeholder="A few words about yourself" required />
          </div>

          <div class="form__container">
            <button class="btn-reset main-button form__btn">Save</button>
          </div>
        </form>
     </div>
   </section>
</template>

<style scoped lang="scss">
  .change-profile{
    margin: 50px 0;
    &__container{
      max-width: 800px;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      justify-content: center;
      gap: 30px;
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
      flex-direction: row;
      align-items: center;
      gap: 20px;
    }
  }

  .settings-upload{
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  .uploader{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
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
    width: 100%;
    margin: 0 auto;
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
      max-width: 770px;
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
</style>