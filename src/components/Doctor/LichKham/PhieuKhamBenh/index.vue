<template>
  <div class="flex flex-col w-full">
    <!-- Header -->
    <div class="flex items-center justify-between h-[60px] mb-6">
      <!-- Left: Back button & Title -->
      <div class="flex items-center gap-4">
        <button 
          class="h-9 px-3 bg-white border border-[rgba(0,0,0,0.1)] rounded-lg flex items-center gap-2 hover:bg-gray-50 transition-colors"
          @click="handleBack"
        >
          <img :src="icons.arrowLeft" alt="" class="w-4 h-4" />
          <span class="font-medium text-sm leading-5 text-gray-900 tracking-[-0.1504px]">Quay lại</span>
        </button>
        <div class="flex flex-col">
          <h1 class="font-medium text-2xl leading-9 text-[#101828] tracking-[0.0703px]">
            Khám bệnh
          </h1>
          <p class="font-normal text-base leading-6 text-[#4a5565] tracking-[-0.3125px]">
            Nhập chẩn đoán và kê đơn thuốc
          </p>
        </div>
      </div>

      <!-- Right: Save button -->
      <button 
        class="h-9 px-3 bg-[#155dfc] text-white rounded-lg flex items-center gap-2 hover:bg-[#1447e6] transition-colors"
        @click="handleSave"
      >
        <img :src="icons.save" alt="" class="w-4 h-4" />
        <span class="font-medium text-sm leading-5 tracking-[-0.1504px]">Lưu hồ sơ</span>
      </button>
    </div>

    <!-- Patient Info Card (Blue highlight) -->
    <div class="bg-blue-50 border-2 border-[#bedbff] rounded-[14px] p-[26px] mb-6">
      <div class="flex items-start gap-6">
        <!-- Pet Image -->
        <div class="w-32 h-32 border-4 border-white rounded-[14px] shadow-lg overflow-hidden flex-shrink-0">
          <img :src="patientInfo.petImage" alt="" class="w-full h-full object-cover" />
        </div>

        <!-- Patient Details -->
        <div class="flex-1 flex flex-col gap-3">
          <!-- Pet Name & Badge -->
          <div class="flex items-center gap-3">
            <h2 class="font-bold text-2xl leading-8 text-[#101828] tracking-[0.0703px]">
              {{ patientInfo.petName }}
            </h2>
            <div class="bg-purple-50 border border-[#e9d4ff] rounded-lg px-2 py-1 flex items-center gap-2">
              <img :src="icons.userPurple" alt="" class="w-3 h-3" />
              <span class="font-medium text-xs leading-4 text-[#8200db]">{{ patientInfo.badge }}</span>
            </div>
          </div>

          <!-- Species, Breed, Age -->
          <div class="flex items-center gap-3 text-sm leading-5 text-[#364153] tracking-[-0.1504px]">
            <div class="flex gap-1">
              <span class="font-bold">Loài:</span>
              <span class="font-normal">{{ patientInfo.species }}</span>
            </div>
            <span class="text-[#99a1af]">•</span>
            <div class="flex gap-1">
              <span class="font-bold">Giống:</span>
              <span class="font-normal">{{ patientInfo.breed }}</span>
            </div>
            <span class="text-[#99a1af]">•</span>
            <div class="flex gap-1">
              <span class="font-bold">Tuổi:</span>
              <span class="font-normal">{{ patientInfo.age }}</span>
            </div>
          </div>

          <!-- Owner & Appointment Info -->
          <div class="bg-gray-50 rounded-[10px] p-4 grid grid-cols-2 gap-3">
            <!-- Owner Info -->
            <div class="flex flex-col gap-2">
              <p class="font-normal text-xs leading-4 text-[#6a7282] uppercase">Chủ nuôi</p>
              <p class="font-bold text-base leading-6 text-[#101828] tracking-[-0.3125px]">{{ patientInfo.ownerName }}</p>
              <div class="flex items-center gap-2">
                <img :src="icons.phone" alt="" class="w-4 h-4" />
                <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">{{ patientInfo.ownerPhone }}</span>
              </div>
            </div>

            <!-- Appointment Info -->
            <div class="flex flex-col gap-2">
              <p class="font-normal text-xs leading-4 text-[#6a7282] uppercase">Thông tin lịch khám</p>
              <div class="flex items-center gap-4">
                <div class="flex items-center gap-1.5">
                  <img :src="icons.calendar" alt="" class="w-4 h-4" />
                  <span class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">{{ patientInfo.appointmentDate }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                  <img :src="icons.clock" alt="" class="w-4 h-4" />
                  <span class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">{{ patientInfo.appointmentTime }}</span>
                </div>
              </div>
              <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-lg px-2 py-1 inline-flex items-center gap-2 w-fit">
                <img :src="icons.stethoscope" alt="" class="w-3 h-3" />
                <span class="font-medium text-xs leading-4 text-gray-900">{{ patientInfo.service }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content: Two Columns -->
    <div class="flex items-start justify-between gap-6">
      <!-- Left Column: Forms -->
      <div class="flex flex-col gap-6 flex-1">
        <!-- Vital Signs Card -->
        <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] p-[25px]">
          <div class="flex items-center gap-2 mb-[30px]">
            <img :src="icons.activity" alt="" class="w-5 h-5" />
            <h3 class="font-normal text-base leading-4 text-gray-900 tracking-[-0.3125px]">Chỉ số sinh tồn</h3>
          </div>
          <div class="grid grid-cols-2 gap-x-4 gap-y-4">
            <!-- Temperature -->
            <div class="flex flex-col gap-1">
              <label class="flex items-center gap-1 text-sm leading-5 text-[#364153] tracking-[-0.1504px]">
                <img :src="icons.thermometer" alt="" class="w-4 h-4" />
                Nhiệt độ (°C)
              </label>
              <input 
                v-model="vitalSigns.temperature"
                type="text"
                class="h-9 bg-[#f3f3f5] border-0 rounded-lg px-3 py-1 text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <!-- Weight -->
            <div class="flex flex-col gap-1">
              <label class="flex items-center gap-1 text-sm leading-5 text-[#364153] tracking-[-0.1504px]">
                <img :src="icons.weight" alt="" class="w-4 h-4" />
                Cân nặng (kg)
              </label>
              <input 
                v-model="vitalSigns.weight"
                type="text"
                class="h-9 bg-[#f3f3f5] border-0 rounded-lg px-3 py-1 text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <!-- Heart Rate -->
            <div class="flex flex-col gap-1">
              <label class="flex items-center gap-1 text-sm leading-5 text-[#364153] tracking-[-0.1504px]">
                <img :src="icons.heartbeat" alt="" class="w-4 h-4" />
                Nhịp tim (bpm)
              </label>
              <input 
                v-model="vitalSigns.heartRate"
                type="text"
                class="h-9 bg-[#f3f3f5] border-0 rounded-lg px-3 py-1 text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>

            <!-- Respiratory Rate -->
            <div class="flex flex-col gap-1">
              <label class="flex items-center gap-1 text-sm leading-5 text-[#364153] tracking-[-0.1504px]">
                <img :src="icons.lungs" alt="" class="w-4 h-4" />
                Nhịp thở (/phút)
              </label>
              <input 
                v-model="vitalSigns.respiratoryRate"
                type="text"
                class="h-9 bg-[#f3f3f5] border-0 rounded-lg px-3 py-1 text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div>
          </div>
        </div>

        <!-- Reason for Visit Card -->
        <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] p-[25px]">
          <div class="flex items-center gap-2 mb-[30px]">
            <img :src="icons.reason" alt="" class="w-6 h-6" />
            <h3 class="font-normal text-base leading-4 text-gray-900 tracking-[-0.3125px]">Lý do đến khám</h3>
          </div>
          <textarea 
            v-model="reasonForVisit"
            rows="3"
            class="w-full bg-[#f3f3f5] border-0 rounded-lg px-3 py-2 text-sm text-[#717182] leading-5 tracking-[-0.1504px] resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Mô tả triệu chứng của thú cưng (từ lời kể của chủ hoặc quan sát)..."
          ></textarea>
        </div>

        <!-- Symptoms Card -->
        <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] p-[25px]">
          <div class="flex items-center gap-2 mb-[30px]">
            <img :src="icons.symptoms" alt="" class="w-5 h-5" />
            <h3 class="font-normal text-base leading-4 text-gray-900 tracking-[-0.3125px]">Triệu chứng</h3>
          </div>
          <textarea 
            v-model="symptoms"
            rows="3"
            class="w-full bg-[#f3f3f5] border-0 rounded-lg px-3 py-2 text-sm text-[#717182] leading-5 tracking-[-0.1504px] resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Mô tả triệu chứng của thú cưng (từ lời kể của chủ hoặc quan sát)..."
          ></textarea>
        </div>

        <!-- Lab Results Card (Blue highlight) -->
        <div class="bg-blue-50 border-2 border-[#bedbff] rounded-[14px] p-[26px]">
          <div class="flex items-center gap-2 mb-[30px]">
            <img :src="icons.activity" alt="" class="w-5 h-5" />
            <h3 class="font-normal text-base leading-4 text-gray-900 tracking-[-0.3125px]">KẾT QUẢ CẬN LÂM SÀNG</h3>
          </div>
          <div class="bg-white border border-[#bedbff] rounded-[10px] p-3">
            <div class="flex flex-col gap-1.5 mb-3">
              <p class="font-bold text-sm leading-5 text-[#101828] tracking-[-0.1504px]">1. Chụp X-Quang Xương:</p>
              <p class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">Gãy xương đùi trái (kín)</p>
              <p class="font-normal text-xs leading-4 text-[#6a7282]">Hoàn thành lúc 10:45</p>
            </div>
            <button class="bg-white border border-[#8ec5ff] rounded-lg px-4 py-1.5 text-sm font-medium text-[#155dfc] tracking-[-0.1504px] hover:bg-blue-50 transition-colors">
              Xem ảnh (2)
            </button>
          </div>
        </div>

        <!-- Diagnosis Card (Required) -->
        <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] p-[25px]">
          <div class="flex items-center gap-2 mb-[30px]">
            <img :src="icons.diagnosis" alt="" class="w-5 h-5" />
            <h3 class="font-normal text-base leading-4 text-gray-900 tracking-[-0.3125px]">Chẩn đoán</h3>
            <span class="text-base text-[#e7000b] tracking-[-0.3125px]">*</span>
          </div>
          <textarea 
            v-model="diagnosis"
            rows="3"
            class="w-full bg-[#f3f3f5] border-0 rounded-lg px-3 py-2 text-sm text-[#717182] leading-5 tracking-[-0.1504px] resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Nhập chẩn đoán bệnh..."
          ></textarea>
        </div>

        <!-- Notes Card -->
        <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] p-[25px]">
          <div class="flex items-center gap-2 mb-[30px]">
            <h3 class="font-normal text-base leading-4 text-gray-900 tracking-[-0.3125px]">Ghi Chú</h3>
          </div>
          <textarea 
            v-model="notes"
            rows="3"
            class="w-full bg-[#f3f3f5] border-0 rounded-lg px-3 py-2 text-sm text-[#717182] leading-5 tracking-[-0.1504px] resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Mô tả phương pháp điều trị (nếu có)..."
          ></textarea>
        </div>
      </div>

      <!-- Right Column: Action Buttons -->
      <div class="flex flex-col gap-6 w-[358px]">
        <!-- Lab Test Order Button -->
        <button class="h-9 bg-white border-2 border-[#dab2ff] rounded-lg flex items-center justify-center gap-2 text-sm font-medium text-[#8200db] tracking-[-0.1504px] hover:bg-purple-50 transition-colors">
          <img :src="icons.labTest" alt="" class="w-4 h-4" />
          Chỉ định cận lâm sàng
        </button>

        <!-- Prescription Button -->
        <button class="h-9 bg-white border-2 border-[#7bf1a8] rounded-lg flex items-center justify-center gap-2 text-sm font-medium text-[#008236] tracking-[-0.1504px] hover:bg-green-50 transition-colors">
          <img :src="icons.prescription" alt="" class="w-4 h-4" />
          Đơn thuốc
        </button>

        <!-- Follow-up Appointment Button -->
        <button class="h-9 bg-white border-2 border-[#53eafd] rounded-lg flex items-center justify-center gap-2 text-sm font-medium text-[#007595] tracking-[-0.1504px] hover:bg-cyan-50 transition-colors">
          <img :src="icons.followUp" alt="" class="w-4 h-4" />
          Hẹn Tái Khám
        </button>

        <!-- Complete & Transfer Button -->
        <button class="bg-[#5a9690] text-white rounded-lg px-8 py-3 text-sm font-medium text-center tracking-[-0.1504px] hover:bg-[#4a857f] transition-colors">
          Hoàn tất & Chuyển thu ngân
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

// Icons from Figma
const icons = {
  arrowLeft: "https://www.figma.com/api/mcp/asset/76b11aab-6817-4105-94c7-1180dbbb1fb3",
  save: "https://www.figma.com/api/mcp/asset/f76bae8e-6f66-4f28-acaa-19150935c4f6",
  userPurple: "https://www.figma.com/api/mcp/asset/af4ede92-6228-4dd1-99db-eff9ed2b1d20",
  phone: "https://www.figma.com/api/mcp/asset/5a79a9a9-0485-4d94-a78b-4e4b35306ff5",
  calendar: "https://www.figma.com/api/mcp/asset/2801329b-9e9f-418d-95bb-7c96e481db4a",
  clock: "https://www.figma.com/api/mcp/asset/68ca25c2-7947-465e-af9d-0418216a9c45",
  stethoscope: "https://www.figma.com/api/mcp/asset/42eb7cf4-83ba-45b6-8e8f-0a2e139d2738",
  activity: "https://www.figma.com/api/mcp/asset/868e59e4-5a5c-47b8-a0e0-4a286cbbf945",
  thermometer: "https://www.figma.com/api/mcp/asset/0ff425ce-e518-46b7-8a11-cf3cae0a436c",
  weight: "https://www.figma.com/api/mcp/asset/65ebcc68-bd19-45bb-ad10-865dac201c71",
  heartbeat: "https://www.figma.com/api/mcp/asset/be36d78b-ae2e-4792-bd5b-d92799ae00c0",
  lungs: "https://www.figma.com/api/mcp/asset/2749b6bc-762e-4b59-913b-377fb8b0e5ec",
  reason: "https://www.figma.com/api/mcp/asset/c0305605-27e4-4f30-a91b-af51a1287fcc",
  symptoms: "https://www.figma.com/api/mcp/asset/618349e3-61b4-4047-bfd0-76286998bf8d",
  diagnosis: "https://www.figma.com/api/mcp/asset/4179807a-a764-4d16-b5e9-d873e8edd7c4",
  labTest: "https://www.figma.com/api/mcp/asset/53df81c1-f80d-4947-b736-a5349c435d8d",
  prescription: "https://www.figma.com/api/mcp/asset/6ddb03bc-f4a6-4e07-aae5-e62d607a9fa1",
  followUp: "https://www.figma.com/api/mcp/asset/2e0d530a-e641-49ef-b197-02399437f53d"
};

// Patient Information
const patientInfo = ref({
  petName: 'Lu',
  petImage: 'https://www.figma.com/api/mcp/asset/7c007591-3cd2-446c-ba1a-0313338c5edb',
  badge: 'Vãng lai',
  species: 'Mèo',
  breed: 'Anh Lông Ngắn',
  age: '2',
  ownerName: 'Đỗ Thị D',
  ownerPhone: '0901234567',
  appointmentDate: 'Hôm nay',
  appointmentTime: '09:12',
  service: 'Khám tổng quát'
});

// Vital Signs
const vitalSigns = ref({
  temperature: '38.5',
  weight: '12.5',
  heartRate: '90',
  respiratoryRate: '25'
});

// Form Data
const reasonForVisit = ref('');
const symptoms = ref('');
const diagnosis = ref('');
const notes = ref('');

// Methods
const handleBack = () => {
  router.push('/doctor/lich-kham');
};

const handleSave = () => {
  // TODO: Save examination record
  console.log('Save record');
};
</script>
