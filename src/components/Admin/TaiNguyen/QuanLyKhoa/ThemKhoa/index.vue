<template>
  <div
    class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[10px] p-6 flex flex-col gap-4 w-[512px]"
  >
    <!-- Dialog Header -->
    <div class="flex flex-col gap-2 w-full">
      <div class="h-7 relative">
        <div class="flex items-center justify-center overflow-clip">
          <div
            class="absolute left-0 top-0 flex gap-2.5 items-center justify-center"
          >
            <h2
              class="font-nunitoSans font-bold text-black text-lg leading-7 tracking-[0px]"
            >
              Thêm Khoa mới
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
          Điền thông tin để tạo khoa mới
        </p>
      </div>
    </div>

    <!-- Form Content -->
    <div class="flex flex-col gap-4 w-full">
      <!-- Row 1: Mã Khoa & Tên Khoa -->
      <div class="grid grid-cols-2 gap-4 h-[58px]">
        <!-- Mã Khoa -->
        <div class="flex flex-col gap-2">
          <label class="flex gap-2 h-3.5 items-center">
            <span
              class="font-nunitoSans font-semibold text-black text-sm leading-5"
            >
              Mã Khoa *
            </span>
          </label>
          <input
            v-model="formData.code"
            type="text"
            placeholder="KHOA-01"
            class="bg-[#f3f4f6] border border-transparent h-9 rounded-lg px-3 py-1 font-nunitoSans font-medium text-sm leading-5 text-black placeholder:text-[#6b7280] outline-none focus:border-[#5a9690] transition-colors"
          />
        </div>

        <!-- Tên Khoa -->
        <div class="flex flex-col gap-2">
          <label class="flex gap-2 h-3.5 items-center">
            <span
              class="font-nunitoSans font-semibold text-black text-sm leading-5"
            >
              Tên Khoa *
            </span>
          </label>
          <input
            v-model="formData.name"
            type="text"
            placeholder="Khoa Nội"
            class="bg-[#f3f4f6] border border-transparent h-9 rounded-lg px-3 py-1 font-nunitoSans font-medium text-sm leading-5 text-black placeholder:text-[#6b7280] outline-none focus:border-[#5a9690] transition-colors"
          />
        </div>
      </div>

      <!-- Mô tả -->
      <div class="flex flex-col gap-2 w-full">
        <label class="flex gap-2 h-3.5 items-center">
          <span
            class="font-nunitoSans font-semibold text-black text-sm leading-5"
          >
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

      <!-- Trạng thái hoạt động -->
      <div
        class="bg-[#f3f4f6] flex items-center justify-between px-4 py-0 rounded-[10px] h-[50.398px]"
      >
        <label class="h-3.5">
          <span
            class="font-nunitoSans font-semibold text-black text-sm leading-5"
          >
            Trạng thái hoạt động
          </span>
        </label>
        <button
          @click="formData.isActive = !formData.isActive"
          :class="formData.isActive ? 'bg-black' : 'bg-[#d1d5db]'"
          class="relative rounded-full h-[18.398px] w-8 transition-colors cursor-pointer"
        >
          <div
            :class="
              formData.isActive ? 'translate-x-[15px]' : 'translate-x-[1px]'
            "
            class="absolute top-[1px] bg-white rounded-full w-4 h-4 transition-transform"
          ></div>
        </button>
      </div>
    </div>

    <!-- Dialog Footer -->
    <div class="flex gap-2 h-9 items-start justify-end w-full">
      <button
        @click="handleSubmit"
        class="bg-[#5a9690] h-9 rounded-lg px-4 py-2 hover:bg-[#4a7f79] transition-colors"
      >
        <span
          class="font-nunitoSans font-semibold text-white text-sm leading-5 text-center"
        >
          Thêm khoa
        </span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { getToken } from "@/utils/auth";
import { showSuccessToast, showErrorToast } from "@/utils/toast";

// Icon from Figma
const icons = {
  close:
    "https://www.figma.com/api/mcp/asset/10de6cf9-ea23-4a19-af5c-4f6446a26c12",
};

// Form data
const formData = ref({
  code: "",
  name: "",
  description: "",
  isActive: true,
});

const isSubmitting = ref(false);

// Emit events
const emit = defineEmits(["close", "submit"]);

// Methods
const handleClose = () => {
  if (isSubmitting.value) return;
  emit("close");
};

const handleSubmit = async () => {
  // Validate required fields
  if (!formData.value.code || !formData.value.name) {
    showErrorToast("Lỗi", "Vui lòng điền đầy đủ thông tin bắt buộc (*)");
    return;
  }

  // Prepare payload matching backend expectations
  const payload = {
    code: formData.value.code,
    name: formData.value.name,
    description: formData.value.description,
    is_active: formData.value.isActive,
  };

  isSubmitting.value = true;
  try {
    // Attach token if available
    const token = getToken();
    const headers = {};
    if (token) headers["Authorization"] = `Bearer ${token}`;

    const response = await axios.post("/khoa", payload, { headers });

    // Expect the created Khoa in response.data.data per BE
    const created = response?.data?.data ?? null;

    showSuccessToast("Thành công", "Tạo khoa mới thành công");

    // Emit submit so parent can update its list with the created resource
    emit("submit", created || payload);

    // Optionally close modal by emitting close (parent also closes on submit)
    emit("close");

    // Reset form
    formData.value = {
      code: "",
      name: "",
      description: "",
      isActive: true,
    };
  } catch (err) {
    // Try to show meaningful message
    const msg =
      err?.response?.data?.message ||
      err?.message ||
      "Có lỗi xảy ra khi tạo khoa";
    showErrorToast("Lỗi", msg);
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
/* Custom focus styles */
input:focus,
textarea:focus {
  border-color: #5a9690;
}
</style>
