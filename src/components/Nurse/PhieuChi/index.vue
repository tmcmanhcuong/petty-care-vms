<template>
  <div class="flex flex-col gap-6 w-full font-nunito">
    <!-- Header -->
    <div class="flex flex-col">
      <h1 class="text-2xl font-medium text-[#101828] leading-9">Phiếu Chi</h1>
      <p class="text-base text-[#4a5565] leading-6">Quản lý chi phí và công nợ nhà cung cấp</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-3 gap-6">
      <!-- Tổng chi tháng này -->
      <div class="bg-white border border-black/10 rounded-[14px] p-[25px]">
        <div class="flex items-center justify-between">
          <div class="flex flex-col gap-1">
            <p class="text-sm text-[#4a5565] leading-5">Tổng chi tháng này</p>
            <p class="text-[30px] text-[#e7000b] leading-9">32.300.000đ</p>
            <p class="text-xs text-[#6a7282] leading-4">Tiền đi ra khỏi quỹ</p>
          </div>
          <div class="w-12 h-12 bg-[#ffe2e2] rounded-full flex items-center justify-center">
            <img :src="iconExpense" alt="" class="w-6 h-6" />
          </div>
        </div>
      </div>

      <!-- Nợ Nhà cung cấp -->
      <div class="bg-white border border-black/10 rounded-[14px] p-[25px]">
        <div class="flex items-center justify-between">
          <div class="flex flex-col gap-1">
            <p class="text-sm text-[#4a5565] leading-5">Nợ Nhà cung cấp</p>
            <p class="text-[30px] text-[#f54900] leading-9">15.000.000đ</p>
            <p class="text-xs text-[#6a7282] leading-4">Hàng nhập chưa trả</p>
          </div>
          <div class="w-12 h-12 bg-[#ffedd4] rounded-full flex items-center justify-center">
            <img :src="iconDebt" alt="" class="w-6 h-6" />
          </div>
        </div>
      </div>

      <!-- Chi phí Vận hành -->
      <div class="bg-white border border-black/10 rounded-[14px] p-[25px]">
        <div class="flex items-center justify-between">
          <div class="flex flex-col gap-1">
            <p class="text-sm text-[#4a5565] leading-5">Chi phí Vận hành</p>
            <p class="text-[30px] text-[#ff6900] leading-9">24.300.000đ</p>
            <p class="text-xs text-[#6a7282] leading-4">Điện, nước, thuê nhà</p>
          </div>
          <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center">
            <img :src="iconOperating" alt="" class="w-6 h-6" />
          </div>
        </div>
      </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white border border-black/10 rounded-[14px] p-[25px]">
      <div class="flex flex-col gap-4">
        <!-- Search Bar -->
        <div class="relative">
          <img :src="iconSearch" alt="" class="absolute left-3 top-2 w-5 h-5" />
          <input
            type="text"
            v-model="searchQuery"
            placeholder="Tìm theo Mã phiếu, Tên Nhà cung cấp, Nội dung chi..."
            class="w-full h-9 pl-10 pr-3 py-1 bg-[#f3f3f5] border-0 rounded-lg text-sm text-[#717182] focus:outline-none focus:ring-2 focus:ring-[#009689]"
          />
        </div>

        <!-- Filters and Create Button -->
        <div class="grid grid-cols-4 gap-4">
          <!-- Time Filter -->
          <button class="bg-[#f3f3f5] border-0 rounded-lg px-3 py-1 flex items-center justify-between h-9 hover:bg-gray-200 transition-colors">
            <span class="text-sm text-neutral-950">Tháng này</span>
            <img :src="iconChevronDown" alt="" class="w-4 h-4" />
          </button>

          <!-- Category Filter -->
          <button class="bg-[#f3f3f5] border-0 rounded-lg px-3 py-1 flex items-center justify-between h-9 hover:bg-gray-200 transition-colors">
            <span class="text-sm text-neutral-950">💰 Tất cả</span>
            <img :src="iconChevronDown" alt="" class="w-4 h-4" />
          </button>

          <!-- Status Filter -->
          <button class="bg-[#f3f3f5] border-0 rounded-lg px-3 py-1 flex items-center justify-between h-9 hover:bg-gray-200 transition-colors">
            <span class="text-sm text-neutral-950">Tất cả</span>
            <img :src="iconChevronDown" alt="" class="w-4 h-4" />
          </button>

          <!-- Create Button -->
          <button 
            @click="isCreateExpenseModalOpen = true"
            class="bg-[#e7000b] text-white rounded-lg px-3 py-1 flex items-center justify-center gap-2 h-9 hover:bg-[#c4000a] transition-colors"
          >
            <img :src="iconPlus" alt="" class="w-4 h-4" />
            <span class="text-sm font-medium">Tạo phiếu chi</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Expense Table -->
    <div class="bg-white border border-black/10 rounded-[14px] p-[25px]">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-black/10">
              <th class="text-left text-sm font-medium text-neutral-950 py-2.5 px-2">Mã Phiếu</th>
              <th class="text-left text-sm font-medium text-neutral-950 py-2.5 px-2">Ngày tạo</th>
              <th class="text-left text-sm font-medium text-neutral-950 py-2.5 px-2">Nội dung chi</th>
              <th class="text-left text-sm font-medium text-neutral-950 py-2.5 px-2">Phân loại</th>
              <th class="text-right text-sm font-medium text-neutral-950 py-2.5 px-2">Tổng giá trị</th>
              <th class="text-right text-sm font-medium text-neutral-950 py-2.5 px-2">Đã trả</th>
              <th class="text-right text-sm font-medium text-neutral-950 py-2.5 px-2">Còn nợ</th>
              <th class="text-left text-sm font-medium text-neutral-950 py-2.5 px-2">Trạng thái</th>
              <th class="text-right text-sm font-medium text-neutral-950 py-2.5 px-2">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <tr 
              v-for="expense in expenses" 
              :key="expense.id"
              class="border-b border-black/10 hover:bg-gray-50 transition-colors"
            >
              <!-- Mã Phiếu -->
              <td class="py-4 px-2">
                <p class="text-base font-medium text-[#009689] text-center">{{ expense.code }}</p>
              </td>

              <!-- Ngày tạo -->
              <td class="py-4 px-2">
                <div class="flex flex-col gap-1">
                  <p class="text-sm text-[#101828]">{{ expense.date }}</p>
                  <p class="text-xs text-[#6a7282]">{{ expense.time }}</p>
                </div>
              </td>

              <!-- Nội dung chi -->
              <td class="py-4 px-2">
                <div class="flex flex-col gap-1">
                  <p class="text-sm text-[#101828]">{{ expense.description }}</p>
                  <p class="text-xs text-[#6a7282] italic">{{ expense.supplier }}</p>
                </div>
              </td>

              <!-- Phân loại -->
              <td class="py-4 px-2">
                <span 
                  class="inline-block px-3 py-1 rounded-lg border text-xs font-medium"
                  :class="getCategoryClass(expense.category)"
                >
                  {{ expense.categoryLabel }}
                </span>
              </td>

              <!-- Tổng giá trị -->
              <td class="py-4 px-2 text-right">
                <p class="text-sm text-[#101828]">{{ formatCurrency(expense.totalAmount) }}</p>
              </td>

              <!-- Đã trả -->
              <td class="py-4 px-2 text-right">
                <p class="text-sm text-[#00a63e]">{{ formatCurrency(expense.paidAmount) }}</p>
              </td>

              <!-- Còn nợ -->
              <td class="py-4 px-2 text-right">
                <p 
                  class="text-sm"
                  :class="expense.remainingAmount > 0 ? 'text-[#e7000b]' : 'text-[#99a1af]'"
                >
                  {{ expense.remainingAmount > 0 ? formatCurrency(expense.remainingAmount) : '-' }}
                </p>
              </td>

              <!-- Trạng thái -->
              <td class="py-4 px-2">
                <span 
                  class="inline-block px-3 py-1 rounded-lg border-0 text-xs font-medium"
                  :class="getStatusClass(expense.status)"
                >
                  {{ expense.statusLabel }}
                </span>
              </td>

              <!-- Thao tác -->
              <td class="py-4 px-2">
                <div class="flex items-center justify-end gap-2">
                  <button 
                    v-if="expense.remainingAmount > 0"
                    @click="handleAddPayment(expense)"
                    class="w-9 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors"
                    title="Thanh toán"
                  >
                    <img :src="iconPayment" alt="" class="w-4 h-4" />
                  </button>
                  <button 
                    @click="handleViewExpense(expense)"
                    class="w-9 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors"
                    title="Xem chi tiết"
                  >
                    <img :src="iconEye" alt="" class="w-4 h-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>


    <!-- Modals -->
    <TaoPhieuChi
      v-if="isCreateExpenseModalOpen"
      @close="isCreateExpenseModalOpen = false"
      @submit="handleCreateExpense"
    />

    <ChiTietPhieuChi
      v-if="isViewExpenseModalOpen"
      :expense="selectedExpense"
      @close="isViewExpenseModalOpen = false"
    />

    <ThanhToanThem
      v-if="isAddPaymentModalOpen"
      :expense-code="selectedExpenseForPayment.code"
      :supplier-name="selectedExpenseForPayment.supplier"
      :total-amount="selectedExpenseForPayment.totalAmount"
      :paid-amount="selectedExpenseForPayment.paidAmount"
      :remaining-amount="selectedExpenseForPayment.remainingAmount"
      @close="isAddPaymentModalOpen = false"
      @submit="handlePaymentSubmit"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import TaoPhieuChi from './TaoPhieuChi/index.vue';
import ChiTietPhieuChi from './ChiTietPhieuChi/index.vue';
import ThanhToanThem from './ThanhToanThem/index.vue';

// Icons
const iconExpense = 'https://www.figma.com/api/mcp/asset/16735956-858e-46d4-bd3c-c2dd72763b52';
const iconDebt = 'https://www.figma.com/api/mcp/asset/ebec506a-9322-4167-bbbb-46b34cc43d8a';
const iconOperating = 'https://www.figma.com/api/mcp/asset/43c8fce2-6fb6-428d-974e-5dd1e67f313a';
const iconSearch = 'https://www.figma.com/api/mcp/asset/18f6e5fc-aeeb-43d8-80ec-e1ac650323bc';
const iconChevronDown = 'https://www.figma.com/api/mcp/asset/f86525a5-7485-445e-ad64-9a2d40a4b2f3';
const iconPlus = 'https://www.figma.com/api/mcp/asset/09d2faf2-37da-4687-9b25-b6f21f2111e6';
const iconPayment = 'https://www.figma.com/api/mcp/asset/c2d1d5da-d000-42b6-970e-025708bf6746';
const iconEye = 'https://www.figma.com/api/mcp/asset/4277dd85-ff95-4e74-aaea-333b4cbd8189';

// Define emits
const emit = defineEmits(['create-expense', 'view-detail', 'payment']);

// Search query
const searchQuery = ref('');
const isCreateExpenseModalOpen = ref(false);
const isViewExpenseModalOpen = ref(false);
const selectedExpense = ref(null);
const isAddPaymentModalOpen = ref(false);
const selectedExpenseForPayment = ref(null);

// Sample expense data
const expenses = ref([
  {
    id: 1,
    code: 'PC0056',
    date: '20/11/2025',
    time: '09:30',
    description: 'Nhập thuốc lô A1 - Tháng 11',
    supplier: '(NCC: Công ty CP Dược Thú Y Việt Nam)',
    category: 'purchase',
    categoryLabel: 'Nhập hàng',
    totalAmount: 15000000,
    paidAmount: 5000000,
    remainingAmount: 10000000,
    status: 'debt',
    statusLabel: 'Còn nợ NCC'
  },
  {
    id: 2,
    code: 'PC0055',
    date: '19/11/2025',
    time: '14:20',
    description: 'Tiền điện tháng 10/2025',
    supplier: '(NCC: Điện lực TP.HCM)',
    category: 'operating',
    categoryLabel: 'Vận hành',
    totalAmount: 3500000,
    paidAmount: 3500000,
    remainingAmount: 0,
    status: 'completed',
    statusLabel: 'Đã xong'
  },
  {
    id: 3,
    code: 'PC0054',
    date: '18/11/2025',
    time: '11:00',
    description: 'Nhập vắc-xin Nobivac',
    supplier: '(NCC: Nhà phân phối Vắc-xin Nobivac)',
    category: 'purchase',
    categoryLabel: 'Nhập hàng',
    totalAmount: 8000000,
    paidAmount: 8000000,
    remainingAmount: 0,
    status: 'completed',
    statusLabel: 'Đã xong'
  },
  {
    id: 4,
    code: 'PC0053',
    date: '15/11/2025',
    time: '16:45',
    description: 'Tiền nước tháng 10/2025',
    supplier: '(NCC: Cấp nước TP.HCM)',
    category: 'operating',
    categoryLabel: 'Vận hành',
    totalAmount: 800000,
    paidAmount: 800000,
    remainingAmount: 0,
    status: 'completed',
    statusLabel: 'Đã xong'
  },
  {
    id: 5,
    code: 'PC0052',
    date: '10/11/2025',
    time: '10:00',
    description: 'Nhập thức ăn cho chó mèo',
    supplier: '(NCC: Công ty CP Thức ăn Thú cưng Happy Pet)',
    category: 'purchase',
    categoryLabel: 'Nhập hàng',
    totalAmount: 12000000,
    paidAmount: 7000000,
    remainingAmount: 5000000,
    status: 'debt',
    statusLabel: 'Còn nợ NCC'
  },
  {
    id: 6,
    code: 'PC0051',
    date: '05/11/2025',
    time: '09:00',
    description: 'Tiền thuê mặt bằng tháng 11',
    supplier: '(NCC: Chủ nhà - Ông Nguyễn Văn X)',
    category: 'operating',
    categoryLabel: 'Vận hành',
    totalAmount: 20000000,
    paidAmount: 20000000,
    remainingAmount: 0,
    status: 'completed',
    statusLabel: 'Đã xong'
  }
]);

// Format currency
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'decimal',
    minimumFractionDigits: 0
  }).format(amount) + 'đ';
};

// Get category badge class
const getCategoryClass = (category) => {
  const classes = {
    purchase: 'bg-blue-100 border-black/10 text-[#1447e6]',
    operating: 'bg-[#fef9c2] border-black/10 text-[#a65f00]'
  };
  return classes[category] || 'bg-gray-100 border-black/10 text-gray-700';
};

// Get status badge class
const getStatusClass = (status) => {
  const classes = {
    completed: 'bg-green-100 text-[#008236]',
    debt: 'bg-[#ffedd4] text-[#ca3500]'
  };
  return classes[status] || 'bg-gray-100 text-gray-700';
};

const handleCreateExpense = (data) => {
  console.log('New expense data:', data);
  // Logic to create expense goes here
  isCreateExpenseModalOpen.value = false;
};

const handleViewExpense = (expense) => {
  // In a real app, you might fetch full details here
  // For now, we'll just use the expense object and add some mock history if missing
  const expenseWithHistory = { ...expense };
  if (!expenseWithHistory.paymentHistory) {
    expenseWithHistory.paymentHistory = [
      {
        date: '10:00 - 10/11/2025',
        method: '🏦 Chuyển khoản',
        amount: expense.paidAmount,
        note: 'Thanh toán đợt 1',
        status: 'success'
      }
    ];
  }
  // Add other missing fields with mock data
  if (!expenseWithHistory.recipient) expenseWithHistory.recipient = expense.supplier || 'Nhà cung cấp A';
  if (!expenseWithHistory.createdAt) expenseWithHistory.createdAt = `${expense.time} - ${expense.date}`;
  if (!expenseWithHistory.createdBy) expenseWithHistory.createdBy = 'Kế toán Hoa';

  selectedExpense.value = expenseWithHistory;
  isViewExpenseModalOpen.value = true;
};

const handleAddPayment = (expense) => {
  selectedExpenseForPayment.value = expense;
  isAddPaymentModalOpen.value = true;
};

const handlePaymentSubmit = (data) => {
  console.log('Payment submitted:', data);
  // Logic to process payment goes here
  isAddPaymentModalOpen.value = false;
};
</script>

<style scoped>
/* Ensure Nunito Sans font is applied */
.font-nunito {
  font-family: 'Nunito Sans', sans-serif;
}
</style>
