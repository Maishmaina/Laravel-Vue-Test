<template>
    <TabularTemplate
        resource="Destination"
        :fetched-data="destinations"
        :processing="processing"
        :filter="filter"
        add-permission="create destinations"
        @add-clicked="showAddModal"
        @searching="searching"
        @clear-filters="clearFilters"
        @filter-clicked="showFilterModal"
    >
        <template #thead>
            <th>Destination Name</th>
            <th>Destination Slug</th>
            <th>Description.</th>
            <th>Number of Tours</th>
            <th>Date Created</th>
            <th class="text-end" v-if="permissions.includes('edit destinations') || permissions.includes('delete destinations')">Actions</th>
        </template>

        <template #tbody>
            <template v-if="destinations.data.length">
                <tr v-for="destination in destinations.data">
                    <td>{{ destination.name }}</td>
                    <td>{{ destination.slug }}</td>
                    <td>{{ destination.description }}</td>
                    <td>{{ destination.tours_count }}</td>
                    <td>{{ moment(destination.created_at).format('MMMM Do YYYY') }}</td>
                    
                    <td class="text-end" v-if="permissions.includes('delete destinations')">
                        <div class="btn-group" > 
                        <button  type="button" class="btn btn-sm btn-icon btn-primary" @click.prevent="edit_destination(destination)" >
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-icon btn-danger" @click="deleteDestination(destination.id)" v-if="permissions.includes('delete destinations')">
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
            <Pagination :data="destinations" @pagination-change-page="fetchDestination" :limit="5" />
        </template>
    </TabularTemplate>

    <Modal id="add-modal" :title="edit_id==null?'Add Destination':'Edit Destination'">
        <template #modal-body>
            <div class="form-group">
                <label for="name" class="required form-label">Destination Name</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.name}"
                    id="name"
                    placeholder="Enter Destination name"
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

const destinations = ref({})

const search = ref('')

const searching = (value) => {
    search.value = value
}

const filters = ref({
    name: '',
    description: '',
})

const fetchDestination = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`admin/destinations`, {
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
        destinations.value = response.data
        processing.value = false
    } else {
        toast.error("Error fetching list")
    }

}

onMounted(() => {
    fetchDestination()
})


const showAddModal = () => {
    $('#add-modal').modal('show')
    clearForm()
}
const edit_id=ref(null);

const edit_destination=(data)=>{
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
    let message_respo="Destination added successfully";

    let response = null
    try {
        if(edit_id.value==null){
            response = await axios.post('admin/destinations', form.value, config)
        }else{
        response = await axios.put(`admin/destinations/${edit_id.value}`, form.value, config)
        message_respo="Destination edited successfully";

        }
    } catch (error) {
        response = error.response
    }

    if (response.status == 201 || response.status == 200) {
        toast.success(message_respo)
        clearForm()
        $('#add-modal .btn-sm').click()
        fetchDestination()
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

    await fetchDestination()

    filter.value = true
}



const clearFilters = async () => {
    processing.value = true

    filters.value.name = ''
    filters.value.description = ''

    await fetchDestination()

    filter.value = false
}

watch(() => search.value, throttle(() => {
    fetchDestination()
}, 600))

const deleteDestination = (id) => {
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
                response = await axios.delete(`admin/destinations/${id}`, config)
            } catch (error) {
                response = error.response
                toast.error("Error deleting ")
            }

            if (response.status == 200) {
                Swal.fire(
                    'Deleted!',
                    'Destination has been deleted.',
                    'success'
                )
                processing.value = true

                fetchDestination()
            }
        }
    })
}

</script>

<style scoped></style>
