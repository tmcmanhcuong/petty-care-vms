<template>
  <div class="flex flex-col gap-6 size-full">
    <!-- Header Section -->
    <div class="flex flex-col h-[105px]">
      <!-- Title -->
      <h1
        class="text-base font-normal text-[#101828] leading-6 tracking-[-0.3125px]"
        style="font-family: 'Nunito Sans', sans-serif"
      >
        Lịch làm việc
      </h1>
      <!-- Subtitle -->
      <p
        class="text-base font-normal text-[#4a5565] leading-6 tracking-[-0.3125px]"
        style="font-family: 'Inter', sans-serif"
      >
        Quản lý lịch trực và đăng ký ca làm việc
      </p>
      <!-- Tabs -->
      <div class="border-b border-gray-200 h-[41px] relative mt-auto">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="[
            'absolute top-0 h-10 px-4 pt-2 pb-0 flex items-center gap-2',
            tab.id === activeTab ? 'text-[#155dfc]' : 'text-[#4a5565]',
          ]"
          :style="{ left: tab.left }"
        >
          <img :src="icons[tab.icon]" alt="" class="w-4 h-4" />
          <span
            class="text-base font-normal leading-6 tracking-[-0.3125px]"
            style="font-family: 'Inter', sans-serif"
          >
            {{ tab.label }}
          </span>
          <div
            v-if="tab.id === activeTab"
            class="absolute left-0 bottom-[-1px] w-full h-0.5 bg-[#155dfc]"
          />
        </button>
      </div>
    </div>

    <!-- My Schedule Card -->
    <div
      v-if="activeTab === 'my-schedule'"
      class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] p-px h-[717px]"
    >
      <!-- Header with gradient background -->
      <div
        class="bg-gradient-to-r from-[#f0fdfa] to-[#f0fdf4] h-[110px] px-6 pt-6 pb-1.5 flex flex-col gap-4"
      >
        <!-- Week Navigation -->
        <div class="flex items-center justify-between">
          <button
            @click="goToPreviousWeek"
            class="bg-white border border-[rgba(0,0,0,0.1)] rounded-lg h-8 px-3 flex items-center gap-2"
          >
            <img :src="icons.chevronLeft" alt="" class="w-4 h-4" />
            <span
              class="text-sm font-medium text-neutral-950 leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Tuần trước
            </span>
          </button>

          <div class="flex items-center gap-2">
            <img :src="icons.calendar" alt="" class="w-5 h-5" />
            <span
              class="text-base font-normal text-neutral-950 leading-4 tracking-[-0.3125px]"
              style="font-family: 'Inter', sans-serif"
            >
              Tuần {{ weekNumber }} ({{ weekRange }})
            </span>
          </div>

          <button
            @click="goToNextWeek"
            class="bg-white border border-[rgba(0,0,0,0.1)] rounded-lg h-8 px-3 flex items-center gap-2"
          >
            <span
              class="text-sm font-medium text-neutral-950 leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Tuần sau
            </span>
            <img :src="icons.chevronRight" alt="" class="w-4 h-4" />
          </button>
        </div>

        <!-- Status Info & View Toggle -->
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
              <span
                class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                Ca tuần này:
              </span>
              <span
                class="text-sm font-normal text-[#009689] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                {{ weekShifts }}
              </span>
            </div>
            <div class="w-px h-4 bg-[#d1d5dc]" />
            <div class="flex items-center gap-2">
              <span
                class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                Tổng giờ làm:
              </span>
              <span
                class="text-sm font-normal text-[#009689] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                {{ totalHours }}h
              </span>
            </div>
          </div>

          <!-- View Toggle -->
          <div class="flex items-center gap-2">
            <button
              @click="viewMode = 'week'"
              :class="[
                'h-8 px-4 rounded-lg flex items-center gap-2',
                viewMode === 'week'
                  ? 'bg-[#030213] text-white'
                  : 'bg-white border border-[rgba(0,0,0,0.1)] text-neutral-950',
              ]"
            >
              <img
                :src="
                  viewMode === 'week'
                    ? icons.calendarWhite
                    : icons.calendarBlack
                "
                alt=""
                class="w-4 h-4"
              />
              <span
                class="text-sm font-medium leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                Lịch Tuần
              </span>
            </button>
            <button
              @click="viewMode = 'list'"
              :class="[
                'h-8 px-4 rounded-lg flex items-center gap-2',
                viewMode === 'list'
                  ? 'bg-[#030213] text-white'
                  : 'bg-white border border-[rgba(0,0,0,0.1)] text-neutral-950',
              ]"
            >
              <img
                :src="viewMode === 'list' ? icons.listWhite : icons.listBlack"
                alt=""
                class="w-4 h-4"
              />
              <span
                class="text-sm font-medium leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                Danh sách
              </span>
            </button>
          </div>
        </div>
      </div>

      <!-- Calendar Table -->
      <div class="px-6 py-6 flex flex-col gap-6">
        <!-- Loading State -->
        <div v-if="loading" class="flex items-center justify-center h-64">
          <div
            class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#155dfc]"
          ></div>
        </div>

        <div v-else class="overflow-auto">
          <table class="w-full border-collapse">
            <thead>
              <tr>
                <th
                  class="bg-gray-50 border border-[#d1d5dc] h-[61px] px-2 text-center text-sm font-bold text-[#364153] tracking-[-0.1504px]"
                  style="font-family: 'Inter', sans-serif; width: 112px"
                >
                  Giờ / Ngày
                </th>
                <th
                  v-for="day in calendarDays"
                  :key="day.label"
                  class="bg-gray-50 border border-[#d1d5dc] h-[61px] px-2 text-center"
                  :style="{ width: day.width }"
                >
                  <div class="flex flex-col items-center justify-center gap-1">
                    <span
                      class="text-sm font-bold text-[#101828] leading-5 tracking-[-0.1504px]"
                      style="font-family: 'Inter', sans-serif"
                    >
                      {{ day.label }}
                    </span>
                    <span
                      class="text-xs font-bold text-[#6a7282] leading-4"
                      style="font-family: 'Inter', sans-serif"
                    >
                      {{ day.date }}
                    </span>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="timeSlot in timeSlots" :key="timeSlot.name">
                <td
                  class="bg-gray-50 border border-[#d1d5dc] h-[117px] text-center"
                >
                  <div class="flex flex-col items-center justify-center gap-1">
                    <span
                      class="text-sm font-normal text-[#101828] leading-5 tracking-[-0.1504px]"
                      style="font-family: 'Inter', sans-serif"
                    >
                      {{ timeSlot.name }}
                    </span>
                    <span
                      class="text-xs font-normal text-[#6a7282] leading-4"
                      style="font-family: 'Inter', sans-serif"
                    >
                      {{ timeSlot.time }}
                    </span>
                  </div>
                </td>
                <td
                  v-for="(daySchedule, dayIndex) in timeSlot.schedule"
                  :key="dayIndex"
                  class="border border-[#d1d5dc] h-[117px] p-2"
                >
                  <div
                    v-if="daySchedule"
                    :class="[
                      'h-[100px] border-2 rounded-[10px] p-3.5 flex flex-col justify-between cursor-pointer hover:shadow-md transition-shadow',
                      getScheduleCellClass(daySchedule.status),
                      daySchedule.status === 'ongoing' ? 'animate-pulse' : '',
                    ]"
                    @click="handleShiftClick(daySchedule, dayIndex, timeSlot)"
                  >
                    <div class="flex items-center gap-1">
                      <img :src="icons.mapPin" alt="" class="w-3 h-3" />
                      <span
                        class="text-xs font-normal text-[#364153] leading-4 truncate"
                        style="font-family: 'Inter', sans-serif"
                      >
                        {{ daySchedule.room }}
                      </span>
                    </div>
                    <div
                      :class="[
                        'h-[22px] px-2 py-0.5 rounded-lg flex items-center gap-1 w-fit',
                        daySchedule.status === 'upcoming'
                          ? 'bg-green-100'
                          : 'bg-[#ffedd4]',
                      ]"
                    >
                      <img
                        :src="
                          daySchedule.status === 'upcoming'
                            ? icons.usersGreen
                            : icons.usersOrange
                        "
                        alt=""
                        class="w-3 h-3"
                      />
                      <span
                        :class="[
                          'text-xs font-medium leading-4',
                          daySchedule.status === 'upcoming'
                            ? 'text-[#008236]'
                            : 'text-[#ca3500]',
                        ]"
                        style="font-family: 'Inter', sans-serif"
                      >
                        {{ daySchedule.patients }} khách
                      </span>
                    </div>
                  </div>
                  <div v-else class="bg-gray-50 h-[100px] rounded-[10px]" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Legend -->
        <div class="bg-gray-50 rounded-[10px] h-24 px-4 py-4">
          <p
            class="text-sm font-bold text-[#364153] leading-5 tracking-[-0.1504px] mb-3"
            style="font-family: 'Inter', sans-serif"
          >
            Chú thích:
          </p>
          <div class="flex items-center gap-[351.66px]">
            <div
              v-for="calendarLegend in calendarLegends"
              :key="calendarLegend.label"
              class="flex items-center gap-2"
            >
              <div
                :class="['w-8 h-8 border-2 rounded', calendarLegend.class]"
              />
              <span
                class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                {{ calendarLegend.label }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Schedule Registration Card -->
    <div
      v-else
      class="bg-white border border-[rgba(0,0,0,0.1)] rounded-[14px] p-px h-[767px]"
    >
      <!-- Header with gradient background -->
      <div
        class="bg-gradient-to-r from-[#eff6ff] to-[#f0fdfa] h-[104px] px-6 pt-6 pb-1.5 flex flex-col gap-4"
      >
        <!-- Week Navigation -->
        <div class="flex items-center justify-between">
          <button
            @click="goToPreviousWeek"
            class="bg-white border border-[rgba(0,0,0,0.1)] rounded-lg h-8 px-3 flex items-center gap-2"
          >
            <img :src="icons.chevronLeft" alt="" class="w-4 h-4" />
            <span
              class="text-sm font-medium text-neutral-950 leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Tuần trước
            </span>
          </button>

          <div class="flex items-center gap-2">
            <img :src="icons.calendar" alt="" class="w-5 h-5" />
            <span
              class="text-base font-normal text-neutral-950 leading-4 tracking-[-0.3125px]"
              style="font-family: 'Inter', sans-serif"
            >
              Tuần {{ weekNumber }} ({{ weekRange }})
            </span>
          </div>

          <button
            @click="goToNextWeek"
            class="bg-white border border-[rgba(0,0,0,0.1)] rounded-lg h-8 px-3 flex items-center gap-2"
          >
            <span
              class="text-sm font-medium text-neutral-950 leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Tuần sau
            </span>
            <img :src="icons.chevronRight" alt="" class="w-4 h-4" />
          </button>
        </div>

        <!-- Status Info -->
        <div class="flex items-center justify-between">
          <div
            class="bg-[#ffedd4] border-0 rounded-lg h-[26px] px-3 flex items-center gap-2"
          >
            <img :src="icons.alertCircle" alt="" class="w-3 h-3" />
            <span
              class="text-xs font-medium text-[#ca3500] leading-4"
              style="font-family: 'Inter', sans-serif"
            >
              ⚠️ Hạn đăng ký: Thứ 6, 17:00
            </span>
          </div>

          <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
              <span
                class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                Đã đăng ký:
              </span>
              <span
                class="text-sm font-normal text-[#155dfc] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                {{ registeredShifts }} ca
              </span>
            </div>
            <div class="w-px h-4 bg-[#d1d5dc]" />
            <div class="flex items-center gap-2">
              <span
                class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                Yêu cầu tối thiểu:
              </span>
              <span
                class="text-sm font-normal text-[#f54900] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                {{ minRequirement }} ca/tuần
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Schedule Table -->
      <div class="px-6 py-6">
        <div class="overflow-auto">
          <table class="w-full border-collapse">
            <thead>
              <tr>
                <th
                  class="bg-gray-50 border border-[#d1d5dc] h-[45px] px-2 text-center text-sm font-bold text-[#364153] tracking-[-0.1504px]"
                  style="font-family: 'Inter', sans-serif; width: 128px"
                >
                  Ca Trực
                </th>
                <th
                  v-for="day in weekDays"
                  :key="day"
                  class="bg-gray-50 border border-[#d1d5dc] h-[45px] px-2 text-center text-sm font-bold text-[#101828] tracking-[-0.1504px]"
                  style="font-family: 'Inter', sans-serif"
                >
                  {{ day }}
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="shift in shifts" :key="shift.id">
                <td
                  class="bg-gray-50 border border-[#d1d5dc] h-[97px] text-center"
                >
                  <div class="flex flex-col items-center justify-center gap-1">
                    <span
                      class="text-sm font-normal text-[#101828] leading-5 tracking-[-0.1504px]"
                      style="font-family: 'Inter', sans-serif"
                    >
                      {{ shift.name }}
                    </span>
                    <span
                      class="text-xs font-normal text-[#6a7282] leading-4"
                      style="font-family: 'Inter', sans-serif"
                    >
                      {{ shift.time }}
                    </span>
                  </div>
                </td>
                <td
                  v-for="(status, dayIndex) in shift.days"
                  :key="dayIndex"
                  class="border border-[#d1d5dc] h-[97px] p-0.5"
                >
                  <div
                    :class="[
                      'flex flex-col items-center justify-center h-full border-2 cursor-pointer',
                      status === 'selected'
                        ? 'bg-blue-100 border-[#51a2ff]'
                        : '',
                      status === 'approved'
                        ? 'bg-green-100 border-[#00c950]'
                        : '',
                      status === 'full'
                        ? 'bg-gray-200 border-[#99a1af]'
                        : 'bg-white border-gray-200',
                    ]"
                    @click="toggleShift(shift.id, dayIndex, status)"
                  >
                    <img
                      v-if="status === 'selected'"
                      :src="icons.checkCircleBlue"
                      alt=""
                      class="w-6 h-6"
                    />
                    <img
                      v-else-if="status === 'approved'"
                      :src="icons.checkCircleGreen"
                      alt=""
                      class="w-6 h-6"
                    />
                    <img
                      v-else-if="status === 'full'"
                      :src="icons.lockIcon"
                      alt=""
                      class="w-6 h-6"
                    />
                    <img
                      v-else
                      :src="icons.plusCircle"
                      alt=""
                      class="w-6 h-6"
                    />
                    <span
                      v-if="status === 'approved'"
                      class="text-xs font-normal text-[#016630] leading-4 mt-1"
                      style="font-family: 'Inter', sans-serif"
                    >
                      Đã duyệt
                    </span>
                    <span
                      v-if="status === 'full'"
                      class="text-xs font-normal text-[#364153] leading-4 mt-1"
                      style="font-family: 'Inter', sans-serif"
                    >
                      Full
                    </span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Legend -->
        <div class="bg-gray-50 rounded-[10px] h-24 px-4 py-4 mt-6">
          <p
            class="text-sm font-bold text-[#364153] leading-5 tracking-[-0.1504px] mb-3"
            style="font-family: 'Inter', sans-serif"
          >
            Chú thích:
          </p>
          <div class="grid grid-cols-4 gap-4">
            <div
              v-for="legend in legends"
              :key="legend.label"
              class="flex items-center gap-2"
            >
              <div
                :class="[
                  'w-8 h-8 border-2 rounded flex items-center justify-center',
                  legend.class,
                ]"
              >
                <img :src="icons[legend.icon]" alt="" class="w-4 h-4" />
              </div>
              <span
                class="text-sm font-normal text-[#4a5565] leading-5 tracking-[-0.1504px]"
                style="font-family: 'Inter', sans-serif"
              >
                {{ legend.label }}
              </span>
            </div>
          </div>
        </div>

        <!-- Summary -->
        <div
          class="bg-blue-50 border border-[#bedbff] rounded-[10px] h-14 px-4 py-4 mt-4 flex items-center justify-between"
        >
          <div class="flex items-center gap-2">
            <span
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Tổng cộng đã chọn:
            </span>
            <span
              class="text-sm font-normal text-[#1447e6] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              {{ newShiftsCount }} ca mới
            </span>
            <span
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              +
            </span>
            <span
              class="text-sm font-normal text-[#008236] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              {{ approvedShiftsCount }} ca đã duyệt
            </span>
            <span
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              =
            </span>
            <span
              class="text-sm font-bold text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              {{ totalShiftsCount }} ca
            </span>
          </div>

          <div
            class="bg-green-100 border-0 rounded-lg h-[22px] px-2.5 py-0.5 flex items-center"
          >
            <span
              class="text-xs font-medium text-[#008236]"
              style="font-family: 'Inter', sans-serif"
            >
              ✓ Đủ yêu cầu
            </span>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-4">
          <button
            class="bg-white border border-[rgba(0,0,0,0.1)] rounded-lg h-9 px-4 flex items-center gap-2"
          >
            <img :src="icons.save" alt="" class="w-4 h-4" />
            <span
              class="text-sm font-medium text-neutral-950 leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Lưu nháp
            </span>
          </button>
          <button
            class="bg-[#155dfc] rounded-lg h-9 px-4 flex items-center gap-2"
          >
            <img :src="icons.send" alt="" class="w-4 h-4" />
            <span
              class="text-sm font-medium text-white leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              🚀 Gửi đăng ký
            </span>
          </button>
        </div>
      </div>
    </div>

    <!-- Important Notes Card -->
    <div
      v-if="activeTab === 'my-schedule'"
      class="border border-[#b9f8cf] rounded-[14px] px-6 py-6 h-[174px]"
    >
      <div class="flex gap-4">
        <div
          class="bg-green-100 rounded-[10px] w-10 h-10 flex items-center justify-center shrink-0"
        >
          <img :src="icons.lightbulb" alt="" class="w-5 h-5" />
        </div>
        <div>
          <p
            class="text-base font-bold text-[#364153] leading-6 tracking-[-0.3125px] mb-2"
            style="font-family: 'Inter', sans-serif"
          >
            💡 Hướng dẫn sử dụng:
          </p>
          <ul class="flex flex-col gap-1 pl-2">
            <li
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              <span class="font-bold">Bấm vào ô ca trực</span> để xem chi tiết
              danh sách bệnh nhân.
            </li>
            <li
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Ca <span class="font-bold text-[#ca3500]">Đang diễn ra</span> sẽ
              nhấp nháy để bạn dễ nhận biết.
            </li>
            <li
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Nếu cần nghỉ đột xuất, vào chi tiết ca và bấm
              <span class="font-bold">"Xin nghỉ"</span>.
            </li>
            <li
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Lịch này là <span class="font-bold">lịch chính thức</span> đã được
              Admin duyệt.
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Important Notes Card for Registration -->
    <div
      v-else
      class="border border-[#96f7e4] rounded-[14px] px-6 py-6 h-[174px]"
    >
      <div class="flex gap-4">
        <div
          class="bg-[#cbfbf1] rounded-[10px] w-10 h-10 flex items-center justify-center shrink-0"
        >
          <img :src="icons.infoCircle" alt="" class="w-5 h-5" />
        </div>
        <div>
          <p
            class="text-base font-bold text-[#364153] leading-6 tracking-[-0.3125px] mb-2"
            style="font-family: 'Inter', sans-serif"
          >
            📌 Lưu ý quan trọng:
          </p>
          <ul class="flex flex-col gap-1 pl-2">
            <li
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Vui lòng đăng ký
              <span class="font-bold">trước Thứ 6, 17:00</span> hàng tuần.
            </li>
            <li
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Các ca
              <span class="font-bold text-[#008236]">Đã duyệt</span> không thể
              thay đổi.
            </li>
            <li
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Các ca <span class="font-bold">Đã kín</span> là ca đã đủ bác sĩ
              đăng ký.
            </li>
            <li
              class="text-sm font-normal text-[#364153] leading-5 tracking-[-0.1504px]"
              style="font-family: 'Inter', sans-serif"
            >
              Sau khi gửi đăng ký, Admin sẽ phê duyệt trong vòng
              <span class="font-bold">24 giờ</span>.
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Detail Modal -->
  <div
    v-if="showDetailModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="closeModal"
  >
    <div
      class="bg-white rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl"
    >
      <!-- Modal Header -->
      <div
        class="bg-gradient-to-r from-[#f0fdfa] to-[#f0fdf4] px-6 py-4 flex items-center justify-between border-b"
      >
        <div>
          <h2
            class="text-xl font-bold text-[#101828]"
            style="font-family: 'Nunito Sans', sans-serif"
          >
            Chi tiết ca làm việc
          </h2>
          <p
            class="text-sm text-[#4a5565]"
            style="font-family: 'Inter', sans-serif"
          >
            {{ selectedShift?.timeSlot }} ({{ selectedShift?.timeRange }})
          </p>
        </div>
        <button
          @click="closeModal"
          class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors"
        >
          <span class="text-2xl text-gray-500">×</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="px-6 py-6" v-if="selectedShift">
        <!-- Shift Info -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p
                class="text-sm text-[#6a7282] mb-1"
                style="font-family: 'Inter', sans-serif"
              >
                Địa điểm
              </p>
              <p
                class="text-base font-semibold text-[#101828]"
                style="font-family: 'Inter', sans-serif"
              >
                {{ selectedShift.room }}
              </p>
            </div>
            <div>
              <p
                class="text-sm text-[#6a7282] mb-1"
                style="font-family: 'Inter', sans-serif"
              >
                Số khách hẹn
              </p>
              <p
                class="text-base font-semibold text-[#101828]"
                style="font-family: 'Inter', sans-serif"
              >
                {{ selectedShift.patients }} khách
              </p>
            </div>
            <div>
              <p
                class="text-sm text-[#6a7282] mb-1"
                style="font-family: 'Inter', sans-serif"
              >
                Trạng thái
              </p>
              <span
                :class="[
                  'inline-block px-3 py-1 rounded-full text-sm font-medium',
                  selectedShift.status === 'upcoming'
                    ? 'bg-green-100 text-[#008236]'
                    : '',
                  selectedShift.status === 'ongoing'
                    ? 'bg-orange-100 text-[#ca3500]'
                    : '',
                  selectedShift.status === 'past'
                    ? 'bg-gray-100 text-[#6a7282]'
                    : '',
                ]"
                style="font-family: 'Inter', sans-serif"
              >
                {{
                  selectedShift.status === "upcoming"
                    ? "⏰ Sắp tới"
                    : selectedShift.status === "ongoing"
                    ? "🔄 Đang diễn ra"
                    : "✓ Đã hoàn thành"
                }}
              </span>
            </div>
          </div>
        </div>

        <!-- Appointments List (if available) -->
        <div
          v-if="
            selectedShift.appointments && selectedShift.appointments.length > 0
          "
        >
          <h3
            class="text-base font-bold text-[#364153] mb-3"
            style="font-family: 'Inter', sans-serif"
          >
            Danh sách bệnh nhân
          </h3>
          <div class="space-y-2">
            <div
              v-for="(appointment, index) in selectedShift.appointments"
              :key="index"
              class="bg-white border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow"
            >
              <div class="flex items-center justify-between">
                <div class="flex-1">
                  <p
                    class="font-semibold text-[#101828]"
                    style="font-family: 'Inter', sans-serif"
                  >
                    {{ appointment.khach_hang }}
                  </p>
                  <p
                    class="text-sm text-[#6a7282]"
                    style="font-family: 'Inter', sans-serif"
                  >
                    Thú cưng: {{ appointment.thu_cung }}
                  </p>
                  <p
                    class="text-sm text-[#6a7282]"
                    style="font-family: 'Inter', sans-serif"
                  >
                    Dịch vụ: {{ appointment.dich_vu }}
                  </p>
                </div>
                <div class="text-right">
                  <p
                    class="text-sm font-medium text-[#155dfc]"
                    style="font-family: 'Inter', sans-serif"
                  >
                    {{ appointment.ngay_gio }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- No Appointments -->
        <div v-else class="text-center py-8">
          <img
            :src="icons.calendarBlack"
            alt=""
            class="w-16 h-16 mx-auto mb-3 opacity-20"
          />
          <p
            class="text-sm text-[#6a7282]"
            style="font-family: 'Inter', sans-serif"
          >
            Chưa có lịch hẹn nào trong ca này
          </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t">
          <button
            @click="closeModal"
            class="bg-gray-100 hover:bg-gray-200 rounded-lg h-10 px-6 flex items-center gap-2 transition-colors"
          >
            <span
              class="text-sm font-medium text-[#364153]"
              style="font-family: 'Inter', sans-serif"
            >
              Đóng
            </span>
          </button>
          <button
            v-if="selectedShift.status === 'upcoming'"
            class="bg-red-500 hover:bg-red-600 rounded-lg h-10 px-6 flex items-center gap-2 transition-colors"
          >
            <span
              class="text-sm font-medium text-white"
              style="font-family: 'Inter', sans-serif"
            >
              🚫 Xin nghỉ ca này
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { getUser } from "@/utils/auth";
import { showSuccessToast, showErrorToast } from "@/utils/toast";
import {
  getMySchedule,
  getMyTodaySchedule,
} from "@/services/lichLamViecService";

const activeTab = ref("my-schedule");
const loading = ref(false);
const currentUser = ref(null);

const tabs = [
  {
    id: "register",
    label: "Đăng ký ca trực",
    icon: "clipboardCheck",
    left: "0px",
  },
  {
    id: "my-schedule",
    label: "Lịch của tôi",
    icon: "calendarUser",
    left: "178.15px",
  },
];

// Date management
const currentDate = ref(new Date());
const selectedDate = ref(new Date());

const weekNumber = ref(49);
const weekRange = ref("01/12 - 07/12");
const registeredShifts = ref(5);
const minRequirement = ref(4);
const newShiftsCount = ref(4);
const approvedShiftsCount = ref(1);
const weekShifts = ref(5);
const totalHours = ref(19);
const viewMode = ref("week");

// API Data
const scheduleData = ref(null);
const todayScheduleData = ref(null);

// Modal state
const showDetailModal = ref(false);
const selectedShift = ref(null);

const totalShiftsCount = computed(
  () => newShiftsCount.value + approvedShiftsCount.value
);

// Computed properties for date calculations
const startOfWeek = computed(() => {
  const date = new Date(currentDate.value);
  const day = date.getDay();
  const diff = date.getDate() - day + (day === 0 ? -6 : 1); // Monday as first day
  return new Date(date.setDate(diff));
});

const endOfWeek = computed(() => {
  const date = new Date(startOfWeek.value);
  date.setDate(date.getDate() + 6);
  return date;
});

const formatDate = (date) => {
  return date.toISOString().split("T")[0];
};

const formatDateDisplay = (date) => {
  const d = new Date(date);
  const day = String(d.getDate()).padStart(2, "0");
  const month = String(d.getMonth() + 1).padStart(2, "0");
  return `${day}/${month}`;
};

// Update week range display
const updateWeekRange = () => {
  const start = formatDateDisplay(startOfWeek.value);
  const end = formatDateDisplay(endOfWeek.value);
  weekRange.value = `${start} - ${end}`;

  // Calculate week number
  const onejan = new Date(currentDate.value.getFullYear(), 0, 1);
  const week = Math.ceil(
    ((currentDate.value - onejan) / 86400000 + onejan.getDay() + 1) / 7
  );
  weekNumber.value = week;
};

// Navigation functions
const goToPreviousWeek = () => {
  const date = new Date(currentDate.value);
  date.setDate(date.getDate() - 7);
  currentDate.value = date;
  updateWeekRange();
  fetchScheduleData();
};

const goToNextWeek = () => {
  const date = new Date(currentDate.value);
  date.setDate(date.getDate() + 7);
  currentDate.value = date;
  updateWeekRange();
  fetchScheduleData();
};

// Fetch schedule data from API
const fetchScheduleData = async () => {
  loading.value = true;
  try {
    const data = await getMySchedule(
      formatDate(startOfWeek.value),
      formatDate(endOfWeek.value)
    );

    if (data.status) {
      scheduleData.value = data.data;
      updateCalendarData(data.data);

      // Update employee info
      if (data.data.nhan_vien) {
        currentUser.value = {
          ...currentUser.value,
          ...data.data.nhan_vien,
        };
      }
    }
  } catch (error) {
    console.error("Error fetching schedule:", error);
    showErrorToast(
      "Lỗi",
      error.response?.data?.message || "Không thể tải lịch làm việc"
    );
  } finally {
    loading.value = false;
  }
};

// Fetch today's schedule
const fetchTodaySchedule = async () => {
  loading.value = true;
  try {
    const data = await getMyTodaySchedule();

    if (data.status) {
      todayScheduleData.value = data.data;
      // You can display today's data in a special view if needed
    }
  } catch (error) {
    console.error("Error fetching today schedule:", error);
    showErrorToast("Lỗi", "Không thể tải lịch hôm nay");
  } finally {
    loading.value = false;
  }
};

// Update calendar data from API response
const updateCalendarData = (data) => {
  if (!data || !data.schedule) return;

  // Reset time slots
  timeSlots.value.forEach((slot) => {
    slot.schedule = [null, null, null, null, null, null, null];
  });

  // Map schedule data to calendar
  data.schedule.forEach((daySchedule) => {
    const date = new Date(daySchedule.date);
    const dayOfWeek = date.getDay();
    const dayIndex = dayOfWeek === 0 ? 6 : dayOfWeek - 1; // Monday = 0, Sunday = 6

    // Process work shifts
    daySchedule.lich_lam_viec.forEach((shift) => {
      const slotIndex = getTimeSlotIndex(shift.thoi_gian_truc);
      if (slotIndex !== -1 && timeSlots.value[slotIndex]) {
        const appointmentCount = daySchedule.lich_hen
          ? daySchedule.lich_hen.length
          : 0;
        timeSlots.value[slotIndex].schedule[dayIndex] = {
          id: shift.id,
          room: formatRoomName(shift.thoi_gian_truc, shift.ghi_chu),
          patients: appointmentCount,
          status: getShiftStatus(daySchedule.date, shift.thoi_gian_truc),
          appointments: daySchedule.lich_hen || [],
          date: daySchedule.date,
          shift: shift.thoi_gian_truc,
        };
      }
    });
  });

  // Update statistics
  if (data.statistics) {
    weekShifts.value = data.statistics.total_work_days || 0;

    // Calculate total hours based on shift type
    let totalHoursCalc = 0;
    data.schedule.forEach((daySchedule) => {
      daySchedule.lich_lam_viec.forEach((shift) => {
        // ca_sang: 4h (8-12), ca_chieu: 4h (13-17), ca_toi: 3h (18-21)
        if (shift.thoi_gian_truc === "ca_sang") totalHoursCalc += 4;
        else if (shift.thoi_gian_truc === "ca_chieu") totalHoursCalc += 4;
        else if (shift.thoi_gian_truc === "ca_toi") totalHoursCalc += 3;
      });
    });
    totalHours.value = totalHoursCalc;
  }
};

// Helper function to get time slot index
const getTimeSlotIndex = (thoi_gian_truc) => {
  const mapping = {
    ca_sang: 0,
    ca_chieu: 1,
    ca_toi: 2,
  };
  return mapping[thoi_gian_truc] !== undefined ? mapping[thoi_gian_truc] : -1;
};

// Helper function to get shift name
const getShiftName = (thoi_gian_truc) => {
  const names = {
    ca_sang: "Ca Sáng",
    ca_chieu: "Ca Chiều",
    ca_toi: "Ca Tối",
  };
  return names[thoi_gian_truc] || thoi_gian_truc;
};

// Helper function to format room/location name
const formatRoomName = (shift, ghi_chu) => {
  const shiftName = getShiftName(shift);
  return ghi_chu ? `${shiftName} - ${ghi_chu}` : shiftName;
};

// Helper function to determine shift status
const getShiftStatus = (date, shift) => {
  const now = new Date();
  const shiftDate = new Date(date);

  if (shiftDate < now) {
    return "past";
  }

  // Check if it's today and within shift time
  if (shiftDate.toDateString() === now.toDateString()) {
    const hour = now.getHours();
    if (shift === "ca_sang" && hour >= 8 && hour < 12) return "ongoing";
    if (shift === "ca_chieu" && hour >= 13 && hour < 17) return "ongoing";
    if (shift === "ca_toi" && hour >= 18 && hour < 21) return "ongoing";
  }

  return "upcoming";
};

// Generate calendar days dynamically
const calendarDays = computed(() => {
  const days = [];
  const dayNames = ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "CN"];

  for (let i = 0; i < 7; i++) {
    const date = new Date(startOfWeek.value);
    date.setDate(date.getDate() + i);
    days.push({
      label: dayNames[i],
      date: formatDateDisplay(date),
      width: i < 4 ? "181.867px" : "78.82px",
    });
  }

  return days;
});

// Initialize on mount
onMounted(() => {
  currentUser.value = getUser();
  updateWeekRange();
  // Always fetch schedule data on mount
  fetchScheduleData();
});

// Watch for tab changes
watch(activeTab, (newTab) => {
  if (newTab === "my-schedule") {
    fetchScheduleData();
  }
});

// Handle click on shift to view details
const handleShiftClick = (shift, dayIndex, timeSlot) => {
  if (!shift) return;

  selectedShift.value = {
    ...shift,
    dayIndex,
    timeSlot: timeSlot.name,
    timeRange: timeSlot.time,
  };
  showDetailModal.value = true;
};

// Close modal
const closeModal = () => {
  showDetailModal.value = false;
  selectedShift.value = null;
};

const weekDays = ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "CN"];

const timeSlots = ref([
  {
    name: "Sáng",
    time: "8h-12h",
    schedule: [null, null, null, null, null, null, null],
  },
  {
    name: "Chiều",
    time: "13h-17h",
    schedule: [null, null, null, null, null, null, null],
  },
  {
    name: "Tối",
    time: "18h-21h",
    schedule: [null, null, null, null, null, null, null],
  },
]);

const shifts = ref([
  {
    id: 1,
    name: "Sáng",
    time: "8h-12h",
    days: ["selected", "empty", "selected", "full", "empty", "empty", "empty"],
  },
  {
    id: 2,
    name: "Chiều",
    time: "13h-17h",
    days: ["empty", "selected", "empty", "empty", "approved", "empty", "empty"],
  },
  {
    id: 3,
    name: "Tối",
    time: "18h-21h",
    days: ["empty", "empty", "empty", "empty", "empty", "selected", "empty"],
  },
]);

const legends = [
  {
    label: "Chưa chọn",
    class: "bg-white border-gray-200",
    icon: "plusCircleGray",
  },
  {
    label: "Đang chọn",
    class: "bg-blue-100 border-[#51a2ff]",
    icon: "checkCircleBlue",
  },
  {
    label: "Đã duyệt",
    class: "bg-green-100 border-[#00c950]",
    icon: "checkCircleGreen",
  },
  { label: "Đã kín", class: "bg-gray-200 border-[#99a1af]", icon: "lockIcon" },
];

const calendarLegends = [
  {
    label: "Sắp tới",
    class: "border-[#05df72] bg-green-50",
    status: "upcoming",
  },
  {
    label: "Đang diễn ra",
    class: "border-[#ff8904] bg-orange-50",
    status: "ongoing",
  },
  { label: "Đã qua", class: "border-gray-300 bg-gray-50", status: "past" },
];

// Helper function to get schedule cell class based on status
const getScheduleCellClass = (status) => {
  const legend = calendarLegends.find((l) => l.status === status);
  return legend ? legend.class : "";
};

const icons = {
  clipboardCheck:
    "https://www.figma.com/api/mcp/asset/afaa17a8-4dd1-4159-afba-ce6de41be981",
  calendarUser:
    "https://www.figma.com/api/mcp/asset/1d8695a1-d3ce-41f5-be9a-f01d493bd4ff",
  chevronLeft:
    "https://www.figma.com/api/mcp/asset/95893011-66af-46a2-89d0-8c37f38af121",
  calendar:
    "https://www.figma.com/api/mcp/asset/9bf5af36-6033-44b5-bc9f-c9d509e09bbd",
  chevronRight:
    "https://www.figma.com/api/mcp/asset/19f37aaa-5617-4f0f-a2f0-850b473694b0",
  alertCircle:
    "https://www.figma.com/api/mcp/asset/ac86bf5b-9f0d-484a-bc78-f45f1cfae5f1",
  calendarWhite:
    "https://www.figma.com/api/mcp/asset/0061a89d-0be4-4567-82c5-fa1ac2abfd69",
  listBlack:
    "https://www.figma.com/api/mcp/asset/ce93a96a-c48d-45d5-bfd4-9412ada63533",
  calendarBlack:
    "https://www.figma.com/api/mcp/asset/ce93a96a-c48d-45d5-bfd4-9412ada63533",
  listWhite:
    "https://www.figma.com/api/mcp/asset/0061a89d-0be4-4567-82c5-fa1ac2abfd69",
  mapPin:
    "https://www.figma.com/api/mcp/asset/80e0c896-dee8-4a04-98ce-137631eada1a",
  usersGreen:
    "https://www.figma.com/api/mcp/asset/525d3e04-34e1-478f-ab67-dcab0c194926",
  usersOrange:
    "https://www.figma.com/api/mcp/asset/23c7949b-a408-4b98-b4e4-624c65022e04",
  lightbulb:
    "https://www.figma.com/api/mcp/asset/307dc19e-d484-413b-977d-4ce4ececcd6b",
  checkCircleBlue:
    "https://www.figma.com/api/mcp/asset/71657569-34c5-4c7a-8449-a69598eac37c",
  plusCircle:
    "https://www.figma.com/api/mcp/asset/952ab492-d9f1-42fe-80eb-50dbf7b3c167",
  lockIcon:
    "https://www.figma.com/api/mcp/asset/be64e2a4-92fa-4ce0-8fa5-0ade98416436",
  checkCircleGreen:
    "https://www.figma.com/api/mcp/asset/8842afba-a48d-4d12-a65c-2b2a8b3760b5",
  plusCircleGray:
    "https://www.figma.com/api/mcp/asset/20fe5daa-db0a-4643-bb00-6350643d9ec5",
  save: "https://www.figma.com/api/mcp/asset/afd59c54-58a8-4849-bc1c-e61fde5b1006",
  send: "https://www.figma.com/api/mcp/asset/b8ce81d2-9e32-4792-8429-e45c725bc1c4",
  infoCircle:
    "https://www.figma.com/api/mcp/asset/74328a54-dc6a-450b-9316-ee606f99aace",
};

function toggleShift(shiftId, dayIndex, currentStatus) {
  if (currentStatus === "approved" || currentStatus === "full") {
    return; // Cannot toggle approved or full shifts
  }

  const shift = shifts.value.find((s) => s.id === shiftId);
  if (shift) {
    if (currentStatus === "selected") {
      shift.days[dayIndex] = "empty";
    } else {
      shift.days[dayIndex] = "selected";
    }
  }
}
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: #f3f3f5;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: #d1d1d6;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a8a8b0;
}

/* Remove default button styling */
button:focus {
  outline: none;
}

/* Font imports */
@import url("https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");
</style>
