<template>
  <div class="min-h-screen font-nunitoSans">
    <div class="container mx-auto px-6 py-8 max-w-6xl">

      <!-- Header -->
      <div class="flex justify-between items-center mb-6 flex-col md:flex-row gap-4">
        <div>
          <h1 class="text-2xl font-bold text-black">Lịch hẹn khám</h1>
          <p class="text-xl font-medium text-gray-600">Quản lý các buổi khám đã đặt</p>
        </div>
        <button @click="handleNewAppointment"
          class="flex items-center gap-3 px-6 py-3 bg-teal-600 text-white rounded-lg font-medium text-lg hover:bg-teal-700 transition">
          <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none">
            <path d="M8 2v12M2 8h12" stroke="white" stroke-width="2" stroke-linecap="round" />
          </svg>
          Đặt lịch mới
        </button>
      </div>

      <!-- Tabs -->
      <div class="flex bg-zinc-100 rounded-2xl p-1 gap-1 mb-8 w-fit">
        <button v-for="tab in tabs" :key="tab.id" @click="activeTab = tab.id"
          :class="activeTab === tab.id ? 'bg-white text-black shadow-sm' : 'text-black hover:opacity-70'"
          class="px-6 py-2.5 rounded-2xl font-semibold text-base transition">
          {{ tab.label }} ({{ tab.count }})
        </button>
      </div>

      <!-- Filter -->
      <div class="bg-gray-200 border border-black/20 rounded-2xl p-6 mb-8">
        <div class="flex flex-wrap items-center gap-4">
          <div class="flex items-center gap-2">
            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none">
              <path d="M3 5h14M7 10h6M5 15h10" stroke="#374151" stroke-width="2" stroke-linecap="round" />
            </svg>
            <span class="font-medium text-gray-700">Lọc theo:</span>
          </div>
          <div class="flex flex-1 flex-wrap gap-4">
            <button @click="openFilter('pet')" class="flex-1 min-w-48 flex justify-between items-center px-4 py-2 bg-white rounded-lg hover:opacity-80 transition">
              <span class="text-gray-500 font-medium">Tất cả thú cưng</span>
              <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none"><path d="M2 5l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
            </button>
            <button @click="openFilter('service')" class="flex-1 min-w-48 flex justify-between items-center px-4 py-2 bg-white rounded-lg hover:opacity-80 transition">
              <span class="text-gray-500 font-medium">Tất cả dịch vụ</span>
              <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none"><path d="M2 5l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
            </button>
            <button @click="openFilter('date')" class="flex-1 min-w-48 flex justify-between items-center px-4 py-2 bg-white rounded-lg hover:opacity-80 transition">
              <span class="text-gray-500 font-medium">Khoảng thời gian</span>
              <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none"><path d="M2 5l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" /></svg>
            </button>
          </div>
          <button @click="clearFilters" class="px-3 py-1 text-teal-700 font-medium hover:opacity-70 transition">
            Xóa bộ lọc
          </button>
        </div>
      </div>

      <!-- TAB SẮP TỚI -->
      <div v-if="activeTab === 'upcoming'" class="space-y-6">
        <div v-for="appt in upcomingAppointments" :key="appt.id"
          class="bg-white rounded-2xl overflow-hidden border border-black/5 shadow-sm">
          <div class="bg-teal-50 border-b border-teal-100 p-6">
            <div class="flex justify-between flex-col md:flex-row gap-4">
              <div>
                <div class="flex items-center gap-3 mb-2">
                  <h3 class="text-lg font-semibold">{{ appt.service }}</h3>
                  <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-lg font-medium text-base">Đã xác nhận</span>
                </div>
                <p class="text-gray-600 font-medium">Mã lịch hẹn: {{ appt.id }}</p>
              </div>
              <div class="text-right md:text-left">
                <div class="font-medium">{{ appt.date }}</div>
                <div class="text-teal-600 font-medium text-lg">{{ appt.time }}</div>
              </div>
            </div>
          </div>

          <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-6">
              <div class="space-y-6">
                <div class="flex gap-4">
                  <svg class="w-6 h-6 mt-1 flex-shrink-0 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="3.5" stroke-width="2" />
                    <path d="M4 20c0-4 4-7 8-7s8 3 8 7" stroke-width="2" />
                  </svg>
                  <div>
                    <p class="text-gray-600 font-medium mb-1">Thú cưng</p>
                    <p :class="appt.pet === 'Milo' ? 'text-amber-700' : 'text-sky-500'" class="text-lg font-semibold">{{ appt.pet }}</p>
                    <div class="flex flex-wrap gap-4 mt-2 text-gray-600 font-medium">
                      <span>{{ appt.breed }}</span>
                      <span>{{ appt.age }}</span>
                      <span>{{ appt.weight }}</span>
                    </div>
                  </div>
                </div>
                <div class="flex gap-4">
                  <svg class="w-6 h-6 mt-1 flex-shrink-0 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 20c0-5 4-8 8-8s8 3 8 8" stroke-width="2" />
                  </svg>
                  <div>
                    <p class="text-gray-600 font-medium mb-1">Bác sĩ</p>
                    <p class="font-semibold">{{ appt.doctor }}</p>
                  </div>
                </div>
              </div>
              <div class="space-y-6">
                <div class="flex gap-4">
                  <svg class="w-6 h-6 mt-1 flex-shrink-0 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2a8 8 0 00-8 8c0 6 8 12 8 12s8-6 8-12a8 8 0 00-8-8z" stroke-width="2" />
                    <circle cx="12" cy="10" r="3" fill="currentColor" />
                  </svg>
                  <div>
                    <p class="text-gray-600 font-medium mb-1">Địa điểm</p>
                    <p class="font-semibold">{{ appt.clinic }}</p>
                    <p class="text-gray-600 font-medium">{{ appt.address }}</p>
                  </div>
                </div>
                <div v-if="appt.note" class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                  <p class="font-bold text-amber-800 text-sm mb-1">Lưu ý:</p>
                  <p class="font-medium text-amber-800">{{ appt.note }}</p>
                </div>
              </div>
            </div>

            <div class="pt-6 border-t border-zinc-200 flex flex-col md:flex-row gap-4">
              <button @click="handleReschedule(appt.id)" class="flex-1 flex items-center justify-center gap-2 py-3 border border-black/10 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none"><path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Đổi lịch
              </button>
              <button @click="handleCancel(appt.id)" class="flex-1 flex items-center justify-center gap-2 py-3 border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition">
                <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none"><path d="M2 8h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                Hủy hẹn
              </button>
              <button @click="openDetail(appt)" class="flex-1 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition font-medium">
                Xem chi tiết
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- TAB ĐÃ QUA -->
      <div v-if="activeTab === 'past'" class="space-y-6">
        <div v-for="appt in pastAppointments" :key="appt.id"
          class="bg-white rounded-2xl border border-black/5 overflow-hidden shadow-sm">
          <div class="p-6">
            <div class="flex justify-between flex-col md:flex-row gap-4 mb-4">
              <div>
                <div class="flex items-center gap-3 flex-wrap">
                  <h3 class="text-lg font-semibold">{{ appt.service }}</h3>
                  <span class="px-3 py-1 rounded-lg text-sm font-medium"
                    :class="appt.status === 'completed' ? 'bg-emerald-100 text-green-700' : 'bg-gray-200 text-gray-700'">
                    {{ appt.badge1 }}
                  </span>
                  <span v-if="appt.badge2" class="px-3 py-1 bg-emerald-50 border border-emerald-200 text-green-700 rounded-lg text-sm font-medium">
                    {{ appt.badge2 }}
                  </span>
                </div>
                <p class="text-gray-600 font-medium mt-1">Mã lịch hẹn: {{ appt.id }}</p>
              </div>
              <div class="text-right">
                <div class="font-medium">{{ appt.date }}</div>
                <div class="text-gray-600">{{ appt.time }}</div>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4 max-w-md ml-auto pt-4">
              <div>
                <button v-if="appt.status === 'completed'" @click="viewResult(appt.id)"
                  class="w-full px-6 py-3.5 bg-white border border-black/10 rounded-xl hover:bg-gray-50 transition font-semibold text-center">
                  Xem kết quả
                </button>
              </div>
              <div>
                <button v-if="appt.status !== 'cancelled'" @click="rebook(appt.id)"
                  class="w-full px-6 py-3.5 bg-white border border-black/10 rounded-xl hover:bg-gray-50 transition font-semibold text-center">
                  Đặt lại
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- POPUP CHI TIẾT LỊCH HẸN -->
    <teleport to="body">
      <ChiTietLichHen 
        v-if="selectedAppt"
        :is-open="showDetail" 
        :selected-appt="selectedAppt" 
        @close="showDetail = false" 
      />
    </teleport>

    <!-- POPUP ĐẶT LỊCH KHÁM -->
    <teleport to="body">
      <DatLichKham
        :is-open="showBookingPopup"
        :initial-data="rebookData"
        @close="showBookingPopup = false"
        @confirm="handleBookingConfirm"
        @openAddPet="() => {}" 
      />
    </teleport>

    <!-- POPUP ĐỔI LỊCH HẸN -->
    <teleport to="body">
      <DoiLich
        v-if="rescheduleAppt"
        :is-open="showReschedulePopup"
        :old-appointment="rescheduleAppt"
        @close="showReschedulePopup = false"
        @save="handleRescheduleConfirm"
      />
    </teleport>

    <!-- POPUP HỦY LỊCH HẸN -->
    <teleport to="body">
      <HuyHen
        v-if="cancelAppt"
        :is-open="showCancelPopup"
        :appointment="cancelAppt"
        :cancel-status="cancelStatus"
        @close="showCancelPopup = false"
        @keep="showCancelPopup = false"
        @cancel="handleCancelConfirm"
      />
    </teleport>

    <!-- POPUP KẾT QUẢ KHÁM BỆNH -->
    <teleport to="body">
      <KetQuaKhambenh
        v-if="resultData"
        :is-open="showResultPopup"
        :result="resultData"
        @close="showResultPopup = false"
        @download="(file) => console.log('Downloading', file)"
      />
    </teleport>
  </div>
</template>

<script setup>
import { ref } from 'vue'

import DatLichKham from './DatLichKham/index.vue'
import ChiTietLichHen from './ChiTietLichHen/index.vue'
import DoiLich from './DoiLich/index.vue'
import HuyHen from './HuyHen/index.vue'
import KetQuaKhambenh from './KetQuaKhambenh/index.vue'

const activeTab = ref('upcoming')
const tabs = ref([
  { id: 'upcoming', label: 'Sắp tới', count: 2 },
  { id: 'past', label: 'Đã qua', count: 3 }
])

const upcomingAppointments = ref([
  {
    id: 'LH001234',
    service: 'Khám tổng quát',
    date: '10/11/2025',
    time: '14:00 - 14:30',
    pet: 'Milo',
    breed: 'Golden Retriever',
    age: '2 tuổi',
    weight: '28 kg',
    doctor: 'Bs. Nguyễn Thị B',
    clinic: 'Phòng khám Petty - Chi nhánh Quận 1',
    address: '123 Nguyễn Huệ, Q.1, TP.HCM',
    note: 'Mang theo sổ tiêm phòng'
  },
  {
    id: 'LH001235',
    service: 'Tiêm phòng dại',
    date: '15/11/2025',
    time: '10:30 - 11:00',
    pet: 'Luna',
    breed: 'Ragdoll',
    age: '1.5 tuổi',
    weight: '4.2 kg',
    doctor: 'Bs. Trần Văn C',
    clinic: 'Phòng khám Pet Care - Chi nhánh Quận 1',
    address: '123 Nguyễn Huệ, Q.1, TP.HCM',
    note: null
  }
])

const pastAppointments = ref([
  { id: 'LH001230', service: 'Khám da liễu', date: '25/10/2025', time: '15:00 - 15:30', pet: 'Milo', doctor: 'Bs. Trần Văn C', badge1: 'Hoàn thành', badge2: 'Đã thanh toán', status: 'completed' },
  { id: 'LH001228', service: 'Khám tổng quát', date: '14/10/2025', time: '15:00 - 15:30', pet: 'Luna', doctor: 'Bs. Nguyễn Thị B', badge1: 'Hoàn thành', badge2: 'Đã thanh toán', status: 'completed' },
  { id: 'LH001220', service: 'Cắt tỉa lông', date: '20/09/2025', time: '14:00 - 15:00', pet: 'Luna', doctor: 'Chuyên viên Lê D', badge1: 'Đã huỷ', status: 'cancelled' }
])

const showDetail = ref(false)
const selectedAppt = ref(null)
const showBookingPopup = ref(false)
const rebookData = ref(null)
const showReschedulePopup = ref(false)
const rescheduleAppt = ref(null)
const showCancelPopup = ref(false)
const cancelAppt = ref(null)
const cancelStatus = ref('unpaid') // 'late' | 'refundable' | 'unpaid'
const showResultPopup = ref(false)
const resultData = ref(null)

const openDetail = (appt) => {
  selectedAppt.value = { ...appt }
  showDetail.value = true
}

const handleNewAppointment = () => {
  rebookData.value = null
  showBookingPopup.value = true
}

const handleBookingConfirm = (bookingData) => {
  console.log('Booking confirmed:', bookingData)
  alert('Đặt lịch thành công!')
}

const openFilter = (type) => alert(`Lọc theo ${type}`)
const clearFilters = () => alert('Đã xóa bộ lọc')

const handleReschedule = (id) => {
  const appt = upcomingAppointments.value.find(a => a.id === id)
  if (appt) {
    rescheduleAppt.value = {
      id: appt.id,
      petName: appt.pet,
      serviceName: appt.service,
      dateTime: `${appt.time} - ${appt.date}`,
      date: appt.date,
      time: appt.time
    }
    showReschedulePopup.value = true
  }
}

const handleRescheduleConfirm = (data) => {
  console.log('Reschedule confirmed:', data)
  alert('Đổi lịch thành công!')
  showReschedulePopup.value = false
}

const handleCancel = (id) => {
  const appt = upcomingAppointments.value.find(a => a.id === id)
  if (appt) {
    cancelAppt.value = {
      id: appt.id,
      petName: appt.pet,
      serviceName: appt.service,
      paidAmount: '250.000' // Mock amount
    }
    // Mock logic to determine cancel status
    // In real app, check time diff and payment status
    const randomStatus = Math.random()
    if (randomStatus < 0.33) cancelStatus.value = 'late'
    else if (randomStatus < 0.66) cancelStatus.value = 'refundable'
    else cancelStatus.value = 'unpaid'
    
    showCancelPopup.value = true
  }
}

const handleCancelConfirm = (data) => {
  console.log('Cancel confirmed:', data)
  alert('Đã hủy lịch hẹn!')
  showCancelPopup.value = false
  // Remove from list or update status
}

const viewResult = (id) => {
  const appt = pastAppointments.value.find(a => a.id === id)
  if (appt) {
    // Mock result data
    resultData.value = {
      date: appt.date,
      time: appt.time,
      serviceName: appt.service,
      doctorName: appt.doctor,
      doctorSpecialty: 'Nội khoa thú y',
      diagnosis: 'Viêm da dị ứng do bọ chét. Thú cưng có biểu hiện ngứa nhiều vùng lưng và đuôi, da mẩn đỏ.',
      medicines: [
        { name: 'Apoquel 5.4mg', dosage: '1 viên/ngày', instruction: 'Uống sau khi ăn sáng' },
        { name: 'Bravecto', dosage: '1 viên duy nhất', instruction: 'Nhai trực tiếp hoặc trộn với thức ăn' }
      ],
      postCareGuideline: 'Vệ sinh môi trường sống sạch sẽ, giặt giũ đệm nằm của thú cưng. Tái khám sau 2 tuần nếu triệu chứng không giảm.',
      attachments: [
        { name: 'Ket_qua_xet_nghiem_mau.pdf', label: 'Kết quả xét nghiệm', type: 'pdf', url: '#' },
        { name: 'Hinh_anh_vung_da.jpg', label: 'Hình ảnh lâm sàng', type: 'image', url: '#' }
      ]
    }
    showResultPopup.value = true
  }
}

const rebook = (id) => {
  const appt = pastAppointments.value.find(a => a.id === id) || upcomingAppointments.value.find(a => a.id === id)
  if (appt) {
    rebookData.value = {
      petName: appt.pet,
      serviceName: appt.service
    }
    showBookingPopup.value = true
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700;800&family=Inter:wght@700&display=swap');
.font-nunito { font-family: 'Nunito Sans', sans-serif; }
</style>