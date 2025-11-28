<template>
  <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[10px] p-6 flex flex-col gap-4 w-[512px]">
    <!-- Dialog Header -->
    <div class="flex flex-col gap-2 w-full">
      <div class="h-7 relative">
        <div class="flex items-center justify-center overflow-clip">
          <div class="absolute left-0 top-0 flex gap-2.5 items-center justify-center">
            <h2 class="font-nunitoSans font-bold text-black text-lg leading-7 tracking-[0px]">
              Thêm nhân sự vào Khoa
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
          Chọn nhân viên từ danh sách chưa có biên chế
        </p>
      </div>
    </div>

    <!-- Form Content -->
    <div class="flex flex-col gap-4 w-full">
      <!-- Chọn nhân viên -->
      <div class="flex flex-col gap-2 w-full">
        <label class="flex gap-2 h-3.5 items-center">
          <span class="font-nunitoSans font-semibold text-black text-sm leading-5">
            Chọn nhân viên *
          </span>
        </label>
        <button
          @click="handleSelectEmployee"
          class="bg-[#f3f4f6] border border-transparent flex h-9 items-center justify-between px-[13px] py-px rounded-lg w-full hover:border-[#5a9690] transition-colors"
        >
          <span 
            :class="formData.employeeId ? 'text-black' : 'text-[#6b7280]'"
            class="font-nunitoSans font-medium text-sm leading-5"
          >
            {{ selectedEmployeeName || 'Chọn nhân viên' }}
          </span>
          <img :src="icons.chevronDown" alt="" class="w-4 h-4" />
        </button>
      </div>

      <!-- Chức danh -->
      <div class="flex flex-col gap-2 w-full">
        <label class="flex gap-2 h-3.5 items-center">
          <span class="font-nunitoSans font-semibold text-black text-sm leading-5">
            Chức danh *
          </span>
        </label>
        <button
          @click="handleSelectPosition"
          :disabled="!formData.employeeId"
          :class="!formData.employeeId ? 'opacity-50 cursor-not-allowed' : 'hover:border-[#5a9690] cursor-pointer'"
          class="bg-[#f3f4f6] border border-transparent flex h-9 items-center justify-between px-[13px] py-px rounded-lg w-full transition-colors"
        >
          <span 
            :class="formData.position ? 'text-black' : 'text-[#6b7280]'"
            class="font-nunitoSans font-medium text-sm leading-5"
          >
            {{ formData.position || 'Chọn chức danh' }}
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
          Thêm vào khoa
        </span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Props
const props = defineProps({
  availableEmployees: {
    type: Array,
    default: () => []
  },
  availablePositions: {
    type: Array,
    default: () => ['Bác sĩ chính', 'Bác sĩ', 'Điều dưỡng trưởng', 'Y tá', 'Kỹ thuật viên']
  }
});

// Icons from Figma
const icons = {
  close: "https://www.figma.com/api/mcp/asset/277ca31e-9972-44d8-9933-8f7ca7362381",
  chevronDown: "https://www.figma.com/api/mcp/asset/320df9d1-2e11-4f93-98eb-a8027042dde3"
};

// Form data
const formData = ref({
  employeeId: null,
  position: ''
});

// Computed
const selectedEmployeeName = computed(() => {
  if (!formData.value.employeeId) return '';
  const employee = props.availableEmployees.find(e => e.id === formData.value.employeeId);
  return employee ? employee.name : '';
});

const isFormValid = computed(() => {
  return formData.value.employeeId && formData.value.position;
});

// Emit events
const emit = defineEmits(['close', 'submit', 'selectEmployee', 'selectPosition']);

// Methods
const handleClose = () => {
  emit('close');
};

const handleSelectEmployee = () => {
  // Emit event to open employee selection modal
  emit('selectEmployee', (selectedEmployee) => {
    formData.value.employeeId = selectedEmployee.id;
  });
};

const handleSelectPosition = () => {
  if (!formData.value.employeeId) return;
  
  // Emit event to open position selection modal
  emit('selectPosition', (selectedPosition) => {
    formData.value.position = selectedPosition;
  });
};

const handleSubmit = () => {
  if (!isFormValid.value) return;

  // Emit submit event with form data
  emit('submit', {
    employeeId: formData.value.employeeId,
    position: formData.value.position
  });

  // Reset form
  formData.value = {
    employeeId: null,
    position: ''
  };
};
</script>

<style scoped>
/* Custom styles */
button:disabled {
  pointer-events: none;
}
</style>
