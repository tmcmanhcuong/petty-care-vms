<template>
  <div class="w-full min-h-screen flex flex-col gap-6 p-6">
    <!-- Shift Info Card (Blue Gradient) -->
    <!-- <div class="bg-gradient-to-r from-[#eff6ff] to-white border-2 border-[#bedbff] rounded-[14px] p-[18px]">
      <div class="flex items-center justify-between">
        
        <div class="flex items-center gap-8">
          
          <div class="flex items-center gap-2">
            <img :src="iconClock" alt="Clock" class="w-5 h-5" />
            <div class="flex flex-col gap-[2.5px]">
              <p class="font-nunito text-xs leading-4 text-[#6a7282]">
                Ca làm việc
              </p>
              <p class="font-nunito font-bold text-base leading-6 text-[#101828] tracking-[-0.3125px]">
                {{ shiftInfo.name }}
              </p>
            </div>
          </div>

          <div class="w-px h-10 bg-[#d1d5dc]"></div>

          
          <div class="flex items-center gap-2">
            <img :src="iconStatus" alt="Status" class="w-5 h-5" />
            <div class="flex flex-col gap-[2.5px]">
              <p class="font-nunito text-xs leading-4 text-[#6a7282]">
                Trạng thái
              </p>
              <span class="bg-green-100 border border-transparent rounded-lg px-2 py-[3px] font-nunito font-medium text-xs leading-4 text-[#008236]">
                Đang mở
              </span>
            </div>
          </div>

          <div class="w-px h-10 bg-[#d1d5dc]"></div>

          
          <div class="flex items-center gap-2">
            <img :src="iconCash" alt="Cash" class="w-5 h-5" />
            <div class="flex flex-col gap-[2.5px]">
              <p class="font-nunito text-xs leading-4 text-[#6a7282]">
                Đầu ca
              </p>
              <p class="font-nunito font-bold text-base leading-6 text-[#101828] tracking-[-0.3125px]">
                {{ formatCurrency(shiftInfo.startingCash) }}
              </p>
            </div>
          </div>

          <div class="w-px h-10 bg-[#d1d5dc]"></div>

          
          <div class="flex items-center gap-2">
            <img :src="iconRevenue" alt="Revenue" class="w-5 h-5" />
            <div class="flex flex-col gap-[2.5px]">
              <p class="font-nunito text-xs leading-4 text-[#6a7282]">
                Doanh thu tiền mặt
              </p>
              <p class="font-nunito font-bold text-base leading-6 text-[#00a63e] tracking-[-0.3125px]">
                +{{ formatCurrency(shiftInfo.cashRevenue) }}
              </p>
            </div>
          </div>
        </div>

        
        <button
          class="bg-[#e7000b] rounded-lg px-3 py-2 flex items-center gap-4 hover:bg-[#c5000a] transition-colors"
          @click="endShift"
        >
          <img :src="iconLock" alt="Lock" class="w-4 h-4" />
          <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
            Kết thúc ca & Bàn giao
          </span>
        </button>
      </div>
    </div> -->

    <!-- Main Content -->
    <div v-if="!selectedInvoice" class="flex flex-col gap-6">
      <!-- Header -->
      <div class="flex flex-col h-[60px]">
        <h1 class="font-nunito font-medium text-2xl leading-9 text-[#101828] tracking-[0.0703px]">
          Tài chính & Hóa đơn (POS)
        </h1>
        <p class="font-nunito text-base leading-6 text-[#4a5565] tracking-[-0.3125px]">
          Thu ngân - Thanh toán dịch vụ
        </p>
      </div>

      <!-- Search and Create Card -->
      <div class="bg-white border border-black/10 rounded-[14px] p-[17px]">
        <div class="flex items-center justify-between">
          <!-- Search Input -->
          <div class="relative flex-1 max-w-[785px]">
            <img
              :src="iconSearch"
              alt="Search"
              class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5"
            />
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Nhập mã hóa đơn hoặc SĐT khách..."
              class="w-full h-12 bg-[#f3f3f5] border border-transparent rounded-lg pl-10 pr-3 py-1 font-nunito text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:border-[#009689]"
            />
          </div>

          <!-- Create Retail Invoice Button -->
          <button
            class="bg-[#00a63e] rounded-lg px-3 py-[14px] flex items-center gap-4 hover:bg-[#008833] transition-colors"
            @click="createRetailInvoice"
          >
            <img :src="iconPlus" alt="Plus" class="w-4 h-4" />
            <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
              Tạo hóa đơn bán lẻ
            </span>
          </button>
        </div>
      </div>

      <!-- Pending Invoices Card -->
      <div class="bg-white border border-black/10 rounded-[14px] px-[25px] py-[25px] flex flex-col gap-[30px]">
        <h2 class="font-nunito text-base leading-4 text-[#101828] tracking-[-0.3125px]">
          Hóa đơn chờ thanh toán
        </h2>

        <!-- Invoice List -->
        <div class="flex flex-col gap-3">
          <button
            v-for="invoice in filteredInvoices"
            :key="invoice.id"
            class="border-2 border-gray-200 rounded-[10px] p-4 hover:border-[#009689] transition-colors text-left"
            @click="viewInvoice(invoice)"
          >
            <!-- Invoice Header -->
            <div class="flex items-center justify-between mb-2">
              <!-- Invoice ID and Customer -->
              <div class="flex flex-col">
                <p class="font-nunito font-bold text-base leading-6 text-[#101828] tracking-[-0.3125px]">
                  {{ invoice.invoiceId }}
                </p>
                <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
                  {{ invoice.customerName }} - {{ invoice.petName }}
                </p>
              </div>

              <!-- Amount and Status -->
              <div class="flex flex-col items-end">
                <p class="font-nunito font-bold text-lg leading-7 text-[#155dfc] tracking-[-0.4395px]">
                  {{ formatCurrency(invoice.amount) }}
                </p>
                <span class="bg-[#fef9c2] border border-transparent rounded-lg px-2 py-[3px] font-nunito font-medium text-xs leading-4 text-[#a65f00]">
                  Chờ thanh toán
                </span>
              </div>
            </div>

            <!-- Invoice Date -->
            <p class="font-nunito text-xs leading-4 text-[#6a7282]">
              Ngày: {{ invoice.date }}
            </p>
          </button>
        </div>
      </div>
    </div>

    <!-- Detail View -->
    <div v-else class="flex flex-col gap-4">
      <!-- Back Button -->
      <button 
        class="flex items-center gap-2 text-[#4a5565] hover:text-[#101828] transition-colors w-fit"
        @click="selectedInvoice = null"
      >
        <img :src="iconArrowLeft" alt="Back" class="w-5 h-5 rotate-180" />
        <span class="font-nunito font-medium text-sm leading-5">Quay lại danh sách</span>
      </button>

      <ChiTietHoaDon 
        :invoice-id="selectedInvoice.invoiceId" 
        @changeInvoice="selectedInvoice = null"
        @complete="handlePaymentComplete"
      />
    </div>

    <!-- Create Retail Invoice Modal -->
    <TaoHoaDon
      :is-open="isTaoHoaDonOpen"
      @close="isTaoHoaDonOpen = false"
      @complete="handleRetailInvoiceComplete"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import ChiTietHoaDon from './ChiTietHoaDon/index.vue'
import TaoHoaDon from './TaoHoaDon/index.vue'

// Icons
const iconClock = "https://www.figma.com/api/mcp/asset/d5f9a429-69cb-4ed2-9ffa-7f8149547512"
const iconStatus = "https://www.figma.com/api/mcp/asset/f3445a93-7029-4dcb-8df2-a06d657787c8"
const iconCash = "https://www.figma.com/api/mcp/asset/1f8bf05e-8c7b-4a04-8794-6ed76fb885c3"
const iconRevenue = "https://www.figma.com/api/mcp/asset/ed1db92d-3827-41c8-af98-782817619120"
const iconLock = "https://www.figma.com/api/mcp/asset/cf0bcea0-b770-4e92-b6b1-a1a55389fb0c"
const iconSearch = "https://www.figma.com/api/mcp/asset/b901c038-cd1f-4ed5-8d13-6024afc9e670"
const iconPlus = "https://www.figma.com/api/mcp/asset/d918040c-7daa-4ec7-bb71-eeccf868527e"
const iconArrowLeft = "https://www.figma.com/api/mcp/asset/2bb7bd10-d9fa-46f4-8c76-259dd73e0fd2" // Reusing chevron/arrow icon if available or generic

// State
const searchQuery = ref('')
const selectedInvoice = ref(null)
const isTaoHoaDonOpen = ref(false)

// Shift Information
const shiftInfo = ref({
  name: 'Sáng (08:00 - 14:00)',
  status: 'open',
  startingCash: 2000000,
  cashRevenue: 1500000
})

// Pending Invoices
const pendingInvoices = ref([
  {
    id: 1,
    invoiceId: 'HD001234',
    customerName: 'Nguyễn Văn A',
    petName: 'Milo',
    amount: 400000,
    status: 'pending',
    date: '21/11/2024'
  },
  {
    id: 2,
    invoiceId: 'HD001235',
    customerName: 'Trần Thị B',
    petName: 'Luna',
    amount: 242000,
    status: 'pending',
    date: '21/11/2024'
  }
])

// Computed
const filteredInvoices = computed(() => {
  if (!searchQuery.value) {
    return pendingInvoices.value
  }

  const query = searchQuery.value.toLowerCase()
  return pendingInvoices.value.filter(invoice =>
    invoice.invoiceId.toLowerCase().includes(query) ||
    invoice.customerName.toLowerCase().includes(query) ||
    invoice.petName.toLowerCase().includes(query)
  )
})

// Methods
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'decimal'
  }).format(amount) + ' ₫'
}

const endShift = () => {
  console.log('End shift and handover')
  // TODO: Implement end shift modal with cash reconciliation
}

const createRetailInvoice = () => {
  isTaoHoaDonOpen.value = true
}

const viewInvoice = (invoice) => {
  console.log('View invoice:', invoice.invoiceId)
  selectedInvoice.value = invoice
}

const handlePaymentComplete = (data) => {
  console.log('Payment completed:', data)
  selectedInvoice.value = null
  // Here you would typically refresh the list or remove the paid invoice
}

const handleRetailInvoiceComplete = (data) => {
  console.log('Retail invoice created:', data)
  isTaoHoaDonOpen.value = false
  // Here you would typically refresh the list or add the new invoice
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700&display=swap');

* {
  font-family: 'Nunito Sans', sans-serif;
}
</style>
