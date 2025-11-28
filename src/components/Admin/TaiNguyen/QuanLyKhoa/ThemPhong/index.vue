<template>
  <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[10px] p-6 flex flex-col gap-4 w-[512px]">
    <!-- Dialog Header -->
    <div class="flex flex-col gap-2 w-full">
      <div class="h-7 relative">
        <div class="flex items-center justify-center overflow-clip">
          <div class="absolute left-0 top-0 flex gap-2.5 items-center justify-center">
            <h2 class="font-nunitoSans font-bold text-black text-lg leading-7 tracking-[0px]">
              Thêm phòng mới
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
          Thêm phòng vào khoa
        </p>
      </div>
    </div>

    <!-- Form Content -->
    <div class="flex flex-col gap-4 w-full">
      <!-- Tên phòng -->
      <div class="flex flex-col gap-2 w-full">
        <label class="flex gap-2 h-3.5 items-center">
          <span class="font-nunitoSans font-semibold text-black text-sm leading-5">
            Tên phòng *
          </span>
        </label>
        <input
          v-model="formData.name"
          type="text"
          placeholder="VD: Phòng Khám 01"
          class="bg-[#f3f4f6] border border-transparent rounded-lg px-3 py-2.5 font-nunitoSans font-medium text-sm leading-5 text-black placeholder:text-[#6b7280] outline-none focus:border-[#5a9690] transition-colors"
        />
      </div>

      <!-- Loại phòng -->
      <div class="flex flex-col gap-2 w-full">
        <label class="flex gap-2 h-3.5 items-center">
          <span class="font-nunitoSans font-semibold text-black text-sm leading-5">
            Loại phòng *
          </span>
        </label>
        <button
          @click="handleSelectRoomType"
          class="bg-[#f3f4f6] border border-transparent flex h-9 items-center justify-between px-[13px] py-[9px] rounded-lg w-full hover:border-[#5a9690] transition-colors"
        >
          <span 
            :class="formData.type ? 'text-black' : 'text-[#6b7280]'"
            class="font-nunitoSans font-medium text-xs leading-5"
          >
            {{ formData.type || 'Chọn loại phòng' }}
          </span>
          <img :src="icons.chevronDown" alt="" class="w-4 h-4" />
        </button>
      </div>
    </div>

    <!-- Dialog Footer -->
    <div class="flex gap-2 h-9 items-start justify-end w-full">
      <button
        @click="handleSubmit"
        :disabled="!isFormValid"
        :class="isFormValid ? 'bg-[#5a9690] hover:bg-[#4a7f79] cursor-pointer' : 'bg-[#5a9690] opacity-50 cursor-not-allowed'"
        class="h-9 rounded-lg px-4 py-2 transition-colors"
      >
        <span class="font-nunitoSans font-semibold text-white text-sm leading-5 text-center">
          Thêm phòng
        </span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Props
const props = defineProps({
  roomTypes: {
    type: Array,
    default: () => ['Phòng khám', 'Phòng mổ', 'Phòng điều trị', 'Phòng nội trú', 'Phòng xét nghiệm', 'Phòng X-quang']
  }
});

// Icons from Figma
const icons = {
  close: "https://www.figma.com/api/mcp/asset/1540e58a-8f89-4def-897d-83881777020e",
  chevronDown: "https://www.figma.com/api/mcp/asset/db8751c2-ef95-4686-8e3a-d609c4950709"
};

// Form data
const formData = ref({
  name: '',
  type: ''
});

// Computed
const isFormValid = computed(() => {
  return formData.value.name.trim() && formData.value.type;
});

// Emit events
const emit = defineEmits(['close', 'submit', 'selectRoomType']);

// Methods
const handleClose = () => {
  emit('close');
};

const handleSelectRoomType = () => {
  // Emit event to open room type selection modal
  emit('selectRoomType', props.roomTypes, (selectedType) => {
    formData.value.type = selectedType;
  });
};

const handleSubmit = () => {
  if (!isFormValid.value) return;

  // Emit submit event with form data
  emit('submit', {
    name: formData.value.name.trim(),
    type: formData.value.type
  });

  // Reset form
  formData.value = {
    name: '',
    type: ''
  };
};
</script>

<style scoped>
/* Custom focus styles */
input:focus {
  outline: none;
}

button:disabled {
  pointer-events: none;
}
</style>
