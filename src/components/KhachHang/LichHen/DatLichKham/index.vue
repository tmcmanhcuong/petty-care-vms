<template>
  <!-- Overlay -->
  <div 
    v-if="isOpen"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="showSuccess ? null : closePopup"
  >
    <!-- Success Modal -->
    <div 
      v-if="showSuccess"
      class="bg-white rounded-lg border border-gray-300 w-full max-w-[512px] shadow-xl"
    >
      <div class="flex flex-col p-6 gap-4 items-center">
        <!-- Success Icon -->
        <div class="w-16 h-16 rounded-full bg-teal-100 flex items-center justify-center">
          <img :src="iconSuccess" alt="Success" class="w-10 h-10" />
        </div>

        <!-- Success Message -->
        <div class="flex flex-col gap-2 items-center">
          <h2 class="text-2xl font-bold text-black text-center" style="font-family: 'Nunito Sans', sans-serif; font-variation-settings: 'YTLC' 500, 'wdth' 100;">
            Đặt lịch thành công
          </h2>
          <p class="text-sm font-medium text-gray-500 text-center" style="font-family: 'Nunito Sans', sans-serif; font-variation-settings: 'YTLC' 500, 'wdth' 100;">
            Mã lịch hẹn của bạn là
          </p>
          <p class="text-sm font-medium text-teal-600 text-center" style="font-family: 'Nunito Sans', sans-serif; font-variation-settings: 'YTLC' 500, 'wdth' 100;">
            {{ bookingCode }}
          </p>
        </div>

        <!-- Booking Summary -->
        <div class="w-full bg-teal-50 rounded-lg p-4 flex flex-col gap-1 items-center">
          <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-gray-500" style="font-family: 'Nunito Sans', sans-serif;">Thú cưng:</span>
            <span class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">{{ selectedPet?.name }}</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-gray-500" style="font-family: 'Nunito Sans', sans-serif;">Dịch vụ:</span>
            <span class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">{{ selectedService?.name }}</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-gray-500" style="font-family: 'Nunito Sans', sans-serif;">Thời gian:</span>
            <span class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">{{ formattedDateTime }}</span>
          </div>
        </div>

        <!-- Close Button -->
        <button 
          @click="closeSuccessPopup"
          class="w-full h-9 bg-teal-600 hover:bg-teal-700 rounded-lg transition-colors"
        >
          <span class="text-sm font-semibold text-white" style="font-family: 'Nunito Sans', sans-serif;">
            Hoàn tất
          </span>
        </button>
      </div>
    </div>

    <!-- Main Booking Modal -->
    <div v-else class="bg-white rounded-lg border border-gray-300 w-full max-w-[512px] max-h-[90vh] overflow-hidden shadow-xl">
      <div class="flex flex-col p-6 gap-4 overflow-y-auto max-h-[90vh]">
        <!-- Header -->
        <div class="flex flex-col gap-2">
          <div class="h-7 relative">
            <h2 class="text-lg font-bold text-black" style="font-family: 'Nunito Sans', sans-serif; font-variation-settings: 'YTLC' 500, 'wdth' 100;">
              Đặt lịch khám
            </h2>
            <button 
              @click="closePopup"
              class="absolute right-0 top-0 w-7 h-7 flex items-center justify-center hover:opacity-70 transition-opacity"
            >
              <img :src="iconClose" alt="Close" class="w-full h-full" />
            </button>
          </div>
          <p class="text-sm font-medium text-gray-500" style="font-family: 'Nunito Sans', sans-serif; font-variation-settings: 'YTLC' 500, 'wdth' 100;">
            {{ stepDescriptions[currentStep] }}
          </p>
        </div>

        <!-- Progress Stepper -->
        <div class="flex flex-col gap-2 h-9">
          <div class="flex items-center justify-between h-5">
            <span 
              v-for="(step, index) in steps" 
              :key="index"
              class="text-sm font-medium"
              :class="index <= currentStep ? 'text-teal-600' : 'text-gray-500'"
              style="font-family: 'Nunito Sans', sans-serif; font-variation-settings: 'YTLC' 500, 'wdth' 100;"
            >
              {{ step }}
            </span>
          </div>
          <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
            <div 
              class="h-full bg-teal-600 rounded-full transition-all duration-300"
              :style="{ width: progressWidth }"
            ></div>
          </div>
        </div>

        <!-- Step 1: Chọn thú cưng -->
        <div v-if="currentStep === 0" class="flex flex-col gap-4">
          <div class="grid grid-cols-2 gap-4">
            <div 
              v-for="pet in pets" 
              :key="pet.id"
              @click="selectPet(pet)"
              :class="[
                'border-2 rounded-lg p-[18px] cursor-pointer transition-all',
                selectedPet?.id === pet.id 
                  ? 'border-teal-500 bg-teal-50' 
                  : 'border-gray-200 hover:border-gray-300'
              ]"
            >
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center flex-shrink-0">
                  <img :src="iconPet" alt="Pet" class="w-6 h-6" />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-black truncate" style="font-family: 'Nunito Sans', sans-serif;">
                    {{ pet.name }}
                  </p>
                  <p class="text-sm font-medium text-gray-500 truncate" style="font-family: 'Nunito Sans', sans-serif;">
                    {{ pet.breed }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <button 
            @click="$emit('openAddPet')"
            class="w-full h-9 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-colors flex items-center justify-center gap-2"
          >
            <img :src="iconPlus" alt="Add" class="w-4 h-4" />
            <span class="text-sm font-semibold text-black" style="font-family: 'Nunito Sans', sans-serif;">
              Thêm thú cưng mới
            </span>
          </button>
        </div>

        <!-- Step 2: Chọn dịch vụ -->
        <div v-if="currentStep === 1" class="flex flex-col gap-3">
          <div 
            v-for="service in services" 
            :key="service.id"
            @click="selectService(service)"
            :class="[
              'border-2 rounded-lg p-[18px] cursor-pointer transition-all',
              selectedService?.id === service.id 
                ? 'border-teal-500 bg-teal-50' 
                : 'border-gray-300 hover:border-gray-400'
            ]"
          >
            <div class="flex flex-col gap-1">
              <div class="flex items-center gap-2">
                <p class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">
                  {{ service.name }}
                </p>
                <img v-if="selectedService?.id === service.id" :src="iconCheck" alt="Selected" class="w-5 h-5" />
              </div>
              <p class="text-sm font-medium text-gray-600" style="font-family: 'Nunito Sans', sans-serif;">
                {{ service.description }}
              </p>
              <div class="flex items-center gap-4 mt-1">
                <div class="flex items-center gap-1">
                  <img :src="iconClock" alt="Time" class="w-4 h-4" />
                  <span class="text-sm font-medium text-gray-500" style="font-family: 'Nunito Sans', sans-serif;">
                    {{ service.duration }} phút
                  </span>
                </div>
                <span class="text-sm font-medium text-teal-600" style="font-family: 'Nunito Sans', sans-serif;">
                  {{ formatPrice(service.price) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 3: Chọn ngày giờ -->
        <div v-if="currentStep === 2" class="flex flex-col gap-4">
          <!-- Date Picker -->
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black" style="font-family: 'Nunito Sans', sans-serif;">
              Chọn ngày khám
            </label>
            <div class="border border-gray-300 rounded-lg p-3">
              <div class="flex flex-col items-center">
                <!-- Calendar Header -->
                <div class="flex items-center justify-between w-full mb-4">
                  <button 
                    @click="previousMonth"
                    class="w-7 h-7 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors"
                    :disabled="!canGoPrevious"
                    :class="{ 'opacity-50 cursor-not-allowed': !canGoPrevious }"
                  >
                    <img :src="iconChevronLeft" alt="Previous" class="w-4 h-4" />
                  </button>
                  <span class="text-sm font-semibold text-black" style="font-family: 'Nunito Sans', sans-serif;">
                    {{ currentMonthYear }}
                  </span>
                  <button 
                    @click="nextMonth"
                    class="w-7 h-7 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors"
                    :disabled="!canGoNext"
                    :class="{ 'opacity-50 cursor-not-allowed': !canGoNext }"
                  >
                    <img :src="iconChevronRight" alt="Next" class="w-4 h-4" />
                  </button>
                </div>

                <!-- Calendar Grid -->
                <div class="w-full">
                  <div class="grid grid-cols-7 gap-0 mb-2">
                    <div 
                      v-for="day in weekDays" 
                      :key="day"
                      class="h-5 flex items-center justify-center"
                    >
                      <span class="text-sm font-medium text-gray-500" style="font-family: 'Nunito Sans', sans-serif;">
                        {{ day }}
                      </span>
                    </div>
                  </div>
                  <div class="grid grid-cols-7 gap-0">
                    <button
                      v-for="(date, index) in calendarDates"
                      :key="index"
                      @click="selectDate(date)"
                      :disabled="!date.isCurrentMonth || date.isPast"
                      :class="[
                        'w-8 h-8 flex items-center justify-center rounded-lg text-sm font-medium transition-colors',
                        date.isSelected 
                          ? 'bg-black text-white' 
                          : (!date.isCurrentMonth || date.isPast 
                              ? 'opacity-50 cursor-not-allowed text-gray-500' 
                              : 'text-black hover:bg-gray-100 cursor-pointer')
                      ]"
                      style="font-family: 'Nunito Sans', sans-serif;"
                    >
                      {{ date.day }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Time Picker -->
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black" style="font-family: 'Nunito Sans', sans-serif;">
              Chọn giờ khám
            </label>
            <div class="grid grid-cols-4 gap-2">
              <button
                v-for="time in timeSlots"
                :key="time.value"
                @click="selectTime(time)"
                :disabled="time.isBooked"
                :class="[
                  'h-9 border rounded-lg text-sm font-semibold transition-colors',
                  selectedTime === time.value ? 'bg-teal-600 text-white border-teal-600' : '',
                  time.isBooked ? 'opacity-50 cursor-not-allowed border-gray-300 bg-white text-black' : '',
                  !time.isBooked && selectedTime !== time.value ? 'border-gray-300 bg-white text-black hover:border-gray-400' : ''
                ]"
                style="font-family: 'Nunito Sans', sans-serif;"
              >
                {{ time.label }}
              </button>
            </div>
            <p class="text-sm font-medium text-gray-500 mt-1" style="font-family: 'Nunito Sans', sans-serif;">
              * Các khung giờ bị mờ đã kín lịch
            </p>
          </div>
        </div>

        <!-- Step 4: Xác nhận -->
        <div v-if="currentStep === 3" class="flex flex-col gap-4">
          <!-- Thông tin đặt lịch -->
          <div class="bg-teal-50 rounded-lg p-4 flex flex-col gap-3">
            <h3 class="text-sm font-semibold text-teal-900" style="font-family: 'Nunito Sans', sans-serif;">
              Thông tin đặt lịch
            </h3>
            <div class="w-full h-px bg-gray-300"></div>
            <div class="flex flex-col gap-2">
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-600" style="font-family: 'Nunito Sans', sans-serif;">Khách hàng:</span>
                <span class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">{{ customerName }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-600" style="font-family: 'Nunito Sans', sans-serif;">Thú cưng:</span>
                <span class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">{{ selectedPet?.name }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-600" style="font-family: 'Nunito Sans', sans-serif;">Dịch vụ:</span>
                <span class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">{{ selectedService?.name }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-600" style="font-family: 'Nunito Sans', sans-serif;">Thời gian:</span>
                <span class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">{{ formattedDateTime }}</span>
              </div>
              <div class="w-full h-px bg-gray-300"></div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-black" style="font-family: 'Nunito Sans', sans-serif;">Tạm tính:</span>
                <span class="text-sm font-medium text-teal-600" style="font-family: 'Nunito Sans', sans-serif;">{{ formatPrice(selectedService?.price) }}</span>
              </div>
            </div>
          </div>

          <!-- Phương thức thanh toán -->
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-black" style="font-family: 'Nunito Sans', sans-serif;">
              Phương thức thanh toán
            </label>
            <div class="flex flex-col gap-2">
              <!-- Thanh toán trước -->
              <div 
                @click="selectPaymentMethod('online')"
                :class="[
                  'border rounded-lg p-3 flex items-start gap-2 cursor-pointer transition-all',
                  paymentMethod === 'online' ? 'border-teal-500 bg-teal-50' : 'border-gray-300 hover:border-gray-400'
                ]"
              >
                <div class="w-4 h-4 rounded-full border-2 mt-0.5 flex items-center justify-center flex-shrink-0"
                     :class="paymentMethod === 'online' ? 'border-black' : 'border-gray-400'">
                  <div v-if="paymentMethod === 'online'" class="w-2 h-2 bg-black rounded-full"></div>
                </div>
                <div class="flex-1 flex items-center justify-between gap-2">
                  <span class="text-sm font-semibold text-black" style="font-family: 'Nunito Sans', sans-serif;">
                    Thanh toán trước (VNPay/Momo)
                  </span>
                  <span class="text-sm font-semibold text-gray-500 text-right" style="font-family: 'Nunito Sans', sans-serif; max-width: 128px;">
                    Thanh toán ngay và được ưu tiên
                  </span>
                </div>
              </div>

              <!-- Thanh toán tại phòng khám -->
              <div 
                @click="selectPaymentMethod('offline')"
                :class="[
                  'border rounded-lg p-3 flex items-start gap-2 cursor-pointer transition-all',
                  paymentMethod === 'offline' ? 'border-teal-500 bg-teal-50' : 'border-gray-300 hover:border-gray-400'
                ]"
              >
                <div class="w-4 h-4 rounded-full border-2 mt-0.5 flex items-center justify-center flex-shrink-0"
                     :class="paymentMethod === 'offline' ? 'border-black' : 'border-gray-400'">
                  <div v-if="paymentMethod === 'offline'" class="w-2 h-2 bg-black rounded-full"></div>
                </div>
                <div class="flex-1 flex items-center justify-between gap-2">
                  <span class="text-sm font-semibold text-black" style="font-family: 'Nunito Sans', sans-serif;">
                    Thanh toán tại phòng khám
                  </span>
                  <span class="text-sm font-semibold text-gray-500 text-right" style="font-family: 'Nunito Sans', sans-serif; max-width: 119px;">
                    Thanh toán khi đến khám
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer Buttons -->
        <div class="flex items-center justify-end gap-6">
          <button 
            v-if="currentStep > 0"
            @click="previousStep"
            class="h-9 px-4 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 transition-colors"
          >
            <span class="text-sm font-semibold text-black" style="font-family: 'Nunito Sans', sans-serif;">
              Quay lại
            </span>
          </button>
          <button 
            v-if="currentStep < 3"
            @click="nextStep"
            :disabled="!canProceed"
            :class="[
              'h-9 px-4 rounded-lg transition-colors',
              canProceed 
                ? 'bg-teal-600 hover:bg-teal-700 text-white' 
                : 'bg-gray-300 text-gray-500 cursor-not-allowed'
            ]"
          >
            <span class="text-sm font-semibold" style="font-family: 'Nunito Sans', sans-serif;">
              Tiếp tục
            </span>
          </button>
          <button 
            v-if="currentStep === 3"
            @click="confirmBooking"
            :disabled="!canConfirm"
            :class="[
              'h-9 px-3 rounded-lg flex items-center gap-2 transition-colors',
              canConfirm 
                ? 'bg-teal-600 hover:bg-teal-700 text-white' 
                : 'bg-gray-300 text-gray-500 cursor-not-allowed'
            ]"
          >
            <img :src="iconCheckWhite" alt="Check" class="w-5 h-5" />
            <span class="text-sm font-semibold" style="font-family: 'Nunito Sans', sans-serif;">
              Xác nhận đặt lịch
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';

// Props
const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  customerName: {
    type: String,
    default: 'Phương Linh'
  },
  initialData: {
    type: Object,
    default: null
  }
});

// Emits
const emit = defineEmits(['close', 'confirm', 'openAddPet']);

// Icons (from Figma API)
const iconClose = 'https://www.figma.com/api/mcp/asset/79d55341-dcb3-431e-8e77-d949b6e94323';
const iconPet = 'https://www.figma.com/api/mcp/asset/ef916bf9-89d0-4f44-af2d-27055eba7ed4';
const iconPlus = 'https://www.figma.com/api/mcp/asset/c50a52f1-d921-4402-92cd-bd9d8d2e8979';
const iconCheck = 'https://www.figma.com/api/mcp/asset/f20026eb-0c07-42a0-9860-ee46dcc236f0';
const iconClock = 'https://www.figma.com/api/mcp/asset/782b4104-3e28-4483-8176-05843a28806e';
const iconChevronLeft = 'https://www.figma.com/api/mcp/asset/0fac0d07-36eb-400c-bc9b-443c185c380e';
const iconChevronRight = 'https://www.figma.com/api/mcp/asset/d4ec99aa-41aa-4aa8-9031-beb16589d32d';
const iconCheckWhite = 'https://www.figma.com/api/mcp/asset/7952c458-389a-4827-9b73-ee00c4328dab';
const iconSuccess = 'https://www.figma.com/api/mcp/asset/c7c04549-7865-402c-ba5c-c220ddf99e13';

// Step Management
const currentStep = ref(0);
const steps = ['Chọn thú cưng', 'Chọn dịch vụ', 'Chọn ngày giờ', 'Xác nhận'];
const stepDescriptions = [
  'Chọn thú cưng cần khám',
  'Chọn dịch vụ khám',
  'Chọn ngày và giờ khám',
  'Xác nhận thông tin'
];

const progressWidth = computed(() => {
  return `${((currentStep.value + 1) / steps.length) * 100}%`;
});

// Data
const pets = ref([
  { id: 1, name: 'Milo', breed: 'Poodle' },
  { id: 2, name: 'Luna', breed: 'Scottish Fold' }
]);

const services = ref([
  { id: 1, name: 'Khám tổng quát', description: 'Khám sức khỏe tổng quát', duration: 30, price: 150000 },
  { id: 2, name: 'Tiêm phòng 6 bệnh', description: 'Phòng ngừa 6 bệnh phổ biến', duration: 15, price: 200000 },
  { id: 3, name: 'Tiêm phòng dại', description: 'Phòng ngừa bệnh dại', duration: 15, price: 100000 },
  { id: 4, name: 'Tắm rửa', description: 'Tắm rửa vệ sinh', duration: 60, price: 120000 },
  { id: 5, name: 'Cắt tỉa lông', description: 'Cắt tỉa tạo kiểu', duration: 45, price: 150000 },
  { id: 6, name: 'Khám chuyên sâu', description: 'Khám chuyên khoa', duration: 60, price: 300000 },
  { id: 7, name: 'Khám da liễu', description: 'Khám và điều trị các bệnh về da', duration: 45, price: 250000 }
]);

const weekDays = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

const timeSlots = ref([
  { value: '08:00', label: '08:00', isBooked: false },
  { value: '08:30', label: '08:30', isBooked: false },
  { value: '09:00', label: '09:00', isBooked: true },
  { value: '09:30', label: '09:30', isBooked: false },
  { value: '10:00', label: '10:00', isBooked: false },
  { value: '10:30', label: '10:30', isBooked: true },
  { value: '11:00', label: '11:00', isBooked: false },
  { value: '11:30', label: '11:30', isBooked: false },
  { value: '13:00', label: '13:00', isBooked: false },
  { value: '13:30', label: '13:30', isBooked: false },
  { value: '14:00', label: '14:00', isBooked: true },
  { value: '14:30', label: '14:30', isBooked: false },
  { value: '15:00', label: '15:00', isBooked: false },
  { value: '15:30', label: '15:30', isBooked: false },
  { value: '16:00', label: '16:00', isBooked: false },
  { value: '16:30', label: '16:30', isBooked: false },
  { value: '17:00', label: '17:00', isBooked: false }
]);

// Selection States
const selectedPet = ref(null);
const selectedService = ref(null);
const selectedDate = ref(null);
const selectedTime = ref(null);
const paymentMethod = ref('online');

// Success State
const showSuccess = ref(false);
const bookingCode = ref('');

// Calendar State
const currentMonth = ref(new Date().getMonth());
const currentYear = ref(new Date().getFullYear());

const currentMonthYear = computed(() => {
  const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  return `${months[currentMonth.value]} ${currentYear.value}`;
});

const calendarDates = computed(() => {
  const dates = [];
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  
  const firstDay = new Date(currentYear.value, currentMonth.value, 1);
  const lastDay = new Date(currentYear.value, currentMonth.value + 1, 0);
  const startingDayOfWeek = firstDay.getDay();
  
  // Previous month dates
  const prevMonthLastDay = new Date(currentYear.value, currentMonth.value, 0);
  for (let i = startingDayOfWeek - 1; i >= 0; i--) {
    const day = prevMonthLastDay.getDate() - i;
    dates.push({
      day,
      isCurrentMonth: false,
      isPast: true,
      isSelected: false,
      date: new Date(currentYear.value, currentMonth.value - 1, day)
    });
  }
  
  // Current month dates
  for (let day = 1; day <= lastDay.getDate(); day++) {
    const date = new Date(currentYear.value, currentMonth.value, day);
    date.setHours(0, 0, 0, 0);
    const isPast = date < today;
    const isSelected = selectedDate.value && 
      date.getDate() === selectedDate.value.getDate() &&
      date.getMonth() === selectedDate.value.getMonth() &&
      date.getFullYear() === selectedDate.value.getFullYear();
    
    dates.push({
      day,
      isCurrentMonth: true,
      isPast,
      isSelected,
      date
    });
  }
  
  // Next month dates to fill the grid
  const remainingDays = 42 - dates.length;
  for (let day = 1; day <= remainingDays; day++) {
    dates.push({
      day,
      isCurrentMonth: false,
      isPast: false,
      isSelected: false,
      date: new Date(currentYear.value, currentMonth.value + 1, day)
    });
  }
  
  return dates;
});

const canGoPrevious = computed(() => {
  const today = new Date();
  return currentYear.value > today.getFullYear() || 
    (currentYear.value === today.getFullYear() && currentMonth.value > today.getMonth());
});

const canGoNext = computed(() => {
  // Allow navigation up to 6 months in the future
  const today = new Date();
  const maxDate = new Date(today.getFullYear(), today.getMonth() + 6);
  const currentDate = new Date(currentYear.value, currentMonth.value);
  return currentDate < maxDate;
});

// Computed Properties
const canProceed = computed(() => {
  switch (currentStep.value) {
    case 0:
      return selectedPet.value !== null;
    case 1:
      return selectedService.value !== null;
    case 2:
      return selectedDate.value !== null && selectedTime.value !== null;
    default:
      return false;
  }
});

const canConfirm = computed(() => {
  return selectedPet.value && selectedService.value && selectedDate.value && selectedTime.value && paymentMethod.value;
});

const formattedDateTime = computed(() => {
  if (!selectedDate.value || !selectedTime.value) return '';
  const day = selectedDate.value.getDate().toString().padStart(2, '0');
  const month = (selectedDate.value.getMonth() + 1).toString().padStart(2, '0');
  const year = selectedDate.value.getFullYear();
  return `${selectedTime.value} - ${day}/${month}/${year}`;
});

// Methods
const selectPet = (pet) => {
  selectedPet.value = pet;
};

const selectService = (service) => {
  selectedService.value = service;
};

const selectDate = (date) => {
  if (!date.isCurrentMonth || date.isPast) return;
  selectedDate.value = date.date;
};

const selectTime = (time) => {
  if (time.isBooked) return;
  selectedTime.value = time.value;
};

const selectPaymentMethod = (method) => {
  paymentMethod.value = method;
};

const previousMonth = () => {
  if (!canGoPrevious.value) return;
  if (currentMonth.value === 0) {
    currentMonth.value = 11;
    currentYear.value--;
  } else {
    currentMonth.value--;
  }
};

const nextMonth = () => {
  if (!canGoNext.value) return;
  if (currentMonth.value === 11) {
    currentMonth.value = 0;
    currentYear.value++;
  } else {
    currentMonth.value++;
  }
};

const nextStep = () => {
  if (canProceed.value && currentStep.value < 3) {
    currentStep.value++;
  }
};

const previousStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--;
  }
};

const closePopup = () => {
  emit('close');
  // Reset after animation
  setTimeout(() => {
    currentStep.value = 0;
    selectedPet.value = null;
    selectedService.value = null;
    selectedDate.value = null;
    selectedTime.value = null;
    paymentMethod.value = 'online';
    showSuccess.value = false;
    bookingCode.value = '';
  }, 300);
};

const confirmBooking = () => {
  if (!canConfirm.value) return;
  
  // Generate booking code (in real app, this would come from backend)
  bookingCode.value = `#LH${String(Math.floor(Math.random() * 1000000)).padStart(6, '0')}`;
  
  const bookingData = {
    pet: selectedPet.value,
    service: selectedService.value,
    date: selectedDate.value,
    time: selectedTime.value,
    paymentMethod: paymentMethod.value,
    totalPrice: selectedService.value.price,
    bookingCode: bookingCode.value
  };
  
  // Show success popup instead of closing immediately
  showSuccess.value = true;
  
  emit('confirm', bookingData);
};

const closeSuccessPopup = () => {
  showSuccess.value = false;
  closePopup();
};

const formatPrice = (price) => {
  if (!price) return '';
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(price).replace('₫', '₫');
};

// Watch for calendar month changes to reset selected date if out of range
watch([currentMonth, currentYear], () => {
  if (selectedDate.value) {
    const selectedMonth = selectedDate.value.getMonth();
    const selectedYear = selectedDate.value.getFullYear();
    if (selectedMonth !== currentMonth.value || selectedYear !== currentYear.value) {
      // Keep the selection but just ensure it's visible when user navigates back
    }
  }
});

// Watch for isOpen to handle initial data (Rebook functionality)
watch(() => props.isOpen, (newVal) => {
  if (newVal && props.initialData) {
    const pet = pets.value.find(p => p.name === props.initialData.petName);
    const service = services.value.find(s => s.name === props.initialData.serviceName);

    if (pet) selectedPet.value = pet;
    if (service) selectedService.value = service;

    // Handle pre-selected date if provided (for vaccination reminders)
    if (props.initialData.dueDate) {
      const [day, month, year] = props.initialData.dueDate.split('/');
      const preSelectedDate = new Date(parseInt(year), parseInt(month) - 1, parseInt(day));
      selectedDate.value = preSelectedDate;
      
      // Navigate to the correct month
      currentMonth.value = preSelectedDate.getMonth();
      currentYear.value = preSelectedDate.getFullYear();
    }

    if (pet && service) {
      currentStep.value = 2; // Jump to Date/Time selection
    }
  }
});
</script>

<style scoped>
/* Custom scrollbar for modal */
.overflow-y-auto::-webkit-scrollbar {
  width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
