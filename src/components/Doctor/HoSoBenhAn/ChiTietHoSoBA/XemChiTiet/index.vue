<template>
  <div class="w-full h-full flex flex-col items-start">
    <!-- Dialog Content -->
    <div class="w-full bg-white rounded-[10px] shadow-[0px_20px_25px_-5px_rgba(0,0,0,0.1),0px_8px_10px_-6px_rgba(0,0,0,0.1)] p-6 flex flex-col gap-4">
      <!-- Header -->
      <div class="w-full flex items-center justify-between">
        <h2 class="text-xl font-normal text-neutral-950 leading-7 tracking-[-0.4492px]">
          Phiếu Khám Lâm Sàng - {{ examinationData.date }}
        </h2>
        <button class="bg-white border border-[rgba(0,0,0,0.1)] rounded-lg h-8 px-[10px] flex items-center gap-2 hover:bg-gray-50">
          <img :src="icons.print" alt="" class="w-4 h-4" />
          <span class="text-sm font-medium text-neutral-950 tracking-[-0.1504px]">In phiếu</span>
        </button>
      </div>

      <!-- Scrollable Content -->
      <div class="w-full h-[1150px] flex flex-col gap-6 overflow-y-auto">
        <!-- Basic Info Card -->
        <div class="w-full h-[90px] bg-blue-50 border border-[#bedbff] rounded-[10px] p-[17px]">
          <div class="grid grid-cols-2 gap-4 h-14">
            <!-- Left Column -->
            <div class="flex flex-col gap-2">
              <div class="flex items-center gap-2 h-6">
                <img :src="icons.calendar" alt="" class="w-4 h-4" />
                <span class="text-sm text-[#4a5565] leading-5 tracking-[-0.1504px]">Ngày khám:</span>
                <span class="text-base font-bold text-neutral-950 leading-6 tracking-[-0.3125px]">{{ examinationData.date }}</span>
                <span class="text-sm text-[#6a7282] leading-5 tracking-[-0.1504px]">lúc {{ examinationData.time }}</span>
              </div>
              <div class="flex items-center gap-2 h-6">
                <img :src="icons.doctor" alt="" class="w-4 h-4" />
                <span class="text-sm text-[#4a5565] leading-5 tracking-[-0.1504px]">Bác sĩ:</span>
                <span class="text-base font-bold text-neutral-950 leading-6 tracking-[-0.3125px]">{{ examinationData.doctor }}</span>
              </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-2">
              <div class="flex items-center gap-2 h-6">
                <img :src="icons.owner" alt="" class="w-4 h-4" />
                <span class="text-sm text-[#4a5565] leading-5 tracking-[-0.1504px]">Chủ nuôi:</span>
                <span class="text-base font-bold text-neutral-950 leading-6 tracking-[-0.3125px]">{{ examinationData.ownerName }}</span>
              </div>
              <div class="flex items-center gap-2 h-6">
                <img :src="icons.phone" alt="" class="w-4 h-4" />
                <span class="text-sm text-[#4a5565] leading-5 tracking-[-0.1504px]">SĐT:</span>
                <span class="text-base font-bold text-neutral-950 leading-6 tracking-[-0.3125px]">{{ examinationData.ownerPhone }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="w-full h-px bg-[rgba(0,0,0,0.1)]"></div>

        <!-- Patient Info Section -->
        <div class="w-full flex flex-col gap-3">
          <h3 class="text-lg font-medium text-[#101828] leading-[27px] tracking-[-0.4395px]">
            🐾 Thông tin Bệnh nhân
          </h3>
          <div class="w-full bg-gray-50 rounded-[10px] p-4 flex flex-col gap-2">
            <div class="flex items-center gap-2">
              <span class="text-base font-bold text-neutral-950 tracking-[-0.3125px]">Tên thú cưng:</span>
              <span class="text-base text-neutral-950 tracking-[-0.3125px]">{{ examinationData.petName }} ({{ examinationData.petSpecies }})</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="text-base font-bold text-neutral-950 tracking-[-0.3125px]">Lý do khám:</span>
              <span class="text-base text-neutral-950 tracking-[-0.3125px]">{{ examinationData.reason }}</span>
            </div>
          </div>
        </div>

        <!-- Vital Signs Section -->
        <div class="w-full flex flex-col gap-3">
          <div class="flex items-center gap-2 h-6">
            <img :src="icons.vitals" alt="" class="w-5 h-5" />
            <h3 class="text-base text-[#101828] leading-6 tracking-[-0.3125px]">Chỉ số Sinh tồn</h3>
          </div>
          <div class="grid grid-cols-4 gap-4">
            <!-- Temperature -->
            <div class="bg-red-50 border border-[#ffc9c9] rounded-[10px] p-[13px] flex flex-col gap-1">
              <div class="flex items-center gap-2 h-5">
                <img :src="icons.temperature" alt="" class="w-4 h-4" />
                <span class="text-sm text-[#4a5565] leading-5 tracking-[-0.1504px]">Nhiệt độ</span>
              </div>
              <p class="text-xl text-[#101828] leading-7 tracking-[-0.4492px]">{{ examinationData.vitals.temperature }}</p>
            </div>

            <!-- Heart Rate -->
            <div class="bg-pink-50 border border-[#fccee8] rounded-[10px] p-[13px] flex flex-col gap-1">
              <div class="flex items-center gap-2 h-5">
                <img :src="icons.heartRate" alt="" class="w-4 h-4" />
                <span class="text-sm text-[#4a5565] leading-5 tracking-[-0.1504px]">Nhịp tim</span>
              </div>
              <p class="text-xl text-[#101828] leading-7 tracking-[-0.4492px]">{{ examinationData.vitals.heartRate }}</p>
            </div>

            <!-- Respiratory Rate -->
            <div class="bg-blue-50 border border-[#bedbff] rounded-[10px] p-[13px] flex flex-col gap-1">
              <div class="flex items-center gap-2 h-5">
                <img :src="icons.respiratory" alt="" class="w-4 h-4" />
                <span class="text-sm text-[#4a5565] leading-5 tracking-[-0.1504px]">Nhịp thở</span>
              </div>
              <p class="text-xl text-[#101828] leading-7 tracking-[-0.4492px]">{{ examinationData.vitals.respiratory }}</p>
            </div>

            <!-- Weight -->
            <div class="bg-green-50 border border-[#b9f8cf] rounded-[10px] p-[13px] flex flex-col gap-1">
              <div class="flex items-center gap-2 h-5">
                <img :src="icons.weight" alt="" class="w-4 h-4" />
                <span class="text-sm text-[#4a5565] leading-5 tracking-[-0.1504px]">Cân nặng</span>
              </div>
              <p class="text-xl text-[#101828] leading-7 tracking-[-0.4492px]">{{ examinationData.vitals.weight }}</p>
            </div>
          </div>
        </div>

        <!-- Symptoms Section -->
        <div class="w-full flex flex-col gap-3">
          <div class="flex items-center gap-2 h-6">
            <img :src="icons.symptoms" alt="" class="w-5 h-5" />
            <h3 class="text-base text-[#101828] leading-6 tracking-[-0.3125px]">Triệu chứng</h3>
          </div>
          <div class="w-full bg-orange-50 border border-[#ffd6a7] rounded-[10px] p-[17px]">
            <p class="text-base text-[#1e2939] leading-6 tracking-[-0.3125px]">
              {{ examinationData.symptoms }}
            </p>
          </div>
        </div>

        <!-- Diagnosis Section -->
        <div class="w-full flex flex-col gap-3">
          <div class="flex items-center gap-2 h-6">
            <img :src="icons.diagnosis" alt="" class="w-5 h-5" />
            <h3 class="text-base text-[#101828] leading-6 tracking-[-0.3125px]">Chẩn đoán</h3>
          </div>
          <div class="w-full bg-blue-50 border border-[#bedbff] rounded-[10px] p-[17px]">
            <p class="text-base text-[#1e2939] leading-6 tracking-[-0.3125px]">
              {{ examinationData.diagnosis }}
            </p>
          </div>
        </div>

        <!-- Prescription Section -->
        <div class="w-full flex flex-col gap-3">
          <div class="flex items-center gap-2 h-6">
            <img :src="icons.prescription" alt="" class="w-5 h-5" />
            <h3 class="text-base text-[#101828] leading-6 tracking-[-0.3125px]">Đơn thuốc</h3>
          </div>
          <div class="w-full border border-gray-200 rounded-[10px] overflow-hidden">
            <table class="w-full">
              <thead class="bg-gray-100">
                <tr class="h-11">
                  <th class="text-left px-4 text-sm font-bold text-[#364153] tracking-[-0.1504px]">STT</th>
                  <th class="text-left px-4 text-sm font-bold text-[#364153] tracking-[-0.1504px]">Tên thuốc</th>
                  <th class="text-left px-4 text-sm font-bold text-[#364153] tracking-[-0.1504px]">Liều lượng</th>
                  <th class="text-left px-4 text-sm font-bold text-[#364153] tracking-[-0.1504px]">Tần suất</th>
                  <th class="text-left px-4 text-sm font-bold text-[#364153] tracking-[-0.1504px]">Thời gian</th>
                  <th class="text-left px-4 text-sm font-bold text-[#364153] tracking-[-0.1504px]">Ghi chú</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(medicine, index) in examinationData.prescription"
                  :key="index"
                  class="border-t border-gray-200 h-[44.5px]"
                >
                  <td class="px-4 text-sm text-neutral-950 tracking-[-0.1504px]">{{ index + 1 }}</td>
                  <td class="px-4 text-sm text-neutral-950 tracking-[-0.1504px]">{{ medicine.name }}</td>
                  <td class="px-4 text-sm text-neutral-950 tracking-[-0.1504px]">{{ medicine.dosage }}</td>
                  <td class="px-4 text-sm text-neutral-950 tracking-[-0.1504px]">{{ medicine.frequency }}</td>
                  <td class="px-4 text-sm text-neutral-950 tracking-[-0.1504px]">{{ medicine.duration }}</td>
                  <td class="px-4 text-sm text-[#4a5565] tracking-[-0.1504px]">{{ medicine.note }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Notes Section -->
        <div class="w-full flex flex-col gap-3">
          <h3 class="text-lg font-medium text-[#101828] leading-[27px] tracking-[-0.4395px]">
            Ghi chú
          </h3>
          <div class="w-full bg-yellow-50 border border-[#fff085] rounded-[10px] p-[17px]">
            <p class="text-base text-[#1e2939] leading-6 tracking-[-0.3125px]">
              {{ examinationData.notes }}
            </p>
          </div>
        </div>

        <!-- Footer with Close Button -->
        <div class="w-full border-t border-[rgba(0,0,0,0.1)] pt-[17px] flex justify-end">
          <button
            @click="closeModal"
            class="bg-white border border-[rgba(0,0,0,0.1)] rounded-lg h-9 px-[17px] py-[9px] hover:bg-gray-50"
          >
            <span class="text-sm font-medium text-neutral-950 tracking-[-0.1504px]">Đóng</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

// Icons
const icons = {
  print: 'https://www.figma.com/api/mcp/asset/5d5a2786-34bd-4573-a400-99048b08691d',
  calendar: 'https://www.figma.com/api/mcp/asset/56afdeed-0e62-42e4-863b-8f09692271c4',
  doctor: 'https://www.figma.com/api/mcp/asset/22f3d5c3-3c6b-4d7e-80a9-4c59ccdeca31',
  owner: 'https://www.figma.com/api/mcp/asset/94b608b7-8293-4227-a095-54e9f85cb5e7',
  phone: 'https://www.figma.com/api/mcp/asset/6a6008ef-b424-4d60-bea1-89cd5c71a4e3',
  vitals: 'https://www.figma.com/api/mcp/asset/f433ad1c-0629-4d68-abc0-d7327b6d7331',
  temperature: 'https://www.figma.com/api/mcp/asset/1b16bbaa-31b4-442b-b016-20811f39ac53',
  heartRate: 'https://www.figma.com/api/mcp/asset/98bd780f-82f2-4437-8146-0daa3c7e079a',
  respiratory: 'https://www.figma.com/api/mcp/asset/a7710ae5-e77f-44b4-bbb6-b6db129c61e9',
  weight: 'https://www.figma.com/api/mcp/asset/01b87b21-f20b-4786-9f7e-86030fb9ba93',
  symptoms: 'https://www.figma.com/api/mcp/asset/65935341-9258-4c79-8082-36ddd67bee35',
  diagnosis: 'https://www.figma.com/api/mcp/asset/03475182-f0a6-4df6-8a20-4ddd41e2ae70',
  prescription: 'https://www.figma.com/api/mcp/asset/3936b78c-2b8f-43be-8bc9-f02a5c77c3b9'
}

// Sample examination data
const examinationData = ref({
  date: '01/12/2024',
  time: '14:30',
  doctor: 'BS. Trần Văn B',
  ownerName: 'Nguyễn Văn A',
  ownerPhone: '0901234567',
  petName: 'Milo',
  petSpecies: 'Chó Golden Retriever',
  reason: 'Ngứa ngáy, rụng lông vùng bụng',
  vitals: {
    temperature: '38.5°C',
    heartRate: '110 lần/phút',
    respiratory: '25 lần/phút',
    weight: '28 kg'
  },
  symptoms: 'Thú cưng liên tục ngứa vùng bụng và chân, rụng lông nhiều. Da có vết đỏ và vảy. Chủ nhân cho biết triệu chứng xuất hiện sau khi đổi thức ăn mới.',
  diagnosis: 'Viêm da dị ứng (Allergic Dermatitis) do phản ứng với thành phần trong thức ăn mới. Vùng da bị nhiễm trùng thứ phát do gãi nhiều.',
  prescription: [
    {
      name: 'Ketoconazole Cream 2%',
      dosage: 'Bôi mỏng',
      frequency: '2 lần/ngày',
      duration: '7 ngày',
      note: 'Bôi vào vùng da bị viêm'
    },
    {
      name: 'Amoxicillin 500mg',
      dosage: '1 viên',
      frequency: '2 lần/ngày',
      duration: '7 ngày',
      note: 'Uống sau ăn'
    },
    {
      name: 'Cetirizine 10mg',
      dosage: '1/2 viên',
      frequency: '1 lần/ngày',
      duration: '10 ngày',
      note: 'Giảm ngứa'
    }
  ],
  notes: 'Khuyên chủ nhân ngừng thức ăn mới, quay về thức ăn cũ. Tái khám sau 7 ngày để đánh giá tiến triển. Nếu không cải thiện, cần làm xét nghiệm dị ứng.'
})

const emit = defineEmits(['close'])

// Methods
const closeModal = () => {
  emit('close')
}
</script>
