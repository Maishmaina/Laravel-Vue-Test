<template>
<section class="blog-area section--padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-heading">
              <h2 class="sec__title curve-shape padding-bottom-30px" data-text="curvs">
               Popular tour in this month
              </h2>
            </div>
          </div>
        </div>
        <div class="row padding-top-50px">
          
        <tour_card v-for="tour,i in tours.data" :key="i" :tour="tour"/>
        </div>
      </div>
    </section>
</template>
<script setup>
import { onMounted,ref} from "vue";
import tour_card from './tour_card.vue';

const processing = ref(true);

const tours = ref([]);

const fetchTours = async (page = 1) => {
    processing.value=true;
  let response = null;
  try {
    response = await axios.get(`get-all-tours`, {
      params: {
        page
      }
    });
  } catch (error) {
    response = error.response;
  }

  if (response.status == 200) {
    tours.value = response.data;
    processing.value = false;
  } else {
    toast.error("Error fetching Tours list");
  }
};

onMounted(()=>{
    fetchTours()  
})
</script>