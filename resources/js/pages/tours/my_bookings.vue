<template>
<div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-box">
                  <div class="form-title-wrap">
                    <div class="d-flex align-items-center justify-content-between">
                      <div>
                    
                      </div>
                      <span>Total Bookings
                        <strong class="color-text">({{bookings.total}})</strong></span>
                    </div>
                  </div>
                  <div class="form-content">
                    <div class="table-form table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Location</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Execution Date</th>
                            <th scope="col">Slots</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody v-if="bookings?.data?.length">
                          <tr v-for="(book,i) in bookings.data" :key="i">
                            <th scope="row">
                              {{ i+1 }}
                            </th>
                            <td>
                              <div class="table-content">
                                <h3 class="title">{{ book.tours.name }}</h3>
                              </div>
                            </td>
                            <td>{{ book.tours.destinations.name }}</td>
                            <td>{{ date_format(book.created_at) }}</td>
                            <td>{{ date_format(book.created_at) }}</td>
                            <td>{{ book.slots }} People</td>
                            <td>KES {{ book.amount }}</td>
                            <td>
                              <span class="badge text-white py-1 px-2" :class="book.status==0?'text-bg-info' : book.status==1?'text-bg-primary':'text-bg-danger'" >{{ book.status==0?'Pending':book.status==1?'Approved':'Canceled' }}</span>
                            </td>
                            <td>
                              <div class="group-button">
                                <button class="btn btn-primary btn-sm">
                                  Ticket
                                </button> &nbsp;<button class="btn btn-danger btn-sm">
                                  Cancel
                                </button>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
          </div>
</template>
<script setup>

import { ref,onMounted,computed } from "vue";
 import {  useRoute,useRouter } from "vue-router";
 import { useUserStore } from "@/stores/userStore";
 import { toast } from "vue3-toastify";
 const { user_config,user } = useUserStore();

 const route = useRoute();
 const router = useRouter();

 if(user==null){
    router.push({name: 'tours'});
 }

 const processing = ref(true);

const bookings = ref([]);



const fetchMyBookings = async () => {
    processing.value=true;
  let response = null;
  try {
    response = await axios.get(`customer-booking`,user_config);
  } catch (error) {
    response = error.response;
  }

  if (response.status == 200) {
    bookings.value = response.data;

    processing.value = false;
  } else {
    // toast.error("Error fetching Tour");
  }
};
const date_format=(in_date)=>{
    const date = new Date(in_date);
const formattedDate = date.toLocaleDateString('en-GB');
return formattedDate;
}
onMounted(()=>{
    fetchMyBookings()
})
</script>