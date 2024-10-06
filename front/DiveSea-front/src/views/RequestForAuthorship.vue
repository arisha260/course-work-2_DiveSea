<script setup>
  import { ref } from 'vue';
  import { useAuthorshipStore } from '@/stores/Authorship/authorshipStore.js'
  import { useAuthStore } from '@/stores/authStore.js'
  import { useValidStore } from '@/stores/Authorship/validStore.js'
  import { storeToRefs } from 'pinia'

  const store = useAuthorshipStore();
  const authStore = useAuthStore();
  const validStore = useValidStore();
  const { user } = storeToRefs(authStore)

  const reason = ref(null);
  const reasonError = ref(null);
  const error = ref(null);
  const isSubmitted = ref(false);
  // Переменная, контролирующая состояние раскрытия списка
  const isListVisible = ref(false);
  // Функция для переключения видимости списка
  const toggleListVisibility = () => {
    isListVisible.value = !isListVisible.value;
  };

  const sendApprovedAuthorship = async () => {
    if (!validStore.validateForm(reason, reasonError)) {
      return; // Если форма не прошла валидацию, не отправляем
    }
    const formData = new FormData();
    formData.append('reason', reason.value);
    formData.append('user_id', user.value.id);
    try{
      await store.sendApprovedAuthorship(formData);
      console.log('Данные отправлены: ', formData)
      reason.value = null;
      error.value = null; // Очищаем ошибку, если все прошло успешно
      isSubmitted.value = true; // Устанавливаем флаг успешной отправки
    } catch (error){
      error.value = error.data || 'Ошибка при отправке данных';
      console.log('При отправке подтверждения на авторство произошла ошибка: ', error)
      isSubmitted.value = false;
    }
  }

</script>

<template>
  <section class="authorship">
      <div class="container authorship__container">
        <RouterLink :to="{ name: 'discover' }" class="authorship__back">
          <svg width="5" height="10" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39523 0.953926C8.99428 1.55298 8.99428 2.52423 8.39523 3.12328L4.11103 7.40747L8.39523 11.6917C8.99428 12.2907 8.99428 13.262 8.39523 13.861C7.79618 14.4601 6.82493 14.4601 6.22588 13.861L0.857002 8.49215C0.257952 7.8931 0.257952 6.92185 0.857002 6.3228L6.22588 0.953926C6.82493 0.354876 7.79618 0.354876 8.39523 0.953926Z" fill="#23262F" />
          </svg>
          To Home
        </RouterLink>
        <h1 class="main-title authorship__title">Submitting an application for authorship</h1>
        <!-- Форма логина -->
        <p class="authorship__more-info" @click="toggleListVisibility">How it works?
          <svg width="15px" height="15px" class="authorship__svg" :class="{ activeSvg: isListVisible }" viewBox="0 -4.5 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" stroke-width="0.6"></g><g id="SVGRepo_iconCarrier"><g id="Page-1" stroke="currentColor" stroke-width="1" fill="currentColor" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-180.000000, -6684.000000)" fill="currentColor"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M144,6525.39 L142.594,6524 L133.987,6532.261 L133.069,6531.38 L133.074,6531.385 L125.427,6524.045 L124,6525.414 C126.113,6527.443 132.014,6533.107 133.987,6535 C135.453,6533.594 134.024,6534.965 144,6525.39" id="arrow_down-[#339]"> </path> </g> </g> </g> </g></svg>
        </p>
        <transition name="slide-fade">
          <ol class="authorship__list list" v-if="isListVisible">
            <li class="list__item">Leave a request.</li>
            <li class="list__item">Your application will be reviewed by the administrator.</li>
            <li class="list__item">If the administrator accepts your application for authorship, you will receive an email notification.</li>
          </ol>
        </transition>
        <form class="authorship__form form" @submit.prevent="sendApprovedAuthorship">
          <div class="form__content">
            <textarea type="textarea" class="form__field" id="authorshipLetter" v-model="reason" placeholder="Write why you want become authorship" required />
            <span class="form__error" v-if="reasonError">{{ reasonError }}</span>
          </div>
          <span v-if="error" class="form__server-error">{{ error }}</span>
          <button type="submit" class="btn-reset main-button form__btn">Send</button>
        </form>
      </div>

    <div class="overlay" v-if="isSubmitted"></div>

    <div class="authorship__done" v-if="isSubmitted">
      <h4 class="main-title authorship__title-sec">Data send!</h4>
      <p class="authorship__text">The data has been sent. The answer with the result will be sent to your email.</p>
      <router-link :to="{ name: 'home' }"><button class="btn-reset main-button authorship__btn-sec">Ok!</button></router-link>
    </div>

    </section>
</template>

<style scoped lang="scss">
.authorship{
  margin-top: 150px;
  position: relative;
  &__container {
    max-width: 700px;
    padding: 25px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 31px;
    box-shadow: 0 82px 82px -61px rgba(15, 15, 15, 0.1), 0 -82px 80px 0 rgba(0, 0, 0, 0.05);
    background: #fcfcfd;
  }
  &__form{
    max-width: 100%;
    margin-top: 30px;
  }
  &__back{
    align-self: flex-start;
    font-family: var(--font-family);
    font-weight: 500;
    font-size: 14px;
    line-height: 125%;
    color: #000;
  }
  &__title{
    margin-top: 30px;
    margin-bottom: 50px;
    text-align: center;
  }
  &__btn{
    grid-column: 6 span;
    padding-bottom: 15px;
    font-family: var(--font-family);
    font-weight: 700;
    font-size: 16px;
    line-height: 153%;
    text-align: center;
    color: #d2d2d2;
  }
  &__more-info{
    align-self: flex-start;
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 16px;
    line-height: 125%;
    color: #000;
    text-align: left;
  }
  &__svg{
    transition: all .3s;
  }

  &__done{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 300px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 31px;
    box-shadow: 0 82px 82px -61px rgba(15, 15, 15, 0.1), 0 -82px 80px 0 rgba(0, 0, 0, 0.05);
    background: #fcfcfd;
    z-index: 1001;
  }
  &__title-sec{
    margin-bottom: 20px;
  }
  &__text{
    margin: 0;
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 16px;
    line-height: 125%;
    color: #000;
  }
  &__btn-sec{
    margin-top: 20px;
    padding: 10px 20px;
  }
}

.form{
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: 30px;
  &__content{
    padding-bottom: 20px;
    grid-column: 12 span;
    display: flex;
    flex-direction: column;
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
  &__field{
    padding: 23px 26px;
    max-width: 600px;
    min-width: 600px;
    min-height: 200px;
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
    grid-column: 12 span;
    padding: 20px 40px;
    border-radius: 16px;
  }
  &__server-error{
    grid-column: 12 span;
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 13px;
    line-height: 125%;
    color: #ff0000;
  }
}

.activeBtn{
  font-family: var(--font-family);
  font-weight: 700;
  font-size: 16px;
  line-height: 153%;
  color: #000;
  border-bottom: 4px solid #141416;
}

.list{
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 10px;
  &__item{
    font-family: var(--font-family);
    font-weight: 400;
    font-size: 16px;
    line-height: 125%;
    color: #000;
  }
}

/* CSS-анимация */
.slide-fade-enter-active, .slide-fade-leave-active {
  transition: all 0.3s ease;
}

.slide-fade-enter, .slide-fade-leave-to /* .slide-fade-leave-active in Vue 3 */ {
  opacity: 0;
  transform: translateY(-10px); /* Начальная/конечная позиция */
}
.activeSvg{
  transform: rotate(-180deg);
}
</style>