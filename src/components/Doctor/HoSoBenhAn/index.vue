<template>
  <div class="flex flex-col gap-6 w-full h-full">
    <!-- Header Section -->
    <div class="flex flex-col h-[60px]">
      <h1 class="text-2xl font-medium text-[#101828] leading-9 tracking-[0.0703px]">
        Quản lý Hồ sơ bệnh án
      </h1>
      <p class="text-base font-normal text-[#4a5565] leading-6 tracking-[-0.3125px]">
        Tra cứu lịch sử khám bệnh và thông tin khách hàng
      </p>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] px-6 py-[25px]">
      <div class="flex items-start justify-between gap-3">
        <!-- Search Input -->
        <div class="relative flex-1">
          <div class="absolute left-4 top-[14px] w-5 h-5">
            <img :src="icons.search" alt="" class="w-full h-full" />
          </div>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Nhập SĐT, Tên chủ hoặc Tên thú cưng để tra cứu..."
            class="w-full h-12 bg-[#f3f3f5] border-0 rounded-lg pl-12 pr-3 py-1 text-sm text-[#717182] focus:outline-none focus:ring-2 focus:ring-[#155dfc]"
          />
        </div>

        <!-- Filter Buttons -->
        <div class="flex gap-2">
          <button
            @click="selectedFilter = 'all'"
            :class="[
              'h-9 px-3 rounded-lg flex items-center gap-2',
              selectedFilter === 'all' 
                ? 'bg-[#155dfc] text-white' 
                : 'bg-white border border-[rgba(0,0,0,0.1)] text-neutral-950'
            ]"
          >
            <img :src="selectedFilter === 'all' ? icons.filterWhite : icons.filterBlack" alt="" class="w-4 h-4" />
            <span class="text-sm font-medium leading-5 tracking-[-0.1504px]">Tất cả</span>
          </button>
          <button
            @click="selectedFilter = 'member'"
            :class="[
              'h-9 px-3 rounded-lg flex items-center gap-2',
              selectedFilter === 'member' 
                ? 'bg-[#155dfc] text-white' 
                : 'bg-white border border-[rgba(0,0,0,0.1)] text-neutral-950'
            ]"
          >
            <img :src="selectedFilter === 'member' ? icons.memberWhite : icons.memberBlack" alt="" class="w-4 h-4" />
            <span class="text-sm font-medium leading-5 tracking-[-0.1504px]">Member</span>
          </button>
          <button
            @click="selectedFilter = 'vanglai'"
            :class="[
              'h-9 px-3 rounded-lg flex items-center gap-2',
              selectedFilter === 'vanglai' 
                ? 'bg-[#155dfc] text-white' 
                : 'bg-white border border-[rgba(0,0,0,0.1)] text-neutral-950'
            ]"
          >
            <img :src="selectedFilter === 'vanglai' ? icons.vanglaiWhite : icons.vanglaiBlack" alt="" class="w-4 h-4" />
            <span class="text-sm font-medium leading-5 tracking-[-0.1504px]">Vãng lai</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Patient Records List -->
    <div class="flex flex-col gap-4">
      <!-- Customer Card -->
      <div
        v-for="customer in filteredCustomers"
        :key="customer.id"
        class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px]"
      >
        <!-- Customer Header -->
        <div class="border-b border-gray-100 px-6 pt-6 pb-[31px]">
          <div class="flex items-center justify-between">
            <!-- Customer Info -->
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <img :src="icons.user" alt="" class="w-5 h-5" />
              </div>
              <div class="flex flex-col">
                <p class="text-base font-normal text-neutral-950 leading-6 tracking-[-0.3125px]">
                  {{ customer.name }}
                </p>
                <div class="flex items-center gap-1 h-5">
                  <img :src="icons.phone" alt="" class="w-3 h-3" />
                  <span class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]">
                    {{ customer.phone }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Badge -->
            <div
              :class="[
                'px-3 py-1 rounded-lg border flex items-center gap-2',
                customer.type === 'member'
                  ? 'bg-blue-100 border-[#bedbff]'
                  : 'bg-gray-100 border-gray-200'
              ]"
            >
              <img 
                :src="customer.type === 'member' ? icons.memberBadge : icons.vanglaiBadge" 
                alt="" 
                class="w-3 h-3" 
              />
              <span
                :class="[
                  'text-xs font-medium leading-4',
                  customer.type === 'member' ? 'text-[#1447e6]' : 'text-[#364153]'
                ]"
              >
                {{ customer.type === 'member' ? 'Member' : 'Vãng lai' }}
              </span>
            </div>
          </div>
        </div>

        <!-- Pets List -->
        <div class="px-6 py-10 flex flex-col gap-3">
          <div
            v-for="pet in customer.pets"
            :key="pet.id"
            class="bg-gray-50 border border-gray-200 rounded-[10px] p-[17px] flex items-center gap-4"
          >
            <!-- Pet Image -->
            <div class="w-20 h-20 rounded-[10px] border-2 border-white shadow-[0px_1px_3px_0px_rgba(0,0,0,0.1),0px_1px_2px_-1px_rgba(0,0,0,0.1)] overflow-hidden flex-shrink-0">
              <img :src="pet.image" alt="" class="w-full h-full object-cover" />
            </div>

            <!-- Pet Info -->
            <div class="flex-1 flex flex-col gap-2">
              <!-- Name & Species -->
              <div class="flex items-center gap-2 h-6">
                <span class="text-base font-bold text-[#101828] leading-6 tracking-[-0.3125px]">
                  {{ pet.name }}
                </span>
                <span class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]">
                  ({{ pet.species }})
                </span>
              </div>

              <!-- Last Visit -->
              <div class="flex items-center gap-2 h-5">
                <img :src="icons.clock" alt="" class="w-4 h-4" />
                <span class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]">
                  Lần khám cuối:
                </span>
                <span class="text-sm font-bold text-[#4a5565] leading-5 tracking-[-0.1504px]">
                  {{ pet.lastVisit }}
                </span>
                <span class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]">
                  - Chẩn đoán: {{ pet.diagnosis }}
                </span>
              </div>

              <!-- Pet Details -->
              <p class="text-xs font-normal text-[#6a7282] leading-4">
                {{ pet.age }} • {{ pet.gender }} • {{ pet.weight }}
              </p>
            </div>

            <!-- View Button -->
            <button
              @click="viewRecord(customer.id, pet.id)"
              class="bg-[#155dfc] hover:bg-[#0d47c9] transition-colors rounded-lg px-3 py-[6px] flex items-center gap-3 flex-shrink-0"
            >
              <img :src="icons.eye" alt="" class="w-4 h-4" />
              <span class="text-sm font-medium text-white leading-5 tracking-[-0.1504px]">
                Xem Hồ sơ
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Icons
const icons = {
  search: 'https://www.figma.com/api/mcp/asset/18b3a6b9-ef14-4bd4-9891-6c33221bd520',
  filterWhite: 'https://www.figma.com/api/mcp/asset/975757c0-9d30-427f-b8bc-cabfcc0a34b3',
  filterBlack: 'https://www.figma.com/api/mcp/asset/975757c0-9d30-427f-b8bc-cabfcc0a34b3',
  memberWhite: 'https://www.figma.com/api/mcp/asset/04a28a11-a2d5-44e8-9582-f0328ceb42a1',
  memberBlack: 'https://www.figma.com/api/mcp/asset/04a28a11-a2d5-44e8-9582-f0328ceb42a1',
  vanglaiWhite: 'https://www.figma.com/api/mcp/asset/f3462224-5618-4e0d-b3a0-80ce1c345e2d',
  vanglaiBlack: 'https://www.figma.com/api/mcp/asset/f3462224-5618-4e0d-b3a0-80ce1c345e2d',
  user: 'https://www.figma.com/api/mcp/asset/ffdf60ec-2493-42b6-bb4c-196a150deb61',
  phone: 'https://www.figma.com/api/mcp/asset/0c829708-4e7b-4320-ac9f-ce323fdefadc',
  memberBadge: 'https://www.figma.com/api/mcp/asset/1eb89c2f-dade-486f-988e-8893bfb9da1a',
  vanglaiBadge: 'https://www.figma.com/api/mcp/asset/3ff3b015-4003-4406-aa33-bf59b5e29503',
  clock: 'https://www.figma.com/api/mcp/asset/b18f33dc-1063-4480-9ca3-ee54c9faab38',
  eye: 'https://www.figma.com/api/mcp/asset/019de0d1-2c82-4ecf-aa57-4f9b208c044d'
}

// State
const searchQuery = ref('')
const selectedFilter = ref('all')

// Sample data
const customers = ref([
  {
    id: 1,
    name: 'Nguyễn Văn A',
    phone: '0901234567',
    type: 'member',
    pets: [
      {
        id: 1,
        name: 'Milo',
        species: 'Chó Golden Retriever',
        image: 'https://www.figma.com/api/mcp/asset/800b99a2-25e2-4122-b7c9-7f659b22befc',
        lastVisit: '3 ngày trước',
        diagnosis: 'Viêm da',
        age: '3 tuổi',
        gender: 'Đực',
        weight: '28 kg'
      },
      {
        id: 2,
        name: 'Kitty',
        species: 'Mèo Mướp',
        image: 'https://www.figma.com/api/mcp/asset/8b49f52a-230f-4db5-bd4a-9dafe0c324a8',
        lastVisit: '2 tháng trước',
        diagnosis: 'Tiêm phòng 3 bệnh',
        age: '2 tuổi',
        gender: 'Cái',
        weight: '3.5 kg'
      }
    ]
  },
  {
    id: 2,
    name: 'Trần Thị B',
    phone: '0912345678',
    type: 'vanglai',
    pets: [
      {
        id: 3,
        name: 'Mimi',
        species: 'Mèo Mướp',
        image: 'https://www.figma.com/api/mcp/asset/0c9926b8-75af-485d-9a9e-03313d5f87ca',
        lastVisit: 'Hôm nay',
        diagnosis: 'Tiêm phòng',
        age: '1 tuổi',
        gender: 'Cái',
        weight: '3 kg'
      }
    ]
  },
  {
    id: 3,
    name: 'Lê Văn C',
    phone: '0923456789',
    type: 'member',
    pets: [
      {
        id: 4,
        name: 'Bông',
        species: 'Mèo Anh lông dài',
        image: 'https://www.figma.com/api/mcp/asset/de5b3d83-fdf1-425e-a2b1-cd82f1ce26c6',
        lastVisit: '5 ngày trước',
        diagnosis: 'Tẩy giun định kỳ',
        age: '4 tuổi',
        gender: 'Đực',
        weight: '5 kg'
      }
    ]
  },
  {
    id: 4,
    name: 'Phạm Thị D',
    phone: '0934567890',
    type: 'vanglai',
    pets: [
      {
        id: 5,
        name: 'Max',
        species: 'Chó Husky',
        image: 'https://www.figma.com/api/mcp/asset/500ba864-bf69-491e-97c8-81316dcba68a',
        lastVisit: '1 tuần trước',
        diagnosis: 'Khám tổng quát',
        age: '2 tuổi',
        gender: 'Đực',
        weight: '25 kg'
      }
    ]
  }
])

// Computed filtered customers
const filteredCustomers = computed(() => {
  let filtered = customers.value

  // Filter by type
  if (selectedFilter.value === 'member') {
    filtered = filtered.filter(c => c.type === 'member')
  } else if (selectedFilter.value === 'vanglai') {
    filtered = filtered.filter(c => c.type === 'vanglai')
  }

  // Filter by search query
  if (searchQuery.value.trim()) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(customer => {
      const matchCustomer = 
        customer.name.toLowerCase().includes(query) ||
        customer.phone.includes(query)
      
      const matchPet = customer.pets.some(pet =>
        pet.name.toLowerCase().includes(query)
      )
      
      return matchCustomer || matchPet
    })
  }

  return filtered
})

// Methods
const viewRecord = (customerId, petId) => {
  console.log('View record:', customerId, petId)
  router.push('/doctor/benh-an/chi-tiet')
}
</script>
