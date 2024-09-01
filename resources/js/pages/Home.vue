<template>
   <div class="dashboard-content-wrap">
        <div class="dashboard-bread dashboard-bread-2">
          <div class="container-fluid">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <div class="breadcrumb-content">
                  <div class="section-heading">
                    <h2 class="sec__title font-size-30 text-white">
                      Dashboard
                    </h2>
                  </div>
                </div>
                <!-- end breadcrumb-content -->
              </div>
             
              <!-- end col-lg-6 -->
            </div>
            <!-- end row -->
            <div class="row mt-4">
                <TopTotalsCard
                card-color="bg-4"
                card-icon="la-shopping-cart"
                :total-count="all_total_reports.bookings"
                card-title="Total Bookings"
                card-route-name="bookings-list"
                />
                <TopTotalsCard
                card-color="bg-3"
                card-icon="la-star"
                :total-count="all_total_reports.destinations"
                card-title="All Destinations"
                card-route-name="destination-list"
                />
                <TopTotalsCard
                card-color="bg-2"
                card-icon="la-bookmark-o"
                :total-count="all_total_reports.tours"
                card-title="All Tours"
                card-route-name="tours-list"
                />
                <TopTotalsCard
                card-color="bg-1"
                card-icon="la-users"
                :total-count="all_total_reports.users"
                card-title="All Users"
                card-route-name="users-list"
                />
            </div>
          </div>
        </div>
        <div class="dashboard-main-content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-7 responsive-column--m">
                <MonthlyTourEarning/>
                <!-- end form-box -->
              </div>
              <div class="col-lg-5 responsive-column--m">
              <LatestBookings/>
                <!-- end form-box -->
              </div>
              <div class="col-lg-12">
                <div class="form-box dashboard-card">
                  <div class="form-title-wrap">
                    <h3 class="title">
                      Total Amount  Processed {{ sum_total_collected.total_payment }}
                    </h3>
                  </div>
                  <div class="form-content">
                    <div class="row">
                    <AmountCollectedCard
                    card-title="All Received"
                    :card-amount="sum_total_collected.total_payment"
                    card-route="bookings-list"
                    card-color="bg-1"
                    card-icon="la-hotel"
                    />

                    <AmountCollectedCard
                    card-title="Pending Confirm"
                    :card-amount="sum_total_collected.pending_payment"
                    card-route="bookings-list"
                    card-color="bg-2"
                    card-icon="la-car"
                    />

                    <AmountCollectedCard
                    card-title="Amount Received"
                    :card-amount="sum_total_collected.received_payment"
                    card-route="bookings-list"
                    card-color="bg-3"
                    card-icon="la-ship"
                    />

                    <AmountCollectedCard
                    card-title="Canceled Bookings Amount"
                    :card-amount="sum_total_collected.rejected_payment"
                    card-route="bookings-list"
                    card-color="bg-4"
                    card-icon="la-plane"
                    />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>

<script setup>
import { toast } from 'vue3-toastify';
import { onMounted, ref, watch } from 'vue'
import { useAuthStore } from '@/stores/authStore.js'    
import TopTotalsCard from './report/top_totals_card.vue';
import MonthlyTourEarning from './report/monthly_tour_earning.vue';
import LatestBookings from './report/latest_bookings.vue';
import AmountCollectedCard from './report/amount_collected_card.vue';

const { token } = useAuthStore()

const config = {
    headers: {
        Authorization: `Bearer ${token}`
    }
}

const all_total_reports = ref([])
const sum_total_collected=ref([])

const fetchTopReport = async () => {
    let response = null
    try {
        response = await axios.get(`admin/top-totals-report`, {
            ...config,
        })
    } catch (error) {
        response = error.response
    }
   
    if (response?.status == 200) {
        all_total_reports.value = response.data
    
    } else {
        toast.error("Error fetching list")
    }

}


const fetchSumCollected = async () => {
    let response = null
    try {
        response = await axios.get(`admin/totals-earning-collection`, {
            ...config,
        })
    } catch (error) {
        response = error.response
    }
   
    if (response?.status == 200) {
      sum_total_collected.value = response.data
    
    } else {
        toast.error("Error fetching list")
    }

}

onMounted(() => {
    fetchTopReport()
    fetchSumCollected()
})

</script>

<style lang="scss" scoped></style>
