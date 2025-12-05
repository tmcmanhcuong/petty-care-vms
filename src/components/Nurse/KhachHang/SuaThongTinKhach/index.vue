<template>
  <Transition name="slide">
    <div v-if="isOpen" class="fixed inset-0 z-50 flex justify-end">
      <!-- Backdrop -->
      <div
        class="absolute inset-0 bg-black/50"
        @click="closeModal"
      ></div>

      <!-- Panel -->
      <div
        class="relative bg-white w-full max-w-[700px] h-full shadow-xl flex flex-col"
      >
      <!-- Header -->
      <div class="flex flex-col gap-1.5 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h2 class="text-base font-semibold text-neutral-950 tracking-[-0.3125px]">
            Thông tin khách hàng
          </h2>
          <button
            @click="closeModal"
            class="w-4 h-4 opacity-70 hover:opacity-100 transition-opacity"
          >
            <img :src="ICONS.close" alt="Đóng" class="w-full h-full" />
          </button>
        </div>
        <p class="text-sm text-[#717182] tracking-[-0.1504px]">
          Chi tiết hồ sơ và lịch sử giao dịch
        </p>
      </div>

      <!-- Customer Info Card -->
      <div class="p-6 flex flex-col gap-4">
        <div class="bg-blue-50 border-2 border-[#bedbff] rounded-[10px] p-[18px]">
          <div class="flex items-center gap-3">
            <!-- Avatar -->
            <div class="w-16 h-16 bg-[#bedbff] rounded-full flex items-center justify-center shrink-0">
              <img :src="ICONS.user" alt="User" class="w-8 h-8" />
            </div>

            <!-- Customer Details -->
            <div class="flex flex-col gap-2">
              <h3 class="text-xl font-bold text-[#101828] tracking-[-0.4492px]">
                {{ customer.name }}
              </h3>
              <div class="flex items-center gap-1">
                <img :src="ICONS.phone" alt="Phone" class="w-3 h-3" />
                <p class="text-sm text-[#4a5565] tracking-[-0.1504px]">
                  {{ customer.phone }}
                </p>
              </div>
              <div
                class="inline-flex items-center px-2 py-0.5 rounded-lg border border-transparent w-fit"
                :class="getMembershipStyle(customer.membership)"
              >
                <span class="text-xs font-medium">{{ customer.membership }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabs -->
        <div class="flex flex-col gap-4">
          <div class="flex items-center gap-2 border-b border-gray-200">
            <button
              @click="activeTab = 'pets'"
              class="px-0 py-2 text-sm tracking-[-0.1504px] transition-colors relative"
              :class="activeTab === 'pets' ? 'text-[#1447e6] border-b-2 border-[#1447e6]' : 'text-[#4a5565]'"
            >
              Danh sách Thú cưng
            </button>
            <button
              @click="activeTab = 'transactions'"
              class="px-0 py-2 text-sm tracking-[-0.1504px] transition-colors relative"
              :class="activeTab === 'transactions' ? 'text-[#1447e6] border-b-2 border-[#1447e6]' : 'text-[#4a5565]'"
            >
              Lịch sử Giao dịch
            </button>
          </div>

          <!-- Tab Content -->
          <div class="flex flex-col gap-4">
            <!-- Pets Tab -->
            <div v-if="activeTab === 'pets'" class="flex flex-col gap-4">
              <div
                v-for="pet in pets"
                :key="pet.id"
                class="bg-white border-2 border-black/10 rounded-[14px] p-[18px]"
              >
                <div class="flex gap-4">
                  <!-- Pet Image -->
                  <div class="w-20 h-20 rounded-[10px] overflow-hidden shrink-0">
                    <img
                      :src="pet.image"
                      :alt="pet.name"
                      class="w-full h-full object-cover"
                    />
                  </div>

                  <!-- Pet Details -->
                  <div class="flex flex-col gap-2 flex-1">
                    <h4 class="text-lg font-bold text-[#101828] tracking-[-0.4395px]">
                      {{ pet.name }}
                    </h4>
                    <p class="text-sm text-[#4a5565] tracking-[-0.1504px]">
                      {{ pet.species }} • {{ pet.age }} tuổi
                    </p>
                    <div class="bg-gray-50 border border-black/[0.15] rounded p-2 flex flex-col gap-1">
                      <p class="text-base text-[#364153] tracking-[-0.3125px]">
                        Lần khám gần nhất: {{ pet.lastVisit }}
                      </p>
                      <p class="text-base text-[#364153] tracking-[-0.3125px]">
                        Dịch vụ: {{ pet.lastService }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Add Pet Button -->
              <button
                @click="addNewPet"
                class="bg-white border border-black/10 rounded-lg px-[200px] py-3 flex items-center justify-center gap-4 hover:bg-gray-50 transition-colors"
              >
                <img :src="ICONS.plus" alt="Plus" class="w-4 h-4" />
                <span class="text-base font-semibold text-neutral-950 tracking-[-0.1504px]">
                  Thêm thú cưng mới
                </span>
              </button>
            </div>

            <!-- Transactions Tab -->
            <div v-else-if="activeTab === 'transactions'" class="flex flex-col gap-4">
              <div
                v-for="transaction in transactions"
                :key="transaction.id"
                class="bg-white border border-black/10 rounded-[14px] p-[17px]"
              >
                <div class="flex items-center justify-between">
                  <!-- Transaction Info -->
                  <div class="flex flex-col gap-2">
                    <h4 class="text-base font-bold text-[#101828] tracking-[-0.3125px]">
                      {{ transaction.service }}
                    </h4>
                    <p class="text-sm text-[#4a5565] tracking-[-0.1504px]">
                      {{ transaction.date }}
                    </p>
                  </div>

                  <!-- Amount and Status -->
                  <div class="flex flex-col gap-2 items-end">
                    <p class="text-lg font-bold text-[#101828] tracking-[-0.4395px]">
                      {{ formatCurrency(transaction.amount) }}
                    </p>
                    <div
                      class="bg-green-100 border border-transparent rounded-lg px-2 py-0.5"
                    >
                      <span class="text-xs font-medium text-[#008236]">
                        {{ transaction.status }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, computed } from 'vue'

// Icons from Figma (7-day expiry)
const ICONS = {
  close: 'https://www.figma.com/api/mcp/asset/093dfe48-7373-4a7a-9024-0246fea90bb9',
  user: 'https://www.figma.com/api/mcp/asset/cf96353e-47c6-439e-9925-62ad7e91b016',
  phone: 'https://www.figma.com/api/mcp/asset/b9bf8c53-efc7-4005-ad6f-205478453065',
  plus: 'https://www.figma.com/api/mcp/asset/3bd262e3-306f-475d-9429-8537b44c3979'
}

// Props
const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  customerId: {
    type: [String, Number],
    default: null
  }
})

// Emits
const emit = defineEmits(['close', 'addPet'])

// State
const activeTab = ref('pets')

// Sample customer data (replace with API call)
const customer = ref({
  name: 'Trần Thị B',
  phone: '0912345678',
  membership: 'Kim cương'
})

// Sample pets data (replace with API call)
const pets = ref([
  {
    id: 1,
    name: 'Max',
    species: 'Chó Husky',
    age: 3,
    image: 'https://www.figma.com/api/mcp/asset/5801e277-8a6c-4489-8ccb-6151089e5870',
    lastVisit: '15/11/2024',
    lastService: 'Spa & Tắm'
  }
])

// Sample transactions data (replace with API call)
const transactions = ref([
  {
    id: 1,
    service: 'Spa & Tắm',
    date: '15/11/2024',
    amount: 400000,
    status: 'Đã thanh toán'
  }
])

// Methods
const closeModal = () => {
  emit('close')
}

const addNewPet = () => {
  emit('addPet', customer.value.id)
}

const getMembershipStyle = (membership) => {
  const styles = {
    'Kim cương': 'bg-purple-100 text-[#8200db]',
    'Vàng': 'bg-[#fef9c2] text-[#a65f00]',
    'Bạc': 'bg-gray-100 text-[#364153]',
    'Thường': 'bg-gray-100 text-[#6a7282]'
  }
  return styles[membership] || 'bg-gray-100 text-gray-600'
}

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(amount)
}

// TODO: Fetch customer data, pets, and transactions from API when component mounts
// TODO: Implement real-time updates for customer information
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap');

* {
  font-family: 'Nunito Sans', sans-serif;
}

/* Slide Animation */
.slide-enter-active,
.slide-leave-active {
  transition: opacity 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  opacity: 0;
}

.slide-enter-active .relative,
.slide-leave-active .relative {
  transition: transform 0.3s ease-in-out;
}

.slide-enter-from .relative,
.slide-leave-to .relative {
  transform: translateX(100%);
}
</style>
