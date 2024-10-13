<script setup>
  import TableBody from '@/components/table/TableBody.vue'
</script>

<template>
  <table class="top-collection__table table">
    <thead>
    <tr>
      <th class="table__col">Collection</th>
      <th class="table__col">Volume</th>
      <th class="table__col">24h %</th>
      <th class="table__col">Floor Price</th>
      <th class="table__col">Owners</th>
      <th class="table__col">Items</th>
    </tr>
    </thead>
    <tbody>
      <TableBody img="/cards__recent-1.png" alt="recent img" name="Alex Ca." nickname="By Alex" volume="8,456" percents="+ 27.78%"
      price="3,5" owners="2.2K" items="500"/>
      <TableBody img="/cards__recent-2.png" alt="recent img" name="Alex Ca." nickname="By Alex" volume="4,780" percents="+ 27.78%"
                 price="7,9" owners="3.4K" items="900"/>
      <TableBody img="/cards__recent-1.png" alt="recent img" name="Alex Ca." nickname="By Alex" volume="8,456" percents="+ 27.78%"
                 price="3,5" owners="2.2K" items="500"/>
      <TableBody img="/cards__recent-2.png" alt="recent img" name="Alex Ca." nickname="By Alex" volume="4,780" percents="+ 27.78%"
                 price="7,9" owners="3.4K" items="900"/>
    </tbody>
  </table>
</template>

<style lang="scss">
.table {
  width: 100%;
  max-width: 1247px;
  border-collapse: collapse; /* Убираем промежутки между ячейками, чтобы границы были сплошными */
  &__col {
    text-align: left;
    font-family: var(--font-family);
    font-weight: 500;
    font-size: 22px;
    line-height: 130%;
    letter-spacing: 0.01em;
    color: #93989a;
    @media (max-width: 1200px) {
      font-size: 15px;
    }
  }

  &__item {
    padding: 48px 0 39px 0 !important;
    text-align: left;
    @media (max-width: 1200px) {
      padding: 34px 0 27px 0 !important;
    }
  }

  &__row {
    border-bottom: 1.69px solid #ebe9e9; /* Сплошная линия между строками */
  }
  &__author{
    display: flex;
    flex-direction: row;
    gap: 24px;
    @media (max-width: 1200px) {
      gap: 16px;
    }
  }
  &__img{
    border: 3.50px solid #fff;
    border-radius: 1751px;
    @media (max-width: 1200px) {
      width: 59px;
      height: 59px;
    }
  }
  &__price{
    margin-left: 30px;
  }
}
</style>