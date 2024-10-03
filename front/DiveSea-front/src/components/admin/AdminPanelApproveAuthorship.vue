<script setup>
  import AdminPanelApproveAuthorshipCard from '@/components/admin/AdminPanelApproveAuthorshipCard.vue'
  import { useAuthorshipStore } from '@/stores/Authorship/authorshipStore.js'
  import { storeToRefs } from 'pinia'
  import MainHollow from '@/components/MainHollow.vue'
  import { onMounted } from 'vue'

  const store = useAuthorshipStore();
  const { authorships, loader } = storeToRefs(store)

  // const approveNft = async () => {
  //   const formData = new FormData();
  //
  //   if (currentAuthorship.value) {
  //     formData.append('description', currentAuthorship.value.description);
  //     formData.append('author_id', currentAuthorship.value.user.id);
  //   }
  //   await store.sendApprovedNft(currentNft.value.id, formData);
  //   handleClose();
  // }

  onMounted(() => {
    store.getApprovedAuthorship();
  });
</script>

<template>
  <div class="admin-authorship">
    <div class="container admin-authorship__container">
      <div class="loader admin-authorship__loader" v-if="loader"></div>

      <div class="admin-authorship__content" v-if="!loader && authorships && authorships.length > 0">
<!--        <AdminPanelApproveAuthorshipCard class="admin-authorship__card" v-for="(card, index) in authorships" :key="index" :name="card.user.name" :reason="card.reason" />-->
        <div class="admin-authorship__card approve-authorship-card" v-for="(card, index) in authorships" :key="index">
          <p class="approve-authorship-card__text title">Authorship for confirmation from the user: <span class="approve-authorship-card__name">{{ card.user.name }}</span></p>
          <p class="approve-authorship-card__text">Reason: {{ card.reason }}</p>
          <div class="approve-authorship-card__btns">
            <button @click.prevent="store.approveAuthorship(card.id)" class="btn-reset main-button approve-authorship-card__btn approve-authorship-card__accept">Accept</button>
            <button @click.prevent="store.rejectNft(card.id)" class="btn-reset main-button approve-authorship-card__btn approve-authorship-card__denial">Denial</button>
          </div>
        </div>
      </div>
      <MainHollow v-else-if="authorships.length === 0 && !loader" />

    </div>
  </div>
</template>

<style scoped lang="scss">
  .admin-authorship{
    &__container{
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    &__content {
      display: grid;
      grid-template-columns: repeat(12, 1fr);
      align-items: center;
      justify-content: center;
      gap: 30px;
    }
    &__card{
      grid-column: 5 span;
    }
    &__loader{
      margin: 300px auto;
    }

    .approve-authorship-card{
      padding: 10px;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      flex-grow: 1;
      gap: 10px;
      background-color: #fff;
      border-radius: 23px;
      box-shadow: 39px 12px 59px 0 rgba(199, 199, 199, 0.6);
      position: relative;
      transition: all .3s ease;
      @media (hover: hover) {
        &:hover{
          transform: translateY(-5px);
        }
      }
      &__text{
        margin: 0;
        margin-top: auto;
        font-family: var(--font-family);
        font-weight: 600;
        font-size: 16px;
        line-height: 140%;
        color: #686868;
      }
      &__name{
        text-decoration: underline;
      }
      &__btns{
        display: flex;
        align-items: center;
        gap: 20px;
      }
      &__btn{
        padding: 10px;
      }
    }
    .title{
      font-size: 20px;
      color: #000000;
    }
  }
</style>