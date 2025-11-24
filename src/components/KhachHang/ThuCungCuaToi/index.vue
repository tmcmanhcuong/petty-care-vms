<template>
  <div class="min-h-screen font-nunito">
    <!-- ====================== DANH SÁCH THÚ CƯNG ====================== -->
    <div class="container mx-auto px-12 py-7 max-w-7xl">

      <!-- Header -->
      <div class="flex justify-between items-center mb-12">
        <div>
          <h1 class="text-xl font-bold">Thú cưng của tôi</h1>
          <p class="text-lg font-semibold text-gray-600">Quản lý thông tin và sức khỏe các bé</p>
        </div>
        <button @click="isAddPetOpen = true" class="flex items-center gap-2 bg-[#5a9690] text-white rounded-xl px-5 py-3.5 font-semibold text-lg hover:bg-[#4a807a] transition">
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
              <!-- <button class="w-full flex justify-center items-center gap-2 border border-black/15 rounded-lg py-3 font-bold hover:bg-gray-50 transition">
                Xem chi tiết
                <svg class="w-4 h-4" fill="none" stroke="black" viewBox="0 0 16 16">
                  <path d="M6 12l4-4-4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button> -->
              <button @click.stop="openDeletePopup(pet)" class="w-full py-3 border border-[#eb8e90] rounded-lg hover:bg-red-50 transition">
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

    <!-- Modal Chi Tiết Thú Cưng -->
    <teleport to="body">
      <ChiTietThuCung 
        v-if="selectedPet"
        :isOpen="showDetail" 
        :pet="selectedPet"
        @close="showDetail = false" 
      />
    </teleport>




    <!-- Modal Xóa Thú Cưng -->
    <teleport to="body">
      <XoaThuCung 
        v-if="petToDelete"
        :isOpen="isDeletePetOpen" 
        :petData="petToDelete"
        @close="isDeletePetOpen = false" 
        @delete="handleDeletePet" 
      />
    </teleport>

    <!-- Modal Thêm Thú Cưng -->
    <teleport to="body">
      <ThemThuCung 
        :isOpen="isAddPetOpen" 
        @close="isAddPetOpen = false" 
        @submit="handleAddPet" 
      />
    </teleport>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import ThemThuCung from './ThemThuCung/index.vue'
import ChiTietThuCung from './ChiTietThuCung/index.vue'
import XoaThuCung from './XoaThuCung/index.vue'
import { showSuccessToast } from '@/utils/toast'

const isAddPetOpen = ref(false)

const handleAddPet = (data) => {
  console.log('Thêm thú cưng mới:', data)
  // Sau này sẽ gọi API để lưu vào database
}

const isDeletePetOpen = ref(false)
const petToDelete = ref(null)

const openDeletePopup = (pet) => {
  petToDelete.value = pet
  isDeletePetOpen.value = true
}

const handleDeletePet = (pet) => {
  console.log('Xóa thú cưng:', pet)
  // Logic xóa thú cưng khỏi danh sách
  pets.value = pets.value.filter(p => p.id !== pet.id)
  isDeletePetOpen.value = false
  showSuccessToast('Xóa thành công', `Đã xóa thú cưng ${pet.name} khỏi danh sách`)
}

const showDetail = ref(false)
const selectedPet = ref(null)

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
  showDetail.value = true
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap');
.font-nunito { font-family: 'Nunito Sans', sans-serif; }
</style>