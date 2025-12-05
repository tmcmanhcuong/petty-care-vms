<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white border border-gray-200/60 rounded-[10px] shadow-lg w-[860px] max-h-[90vh] overflow-y-auto relative">
      <!-- Header -->
      <div class="flex flex-col gap-2 px-6 pt-6 pb-4">
        <h2 class="font-nunito font-semibold text-lg leading-[18px] text-neutral-950 tracking-tight">
          Tạo phiếu nhập hàng
        </h2>
        <p class="font-nunito text-sm leading-5 text-[#717182] tracking-tight">
          Nhập thông tin phiếu nhập kho mới
        </p>
      </div>

      <!-- Content -->
      <div class="flex flex-col gap-4 px-6 py-4">
        <!-- Row 1: Supplier & Date -->
        <div class="grid grid-cols-2 gap-4">
          <!-- Supplier -->
          <div class="flex flex-col gap-0">
            <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
              Nhà cung cấp (*)
            </label>
            <button
              class="bg-[#f3f3f5] border-none rounded-lg h-9 px-[13px] py-0.5 flex items-center justify-between hover:bg-gray-200 transition-colors mt-0"
            >
              <span class="font-nunito text-sm leading-5 text-[#717182] tracking-tight">{{ formData.supplier || 'Chọn nhà cung cấp' }}</span>
              <img :src="iconChevronDown" alt="" class="w-4 h-4" />
            </button>
          </div>

          <!-- Import Date -->
          <div class="flex flex-col gap-0">
            <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
              Ngày nhập (*)
            </label>
            <input
              v-model="formData.importDate"
              type="date"
              class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none mt-0"
            />
          </div>
        </div>

        <!-- Import Items Section -->
        <div class="bg-gray-50 border border-gray-200/60 rounded-[10px] p-[17px] flex flex-col gap-3">
          <!-- Section Header -->
          <div class="flex items-center justify-between h-8">
            <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight">
              Danh sách hàng nhập
            </label>
            <button
              @click="addItem"
              class="bg-white border border-gray-200/60 rounded-lg h-8 px-[11px] py-0 flex items-center gap-2 hover:bg-gray-50 transition-colors"
            >
              <img :src="iconPlus" alt="" class="w-4 h-4" />
              <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Thêm dòng</span>
            </button>
          </div>

          <!-- Items Table -->
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-gray-200/60">
                  <th class="text-left py-[10px] px-2 min-w-[155px]">
                    <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Tên hàng hóa (*)</span>
                  </th>
                  <th class="text-left py-[10px] px-2 min-w-[50px]">
                    <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Đơn vị</span>
                  </th>
                  <th class="text-left py-[10px] px-2 min-w-[87px]">
                    <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Số lượng (*)</span>
                  </th>
                  <th class="text-left py-[10px] px-2 min-w-[80px]">
                    <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Đơn giá (*)</span>
                  </th>
                  <th class="text-left py-[10px] px-2 min-w-[62px]">
                    <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Số lô (*)</span>
                  </th>
                  <th class="text-left py-[10px] px-2 min-w-[157px]">
                    <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Hạn sử dụng (*)</span>
                  </th>
                  <th class="text-left py-[10px] px-2 min-w-[78px]">
                    <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Thành tiền</span>
                  </th>
                  <th class="py-[10px] px-2 w-[52px]"></th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(item, index) in formData.items"
                  :key="index"
                >
                  <!-- Product Name -->
                  <td class="py-2 px-2">
                    <button
                      class="bg-[#f3f3f5] border-none rounded-lg h-9 px-[13px] py-0.5 flex items-center justify-between hover:bg-gray-200 transition-colors w-full"
                    >
                      <span class="font-nunito text-sm leading-5 text-[#717182] tracking-tight">{{ item.productName || 'Chọn hàng hóa' }}</span>
                      <img :src="iconChevronDown" alt="" class="w-4 h-4" />
                    </button>
                  </td>

                  <!-- Unit -->
                  <td class="py-2 px-2">
                    <input
                      v-model="item.unit"
                      type="text"
                      disabled
                      class="bg-gray-100 border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none opacity-50 w-full"
                    />
                  </td>

                  <!-- Quantity -->
                  <td class="py-2 px-2">
                    <input
                      v-model.number="item.quantity"
                      type="number"
                      placeholder="1"
                      class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none w-full"
                      @input="calculateTotal(index)"
                    />
                  </td>

                  <!-- Unit Price -->
                  <td class="py-2 px-2">
                    <input
                      v-model.number="item.unitPrice"
                      type="number"
                      placeholder="0"
                      class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-[#717182] tracking-tight outline-none w-full"
                      @input="calculateTotal(index)"
                    />
                  </td>

                  <!-- Lot Number -->
                  <td class="py-2 px-2">
                    <input
                      v-model="item.lotNumber"
                      type="text"
                      placeholder="LOT-2025-A"
                      class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-[#717182] tracking-tight outline-none w-full"
                    />
                  </td>

                  <!-- Expiry Date -->
                  <td class="py-2 px-2">
                    <input
                      v-model="item.expiryDate"
                      type="date"
                      class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none w-full"
                    />
                  </td>

                  <!-- Total Price -->
                  <td class="py-2 px-2">
                    <span class="font-nunito text-sm leading-5 text-[#009689] tracking-tight">
                      {{ formatCurrency(item.total) }}
                    </span>
                  </td>

                  <!-- Delete Button -->
                  <td class="py-2 px-2">
                    <button
                      @click="removeItem(index)"
                      class="rounded-lg h-8 w-9 flex items-center justify-center hover:bg-gray-100 transition-colors"
                    >
                      <img :src="iconTrash" alt="Delete" class="w-4 h-4" />
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Total Amount -->
        <div class="bg-teal-50 rounded-[10px] px-4 h-14 flex items-center justify-between">
          <span class="font-nunito text-base leading-6 text-[#364153] tracking-tight">
            Tổng tiền thanh toán:
          </span>
          <span class="font-nunito text-base leading-6 text-[#009689] tracking-tight">
            {{ formatCurrency(totalAmount) }}
          </span>
        </div>
      </div>

      <!-- Footer -->
      <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-gray-200/60">
        <button
          @click="$emit('close')"
          class="bg-white border border-gray-200/60 rounded-lg h-9 px-[17px] py-[9px] hover:bg-gray-50 transition-colors"
        >
          <span class="font-nunito font-medium text-sm leading-5 text-neutral-950 tracking-tight">Hủy</span>
        </button>
        <button
          @click="handleSubmit"
          class="bg-[#009689] rounded-lg h-9 px-4 py-2 hover:bg-[#007d72] transition-colors"
          :disabled="!isFormValid"
          :class="{ 'opacity-50 cursor-not-allowed': !isFormValid }"
        >
          <span class="font-nunito font-medium text-sm leading-5 text-white tracking-tight">Lưu phiếu nhập</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

// Props
defineProps({
  // No props needed for now
})

// Emits
const emit = defineEmits(['close', 'save'])

// Icons from Figma (expire in 7 days)
const iconChevronDown = "https://www.figma.com/api/mcp/asset/a1ded1f1-d0c6-4c3b-b997-f20959d61b35"
const iconPlus = "https://www.figma.com/api/mcp/asset/64d11dfb-2f3b-498d-8e70-f9abb7dc2277"
const iconTrash = "https://www.figma.com/api/mcp/asset/a52fd607-bafd-4638-a83e-c099f421cb2d"

// Form Data
const formData = ref({
  supplier: '',
  importDate: '',
  items: [
    {
      productName: '',
      unit: '',
      quantity: 1,
      unitPrice: 0,
      lotNumber: '',
      expiryDate: '',
      total: 0
    }
  ]
})

// Computed
const totalAmount = computed(() => {
  return formData.value.items.reduce((sum, item) => sum + (item.total || 0), 0)
})

const isFormValid = computed(() => {
  if (!formData.value.supplier || !formData.value.importDate) {
    return false
  }

  return formData.value.items.every(item => 
    item.productName &&
    item.quantity > 0 &&
    item.unitPrice > 0 &&
    item.lotNumber &&
    item.expiryDate
  )
})

// Methods
const addItem = () => {
  formData.value.items.push({
    productName: '',
    unit: '',
    quantity: 1,
    unitPrice: 0,
    lotNumber: '',
    expiryDate: '',
    total: 0
  })
}

const removeItem = (index) => {
  if (formData.value.items.length > 1) {
    formData.value.items.splice(index, 1)
  }
}

const calculateTotal = (index) => {
  const item = formData.value.items[index]
  item.total = (item.quantity || 0) * (item.unitPrice || 0)
}

const formatCurrency = (amount) => {
  return `${(amount || 0).toLocaleString('vi-VN')} ₫`
}

const handleSubmit = () => {
  if (isFormValid.value) {
    emit('save', formData.value)
  }
}
</script>

<style scoped>
/* Remove number input arrows */
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
  appearance: textfield;
}

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
