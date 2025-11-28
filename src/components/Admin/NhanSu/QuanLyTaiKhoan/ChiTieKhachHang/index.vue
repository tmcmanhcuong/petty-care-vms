<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white border border-gray-200/60 rounded-[10px] shadow-lg w-[510px] max-h-[90vh] overflow-y-auto">
      <div class="p-6 flex flex-col gap-4">
        <!-- Header -->
        <div class="flex flex-col gap-2">
          <h2 class="font-nunito font-semibold text-lg leading-[18px] text-neutral-950 tracking-tight">
            Thông tin Khách hàng
          </h2>
          <p class="font-nunito text-sm leading-5 text-[#717182] tracking-tight">
            Lịch sử khám và thông tin chi tiết
          </p>
        </div>

        <!-- Content -->
        <div class="flex flex-col">
          <!-- Avatar -->
          <div class="flex justify-center mb-6">
            <div class="border-4 border-[#cbfbf1] rounded-full w-20 h-20 overflow-hidden">
              <img :src="customer.avatar" alt="Avatar" class="w-full h-full object-cover" />
            </div>
          </div>

          <!-- Customer Information Section -->
          <div class="bg-gray-50 rounded-[10px] p-4 mb-4">
            <div class="grid grid-cols-2 gap-4">
              <!-- Name -->
              <div class="flex flex-col">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Họ tên</span>
                <span class="font-nunito text-base leading-6 text-[#101828] tracking-tight">{{ customer.name }}</span>
              </div>
              
              <!-- Phone -->
              <div class="flex flex-col">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Số điện thoại</span>
                <span class="font-nunito text-base leading-6 text-[#101828] tracking-tight">{{ customer.phone }}</span>
              </div>
              
              <!-- Email -->
              <div class="flex flex-col">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Email</span>
                <span class="font-nunito text-base leading-6 text-[#101828] tracking-tight">{{ customer.email }}</span>
              </div>
              
              <!-- Rank -->
              <div class="flex flex-col">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Xếp hạng</span>
                <span 
                  :class="[
                    'inline-flex items-center px-2 py-[3px] rounded-lg text-xs leading-4 font-nunito font-medium mt-[2px] w-fit',
                    customer.rank === 'Gold' ? 'bg-[#fef3c6] text-[#bb4d00]' :
                    customer.rank === 'Silver' ? 'bg-gray-100 text-gray-700' :
                    'bg-orange-100 text-orange-700'
                  ]"
                >
                  {{ customer.rankIcon }} {{ customer.rank }}
                </span>
              </div>
              
              <!-- Address (full width) -->
              <div class="flex flex-col col-span-2">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Địa chỉ</span>
                <span class="font-nunito text-base leading-6 text-[#101828] tracking-tight">{{ customer.address }}</span>
              </div>
              
              <!-- Total Spending -->
              <div class="flex flex-col">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Tổng chi tiêu</span>
                <span class="font-nunito text-base leading-6 text-[#009689] tracking-tight">{{ formatCurrency(customer.totalSpent) }}</span>
              </div>
              
              <!-- Join Date -->
              <div class="flex flex-col">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Ngày tham gia</span>
                <span class="font-nunito text-base leading-6 text-[#101828] tracking-tight">{{ customer.joinDate }}</span>
              </div>
              
              <!-- Password -->
              <div class="flex flex-col">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Mật khẩu</span>
                <div class="flex items-center gap-2">
                  <span class="font-nunito text-sm leading-5 text-[#101828] tracking-tight">••••••••</span>
                  <button class="w-6 h-6 flex items-center justify-center hover:bg-gray-100 rounded transition-colors">
                    <img :src="iconEye" alt="Show" class="w-4 h-4" />
                  </button>
                </div>
              </div>
              
              <!-- Status -->
              <div class="flex flex-col">
                <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">Trạng thái</span>
                <span 
                  :class="[
                    'inline-flex items-center gap-2 px-2 py-[3px] rounded-lg text-xs leading-4 font-nunito font-medium mt-[2px] w-fit',
                    customer.status === 'active' ? 'bg-green-100 text-[#008236]' : 'bg-gray-100 text-[#364153]'
                  ]"
                >
                  <img :src="customer.status === 'active' ? iconCheck : iconX" alt="" class="w-3 h-3" />
                  {{ customer.status === 'active' ? 'Hoạt động' : 'Đã khóa' }}
                </span>
              </div>
            </div>
          </div>

          <!-- Pets Section -->
          <div class="flex flex-col gap-2 mb-4">
            <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight">
              Thú cưng
            </label>
            <div class="border border-gray-200/60 rounded-[10px] divide-y divide-gray-200/60">
              <div
                v-for="(pet, index) in customer.pets"
                :key="index"
                class="px-3 py-3"
              >
                <p class="font-nunito text-sm leading-5 text-[#101828] tracking-tight">{{ pet }}</p>
              </div>
            </div>
          </div>

          <!-- Recent Visit History Section -->
          <div class="flex flex-col gap-2">
            <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight">
              Lịch sử khám gần đây
            </label>
            <div class="border border-gray-200/60 rounded-[10px] p-3">
              <div
                v-for="(visit, index) in customer.recentVisits"
                :key="index"
                class="flex items-center justify-between"
                :class="{ 'mt-3 pt-3 border-t border-gray-200/60': index > 0 }"
              >
                <div class="flex flex-col">
                  <p class="font-nunito text-sm leading-5 text-[#101828] tracking-tight">{{ visit.service }}</p>
                  <p class="font-nunito text-xs leading-4 text-[#6a7282]">{{ visit.date }} - {{ visit.doctor }}</p>
                </div>
                <p class="font-nunito text-base leading-6 text-[#009689] tracking-tight">{{ formatCurrency(visit.cost) }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer Button -->
        <div class="flex items-center justify-end mt-2">
          <button
            @click="$emit('close')"
            class="bg-white border border-gray-200/60 rounded-lg h-9 px-[17px] py-[9px] hover:bg-gray-50 transition-colors"
          >
            <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Đóng</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Props
const props = defineProps({
  customer: {
    type: Object,
    default: () => ({
      avatar: 'https://www.figma.com/api/mcp/asset/69ab4ed0-d5a9-4482-8a8e-baeaf0347487',
      name: 'Trần Thị Hương',
      phone: '0912345678',
      email: 'huong.tran@email.com',
      rank: 'Gold',
      rankIcon: '🥇',
      address: '123 Lê Lợi, Quận 1, TP.HCM',
      totalSpent: 5200000,
      joinDate: '2024-11-20',
      status: 'active',
      pets: ['Milo', 'Luna'],
      recentVisits: [
        {
          service: 'Khám tổng quát',
          date: '15/11/2024',
          doctor: 'BS. Nguyễn Văn A',
          cost: 500000
        }
      ]
    })
  }
})

// Emits
const emit = defineEmits(['close'])

// Icons (from Figma - expire in 7 days)
const iconEye = "https://www.figma.com/api/mcp/asset/e9ca48ae-3e38-4bcf-8170-e98ca3d92d1d"
const iconCheck = "https://www.figma.com/api/mcp/asset/ee31047a-6029-4014-acfb-56748e1523ec"
const iconX = "https://www.figma.com/api/mcp/asset/1d86c67f-830e-4ef0-a6fe-45849993acf4"

// Methods
const formatCurrency = (amount) => {
  return amount.toLocaleString('vi-VN') + ' ₫'
}
</script>

<style scoped>
/* Custom scrollbar for modal */
div::-webkit-scrollbar {
  width: 8px;
}

div::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

div::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

div::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
