<template>
  <div class="min-h-screen py-7 px-12 max-w-5xl mx-auto md:px-6 sm:px-4">
    <!-- Dashboard - Trang Của Tôi -->
    <div class="bg-teal-50 border border-teal-300 rounded-xl p-8 flex gap-3 mb-6 sm:p-4">
      <img src="https://www.figma.com/api/mcp/asset/49a71dd4-fc1c-432b-9dcf-953170709dbc" alt="Info"
        class="w-4 h-4 flex-shrink-0 mt-1" />
      <div>
        <p class="font-semibold text-base text-teal-900 mb-2">
          Chào mừng bạn quay trở lại ! Bạn có
        </p>
        <div class="text-3xl font-bold text-teal-900 mb-2 sm:text-2xl">
          2 lịch hẹn sắp tới
        </div>
        <p class="inline font-semibold text-base text-teal-900">và</p>
        <div class="text-3xl font-bold text-orange-500 inline mx-1 sm:text-2xl">
          1 thanh toán chờ xử lý
        </div>
        <p class="inline font-semibold text-base text-teal-900">.</p>
      </div>
    </div>

    <div class="flex gap-16 mb-11">
      <button
        @click="openBookingPopup"
        class="flex-1 flex items-center justify-center gap-4 py-6 rounded-lg bg-teal-700 text-white font-bold text-xl hover:bg-teal-800 transition">
        <img src="https://www.figma.com/api/mcp/asset/025ca85f-759b-44b3-ab90-5dc1971e474e" alt="Calendar"
          class="w-6 h-6" />
        <span>Đặt lịch khám</span>
      </button>
      <button
        @click="openAddPetPopup"
        class="flex-1 flex items-center justify-center gap-4 py-6 rounded-lg bg-white border border-teal-200 text-teal-700 font-bold text-xl hover:bg-teal-50 transition">
        <img src="https://www.figma.com/api/mcp/asset/a40f71e4-b37d-4574-9e21-93c9c182618f" alt="Pet" class="w-4 h-4" />
        <span>Thêm thú cưng</span>
      </button>
    </div>
    <div class="grid grid-cols-3 gap-11 mb-6">
      <div class="bg-white border border-sky-400 rounded-2xl p-6 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-10">
          <span class="text-gray-600 text-lg font-normal">Lịch hẹn sắp tới</span>
          <img src="https://www.figma.com/api/mcp/asset/9b6de4bd-0c67-42f6-8919-5a89c9d57795" alt="Calendar"
            class="w-5 h-5" />
        </div>
        <div>
          <div class="text-5xl font-normal text-gray-900 font-['Nunito']">
            2
          </div>
          <div class="text-sky-400 text-lg font-bold italic mt-1">
            Trong tháng này
          </div>
        </div>
      </div>

      <div class="bg-white border border-orange-400 rounded-2xl p-6 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-10">
          <span class="text-gray-600 text-lg font-normal">Nhắc tiêm phòng</span>
          <img src="https://www.figma.com/api/mcp/asset/d433ca14-4dd1-49bc-8593-b94d0391691b" alt="Syringe"
            class="w-5 h-5" />
        </div>
        <div>
          <div class="text-5xl font-normal text-gray-900 font-['Nunito']">
            2
          </div>
          <div class="text-orange-400 text-lg font-bold italic mt-1">
            Cần tiêm trong tháng này
          </div>
        </div>
      </div>

      <div class="bg-white border border-purple-300 rounded-2xl p-6 flex flex-col justify-between">
        <div class="flex justify-between items-center mb-10">
          <span class="text-gray-600 text-lg font-normal">Thanh toán chờ xử lý</span>
          <img src="https://www.figma.com/api/mcp/asset/a714ee2e-53af-45f6-8ce5-0f4e3d4f1fe1" alt="Payment"
            class="w-5 h-5" />
        </div>
        <div>
          <div class="text-5xl font-normal text-gray-900 font-['Nunito']">
            500.000đ
          </div>
          <div class="text-purple-400 text-lg font-bold italic mt-1">
            1 hóa đơn chưa thanh toán
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl p-6 mb-6">
      <div class="flex justify-between items-start mb-8 sm:flex-col sm:gap-4">
        <div>
          <h3 class="text-xl font-medium text-black mb-1">Lịch hẹn sắp tới</h3>
          <p class="text-sm text-gray-500 font-medium">
            Các buổi khám được xếp lịch
          </p>
        </div>
        <button class="flex items-center gap-1 text-teal-600 font-semibold text-base hover:text-teal-700 transition">
          <span>Xem tất cả</span>
          <img src="https://www.figma.com/api/mcp/asset/aaf1156e-154d-4557-a460-f3937caa8aa1" alt="Arrow"
            class="w-5 h-5" />
        </button>
      </div>

      <div class="space-y-4">
        <div
          class="border border-gray-200 rounded-lg p-4 flex justify-between items-center sm:flex-col sm:items-start sm:gap-4">
          <div class="flex gap-6 items-center sm:flex-col sm:items-start sm:gap-3">
            <div class="bg-teal-100 rounded-lg w-14 h-14 flex flex-col items-center justify-center flex-shrink-0">
              <div class="text-teal-800 font-bold text-base">10</div>
              <div class="text-teal-900 text-xs font-normal font-['Inter']">
                Th 11
              </div>
            </div>
            <div>
              <h4 class="font-semibold text-base text-black mb-1">
                Khám tổng quát
              </h4>
              <p class="text-gray-500 text-sm font-semibold mb-2">
                Thú cưng: Milo
              </p>
              <div class="flex gap-4 items-center text-sm font-semibold text-gray-500">
                <div class="flex items-center gap-1">
                  <img src="https://www.figma.com/api/mcp/asset/14f8de4e-b077-4bd3-a835-d2b8982e18b3" alt="Time"
                    class="w-4 h-4" />
                  <span>14:00</span>
                </div>
                <div class="flex items-center gap-1">
                  <img src="https://www.figma.com/api/mcp/asset/7e6f603b-5f0e-47c5-a267-8d650a959528" alt="Doctor"
                    class="w-4 h-4" />
                  <span>Bs. Nguyễn Thị B</span>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-col gap-2 items-center sm:flex-row sm:w-full sm:justify-between">
            <span class="bg-teal-100 text-teal-800 font-bold text-base px-2 py-1 rounded-lg">Đã xác nhận</span>
            <button
              @click="openAppointmentDetail(appointment1)"
              class="border border-gray-300 text-black font-bold text-base px-3 py-1 rounded-lg hover:bg-gray-50 transition">
              Chi tiết
            </button>
          </div>
        </div>

        <div
          class="border border-gray-200 rounded-lg p-4 flex justify-between items-center sm:flex-col sm:items-start sm:gap-4">
          <div class="flex gap-6 items-center sm:flex-col sm:items-start sm:gap-3">
            <div class="bg-teal-100 rounded-lg w-14 h-14 flex flex-col items-center justify-center flex-shrink-0">
              <div class="text-teal-800 font-bold text-base">15</div>
              <div class="text-teal-900 text-xs font-normal font-['Inter']">
                Th 11
              </div>
            </div>
            <div>
              <h4 class="font-semibold text-base text-black mb-1">
                Tiêm phòng dại
              </h4>
              <p class="text-gray-500 text-sm font-semibold mb-2">
                Thú cưng: Luna
              </p>
              <div class="flex gap-4 items-center text-sm font-semibold text-gray-500">
                <div class="flex items-center gap-1">
                  <img src="https://www.figma.com/api/mcp/asset/14f8de4e-b077-4bd3-a835-d2b8982e18b3" alt="Time"
                    class="w-4 h-4" />
                  <span>10:30</span>
                </div>
                <div class="flex items-center gap-1">
                  <img src="https://www.figma.com/api/mcp/asset/7e6f603b-5f0e-47c5-a267-8d650a959528" alt="Doctor"
                    class="w-4 h-4" />
                  <span>Bs. Trần Văn C</span>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-col gap-2 items-center sm:flex-row sm:w-full sm:justify-between">
            <span class="bg-teal-100 text-teal-800 font-bold text-base px-2 py-1 rounded-lg">Đã xác nhận</span>
            <button
              @click="openAppointmentDetail(appointment2)"
              class="border border-gray-300 text-black font-bold text-base px-3 py-1 rounded-lg hover:bg-gray-50 transition">
              Chi tiết
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-yellow-50/30 border border-yellow-300 rounded-2xl p-8">
      <div class="flex gap-2 items-start mb-6">
        <img src="https://www.figma.com/api/mcp/asset/af47be4d-4749-4d4e-94e2-ea38f8f3f6a5" alt="Alert"
          class="w-5 h-5 flex-shrink-0" />
        <div>
          <h3 class="text-xl font-bold text-orange-900">Nhắc nhở tiêm phòng</h3>
          <p class="text-base text-orange-700 mt-2">
            Đừng quên lịch tiêm phòng cho bé cưng
          </p>
        </div>
      </div>

      <div class="space-y-3">
        <div class="bg-white border border-yellow-300 rounded-lg p-3.5 flex justify-between items-center">
          <div>
            <h4 class="font-bold text-base text-black mb-1">Milo</h4>
            <p class="text-gray-500 text-base font-normal font-['Inter']">
              Tiêm phòng 6 bệnh
            </p>
          </div>
          <div class="text-right">
            <p class="text-orange-700 font-bold text-base mb-1">
              Đến hạn: 20/11/2025
            </p>
            <button @click="openVaccinationBooking('Milo', 'Tiêm phòng 6 bệnh', '20/11/2025')" class="text-teal-600 font-semibold text-sm hover:text-teal-700 transition">
              Đặt lịch ngay
            </button>
          </div>
        </div>

        <div class="bg-white border border-yellow-300 rounded-lg p-3.5 flex justify-between items-center">
          <div>
            <h4 class="font-bold text-base text-black mb-1">Luna</h4>
            <p class="text-gray-500 text-base font-normal font-['Inter']">
              Tiêm phòng dại
            </p>
          </div>
          <div class="text-right">
            <p class="text-orange-700 font-bold text-base mb-1">
              Đến hạn: 15/11/2025
            </p>
            <button @click="openVaccinationBooking('Luna', 'Tiêm phòng dại', '15/11/2025')" class="text-teal-600 font-semibold text-sm hover:text-teal-700 transition">
              Đặt lịch ngay
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Pet Popup -->
    <ThemThuCung 
      ref="themThuCungRef"
      :isOpen="isAddPetOpen" 
      @close="closeAddPetPopup" 
      @submit="handleAddPetSubmit" 
    />

    <!-- Success Popup -->
    <ThemThuCungThanhCong 
      :isOpen="isSuccessPopupOpen" 
      :petData="newPetData"
      @close="closeSuccessPopup" 
      @bookAppointment="handleBookAppointment" 
    />

    <!-- Booking Popup -->
    <DatLichKham 
      :isOpen="isBookingPopupOpen" 
      :initialData="rebookData"
      @close="closeBookingPopup" 
      @confirm="handleBookingConfirm"
      @openAddPet="openAddPetPopup" 
    />

    <!-- Appointment Detail Popup -->
    <ChiTietLichHen 
      :isOpen="isAppointmentDetailOpen" 
      :selectedAppt="selectedAppointment"
      @close="closeAppointmentDetail" 
    />
</template>

<script setup>
import { ref } from 'vue';
import ThemThuCung from '../ThuCungCuaToi/ThemThuCung/index.vue';
import DatLichKham from '../LichHen/DatLichKham/index.vue';
import ChiTietLichHen from '../LichHen/ChiTietLichHen/index.vue';

const themThuCungRef = ref(null);
const isAddPetOpen = ref(false);
const isSuccessPopupOpen = ref(false);
const newPetData = ref({});
const isBookingPopupOpen = ref(false);
const rebookData = ref(null);
const isAppointmentDetailOpen = ref(false);
const selectedAppointment = ref({});

// Mock appointment data
const appointment1 = {
  id: '#LH001234',
  service: 'Khám tổng quát',
  pet: 'Milo',
  breed: 'Poodle',
  age: '2 tuổi',
  weight: '5.5 kg',
  doctor: 'Bs. Nguyễn Thị B',
  date: '10/11/2025',
  time: '14:00',
  clinic: 'Phòng khám thú y Petty',
  address: '123 Đường ABC, Quận 1, TP.HCM',
  note: 'Thú cưng cần nhịn ăn trước khi khám'
};

const appointment2 = {
  id: '#LH001235',
  service: 'Tiêm phòng dại',
  pet: 'Luna',
  breed: 'Scottish Fold',
  age: '1.5 tuổi',
  weight: '3.2 kg',
  doctor: 'Bs. Trần Văn C',
  date: '15/11/2025',
  time: '10:30',
  clinic: 'Phòng khám thú y Petty',
  address: '123 Đường ABC, Quận 1, TP.HCM',
  note: 'Mang theo sổ tiêm chủng'
};

const openAddPetPopup = () => {
  isAddPetOpen.value = true;
};

const closeAddPetPopup = () => {
  isAddPetOpen.value = false;
  // Reset form when closing
  setTimeout(() => {
    themThuCungRef.value?.resetForm();
  }, 300);
};

const handleAddPetSubmit = (petData) => {
  console.log('New pet data:', petData);
  // TODO: Implement API call to save pet data
  // Example: await api.addPet(petData);
  
  // Store pet data for success popup
  newPetData.value = petData;
  
  // Close add pet popup and show success popup
  isAddPetOpen.value = false;
  isSuccessPopupOpen.value = true;
};

const closeSuccessPopup = () => {
  isSuccessPopupOpen.value = false;
  // Reset form after closing success popup
  setTimeout(() => {
    themThuCungRef.value?.resetForm();
    newPetData.value = {};
  }, 300);
};

const handleBookAppointment = (petData) => {
  console.log('Book appointment for:', petData);
  // TODO: Navigate to booking page or open booking modal
  // Example: router.push({ name: 'LichHen', query: { petId: petData.id } });
};

const openBookingPopup = () => {
  rebookData.value = null;
  isBookingPopupOpen.value = true;
};

const closeBookingPopup = () => {
  isBookingPopupOpen.value = false;
  // Reset rebookData after closing
  setTimeout(() => {
    rebookData.value = null;
  }, 300);
};

const handleBookingConfirm = (bookingData) => {
  console.log('Booking confirmed:', bookingData);
  // TODO: Implement API call to save booking data
  // Example: await api.createBooking(bookingData);
};

const openAppointmentDetail = (appointment) => {
  selectedAppointment.value = appointment;
  isAppointmentDetailOpen.value = true;
};

const closeAppointmentDetail = () => {
  isAppointmentDetailOpen.value = false;
  // Reset selected appointment after animation
  setTimeout(() => {
    selectedAppointment.value = {};
  }, 300);
};

const openVaccinationBooking = (petName, serviceName, dueDate) => {
  rebookData.value = {
    petName,
    serviceName,
    dueDate
  };
  isBookingPopupOpen.value = true;
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito+Sans:ital,wght@0,400;0,500;0,600;0,700;1,700&family=Nunito:wght@400&display=swap");

body {
  font-family: "Nunito Sans", sans-serif;
}
</style>
