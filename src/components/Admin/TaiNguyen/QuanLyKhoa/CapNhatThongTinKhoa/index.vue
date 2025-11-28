<template>
  <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[10px] p-6 flex flex-col gap-4 w-[512px]">
    <!-- Dialog Header -->
    <div class="flex flex-col gap-2 w-full">
      <div class="h-7 relative">
        <div class="flex items-center justify-center overflow-clip">
          <div class="absolute left-0 top-0 flex gap-2.5 items-center justify-center">
            <h2 class="font-nunitoSans font-bold text-black text-lg leading-7 tracking-[0px]">
              Cập nhật thông tin Khoa
            </h2>
          </div>
          <button
            @click="handleClose"
            class="absolute left-[436px] top-0 w-7 h-7 cursor-pointer hover:opacity-70 transition-opacity"
          >
            <img :src="icons.close" alt="Close" class="w-full h-full" />
          </button>
        </div>
      </div>
      <div class="flex gap-2.5 items-center justify-center">
        <p class="font-nunitoSans font-medium text-[#6b7280] text-sm leading-5">
          Chỉnh sửa thông tin khoa
        </p>
      </div>
    </div>

    <!-- Form Content -->
    <div class="flex flex-col gap-4 w-full">
      <!-- Mô tả -->
      <div class="flex flex-col gap-2 w-full">
        <label class="flex gap-2 h-3.5 items-center">
          <span class="font-nunitoSans font-semibold text-black text-sm leading-5">
            Mô tả
          </span>
        </label>
        <textarea
          v-model="formData.description"
          placeholder="Chức năng của khoa..."
          rows="3"
          class="bg-[#f3f4f6] border border-transparent rounded-lg px-3 py-2.5 font-nunitoSans font-medium text-sm leading-5 text-black placeholder:text-[#6b7280] outline-none focus:border-[#5a9690] transition-colors resize-none"
        ></textarea>
      </div>

      <!-- Trưởng khoa -->
      <div class="flex flex-col gap-2 w-full">
        <label class="flex gap-2 h-3.5 items-center">
          <span class="font-nunitoSans font-semibold text-black text-sm leading-5">
            Trưởng khoa
          </span>
        </label>
        <button
          @click="handleSelectHead"
          class="bg-[#f3f4f6] border border-transparent flex h-9 items-center justify-between px-[13px] py-[9px] rounded-lg w-full hover:border-[#5a9690] transition-colors"
        >
          <span class="font-nunitoSans font-medium text-black text-xs leading-5 text-center">
            {{ formData.head || 'Chọn trưởng khoa' }}
          </span>
        </button>
      </div>
    </div>

    <!-- Dialog Footer -->
    <div class="flex gap-2 h-9 items-start justify-end w-full">
      <button
        @click="handleSubmit"
        class="bg-[#5a9690] h-9 rounded-lg px-4 py-2 hover:bg-[#4a7f79] transition-colors"
      >
        <span class="font-nunitoSans font-semibold text-white text-sm leading-5 text-center">
          Lưu thay đổi
        </span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

// Props
const props = defineProps({
  department: {
    type: Object,
    default: null
  }
});

// Icon from Figma
const icons = {
  close: "https://www.figma.com/api/mcp/asset/37803a27-e7d2-43b9-b323-f46306885e0c"
};

// Form data
const formData = ref({
  description: '',
  head: ''
});

// Initialize form with department data
onMounted(() => {
  if (props.department) {
    formData.value = {
      description: props.department.description || '',
      head: props.department.head || ''
    };
  }
});

// Emit events
const emit = defineEmits(['close', 'submit', 'selectHead']);

// Methods
const handleClose = () => {
  emit('close');
};

const handleSelectHead = () => {
  // Emit event to open staff selection modal
  emit('selectHead');
};

const handleSubmit = () => {
  // Emit submit event with form data
  emit('submit', {
    description: formData.value.description,
    head: formData.value.head
  });
};
</script>

<style scoped>
/* Custom focus styles */
textarea:focus,
button:focus {
  outline: none;
}
</style>
