<script setup>
import { useAuthorshipStore } from '@/stores/Authorship/authorshipStore.js'
import { storeToRefs } from 'pinia'

const store = useAuthorshipStore();
const { currentAuthorship } = storeToRefs(store)

defineProps({
  name: String,
  reason: String,
})

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

const emit = defineEmits(['approve', 'reject'])

// Функция для уведомления родительского компонента о закрытии
const approveAuthorship = () => {
  emit('approve')
}

</script>

<template>
  <div class="approve-authorship-card">
    <p class="approve-authorship-card__text title">Authorship for confirmation from the user: <span class="approve-authorship-card__name">{{ name }}</span></p>
    <p class="approve-authorship-card__text">Reason: {{ reason }}</p>
    <div class="approve-authorship-card__btns">
      <button @click.prevent="approveAuthorship()" class="btn-reset main-button approve-authorship-card__btn approve-authorship-card__accept">Accept</button>
      <button @click.prevent="store.rejectNft(currentAuthorship)" class="btn-reset main-button approve-authorship-card__btn approve-authorship-card__denial">Denial</button>
    </div>
  </div>
</template>

<style scoped lang="scss">
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
</style>