<template>
    <TabularTemplate
        resource="Bookings"
        :fetched-data="bookings"
        :processing="processing"
        :filter="filter"
        add-permission="create booking"
        @add-clicked="showAddModal"
        @searching="searching"
        @clear-filters="clearFilters"
        @filter-clicked="showFilterModal"
    >
        <template #thead>
            <th>Tour </th>
            <th>Destination</th>
            <th>Booked by</th>
            <th>Slot booked</th>
            <th>Amount Paid(KES)</th>
            <th>Status</th>
            <th>Tour day</th>
            <th>Booked on</th>
            <th class="text-end" v-if="permissions.includes('edit bookings') || permissions.includes('delete bookings')">Actions</th>
        </template>

        <template #tbody>
            <template v-if="bookings.data.length">
                <tr v-for="booking in bookings.data">
                    <td>{{ booking.tours.name }}</td>
                    <td>{{ booking.tours.destinations.name }}</td>
                    <td>{{ booking.users.full_name }}</td>
                    <td>{{ booking.slots }}</td>
                    <td>{{ booking.amount }}</td>
                    <td>
                        <span class="badge text-white py-1 px-2" :class="booking.status==0?'text-bg-primary' : booking.status==1?'text-bg-success':'text-bg-danger'" >{{ booking.status==0?'Pending':booking.status==1?'Approved':'Canceled' }}</span>
                    </td>
                    <td>{{ moment(booking.tours.start_date).format('MMMM Do YYYY') }}</td>
                    <td>{{ moment(booking.created_at).format('MMMM Do YYYY') }}</td>
                    <td class="text-end" v-if="permissions.includes('delete bookings')">
                        <div class="btn-group" > 
                        <button  type="button" title="view ticket" class="btn btn-sm btn-icon btn-success" @click.prevent="showTicketModal(booking)" >
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button  type="button" title="edit status" class="btn btn-sm btn-icon btn-primary" @click.prevent="edit_booking(booking)" >
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-danger" @click="deleteBooking(booking.id)" v-if="permissions.includes('delete bookings')">
                            <i class="fa-solid fa-trash"></i>
                        </button></div> 
                    </td>
                </tr>
            </template>
            <tr v-else>
                <td colspan="7" class="text-center">No data available</td>
            </tr>
        </template>

        <template #pagination>
            <Pagination :data="bookings" @pagination-change-page="fetchBookings" :limit="5" />
        </template>
    </TabularTemplate>

    <Modal id="add-modal" title="Update Booking">
        <template #modal-body>
            <div class="form-group">
                <label for="role" class="required form-label">Update Booking Status</label>
                <select class="form-select form-select-solid" id="role" v-model="form.status" :readonly="processing">
                    <option value="">Select status...</option>
                    <option value="0">Pending</option>
                    <option value="1">Approved</option>
                    <option value="2">Canceled</option>
                   
                </select>
            </div>
          
        </template>

        <template #modal-footer>
            <button type="button" class="btn btn-primary" @click="submitForm">
                <span class="indicator-label" v-if="!processing">
                    Submit
                </span>
                <span class="indicator-progress d-block" v-else>
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </template>
    </Modal>
    <Modal id="print-modal" title="View Ticket">
        <template #modal-body>
             <!-- Modal Body -->
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
          
        </template>

        <template #modal-footer>
            <button type="button" class="btn btn-primary" @click="print_ticket">
                <span class="indicator-label">
                    Print Ticket
                </span>
              
            </button>
        </template>
    </Modal>

</template>

<script setup>
import moment from 'moment'
import Swal from 'sweetalert2'
import throttle from 'lodash/throttle'
import { toast } from 'vue3-toastify';
import { onMounted, ref, watch } from 'vue'
import { useAuthStore } from '@/stores/authStore.js'
import { Bootstrap5Pagination as Pagination } from 'laravel-vue-pagination';
import TabularTemplate from '@/components/TabularTemplate.vue'
import Modal from '@/components/Modal.vue'

const { token, permissions } = useAuthStore()

const config = {
    headers: {
        Authorization: `Bearer ${token}`
    }
}

const processing = ref(true)

const bookings = ref({})

const search = ref('')

const searching = (value) => {
    search.value = value
}


const fetchBookings = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`admin/bookings`, {
            ...config,

            params: {
                page,
                search: search.value
            }
        })
    } catch (error) {
        response = error.response
    }

    if (response.status == 200) {
        bookings.value = response.data
        processing.value = false
    } else {
        toast.error("Error fetching list")
    }

}

onMounted(() => {
    fetchBookings()
})


const showAddModal = () => {
    $('#add-modal').modal('show')
    clearForm()
}

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
    console.log(data);
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


const edit_booking=(data)=>{
    showAddModal()
    form.value.id=data.id;
    form.value.tour_id=data.tour_id;
    form.value.amount=data.amount
    form.value.status=data.status
}

const errors = ref({})

const form = ref({
    id:'',
    tour_id: '',
    amount: '',
    status: '',
})

const clearForm = () => {
    form.value.id = ''
    form.value.tour_id = ''
    form.value.amount = ''
    form.value.status=''
}

const submitForm = async () => {
    errors.value = {}
    processing.value = true
    
    let response = null
  
    try {
        
        response = await axios.put(`admin/bookings/${form.value.id}`, form.value, config)
        
    } catch (error) {
        response = error.response
    }

    if (response.status == 201 || response.status == 200) {
        toast.success("Booking status updated successfully")
        clearForm()
        $('#add-modal .btn-sm').click()
        fetchBookings()
    } else if (response.status == 422) {
        toast.error("Error adding")
        errors.value = response.data.errors

        processing.value = false
    }
}

const filter = ref(false)

const showFilterModal = () => {
    $('#filter-modal').modal('show')
}


watch(() => search.value, throttle(() => {
    fetchBookings()
}, 600))

const deleteBooking = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            let response = null
            try {
                response = await axios.delete(`admin/bookings/${id}`, config)
            } catch (error) {
                response = error.response
                toast.error("Deleting User Bookings is prohibited, Contact Admin")
            }

            if (response.status == 200) {
                Swal.fire(
                    'Deleted!',
                    'Bookings has been deleted.',
                    'success'
                )
                processing.value = true

                fetchBookings()
            }
        }
    })
}

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
