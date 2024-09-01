<template>
<div class="col-lg-3 responsive-column-l">
<div class="icon-box icon-layout-2 dashboard-icon-box dashboard--icon-box pb-0" :class="cardColor" >
<div class="d-flex pb-3 justify-content-between">
    <div class="info-content">
    <p class="info__desc">{{ cardTitle }}</p>
    <h4 class="info__title">KES {{ cardAmount }}</h4>
    </div>
    <!-- end info-content -->
    <div class="info-icon icon-element bg-white text-color-2">
    <i class="la " :class="cardIcon" ></i>
    </div>
    <!-- end info-icon-->
</div>
<div class="section-block"></div>
<router-link :to="{name:cardRoute}" class="d-flex align-items-center justify-content-between view-all">View Details <i class="la la-arrow-right"></i></router-link>
</div>
</div>
</template>
<script setup>

const props=defineProps({
    cardTitle: String,
    cardAmount: Number,
    cardRoute:String,
    cardColor: String,
    cardIcon: String,
})
</script>