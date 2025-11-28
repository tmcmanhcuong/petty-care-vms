<template>
  <div class="flex flex-col bg-white rounded-[10px] shadow-xl w-full h-full overflow-hidden">
    <!-- Header -->
    <div class="flex items-start justify-between p-6 pb-4 border-b border-gray-100 shrink-0">
      <div class="flex flex-col gap-1">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-[#f0fdfa] flex items-center justify-center">
             <img :src="iconFolder" alt="" class="w-5 h-5" />
          </div>
          <h2 class="font-nunito font-bold text-lg text-gray-900">
            Quản lý Danh Mục Dịch vụ
          </h2>
        </div>
        <p class="font-nunito text-sm text-gray-500 pl-10">
          Tạo và quản lý các nhóm dịch vụ theo từng khoa
        </p>
      </div>
      <button
        class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-md hover:bg-gray-100"
        @click="$emit('close')"
      >
        <img :src="iconClose" alt="Close" class="w-5 h-5" />
      </button>
    </div>

    <!-- Body -->
    <div class="flex-1 flex flex-col min-h-0 p-6 pt-4 gap-4 overflow-hidden">
      <!-- Department Selector -->
      <div class="flex flex-col gap-1.5 shrink-0">
        <label class="font-nunito font-semibold text-sm text-gray-700">
          Chọn khoa
        </label>
        <div class="relative">
          <select
            v-model="selectedDepartment"
            class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-[#5a9690] focus:border-[#5a9690] block p-2.5 appearance-none font-nunito cursor-pointer"
          >
            <option value="">Tất cả các khoa</option>
            <option v-for="dept in uniqueDepartments" :key="dept" :value="dept">{{ dept }}</option>
          </select>
          <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
            <img :src="iconChevronDown" class="w-4 h-4 text-gray-500" />
          </div>
        </div>
      </div>

      <!-- Categories List -->
      <div class="flex-1 border border-gray-200 rounded-lg overflow-hidden flex flex-col min-h-0">
        <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 shrink-0">
          <span class="text-xs font-semibold text-gray-500 uppercase font-nunito">Danh sách nhóm ({{ filteredCategories.length }})</span>
        </div>
        <div class="flex-1 overflow-y-auto p-2 space-y-2 bg-white custom-scrollbar">
          <div
            v-for="category in filteredCategories"
            :key="category.id"
            class="group flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:border-[#5a9690]/30 hover:bg-[#5a9690]/5 transition-all"
          >
            <div class="flex flex-col">
              <span class="font-nunito font-medium text-gray-900">{{ category.name }}</span>
              <span class="text-xs text-gray-500 font-nunito">{{ category.department }} • {{ category.serviceCount }} dịch vụ</span>
            </div>
            <button
              class="opacity-0 group-hover:opacity-100 p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-all"
              @click="handleDeleteCategory(category)"
              title="Xóa nhóm"
            >
              <img :src="iconDelete" class="w-4 h-4" />
            </button>
          </div>
          
          <!-- Empty State -->
          <div v-if="filteredCategories.length === 0" class="flex flex-col items-center justify-center h-full text-gray-400 py-8 gap-2">
            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center">
              <img :src="iconFolder" class="w-6 h-6 opacity-20 grayscale" />
            </div>
            <p class="text-sm font-nunito">Không tìm thấy nhóm dịch vụ nào</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="p-6 pt-4 border-t border-gray-100 bg-gray-50/50 shrink-0">
      <div class="flex flex-col gap-3">
        <label class="font-nunito font-semibold text-sm text-gray-700">
          Thêm nhóm mới
        </label>
        <div class="flex gap-2">
          <input
            v-model="newCategoryName"
            type="text"
            placeholder="Nhập tên nhóm..."
            class="flex-1 bg-white border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-[#5a9690] focus:border-[#5a9690] block p-2.5 font-nunito outline-none transition-all"
            :disabled="!selectedDepartment"
            @keyup.enter="handleAddCategory"
          />
          <button
            class="px-4 py-2 bg-[#5a9690] hover:bg-[#4a7f79] text-white rounded-lg font-medium text-sm transition-colors flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed font-nunito shrink-0"
            :disabled="!selectedDepartment || !newCategoryName.trim()"
            @click="handleAddCategory"
          >
            <img :src="iconPlus" class="w-4 h-4 brightness-0 invert" />
            Thêm
          </button>
        </div>
        <p v-if="!selectedDepartment" class="text-xs text-amber-600 font-nunito flex items-center gap-1">
          <span>⚠️</span> Vui lòng chọn khoa cụ thể để thêm nhóm mới
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const emit = defineEmits(['close', 'addCategory', 'deleteCategory'])

// State
const selectedDepartment = ref('')
const newCategoryName = ref('')

// Sample data
const categories = ref([
  {
    id: 1,
    name: 'Cắt tỉa',
    department: 'Spa & Grooming',
    serviceCount: 1
  },
  {
    id: 2,
    name: 'Tắm sấy',
    department: 'Spa & Grooming',
    serviceCount: 2
  },
  {
    id: 3,
    name: 'Nhuộm lông',
    department: 'Spa & Grooming',
    serviceCount: 0
  },
  {
    id: 4,
    name: 'Tiêm phòng',
    department: 'Khoa Lâm Sàng',
    serviceCount: 1
  },
  {
    id: 5,
    name: 'Khám bệnh',
    department: 'Khoa Lâm Sàng',
    serviceCount: 1
  },
  {
    id: 6,
    name: 'Xét nghiệm',
    department: 'Khoa Lâm Sàng',
    serviceCount: 1
  },
  {
    id: 7,
    name: 'Thức ăn',
    department: 'Pet Shop',
    serviceCount: 0
  },
  {
    id: 8,
    name: 'Phụ kiện',
    department: 'Pet Shop',
    serviceCount: 0
  }
])

// Computed
const uniqueDepartments = computed(() => {
  const depts = new Set(categories.value.map(c => c.department))
  return Array.from(depts)
})

const filteredCategories = computed(() => {
  if (!selectedDepartment.value) return categories.value
  return categories.value.filter(c => c.department === selectedDepartment.value)
})

// Icon URLs from Figma (expire in 7 days)
const iconFolder = "https://www.figma.com/api/mcp/asset/748ca3f4-e562-4223-9e77-7e938a826bc9"
const iconChevronDown = "https://www.figma.com/api/mcp/asset/3166eaf1-6101-478d-8d03-fdeb48468b43"
const iconDelete = "https://www.figma.com/api/mcp/asset/c1bc743c-8931-46b2-9ddb-04a1e036c137"
const iconPlus = "https://www.figma.com/api/mcp/asset/64f50774-2e92-4326-91d0-af089daa1df7"
const iconClose = "https://www.figma.com/api/mcp/asset/a6a4548a-a1df-4511-8403-6bb9c4a0a210"

// Methods
const handleAddCategory = () => {
  if (selectedDepartment.value && newCategoryName.value.trim()) {
    // In a real app, this would be an API call
    const newId = Math.max(...categories.value.map(c => c.id)) + 1
    categories.value.push({
      id: newId,
      name: newCategoryName.value.trim(),
      department: selectedDepartment.value,
      serviceCount: 0
    })
    
    emit('addCategory', {
      name: newCategoryName.value,
      department: selectedDepartment.value
    })
    newCategoryName.value = ''
  }
}

const handleDeleteCategory = (category) => {
  if (confirm(`Bạn có chắc muốn xóa nhóm "${category.name}"?`)) {
    categories.value = categories.value.filter(c => c.id !== category.id)
    emit('deleteCategory', category)
  }
}
</script>

<style scoped>
/* Custom scrollbar for categories list */
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #e5e7eb;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #d1d5db;
}
</style>
