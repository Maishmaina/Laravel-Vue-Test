<template>
    <div class="col-lg-4 responsive-column">
            <div class="card-item trending-card mb-0">
                <div class="card-img">
                  <router-link :to="{name:'tours_details',params:{destination:tour.destinations.slug,tour_id:tour.id}}" class="d-block">
                    <img src="/assets/images/tour_home.jpg" alt="Destination-img">
                  </router-link>
                  <span class="badge">Featured</span>
                </div>
                <div class="card-body">
                  <h3 class="card-title mb-0">
                    <router-link :to="{name:'tours_details',params:{destination:tour.destinations.slug,tour_id:tour.id}}">{{ tour.name }}</router-link>
                  </h3>
                  <div class="card-rating">
                    <span class="la la-map-marker form-icon"></span>
                    <span class="rating__text">{{ tour.destinations.name }}</span>
                  </div>
                  <div class="card-price d-flex align-items-center justify-content-between">
                    <span><i class="la la-clock me-1"></i>6 Days</span>
                    <p>
                      <span class="price__from">from</span>
                      <span class="price__num"> KES {{ tour.price }}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
</template>
<script setup>

const props = defineProps({
    tour: Object,
});
</script>