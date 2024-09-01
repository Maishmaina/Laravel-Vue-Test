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
                                <button class="btn btn-primary btn-sm" @click.prevent="showTicketModal(book)" >
                                  View Ticket
                                </button> 
                                <!-- &nbsp;<button class="btn btn-danger btn-sm">
                                  Cancel
                                </button> -->
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

        <div class="modal fade" id="print-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">View Ticket</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body" id="ticketContent">
                  <div class="ticket-container">
                        <div class="ticket-header">
                            <h3>All-Star Tours</h3>
                            <p><strong>Title:</strong> {{print_data.tour_name }}</p>
                            <p><strong>Date:</strong> {{ moment(print_data.tour_start).format('MMMM Do YYYY') }}</p>
                            <p><strong>Time:</strong> {{ moment(print_data.tour_start).format('hh:mm:ss A') }}</p>
                        </div>

                        <div class="ticket-details">
                            <p><strong>Name:</strong> {{ print_data.tour_user_name }}</p>
                            <p><strong>Slot Booked:</strong> {{ print_data.tour_slot }}</p>
                            <p><strong>Tour To:</strong> {{ print_data.tour_place }}</p>
                            <p><strong>Meeting Point:</strong> {{ print_data.tour_meeting_point }}</p>
                            <p><strong>Ticket Number:</strong> {{ print_data.tour_ticket }}</p>
                        </div>
                        <div class="barcode">
                            <img :src="'https://barcode.tec-it.com/barcode.ashx?data='+print_data.tour_ticket + '&code=Code128&dpi=96'" alt="Barcode">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="print_ticket">
                <span class="indicator-label">
                    Print Ticket
                </span>
              
            </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>

import { ref,onMounted,computed } from "vue";
 import {  useRoute,useRouter } from "vue-router";
 import { useUserStore } from "@/stores/userStore";
 import moment from 'moment'
 const { user_config,user } = useUserStore();

 const route = useRoute();
 const router = useRouter();

 if(user==null){
    router.push({name: 'tours'});
 }

 const processing = ref(true);

const bookings = ref([]);

const print_data=ref({
    tour_name:'',
    tour_place:'',
    tour_meeting_point:'',
    tour_slot:'',
    tour_user_name:'',
    tour_start:'',
    tour_ticket:'12345',

})
const showTicketModal=(data)=>{
    
    $('#print-modal').modal('show')
    print_data.value.tour_name=data.tours.name
    print_data.value.tour_place=data.tours.destinations.name
    print_data.value.tour_meeting_point=data.tours.pickup_place
    print_data.value.tour_slot=data.slots
    print_data.value.tour_user_name=data.users.full_name
    print_data.value.tour_start=data.tours.start_date
    print_data.value.tour_ticket=data.tickets[0].ticket_no !==''?data.tickets[0].ticket_no:12345;

}

const print_ticket=()=>{

    let printContents = document.getElementById('ticketContent').innerHTML;
    let originalContents = document.body.innerHTML;
    
    document.body.innerHTML = printContents;
    
    window.print();
    
    document.body.innerHTML = originalContents;
    window.location.reload();
}




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
<style scoped>

.ticket-container {
            border: 2px solid #007bff;
            border-radius: 15px;
            padding: 20px;
            max-width: 500px;
            margin: 20px auto;
            background-color: #f8f9fa;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-header h3 {
            margin: 0;
            color: #007bff;
        }
        .ticket-details {
            margin-bottom: 20px;
        }
        .ticket-details p {
            margin: 5px 0;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
        .modal-footer {
            justify-content: center;
        }
</style>