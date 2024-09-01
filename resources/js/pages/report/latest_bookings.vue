<template>
  <div class="form-box dashboard-card">
                  <div class="form-title-wrap">
                    <div class="d-flex justify-content-between align-items-center">
                      <h3 class="title">Latest Bookings</h3>
                    </div>
                  </div>
                  <div class="form-content p-0">
                    <div class="list-group drop-reveal-list">
                      <router-link :to="{name: 'bookings-list'}" v-for="latest,i in bookings.data" class="list-group-item list-group-item-action border-top-0">
                        <div class="msg-body d-flex align-items-center">
                          <div class="msg-content w-50">
                            <h3 class="title pb-1"><b>Name:</b> {{ latest.users.full_name }}</h3>
                            <p class="msg-text"><b>Tour Date:</b> {{ latest.tours.start_date }}</p>
                            
                          </div>
                          <p>
                            <b>Location:</b> {{ latest.tours.destinations.name }}
                          </p>
                        </div>
                        <p class="msg-content w-50"></p>
                        <p>
                            <b>Tour Title:</b> {{ latest.tours.name }}
                        </p>
                      </router-link>
                    </div>
                  </div>
                </div>
</template>
<script setup>

import { toast } from 'vue3-toastify';
import { onMounted, ref } from 'vue'
import { useAuthStore } from '@/stores/authStore.js'


const { token } = useAuthStore()

const config = {
    headers: {
        Authorization: `Bearer ${token}`
    }
}

const processing = ref(true)

const bookings = ref({})


const fetchBookings = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`admin/bookings`, {
            ...config,

            params: {
                page
            }
        })
    } catch (error) {
        response = error.response
    }

    if (response.status == 200) {
        bookings.value = response.data
       
        processing.value = false
    }
    console.log(bookings.value);

}

onMounted(() => {
    fetchBookings()
})

</script>