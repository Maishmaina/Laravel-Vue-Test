<template>
    <div style="height: 15vh;"></div>
<div class="single-content-box">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="single-content-wrap padding-top-60px">
                <div id="description" class="page-scroll">
                  <div class="single-content-item pb-4">
                    <h3 class="title font-size-26">
                      3 Days Tour: {{ tour.name }}
                    </h3>
                    <div class="d-flex flex-wrap align-items-center pt-2">
                      <p class="me-2">{{ tour.destinations?.name }}</p>
                    </div>
                  </div>
                  <!-- end single-content-item -->
                  <div class="section-block"></div>
                  <div class="single-content-item py-4">
                    <div class="row">
                      <div class="col-lg-4 responsive-column">
                        <div class="single-tour-feature d-flex align-items-center mb-3">
                          <div class="single-feature-icon icon-element ms-0 flex-shrink-0 me-3">
                            <i class="la la-clock-o"></i>
                          </div>
                          <div class="single-feature-titles">
                            <h3 class="title font-size-15 font-weight-medium">
                              Duration
                            </h3>
                            <span class="font-size-13">3 Days</span>
                          </div>
                        </div>
                        <!-- end single-tour-feature -->
                      </div>
                      <!-- end col-lg-4 -->
                      <div class="col-lg-4 responsive-column">
                        <div class="single-tour-feature d-flex align-items-center mb-3">
                          <div class="single-feature-icon icon-element ms-0 flex-shrink-0 me-3">
                            <i class="la la-users"></i>
                          </div>
                          <div class="single-feature-titles">
                            <h3 class="title font-size-15 font-weight-medium">
                              Group Size
                            </h3>
                            <span class="font-size-13">{{ tour.slots }} People</span>
                          </div>
                        </div>
                        <!-- end single-tour-feature -->
                      </div>

                      <div class="col-lg-4 responsive-column">
                        <div class="single-tour-feature d-flex align-items-center mb-3">
                          <div class="single-feature-icon icon-element ms-0 flex-shrink-0 me-3">
                            <i class="la la-child"></i>
                          </div>
                          <div class="single-feature-titles">
                            <h3 class="title font-size-15 font-weight-medium">
                              Remaining slots
                            </h3>
                            <span class="font-size-13">{{ available_slot}} People</span>
                          </div>
                        </div>
                        <!-- end single-tour-feature -->
                      </div>
                      <!-- end col-lg-4 -->
                      <div class="col-lg-4 responsive-column">
                        <div class="single-tour-feature d-flex align-items-center mb-3">
                          <div class="single-feature-icon icon-element ms-0 flex-shrink-0 me-3">
                            <i class="la la-calendar"></i>
                          </div>
                          <div class="single-feature-titles">
                            <h3 class="title font-size-15 font-weight-medium">
                              Date
                            </h3>
                            <span class="font-size-13">Jan 19' - Dec 21'</span>
                          </div>
                        </div>
                        <!-- end single-tour-feature -->
                      </div>
                   
                      <!-- end col-lg-4 -->
                      <div class="col-lg-4 responsive-column">
                        <div class="single-tour-feature d-flex align-items-center mb-3">
                          <div class="single-feature-icon icon-element ms-0 flex-shrink-0 me-3">
                            <i class="la la-plane"></i>
                          </div>
                          <div class="single-feature-titles">
                            <h3 class="title font-size-15 font-weight-medium">
                              Pickup From
                            </h3>
                            <span class="font-size-13">Airport</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="section-block"></div>
                  <div class="single-content-item padding-top-40px padding-bottom-40px">
                    <h3 class="title font-size-20">Description</h3>
                    <p class="py-3">
                      {{ tour.description }}
                    </p>
                    <p class="pb-4">
                      {{ tour.destinations?.description }}
                    </p>
            
                  </div>
                  <!-- end single-content-item -->
                  <div class="section-block"></div>
                </div>
                         
                <!-- end faq -->
                <div id="location-map" class="page-scroll">
                  <div class="single-content-item padding-top-40px padding-bottom-40px">
                    <h3 class="title font-size-20">Location</h3>
                    <div class="gmaps padding-top-30px">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d1021193.6145398908!2d35.25200455661496!3d-1.1335166838343225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x182ced340e0926ff%3A0xf11b680298c8c545!2sMasai%20Mara%20National%20Reserve%2C%20Kenya!3m2!1d-1.2482106!2d35.011966799999996!4m5!1s0x182f10d6c4f0f09d%3A0xfcea546bb215a4b0!2sNairobi%20Serena%20Hotel%2C%20Nairobi%20City%2C%20Kenya!3m2!1d-1.2870297!2d36.8145232!5e0!3m2!1sen!2sin!4v1725076164261!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                  </div>
                  <div class="section-block"></div>
                </div>
              </div>
              <!-- end single-content-wrap -->
            </div>
            <!-- end col-lg-8 -->
            <div class="col-lg-4">
              <div class="sidebar single-content-sidebar mb-0">
                <div class="sidebar-widget single-content-widget">
                  <div class="sidebar-widget-item">
                    <div class="sidebar-book-title-wrap mb-3">
                      <h3>Bestseller</h3>
                      <p>
                        <span class="text-form">From</span><span class="text-value ms-2 me-1"> KES {{ tour.price }} /=</span>
                     
                      </p>
                    </div>
                  </div>
                 
                  <div class="sidebar-widget-item">
                    <div class="qty-box mb-2 d-flex align-items-center justify-content-between">
                      <label class="font-size-16">Slots <span>{{available_slot}} Available</span></label>
                      <div class="qtyBtn d-flex align-items-center">
                        <div class="qtyDec" @click.prevent="slotCounter('minus',available_slot,tour.price)"><i class="la la-minus"></i></div>
                        <input 
                        type="text" 
                        name="qtyInput" 
                        v-model="booking_slot">
                        <div class="qtyInc" @click.prevent="slotCounter('add',available_slot,tour.price)"><i class="la la-plus"></i></div>
                      </div>

                      
                    </div>
                  </div>
                  <div class="sidebar-book-title-wrap mb-3">
                 
                      <p v-show="sum_amount_payable !==0">
                        <span class="text-form">Totals</span><span class="text-value ms-2 me-1"> KES {{ sum_amount_payable.toFixed(2) }} /=</span>
                      </p>
                    </div>
                  <!-- end sidebar-widget-item -->
                  <div class="btn-box pt-2">
                    <button @click.prevent="submitDetails" class="theme-btn text-center w-100 mb-2"><i class="la la-shopping-cart me-2 font-size-18"></i>Book
                      Now</button>
                    <div class="d-flex align-items-center justify-content-between pt-2">
                      
                    </div>
                  </div>
                </div>               
                <!-- end sidebar-widget -->
                <div class="sidebar-widget single-content-widget">
                  <h3 class="title stroke-shape">Get a Question?</h3>
                  <p class="font-size-14 line-height-24">
                    Do not hesitate to give us a call. We are an expert team and
                    we are happy to talk to you.
                  </p>
                  <div class="sidebar-list pt-3">
                    <ul class="list-items">
                      <li>
                        <i class="la la-phone icon-element me-2"></i><a href="#">+ 254 12 1234 1234</a>
                      </li>
                      <li>
                        <i class="la la-envelope icon-element me-2"></i><a href="mailto:admin@gmail.com">admin@gmail.com</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>
<script setup lang="ts">
 import { ref,onMounted,computed } from "vue";
 import {  useRoute,useRouter } from "vue-router";
 import { useUserStore } from "@/stores/userStore";
 const { user_config } = useUserStore();

 const route = useRoute();
 const router = useRouter();

 let destination=route.params.destination;
 let tour_id=route.params.tour_id;

 if(destination==null || tour_id==null){
    router.push({name: 'tours'});
 }

 let booking_slot:int=ref(0);
 let sum_amount_payable:float=ref(0);

 const slotCounter=(type, available_slot:int,amount)=>{
    console.log(type+available_slot);
    if(available_slot>=1){
        if(type=='add' && available_slot>booking_slot.value){
            booking_slot.value++;

            sum_amount_payable.value=(amount*booking_slot.value);

        }

        if(type=='minus' && booking_slot.value<=available_slot){
             if(booking_slot.value>=1){
                booking_slot.value--;
                sum_amount_payable.value=(amount*booking_slot.value);
             }
        }
    }
 }


 const processing = ref(true);

const tour = ref({});



const fetchTour = async () => {
    processing.value=true;
  let response = null;
  try {
    response = await axios.get(`get-tour/${tour_id}`);
  } catch (error) {
    response = error.response;
  }
    
  if (response.status == 200) {
    tour.value = response.data;

    processing.value = false;
  } else {
    toast.error("Error fetching Tour");
  }
};
const available_slot = computed(() => {
            return tour.value.slots-tour.value.total_slots;
        });


  const submitDetails=async()=>{

  } 


onMounted(()=>{
    fetchTour()
})
</script>