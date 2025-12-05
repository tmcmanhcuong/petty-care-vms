<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    @click.self="closeModal"
  >
    <div class="bg-white rounded-[10px] shadow-[0px_20px_25px_-5px_rgba(0,0,0,0.1),0px_8px_10px_-6px_rgba(0,0,0,0.1)] w-full max-w-[500px] max-h-[90vh] overflow-y-auto mx-4">
      <!-- Modal Content -->
      <div class="flex flex-col gap-4 p-6">
        <!-- Header -->
        <div class="flex flex-col h-12">
          <h2 class="font-nunito text-lg leading-7 text-[#101828] tracking-[-0.4395px]">
            Thêm Hồ Sơ Khách Hàng Mới
          </h2>
          <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
            Tạo hồ sơ mới cho khách hàng và thú cưng
          </p>
        </div>

        <!-- THÔNG TIN CHỦ NUÔI (Gray Section) -->
        <div class="bg-gray-50 border-2 border-gray-200 rounded-[10px] p-[18px] flex flex-col gap-4">
          <!-- Section Title -->
          <div class="flex items-center gap-2 h-6">
            <img :src="iconUser" alt="User" class="w-5 h-5" />
            <h3 class="font-nunito font-bold text-base leading-6 text-[#101828] tracking-[-0.3125px]">
              THÔNG TIN CHỦ NUÔI
            </h3>
          </div>

          <!-- Phone Number -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#101828] tracking-[-0.1504px] mb-2">
              Số điện thoại
              <span class="text-[#fb2c36] ml-1">*</span>
            </label>
            <input
              v-model="formData.phone"
              type="tel"
              placeholder="0912345678"
              class="bg-[#f3f3f5] border border-transparent rounded-lg px-3 py-2 h-9 font-nunito text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:border-[#009689]"
            />
          </div>

          <!-- Full Name -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#101828] tracking-[-0.1504px] mb-2">
              Họ và tên
              <span class="text-[#fb2c36] ml-1">*</span>
            </label>
            <input
              v-model="formData.fullName"
              type="text"
              placeholder="Trần Thị B"
              class="bg-[#f3f3f5] border border-transparent rounded-lg px-3 py-2 h-9 font-nunito text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:border-[#009689]"
            />
            <p class="font-nunito text-xs leading-4 text-[#6a7282] mt-1">
              Tự động viết hoa chữ cái đầu
            </p>
          </div>
        </div>

        <!-- THÔNG TIN THÚ CƯNG (Blue Section) -->
        <div class="bg-blue-50 border-2 border-[#bedbff] rounded-[10px] p-[18px] flex flex-col gap-4">
          <!-- Section Title -->
          <div class="flex items-center gap-2 h-6">
            <img :src="iconPet" alt="Pet" class="w-5 h-5" />
            <h3 class="font-nunito font-bold text-base leading-6 text-[#101828] tracking-[-0.3125px]">
              THÔNG TIN THÚ CƯNG
            </h3>
          </div>

          <!-- Pet Name -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#101828] tracking-[-0.1504px] mb-2">
              Tên thú cưng
              <span class="text-[#fb2c36] ml-1">*</span>
            </label>
            <input
              v-model="formData.petName"
              type="text"
              placeholder="VD: Milo, Mimi..."
              class="bg-[#f9fafb] border border-black/[0.15] rounded-lg px-3 py-2 h-9 font-nunito text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:border-[#009689]"
            />
          </div>

          <!-- Species (Radio Buttons) -->
          <div class="flex flex-col gap-2">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#101828] tracking-[-0.1504px]">
              Loài vật
              <span class="text-[#fb2c36] ml-1">*</span>
            </label>
            <div class="flex items-center gap-4">
              <label
                v-for="species in speciesOptions"
                :key="species.value"
                class="flex items-center gap-2 cursor-pointer"
              >
                <div class="relative">
                  <input
                    v-model="formData.species"
                    type="radio"
                    :value="species.value"
                    class="appearance-none w-4 h-4 border border-black/20 rounded-full shadow-sm checked:bg-white checked:border-[#009689] cursor-pointer"
                  />
                  <div
                    v-if="formData.species === species.value"
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-2 h-2 pointer-events-none"
                  >
                    <img :src="iconCheck" alt="Check" class="w-full h-full" />
                  </div>
                </div>
                <span class="font-nunito font-medium text-sm leading-[14px] text-[#101828] tracking-[-0.1504px]">
                  {{ species.label }}
                </span>
              </label>
            </div>
          </div>

          <!-- Breed -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#101828] tracking-[-0.1504px] mb-2">
              Giống (Breed)
              <span class="text-[#fb2c36] ml-1">*</span>
            </label>
            <div class="relative">
              <select
                v-model="formData.breed"
                class="bg-[#f9fafb] border border-black/[0.15] rounded-lg px-3 py-2 h-9 w-full font-nunito text-sm text-[#717182] tracking-[-0.1504px] appearance-none focus:outline-none focus:border-[#009689]"
              >
                <option value="" disabled>Chọn giống...</option>
                <option v-for="breed in availableBreeds" :key="breed" :value="breed">
                  {{ breed }}
                </option>
              </select>
              <img
                :src="iconChevron"
                alt="Chevron"
                class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none"
              />
            </div>
            <div class="flex items-center gap-1 mt-1">
              <img :src="iconInfo" alt="Info" class="w-3 h-3" />
              <p class="font-nunito text-xs leading-4 text-[#4a5565]">
                Danh sách giống thay đổi theo loài
              </p>
            </div>
          </div>

          <!-- Birth Date -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#101828] tracking-[-0.1504px] mb-2">
              Ngày sinh
              <span class="text-[#fb2c36] ml-1">*</span>
            </label>
            <input
              v-model="formData.birthDate"
              type="date"
              class="bg-[#f9fafb] border border-black/[0.15] rounded-lg px-3 py-2 h-9 font-nunito text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:border-[#009689]"
            />
          </div>

          <!-- Notes -->
          <div class="flex flex-col">
            <label class="font-nunito font-medium text-sm leading-[14px] text-[#101828] tracking-[-0.1504px] mb-2">
              Ghi chú
            </label>
            <textarea
              v-model="formData.notes"
              rows="3"
              placeholder="VD: Hay sủa, hiền lành, dễ thương..."
              class="bg-[#f9fafb] border border-black/[0.15] rounded-lg px-3 py-2 font-nunito text-sm text-[#717182] tracking-[-0.1504px] resize-none focus:outline-none focus:border-[#009689]"
            ></textarea>
          </div>

          <!-- Add Pet Button -->
          <button
            class="bg-[#00a63e] rounded-lg px-3 py-2 h-9 flex items-center gap-3 hover:bg-[#008833] transition-colors self-start"
            @click="addPet"
          >
            <img :src="iconPlus" alt="Plus" class="w-4 h-4" />
            <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
              Thêm Thú Cưng
            </span>
          </button>
        </div>

        <!-- Footer Buttons -->
        <div class="flex items-center justify-end gap-2 h-9">
          <button
            class="bg-white border border-black/10 rounded-lg px-4 py-2 h-9 hover:bg-gray-50 transition-colors"
            @click="closeModal"
          >
            <span class="font-nunito font-medium text-sm leading-5 text-[#101828] tracking-[-0.1504px]">
              Hủy
            </span>
          </button>
          <button
            class="bg-[#9810fa] rounded-lg px-3 py-2 h-9 flex items-center gap-3 hover:bg-[#7a0cc9] transition-colors"
            @click="saveProfile"
          >
            <img :src="iconSave" alt="Save" class="w-4 h-4" />
            <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
              Lưu hồ sơ
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

// Props
const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  }
})

// Emits
const emit = defineEmits(['close', 'submit'])

// Icons
const iconUser = "https://www.figma.com/api/mcp/asset/b9bbdb94-a032-470d-8a79-5c02b70d39df"
const iconPet = "https://www.figma.com/api/mcp/asset/55e321fc-1581-494e-a165-15c8317238bb"
const iconCheck = "https://www.figma.com/api/mcp/asset/f2d3e2d3-0809-4d13-9240-bd7a127750f2"
const iconChevron = "https://www.figma.com/api/mcp/asset/2bb7bd10-d9fa-46f4-8c76-259dd73e0fd2"
const iconInfo = "https://www.figma.com/api/mcp/asset/8e903663-fc0a-4416-a8a8-e99edb44529d"
const iconPlus = "https://www.figma.com/api/mcp/asset/8244750d-92b0-4418-84a4-bbb408b84406"
const iconSave = "https://www.figma.com/api/mcp/asset/e39ca45c-c65b-464c-aee8-12fd565db54f"

// Form data
const formData = ref({
  phone: '',
  fullName: '',
  petName: '',
  species: 'dog',
  breed: '',
  birthDate: '',
  notes: ''
})

// Species options
const speciesOptions = [
  { value: 'dog', label: 'Chó' },
  { value: 'cat', label: 'Mèo' },
  { value: 'other', label: 'Khác' }
]

// Breed options based on species
const breedsBySpecies = {
  dog: [
    'Poodle',
    'Golden Retriever',
    'Husky',
    'Chihuahua',
    'Corgi',
    'Bulldog',
    'Chó ta'
  ],
  cat: [
    'Mèo Anh lông ngắn',
    'Mèo Ba Tư',
    'Mèo Xiêm',
    'Mèo Bengal',
    'Mèo ta'
  ],
  other: [
    'Hamster',
    'Thỏ',
    'Chim',
    'Rùa',
    'Khác'
  ]
}

// Computed breeds based on selected species
const availableBreeds = computed(() => {
  return breedsBySpecies[formData.value.species] || []
})

// Watch species change to reset breed
watch(() => formData.value.species, () => {
  formData.value.breed = ''
})

// Auto-capitalize full name
watch(() => formData.value.fullName, (newValue) => {
  if (newValue) {
    formData.value.fullName = newValue
      .split(' ')
      .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
      .join(' ')
  }
})

// Methods
const closeModal = () => {
  emit('close')
  resetForm()
}

const resetForm = () => {
  formData.value = {
    phone: '',
    fullName: '',
    petName: '',
    species: 'dog',
    breed: '',
    birthDate: '',
    notes: ''
  }
}

const addPet = () => {
  console.log('Add another pet')
  // TODO: Implement add multiple pets functionality
}

const saveProfile = () => {
  // Validate required fields
  if (!formData.value.phone || !formData.value.fullName || !formData.value.petName || !formData.value.breed || !formData.value.birthDate) {
    alert('Vui lòng điền đầy đủ thông tin bắt buộc (*)')
    return
  }

  emit('submit', { ...formData.value })
  closeModal()
}

// Watch modal open to reset form
watch(() => props.isOpen, (newValue) => {
  if (!newValue) {
    resetForm()
  }
})
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700&display=swap');

* {
  font-family: 'Nunito Sans', sans-serif;
}

/* Custom radio button styling */
input[type="radio"]:checked {
  position: relative;
}
</style>
