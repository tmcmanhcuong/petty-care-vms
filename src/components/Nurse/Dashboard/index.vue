<template>
  <div class="w-full min-h-screen p-6 flex flex-col gap-6">
    <!-- Header Section -->
    <div class="flex items-center gap-4 h-[60px]">
      <div class="flex-1 flex flex-col">
        <h1 class="font-nunito font-medium text-2xl leading-9 text-[#101828] tracking-[0.0703px]">
          Dashboard - Sảnh chờ
        </h1>
        <p class="font-nunito text-base leading-6 text-[#4a5565] tracking-[-0.3125px]">
          Quản lý hàng chờ & điều phối khách hàng
        </p>
      </div>
      <button 
        class="bg-[#009689] rounded-lg px-4 py-3 flex items-center gap-3 hover:bg-[#007d72] transition-colors"
        @click="createAppointment"
      >
        <img :src="iconCalendarPlus" alt="Create" class="w-4 h-4" />
        <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
          Tạo lịch khám
        </span>
      </button>
      <button 
        class="bg-[#9810fa] rounded-lg px-4 py-3 flex items-center gap-3 hover:bg-[#8000e0] transition-colors"
        @click="createCustomer"
      >
        <img :src="iconUserPlus" alt="New Customer" class="w-4 h-4" />
        <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
          Tạo khách mới
        </span>
      </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-4 gap-4 h-[98px]">
      <div class="bg-white border border-black/10 rounded-[14px] p-[17px] pb-px">
        <div class="flex items-center justify-between h-14">
          <div class="flex flex-col gap-1">
            <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
              Sắp đến
            </p>
            <p class="font-nunito text-2xl leading-8 text-[#155dfc] tracking-[0.0703px]">
              {{ stats.upcoming }}
            </p>
          </div>
          <img :src="iconClock" alt="Upcoming" class="w-8 h-8" />
        </div>
      </div>

      <div class="bg-white border border-black/10 rounded-[14px] p-[17px] pb-px">
        <div class="flex items-center justify-between h-14">
          <div class="flex flex-col gap-1">
            <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
              Đang chờ
            </p>
            <p class="font-nunito text-2xl leading-8 text-[#f54900] tracking-[0.0703px]">
              {{ stats.waiting }}
            </p>
          </div>
          <img :src="iconHourglass" alt="Waiting" class="w-8 h-8" />
        </div>
      </div>

      <div class="bg-white border border-black/10 rounded-[14px] p-[17px] pb-px">
        <div class="flex items-center justify-between h-14">
          <div class="flex flex-col gap-1">
            <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
              Chờ thanh toán
            </p>
            <p class="font-nunito text-2xl leading-8 text-[#00a63e] tracking-[0.0703px]">
              {{ stats.payment }}
            </p>
          </div>
          <img :src="iconDollar" alt="Payment" class="w-8 h-8" />
        </div>
      </div>

      <div class="bg-white border border-black/10 rounded-[14px] p-[17px] pb-px">
        <div class="flex items-center justify-between h-14">
          <div class="flex flex-col gap-1">
            <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
              Tổng hôm nay
            </p>
            <p class="font-nunito text-2xl leading-8 text-[#9810fa] tracking-[0.0703px]">
              {{ stats.total }}
            </p>
          </div>
          <img :src="iconUsers" alt="Total" class="w-8 h-8" />
        </div>
      </div>
    </div>

    <!-- Queue Card -->
    <div class="bg-white border-2 border-[#bedbff] rounded-xl p-6 flex flex-col gap-4">
      <!-- Queue Header -->
      <div class="bg-blue-50 rounded-lg p-2 flex items-center">
        <img :src="iconQueue" alt="Queue" class="w-5 h-5 mr-2" />
        <p class="font-nunito text-base leading-4 text-neutral-950 tracking-[-0.3125px]">
          Hàng chờ hôm nay
        </p>
      </div>

      <!-- Appointments List -->
      <div class="flex flex-col">
        <div
          v-for="(appointment, index) in appointments"
          :key="index"
          class="border-b border-gray-200 p-4 flex flex-col gap-2.5"
        >
          <!-- Badges Row -->
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <!-- Type Badge -->
              <span
                v-if="appointment.type === 'scheduled'"
                class="bg-blue-50 border border-[#bedbff] rounded-lg px-[9px] py-1 flex items-center gap-[5px]"
              >
                <img :src="iconCalendar" alt="Scheduled" class="w-3 h-3" />
                <span class="font-nunito font-medium text-xs leading-4 text-[#1447e6]">
                  Đặt trước
                </span>
              </span>
              <span
                v-else-if="appointment.type === 'walkin'"
                class="bg-purple-50 border border-[#e9d4ff] rounded-lg px-2 py-1 flex items-center gap-2"
              >
                <img :src="iconWalkIn" alt="Walk-in" class="w-3 h-3" />
                <span class="font-nunito font-medium text-xs leading-4 text-[#8200db]">
                  Vãng lai
                </span>
              </span>
              <span
                v-else-if="appointment.type === 'member'"
                class="bg-blue-50 border border-blue-300 rounded-lg px-2 py-1 flex items-center gap-2"
              >
                <img :src="iconMember" alt="Member" class="w-3 h-3" />
                <span class="font-nunito font-medium text-xs leading-4 text-blue-700">
                  Thành Viên
                </span>
              </span>

              <!-- Status Badge -->
              <span
                v-if="appointment.status === 'upcoming'"
                class="bg-blue-100 border border-blue-300 rounded-lg px-[17px] py-[3px]"
              >
                <span class="font-nunito font-medium text-xs leading-4 text-blue-700">
                  Sắp đến
                </span>
              </span>
              <span
                v-else-if="appointment.status === 'arrived'"
                class="bg-green-100 border border-[#7bf1a8] rounded-lg px-[17px] py-[5px]"
              >
                <span class="font-nunito font-medium text-xs leading-4 text-[#008236]">
                  Đã đến
                </span>
              </span>
              <span
                v-else-if="appointment.status === 'payment'"
                class="bg-green-100 border-transparent rounded-lg px-2 py-[2px]"
              >
                <span class="font-nunito font-medium text-xs leading-4 text-[#008236]">
                  Chờ thanh toán
                </span>
              </span>
            </div>

            <!-- Time Badge -->
            <span
              v-if="appointment.delay"
              :class="[
                'rounded-lg px-2 py-[2px] flex items-center gap-2',
                appointment.delay.type === 'late' ? 'bg-red-50 border border-red-300' :
                appointment.delay.type === 'waiting' ? 'bg-[#ffedd4]' :
                appointment.delay.type === 'short' ? 'bg-gray-100' :
                'bg-cyan-50 border border-cyan-200'
              ]"
            >
              <img :src="appointment.delay.icon" alt="Time" class="w-3 h-3" />
              <span
                :class="[
                  'font-nunito font-medium text-xs leading-4',
                  appointment.delay.type === 'late' ? 'text-red-600' :
                  appointment.delay.type === 'waiting' ? 'text-[#ca3500]' :
                  appointment.delay.type === 'short' ? 'text-[#364153]' :
                  'text-cyan-500'
                ]"
              >
                {{ appointment.delay.text }}
              </span>
            </span>
          </div>

          <!-- Pet & Owner Info -->
          <div class="flex items-center gap-3">
            <img
              :src="appointment.petImage"
              :alt="appointment.petName"
              class="w-12 h-12 rounded-[10px] object-cover"
            />
            <div class="flex flex-col gap-1">
              <div class="flex items-center gap-3">
                <p class="font-nunito font-bold text-base leading-6 text-[#101828] tracking-[-0.3125px]">
                  {{ appointment.petName }}
                </p>
                <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
                  {{ appointment.petType }}
                </p>
                <p class="font-nunito text-sm leading-5 text-[#364153] tracking-[-0.1504px]">
                  Chủ: {{ appointment.ownerName }}
                </p>
              </div>
              <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                  <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
                    Giờ hẹn:
                  </p>
                  <p class="font-nunito font-bold text-sm leading-5 text-[#1447e6] tracking-[-0.1504px]">
                    {{ appointment.appointmentTime }}
                  </p>
                </div>
                <div class="flex items-center gap-1">
                  <img
                    :src="appointment.checkedIn ? iconCheckPurple : iconCheckGray"
                    alt="Check-in"
                    class="w-3 h-3"
                  />
                  <p
                    :class="[
                      'font-nunito text-sm leading-4',
                      appointment.checkedIn ? 'text-purple-700' : 'text-gray-500'
                    ]"
                  >
                    Check-in:
                    <span v-if="appointment.checkedIn" class="font-bold">
                      {{ appointment.checkInTime }}
                    </span>
                    <span v-else>--:--</span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Room Assignment (if checked in) -->
          <div
            v-if="appointment.room"
            class="bg-blue-50 border-2 border-[#8ec5ff] rounded-[10px] px-3 py-2 flex items-center justify-between"
          >
            <p class="font-nunito text-xs leading-4 text-[#4a5565]">
              Mời vào:
            </p>
            <p class="font-nunito font-bold text-base leading-6 text-[#1c398e] tracking-[-0.3125px]">
              {{ appointment.room }}
            </p>
          </div>

          <!-- Service & Doctor Info -->
          <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
                Dịch vụ:
              </p>
              <p class="font-nunito font-medium text-lg leading-4 text-neutral-950">
                {{ appointment.service }}
              </p>
            </div>
            <div class="flex items-center justify-between h-5">
              <p class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
                Bác sĩ:
              </p>
              <p class="font-nunito font-medium text-sm leading-5 text-[#364153] tracking-[-0.1504px]">
                {{ appointment.doctor }}
              </p>
            </div>
          </div>

          <!-- Action Button -->
          <button
            v-if="appointment.status === 'upcoming'"
            class="bg-blue-600 rounded-lg h-8 w-full flex items-center justify-center gap-2 hover:bg-blue-700 transition-colors"
            @click="checkIn(appointment)"
          >
            <img :src="iconCheckIn" alt="Check-in" class="w-4 h-4" />
            <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
              Check-In
            </span>
          </button>
          <button
            v-else-if="appointment.status === 'payment'"
            class="bg-green-600 rounded-lg h-8 w-full flex items-center justify-center gap-2 hover:bg-green-700 transition-colors"
            @click="collectPayment(appointment)"
          >
            <img :src="iconMoney" alt="Payment" class="w-4 h-4" />
            <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
              Thu tiền
            </span>
          </button>
        </div>
      </div>
    </div>
    
    <!-- Check-in Modal -->
    <CheckInModal
      :is-open="isCheckInModalOpen"
      :patient-info="selectedAppointment"
      @close="isCheckInModalOpen = false"
      @confirm="handleCheckInConfirm"
    />

    <!-- Create Appointment Modal -->
    <TaoLichKhamModal
      :is-open="isCreateAppointmentModalOpen"
      @close="isCreateAppointmentModalOpen = false"
      @submit="handleCreateAppointmentSubmit"
    />

    <!-- Create Customer Modal -->
    <TaoKhachMoiModal
      :is-open="isCreateCustomerModalOpen"
      @close="isCreateCustomerModalOpen = false"
      @submit="handleCreateCustomerSubmit"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import CheckInModal from '../LichHen/CheckIn/index.vue'
import TaoLichKhamModal from '../LichHen/TaoLichKham/index.vue'
import TaoKhachMoiModal from '../KhachHang/TaoKhachMoi/index.vue'

// Icons from Figma
const iconCalendarPlus = "https://www.figma.com/api/mcp/asset/eb7ba029-87ac-483f-a065-c7a95b006ca8"
const iconUserPlus = "https://www.figma.com/api/mcp/asset/4ee8bff8-974f-463d-9e56-5d8ebb28c911"
const iconClock = "https://www.figma.com/api/mcp/asset/0af944c2-9662-4e84-90c9-e1e0603dfe40"
const iconHourglass = "https://www.figma.com/api/mcp/asset/51760b53-8078-456b-839e-b2740b85f9b5"
const iconDollar = "https://www.figma.com/api/mcp/asset/2d39fef4-1bb4-49bf-a962-ea912dadd540"
const iconUsers = "https://www.figma.com/api/mcp/asset/27d4694f-74ed-4d7c-a4ac-565abd0a5b67"
const iconQueue = "https://www.figma.com/api/mcp/asset/41c800ea-01f1-421f-beb6-91673805bcf6"
const iconCalendar = "https://www.figma.com/api/mcp/asset/b806e6b2-5eb0-4316-967e-e20db0fb53fb"
const iconWalkIn = "https://www.figma.com/api/mcp/asset/b1d7a0e0-a91e-44ac-8e6d-0a7194b71d4a"
const iconMember = "https://www.figma.com/api/mcp/asset/43a32373-ad71-4294-b528-ef85402b0bda"
const iconCheckGray = "https://www.figma.com/api/mcp/asset/ac3540cb-5ef7-4bdb-9121-71953068bffd"
const iconCheckPurple = "https://www.figma.com/api/mcp/asset/d802f853-3fdf-461c-8836-1d9526531d0d"
const iconCheckIn = "https://www.figma.com/api/mcp/asset/a382a642-b1f1-4f96-8d19-8faf985a760d"
const iconMoney = "https://www.figma.com/api/mcp/asset/0b5f2b69-d162-4cfa-9d82-946bf1295c71"
const iconLate = "https://www.figma.com/api/mcp/asset/a3ca31b5-42c5-4af6-aaaf-04e195c5d752"
const iconWaiting = "https://www.figma.com/api/mcp/asset/3a61ff7d-568a-4854-9b64-adedb69ebe1c"
const iconShort = "https://www.figma.com/api/mcp/asset/e641182a-026e-40bd-99a0-5b3ef2d1e51c"
const iconRemaining = "https://www.figma.com/api/mcp/asset/e525afb8-5c7d-455b-a40a-a1f4d0c79573"

const petImage = "https://www.figma.com/api/mcp/asset/c4b42828-cb1a-488a-94f3-8d406a0ef20a"

// Stats
const stats = ref({
  upcoming: 1,
  waiting: 2,
  payment: 2,
  total: 5
})

// Appointments data
const appointments = ref([
  {
    id: 1,
    type: 'scheduled',
    status: 'upcoming',
    petName: 'Milo',
    petType: 'Chó Poodle',
    petImage: petImage,
    ownerName: 'Nguyễn Văn A',
    appointmentTime: '09:00',
    checkedIn: false,
    checkInTime: null,
    service: 'Khám tổng quát',
    doctor: 'BS. Hùng',
    room: null,
    delay: {
      type: 'late',
      text: 'Trễ 30 phút',
      icon: iconLate
    }
  },
  {
    id: 2,
    type: 'walkin',
    status: 'arrived',
    petName: 'Lu',
    petType: 'Mèo Anh Lông Ngắn',
    petImage: petImage,
    ownerName: 'Đỗ Thị D',
    appointmentTime: '--:--',
    checkedIn: true,
    checkInTime: '09:12',
    service: 'Khám tổng quát',
    doctor: 'BS. Hùng',
    room: 'P.102',
    delay: {
      type: 'waiting',
      text: 'Chờ 18 phút',
      icon: iconWaiting
    }
  },
  {
    id: 3,
    type: 'member',
    status: 'arrived',
    petName: 'Luna',
    petType: 'Mèo Ba Tư',
    petImage: petImage,
    ownerName: 'Đỗ Thị D',
    appointmentTime: '--:--',
    checkedIn: true,
    checkInTime: '09:24',
    service: 'Tiêm Phòng Vắc-Xin',
    doctor: 'BS. Hùng',
    room: 'P.102',
    delay: {
      type: 'short',
      text: '6 phút',
      icon: iconShort
    }
  },
  {
    id: 4,
    type: 'scheduled',
    status: 'upcoming',
    petName: 'Max',
    petType: 'Chó Husky',
    petImage: petImage,
    ownerName: 'Lê Văn C',
    appointmentTime: '10:30',
    checkedIn: false,
    checkInTime: null,
    service: 'Khám tổng quát',
    doctor: 'BS. Hùng',
    room: null,
    delay: {
      type: 'remaining',
      text: 'Còn 60 phút',
      icon: iconRemaining
    }
  },
  {
    id: 5,
    type: null,
    status: 'payment',
    petName: 'MiMi',
    petType: 'Chó Poodle',
    petImage: petImage,
    ownerName: 'Phạm Thị D',
    appointmentTime: null,
    checkedIn: false,
    checkInTime: null,
    service: 'Cắt tỉa lông',
    doctor: 'CV. Hoài',
    room: null,
    delay: null
  },
  {
    id: 6,
    type: null,
    status: 'payment',
    petName: 'Rocky',
    petType: 'Chó Bulldog',
    petImage: petImage,
    ownerName: 'Hoàng Văn E',
    appointmentTime: null,
    checkedIn: false,
    checkInTime: null,
    service: 'Khám tổng quát',
    doctor: 'BS. Nam',
    room: null,
    delay: null
  }
])

// Modal State
const isCheckInModalOpen = ref(false)
const isCreateAppointmentModalOpen = ref(false)
const isCreateCustomerModalOpen = ref(false)
const selectedAppointment = ref(null)

// Methods
const createAppointment = () => {
  isCreateAppointmentModalOpen.value = true
}

const handleCreateAppointmentSubmit = (data) => {
  console.log('Create appointment:', data)
  // TODO: Implement API call
  isCreateAppointmentModalOpen.value = false
}

const createCustomer = () => {
  isCreateCustomerModalOpen.value = true
}

const handleCreateCustomerSubmit = (data) => {
  console.log('Create customer:', data)
  // TODO: Implement API call
  isCreateCustomerModalOpen.value = false
}

const checkIn = (appointment) => {
  // Map appointment data to patientInfo structure
  selectedAppointment.value = {
    ...appointment,
    phone: '0901234567', // Mock phone
    species: appointment.petType.split(' ')[0], // Simple split for mock
    breed: appointment.petType.split(' ').slice(1).join(' '),
    birthDate: '01/01/2022', // Mock date
    room: 'P.101' // Assign a default room for check-in
  }
  isCheckInModalOpen.value = true
}

const handleCheckInConfirm = (patientInfo) => {
  // Find the appointment and update it
  const index = appointments.value.findIndex(a => a.id === patientInfo.id)
  if (index !== -1) {
    appointments.value[index].status = 'arrived'
    appointments.value[index].checkedIn = true
    appointments.value[index].checkInTime = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })
    appointments.value[index].room = patientInfo.room
    
    // Update stats
    stats.value.upcoming--
    stats.value.waiting++
  }
  isCheckInModalOpen.value = false
}

const collectPayment = (appointment) => {
  console.log('Collect payment:', appointment.petName)
  // TODO: Implement payment collection logic
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700&display=swap');

* {
  font-family: 'Nunito Sans', sans-serif;
}
</style>
