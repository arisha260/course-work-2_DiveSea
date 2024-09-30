<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/authStore'; // подключите store
import router from '@/router';
import { useForm, useField } from 'vee-validate';
import * as yup from 'yup';

// Управление вкладками (1 - Login, 2 - Registration)
const activeTab = ref(1);
const authStore = useAuthStore(); // Инициализация store

// === Валидация для формы авторизации ===
const loginFormSchema = yup.object({
  email: yup.string().required('Email is required').email('Invalid email format'),
  password: yup.string().required('Password is required').min(8, 'Password must be at least 8 characters'),
});

const { handleSubmit: handleLoginSubmit, errors: loginErrors } = useForm({
  validationSchema: loginFormSchema,
});

const { value: loginEmail, errorMessage: loginEmailError } = useField('email');
const { value: loginPassword, errorMessage: loginPasswordError } = useField('password');

// Состояние для хранения ошибок с сервера
const loginServerError = ref('');

// Функция для обработки логина
const handleLogin = handleLoginSubmit(async () => {
  try {
    loginServerError.value = ''; // Очистка ошибок перед новой попыткой
    await authStore.login(loginEmail.value, loginPassword.value);
    router.push({ name: 'home' });
  } catch (error) {
    loginServerError.value = error.response?.data?.message || 'Login failed'; // Отображение ошибки с сервера
  }
});

// === Валидация для формы регистрации ===
const registerFormSchema = yup.object({
  name: yup.string().required('Name is required').max(255),
  email: yup.string().required('Email is required').email('Invalid email format'),
  password: yup.string().required('Password is required').min(8, 'Password must be at least 8 characters'),
  passwordConfirm: yup.string().required('Password is required').min(8, 'Password must be at least 8 characters'),
});

const { handleSubmit: handleRegisterSubmit, errors: registerErrors} = useForm({
  validationSchema: registerFormSchema,
});

const { value: registerName, errorMessage: registerNameError } = useField('name');
const { value: registerEmail, errorMessage: registerEmailError } = useField('email');
const { value: registerPassword, errorMessage: registerPasswordError } = useField('password');
const { value: registerPasswordConfirm, errorMessage: registerPasswordConfirmError } = useField('passwordConfirm');

// Состояние для хранения ошибок с сервера
const registerServerError = ref('');

// Функция для обработки регистрации
const handleRegistration = handleRegisterSubmit(async () => {
  try {
    registerServerError.value = ''; // Очистка ошибок перед новой попыткой
    await authStore.register(registerName.value, registerEmail.value, registerPassword.value, registerPasswordConfirm.value);
    activeTab.value = 1;
  } catch (error) {
    registerServerError.value = error.response?.data?.message || 'Registration failed'; // Отображение ошибки с сервера
  }
});
</script>

<template>
  <section class="auth">
    <div class="container auth__container">
      <RouterLink :to="{ name: 'discover' }" class="auth__back">
        <svg width="5" height="10" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M8.39523 0.953926C8.99428 1.55298 8.99428 2.52423 8.39523 3.12328L4.11103 7.40747L8.39523 11.6917C8.99428 12.2907 8.99428 13.262 8.39523 13.861C7.79618 14.4601 6.82493 14.4601 6.22588 13.861L0.857002 8.49215C0.257952 7.8931 0.257952 6.92185 0.857002 6.3228L6.22588 0.953926C6.82493 0.354876 7.79618 0.354876 8.39523 0.953926Z" fill="#23262F" />
        </svg>
        To Home
      </RouterLink>
      <h1 class="main-title auth__title">Authorization</h1>
      <div class="auth__nav">
        <button class="btn-reset auth__btn" @click="activeTab = 1" :class="{ activeBtn: activeTab === 1 }">
          Login
        </button>
        <button class="btn-reset auth__btn" @click="activeTab = 2" :class="{ activeBtn: activeTab === 2 }">
          Registration
        </button>
      </div>

      <!-- Форма логина -->
      <form class="auth__form form" v-if="activeTab === 1" @submit.prevent="handleLogin">
        <div class="form__content">
          <label for="loginEmail" class="form__title">Email</label>
          <input type="email" class="form__field" id="loginEmail" v-model="loginEmail" placeholder="enter email" required />
          <span class="form__error" v-if="loginEmailError">{{ loginEmailError }}</span>
        </div>
        <div class="form__content">
          <label for="loginPassword" class="form__title">Password</label>
          <input type="password" class="form__field" id="loginPassword" v-model="loginPassword" placeholder="password" required />
          <span class="form__error" v-if="loginPasswordError">{{ loginPasswordError }}</span>
        </div>
        <!-- Отображение ошибок с сервера -->
        <span v-if="loginServerError" class="form__server-error">Invalid username or password!</span>
        <button type="submit" class="btn-reset main-button form__btn">Login</button>
      </form>

      <!-- Форма регистрации -->
      <form class="auth__form form" v-if="activeTab === 2" @submit.prevent="handleRegistration">
        <div class="form__content">
          <label for="registerName" class="form__title">Name</label>
          <input type="text" class="form__field" id="registerName" v-model="registerName" placeholder="enter your name" required />
          <span class="form__error" v-if="registerNameError">{{ registerNameError }}</span>
        </div>
        <div class="form__content">
          <label for="registerEmail" class="form__title">Email</label>
          <input type="email" class="form__field" id="registerEmail" v-model="registerEmail" placeholder="enter email" required />
          <span class="form__error" v-if="registerEmailError">{{ registerEmailError }}</span>
        </div>
        <div class="form__content">
          <label for="registerPassword" class="form__title">Password</label>
          <input type="password" class="form__field" id="registerPassword" v-model="registerPassword" placeholder="password" required />
          <span class="form__error" v-if="registerPasswordError">{{ registerPasswordError }}</span>
        </div>
        <div class="form__content">
          <label for="registerPasswordConfirm" class="form__title">Password Confirmation</label>
          <input type="password" class="form__field" id="registerPasswordConfirm" v-model="registerPasswordConfirm" placeholder="password" required />
          <span class="form__error" v-if="registerPasswordConfirmError">{{ registerPasswordConfirmError }}</span>
        </div>
        <!-- Отображение ошибок с сервера -->
        <div v-if="registerServerError" class="form__server-error">Ошибки с сервера</div>
        <button type="submit" class="btn-reset main-button form__btn">Register</button>
      </form>

    </div>
  </section>
</template>

<style scoped lang="scss">
.auth{
  margin-top: 150px;
  &__container {
    max-width: 500px;
    padding: 30px;
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
  }
  &__nav{
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    align-items: flex-start;
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
    max-width: 350px;
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
</style>