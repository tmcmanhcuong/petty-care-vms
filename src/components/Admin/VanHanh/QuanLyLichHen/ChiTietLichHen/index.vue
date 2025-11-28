<template>
  <!-- Modal Overlay -->
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <!-- Modal Card -->
    <div class="bg-white border border-black/10 rounded-[10px] shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.1),0px_4px_6px_-4px_rgba(0,0,0,0.1)] w-[510px] relative">
      <!-- Close Button -->
      <button
        @click="$emit('close')"
        class="absolute right-4 top-4 w-4 h-4 opacity-70 hover:opacity-100 transition-opacity"
      >
        <img :src="iconClose" alt="Close" class="w-full h-full" />
      </button>

      <!-- Dialog Header -->
      <div class="px-6 pt-6 pb-0">
        <h2 class="font-nunito font-semibold text-lg leading-[18px] text-neutral-950 tracking-tight mb-2">
          Chi tiết lịch hẹn
        </h2>
        <p class="font-nunito text-sm leading-5 text-[#717182] tracking-tight">
          Mã lịch hẹn: {{ appointmentData.id }}
        </p>
      </div>

      <!-- Content -->
      <div class="px-6 pt-[22px] pb-0">
        <div class="flex flex-col gap-4">
          <!-- Time -->
          <div class="relative h-11">
            <div class="absolute left-0 top-[2px] w-5 h-5">
              <img :src="iconCalendar" alt="Calendar" class="w-full h-full" />
            </div>
            <div class="absolute left-8 top-0 flex flex-col">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
                Thời gian
              </p>
              <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
                {{ appointmentData.time }} - {{ appointmentData.date }}
              </p>
            </div>
          </div>

          <!-- Customer -->
          <div class="relative h-11">
            <div class="absolute left-0 top-[2px] w-5 h-5">
              <img :src="iconUser" alt="User" class="w-full h-full" />
            </div>
            <div class="absolute left-8 top-0 flex flex-col">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
                Khách hàng
              </p>
              <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
                {{ appointmentData.customer }}
              </p>
            </div>
          </div>

          <!-- Pet -->
          <div class="relative h-11">
            <div class="absolute left-0 top-[2px] w-5 h-5">
              <img :src="iconUser" alt="Pet" class="w-full h-full" />
            </div>
            <div class="absolute left-8 top-0 flex flex-col">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
                Thú cưng
              </p>
              <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
                {{ appointmentData.pet }}
              </p>
            </div>
          </div>

          <!-- Service -->
          <div class="relative h-11">
            <div class="absolute left-0 top-[2px] w-5 h-5">
              <img :src="iconService" alt="Service" class="w-full h-full" />
            </div>
            <div class="absolute left-8 top-0 flex flex-col">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
                Dịch vụ
              </p>
              <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
                {{ appointmentData.service }}
              </p>
            </div>
          </div>

          <!-- Assigned Staff -->
          <div class="relative h-[60px]">
            <div class="absolute left-0 top-[2px] w-5 h-5">
              <img :src="iconUser" alt="Staff" class="w-full h-full" />
            </div>
            <div class="absolute left-8 top-0 flex flex-col">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
                Phụ trách
              </p>
              <p class="font-nunito text-base leading-6 text-[#101828] tracking-tight">
                {{ appointmentData.assignedStaff }}
              </p>
              <p class="font-nunito text-xs leading-4 text-[#6a7282]">
                ({{ appointmentData.department }})
              </p>
            </div>
          </div>

          <!-- Status and Payment Row -->
          <div class="border-t border-black/10 pt-[17px] grid grid-cols-2 gap-4">
            <!-- Status -->
            <div class="flex flex-col">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight mb-[6.5px]">
                Trạng thái
              </p>
              <span
                :class="[
                  'inline-flex items-center px-2 py-[3px] rounded-lg font-nunito font-medium text-xs leading-4 w-fit',
                  getStatusClass(appointmentData.status)
                ]"
              >
                {{ getStatusLabel(appointmentData.status) }}
              </span>
            </div>

            <!-- Payment -->
            <div class="flex flex-col">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight mb-[6.5px]">
                Thanh toán
              </p>
              <span
                :class="[
                  'inline-flex items-center px-2 py-[3px] rounded-lg font-nunito font-medium text-xs leading-4 w-fit',
                  getPaymentClass(appointmentData.paymentStatus)
                ]"
              >
                {{ getPaymentLabel(appointmentData.paymentStatus) }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Dialog Footer -->
      <div class="px-6 pt-4 pb-6 flex items-center justify-end">
        <button
          @click="$emit('close')"
          class="bg-[#030213] rounded-lg h-9 px-4 py-2 font-nunito font-medium text-sm leading-5 text-white tracking-tight hover:bg-[#1a1b2e] transition-colors"
        >
          Đóng
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

// Icons (from Figma - expire in 7 days)
const iconCalendar = "https://www.figma.com/api/mcp/asset/b58c411f-53b3-4866-802c-3c8f1c5ed79d"
const iconUser = "https://www.figma.com/api/mcp/asset/45ff3f14-22aa-42da-8b81-22568dc780c8"
const iconService = "https://www.figma.com/api/mcp/asset/0e1add33-8582-4146-b603-a88f0d19aafe"
const iconClose = "https://www.figma.com/api/mcp/asset/100c358c-d660-459f-8e29-4e3ff5189c59"

// Props
const props = defineProps({
  appointmentId: {
    type: String,
    default: 'LH001237'
  }
})

// Emits
const emit = defineEmits(['close'])

// Sample Data (in real app, this would be fetched based on appointmentId)
const appointmentData = computed(() => ({
  id: props.appointmentId,
  time: '15:00',
  date: '19/11/2025',
  customer: 'Phạm Thị G',
  pet: 'Max',
  service: 'Khám bệnh',
  assignedStaff: 'BS. Nguyễn Văn B',
  department: 'Khoa Lâm Sàng',
  status: 'completed',
  paymentStatus: 'paid'
}))

// Status helper methods
const getStatusLabel = (status) => {
  const labels = {
    'confirmed': 'Đã xác nhận',
    'in-progress': 'Đang khám',
    'pending': 'Chờ xác nhận',
    'completed': '🔘 Hoàn thành',
    'cancelled': 'Đã hủy'
  }
  return labels[status] || status
}

const getStatusClass = (status) => {
  const classes = {
    'confirmed': 'bg-green-100 text-[#008236]',
    'in-progress': 'bg-purple-100 text-[#8200db]',
    'pending': 'bg-blue-100 text-[#1447e6]',
    'completed': 'bg-gray-100 text-[#364153]',
    'cancelled': 'bg-[#ffe2e2] text-[#c10007]'
  }
  return classes[status] || 'bg-gray-100 text-gray-600'
}

const getPaymentLabel = (status) => {
  const labels = {
    'paid': 'Đã xong',
    'unpaid': 'Chưa thanh toán',
    'refunded': 'Đã hoàn tiền'
  }
  return labels[status] || status
}

const getPaymentClass = (status) => {
  const classes = {
    'paid': 'bg-green-100 text-[#008236]',
    'unpaid': 'bg-gray-100 text-[#4a5565]',
    'refunded': 'bg-purple-100 text-[#7e22ce]'
  }
  return classes[status] || 'bg-gray-100 text-gray-600'
}
</script>

<style scoped>
/* No additional styles needed */
</style>
