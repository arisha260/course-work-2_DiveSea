import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios';
axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;


export const useNftStore = defineStore('nft', () => {
  const nft = ref(null);
  const nfts = ref([]);
  const isLoading = ref(false);
  const currentPage = ref(1);
  const hasMore = ref(true);
  const totalNfts = ref(null);
  const authorWorks = ref([]);
  const authors = ref([]);
  const author = ref(null);
  const stringSearch = ref([]);
  const authorSearch = ref([]);
  const nftsSearch = ref([]);
  const isLoadingSearch = ref(false); // Флаг загрузки для поиска
  const loaderMain = ref(false); // Флаг загрузки для общего контента
  const errors = ref(null);

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

  const getNft = async () => {
    isLoading.value = true;
    try {
      const res = await axios.get('/api/home');
      nfts.value = res.data.data || res.data;
      totalNfts.value = res.data.total_count;
      console.log(nfts, totalNfts)
    } catch (error) {
      console.error('Ошибка при получении данных:', error);
    } finally {
      isLoading.value = false;
    }
  };

  const loadMore = async () => {
    if (!hasMore.value || isLoading.value) return; // Проверка на наличие данных и защиту от повторных запросов
    try {
      isLoading.value = true;
      loaderMain.value = true;
      const response = await axios.get(`/api/home/load-more?page=${currentPage.value}`);
      const { data, nextPage } = response.data;

      // Добавляем новые данные к уже загруженным
      nfts.value = [...nfts.value, ...data];

      // Если больше страниц нет, отключаем кнопку
      if (!nextPage) {
        hasMore.value = false;
        loaderMain.value = false;
      }

      currentPage.value++; // Увеличиваем номер страницы для следующего запроса
    } catch (error) {
      console.error('Ошибка при загрузке данных:', error);
    } finally {
      isLoading.value = false;
      loaderMain.value = false;
    }
  };

  const showNft = async (id) => {
    // Проверяем, есть ли данные в nfts и содержат ли они нужный объект
    if (nfts.value.length > 0) {
      const cachedNft = nfts.value.find(nftItem => nftItem.id == id);

      if (cachedNft) {
        // Если данные найдены в кеше, используем их
        console.log("Найден кешированный элемент:", cachedNft);
        nft.value = cachedNft;
        return; // Возвращаемся, чтобы избежать загрузки с сервера
      }
    }
    console.log("Элемент не найден в кеше, загружаем с сервера...");
    //ВСЕ ЧТО ВЫШЕ В МЕТОДЕ showNft - ПРОВЕРКА НА ТО, ЕСТЬ ЛИ КАРТА В КЕШЕ


    // Если данных нет в кеше, или кеш пуст, загружаем их с сервера
    isLoading.value = true;
    try {
      const res = await axios.get(`/api/home/${id}`);
      console.log('Ответ от API:', res.data.data);
      nft.value = res.data.data;

      // Опционально добавляем данные в массив nfts, если они уникальны
      if (!nfts.value.some(n => n.id === nft.value.id)) {
        //ЕСЛИ ВООБЩЕ НЕТ НИКАКИХ СОВПАДЕНИЙ (КАК Я ПОНЯЛ)
        //ЕСЛИ some ВЕРНЕТ TRUE, ТО ТЕЛО ЦИКЛА НЕ ВЫОЛНИТСЯ И НАОБОРОТ
        //ТО ЕСТЬ ЕСЛИ some ВЕРНЕТ false, ТО false СТАНЕТ true, И НОВАЯ КАРТОЧКА ДОБАВИТСЯ В МАССИВ nfts
        nfts.value.push(nft.value);
      }

    } catch (error) {
      console.error('Ошибка при получении данных:', error);
    } finally {
      isLoading.value = false;
    }
  };

  const loadAuthorWorks = async (id) => {
    isLoading.value = true;
    authorWorks.value = [];

    // if (authorWorks.value.length > 0) {
    //   const authorWorksCache = authorWorks.value.find(nftItem => nftItem.id == id);
    //   if (authorWorksCache) {
    //     // Если данные найдены в кеше, используем их
    //     console.log("Найден кешированный элемент (автора):", authorWorksCache);
    //     authorWorks.value = authorWorksCache;
    //     return; // Возвращаемся, чтобы избежать загрузки с сервера
    //   }
    // }
    // console.log("Элемент не найден в кеше, загружаем с сервера...");

    try {
      const res = await axios.get(`/api/home/author/${id}/works`);
      authorWorks.value = res.data.data;
      console.log('Работы этого автора: ', authorWorks)
    } catch (error) {
      console.error('Ошибка при загрузке работ автора:', error);
    } finally {
      isLoading.value = false;
    }
  };

  const getAuthors = async () => {
    isLoading.value = true;

    try {
      const res = await axios.get('/api/home/authors');
      authors.value = res.data.data;
    } catch (error) {
      console.error('Ошибка при загрузке работ автора:', error);
    } finally {
      isLoading.value = false;
    }
  }

  const search = async (query) => {
    isLoadingSearch.value = true;
    authorSearch.value = [];
    nftsSearch.value = [];

    try {
      const res = await axios.get('/api/home/search', { params: { query }});
      authorSearch.value = res.data.authors;
      nftsSearch.value = res.data.nfts;
      console.log(authorSearch)
      console.log(nftsSearch)
    } catch (error) {
      console.error('Ошибка при поиске:', error);
    } finally {
      isLoadingSearch.value = false;
    }
  }

  const clearSearchResults = () => {
    authorSearch.value = [];
    nftsSearch.value = [];
  };

  const showAuthor = async (id) => {
    if (authors.value.length > 0) {
      const cachedAuthor = authors.value.find(authorItem => authorItem.id == id);

      if (cachedAuthor) {
        console.log("Найден кешированный автор:", cachedAuthor);
        author.value = cachedAuthor;
        return;
      }
    }
    console.log("Элемент не найден в кеше, загружаем с сервера...");

    isLoading.value = true;
    try {
      const res = await axios.get(`/api/home/author/${id}`);
      console.log('Ответ от API (авторы):', res.data);
      author.value = res.data.data;
      if (!authors.value.some(n => n.id === author.value.id)) {
        authors.value.push(author.value);
      }
    } catch (error) {
      console.error('Ошибка при получении данных:', error);
    } finally {
      isLoading.value = false;
    }
  }

  const createNft = async (formData, errors) => {
    try {
      await getCsrfToken();
      const res = await axios.post(`/api/home/store`, formData);
      console.log('Данные отправлены', res.data);
    } catch (error) {
        if (error.response.status === 422) {
          console.clear(); // Очищает консоль
          console.log('Ошибка при отправке данных:', error.response.data);
          const validationErrors = error.response.data.errors;

          // Обработка ошибки для заголовка
          if (validationErrors.title) {
            errors.value = 'This is title already used. Use another title!';
          }
        } else {
        console.log('Ошибка:', error.message);
      }
    }
  };

  const cheackAuth = async () => {
    try {
      await getCsrfToken();
      const res = await axios.post(`/api/home/test`);
      console.log('Данные аутентификации', res.data);
    } catch (error) {
        console.log('Ошибка:', error.message);
      }
  };


  return { nft, nfts, isLoading, currentPage, hasMore, totalNfts, authorWorks, authors, stringSearch, authorSearch, nftsSearch, isLoadingSearch, author, loaderMain, errors,
    getNft, loadMore, showNft, loadAuthorWorks, getAuthors, search, clearSearchResults, showAuthor, createNft, cheackAuth };
});