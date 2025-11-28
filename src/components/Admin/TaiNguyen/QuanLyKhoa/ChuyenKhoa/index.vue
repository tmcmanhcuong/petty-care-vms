<template>
  <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[10px] p-6 flex flex-col gap-4 w-[512px]">
    <!-- Dialog Header -->
    <div class="flex flex-col gap-2 w-full">
      <div class="h-7 relative">
        <div class="flex items-center justify-center overflow-clip">
          <div class="absolute left-0 top-0 flex gap-2.5 items-center justify-center">
            <h2 class="font-nunitoSans font-bold text-black text-lg leading-7 tracking-[0px]">
              Chuyển khoa
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
          Chuyển {{ staffName }} sang khoa khác
        </p>
      </div>
    </div>

    <!-- Form Content -->
    <div class="flex flex-col gap-2 w-full">
      <label class="flex gap-2 h-3.5 items-center">
        <span class="font-nunitoSans font-semibold text-black text-sm leading-5">
          Chọn khoa đích *
        </span>
      </label>
      <button
        @click="handleSelectDepartment"
        class="bg-[#f3f4f6] border border-transparent flex h-9 items-center justify-between px-[13px] py-px rounded-lg w-full hover:border-[#5a9690] transition-colors"
      >
        <span 
          :class="formData.targetDepartmentId ? 'text-black' : 'text-[#6b7280]'"
          class="font-nunitoSans font-medium text-sm leading-5"
        >
          {{ selectedDepartmentName || 'Chọn khoa' }}
        </span>
        <img :src="icons.chevronDown" alt="" class="w-4 h-4" />
      </button>
    </div>

    <!-- Dialog Footer -->
    <div class="flex gap-2 h-9 items-start justify-end w-full">
      <button
        @click="handleSubmit"
        :disabled="!formData.targetDepartmentId"
        :class="formData.targetDepartmentId ? 'bg-[#5a9690] hover:bg-[#4a7f79] cursor-pointer' : 'bg-[#5a9690] opacity-50 cursor-not-allowed'"
        class="h-9 rounded-lg px-4 py-2 transition-colors"
      >
        <span class="font-nunitoSans font-semibold text-white text-sm leading-5 text-center">
          Chuyển khoa
        </span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Props
const props = defineProps({
  staff: {
    type: Object,
    required: true
  },
  currentDepartmentId: {
    type: [Number, String],
    required: true
  },
  availableDepartments: {
    type: Array,
    default: () => []
  }
});

// Icons from Figma
const icons = {
  close: "https://www.figma.com/api/mcp/asset/701ddedf-825b-4bf2-ba3c-250a08980993",
  chevronDown: "https://www.figma.com/api/mcp/asset/7e81bcfe-69cc-44bf-b9b2-94df5f6cfcaa"
};

// Form data
const formData = ref({
  targetDepartmentId: null
});

// Computed
const staffName = computed(() => {
  return props.staff?.name || 'nhân viên này';
});

const selectedDepartmentName = computed(() => {
  if (!formData.value.targetDepartmentId) return '';
  const dept = props.availableDepartments.find(d => d.id === formData.value.targetDepartmentId);
  return dept ? dept.name : '';
});

// Emit events
const emit = defineEmits(['close', 'submit', 'selectDepartment']);

// Methods
const handleClose = () => {
  emit('close');
};

const handleSelectDepartment = () => {
  // Emit event to open department selection modal
  // Filter out current department from selection
  const filteredDepartments = props.availableDepartments.filter(
    d => d.id !== props.currentDepartmentId
  );
  
  emit('selectDepartment', filteredDepartments, (selectedDepartment) => {
    formData.value.targetDepartmentId = selectedDepartment.id;
  });
};

const handleSubmit = () => {
  if (!formData.value.targetDepartmentId) return;

  // Emit submit event with transfer data
  emit('submit', {
    staffId: props.staff.id,
    fromDepartmentId: props.currentDepartmentId,
    toDepartmentId: formData.value.targetDepartmentId
  });

  // Reset form
  formData.value = {
    targetDepartmentId: null
  };
};
</script>

<style scoped>
/* Custom styles */
button:disabled {
  pointer-events: none;
}
</style>
