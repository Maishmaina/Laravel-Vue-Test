<template>
    <TabularTemplate
        resource="Tour"
        :fetched-data="tours"
        :processing="processing"
        :filter="filter"
        add-permission="create tours"
        @add-clicked="showAddModal"
        @searching="searching"
        @clear-filters="clearFilters"
        @filter-clicked="showFilterModal"
    >
        <template #thead>
            <th>Tour Name</th>
            <th>Destination Name</th>
            <th>Description.</th>
            <th>NO. of Slot</th>
            <th>Booked Slot</th>
            <th>Price</th>
            <th>Pick-up Place</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Date Created</th>
            <th class="text-end" v-if="permissions.includes('edit tours') || permissions.includes('delete tours')">Actions</th>
        </template>

        <template #tbody>
            <template v-if="tours.data.length">
                <tr v-for="tour in tours.data">
                    <td>{{ tour.name }}</td>
                    <td>{{ tour.destinations.name }}</td>
                    <td>{{ tour.description }}</td>
                    <td>{{ tour.slots }}</td>
                    <td>{{ tour.total_slots }}</td>
                    <td>{{ tour.price }}</td>
                    <td>{{ tour.pickup_place }}</td>
                    <td>{{ moment(tour.start_date).format('MMMM Do YYYY') }}</td>
                    <td>{{ moment(tour.end_date).format('MMMM Do YYYY') }}</td>
                    <td>{{ moment(tour.created_at).format('MMMM Do YYYY') }}</td>
                    
                    <td class="text-end" v-if="permissions.includes('delete tours')">
                        <div class="btn-group" > 
                        <button  type="button" class="btn btn-sm btn-icon btn-primary" @click.prevent="edit_tour(tour)" >
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-danger" @click="delete_tour(tour.id)" v-if="permissions.includes('delete tours')">
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
            <Pagination :data="tours" @pagination-change-page="fetchTour" :limit="5" />
        </template>
    </TabularTemplate>

    <Modal id="add-modal" :title="edit_id==null?'Add Tour':'Edit Tour'">
        <template #modal-body>
            <div class="form-group">
                <label for="name" class="required form-label">Tour Name</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.name}"
                    id="name"
                    placeholder="Enter Tour name"
                    v-model="form.name"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.name">
                    <small>{{ errors.name[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="required form-label">Description</label>
                <textarea type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.description}"
                    id="description"
                    placeholder="Enter Description"
                    v-model="form.description"
                    :readonly="processing"
                    rows="10"
                ></textarea>
                <div class="invalid-feedback" v-if="errors.description">
                    <small>{{ errors.description[0] }}</small>
                </div>
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

const tours = ref({})

const search = ref('')

const searching = (value) => {
    search.value = value
}

const filters = ref({
    name: '',
    description: '',
})

const fetchTour = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`admin/tours`, {
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
        console.log(response.data);
        tours.value = response.data
        processing.value = false
    } else {
        toast.error("Error fetching list")
    }

}

onMounted(() => {
    fetchTour()
})


const showAddModal = () => {
    $('#add-modal').modal('show')
    clearForm()
}
const edit_id=ref(null);

const edit_tour=(data)=>{
    showAddModal()
    form.value.name=data.name;
    form.value.description=data.description
    edit_id.value=data.id

}

const errors = ref({})

const form = ref({
    name: '',
    description: '',
    phone_number: '',
})

const clearForm = () => {
    form.value.name = ''
    form.value.description = ''
    edit_id.value=null
}

const submitForm = async () => {
    errors.value = {}
    processing.value = true
    let message_respo="Tour added successfully";

    let response = null
    try {
        if(edit_id.value==null){
            response = await axios.post('admin/tours', form.value, config)
        }else{
        response = await axios.put(`admin/tours/${edit_id.value}`, form.value, config)
        message_respo="Tour edited successfully";

        }
    } catch (error) {
        response = error.response
    }

    if (response.status == 201 || response.status == 200) {
        toast.success(message_respo)
        clearForm()
        $('#add-modal .btn-sm').click()
        fetchTour()
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

const filterUsers = async () => {
    $('#filter-modal .btn-sm').click()

    processing.value = true

    await fetchTour()

    filter.value = true
}



const clearFilters = async () => {
    processing.value = true

    filters.value.name = ''
    filters.value.description = ''

    await fetchTour()

    filter.value = false
}

watch(() => search.value, throttle(() => {
    fetchTour()
}, 600))

const delete_tour = (id) => {
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
                response = await axios.delete(`admin/tours/${id}`, config)
            } catch (error) {
                response = error.response
                toast.error("Error deleting ")
            }

            if (response.status == 200) {
                Swal.fire(
                    'Deleted!',
                    'Tour has been deleted.',
                    'success'
                )
                processing.value = true

                fetchTour()
            }
        }
    })
}

</script>

<style scoped></style>
