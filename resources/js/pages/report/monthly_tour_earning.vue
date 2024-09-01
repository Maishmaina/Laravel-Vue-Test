<template>
 <div class="form-box">
                  <div class="form-title-wrap">
                    Monthly Tour Return 
                  </div>
                  <div class="form-content">          
                    <CanvasJSChart :options="options" heigh="250" />
                  </div>
                </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/authStore.js'    
import {ref, computed, onMounted} from 'vue'


const { token } = useAuthStore()

const config = {
    headers: {
        Authorization: `Bearer ${token}`
    }
}

const bookings=ref([]);

const options=computed(()=>(
    {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2",
        title:{
          text: "Collection Distribution"
        },
        axisX:{
          valueFormatString: "YYYY",
          labelTextAlign: "center",
          labelAngle: 0
        },
        axisY: {
          title: "Amount (in KES)",
          valueFormatString: "KES##,##,##0"
        },
        data: [{
          type: "line",
          yValueFormatString: "KES##,##,##0.##",
          dataPoints:booking_options.value
        }]
      }
))

const booking_options=computed(()=>{
    return bookings.value.map((item)=>{
        return {...item,y:Number(item.y)}
    })
})


const fetchEarningReport= async () => {
    let response = null
    try {
        response = await axios.get(`admin/totals-earning-report`, {
            ...config,
        })
    } catch (error) {
        response = error.response
    }

    if (response.status == 200) {
        bookings.value = response.data.reverse()
       
    } 
    
}

onMounted(()=>{
    fetchEarningReport()
})

</script>