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
                    <td>{{ tour.total_slots !=null?tour.total_slots:0 }}</td>
                    <td>{{ tour.price }}</td>
                    <td>{{ tour.pickup_place }}</td>
                    <td>{{ moment(tour.start_date).format('MMMM Do YYYY') }}</td>
                    <td>{{ moment(tour.end_date).format('MMMM Do YYYY') }}</td>
                    <td>{{ moment(tour.created_at).format('MMMM Do YYYY') }}</td>
                    
                    <td class="text-end" v-if="permissions.includes('delete tours')">
                        <div class="btn-group" > 
                        <button  title="Add Tour Images" type="button" class="btn btn-sm btn-icon btn-success" @click.prevent="add_images(tour)" >
                        <i class="fa-solid fa-add"></i>
                      </button>
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
                <label for="role" class="required form-label">Destination</label>
                <select class="form-select form-select-solid" id="role" v-model="form.destination_id" :readonly="processing">
                    <option value="">Select Destination...</option>
                    <option :value="destination.id" v-for="destination  in destinations" :key="destination.id">{{ destination.name }}</option>
                </select>
            </div>
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
                <label for="price" class="required form-label">Tour Price</label>
                <input type="number"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.price}"
                    id="price"
                    placeholder="Enter Tour Price"
                    v-model="form.price"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.price">
                    <small>{{ errors.price[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="slots" class="required form-label">Tour Slots</label>
                <input type="number"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.slots}"
                    id="slots"
                    placeholder="Enter Tour Slots"
                    v-model="form.slots"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.slots">
                    <small>{{ errors.slots[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="pickup_place" class="required form-label">Tour Pickup Place</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.pickup_place}"
                    id="pickup_place"
                    placeholder="Enter Tour Pickup Place"
                    v-model="form.pickup_place"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.pickup_place">
                    <small>{{ errors.pickup_place[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="start_date" class="required form-label">Tour Start Date</label>
                <input type="datetime-local"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.start_date}"
                    id="start_date"
                    placeholder="Enter Tour Start Date"
                    v-model="form.start_date"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.start_date">
                    <small>{{ errors.start_date[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="required form-label">Tour End Date</label>
                <input type="datetime-local"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.end_date}"
                    id="end_date"
                    placeholder="Enter Tour End Date"
                    v-model="form.end_date"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.end_date">
                    <small>{{ errors.end_date[0] }}</small>
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

    <Modal id="add-image-modal" :title="'Add Tour Images'">
        <template #modal-body>
            <el-upload 
            v-model:file-list="fileListEdit"
            :limit="10"
            :disabled="processing"
             list-type="picture-card"
             :auto-upload="false">
    <el-icon><Plus /></el-icon>

    <template #file="{ file }">
      <div>
        <img class="el-upload-list__item-thumbnail" :src="file.url" alt="" />
        <span class="el-upload-list__item-actions">
          <span
            class="el-upload-list__item-preview"
            @click="handlePictureCardPreview(file)"
          >
            <el-icon><zoom-in /></el-icon>
          </span>
          <span
            v-if="!disabled"
            class="el-upload-list__item-delete"
            @click="handleDownload(file)"
          >
            <el-icon><Download /></el-icon>
          </span>
          <span
            v-if="!disabled"
            class="el-upload-list__item-delete"
            @click="handleRemove(file)"
          >
            <el-icon><Delete /></el-icon>
          </span>
        </span>
      </div>
    </template>
  </el-upload>

  <el-dialog v-model="dialogVisible">
    <img w-full :src="dialogImageUrl" alt="Preview Image" />
  </el-dialog>
        </template>
        <template #modal-footer>
            <button type="button" class="btn btn-primary" @click="submitImageForm">
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

import { Delete, Download, Plus, ZoomIn } from '@element-plus/icons-vue'
// import type { UploadFile } from 'element-plus'

const { token, permissions } = useAuthStore()

const config = {
    headers: {
        Authorization: `Bearer ${token}`
    }
}

const processing = ref(true)

const tours = ref({})
const destinations = ref([])

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
        tours.value = response.data
        processing.value = false
    } else {
        toast.error("Error fetching list")
    }

}

const fetchDestination = async () => {
    let response = null
    try {
        response = await axios.get(`admin/destinations`, {
            ...config,
        })
    } catch (error) {
        response = error.response
    }

    if (response.status == 200) {
        destinations.value = response.data?.data
        processing.value = false
    } else {
        toast.error("Error fetching list")
    }

}

onMounted(() => {
    fetchTour()
    fetchDestination()
})


const showAddModal = () => {
    $('#add-modal').modal('show')
    clearForm()
}

const showAddImagesModal = () => {
    $('#add-image-modal').modal('show')
    
}
const add_images=(data)=>{
    showAddImagesModal()
}

const dialogImageUrl = ref('')
const dialogVisible = ref(false)
const disabled = ref(false)
const fileListEdit = ref([]);

const handleRemove = (file) => {
  console.log(file)
}

const handlePictureCardPreview = (file) => {
  dialogImageUrl.value = file?.url
  dialogVisible.value = true
}

const handleDownload = (file) => {
  console.log(file)
}

const edit_id=ref(null);

const edit_tour=(data)=>{
    showAddModal()
    form.value.name=data.name;
    form.value.description=data.description
    form.value.destination_id=data.destination_id
    form.value.price=data.price
    form.value.slots=data.slots
    form.value.pickup_place=data.pickup_place
    form.value.start_date=data.start_date
    form.value.end_date=data.end_date
    edit_id.value=data.id

}

const errors = ref({})

const form = ref({
    name: '',
    description: '',
    destination_id: '',
    price:'',
    slots:'',
    pickup_place:'',
    start_date:'',
    end_date:''
})

const clearForm = () => {
    form.value.name = ''
    form.value.description = ''
    form.value.destination_id=''
    form.value.price=''
    form.value.slots=''
    form.value.pickup_place=''
    form.value.start_date=''
    form.value.end_date=''
    edit_id.value=null
}


const submitImageForm=async()=>{

  toast.error('File Server out of Space',{"theme":"colored"});
    console.log(fileListEdit.value);
    $('#add-image-modal .btn-sm').click()
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
