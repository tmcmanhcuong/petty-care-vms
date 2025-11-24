<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @click="$emit('close')">
    <div class="w-full max-w-lg max-h-[90vh] overflow-y-auto bg-white rounded-xl shadow-2xl border border-black/5" @click.stop>
      <div class="p-6 space-y-6">

        <!-- Header -->
        <div class="relative flex items-center justify-center py-2">
          <h2 class="text-xl font-bold">Chi tiết lịch hẹn</h2>
          <button @click="$emit('close')" class="absolute right-0 p-1 hover:bg-gray-100 rounded-lg transition">
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
</template>

<script setup>
defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  selectedAppt: {
    type: Object,
    required: true
  }
})

defineEmits(['close'])
</script>
