<template>
  <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click="close">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
      <div class="p-6">

        <!-- Header Modal -->
        <div class="text-center relative mb-4">
          <h2 class="text-lg font-bold">Hồ sơ chi tiết</h2>
          <button @click="close" class="absolute right-0 top-1/2 -translate-y-1/2 p-1 hover:bg-gray-100 rounded-full transition">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 28 28">
              <path d="M21 7L7 21M7 7l14 14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <p class="text-gray-600 mt-1">Thông tin sức khỏe và lịch sử khám bệnh</p>
        </div>

        <!-- Pet Info -->
        <div class="flex gap-4 mb-6">
          <img :src="pet.image" alt="Pet" class="w-24 h-24 rounded-xl object-cover">
          <div>
            <h3 class="text-amber-600 font-semibold text-lg">{{ pet.name }}</h3>
            <div class="grid grid-cols-2 gap-y-2 mt-2 text-sm">
              <div><span class="text-gray-500 font-medium">Giống:</span> <span class="font-semibold text-slate-900">{{ pet.breed }}</span></div>
              <div><span class="text-gray-500 font-medium">Tuổi:</span> <span class="font-semibold text-slate-900">{{ pet.age }}</span></div>
              <div><span class="text-gray-500 font-medium">Cân nặng:</span> <span class="font-semibold text-slate-900">{{ pet.weight }}</span></div>
              <div><span class="text-gray-500 font-medium">Giới tính:</span> <span class="font-semibold text-slate-900">{{ pet.gender }}</span></div>
            </div>
          </div>
        </div>

        <!-- Tabs -->
        <div class="bg-gray-200 rounded-2xl p-1 mb-6 flex">
          <button @click="tab = 'vaccination'" :class="{ 'bg-white shadow-sm': tab === 'vaccination' }" class="flex-1 py-2 rounded-2xl font-semibold text-sm transition">
            Lịch tiêm phòng
          </button>
          <button @click="tab = 'medical'" :class="{ 'bg-white shadow-sm': tab === 'medical' }" class="flex-1 py-2 rounded-2xl font-semibold text-sm transition">
            Bệnh án
          </button>
        </div>

        <!-- Tab Vaccination -->
        <div v-show="tab === 'vaccination'" class="space-y-4">
          <div v-for="v in pet.vaccinations" :key="v.date" class="border border-gray-300 rounded-xl p-4">
            <div class="flex justify-between items-center">
              <span class="font-semibold text-slate-900">{{ v.name }}</span>
              <span class="text-sm font-medium">{{ v.date }}</span>
            </div>
            <p class="text-gray-600 text-sm mt-1">Bác sĩ: {{ v.doctor }}</p>
          </div>

          <div v-if="pet.upcomingVaccination" class="bg-amber-50 border border-yellow-300 rounded-xl p-4">
            <div class="flex items-center gap-2 mb-1">
              <svg class="w-5 h-5" fill="none" stroke="#bb4d00" viewBox="0 0 16 16">
                <circle cx="8" cy="8" r="6" stroke-width="2"/>
                <path d="M8 5v3l2 2" stroke-width="2" stroke-linecap="round"/>
              </svg>
              <span class="font-bold text-orange-900">Lịch tiêm sắp tới</span>
            </div>
            <p class="font-bold text-orange-700">{{ pet.upcomingVaccination }}</p>
          </div>
        </div>

        <!-- Tab Medical -->
        <div v-show="tab === 'medical'" class="space-y-4">
          <div v-for="m in pet.medicalRecords" :key="m.date" class="border border-gray-300 rounded-xl p-4">
            <div class="flex justify-between items-center mb-1">
              <span class="font-semibold text-slate-900">{{ m.title }}</span>
              <span class="text-sm font-medium">{{ m.date }}</span>
            </div>
            <p class="text-gray-600 text-sm">Bác sĩ: {{ m.doctor }}</p>
            <p class="text-slate-700 font-medium text-sm">Ghi chú: {{ m.note }}</p>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 mt-8">
          <button class="flex-1 bg-[#5a9690] text-white py-3 rounded-lg font-bold flex items-center justify-center gap-2 hover:opacity-90 transition">
            <svg class="w-5 h-5" fill="none" stroke="white" viewBox="0 0 16 16">
              <rect x="3" y="4" width="10" height="10" rx="1" stroke-width="2"/>
              <path d="M6 2v4M10 2v4M3 7h10" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Đặt lịch khám lại
          </button>
          <button class="flex-1 border border-gray-400 py-3 rounded-lg font-bold flex items-center justify-center gap-2 hover:bg-gray-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="black" viewBox="0 0 16 16">
              <path d="M11.333 2A2.667 2.667 0 0114 4.667v6.666A2.667 2.667 0 0111.333 14H4.667A2.667 2.667 0 012 11.333V4.667A2.667 2.667 0 014.667 2h6.666z" stroke-width="2"/>
              <path d="M10.667 6.667L7.333 10l-2-2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Cập nhật thông tin
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  pet: {
    type: Object,
    default: () => ({})
  }
});

const emit = defineEmits(['close']);

const tab = ref('vaccination');

const close = () => {
  emit('close');
};
</script>

<style scoped>
/* Add any specific styles here if needed */
</style>
