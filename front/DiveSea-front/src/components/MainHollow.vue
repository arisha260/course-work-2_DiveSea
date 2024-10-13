<script setup>

</script>

<template>
 <div class="hollow">
   <pre>
    <p class="hollow__text">
      ой ой
      Здесь пока ничего нет
      :(
    </p>
   </pre>
 </div>
</template>

<style scoped lang="scss">
  .hollow{
    margin: 25px 0;
    &__text{
      font-family: var(--font-family);
      font-weight: 500;
      font-size: 20px;
      line-height: 160%;
      letter-spacing: 0.02em;
      text-transform: capitalize;
      text-align: justify;
      color: #141416;
      @media (max-width: 1200px) {
        font-size: 16px;
      }
    }
  }
</style>