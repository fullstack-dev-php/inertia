<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
  visits: Object
});

const visitList = ref(props.visits.data);
const currentPage = ref(1);
const lastPage = ref(props.visits.last_page);

const loadMore = () => {
  if (currentPage.value < lastPage.value) {
    currentPage.value++;

    axios
      .get(route('visits.load_more'), { params: { page: currentPage.value } })
      .then(response => {
        visitList.value.push(...response.data.data); // Thêm dữ liệu mới
        
      })
      .catch(error => {
        console.error("Lỗi tải dữ liệu:", error);
      });
  }
};
</script>

<template>
  <div>
    <div v-for="visit in visitList" :key="visit.id">
      <p>Giá: {{ visit.price }}{{ visit.name }}</p>
    </div>
    <button v-if="currentPage < lastPage" @click="loadMore">Xem thêm</button>
  </div>
</template>
