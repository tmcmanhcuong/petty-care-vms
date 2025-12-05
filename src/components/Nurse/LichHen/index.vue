<template>
  <div class="w-full min-h-screen flex flex-col gap-6 p-6">
    <!-- Header Section -->
    <div class="flex flex-col h-[60px]">
      <h1 class="font-nunito font-medium text-2xl leading-9 text-[#101828] tracking-[0.0703px]">
        Quản lý Lịch hẹn
      </h1>
      <p class="font-nunito text-base leading-6 text-[#4a5565] tracking-[-0.3125px]">
        Đặt lịch, check-in và theo dõi lịch khám
      </p>
    </div>

    <!-- Search and Create Button Card -->
    <div class="bg-white border border-black/10 rounded-[14px] p-[17px]">
      <div class="flex items-center justify-between w-full">
        <div class="relative flex-1 max-w-[572px]">
          <img
            :src="iconSearch"
            alt="Search"
            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4"
          />
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Tìm theo SĐT, tên khách hàng hoặc tên thú cưng..."
            class="w-full bg-[#f3f3f5] border border-transparent rounded-lg pl-12 pr-4 py-3 font-nunito text-sm text-[#717182] tracking-[-0.1504px] focus:outline-none focus:border-[#009689]"
          />
        </div>
        <button
          class="bg-[#009689] rounded-lg px-4 py-3 flex items-center gap-3 hover:bg-[#007d72] transition-colors"
          @click="createAppointment"
        >
          <img :src="iconPlus" alt="Create" class="w-4 h-4" />
          <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
            Tạo lịch khám
          </span>
        </button>
      </div>
    </div>

    <!-- Tabs Card -->
    <div class="bg-white border border-black/10 rounded-[14px] p-px h-[85px]">
      <div class="border-b border-gray-200 h-[59px] flex items-center">
        <button
          :class="[
            'flex-1 h-[58px] flex items-center justify-center border-b-2 transition-colors',
            activeTab === 'list' ? 'bg-blue-50 border-[#1447e6]' : 'border-transparent'
          ]"
          @click="activeTab = 'list'"
        >
          <span
            :class="[
              'font-nunito text-sm leading-5 tracking-[-0.1504px]',
              activeTab === 'list' ? 'text-[#1447e6]' : 'text-[#4a5565]'
            ]"
          >
            Danh sách lịch hẹn
          </span>
        </button>
        <button
          :class="[
            'flex-1 h-[58px] flex items-center justify-center gap-2 border-b-2 transition-colors relative',
            activeTab === 'reminders' ? 'bg-blue-50 border-[#1447e6]' : 'border-transparent'
          ]"
          @click="activeTab = 'reminders'"
        >
          <span
            :class="[
              'font-nunito text-sm leading-5 tracking-[-0.1504px]',
              activeTab === 'reminders' ? 'text-[#1447e6]' : 'text-[#4a5565]'
            ]"
          >
            Lịch Nhắc Hẹn
          </span>
          <span class="bg-[#e7000b] rounded-lg px-2 py-[3px] min-w-[31px] text-center">
            <span class="font-nunito font-medium text-xs leading-4 text-white">
              15
            </span>
          </span>
        </button>
      </div>
    </div>

    <!-- Appointments Table Card (Danh sách lịch hẹn) -->
    <div v-if="activeTab === 'list'" class="bg-white border border-black/10 rounded-[14px] px-px py-6 flex flex-col gap-[30px]">
      <!-- Card Title -->
      <div class="px-6">
        <h2 class="font-nunito text-lg leading-4 text-[#101828] tracking-[-0.3125px]">
          Danh sách lịch hẹn
        </h2>
      </div>

      <!-- Filters and Date Selector -->
      <div class="px-6 flex flex-col gap-4 border-b border-gray-200 pb-px">
        <div class="flex items-center justify-between">
          <!-- Filter Pills -->
          <div class="flex items-center gap-2">
            <button
              v-for="filter in filters"
              :key="filter.key"
              :class="[
                'h-[38px] rounded-full px-4 flex items-center gap-2 transition-colors',
                activeFilter === filter.key
                  ? 'bg-[#009689] shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.1),0px_2px_4px_-2px_rgba(0,0,0,0.1)]'
                  : 'bg-gray-100 hover:bg-gray-200'
              ]"
              @click="activeFilter = filter.key"
            >
              <img
                v-if="filter.icon"
                :src="filter.icon"
                alt=""
                class="w-4 h-4"
              />
              <span
                :class="[
                  'font-nunito font-medium text-sm leading-5 tracking-[-0.1504px]',
                  activeFilter === filter.key ? 'text-white' : 'text-[#364153]'
                ]"
              >
                {{ filter.label }}
              </span>
              <span
                :class="[
                  'rounded-lg px-2 py-[3px] min-w-[22px] text-center',
                  activeFilter === filter.key ? 'bg-[#00786f]' : 'bg-gray-200'
                ]"
              >
                <span
                  :class="[
                    'font-nunito font-medium text-xs leading-4',
                    activeFilter === filter.key ? 'text-white' : 'text-[#364153]'
                  ]"
                >
                  {{ filter.count }}
                </span>
              </span>
            </button>
          </div>

          <!-- Divider -->
          <div class="bg-[#d1d5dc] w-px h-8" />

          <!-- Date Selector -->
          <button
            class="bg-[#4f39f6] rounded-full shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.1),0px_2px_4px_-2px_rgba(0,0,0,0.1)] h-9 px-4 flex items-center gap-2 hover:bg-[#3d2ac4] transition-colors"
            @click="selectDate"
          >
            <img :src="iconCalendar" alt="Calendar" class="w-4 h-4" />
            <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
              Hôm nay
            </span>
            <img :src="iconChevronDown" alt="Expand" class="w-4 h-4" />
          </button>
        </div>
      </div>

      <!-- Table -->
      <div class="px-6 overflow-x-auto">
        <table class="w-full">
          <!-- Table Header -->
          <thead>
            <tr class="border-b border-black/10">
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Thời gian & Nguồn
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Bệnh nhân
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Dịch vụ
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Phân công
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Trạng thái
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Thao tác
              </th>
            </tr>
          </thead>

          <!-- Table Body -->
          <tbody>
            <tr
              v-for="(appointment, index) in filteredAppointments"
              :key="index"
              :class="[
                'border-b border-black/10',
                appointment.rowColor || ''
              ]"
            >
              <!-- Time & Source -->
              <td class="px-3 py-2">
                <div class="flex flex-col gap-1.5">
                  <div class="flex flex-col gap-0.5">
                    <div v-if="appointment.appointmentTime" class="flex items-center gap-0.5">
                      <span
                        :class="[
                          'font-nunito font-bold text-sm leading-5 tracking-[-0.1504px]',
                          appointment.checkInTime ? 'text-purple-700' : 'text-[#101828]'
                        ]"
                      >
                        {{ appointment.appointmentTime }}
                      </span>
                    </div>
                    <div class="flex items-center gap-0.5">
                      <img :src="iconClock" alt="Check-in" class="w-3 h-3" />
                      <span class="font-nunito text-xs leading-4 text-gray-500">
                        {{ appointment.checkInTime || '--:--' }}
                      </span>
                    </div>
                  </div>
                  <span
                    v-if="appointment.source"
                    :class="[
                      'border rounded-lg px-2 py-1 flex items-center gap-1 w-fit',
                      appointment.source === 'scheduled' ? 'bg-blue-50 border-[#bedbff]' :
                      appointment.source === 'walkin' ? 'bg-purple-50 border-[#e9d4ff]' :
                      'bg-blue-50 border-blue-300'
                    ]"
                  >
                    <img
                      :src="appointment.source === 'scheduled' ? iconCalendarSmall :
                            appointment.source === 'walkin' ? iconWalkIn :
                            iconMember"
                      alt=""
                      class="w-3 h-3"
                    />
                    <span
                      :class="[
                        'font-nunito font-medium text-xs leading-4',
                        appointment.source === 'scheduled' ? 'text-[#1447e6]' :
                        appointment.source === 'walkin' ? 'text-[#8200db]' :
                        'text-blue-700'
                      ]"
                    >
                      {{ appointment.source === 'scheduled' ? 'Đặt trước' :
                         appointment.source === 'walkin' ? 'Vãng lai' :
                         'Thành Viên' }}
                    </span>
                  </span>
                </div>
              </td>

              <!-- Patient -->
              <td class="px-2 py-2.5">
                <div class="flex flex-col gap-0.5">
                  <div class="flex items-center gap-1">
                    <span class="font-nunito font-bold text-sm leading-5 text-[#101828] tracking-[-0.1504px]">
                      {{ appointment.petName }}
                    </span>
                    <img
                      v-if="appointment.hasMale"
                      :src="iconMale"
                      alt="Male"
                      class="w-3.5 h-3.5"
                    />
                  </div>
                  <div class="flex items-center gap-1">
                    <img :src="iconUser" alt="Owner" class="w-3 h-3" />
                    <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
                      {{ appointment.ownerName }}
                    </span>
                  </div>
                </div>
              </td>

              <!-- Service -->
              <td class="px-2 py-5">
                <span class="font-nunito text-base leading-6 text-[#101828] tracking-[-0.3125px]">
                  {{ appointment.service }}
                </span>
              </td>

              <!-- Assignment -->
              <td class="px-2 py-3">
                <div class="flex flex-col gap-0.5">
                  <div class="flex items-center gap-1">
                    <img :src="iconDoctor" alt="Doctor" class="w-3 h-3" />
                    <span class="font-nunito text-sm leading-5 text-[#101828] tracking-[-0.1504px]">
                      {{ appointment.doctor }}
                    </span>
                  </div>
                  <div class="flex items-center gap-1">
                    <img :src="iconRoom" alt="Room" class="w-3 h-3" />
                    <span class="font-nunito text-xs leading-4 text-[#4a5565]">
                      {{ appointment.room }}
                    </span>
                  </div>
                </div>
              </td>

              <!-- Status -->
              <td class="px-2 py-5">
                <span
                  :class="[
                    'border rounded-lg px-4 py-[3px] inline-block',
                    appointment.status === 'upcoming' ? 'bg-blue-100 border-blue-300 text-blue-700' :
                    appointment.status === 'arrived' ? 'bg-green-100 border-[#7bf1a8] text-[#008236]' :
                    appointment.status === 'examining' ? 'bg-orange-100 border-orange-400 text-orange-600' :
                    'bg-green-100 border-transparent text-[#008236]'
                  ]"
                >
                  <span class="font-nunito font-medium text-xs leading-4">
                    {{ appointment.status === 'upcoming' ? 'Sắp đến' :
                       appointment.status === 'arrived' ? 'Đã đến' :
                       appointment.status === 'examining' ? 'Đang khám' :
                       'Chờ thanh toán' }}
                  </span>
                </span>
              </td>

              <!-- Action -->
              <td class="px-2 py-4">
                <button
                  v-if="appointment.action === 'checkin'"
                  :class="[
                    'rounded-lg h-8 w-full flex items-center justify-center gap-2 transition-colors',
                    appointment.status === 'upcoming' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-400 cursor-not-allowed'
                  ]"
                  :disabled="appointment.status !== 'upcoming'"
                  @click="checkIn(appointment)"
                >
                  <img :src="iconCheckIn" alt="Check-in" class="w-4 h-4" />
                  <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
                    Check-in
                  </span>
                </button>
                <button
                  v-else-if="appointment.action === 'payment'"
                  :class="[
                    'rounded-lg h-8 w-full flex items-center justify-center gap-2 transition-colors',
                    appointment.status === 'payment' ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 cursor-not-allowed'
                  ]"
                  :disabled="appointment.status !== 'payment'"
                  @click="collectPayment(appointment)"
                >
                  <img :src="iconMoney" alt="Payment" class="w-4 h-4" />
                  <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
                    Thu tiền
                  </span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Reminders Table Card (Lịch Nhắc Hẹn) -->
    <div v-else-if="activeTab === 'reminders'" class="bg-white border border-black/10 rounded-[14px] px-px py-6 flex flex-col gap-[30px]">
      <!-- Card Title -->
      <div class="px-6">
        <h2 class="font-nunito text-lg leading-4 text-[#101828] tracking-[-0.3125px]">
          Lịch Nhắc Hẹn
        </h2>
      </div>

      <!-- Reminder Filters and Time Selector -->
      <div class="px-6 flex flex-col gap-4 border-b border-gray-200 pb-px">
        <div class="flex items-center gap-2">
          <!-- Type Filter Pills -->
          <button
            v-for="reminderType in reminderTypes"
            :key="reminderType.key"
            :class="[
              'h-[38px] rounded-full px-4 flex items-center gap-2 transition-colors',
              activeReminderType === reminderType.key
                ? 'bg-[#009689] shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.1),0px_2px_4px_-2px_rgba(0,0,0,0.1)]'
                : 'bg-gray-100 hover:bg-gray-200'
            ]"
            @click="activeReminderType = reminderType.key"
          >
            <img
              v-if="reminderType.icon"
              :src="reminderType.icon"
              alt=""
              class="w-4 h-4"
            />
            <span
              :class="[
                'font-nunito font-medium text-sm leading-5 tracking-[-0.1504px]',
                activeReminderType === reminderType.key ? 'text-white' : 'text-[#364153]'
              ]"
            >
              {{ reminderType.label }}
            </span>
            <span
              :class="[
                'rounded-lg px-2 py-[3px] min-w-[22px] text-center',
                activeReminderType === reminderType.key ? 'bg-[#00786f]' : 'bg-gray-200'
              ]"
            >
              <span
                :class="[
                  'font-nunito font-medium text-xs leading-4',
                  activeReminderType === reminderType.key ? 'text-white' : 'text-[#364153]'
                ]"
              >
                {{ reminderType.count }}
              </span>
            </span>
          </button>
        </div>

        <!-- Time Filter -->
        <div class="flex items-center gap-2">
          <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
            Thời gian:
          </span>
          <button
            v-for="timeFilter in timeFilters"
            :key="timeFilter.key"
            :class="[
              'h-9 rounded-[10px] px-4 flex items-center gap-2 transition-colors',
              activeTimeFilter === timeFilter.key
                ? timeFilter.key === 'overdue' ? 'bg-[#e7000b]' : 'bg-[#4f39f6]'
                : 'bg-gray-100 hover:bg-gray-200'
            ]"
            @click="activeTimeFilter = timeFilter.key"
          >
            <img :src="timeFilter.icon" alt="" class="w-4 h-4" />
            <span
              :class="[
                'font-nunito text-sm leading-5 tracking-[-0.1504px]',
                activeTimeFilter === timeFilter.key ? 'text-white' : 'text-[#364153]'
              ]"
            >
              {{ timeFilter.label }}
            </span>
          </button>
        </div>
      </div>

      <!-- Reminders Table -->
      <div class="px-6 overflow-x-auto">
        <table class="w-full">
          <!-- Table Header -->
          <thead>
            <tr class="border-b border-black/10">
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Khách hàng
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Loại nhắc
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Nội dung
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Hạn xử lý
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Trạng thái
              </th>
              <th class="text-left px-2 py-2.5 font-nunito font-medium text-sm text-[#101828] tracking-[-0.1504px]">
                Thao tác
              </th>
            </tr>
          </thead>

          <!-- Table Body -->
          <tbody>
            <tr
              v-for="(reminder, index) in filteredReminders"
              :key="index"
              :class="[
                'border-b border-black/10',
                reminder.isOverdue ? 'bg-red-50' : ''
              ]"
            >
              <!-- Customer -->
              <td class="px-2 py-2">
                <div class="flex flex-col gap-0.5">
                  <div class="flex items-start gap-0.5">
                    <span class="font-nunito font-bold text-sm leading-5 text-[#101828] tracking-[-0.1504px]">
                      {{ reminder.petName }}
                    </span>
                    <span class="font-nunito text-sm leading-5 text-[#101828] tracking-[-0.1504px]">
                      ({{ reminder.breed }})
                    </span>
                  </div>
                  <div class="flex items-center gap-1">
                    <img :src="iconUser" alt="Owner" class="w-3 h-3" />
                    <span class="font-nunito text-sm leading-5 text-[#4a5565] tracking-[-0.1504px]">
                      {{ reminder.ownerName }} - {{ reminder.phone }}
                    </span>
                  </div>
                </div>
              </td>

              <!-- Type -->
              <td class="px-2 py-5">
                <span
                  :class="[
                    'border rounded-lg px-2 py-1 flex items-center gap-1 w-fit',
                    reminder.type === 'recheck' ? 'bg-blue-100 border-transparent' :
                    reminder.type === 'vaccination' ? 'bg-purple-100 border-transparent' :
                    'bg-green-100 border-transparent'
                  ]"
                >
                  <img
                    :src="reminder.type === 'recheck' ? iconReminderRecheck :
                          reminder.type === 'vaccination' ? iconReminderVaccine :
                          iconReminderDeworming"
                    alt=""
                    class="w-3 h-3"
                  />
                  <span
                    :class="[
                      'font-nunito font-medium text-xs leading-4',
                      reminder.type === 'recheck' ? 'text-[#1447e6]' :
                      reminder.type === 'vaccination' ? 'text-[#8200db]' :
                      'text-[#008236]'
                    ]"
                  >
                    {{ reminder.type === 'recheck' ? 'Tái Khám' :
                       reminder.type === 'vaccination' ? 'Tiêm Chủng' :
                       'Tẩy Giun' }}
                  </span>
                </span>
              </td>

              <!-- Content -->
              <td class="px-2 py-5">
                <span class="font-nunito text-base leading-6 text-[#101828] tracking-[-0.3125px]">
                  {{ reminder.content }}
                </span>
              </td>

              <!-- Deadline -->
              <td class="px-2 py-5">
                <div class="flex items-center gap-1">
                  <img
                    v-if="reminder.isOverdue"
                    :src="iconAlert"
                    alt="Alert"
                    class="w-4 h-4"
                  />
                  <span
                    :class="[
                      'font-nunito text-sm leading-5 tracking-[-0.1504px]',
                      reminder.isOverdue ? 'text-[#e7000b]' : 'text-[#101828]'
                    ]"
                  >
                    {{ reminder.deadline }}
                  </span>
                </div>
              </td>

              <!-- Status -->
              <td class="px-2 py-5">
                <span
                  :class="[
                    'border rounded-lg px-2 py-[3px] inline-flex items-center gap-1',
                    reminder.status === 'not-called' ? 'border-[#d1d5dc]' :
                    reminder.status === 'called' ? 'border-[#ffdf20]' :
                    reminder.status === 'agreed' ? 'border-[#7bf1a8]' :
                    'border-[#ffb86a]'
                  ]"
                >
                  <img
                    :src="reminder.status === 'not-called' ? iconStatusNotCalled :
                          reminder.status === 'called' ? iconStatusCalled :
                          reminder.status === 'agreed' ? iconStatusAgreed :
                          iconStatusKNM"
                    alt=""
                    class="w-3 h-3"
                  />
                  <span
                    :class="[
                      'font-nunito font-medium text-xs leading-4',
                      reminder.status === 'not-called' ? 'text-[#4a5565]' :
                      reminder.status === 'called' ? 'text-[#d08700]' :
                      reminder.status === 'agreed' ? 'text-[#00a63e]' :
                      'text-[#f54900]'
                    ]"
                  >
                    {{ reminder.status === 'not-called' ? 'Chưa gọi' :
                       reminder.status === 'called' ? 'Đã gọi' :
                       reminder.status === 'agreed' ? 'Đồng ý' :
                       'KNM' }}
                  </span>
                </span>
              </td>

              <!-- Actions -->
              <td class="px-2 py-4">
                <div class="flex items-center gap-2">
                  <!-- Call button -->
                  <button
                    class="bg-white border border-[#7bf1a8] rounded-lg w-[38px] h-8 flex items-center justify-center hover:bg-green-50 transition-colors"
                    @click="callCustomer(reminder)"
                  >
                    <img :src="iconPhone" alt="Call" class="w-4 h-4" />
                  </button>

                  <!-- Book appointment button -->
                  <button
                    :class="[
                      'rounded-lg h-8 px-3 flex items-center gap-2 transition-colors',
                      reminder.type === 'recheck' ? 'bg-[#155dfc] hover:bg-[#0d4ed4]' :
                      reminder.type === 'vaccination' ? 'bg-[#9810fa] hover:bg-[#7a0cc9]' :
                      'bg-[#00a63e] hover:bg-[#008532]'
                    ]"
                    @click="bookFromReminder(reminder)"
                  >
                    <img :src="iconCalendarBook" alt="Book" class="w-4 h-4" />
                    <span class="font-nunito font-medium text-sm leading-5 text-white tracking-[-0.1504px]">
                      Đặt lịch
                    </span>
                  </button>

                  <!-- Edit button -->
                  <button
                    class="bg-white border border-[#ffb86a] rounded-lg w-[38px] h-8 flex items-center justify-center hover:bg-orange-50 transition-colors"
                    @click="editReminder(reminder)"
                  >
                    <img :src="iconEdit" alt="Edit" class="w-4 h-4" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
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
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import CheckInModal from './CheckIn/index.vue'
import TaoLichKhamModal from './TaoLichKham/index.vue'

// Icons for Appointments
const iconSearch = "https://www.figma.com/api/mcp/asset/2e7c946a-889d-4a42-9d38-aea7bc8066ed"
const iconPlus = "https://www.figma.com/api/mcp/asset/90360139-4011-4346-9a0b-8ca69fab969f"
const iconUpcoming = "https://www.figma.com/api/mcp/asset/7d6466b4-674b-48b6-ab95-8278fe0e9b84"
const iconArrived = "https://www.figma.com/api/mcp/asset/5df771d5-1550-4ae1-ad87-6aeabe3f1e44"
const iconExamining = "https://www.figma.com/api/mcp/asset/6494a3df-fb4e-4a27-a657-96047dc703fd"
const iconPayment = "https://www.figma.com/api/mcp/asset/16a0085a-a982-434f-ab56-44c541537376"
const iconCalendar = "https://www.figma.com/api/mcp/asset/215b1bb0-3b69-4bb3-97ce-a85d2e46eb3a"
const iconChevronDown = "https://www.figma.com/api/mcp/asset/2dc876c1-5158-435b-b6b1-0daf988c9192"
const iconClock = "https://www.figma.com/api/mcp/asset/3823d922-20bc-4121-a652-86e1377b69b9"
const iconCalendarSmall = "https://www.figma.com/api/mcp/asset/8930a10d-4d79-4f01-a1be-65bae7a271b1"
const iconMale = "https://www.figma.com/api/mcp/asset/34fd2f8e-6dd6-478b-9fda-333a17af3bb2"
const iconUser = "https://www.figma.com/api/mcp/asset/8716e4ba-208e-49c1-a9fe-baf53794550f"
const iconDoctor = "https://www.figma.com/api/mcp/asset/97632d8e-c43d-4aa5-a2d1-03a4c2edb6ff"
const iconRoom = "https://www.figma.com/api/mcp/asset/0b335040-3085-48c9-8186-11fb6d926008"
const iconCheckIn = "https://www.figma.com/api/mcp/asset/8adeff95-562c-4cdc-859e-7bcbad6ca375"
const iconWalkIn = "https://www.figma.com/api/mcp/asset/28293856-dcad-4d85-9d01-cd1b62ecb0f8"
const iconMember = "https://www.figma.com/api/mcp/asset/996ab4be-54e4-4a9e-b4be-33dc0567b200"
const iconMoney = "https://www.figma.com/api/mcp/asset/4c71be7b-2b82-43a3-acd7-c4c75d231666"

// Icons for Reminders
const iconReminderRecheck = "https://www.figma.com/api/mcp/asset/22e604f9-99dd-4555-88aa-affc64c8b000"
const iconReminderVaccine = "https://www.figma.com/api/mcp/asset/011d06f7-56e5-4ec3-a486-c9843af12e88"
const iconReminderDeworming = "https://www.figma.com/api/mcp/asset/767464e6-a54c-482a-9c9d-b6230f97d974"
const iconCalendarTime = "https://www.figma.com/api/mcp/asset/60faa6c7-76c8-4c3d-a57c-14af5a8f4455"
const iconOverdue = "https://www.figma.com/api/mcp/asset/067c463b-e4e9-493b-b59b-03dc0dd9abdc"
const iconWeek = "https://www.figma.com/api/mcp/asset/7c665889-aca8-4450-bf58-05b870cb31e1"
const iconAlert = "https://www.figma.com/api/mcp/asset/8c439c25-dad6-4e5d-9b58-77a40dee4cb6"
const iconStatusNotCalled = "https://www.figma.com/api/mcp/asset/73db85ef-7831-4761-89ca-c1b09a00359d"
const iconStatusCalled = "https://www.figma.com/api/mcp/asset/db0fd1c6-447d-4bb3-b5fe-fe6ae8a87104"
const iconStatusAgreed = "https://www.figma.com/api/mcp/asset/fe58dbc3-4dc2-4a33-bc86-be8f5b76cde4"
const iconStatusKNM = "https://www.figma.com/api/mcp/asset/f4bbf67a-674f-46eb-a80f-b7ea0c0c8db1"
const iconPhone = "https://www.figma.com/api/mcp/asset/1c34e33e-f895-4abc-a0fb-7d69db40e7b9"
const iconCalendarBook = "https://www.figma.com/api/mcp/asset/38aa92c1-c34f-444b-90ab-2d5e59d12680"
const iconEdit = "https://www.figma.com/api/mcp/asset/a0fe1a77-f466-43d7-93e4-43ed4e4b7208"

// State
const searchQuery = ref('')
const activeTab = ref('list')
const activeFilter = ref('all')
const activeReminderType = ref('all')
const activeTimeFilter = ref('today')
const isCheckInModalOpen = ref(false)
const isCreateAppointmentModalOpen = ref(false)
const selectedAppointment = ref(null)

// Appointment Filters
const filters = ref([
  { key: 'all', label: 'Tất cả', count: 11, icon: null },
  { key: 'upcoming', label: 'Sắp tới', count: 3, icon: iconUpcoming },
  { key: 'arrived', label: 'Đã đến', count: 1, icon: iconArrived },
  { key: 'examining', label: 'Đang khám', count: 3, icon: iconExamining },
  { key: 'payment', label: 'Chờ thanh toán', count: 2, icon: iconPayment }
])

// Reminder Type Filters
const reminderTypes = ref([
  { key: 'all', label: 'Tất cả', count: 15, icon: null },
  { key: 'recheck', label: 'Tái Khám', count: 5, icon: iconReminderRecheck },
  { key: 'vaccination', label: 'Tiêm Chủng', count: 8, icon: iconReminderVaccine },
  { key: 'deworming', label: 'Tẩy Giun', count: 2, icon: iconReminderDeworming }
])

// Time Filters
const timeFilters = ref([
  { key: 'today', label: 'Hôm nay', icon: iconCalendarTime },
  { key: 'overdue', label: 'Quá hạn', icon: iconOverdue },
  { key: 'thisWeek', label: 'Tuần này', icon: iconWeek }
])

// Appointments data
const appointments = ref([
  {
    id: 1,
    appointmentTime: '09:30',
    checkInTime: null,
    source: 'scheduled',
    petName: 'Milo',
    hasMale: true,
    ownerName: 'Nguyễn Văn A',
    service: 'Khám tổng quát',
    doctor: 'BS. Hùng',
    room: 'Phòng 102',
    status: 'upcoming',
    action: 'checkin',
    rowColor: 'bg-blue-50'
  },
  {
    id: 2,
    appointmentTime: '09:12',
    checkInTime: '09:12',
    source: 'walkin',
    petName: 'Lu',
    hasMale: false,
    ownerName: 'Đỗ Thị D',
    service: 'Khám tổng quát',
    doctor: 'BS. Hùng',
    room: 'Phòng 102',
    status: 'arrived',
    action: 'checkin',
    rowColor: ''
  },
  {
    id: 3,
    appointmentTime: '09:24',
    checkInTime: '09:24',
    source: 'member',
    petName: 'Luna',
    hasMale: false,
    ownerName: 'Trần Thị B',
    service: 'Tiêm phòng Vắc-Xin',
    doctor: 'BS. Hùng',
    room: 'Phòng 102',
    status: 'arrived',
    action: 'checkin',
    rowColor: ''
  },
  {
    id: 4,
    appointmentTime: '10:30',
    checkInTime: null,
    source: 'scheduled',
    petName: 'Max',
    hasMale: false,
    ownerName: 'Lê Văn C',
    service: 'Khám tổng quát',
    doctor: 'BS. Hùng',
    room: 'Phòng 102',
    status: 'upcoming',
    action: 'checkin',
    rowColor: 'bg-blue-50'
  },
  {
    id: 5,
    appointmentTime: '08:18',
    checkInTime: '08:18',
    source: 'member',
    petName: 'Bella',
    hasMale: false,
    ownerName: 'Phạm Thị D',
    service: 'Khám tổng quát',
    doctor: 'BS. Hùng',
    room: 'Phòng 102',
    status: 'examining',
    action: 'payment',
    rowColor: 'bg-orange-50'
  },
  {
    id: 6,
    appointmentTime: null,
    checkInTime: null,
    source: null,
    petName: 'MiMi',
    hasMale: false,
    ownerName: 'Phạm Thị D',
    service: 'Cắt tỉa lông',
    doctor: 'CV. Hoài',
    room: 'Phòng 201',
    status: 'payment',
    action: 'payment',
    rowColor: 'bg-green-50'
  },
  {
    id: 7,
    appointmentTime: null,
    checkInTime: null,
    source: null,
    petName: 'Rocky',
    hasMale: false,
    ownerName: 'Hoàng Văn E',
    service: 'Khám tổng quát',
    doctor: 'BS. Nam',
    room: 'Phòng 104',
    status: 'payment',
    action: 'payment',
    rowColor: 'bg-green-50'
  }
])

// Reminders data
const reminders = ref([
  {
    id: 1,
    petName: 'Milo',
    breed: 'Golden',
    ownerName: 'A. Nam',
    phone: '0901234567',
    type: 'recheck',
    content: 'Tái khám sau phẫu thuật',
    deadline: 'Hôm nay (03/12)',
    status: 'not-called',
    isOverdue: false
  },
  {
    id: 2,
    petName: 'Luna',
    breed: 'Mèo Ba Tư',
    ownerName: 'B. Hương',
    phone: '0912345678',
    type: 'recheck',
    content: 'Kiểm tra vết mổ',
    deadline: 'Hôm nay (03/12)',
    status: 'not-called',
    isOverdue: false
  },
  {
    id: 3,
    petName: 'Max',
    breed: 'Husky',
    ownerName: 'C. Tuấn',
    phone: '0923456789',
    type: 'recheck',
    content: 'Tái khám da liễu',
    deadline: 'Hôm nay (03/12)',
    status: 'called',
    isOverdue: false
  },
  {
    id: 4,
    petName: 'Rocky',
    breed: 'Golden',
    ownerName: 'E. Minh',
    phone: '0945678901',
    type: 'recheck',
    content: 'Tái khám định kỳ',
    deadline: 'Hôm nay (03/12)',
    status: 'agreed',
    isOverdue: false
  },
  {
    id: 5,
    petName: 'Milo',
    breed: 'Golden',
    ownerName: 'A. Nam',
    phone: '0901234567',
    type: 'vaccination',
    content: 'Tiêm mũi 3 (7 bệnh)',
    deadline: 'Hôm nay (03/12)',
    status: 'not-called',
    isOverdue: false
  },
  {
    id: 6,
    petName: 'Simba',
    breed: 'Mèo Ba Tư',
    ownerName: 'G. Tuấn',
    phone: '0967890123',
    type: 'vaccination',
    content: 'Tiêm vaccine 5 bệnh',
    deadline: 'Hôm nay (03/12)',
    status: 'not-called',
    isOverdue: false
  },
  {
    id: 7,
    petName: 'Mimi',
    breed: 'Mèo Anh',
    ownerName: 'K. Lan',
    phone: '0990123456',
    type: 'vaccination',
    content: 'Tiêm vaccine 7 bệnh',
    deadline: 'Hôm nay (03/12)',
    status: 'called',
    isOverdue: false
  },
  {
    id: 8,
    petName: 'Milo',
    breed: 'Golden',
    ownerName: 'A. Nam',
    phone: '0901234567',
    type: 'deworming',
    content: 'Tẩy giun định kỳ 3 tháng',
    deadline: 'Hôm nay (03/12)',
    status: 'not-called',
    isOverdue: false
  },
  {
    id: 9,
    petName: 'Bella',
    breed: 'Poodle',
    ownerName: 'D. Linh',
    phone: '0934567890',
    type: 'recheck',
    content: 'Tái khám nội khoa',
    deadline: 'Quá hạn (02/12)',
    status: 'knm',
    isOverdue: true
  },
  {
    id: 10,
    petName: 'Buddy',
    breed: 'Husky',
    ownerName: 'I. Khoa',
    phone: '0989012345',
    type: 'vaccination',
    content: 'Tiêm phòng dại mũi 1',
    deadline: 'Quá hạn (01/12)',
    status: 'not-called',
    isOverdue: true
  }
])

// Computed
const filteredAppointments = computed(() => {
  let filtered = appointments.value

  // Filter by active filter
  if (activeFilter.value !== 'all') {
    filtered = filtered.filter(app => app.status === activeFilter.value)
  }

  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(app =>
      app.petName.toLowerCase().includes(query) ||
      app.ownerName.toLowerCase().includes(query)
    )
  }

  return filtered
})

const filteredReminders = computed(() => {
  let filtered = reminders.value

  // Filter by reminder type
  if (activeReminderType.value !== 'all') {
    filtered = filtered.filter(rem => rem.type === activeReminderType.value)
  }

  // Filter by time
  if (activeTimeFilter.value === 'overdue') {
    filtered = filtered.filter(rem => rem.isOverdue)
  } else if (activeTimeFilter.value === 'today') {
    filtered = filtered.filter(rem => !rem.isOverdue && rem.deadline.includes('Hôm nay'))
  } else if (activeTimeFilter.value === 'thisWeek') {
    // TODO: Implement week filtering
    filtered = filtered.filter(rem => !rem.isOverdue)
  }

  return filtered
})

// Methods
const createAppointment = () => {
  isCreateAppointmentModalOpen.value = true
}

const handleCreateAppointmentSubmit = (data) => {
  console.log('Create appointment:', data)
  // TODO: Implement API call
  isCreateAppointmentModalOpen.value = false
}

const selectDate = () => {
  console.log('Select date')
  // TODO: Implement date picker
}

const checkIn = (appointment) => {
  selectedAppointment.value = {
    ...appointment,
    phone: '0901234567', // Mock phone
    species: 'Chó', // Mock species
    breed: 'Poodle', // Mock breed
    birthDate: '01/01/2022' // Mock date
  }
  isCheckInModalOpen.value = true
}

const handleCheckInConfirm = (patientInfo) => {
  // Find the appointment and update it
  const index = appointments.value.findIndex(a => a.id === patientInfo.id)
  if (index !== -1) {
    appointments.value[index].status = 'arrived'
    appointments.value[index].checkInTime = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' })
    appointments.value[index].rowColor = ''
  }
  isCheckInModalOpen.value = false
}

const collectPayment = (appointment) => {
  console.log('Collect payment:', appointment.petName)
  // TODO: Implement payment collection logic
}

// Reminder Methods
const callCustomer = (reminder) => {
  console.log('Call customer:', reminder.ownerName, reminder.phone)
  // TODO: Implement call customer logic
}

const bookFromReminder = (reminder) => {
  console.log('Book appointment from reminder:', reminder.petName)
  // TODO: Implement booking from reminder
}

const editReminder = (reminder) => {
  console.log('Edit reminder:', reminder.id)
  // TODO: Implement edit reminder logic
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;500;600;700&display=swap');

* {
  font-family: 'Nunito Sans', sans-serif;
}
</style>
