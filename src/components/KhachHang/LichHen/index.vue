<template>
  <div class="min-h-screen font-nunito bg-gray-50">
    <div class="container mx-auto px-6 py-8 max-w-6xl">
      <!-- Breadcrumb -->
      <div class="flex items-center gap-1 mb-6 text-lg">
        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6.25 15L11.25 10L6.25 5" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <span class="text-gray-500 font-semibold">Trang chủ</span>
        <span class="font-bold text-black">/</span>
        <span class="font-semibold underline text-black">Lịch hẹn</span>
      </div>

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

    <!-- POPUP CHI TIẾT LỊCH HẸN - ĐÃ THÊM THANH TOÁN GIỐNG MẪU 100% -->
    <teleport to="body">
      <div v-if="showDetail" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @click="showDetail = false">
        <div class="w-full max-w-lg max-h-[90vh] overflow-y-auto bg-white rounded-xl shadow-2xl border border-black/5" @click.stop>
          <div class="p-6 space-y-6">

            <!-- Header -->
            <div class="relative flex items-center justify-center py-2">
              <h2 class="text-xl font-bold">Chi tiết lịch hẹn</h2>
              <button @click="showDetail = false" class="absolute right-0 p-1 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-7 h-7" viewBox="0 0 28 28" fill="none">
                  <path d="M21 7L7 21M7 7l14 14" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>

            <!-- Dịch vụ -->
            <div class="bg-teal-50 rounded-xl p-4 flex justify-between items-center">
              <div>
                <p class="text-gray-500 font-medium">Dịch vụ</p>
                <p class="font-medium text-black">{{ selectedAppt.service }}</p>
              </div>
              <div class="text-right">
                <p class="text-gray-500 font-medium">Giá dịch vụ</p>
                <p class="text-teal-600 font-medium">250.000đ</p>
              </div>
            </div>

            <!-- Thú cưng -->
            <section>
              <div class="flex items-center gap-3 mb-3">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="#12a594"><path d="M10 12a4 4 0 100-8 4 4 0 000 8zM10 14c-4.42 0-8 1.79-8 4v1h16v-1c0-2.21-3.58-4-8-4z"/></svg>
                <h3 class="font-semibold">Thông tin thú cưng</h3>
              </div>
              <div class="bg-white rounded-xl p-6">
                <div class="grid grid-cols-2 gap-x-12 gap-y-4">
                  <div><span class="text-gray-500 font-medium">Tên</span><p class="font-medium" :class="selectedAppt.pet === 'Milo' ? 'text-amber-700' : 'text-sky-500'">{{ selectedAppt.pet }}</p></div>
                  <div><span class="text-gray-500 font-medium">Giống</span><p class="font-medium">{{ selectedAppt.breed }}</p></div>
                  <div><span class="text-gray-500 font-medium">Tuổi</span><p class="font-medium">{{ selectedAppt.age }}</p></div>
                  <div><span class="text-gray-500 font-medium">Cân nặng</span><p class="font-medium">{{ selectedAppt.weight }}</p></div>
                </div>
              </div>
            </section>

            <!-- Bác sĩ -->
            <section>
              <div class="flex items-center gap-3 mb-3">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none"><path d="M16 18v-1a4 4 0 00-4-4H8a4 4 0 00-4 4v1M12 6a4 4 0 11-8 0 4 4 0 018 0z" stroke="#12a594" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <h3 class="font-semibold">Bác sĩ phụ trách</h3>
              </div>
              <div class="bg-white rounded-xl p-4 flex items-center gap-4">
                <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center text-teal-600 font-semibold text-xl">
                  {{ selectedAppt.doctor.split(' ').pop()[0] }}
                </div>
                <div>
                  <p class="font-medium">{{ selectedAppt.doctor }}</p>
                  <p class="text-gray-500 font-medium">Nội khoa thú y</p>
                </div>
              </div>
            </section>

            <!-- Ngày giờ khám -->
            <section>
              <div class="flex items-center gap-3 mb-3">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none"><rect x="3" y="4" width="14" height="14" rx="2" stroke="#12a594" stroke-width="2"/><path d="M7 2v4M13 2v4M3 8h14" stroke="#12a594" stroke-width="2" stroke-linecap="round"/></svg>
                <h3 class="font-semibold">Ngày giờ khám</h3>
              </div>
              <div class="bg-white rounded-xl p-4 grid grid-cols-3 gap-4 text-center">
                <div><span class="text-gray-500 font-medium block">Ngày</span><p class="font-medium">{{ selectedAppt.date }}</p></div>
                <div><span class="text-gray-500 font-medium block">Giờ</span><p class="font-medium">{{ selectedAppt.time }}</p></div>
                <div><span class="text-gray-500 font-medium block">Mã lịch hẹn</span><p class="font-medium">{{ selectedAppt.id }}</p></div>
              </div>
            </section>

            <!-- Địa điểm -->
            <section>
              <div class="flex items-center gap-3 mb-3">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none"><path d="M10 11a3 3 0 100-6 3 3 0 000 6z" stroke="#12a594" stroke-width="2"/><path d="M10 2a7 7 0 00-7 7c0 4.5 7 9 7 9s7-4.5 7-9a7 7 0 00-7-7z" stroke="#12a594" stroke-width="2"/></svg>
                <h3 class="font-semibold">Địa điểm</h3>
              </div>
              <div class="bg-white rounded-xl p-4">
                <p class="font-medium">{{ selectedAppt.clinic }}</p>
                <p class="text-gray-500 font-medium">{{ selectedAppt.address }}</p>
              </div>
            </section>

            <!-- Ghi chú & Hướng dẫn -->
            <section v-if="selectedAppt.note">
              <div class="flex items-center gap-3 mb-3">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="8" stroke="#12a594" stroke-width="2"/><path d="M10 10v4M10 6h.01" stroke="#12a594" stroke-width="2" stroke-linecap="round"/></svg>
                <h3 class="font-semibold">Ghi chú & Hướng dẫn</h3>
              </div>
              <div class="space-y-3">
                <div class="bg-amber-50 border border-yellow-200 rounded-xl p-4">
                  <p class="font-bold text-amber-800 text-sm">Lưu ý:</p>
                  <p class="font-medium text-amber-800">{{ selectedAppt.note }}</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                  <p class="font-bold text-blue-900 text-sm">Hướng dẫn:</p>
                  <p class="font-medium text-blue-900">Vui lòng nhịn ăn 8 tiếng trước khi khám</p>
                </div>
              </div>
            </section>

            <!-- Trạng thái -->
            <section>
              <div class="flex items-center gap-3 mb-3">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none"><path d="M7 10l2 2 4-4m5 2a8 8 0 11-16 0 8 8 0 0116 0z" stroke="#12a594" stroke-width="2" stroke-linecap="round"/></svg>
                <h3 class="font-semibold">Trạng thái</h3>
              </div>
              <div class="inline-block bg-teal-100 border border-black/5 rounded-lg px-5 py-2">
                <span class="text-teal-600 font-medium text-lg">Đã xác nhận</span>
              </div>
            </section>

            <!-- THANH TOÁN - GIỐNG HỆT MẪU -->
            <section>
              <div class="flex items-center gap-3 mb-3">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none">
                  <rect x="2" y="5" width="16" height="11" rx="2" stroke="#12a594" stroke-width="2"/>
                  <path d="M2 9h16" stroke="#12a594" stroke-width="2"/>
                </svg>
                <h3 class="font-semibold">Thanh toán</h3>
              </div>
              <div class="bg-white rounded-xl p-4 space-y-4">
                <div class="flex justify-between items-center">
                  <div>
                    <p class="text-gray-500 font-medium">Số tiền</p>
                    <p class="font-medium text-lg">250.000đ</p>
                  </div>
                  <div class="bg-red-50 border border-black/5 rounded-lg px-3 py-1">
                    <span class="text-red-700 font-medium text-lg">Chưa thanh toán</span>
                  </div>
                </div>
                <hr class="border-black/5">
                <div>
                  <p class="text-gray-500 font-medium mb-3">Phương thức thanh toán</p>
                  <div class="grid grid-cols-2 gap-3">
                    <button class="bg-blue-600 text-white font-medium text-lg py-3 rounded-lg hover:opacity-90 transition">
                      Thanh toán VNPay
                    </button>
                    <button class="bg-red-600 text-white font-medium text-lg py-3 rounded-lg hover:opacity-90 transition">
                      Thanh toán Banking
                    </button>
                  </div>
                </div>
              </div>
            </section>

          </div>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script setup>
import { ref } from 'vue'

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

const openDetail = (appt) => {
  selectedAppt.value = { ...appt }
  showDetail.value = true
}

const handleNewAppointment = () => alert('Chức năng đặt lịch mới')
const openFilter = (type) => alert(`Lọc theo ${type}`)
const clearFilters = () => alert('Đã xóa bộ lọc')
const handleReschedule = (id) => confirm(`Đổi lịch hẹn ${id}?`) && alert('Chức năng đổi lịch')
const handleCancel = (id) => confirm(`Hủy lịch hẹn ${id}?`) && alert('Đã hủy')
const viewResult = (id) => alert(`Xem kết quả khám của ${id}`)
const rebook = (id) => alert(`Đặt lại lịch hẹn ${id}`)
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700;800&family=Inter:wght@700&display=swap');
.font-nunito { font-family: 'Nunito Sans', sans-serif; }
</style>