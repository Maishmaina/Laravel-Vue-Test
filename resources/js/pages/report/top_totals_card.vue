<template>
<div class="col-lg-3 responsive-column-l">
                <div class="icon-box icon-layout-2 dashboard-icon-box pb-0">
                  <div class="d-flex pb-3 justify-content-between">
                    <div class="info-content">
                      <p class="info__desc">{{ cardTitle }}</p>
                      <h4 class="info__title">{{ totalCount }}</h4>
                    </div>
                    <!-- end info-content -->
                    <div class="info-icon icon-element" :class="cardColor">
                      <i class="la " :class="cardIcon" ></i>
                    </div>
                    <!-- end info-icon-->
                  </div>
                  <div class="section-block"></div>
                  <router-link :to="{name:cardRouteName}" class="d-flex align-items-center justify-content-between view-all">View All <i class="la la-angle-right"></i></router-link>
                </div>
              </div>
</template>
<script setup>
const props=defineProps({
    cardColor: String,
    cardIcon: String,
    totalCount: Number,
    cardTitle: Object,
    cardRouteName:String,
})
</script>
<style>

</style>