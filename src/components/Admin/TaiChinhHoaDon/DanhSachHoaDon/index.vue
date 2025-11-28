<template>
  <div class="w-full min-h-screen  p-6 flex flex-col gap-6">
    <!-- Page Header -->
    <div class="flex flex-col h-[60px]">
      <h1 class="font-nunito font-medium text-2xl leading-9 text-[#101828] tracking-[0.0703px]">
        Danh sách Hóa đơn
      </h1>
      <p class="font-nunito text-base leading-6 text-[#4a5565] tracking-tight">
        Quản lý và theo dõi dòng tiền
      </p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-3 gap-6 h-[130px]">
      <!-- Today's Revenue -->
      <div class="bg-white border border-black/10 rounded-[14px] p-6 flex items-center justify-between">
        <div class="flex flex-col gap-1">
          <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
            Doanh thu hôm nay
          </p>
          <p class="font-nunito text-[30px] leading-9 text-[#00a63e] tracking-[0.3955px]">
            1.550.000đ
          </p>
          <p class="font-nunito text-xs leading-4 text-[#6a7282]">
            Đã trừ hoàn tiền
          </p>
        </div>
        <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center">
          <img :src="iconRevenue" alt="Revenue" class="w-6 h-6" />
        </div>
      </div>

      <!-- Unpaid -->
      <div class="bg-white border border-black/10 rounded-[14px] p-6 flex items-center justify-between">
        <div class="flex flex-col gap-1">
          <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
            Chưa thanh toán
          </p>
          <p class="font-nunito text-[30px] leading-9 text-[#f54900] tracking-[0.3955px]">
            800.000đ
          </p>
          <p class="font-nunito text-xs leading-4 text-[#6a7282]">
            Tổng giá trị HĐ chưa thanh toán
          </p>
        </div>
        <div class="bg-[#ffedd4] rounded-full w-12 h-12 flex items-center justify-center">
          <img :src="iconUnpaid" alt="Unpaid" class="w-6 h-6" />
        </div>
      </div>

      <!-- Refunded -->
      <div class="bg-white border border-black/10 rounded-[14px] p-6 flex items-center justify-between">
        <div class="flex flex-col gap-1">
          <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-tight">
            Đã hoàn tiền
          </p>
          <p class="font-nunito text-[30px] leading-9 text-[#9810fa] tracking-[0.3955px]">
            2.950.000đ
          </p>
          <p class="font-nunito text-xs leading-4 text-[#6a7282]">
            Tiền trả lại khách
          </p>
        </div>
        <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center">
          <img :src="iconRefund" alt="Refund" class="w-6 h-6" />
        </div>
      </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white border border-black/10 rounded-[14px] p-6">
      <div class="flex flex-col gap-4">
        <!-- Search Bar -->
        <div class="relative">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Tìm theo Mã hóa đơn, Tên khách hàng, SĐT..."
            class="bg-[#f3f3f5] border border-transparent rounded-lg h-9 pl-10 pr-3 w-full font-nunito text-sm text-[#717182] tracking-tight focus:outline-none focus:ring-2 focus:ring-[#009689]"
          />
          <img :src="iconSearch" alt="Search" class="absolute left-3 top-[9px] w-5 h-5" />
        </div>

        <!-- Filter Buttons -->
        <div class="grid grid-cols-4 gap-4">
          <button class="bg-[#f3f3f5] border border-transparent rounded-lg h-9 px-[13px] flex items-center justify-between hover:bg-gray-200 transition-colors">
            <span class="font-nunito text-sm leading-5 text-neutral-950 tracking-tight">
              Hôm nay
            </span>
            <img :src="iconChevronDown" alt="Dropdown" class="w-4 h-4" />
          </button>

          <button class="bg-[#f3f3f5] border border-transparent rounded-lg h-9 px-[13px] flex items-center justify-between hover:bg-gray-200 transition-colors">
            <span class="font-nunito text-sm leading-5 text-neutral-950 tracking-tight">
              Tất cả
            </span>
            <img :src="iconChevronDown" alt="Dropdown" class="w-4 h-4" />
          </button>

          <button class="bg-[#f3f3f5] border border-transparent rounded-lg h-9 px-[13px] flex items-center justify-between hover:bg-gray-200 transition-colors">
            <span class="font-nunito text-sm leading-5 text-neutral-950 tracking-tight">
              💰 Tất cả
            </span>
            <img :src="iconChevronDown" alt="Dropdown" class="w-4 h-4" />
          </button>

          <button class="bg-white border border-black/10 rounded-lg h-9 px-3 flex items-center justify-center gap-2 hover:bg-gray-50 transition-colors">
            <img :src="iconExport" alt="Export" class="w-4 h-4" />
            <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
              Xuất Excel
            </span>
          </button>
        </div>
      </div>
    </div>

    <!-- Invoice Table -->
    <div class="bg-white border border-black/10 rounded-[14px] p-6">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-black/10">
              <th class="text-left px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Mã HĐ
              </th>
              <th class="text-left px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Thời gian
              </th>
              <th class="text-left px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Khách hàng
              </th>
              <th class="text-right px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Tổng giá trị
              </th>
              <th class="text-right px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Đã thanh toán
              </th>
              <th class="text-left px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Hình thức
              </th>
              <th class="text-left px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Trạng thái
              </th>
              <th class="text-left px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Người thu
              </th>
              <th class="text-right px-2 py-[10px] font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">
                Thao tác
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(invoice, index) in invoices"
              :key="index"
              class="border-b border-black/10 hover:bg-gray-50 transition-colors"
            >
              <!-- Invoice Code -->
              <td class="px-2 py-4">
                <p class="font-nunito font-medium text-base leading-6 text-[#009689] tracking-tight">
                  {{ invoice.code }}
                </p>
              </td>

              <!-- Time -->
              <td class="px-2 py-[8.5px]">
                <div class="flex flex-col gap-1">
                  <p class="font-nunito text-sm leading-5 text-[#101828] tracking-tight">
                    {{ invoice.time }}
                  </p>
                  <p class="font-nunito text-xs leading-4 text-[#6a7282]">
                    {{ invoice.date }}
                  </p>
                </div>
              </td>

              <!-- Customer -->
              <td class="px-2 py-[8.5px]">
                <div class="flex flex-col gap-1">
                  <p class="font-nunito text-sm leading-5 text-[#101828] tracking-tight">
                    {{ invoice.customer }}
                  </p>
                  <p class="font-nunito text-xs leading-4 text-[#6a7282]">
                    Pet: {{ invoice.petName }}
                  </p>
                </div>
              </td>

              <!-- Total Amount -->
              <td class="px-2 py-[19px]">
                <p class="font-nunito text-sm leading-5 text-[#101828] text-right tracking-tight">
                  {{ formatCurrency(invoice.totalAmount) }}
                </p>
              </td>

              <!-- Paid Amount -->
              <td class="px-2 py-5">
                <p
                  :class="[
                    'font-nunito text-sm leading-5 text-right tracking-tight',
                    invoice.paidAmount > 0 ? getPaidAmountColor(invoice.status) : 'text-[#99a1af]'
                  ]"
                >
                  {{ invoice.paidAmount > 0 ? formatCurrency(invoice.paidAmount) : '0 đ' }}
                </p>
              </td>

              <!-- Payment Method -->
              <td class="px-2 py-[17.5px]">
                <span
                  :class="[
                    'inline-flex items-center px-2 py-[3px] rounded-lg font-nunito font-medium text-xs leading-4 border',
                    getPaymentMethodStyle(invoice.paymentMethod)
                  ]"
                >
                  {{ getPaymentMethodLabel(invoice.paymentMethod) }}
                </span>
              </td>

              <!-- Status -->
              <td class="px-2 py-[17.5px]">
                <span
                  :class="[
                    'inline-flex items-center px-2 py-[3px] rounded-lg font-nunito font-medium text-xs leading-4 border-0',
                    getStatusStyle(invoice.status)
                  ]"
                >
                  {{ getStatusLabel(invoice.status) }}
                </span>
              </td>

              <!-- Collector -->
              <td class="px-2 py-[8.5px]">
                <div class="flex flex-col gap-1">
                  <p class="font-nunito text-sm leading-5 text-[#101828] tracking-tight">
                    {{ invoice.collector }}
                  </p>
                  <p class="font-nunito text-xs leading-4 text-[#6a7282]">
                    {{ invoice.department }}
                  </p>
                </div>
              </td>

              <!-- Actions -->
              <td class="px-2 py-[12.5px]">
                <div class="flex items-center justify-end gap-2">
                  <button 
                    @click="handleViewInvoice(invoice)"
                    class="w-9 h-8 flex items-center justify-center hover:bg-gray-100 rounded-lg transition-colors"
                  >
                    <img :src="iconEye" alt="View" class="w-4 h-4" />
                  </button>
                  <button class="w-9 h-8 flex items-center justify-center hover:bg-gray-100 rounded-lg transition-colors">
                    <img :src="iconPrint" alt="Print" class="w-4 h-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>


    <!-- Modals -->
    <ChiTietHoaDon
      v-if="isInvoiceDetailModalOpen"
      :invoice="selectedInvoice"
      @close="isInvoiceDetailModalOpen = false"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import ChiTietHoaDon from './ChiTietHoaDon/index.vue'

// Icons (from Figma - expire in 7 days)
const iconRevenue = "https://www.figma.com/api/mcp/asset/9f1cb0c2-182d-4a3a-bb7b-2139013a45c5"
const iconUnpaid = "https://www.figma.com/api/mcp/asset/c13106c5-b275-4da8-a138-03801a16cd98"
const iconRefund = "https://www.figma.com/api/mcp/asset/359bdf8e-f1ba-4521-bde3-18ffe8839f89"
const iconChevronDown = "https://www.figma.com/api/mcp/asset/0177450d-db2e-45f6-82b3-d1a6deb55501"
const iconExport = "https://www.figma.com/api/mcp/asset/582dabfb-4982-4e22-b3f8-b5f959ef8b41"
const iconSearch = "https://www.figma.com/api/mcp/asset/22aa5763-66c1-47ab-b737-0e47a028f845"
const iconEye = "https://www.figma.com/api/mcp/asset/157e4595-5bbf-4983-9373-60ffb98cfae8"
const iconPrint = "https://www.figma.com/api/mcp/asset/89ca15b0-53cf-4c64-84b1-6d7cdcc94e1d"

// Reactive state
const searchQuery = ref('')
const isInvoiceDetailModalOpen = ref(false)
const selectedInvoice = ref(null)

// Sample data
const invoices = ref([
  {
    code: 'HD001234',
    time: '10:30',
    date: '20/11/2025',
    customer: 'Nguyễn Văn A',
    petName: 'Milo',
    totalAmount: 1000000,
    paidAmount: 1000000,
    paymentMethod: 'cash',
    status: 'paid',
    collector: 'Thu ngân Mai',
    department: '(Khoa Vận hành)'
  },
  {
    code: 'HD001235',
    time: '11:15',
    date: '20/11/2025',
    customer: 'Trần Thị B',
    petName: 'Luna',
    totalAmount: 800000,
    paidAmount: 0,
    paymentMethod: 'cash',
    status: 'unpaid',
    collector: 'Thu ngân Mai',
    department: '(Khoa Vận hành)'
  },
  {
    code: 'HD001236',
    time: '14:20',
    date: '20/11/2025',
    customer: 'Lê Văn C',
    petName: 'Max',
    totalAmount: 550000,
    paidAmount: 550000,
    paymentMethod: 'vnpay',
    status: 'paid',
    collector: 'Thu ngân Lan',
    department: '(Khoa Vận hành)'
  },
  {
    code: 'HD001237',
    time: '15:45',
    date: '20/11/2025',
    customer: 'Phạm Thị D',
    petName: 'Bella',
    totalAmount: 2500000,
    paidAmount: 2500000,
    paymentMethod: 'transfer',
    status: 'refunded',
    collector: 'Thu ngân Mai',
    department: '(Khoa Vận hành)'
  },
  {
    code: 'HD001239',
    time: '16:30',
    date: '20/11/2025',
    customer: 'Võ Thị F',
    petName: 'Kitty',
    totalAmount: 450000,
    paidAmount: 450000,
    paymentMethod: 'cash',
    status: 'refunding',
    collector: 'Thu ngân Mai',
    department: '(Khoa Vận hành)'
  }
])

// Methods
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND',
    minimumFractionDigits: 0
  }).format(amount).replace('₫', 'đ')
}

const getPaymentMethodLabel = (method) => {
  const labels = {
    'cash': 'Tiền mặt',
    'vnpay': 'VNPay',
    'transfer': 'Chuyển khoản'
  }
  return labels[method] || method
}

const getPaymentMethodStyle = (method) => {
  const styles = {
    'cash': 'bg-gray-100 border-black/10 text-[#364153]',
    'vnpay': 'bg-purple-100 border-black/10 text-[#8200db]',
    'transfer': 'bg-blue-100 border-black/10 text-[#1447e6]'
  }
  return styles[method] || 'bg-gray-100 border-black/10 text-[#364153]'
}

const getStatusLabel = (status) => {
  const labels = {
    'paid': 'Đã thanh toán',
    'unpaid': 'Chưa thanh toán',
    'refunded': 'Đã hoàn tiền',
    'refunding': 'Đang hoàn tiền'
  }
  return labels[status] || status
}

const getStatusStyle = (status) => {
  const styles = {
    'paid': 'bg-green-100 text-[#008236]',
    'unpaid': 'bg-[#ffedd4] text-[#ca3500]',
    'refunded': 'bg-blue-100 text-[#1447e6]',
    'refunding': 'bg-[#fef9c2] text-[#a65f00]'
  }
  return styles[status] || 'bg-gray-100 text-[#364153]'
}

const getPaidAmountColor = (status) => {
  const colors = {
    'paid': 'text-[#00a63e]',
    'refunded': 'text-[#155dfc]',
    'refunding': 'text-[#d08700]'
  }
  return colors[status] || 'text-[#101828]'
}

const handleViewInvoice = (invoice) => {
  selectedInvoice.value = invoice
  isInvoiceDetailModalOpen.value = true
}
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
