<template>
  <div class="min-h-screen bg-gray-50 font-nunito">
    <!-- ====================== DANH SÁCH THÚ CƯNG ====================== -->
    <div class="container mx-auto px-12 py-7 max-w-6xl">
      <!-- Breadcrumb -->
      <nav class="flex items-center gap-1 mb-6 text-lg">
        <svg class="w-5 h-5 text-gray-400 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="font-semibold text-gray-400">Trang chủ</span>
        <span class="font-bold text-black mx-1">/</span>
        <span class="font-semibold underline">Thú cưng của tôi</span>
      </nav>

      <!-- Header -->
      <div class="flex justify-between items-center mb-12">
        <div>
          <h1 class="text-xl font-bold">Thú cưng của tôi</h1>
          <p class="text-lg font-semibold text-gray-600">Quản lý thông tin và sức khỏe các bé</p>
        </div>
        <button class="flex items-center gap-2 bg-[#5a9690] text-white rounded-xl px-5 py-3.5 font-semibold text-lg hover:bg-[#4a807a] transition">
          <svg class="w-5 h-5" fill="none" stroke="white" viewBox="0 0 16 16">
            <path d="M8 3v10M3 8h10" stroke-width="2" stroke-linecap="round"/>
          </svg>
          Thêm thú cưng
        </button>
      </div>

      <!-- Pet Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="pet in pets" :key="pet.id" 
             class="bg-white border border-black/15 rounded-2xl overflow-hidden flex flex-col hover:shadow-xl transition cursor-pointer"
             @click="openDetail(pet)">
          <!-- Ảnh + Tag loại -->
          <div class="relative h-48 bg-cover bg-center flex justify-end items-start p-7"
               :style="{ backgroundImage: `url(${pet.imageCard})` }">
            <span class="px-4 py-2 rounded-lg font-bold text-lg" :class="pet.tagClass">{{ pet.type }}</span>
          </div>

          <!-- Nội dung card -->
          <div class="p-8 flex-1 flex flex-col">
            <div class="flex justify-between mb-4">
              <div>
                <h3 class="text-lg font-bold">{{ pet.name }}</h3>
                <p class="text-gray-600 font-medium">{{ pet.breed }}</p>
              </div>
              <div class="text-right space-y-1 text-sm">
                <div><span class="text-gray-500 font-medium">Tuổi:</span> <span class="font-bold">{{ pet.age }}</span></div>
                <div><span class="text-gray-500 font-medium">Cân nặng:</span> <span class="font-bold">{{ pet.weight }}</span></div>
              </div>
            </div>

            <!-- Reminder -->
            <div class="flex gap-3 px-6 py-4 rounded-xl mb-6 border" :class="pet.reminderBg">
              <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 16 16">
                <path d="M13 2H3C2.44772 2 2 2.44772 2 3V13C2 13.5523 2.44772 14 3 14H13C13.5523 14 14 13.5523 14 13V3C14 2.44772 13.5523 2 13 2Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11 1V3M5 1V3M2 5H14" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
              <div>
                <p class="font-bold" :class="pet.reminderTitleClass">{{ pet.reminderTitle }}</p>
                <p class="text-xs" :class="pet.reminderDetailClass">{{ pet.reminderDetail }}</p>
              </div>
            </div>

            <!-- Buttons -->
            <div class="mt-auto space-y-3">
              <button class="w-full flex justify-center items-center gap-2 border border-black/15 rounded-lg py-3 font-bold hover:bg-gray-50 transition">
                Xem chi tiết
                <svg class="w-4 h-4" fill="none" stroke="black" viewBox="0 0 16 16">
                  <path d="M6 12l4-4-4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <button class="w-full py-3 border border-[#eb8e90] rounded-lg hover:bg-red-50 transition">
                <svg class="w-7 h-7 mx-auto" fill="none" stroke="#eb8e90" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6h14zM10 11v6M14 11v6"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ====================== MODAL CHI TIẾT (giống 100% file HTML cuối) ====================== -->
    <teleport to="body">
      <div v-if="showDetail" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click="showDetail = false">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
          <div class="p-6">

            <!-- Header Modal -->
            <div class="text-center relative mb-4">
              <h2 class="text-lg font-bold">Hồ sơ chi tiết</h2>
              <button @click="showDetail = false" class="absolute right-0 top-1/2 -translate-y-1/2 p-1 hover:bg-gray-100 rounded-full transition">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 28 28">
                  <path d="M21 7L7 21M7 7l14 14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
              <p class="text-gray-600 mt-1">Thông tin sức khỏe và lịch sử khám bệnh</p>
            </div>

            <!-- Pet Info -->
            <div class="flex gap-4 mb-6">
              <img :src="selectedPet.image" alt="Pet" class="w-24 h-24 rounded-xl object-cover">
              <div>
                <h3 class="text-amber-600 font-semibold text-lg">{{ selectedPet.name }}</h3>
                <div class="grid grid-cols-2 gap-y-2 mt-2 text-sm">
                  <div><span class="text-gray-500 font-medium">Giống:</span> <span class="font-semibold text-slate-900">{{ selectedPet.breed }}</span></div>
                  <div><span class="text-gray-500 font-medium">Tuổi:</span> <span class="font-semibold text-slate-900">{{ selectedPet.age }}</span></div>
                  <div><span class="text-gray-500 font-medium">Cân nặng:</span> <span class="font-semibold text-slate-900">{{ selectedPet.weight }}</span></div>
                  <div><span class="text-gray-500 font-medium">Giới tính:</span> <span class="font-semibold text-slate-900">{{ selectedPet.gender }}</span></div>
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
              <div v-for="v in selectedPet.vaccinations" :key="v.date" class="border border-gray-300 rounded-xl p-4">
                <div class="flex justify-between items-center">
                  <span class="font-semibold text-slate-900">{{ v.name }}</span>
                  <span class="text-sm font-medium">{{ v.date }}</span>
                </div>
                <p class="text-gray-600 text-sm mt-1">Bác sĩ: {{ v.doctor }}</p>
              </div>

              <div v-if="selectedPet.upcomingVaccination" class="bg-amber-50 border border-yellow-300 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-1">
                  <svg class="w-5 h-5" fill="none" stroke="#bb4d00" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="6" stroke-width="2"/>
                    <path d="M8 5v3l2 2" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                  <span class="font-bold text-orange-900">Lịch tiêm sắp tới</span>
                </div>
                <p class="font-bold text-orange-700">{{ selectedPet.upcomingVaccination }}</p>
              </div>
            </div>

            <!-- Tab Medical -->
            <div v-show="tab === 'medical'" class="space-y-4">
              <div v-for="m in selectedPet.medicalRecords" :key="m.date" class="border border-gray-300 rounded-xl p-4">
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
    </teleport>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const showDetail = ref(false)
const selectedPet = ref(null)
const tab = ref('vaccination')

const pets = ref([
  {
    id: 1, name: 'Milo', breed: 'Golden Retriever', type: 'Chó', age: '2 tuổi', weight: '28 kg', gender: 'Đực',
    imageCard: 'https://www.figma.com/api/mcp/asset/7dc3f4c9-30fd-4f46-b415-7a1aab552e01',
    image: 'https://www.figma.com/api/mcp/asset/8cc38ed7-a15e-4e5e-bb8b-a9368f0eff3a',
    tagClass: 'bg-amber-50 text-amber-700',
    reminderBg: 'bg-yellow-50 border-yellow-300',
    reminderTitle: 'Tiêm phòng sắp tới',
    reminderTitleClass: 'text-orange-700',
    reminderDetail: 'Tiêm phòng 6 bệnh - 20/11/2025',
    reminderDetailClass: 'text-orange-900',
    vaccinations: [
      { name: 'Tiêm phòng dại', date: '15/03/2024', doctor: 'Bs. Nguyễn B' },
      { name: 'Tiêm phòng 6 bệnh', date: '20/05/2024', doctor: 'Bs. Trần C' }
    ],
    upcomingVaccination: 'Tiêm phòng 6 bệnh - 20/11/2025',
    medicalRecords: [
      { title: 'Khám tổng quát', date: '10/10/2025', doctor: 'Bs. Nguyễn B', note: 'Sức khỏe tốt' },
      { title: 'Viêm da', date: '15/08/2025', doctor: 'Bs. Trần C', note: 'Đã điều trị' }
    ]
  },
  {
    id: 2, name: 'Luna', breed: 'Ragdoll', type: 'Mèo', age: '3 tuổi', weight: '6 kg', gender: 'Cái',
    imageCard: 'https://www.figma.com/api/mcp/asset/b28879b8-1a58-431b-bf0f-774b57485ff7',
    image: 'https://www.figma.com/api/mcp/asset/b28879b8-1a58-431b-bf0f-774b57485ff7',
    tagClass: 'bg-blue-50 text-sky-500',
    reminderBg: 'bg-cyan-50 border-cyan-200',
    reminderTitle: 'Tiêm phòng sắp tới',
    reminderTitleClass: 'text-cyan-500',
    reminderDetail: 'Tiêm phòng dại - 15/11/2025',
    reminderDetailClass: 'text-cyan-900',
    vaccinations: [], upcomingVaccination: 'Tiêm phòng dại - 15/11/2025', medicalRecords: []
  },
  {
    id: 3, name: 'Xebec', breed: 'Syrian', type: 'Sóc chuột', age: '1 tuổi', weight: '1 kg', gender: 'Đực',
    imageCard: 'https://www.figma.com/api/mcp/asset/b944c01f-94a2-46b5-b071-1ece0c9f856d',
    image: 'https://www.figma.com/api/mcp/asset/b944c01f-94a2-46b5-b071-1ece0c9f856d',
    tagClass: 'bg-zinc-100 text-zinc-500',
    reminderBg: 'bg-zinc-50 border-zinc-400',
    reminderTitle: 'Chưa có lịch hẹn',
    reminderTitleClass: 'text-zinc-700',
    reminderDetail: 'Tiêm phòng 2 bệnh - 20/11/2025',
    reminderDetailClass: 'text-gray-500',
    vaccinations: [], upcomingVaccination: null, medicalRecords: []
  }
])

const openDetail = (pet) => {
  selectedPet.value = pet
  tab.value = 'vaccination'
  showDetail.value = true
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap');
.font-nunito { font-family: 'Nunito Sans', sans-serif; }
</style>