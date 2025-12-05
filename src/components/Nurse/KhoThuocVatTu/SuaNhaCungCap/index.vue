<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white border border-gray-200/60 rounded-[10px] shadow-lg w-[510px] max-h-[90vh] overflow-y-auto relative">
      <!-- Close Button -->
      <button
        @click="$emit('close')"
        class="absolute right-4 top-4 w-4 h-4 opacity-70 hover:opacity-100 transition-opacity"
      >
        <img :src="iconClose" alt="Close" class="w-full h-full" />
      </button>

      <!-- Header -->
      <div class="flex flex-col gap-2 px-6 pt-6 pb-4">
        <h2 class="font-nunito font-semibold text-lg leading-[18px] text-neutral-950 tracking-tight">
          Sửa thông tin Nhà cung cấp
        </h2>
        <p class="font-nunito text-sm leading-5 text-[#717182] tracking-tight">
          Cập nhật thông tin nhà cung cấp
        </p>
      </div>

      <!-- Content -->
      <div class="flex flex-col gap-4 px-6 py-4">
        <!-- Company Information Section -->
        <div class="flex flex-col gap-3 pb-4 border-b border-gray-200/60">
          <h3 class="font-nunito text-sm leading-5 text-[#364153] tracking-tight">
            Thông tin Công ty
          </h3>

          <div class="grid grid-cols-2 gap-4">
            <!-- Supplier Code -->
            <div class="flex flex-col gap-0">
              <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
                Mã NCC
              </label>
              <input
                v-model="formData.code"
                type="text"
                disabled
                class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-[#717182] tracking-tight outline-none opacity-50 mt-0"
              />
            </div>

            <!-- Supplier Name -->
            <div class="flex flex-col gap-0">
              <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
                Tên nhà cung cấp (*)
              </label>
              <input
                v-model="formData.name"
                type="text"
                class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none placeholder:text-[#717182] mt-0"
              />
            </div>
          </div>

          <!-- Address -->
          <div class="flex flex-col gap-0">
            <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
              Địa chỉ
            </label>
            <input
              v-model="formData.address"
              type="text"
              class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none placeholder:text-[#717182] mt-0"
            />
          </div>

          <!-- Tax Code -->
          <div class="grid grid-cols-2 gap-4">
            <div class="flex flex-col gap-0">
              <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
                Mã số thuế (Optional)
              </label>
              <input
                v-model="formData.taxCode"
                type="text"
                class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none placeholder:text-[#717182] mt-0"
              />
            </div>
          </div>
        </div>

        <!-- Contact Information Section -->
        <div class="flex flex-col gap-3">
          <h3 class="font-nunito text-sm leading-5 text-[#364153] tracking-tight">
            Thông tin Người liên hệ (Sales)
          </h3>

          <div class="grid grid-cols-2 gap-4">
            <!-- Contact Name -->
            <div class="flex flex-col gap-0">
              <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
                Tên người liên hệ
              </label>
              <input
                v-model="formData.contactName"
                type="text"
                class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none placeholder:text-[#717182] mt-0"
              />
            </div>

            <!-- Phone -->
            <div class="flex flex-col gap-0">
              <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
                Số điện thoại (*)
              </label>
              <input
                v-model="formData.phone"
                type="tel"
                class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none placeholder:text-[#717182] mt-0"
              />
            </div>
          </div>

          <!-- Email -->
          <div class="flex flex-col gap-0">
            <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
              Email
            </label>
            <input
              v-model="formData.email"
              type="email"
              class="bg-[#f3f3f5] border-none rounded-lg h-9 px-3 py-1 font-nunito text-sm text-neutral-950 tracking-tight outline-none placeholder:text-[#717182] mt-0"
            />
          </div>

          <!-- Notes -->
          <div class="flex flex-col gap-0">
            <label class="font-nunito font-medium text-sm leading-[14px] text-neutral-950 tracking-tight mb-0">
              Ghi chú
            </label>
            <textarea
              v-model="formData.notes"
              rows="3"
              class="bg-[#f3f3f5] border-none rounded-lg px-3 py-2 font-nunito text-sm text-neutral-950 tracking-tight outline-none placeholder:text-[#717182] resize-none mt-0"
            ></textarea>
          </div>
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
          <span class="font-nunito font-medium text-sm leading-5 text-white tracking-tight">Lưu lại</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

// Props
const props = defineProps({
  supplier: {
    type: Object,
    default: () => ({
      code: 'SUP001',
      name: 'Công ty TNHH Dược phẩm ABC',
      address: '123 Đường A, Quận 1, TP.HCM',
      taxCode: '0123456789',
      contactName: 'Nguyễn Văn An',
      phone: '0909123456',
      email: 'an.nguyen@abc.com',
      notes: 'VD: Chuyên cung cấp vắc-xin, giao hàng thứ 3 hàng tuần...'
    })
  }
})

// Emits
const emit = defineEmits(['close', 'save'])

// Icons from Figma (expire in 7 days)
const iconClose = "https://www.figma.com/api/mcp/asset/ce7cfa47-4f81-4cba-8129-ffee46fef68b"

// Form Data - pre-populated with supplier data
const formData = ref({
  code: props.supplier.code,
  name: props.supplier.name,
  address: props.supplier.address,
  taxCode: props.supplier.taxCode,
  contactName: props.supplier.contactName,
  phone: props.supplier.phone,
  email: props.supplier.email,
  notes: props.supplier.notes
})

// Computed
const isFormValid = computed(() => {
  return formData.value.name && formData.value.phone
})

// Methods
const handleSubmit = () => {
  if (isFormValid.value) {
    emit('save', formData.value)
  }
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
