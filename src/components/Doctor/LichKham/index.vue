<template>
  <div class="flex flex-col gap-6 w-full">
    <!-- Page Header -->
    <div class="flex flex-col h-[60px]">
      <h1 class="font-medium text-2xl leading-9 text-[#101828] tracking-[0.0703px]">
        Lịch khám
      </h1>
      <p class="font-normal text-base leading-6 text-[#4a5565] tracking-[-0.3125px]">
        Quản lý lịch khám - Chỉ hiển thị ca khám được phân cho bạn
      </p>
    </div>

    <!-- Toolbar Card -->
    <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] p-4">
      <!-- Date Navigation -->
      <div class="flex items-center gap-2 h-10 mb-4">
        <button 
          class="w-[38px] h-8 bg-white border border-[rgba(0,0,0,0.1)] rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors"
          @click="previousDay"
        >
          <img :src="icons.chevronLeft" alt="" class="w-4 h-4" />
        </button>
        <div class="bg-gray-50 rounded-[10px] px-[34.6px] py-[10.5px] flex-1">
          <p class="font-normal text-base leading-6 text-[#101828] text-center tracking-[-0.3125px]">
            {{ currentDateText }}
          </p>
        </div>
        <button 
          class="w-[38px] h-8 bg-white border border-[rgba(0,0,0,0.1)] rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors"
          @click="nextDay"
        >
          <img :src="icons.chevronRight" alt="" class="w-4 h-4" />
        </button>
        <button 
          class="h-9 px-4 py-2 bg-[#5a9690] text-white font-medium text-sm leading-5 tracking-[-0.1504px] rounded-lg hover:bg-[#4a857f] transition-colors"
          @click="goToToday"
        >
          Hôm nay
        </button>
      </div>

      <!-- Status Filter Tabs -->
      <div class="flex items-center gap-4 h-9">
        <button 
          v-for="tab in statusTabs" 
          :key="tab.value"
          :class="[
            'h-9 px-4 rounded-[10px] font-normal text-sm leading-5 tracking-[-0.1504px] transition-colors',
            activeTab === tab.value 
              ? 'bg-[#155dfc] text-white' 
              : 'bg-gray-100 text-[#364153] hover:bg-gray-200'
          ]"
          @click="activeTab = tab.value"
        >
          {{ tab.label }}
          <span class="opacity-75 ml-1">({{ tab.count }})</span>
        </button>
      </div>
    </div>

    <!-- Appointments List -->
    <div class="flex flex-col gap-4">
      <!-- Appointment Card 1: Milo - Late with Note (Blue Border) -->
      <div class="bg-white border-l-4 border-[#60a5fa] border-t border-r border-b border-[rgba(0,0,0,0.1)] rounded-[14px]">
        <div class="flex items-start h-[186px]">
          <!-- Time Section -->
          <div class="flex flex-col gap-3 w-[165px] border-r border-[rgba(0,0,0,0.1)] p-6">
            <p class="font-normal text-2xl leading-8 text-[#101828] tracking-[0.0703px]">09:00</p>
            <div class="flex items-center gap-1">
              <img :src="icons.clockGray" alt="" class="w-3 h-3" />
              <span class="font-normal text-sm leading-5 text-[#6a7282] tracking-[-0.1504px]">--:--</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="bg-[#dbe7ff] rounded-lg px-[9px] py-[3px] inline-flex">
                <span class="font-medium text-xs leading-4 text-[#1447e6]">Sắp đến</span>
              </div>
            </div>
            <div class="flex items-center gap-1 bg-[#ffdbdb] rounded-lg px-[9px] py-[3px] w-fit">
              <img :src="icons.clockRed" alt="" class="w-3 h-3" />
              <span class="font-medium text-xs leading-4 text-[#fb2c36]">Trễ 30 phút</span>
            </div>
          </div>

          <!-- Pet Info Section -->
          <div class="flex-1 p-6 flex items-start gap-4">
            <div class="w-24 h-24 border-2 border-gray-200 rounded-[14px] overflow-hidden flex-shrink-0">
              <img :src="appointments[0].petImage" alt="" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-2">
                <h3 class="font-bold text-lg leading-7 text-[#101828] tracking-[-0.4395px]">{{ appointments[0].petName }}</h3>
                <span class="font-normal text-lg leading-7 text-[#101828] tracking-[-0.4395px]">({{ appointments[0].petBreed }})</span>
                <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">- {{ appointments[0].petAge }}</span>
                <div class="bg-[#dbe7ff] rounded-lg px-[9px] py-[3px] inline-flex">
                  <span class="font-medium text-xs leading-4 text-[#1447e6]">Đặt trước</span>
                </div>
              </div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">Chủ: </span>
                <span class="font-bold text-sm leading-5 text-[#364153] tracking-[-0.1504px]">{{ appointments[0].ownerName }}</span>
                <span class="font-normal text-base leading-6 text-[#99a1af] tracking-[-0.3125px]">•</span>
                <div class="flex items-center gap-1">
                  <img :src="icons.phone" alt="" class="w-3 h-3" />
                  <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">{{ appointments[0].ownerPhone }}</span>
                </div>
              </div>
              <div class="bg-blue-50 border border-[#bedbff] rounded-lg px-2 py-[3px] inline-flex mb-2">
                <span class="font-medium text-xs leading-4 text-[#1447e6]">{{ appointments[0].service }}</span>
              </div>
              <div v-if="appointments[0].note" class="bg-amber-50 border border-[#fee685] rounded-[10px] px-3 py-2">
                <div class="flex items-start gap-2">
                  <img :src="icons.infoIcon" alt="" class="w-4 h-4 flex-shrink-0 mt-0.5" />
                  <p class="font-normal text-sm leading-5 text-[#7b3306] tracking-[-0.1504px]">
                    <span class="font-bold">Ghi chú:</span> {{ appointments[0].note }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Button -->
          <div class="w-[255px] p-6 flex items-center">
            <button 
              class="w-full h-9 bg-[#155dfc] text-white font-medium text-sm leading-5 tracking-[-0.1504px] rounded-lg flex items-center justify-center gap-2 hover:bg-[#1447e6] transition-colors"
              @click="startExam"
            >
              <img :src="icons.playCircle" alt="" class="w-4 h-4" />
              BẮT ĐẦU
            </button>
          </div>
        </div>
      </div>

      <!-- Appointment Card 2: Lu - Checked In (Standard Border) -->
      <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px]">
        <div class="flex items-start h-[186px]">
          <!-- Time Section -->
          <div class="flex flex-col gap-3 w-[165px] border-r border-[rgba(0,0,0,0.1)] p-6">
            <p class="font-normal text-2xl leading-8 text-[#101828] tracking-[0.0703px]">09:12</p>
            <div class="flex items-center gap-1">
              <img :src="icons.clockPurple" alt="" class="w-3 h-3" />
              <span class="font-normal text-sm leading-5 text-[#9810fa] tracking-[-0.1504px]">+09:12</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="bg-[#d6fae1] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                <img :src="icons.checkCircle" alt="" class="w-3 h-3" />
                <span class="font-medium text-xs leading-4 text-[#00a63e]">Đã đến</span>
              </div>
            </div>
            <div class="bg-gray-100 rounded-lg px-[9px] py-[3px] inline-flex w-fit">
              <span class="font-medium text-xs leading-4 text-[#4a5565]">3 phút</span>
            </div>
          </div>

          <!-- Pet Info Section -->
          <div class="flex-1 p-6 flex items-start gap-4">
            <div class="w-24 h-24 border-2 border-gray-200 rounded-[14px] overflow-hidden flex-shrink-0">
              <img :src="appointments[1].petImage" alt="" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-2">
                <h3 class="font-bold text-lg leading-7 text-[#101828] tracking-[-0.4395px]">{{ appointments[1].petName }}</h3>
                <span class="font-normal text-lg leading-7 text-[#101828] tracking-[-0.4395px]">({{ appointments[1].petBreed }})</span>
                <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">- {{ appointments[1].petAge }}</span>
                <div class="bg-[#f2e6ff] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                  <img :src="icons.userPurple" alt="" class="w-3 h-3" />
                  <span class="font-medium text-xs leading-4 text-[#8200db]">Vãng lai</span>
                </div>
              </div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">Chủ: </span>
                <span class="font-bold text-sm leading-5 text-[#364153] tracking-[-0.1504px]">{{ appointments[1].ownerName }}</span>
                <span class="font-normal text-base leading-6 text-[#99a1af] tracking-[-0.3125px]">•</span>
                <div class="flex items-center gap-1">
                  <img :src="icons.phone" alt="" class="w-3 h-3" />
                  <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">{{ appointments[1].ownerPhone }}</span>
                </div>
              </div>
              <div class="bg-blue-50 border border-[#bedbff] rounded-lg px-2 py-[3px] inline-flex">
                <span class="font-medium text-xs leading-4 text-[#1447e6]">{{ appointments[1].service }}</span>
              </div>
              <div class="h-[52px]"></div>
            </div>
          </div>

          <!-- Action Button -->
          <div class="w-[255px] p-6 flex items-center">
            <button 
              class="w-full h-9 bg-[#155dfc] text-white font-medium text-sm leading-5 tracking-[-0.1504px] rounded-lg flex items-center justify-center gap-2 hover:bg-[#1447e6] transition-colors"
              @click="startExam"
            >
              <img :src="icons.playCircle" alt="" class="w-4 h-4" />
              BẮT ĐẦU
            </button>
          </div>
        </div>
      </div>

      <!-- Appointment Card 3: Luna - Member (Standard Border) -->
      <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px]">
        <div class="flex items-start h-[186px]">
          <!-- Time Section -->
          <div class="flex flex-col gap-3 w-[165px] border-r border-[rgba(0,0,0,0.1)] p-6">
            <p class="font-normal text-2xl leading-8 text-[#101828] tracking-[0.0703px]">09:24</p>
            <div class="flex items-center gap-1">
              <img :src="icons.clockPurple" alt="" class="w-3 h-3" />
              <span class="font-normal text-sm leading-5 text-[#9810fa] tracking-[-0.1504px]">+09:24</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="bg-[#d6fae1] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                <img :src="icons.checkCircle" alt="" class="w-3 h-3" />
                <span class="font-medium text-xs leading-4 text-[#00a63e]">Đã đến</span>
              </div>
            </div>
            <div class="bg-gray-100 rounded-lg px-[9px] py-[3px] inline-flex w-fit">
              <span class="font-medium text-xs leading-4 text-[#4a5565]">5 phút</span>
            </div>
          </div>

          <!-- Pet Info Section -->
          <div class="flex-1 p-6 flex items-start gap-4">
            <div class="w-24 h-24 border-2 border-gray-200 rounded-[14px] overflow-hidden flex-shrink-0">
              <img :src="appointments[2].petImage" alt="" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-2">
                <h3 class="font-bold text-lg leading-7 text-[#101828] tracking-[-0.4395px]">{{ appointments[2].petName }}</h3>
                <span class="font-normal text-lg leading-7 text-[#101828] tracking-[-0.4395px]">({{ appointments[2].petBreed }})</span>
                <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">- {{ appointments[2].petAge }}</span>
                <div class="bg-[#dbe7ff] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                  <img :src="icons.userBlue" alt="" class="w-3 h-3" />
                  <span class="font-medium text-xs leading-4 text-[#1447e6]">Thành Viên</span>
                </div>
              </div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">Chủ: </span>
                <span class="font-bold text-sm leading-5 text-[#364153] tracking-[-0.1504px]">{{ appointments[2].ownerName }}</span>
                <span class="font-normal text-base leading-6 text-[#99a1af] tracking-[-0.3125px]">•</span>
                <div class="flex items-center gap-1">
                  <img :src="icons.phone" alt="" class="w-3 h-3" />
                  <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">{{ appointments[2].ownerPhone }}</span>
                </div>
              </div>
              <div class="bg-blue-50 border border-[#bedbff] rounded-lg px-2 py-[3px] inline-flex">
                <span class="font-medium text-xs leading-4 text-[#1447e6]">{{ appointments[2].service }}</span>
              </div>
              <div class="h-[52px]"></div>
            </div>
          </div>

          <!-- Action Button -->
          <div class="w-[255px] p-6 flex items-center">
            <button 
              class="w-full h-9 bg-[#155dfc] text-white font-medium text-sm leading-5 tracking-[-0.1504px] rounded-lg flex items-center justify-center gap-2 hover:bg-[#1447e6] transition-colors"
              @click="startExam"
            >
              <img :src="icons.playCircle" alt="" class="w-4 h-4" />
              BẮT ĐẦU
            </button>
          </div>
        </div>
      </div>

      <!-- Appointment Card 4: Max - Future (Standard Border, Disabled) -->
      <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px]">
        <div class="flex items-start h-[186px]">
          <!-- Time Section -->
          <div class="flex flex-col gap-3 w-[165px] border-r border-[rgba(0,0,0,0.1)] p-6">
            <p class="font-normal text-2xl leading-8 text-[#101828] tracking-[0.0703px]">10:30</p>
            <div class="flex items-center gap-1">
              <img :src="icons.clockGray" alt="" class="w-3 h-3" />
              <span class="font-normal text-sm leading-5 text-[#6a7282] tracking-[-0.1504px]">--:--</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="bg-[#dbe7ff] rounded-lg px-[9px] py-[3px] inline-flex">
                <span class="font-medium text-xs leading-4 text-[#1447e6]">Sắp đến</span>
              </div>
            </div>
            <div class="bg-cyan-100 rounded-lg px-[9px] py-[3px] inline-flex w-fit">
              <span class="font-medium text-xs leading-4 text-[#0891b2]">Còn 60 phút</span>
            </div>
          </div>

          <!-- Pet Info Section -->
          <div class="flex-1 p-6 flex items-start gap-4">
            <div class="w-24 h-24 border-2 border-gray-200 rounded-[14px] overflow-hidden flex-shrink-0">
              <img :src="appointments[3].petImage" alt="" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-2">
                <h3 class="font-bold text-lg leading-7 text-[#101828] tracking-[-0.4395px]">{{ appointments[3].petName }}</h3>
                <span class="font-normal text-lg leading-7 text-[#101828] tracking-[-0.4395px]">({{ appointments[3].petBreed }})</span>
                <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">- {{ appointments[3].petAge }}</span>
                <div class="bg-[#dbe7ff] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                  <img :src="icons.calendarBadge" alt="" class="w-3 h-3" />
                  <span class="font-medium text-xs leading-4 text-[#1447e6]">Đặt trước</span>
                </div>
              </div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">Chủ: </span>
                <span class="font-bold text-sm leading-5 text-[#364153] tracking-[-0.1504px]">{{ appointments[3].ownerName }}</span>
                <span class="font-normal text-base leading-6 text-[#99a1af] tracking-[-0.3125px]">•</span>
                <div class="flex items-center gap-1">
                  <img :src="icons.phone" alt="" class="w-3 h-3" />
                  <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">{{ appointments[3].ownerPhone }}</span>
                </div>
              </div>
              <div class="bg-blue-50 border border-[#bedbff] rounded-lg px-2 py-[3px] inline-flex">
                <span class="font-medium text-xs leading-4 text-[#1447e6]">{{ appointments[3].service }}</span>
              </div>
              <div class="h-[52px]"></div>
            </div>
          </div>

          <!-- Action Button -->
          <div class="w-[255px] p-6 flex items-center">
            <button 
              class="w-full h-9 bg-gray-100 text-gray-400 font-medium text-sm leading-5 tracking-[-0.1504px] rounded-lg flex items-center justify-center gap-2 cursor-not-allowed"
              disabled
            >
              <img :src="icons.playCircle" alt="" class="w-4 h-4 opacity-40" />
              BẮT ĐẦU
            </button>
          </div>
        </div>
      </div>

      <!-- Appointment Card 5: Bella - In Progress (Orange Border, No Photo) -->
      <div class="bg-white border-l-4 border-[#fb923c] border-t border-r border-b border-[rgba(0,0,0,0.1)] rounded-[14px]">
        <div class="flex items-start h-[186px]">
          <!-- Time Section -->
          <div class="flex flex-col gap-3 w-[165px] border-r border-[rgba(0,0,0,0.1)] p-6">
            <p class="font-normal text-2xl leading-8 text-[#101828] tracking-[0.0703px]">08:18</p>
            <div class="flex items-center gap-1">
              <img :src="icons.clockPurple" alt="" class="w-3 h-3" />
              <span class="font-normal text-sm leading-5 text-[#9810fa] tracking-[-0.1504px]">+08:18</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="bg-[#d6fae1] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                <img :src="icons.checkCircle" alt="" class="w-3 h-3" />
                <span class="font-medium text-xs leading-4 text-[#00a63e]">Đã đến</span>
              </div>
            </div>
            <div class="bg-orange-100 rounded-lg px-[9px] py-[3px] inline-flex w-fit">
              <span class="font-medium text-xs leading-4 text-[#ea580c]">Đang khám</span>
            </div>
          </div>

          <!-- Pet Info Section -->
          <div class="flex-1 p-6 flex items-start gap-4">
            <div class="w-24 h-24 border-2 border-gray-200 rounded-[14px] overflow-hidden flex-shrink-0 flex items-center justify-center bg-gray-50">
              <span class="text-5xl">🐕</span>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-2">
                <h3 class="font-bold text-lg leading-7 text-[#101828] tracking-[-0.4395px]">{{ appointments[4].petName }}</h3>
                <span class="font-normal text-lg leading-7 text-[#101828] tracking-[-0.4395px]">({{ appointments[4].petBreed }})</span>
                <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">- {{ appointments[4].petAge }}</span>
                <div class="bg-[#dbe7ff] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                  <img :src="icons.userBlue" alt="" class="w-3 h-3" />
                  <span class="font-medium text-xs leading-4 text-[#1447e6]">Thành Viên</span>
                </div>
              </div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">Chủ: </span>
                <span class="font-bold text-sm leading-5 text-[#364153] tracking-[-0.1504px]">{{ appointments[4].ownerName }}</span>
                <span class="font-normal text-base leading-6 text-[#99a1af] tracking-[-0.3125px]">•</span>
                <div class="flex items-center gap-1">
                  <img :src="icons.phone" alt="" class="w-3 h-3" />
                  <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">{{ appointments[4].ownerPhone }}</span>
                </div>
              </div>
              <div class="bg-blue-50 border border-[#bedbff] rounded-lg px-2 py-[3px] inline-flex">
                <span class="font-medium text-xs leading-4 text-[#1447e6]">{{ appointments[4].service }}</span>
              </div>
              <div class="h-[52px]"></div>
            </div>
          </div>

          <!-- Action Button -->
          <div class="w-[255px] p-6 flex items-center">
            <button 
              class="w-full h-9 bg-[#f54900] text-white font-medium text-sm leading-5 tracking-[-0.1504px] rounded-lg hover:bg-[#ca3500] transition-colors"
              @click="startExam"
            >
              TIẾP TỤC
            </button>
          </div>
        </div>
      </div>

      <!-- Appointment Card 6: Meo - Completed (Standard Border) -->
      <div class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px]">
        <div class="flex items-start h-[186px]">
          <!-- Time Section -->
          <div class="flex flex-col gap-3 w-[165px] border-r border-[rgba(0,0,0,0.1)] p-6">
            <p class="font-normal text-2xl leading-8 text-[#101828] tracking-[0.0703px]">11:00</p>
            <div class="flex items-center gap-1">
              <img :src="icons.clockPurple" alt="" class="w-3 h-3" />
              <span class="font-normal text-sm leading-5 text-[#9810fa] tracking-[-0.1504px]">+10:50</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="bg-[#d6fae1] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                <img :src="icons.checkCircle" alt="" class="w-3 h-3" />
                <span class="font-medium text-xs leading-4 text-[#00a63e]">Đã đến</span>
              </div>
            </div>
            <div class="bg-green-100 rounded-lg px-[9px] py-[3px] inline-flex w-fit">
              <span class="font-medium text-xs leading-4 text-[#00a63e]">Hoàn thành</span>
            </div>
          </div>

          <!-- Pet Info Section -->
          <div class="flex-1 p-6 flex items-start gap-4">
            <div class="w-24 h-24 border-2 border-gray-200 rounded-[14px] overflow-hidden flex-shrink-0">
              <img :src="appointments[5].petImage" alt="" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-2">
                <h3 class="font-bold text-lg leading-7 text-[#101828] tracking-[-0.4395px]">{{ appointments[5].petName }}</h3>
                <span class="font-normal text-lg leading-7 text-[#101828] tracking-[-0.4395px]">({{ appointments[5].petBreed }})</span>
                <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">- {{ appointments[5].petAge }}</span>
                <div class="bg-[#dbe7ff] rounded-lg px-[9px] py-[3px] inline-flex items-center gap-1">
                  <img :src="icons.userBlue" alt="" class="w-3 h-3" />
                  <span class="font-medium text-xs leading-4 text-[#1447e6]">Thành Viên</span>
                </div>
              </div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-normal text-sm leading-5 text-[#364153] tracking-[-0.1504px]">Chủ: </span>
                <span class="font-bold text-sm leading-5 text-[#364153] tracking-[-0.1504px]">{{ appointments[5].ownerName }}</span>
                <span class="font-normal text-base leading-6 text-[#99a1af] tracking-[-0.3125px]">•</span>
                <div class="flex items-center gap-1">
                  <img :src="icons.phone" alt="" class="w-3 h-3" />
                  <span class="font-normal text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">{{ appointments[5].ownerPhone }}</span>
                </div>
              </div>
              <div class="bg-blue-50 border border-[#bedbff] rounded-lg px-2 py-[3px] inline-flex">
                <span class="font-medium text-xs leading-4 text-[#1447e6]">{{ appointments[5].service }}</span>
              </div>
              <div class="h-[52px]"></div>
            </div>
          </div>

          <!-- Action Button -->
          <div class="w-[255px] p-6 flex items-center">
            <button class="w-full h-9 bg-white border border-[rgba(0,0,0,0.1)] text-gray-700 font-medium text-sm leading-5 tracking-[-0.1504px] rounded-lg flex items-center justify-center gap-2 hover:bg-gray-50 transition-colors">
              <img :src="icons.eyeIcon" alt="" class="w-4 h-4" />
              Xem lại
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

// Icons from Figma
const icons = {
  chevronLeft: "https://www.figma.com/api/mcp/asset/dcda70b5-46a3-4c0f-a889-348b89df96b9",
  chevronRight: "https://www.figma.com/api/mcp/asset/e1aa7f82-33cb-4128-b2c5-56d7232ce76c",
  checkCircle: "https://www.figma.com/api/mcp/asset/702a1446-dc44-463a-9a81-499741bad4ca",
  clockGray: "https://www.figma.com/api/mcp/asset/2b0f3bff-0c89-4d37-8acb-6d96e8eb4b9d",
  clockPurple: "https://www.figma.com/api/mcp/asset/8f92ae18-d9e9-4c1f-9f7e-4ed2e0df5c93",
  clockRed: "https://www.figma.com/api/mcp/asset/9c4a7f3e-5b8d-4a2c-9e1f-7f8e2c3d4e5f",
  phone: "https://www.figma.com/api/mcp/asset/52ad630b-cd0d-4286-b1dd-c58339a7e5dc",
  playCircle: "https://www.figma.com/api/mcp/asset/d25d6ebf-e2f5-467d-a889-01913a6f996a",
  infoIcon: "https://www.figma.com/api/mcp/asset/3d8f9a1b-2c4e-5f6d-7e8f-9a0b1c2d3e4f",
  userPurple: "https://www.figma.com/api/mcp/asset/4e9f0a2b-3c5e-6f7d-8e9f-0a1b2c3d4e5f",
  userBlue: "https://www.figma.com/api/mcp/asset/5f0a1b2c-4d6e-7f8d-9e0f-1a2b3c4d5e6f",
  calendarBadge: "https://www.figma.com/api/mcp/asset/6f1a2b3c-5d7e-8f9d-0e1f-2a3b4c5d6e7f",
  eyeIcon: "https://www.figma.com/api/mcp/asset/a872ff23-fc92-4bde-8371-dd6a95d301e8"
};

// Current date
const currentDate = ref(new Date());
const currentDateText = computed(() => {
  const days = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
  const day = days[currentDate.value.getDay()];
  const date = currentDate.value.getDate().toString().padStart(2, '0');
  const month = (currentDate.value.getMonth() + 1).toString().padStart(2, '0');
  const year = currentDate.value.getFullYear();
  return `${day}, ${date}/${month}/${year}`;
});

// Active tab
const activeTab = ref('all');

// Status tabs
const statusTabs = ref([
  { label: 'Tất cả', value: 'all', count: 6 },
  { label: 'Đang chờ', value: 'waiting', count: 4 },
  { label: 'Đang khám', value: 'examining', count: 1 },
  { label: 'Hoàn thành', value: 'completed', count: 1 }
]);

// Appointments data
const appointments = ref([
  {
    time: '09:00',
    checkInTime: null,
    status: 'waiting',
    late: true,
    lateMinutes: 30,
    petName: 'Milo',
    petBreed: 'Chó Golden Retriever',
    petAge: '2 tuổi',
    petImage: 'https://www.figma.com/api/mcp/asset/d5407383-5007-4d71-b56f-dc25ff3edbad',
    ownerName: 'Nguyễn Văn A',
    ownerPhone: '0901234567',
    service: 'Khám Tổng Quát',
    badge: 'Đặt trước',
    note: 'Bé hơi dữ, cẩn thận khi tiếp cận'
  },
  {
    time: '09:12',
    checkInTime: '09:12',
    status: 'waiting',
    arrived: true,
    waitMinutes: 3,
    petName: 'Lu',
    petBreed: 'Mèo Anh Lông Ngắn',
    petAge: '2 tuổi',
    petImage: 'https://www.figma.com/api/mcp/asset/85b46eea-5637-456e-a38e-14d4280cf26a',
    ownerName: 'Đỗ Thị D',
    ownerPhone: '0912345678',
    service: 'Khám Tổng Quát',
    badge: 'Vãng lai'
  },
  {
    time: '09:24',
    checkInTime: '09:24',
    status: 'waiting',
    arrived: true,
    waitMinutes: 5,
    petName: 'Luna',
    petBreed: 'Mèo Ba Tư',
    petAge: '2 tuổi',
    petImage: 'https://www.figma.com/api/mcp/asset/90036aa7-c05d-4d2c-9626-b1121e0039f5',
    ownerName: 'Trần Thị B',
    ownerPhone: '0912345678',
    service: 'Tiêm Phòng Vắc-Xin',
    badge: 'Thành Viên'
  },
  {
    time: '10:30',
    checkInTime: null,
    status: 'waiting',
    future: true,
    futureMinutes: 60,
    petName: 'Max',
    petBreed: 'Chó Husky',
    petAge: '3 tuổi',
    petImage: 'https://www.figma.com/api/mcp/asset/ec0c8147-a467-46fc-a61d-0006c6610147',
    ownerName: 'Lê Văn C',
    ownerPhone: '0923456789',
    service: 'Khám Tổng Quát',
    badge: 'Đặt trước'
  },
  {
    time: '08:18',
    checkInTime: '08:18',
    status: 'examining',
    arrived: true,
    petName: 'Bella',
    petBreed: 'Chó Poodle',
    petAge: '4 tuổi',
    petImage: null,
    ownerName: 'Phạm Thị D',
    ownerPhone: '0934567890',
    service: 'Khám Tổng Quát',
    badge: 'Thành Viên'
  },
  {
    time: '11:00',
    checkInTime: '10:50',
    status: 'completed',
    arrived: true,
    petName: 'Meo',
    petBreed: 'Mèo Anh Lông Dài',
    petAge: '1 tuổi',
    petImage: 'https://www.figma.com/api/mcp/asset/3a2b1c0d-4e5f-6a7b-8c9d-0e1f2a3b4c5d',
    ownerName: 'Nguyễn Thị F',
    ownerPhone: '0956789012',
    service: 'Khám Da Liễu',
    badge: 'Thành Viên'
  }
]);

// Methods
const previousDay = () => {
  currentDate.value = new Date(currentDate.value.setDate(currentDate.value.getDate() - 1));
};

const nextDay = () => {
  currentDate.value = new Date(currentDate.value.setDate(currentDate.value.getDate() + 1));
};

const goToToday = () => {
  currentDate.value = new Date();
};

const startExam = () => {
  router.push('/doctor/lich-kham/phieu-kham');
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap');

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}
</style>
