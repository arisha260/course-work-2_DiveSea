<script setup>
  import {ref, computed, nextTick, onMounted } from "vue";
  import { useRoute } from 'vue-router';
  import { useNftStore } from '@/stores/Nft';
  import { storeToRefs } from 'pinia';
  import { useAuthStore } from '@/stores/authStore';
  import { useValidStore } from '@/stores/validationStore/validStore.js'
  import { useAuthorshipStore } from '@/stores/Authorship/authorshipStore.js'


  const store = useNftStore();
  const authorStore = useAuthStore();
  const validStore = useValidStore();
  const authorshipStore = useAuthorshipStore();
  const { user, isAuthor, isAdmin, loading, isAuthenticated } = storeToRefs(authorStore);
  const { hasSubmittedAuthorship, loader } = storeToRefs(authorshipStore);

  const title = ref('');
  const description = ref('');
  const royalty = ref(0);
  const price = ref(0);
  const in_stock = ref(1);
  // const put_on_sale = ref(false);
  // const direct_sale = ref(false);
  const image = ref(null);
  const nftForm = ref(null);
  const sale_type = ref(null);


  const titleError = ref('');
  const descriptionError = ref('');
  const royaltyError = ref('');
  const priceError = ref('');
  const inStockError = ref('');


  const clearForm = () => {
    title.value = null;
    description.value = null;
    royalty.value = null;
    // put_on_sale.value = false;
    // direct_sale.value = false;
    price.value = null;
    in_stock.value = null;
    image.value = null;
    sale_type.value = 'put_on_sale';
  };

  const isDisabled = computed(() => {
    return title.value && description.value && royalty.value && price.value && in_stock.value
  });

  const handleFileUpload = (event) => {
    image.value = event.target; // Сохраняем ссылку на элемент input
  };

  const createNft = async () => {
    nftForm.value.scrollIntoView({ behavior: 'smooth' });
    if (!validStore.validateForm(title, titleError, description, descriptionError, royalty, royaltyError, price, priceError, in_stock, inStockError)) {
      return; // Если форма не прошла валидацию, не отправляем
    }
    try {
      const formData = new FormData();

      // Добавляем все необходимые поля в formData
      formData.append('title', title.value);
      formData.append('description', description.value);
      formData.append('royalty', royalty.value);
      // formData.append('put_on_sale', put_on_sale.value ? '1' : '0'); // Преобразуем в '1' или '0'
      // formData.append('direct_sale', direct_sale.value ? '1' : '0'); // Преобразуем в '1' или '0'
      formData.append('sale_type', sale_type.value);
      formData.append('price', price.value);
      formData.append('in_stock', in_stock.value);
      formData.append('author_id', user.value.id);

      const file = image.value.files[0]; // Используем ref для получения файла
      if (file) {
        formData.append('img', file); // Добавляем файл в FormData
      }
      const formDataObject = {};
      formData.forEach((value, key) => {
        formDataObject[key] = value;
      });

      await store.createNft(formData, titleError);
      console.log('Отправляемые данные:', formDataObject);
      clearForm();
    } catch (error) {
      console.error('Ошибка при отправке данных:', error);
      console.log('Ошибка при отправке данных:', error.response.data);
    }
  };

  onMounted(() => {
    if (isAuthenticated){
      authorshipStore.checkAuthorship(user.value.id);
    }
  })
</script>

<template>
  <section class="sell">
    <div class="container sell__container">
      <h1 class="main-title sell__title">Create Your NFT</h1>

      <div v-if="loader" class="loader"></div>

      <div class="sell__auth" v-else-if="!user">
        <p class="sell__text">Для доступа к этой странице необходимо войти в систему</p>
        <router-link :to="{ name: 'login'}" class="main-button sell__btn">Зарегистрироваться!</router-link>
      </div>

      <div class="sell__content" v-else-if="isAuthor || isAdmin">
        <form @submit.prevent="createNft" action="" ref="nftForm" class="sell__form form" enctype="multipart/form-data">

         <div class="form__left">

           <div class="form__content form__content-large">
             <label class="form__title" for="img">Name</label>
             <input class="input-reset form__field" type="text" v-model="title" placeholder="ArtWork Name" required />
             <span class="form__error">{{ titleError }}</span>
           </div>

           <div class="form__content form__content-large">
             <label class="form__title" for="img">Description</label>
             <textarea class="input-reset form__field" type="text" v-model="description" placeholder="Enter Your Description" required></textarea>
             <span class="form__error">{{ descriptionError }}</span>
           </div>

           <div class="form__row">
             <div class="form__content form__content-arrow">
               <label class="form__title" for="img">Royalty</label>
               <input class="input-reset form__field" type="number" min="0" v-model="royalty" placeholder="Royalty" required />
               <span class="form__error">{{ royaltyError }}</span>
             </div>
             <div class="form__content form__content-small">
               <label class="form__title" for="img">Size</label>
               <input class="input-reset form__field" type="text" placeholder="Ex - 100 x 100"  />
             </div>
           </div>

           <div class="form__content form__content-large">
             <label class="form__title" for="img">Tags</label>
             <input class="input-reset form__field" type="text" placeholder="Beautiful Castle, Monkeys ETC"  />
           </div>

           <div class="form__row">
             <div class="form__content form__content-arrow">
               <label class="form__title" for="img">Price</label>
               <div class="form__row-sec"> <!-- Добавляем контейнер с display: flex -->
                 <svg width="11" height="6" class="form__arrow form__arrow-2 form__svg" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                   <path fill-rule="evenodd" clip-rule="evenodd" d="M9.9005 0.474306C10.2074 0.781194 10.2074 1.27876 9.9005 1.58565L5.70938 5.77677C5.40249 6.08365 4.90493 6.08365 4.59804 5.77677L0.406924 1.58565C0.100036 1.27876 0.100036 0.781195 0.406924 0.474307C0.713811 0.167419 1.21137 0.167419 1.51826 0.474307L5.15371 4.10976L8.78916 0.474306C9.09605 0.167419 9.59362 0.167419 9.9005 0.474306Z" fill="currentColor" />
                 </svg>
                 <select class="input-reset form__field form__field-split form__field-line">
                   <option value="ETH">ETH</option>
                   <option value="USDT">USDT</option>
                   <option value="EUR">EUR</option>
                 </select>
                 <div class="form__line"></div>
                 <input v-model="price" class="input-reset form__field form__field-split" type="number" min="0" placeholder="0.00007 ETC" required />
               </div>
               <span class="form__error">{{ priceError }}</span>

             </div>



             <div class="form__content form__content-arrow">
               <label class="form__title" for="img">In Stock</label>
               <svg width="11" height="6" class="form__arrow form__svg" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                 <path fill-rule="evenodd" clip-rule="evenodd" d="M9.9005 0.474306C10.2074 0.781194 10.2074 1.27876 9.9005 1.58565L5.70938 5.77677C5.40249 6.08365 4.90493 6.08365 4.59804 5.77677L0.406924 1.58565C0.100036 1.27876 0.100036 0.781195 0.406924 0.474307C0.713811 0.167419 1.21137 0.167419 1.51826 0.474307L5.15371 4.10976L8.78916 0.474306C9.09605 0.167419 9.59362 0.167419 9.9005 0.474306Z" fill="currentColor" />
               </svg>
               <select class="input-reset form__field" ref="titleField" v-model="in_stock">
                 <option value="1">001</option>
                 <option value="2">002</option>
                 <option value="3">003</option>
                 <option value="4">004</option>
                 <option value="5">005</option>
                 <option value="6">006</option>
               </select>
               <span class="form__error">{{ inStockError }}</span>
             </div>
           </div>


           <div class="form__content-checkbox">
             <div class="form__text-content">
               <h4 class="form__title">Put On Sale</h4>
               <p class="form__text">People Will Bids On Your NFT Project</p>
             </div>
             <label>
               <input type="radio" v-model="sale_type" value="put_on_sale">
             </label>
           </div>

           <div class="form__content-checkbox">
             <div class="form__text-content">
               <h4 class="form__title">Direct Sale</h4>
               <p class="form__text">No Bids - Only Direct Salling</p>
             </div>
             <label>
               <input type="radio" v-model="sale_type" value="direct_sale">
             </label>
           </div>


           <button type="submit" class="btn-reset main-button form__btn form__btn-create">Create</button>
         </div>



          <div class="form__right">
            <div class="form__upload">
              <svg width="52" height="52" viewBox="0 0 52 52" class="form__img" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.78491 11.1497C6.78491 6.43315 10.6084 2.60962 15.325 2.60962H33.1378C35.4028 2.60962 37.575 3.50938 39.1765 5.11095L42.714 8.64837C44.3155 10.2499 45.2153 12.4222 45.2153 14.6871V41.04C45.2153 45.7566 41.3918 49.5801 36.6752 49.5801H15.325C10.6084 49.5801 6.78491 45.7566 6.78491 41.04V11.1497ZM40.9452 17.5548V41.04C40.9452 43.3983 39.0335 45.31 36.6752 45.31H15.325C12.9667 45.31 11.055 43.3983 11.055 41.04V11.1497C11.055 8.79142 12.9667 6.87966 15.325 6.87966H30.2701V11.1497C30.2701 14.6871 33.1378 17.5548 36.6752 17.5548H40.9452ZM40.7084 13.2847C40.4987 12.6818 40.1545 12.1277 39.6946 11.6677L36.1572 8.13033C35.6972 7.67037 35.1431 7.32618 34.5402 7.11652V11.1497C34.5402 12.3288 35.4961 13.2847 36.6752 13.2847H40.7084Z" fill="currentColor" />
                <path d="M25.183 19.8517C24.9312 19.9559 24.6953 20.1103 24.4906 20.315L18.0855 26.7201C17.2518 27.5539 17.2518 28.9057 18.0855 29.7395C18.9193 30.5732 20.2711 30.5732 21.1049 29.7395L23.8653 26.9791V36.7699C23.8653 37.949 24.8212 38.9049 26.0003 38.9049C27.1794 38.9049 28.1353 37.949 28.1353 36.7699V26.9791L30.8957 29.7395C31.7294 30.5732 33.0813 30.5732 33.915 29.7395C34.7488 28.9057 34.7488 27.5539 33.915 26.7201L27.51 20.315C26.8809 19.686 25.9569 19.5315 25.183 19.8517Z" fill="currentColor" />
              </svg>
              <span class="form__type">PNG, GIF, WEBP, MP4 or MP3. Max 1Gb.</span>
              <input type="file" ref="image" class="input-reset form__field-upload" required @change="handleFileUpload">
            </div>
            <a @click="store.cheackAuth()" class="btn-reset main-button form__btn">Upload</a>
          </div>

        </form>
      </div>



      <div class="sell__auth" v-else>
        <p class="sell__text">Чтобы иметь право публиковать NFT необходимо стать автором!</p>
        <p v-if="hasSubmittedAuthorship" class="sell__text">Вы уже подали заявку на авторство. Ожидайте решения администрации.</p>
        <router-link v-else :to="{ name: 'authorship'}" class="main-button sell__btn">Я ХОЧУ СТАТЬ АВТОРОМ!</router-link>
      </div>



    </div>
  </section>
</template>

<style scoped lang="scss">
 .sell{
   margin-top: 155px;
   margin-bottom: 210px;
   &__container{
     display: flex;
     flex-direction: column;
     align-items: center;
   }
   &__title{
     margin-bottom: 153px;
   }
   &__content{
     width: 100%;
   }
   &__auth{
     display: flex;
     flex-direction: column;
     align-items: flex-start;
   }
   &__text{
     margin: 0;
     margin-bottom: 10px;
     font-family: var(--font-family);
     font-weight: 400;
     font-size: 20px;
     line-height: 125%;
     color: #000000;
   }
   &__btn{
      padding: 20px;
   }
 }

 .form{
   max-width: 100%;
   display: grid;
   grid-template-columns: repeat(12, 1fr);
   gap: 30px;
   &__left{
     display: flex;
     flex-direction: column;
     grid-column: 7 span;
     row-gap: 35px;
   }
   &__row{
     display: flex;
     flex-direction: row;
     align-items: center;
     gap: 35px;
   }
   &__row-sec{
     display: flex;
   }
   &__content{
     padding-bottom: 20px;
     display: flex;
     flex-direction: column;
     gap: 20px;
     position: relative;
     .form__error{
       position: absolute;
       bottom: 0;
       left: 0;
       font-family: var(--font-family);
       font-weight: 400;
       font-size: 13px;
       line-height: 125%;
       color: #ff0000;
       z-index: 111111111;
     }
   }
   &__content-row{
     flex-direction: row;
   }
   &__content-checkbox{
     display: flex;
     align-items: center;
     justify-content: space-between;
     &:not(:last-child){
       margin-top: 70px;
     }
   }
   &__title{
     margin: 0;
     font-family: var(--font-family);
     font-weight: 500;
     font-size: 20px;
     line-height: 125%;
     color: #000;
   }
   &__field{
     padding: 23px 26px;
     max-width: 700px;
     min-width: 150px;
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
   &__field-split{
     border-right: 1px solid #efefef; /* Граница между select и input */
     border-radius: 12px 0 0 12px; /* Убираем правый радиус */
     position: relative;
   }
   &__field-split:last-child{
     border-right: 1px solid #efefef; /* Граница между select и input */
     border-radius: 0 12px 12px 0;/* Убираем правый радиус */
   }
   &__field-line{
     min-width: 100px !important;
   }
   &__line{
     position: absolute;
     top: 58px;
     left: 100px;
     width: 1px;
     height: 39px;
     background-color: #dadada;
     z-index: 11;
   }
   &__svg{
     position: absolute;
     top: 65px;
     right: 26px;
     z-index: 10;
   }
   &__arrow{
     position: absolute;
     top: 73px;
     right: 26px;
     z-index: 10;
   }
   &__arrow-2{
     left: 60px;
   }
   &__text-content{
     display: flex;
     flex-direction: column;
     gap: 12px;
   }
   &__text{
     margin: 0;
     font-family: var(--font-family);
     font-weight: 400;
     font-size: 13px;
     line-height: 125%;
     color: #9596a6;
   }

   &__right{
     margin-top: 40px;
     grid-column: 5 span;
     display: flex;
     flex-direction: column;
     gap: 57px;
   }
   &__upload{
     padding: 148px 144px;
     display: flex;
     flex-direction: column;
     align-items: center;
     justify-content: center;
     gap: 13px;
     box-shadow: 0 82px 82px -61px rgba(15, 15, 15, 0.1), 0 -82px 80px 0 rgba(0, 0, 0, 0.05);
     background: #fcfcfd;
     position: relative;
     cursor: pointer;
     z-index: 10;
   }
   &__field-upload{
     position: absolute;
     inset: 0;
     opacity: 0; /* Скрываем input */
     cursor: pointer;
     z-index: 1;
   }
   &__type{
     max-width: 178px;
     font-family: var(--font-family);
     font-weight: 400;
     font-size: 15px;
     line-height: 167%;
     text-align: center;
     color: #777e90;
   }
   &__btn{
     margin: 0 auto;
     max-width: 327px;
     padding: 20px 135px;
     border-radius: 16px;
   }
   &__btn-create{
     max-width: 100%;
     margin: 0;
     margin-top: 110px;
   }
 }
</style>