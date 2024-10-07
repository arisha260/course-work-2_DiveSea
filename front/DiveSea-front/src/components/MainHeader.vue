<script setup>
  import { ref, watch, onMounted, onBeforeUnmount } from 'vue';
  import { useNftStore } from '@/stores/Nft';
  import { storeToRefs } from 'pinia';
  import { debounce } from 'lodash';
  import { useAuthStore } from '@/stores/authStore.js'

  const store = useNftStore()
  const AuthStore = useAuthStore()
  const { isLoadingSearch, authorSearch, nftsSearch } = storeToRefs(store);
  const query = ref('');
  const showSearchResults = ref(false);
  const searchResultsRef = ref(null);
  const { user, isAdmin} = storeToRefs(AuthStore);

  // Метод для обработки ввода
  const onInput = async () => {
    if (query.value.length > 0) {
      await store.search(query.value); // Выполняем поиск по введенному запросу
      showSearchResults.value = true;
    }
  };

  // Дебаунсинг метода поиска
  const debouncedSearch = debounce(async () => {
    if (query.value.length > 0) {
      isLoadingSearch.value = true; // Устанавливаем флаг поиска
      await store.search(query.value);
      isLoadingSearch.value = false; // Снимаем флаг поиска после завершения
    }
  }, 300); // Задержка в миллисекундах

  watch(query, () => {
    if (query.value.length === 0) {
      store.clearSearchResults(); // Очистка результатов поиска при пустом вводе
    } else {
      debouncedSearch(); // Запуск дебаунсинга поиска
    }
  });

  // Функция для закрытия блока с результатами
  const closeSearchResults = () => {
    showSearchResults.value = false;
  };

  // Обработчик нажатия клавиши Esc
  const handleKeyDown = (event) => {
    if (event.key === 'Escape') {
      closeSearchResults();
    }
  };

  // Обработчик клика вне блока
  const handleClickOutside = (event) => {
    if (searchResultsRef.value && !searchResultsRef.value.contains(event.target)) {
      closeSearchResults();
    }
  };

  const handleLogout = async () => {
    try{
      await AuthStore.logout();
    } catch (error) {
      console.log("При выходе с аккаунта возникла какая то ошибка", error)
    }
  }

  onMounted(() => {
    document.addEventListener('keydown', handleKeyDown);
    document.addEventListener('click', handleClickOutside);
  });

  onBeforeUnmount(() => {
    document.removeEventListener('keydown', handleKeyDown);
    document.removeEventListener('click', handleClickOutside);
  });
</script>

<template>
  <header class="header">
    <div class="container header__container">
      <RouterLink :to="{ name: 'home' }"><img src="/logo-header.png" alt="Header logo" class="header__logo" width="53" height="53" /></RouterLink>
      <nav class="nav">
        <ul class="list-reset nav__list">
          <li class="nav__item"><RouterLink :to="{ name: 'discover' }" class="nav__link">Discover</RouterLink></li>
          <li class="nav__item"><RouterLink :to="{ name: 'creators' }" class="nav__link">creators</RouterLink></li>
          <li class="nav__item"><RouterLink :to="{ name: 'sell' }" class="nav__link">Sell</RouterLink></li>
          <li class="nav__item"><RouterLink :to="{ name: 'stats' }" class="nav__link">stats</RouterLink></li>
          <li v-if="isAdmin" class="nav__item"><RouterLink :to="{ name: 'admin-panel' }" class="nav__link">Admin</RouterLink></li>
        </ul>
      </nav>
      <div class="header__search">
        <img src="/header-search.png" alt="Лупа" width="21" height="21">
        <input
          v-model="query"
          @input="onInput"
          type="text"
          class="header__search-input input-reset"
          placeholder="Search Art Work / Creator"
          @focus="showSearchResults = true"
        />

        <!-- Выпадающий блок с результатами поиска -->
        <div v-if="showSearchResults && query.length > 0" class="search-results" ref="searchResultsRef">
          <ul class="list-reset search-results__list">
            <h4 class="search-results__title">NFT</h4>
            <li class="search-results__item" v-for="(res, index) in nftsSearch" :key="index">
              <router-link class="search-results__link" :to="{ name: 'discover.show', params: {id: res.id} }">{{ res.title }}</router-link>
            </li>
            <p v-if="!isLoadingSearch && nftsSearch.length === 0" class="search-results__error">Ничего не найдено!</p>
          </ul>

          <ul class="list-reset search-results__list">
            <h4 class="search-results__title">Authors</h4>
            <li class="search-results__item" v-for="(res, index) in authorSearch" :key="index">
              <router-link class="search-results__link" :to="{ name: 'creators.show', params: {id: res.id} }"> {{ res.name }}</router-link>
            </li>
            <p v-if="!isLoadingSearch && authorSearch.length === 0" class="search-results__error">Ничего не найдено!</p>
          </ul>

          <!-- Показать лоудер, когда идет поиск -->
          <div class="loader search-results__loader" v-if="isLoadingSearch"></div>
        </div>
      </div>
<!--      <a class="header__connect main-button">Connect Wallet</a>-->

      <div class="header__profile-container" v-if="user">
<!--        <RouterLink :to="{ name: 'profile', params: {user: user }">-->
        <div class="header__row">
          <RouterLink :to="{ name: 'profile', params: {user_name: user.name }}">
            <svg width="24px" class="header__svg" height="24px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-420.000000, -2159.000000)" fill="currentColor"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M374,2009 C371.794,2009 370,2007.206 370,2005 C370,2002.794 371.794,2001 374,2001 C376.206,2001 378,2002.794 378,2005 C378,2007.206 376.206,2009 374,2009 M377.758,2009.673 C379.124,2008.574 380,2006.89 380,2005 C380,2001.686 377.314,1999 374,1999 C370.686,1999 368,2001.686 368,2005 C368,2006.89 368.876,2008.574 370.242,2009.673 C366.583,2011.048 364,2014.445 364,2019 L366,2019 C366,2014 369.589,2011 374,2011 C378.411,2011 382,2014 382,2019 L384,2019 C384,2014.445 381.417,2011.048 377.758,2009.673" id="profile-[#1335]"> </path> </g> </g> </g> </g></svg>
          </RouterLink>
          <button class="btn-reset" type="submit" @click="handleLogout()">
            <svg width="24" class="header__svg" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M10 17L15 12L10 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M15 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
        <p class="header__balance">balance: {{ user.balance ? user.balance : 0 }}</p>
      </div>

      <div class="header__profile-container" v-else>
        <!-- Если пользователь не авторизован, показываем ссылку на регистрацию -->
        <RouterLink :to="{ name: 'login'}">
          <svg width="24px" class="header__svg" height="24px" viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>profile [#1335]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-420.000000, -2159.000000)" fill="currentColor"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M374,2009 C371.794,2009 370,2007.206 370,2005 C370,2002.794 371.794,2001 374,2001 C376.206,2001 378,2002.794 378,2005 C378,2007.206 376.206,2009 374,2009 M377.758,2009.673 C379.124,2008.574 380,2006.89 380,2005 C380,2001.686 377.314,1999 374,1999 C370.686,1999 368,2001.686 368,2005 C368,2006.89 368.876,2008.574 370.242,2009.673 C366.583,2011.048 364,2014.445 364,2019 L366,2019 C366,2014 369.589,2011 374,2011 C378.411,2011 382,2014 382,2019 L384,2019 C384,2014.445 381.417,2011.048 377.758,2009.673" id="profile-[#1335]"> </path> </g> </g> </g> </g></svg>
        </RouterLink>
      </div>
    </div>
  </header>
</template>

<style lang="scss" scoped>
  .header{
    padding-top: 45px;
    &__container {
      display: flex;
      align-items: center;
    }
    &__search{
      margin-left: auto;
      max-width: 348px;
      padding-left: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: nowrap;
      border-radius: 14px;
      background-color: #ededed;
      img{
        margin-right: 25px;
        user-select: none;
        pointer-events: none;
        -webkit-user-drag: none;
        user-drag: none;
      }
    }
    &__search-input{
      padding: 18px 80px 18px 0;
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 15px;
      line-height: 117%;
      letter-spacing: -0.02em;
      background-color: #ededed;
      border-radius: 14px;
      outline: none;
      position: relative;
      &::placeholder {
        color: #c2c3cb;
      }
    }
    &__connect{
      margin-left: 30px;
      padding: 16px 24px;
      max-width: 200px;
    }
    &__profile-container{
      margin-left: 20px;
      display: flex;
      align-items: flex-start;
      flex-direction: column;
    }
    &__svg{
      color: #606060;
    }
    &__row{
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 20px;
    }
    &__balance{
      margin: 0;
      margin-bottom: 5px;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 14px;
      line-height: 140%;
      color: #141416;
    }
  }

  .nav{
    margin-left: 60px;
    &__list{
      gap: 53px;
    }
    &__link{
      text-transform: uppercase;
      color: #606060;
      transition: color .2s ease;
      &:focus{
        outline: none;
      }
      &:hover{
        color: #000;
      }
      &:active{
        color: #353535;
      }
    }
  }

  .search-results {
    position: absolute;
    width: 400px;
    max-height: 400px;
    top: 102px;
    right: 25.6%;
    border-radius: 12px;
    box-shadow: 18px 18px 61px 0 rgba(0, 0, 0, 0.12);
    background: #fafafa;
    z-index: 1000;
    overflow-y: auto;
    padding: 10px;
    &__title{
      margin: 0;
      margin-bottom: 5px;
      font-family: var(--font-family);
      font-weight: 600;
      font-size: 21px;
      line-height: 140%;
      color: #141416;
    }
    &__link{
      display: block;
      font-family: var(--font-family);
      font-weight: 400;
      font-size: 16px;
      line-height: 153%;
      color: rgba(136, 136, 136, 0.7);
      border-bottom: 1px solid rgba(136, 136, 136, 0.7);
      padding: 8px 12px;
      cursor: pointer;
      transition: background-color 0.3s;
      &:hover {
        background-color: #f0f0f0;
      }
    }
    &__list {
      padding: 20px;
      display: flex;
      flex-direction: column;
      }
    &__error{
      margin: 0;
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 16px;
      line-height: 160%;
      letter-spacing: 0.02em;
      text-transform: capitalize;
      text-align: justify;
      color: #141416;
      }
    }

</style>
