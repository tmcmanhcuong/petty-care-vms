<template>
  <div class="flex flex-col gap-6 px-6 py-6 w-ful">
    <!-- Page Header -->
    <div class="flex flex-col gap-1">
      <h1 class="font-nunitoSans font-bold text-[#111827] text-xl leading-6">
        Quản lý Khoa & Bộ phận
      </h1>
      <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
        Tổ chức và phân bổ nhân sự theo khoa và bộ phận
      </p>
    </div>

    <!-- Tab Switcher -->
    <div class="bg-[#f3f4f6] flex items-center p-1 rounded-[10px] shadow-sm w-fit">
      <button
        @click="activeMainTab = 'khoa'"
        :class="activeMainTab === 'khoa' ? 'bg-white shadow-md text-[#0d9488]' : 'text-[#4b5563]'"
        class="font-nunitoSans font-medium text-sm leading-5 px-9 py-2.5 rounded-lg transition-all"
      >
        Khoa
      </button>
      <button
        @click="activeMainTab = 'boPhan'"
        :class="activeMainTab === 'boPhan' ? 'bg-white shadow-md text-[#0d9488]' : 'text-[#4b5563]'"
        class="font-nunitoSans font-medium text-sm leading-5 px-6 py-2.5 rounded-lg transition-all"
      >
        Bộ Phận
      </button>
    </div>

    <!-- Main Content -->
    <div v-if="activeMainTab === 'khoa'" class="flex gap-6 items-start">
      <!-- Department List Sidebar -->
      <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-6 w-[266px] flex flex-col gap-8">
        <!-- Search and Add Section -->
        <div class="flex flex-col gap-3 w-[216px]">
          <h3 class="font-nunitoSans font-medium text-black text-base leading-6">
            Danh sách Khoa
          </h3>

          <!-- Search Input -->
          <div class="relative h-9 w-full">
            <div class="absolute bg-[#f3f4f6] border border-transparent h-9 left-0 rounded-lg top-0 w-full">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Tìm tên khoa..."
                class="font-nunitoSans font-medium text-[#6b7280] text-sm h-9 w-full pl-10 pr-3 py-1 bg-transparent border-none outline-none rounded-lg"
              />
            </div>
            <img :src="icons.search" alt="" class="absolute left-3 top-2.5 w-4 h-4" />
          </div>

          <!-- Add Department Button -->
          <button
            @click="handleAddDepartment"
            class="bg-[#5a9690] flex gap-1.5 items-center justify-center px-14 py-1 rounded-lg w-full hover:bg-[#4a7f79] transition-colors"
          >
            <img :src="icons.plus" alt="" class="w-4 h-4" />
            <span class="font-nunitoSans font-medium text-white text-base leading-6">
              Thêm Khoa
            </span>
          </button>
        </div>

        <!-- Department List -->
        <div class="flex flex-col h-[371px] overflow-y-auto w-full">
          <button
            v-for="dept in filteredDepartments"
            :key="dept.id"
            @click="selectDepartment(dept)"
            :class="selectedDepartment?.id === dept.id ? 'bg-[#f0fdfa] border-l-4 border-l-[#5a9690]' : 'border-b border-[rgba(0,0,0,0.15)]'"
            class="h-[93px] w-full relative transition-colors hover:bg-gray-50"
          >
            <div class="absolute flex flex-col gap-2 h-[60px] left-5 top-4 w-[228px]">
              <div class="flex h-9 items-start justify-between w-full">
                <div class="flex-1 flex flex-col items-start">
                  <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                    {{ dept.name }}
                  </p>
                  <p class="font-nunitoSans font-medium text-[#6b7280] text-sm leading-5">
                    {{ dept.code }}
                  </p>
                </div>
                <div class="bg-[#dcfce7] border border-transparent rounded-lg h-6 w-[30px] flex items-center justify-center">
                  <img :src="icons.checkCircle" alt="" class="w-4 h-4" />
                </div>
              </div>
              <div class="flex gap-3 h-4 w-full">
                <span class="font-nunitoSans font-medium text-[#4b5563] text-sm">
                  {{ dept.doctors }} BS
                </span>
                <span class="font-nunitoSans font-medium text-[#4b5563] text-sm">
                  {{ dept.nurses }} Y tá
                </span>
              </div>
            </div>
          </button>
        </div>
      </div>

      <!-- Department Details Card -->
      <div 
        v-if="selectedDepartment"
        class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-6 flex-1 flex flex-col gap-8 min-h-[330px]"
      >
        <!-- Header with Edit Button -->
        <div class="flex items-center justify-between h-10">
          <div class="flex flex-col gap-1">
            <h3 class="font-nunitoSans font-medium text-black text-base leading-5">
              {{ selectedDepartment.name }}
            </h3>
            <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
              {{ selectedDepartment.code }}
            </p>
          </div>
          <button
            @click="handleEditDepartment"
            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg flex gap-2 items-center px-4 py-1 hover:bg-gray-50 transition-colors"
          >
            <img :src="icons.edit" alt="" class="w-4 h-4" />
            <span class="font-nunitoSans font-medium text-black text-sm leading-6">
              Sửa thông tin
            </span>
          </button>
        </div>

        <!-- Tab Navigation -->
        <div class="flex flex-col gap-3 flex-1">
          <div class="bg-[#f3f4f6] h-9 rounded-[14px] grid grid-cols-4 gap-0 p-[3px]">
            <button
              v-for="tab in tabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="activeTab === tab.id ? 'bg-white font-semibold' : 'font-medium'"
              class="font-nunitoSans text-black text-sm leading-6 text-center px-2 py-1 rounded-[14px] transition-all"
            >
              {{ tab.label }}
            </button>
          </div>

          <!-- Tab Content -->
          <div class="flex flex-col gap-6 flex-1">
            <!-- Overview Tab -->
            <div v-if="activeTab === 'overview'" class="flex flex-col gap-6">
              <!-- Department Info -->
              <div class="grid grid-cols-2 gap-4 h-12">
                <div class="flex flex-col gap-1">
                  <p class="font-nunitoSans font-medium text-[#4b5563] text-base leading-6">
                    Trưởng khoa
                  </p>
                  <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                    {{ selectedDepartment.head }}
                  </p>
                </div>
                <div class="flex flex-col gap-1">
                  <p class="font-nunitoSans font-medium text-[#4b5563] text-base leading-6">
                    Mô tả chức năng
                  </p>
                  <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                    {{ selectedDepartment.description }}
                  </p>
                </div>
              </div>

              <!-- Stats Cards -->
              <div class="grid grid-cols-3 gap-4 h-[94px]">
                <!-- Revenue Card -->
                <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-4 flex flex-col justify-center">
                  <div class="flex items-center justify-between h-[52px]">
                    <div class="flex flex-col gap-1">
                      <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
                        Doanh thu tháng này
                      </p>
                      <p class="font-nunitoSans font-medium text-[#5a9690] text-xl leading-5">
                        {{ formatCurrency(selectedDepartment.revenue) }}
                      </p>
                    </div>
                    <img :src="icons.revenue" alt="" class="w-8 h-8" />
                  </div>
                </div>

                <!-- Appointments Card -->
                <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-4 flex flex-col justify-center">
                  <div class="flex items-center justify-between h-[52px]">
                    <div class="flex flex-col gap-1">
                      <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
                        Tổng ca khám
                      </p>
                      <p class="font-nunitoSans font-medium text-[#2563eb] text-xl leading-5">
                        {{ selectedDepartment.appointments }}
                      </p>
                    </div>
                    <img :src="icons.appointments" alt="" class="w-8 h-8" />
                  </div>
                </div>

                <!-- Staff Card -->
                <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-4 flex flex-col justify-center">
                  <div class="flex items-center justify-between h-[52px]">
                    <div class="flex flex-col gap-1">
                      <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
                        Tổng nhân sự
                      </p>
                      <p class="font-nunitoSans font-medium text-[#9333ea] text-xl leading-5">
                        {{ selectedDepartment.totalStaff }}
                      </p>
                    </div>
                    <img :src="icons.staff" alt="" class="w-8 h-8" />
                  </div>
                </div>
              </div>
            </div>

            <!-- Staff Tab -->
            <div v-else-if="activeTab === 'staff'" class="flex flex-col gap-4">
              <!-- Header with count and add button -->
              <div class="flex items-center justify-between h-8">
                <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
                  Tổng: {{ selectedDepartment.staffList.length }} nhân viên
                </p>
                <button
                  @click="handleAddStaff"
                  class="bg-[#5a9690] flex gap-2 items-center justify-center px-3 py-1 rounded-lg hover:bg-[#4a7f79] transition-colors"
                >
                  <img :src="icons.addStaff" alt="" class="w-4 h-4" />
                  <span class="font-nunitoSans font-medium text-white text-base leading-6">
                    Thêm nhân sự
                  </span>
                </button>
              </div>

              <!-- Staff Table -->
              <div class="overflow-clip">
                <table class="w-full">
                  <thead>
                    <tr class="border-b border-[rgba(0,0,0,0.15)] h-10">
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-left px-2">
                        Nhân viên
                      </th>
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-left px-2">
                        Chức danh
                      </th>
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-left px-2">
                        Trạng thái
                      </th>
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-right px-2">
                        Thao tác
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="staff in selectedDepartment.staffList"
                      :key="staff.id"
                      class="border-b border-[rgba(0,0,0,0.15)] h-[57px]"
                    >
                      <!-- Employee Info -->
                      <td class="px-2">
                        <div class="flex gap-3 items-center">
                          <img
                            :src="staff.avatar"
                            alt=""
                            class="w-10 h-10 rounded-full object-cover"
                          />
                          <div class="flex flex-col">
                            <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                              {{ staff.name }}
                            </p>
                            <p class="font-nunitoSans font-medium text-[#6b7280] text-xs leading-5">
                              {{ staff.role }}
                            </p>
                          </div>
                        </div>
                      </td>

                      <!-- Position -->
                      <td class="px-2">
                        <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                          {{ staff.position }}
                        </p>
                      </td>

                      <!-- Status Badge -->
                      <td class="px-2">
                        <div class="bg-[#dcfce7] border border-transparent rounded-lg px-2 py-0 inline-block">
                          <p class="font-nunitoSans font-medium text-[#15803d] text-sm leading-6">
                            {{ staff.status }}
                          </p>
                        </div>
                      </td>

                      <!-- Actions -->
                      <td class="px-2">
                        <div class="flex gap-2 items-center justify-end">
                          <button
                            @click="handleTransferStaff(staff)"
                            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg flex gap-2 items-center px-2 py-1 hover:bg-gray-50 transition-colors"
                          >
                            <img :src="icons.transfer" alt="" class="w-4 h-4" />
                            <span class="font-nunitoSans font-medium text-black text-base leading-6">
                              Chuyển khoa
                            </span>
                          </button>
                          <button
                            @click="handleRemoveStaff(staff)"
                            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg flex gap-2 items-center px-2 py-2 hover:bg-gray-50 transition-colors"
                          >
                            <img :src="icons.remove" alt="" class="w-4 h-4" />
                            <span class="font-nunitoSans font-medium text-[#dc2626] text-base leading-4">
                              Gỡ
                            </span>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Services Tab -->
            <div v-else-if="activeTab === 'services'" class="flex flex-col gap-6">
              <!-- Header with count -->
              <div class="h-5">
                <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
                  Tổng: {{ selectedDepartment.services.length }} dịch vụ
                </p>
              </div>

              <!-- Services Table -->
              <div class="overflow-clip">
                <table class="w-full">
                  <thead>
                    <tr class="border-b border-[rgba(0,0,0,0.15)] h-10">
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-left px-2">
                        Tên dịch vụ
                      </th>
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-right px-2">
                        Giá
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="service in selectedDepartment.services"
                      :key="service.id"
                      class="border-b border-[rgba(0,0,0,0.15)] h-[37px]"
                    >
                      <!-- Service Name -->
                      <td class="px-2">
                        <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                          {{ service.name }}
                        </p>
                      </td>

                      <!-- Price -->
                      <td class="px-2 text-right">
                        <p class="font-nunitoSans font-semibold text-[#0d9488] text-sm leading-5">
                          {{ formatCurrency(service.price) }}
                        </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Rooms Tab (Placeholder) -->
            <div v-else class="flex flex-col gap-4">
              <!-- Header with count and add button -->
              <div class="flex items-center justify-between h-8">
                <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
                  Tổng: {{ selectedDepartment.rooms.length }} phòng
                </p>
                <button
                  @click="handleAddRoom"
                  class="bg-[#5a9690] flex gap-2 items-center justify-center px-3 py-1 rounded-lg hover:bg-[#4a7f79] transition-colors"
                >
                  <img :src="icons.plus" alt="" class="w-4 h-4" />
                  <span class="font-nunitoSans font-medium text-white text-base leading-6">
                    Thêm phòng
                  </span>
                </button>
              </div>

              <!-- Rooms Table -->
              <div class="overflow-clip">
                <table class="w-full">
                  <thead>
                    <tr class="border-b border-[rgba(0,0,0,0.15)] h-10">
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Tên phòng
                      </th>
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Loại
                      </th>
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Số giường
                      </th>
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Trạng thái
                      </th>
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Thao tác
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="room in selectedDepartment.rooms"
                      :key="room.id"
                      class="border-b border-[rgba(0,0,0,0.15)] h-[49px]"
                    >
                      <!-- Room Name -->
                      <td class="px-2">
                        <p class="font-nunitoSans font-normal text-[#111827] text-sm leading-5">
                          {{ room.name }}
                        </p>
                      </td>

                      <!-- Type Badge -->
                      <td class="px-2">
                        <div class="border border-[rgba(0,0,0,0.15)] rounded-lg px-2 py-0 inline-block">
                          <p class="font-nunitoSans font-medium text-black text-sm leading-6">
                            {{ room.type }}
                          </p>
                        </div>
                      </td>

                      <!-- Capacity -->
                      <td class="px-2">
                        <p class="font-nunitoSans font-medium text-black text-sm leading-5">
                          {{ room.capacity || '-' }}
                        </p>
                      </td>

                      <!-- Status Badge -->
                      <td class="px-2">
                        <div 
                          :class="room.status === 'Trống' ? 'bg-[#e5e7eb] text-[#4b5563]' : 'bg-[#dbeafe] text-[#2563eb]'"
                          class="border border-transparent rounded-lg px-2 py-0 inline-block"
                        >
                          <p class="font-nunitoSans font-medium text-sm leading-6">
                            {{ room.status }}
                          </p>
                        </div>
                      </td>

                      <!-- Actions -->
                      <td class="px-2">
                        <div class="flex gap-2 items-center">
                          <button
                            @click="handleEditRoom(room)"
                            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg w-[38px] h-8 flex items-center justify-center hover:bg-gray-50 transition-colors"
                          >
                            <img :src="icons.editIcon" alt="" class="w-4 h-4" />
                          </button>
                          <button
                            @click="handleDeleteRoom(room)"
                            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg w-[38px] h-8 flex items-center justify-center hover:bg-gray-50 transition-colors"
                          >
                            <img :src="icons.deleteIcon" alt="" class="w-4 h-4" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div 
        v-else
        class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-6 flex-1 flex items-center justify-center min-h-[330px]"
      >
        <p class="font-nunitoSans font-medium text-[#6b7280] text-base">
          Chọn một khoa từ danh sách để xem chi tiết
        </p>
      </div>
    </div>

    <!-- Bộ Phận Content -->
    <div v-else class="flex gap-6 items-start">
      <!-- Division List Sidebar -->
      <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-6 w-[266px] flex flex-col gap-8">
        <!-- Search and Add Section -->
        <div class="flex flex-col gap-3 w-[216px]">
          <h3 class="font-nunitoSans font-medium text-black text-base leading-6">
            Danh sách Bộ Phận
          </h3>

          <!-- Search Input -->
          <div class="relative h-9 w-full">
            <div class="absolute bg-[#f3f4f6] border border-transparent h-9 left-0 rounded-lg top-0 w-full">
              <input
                v-model="searchQueryDivision"
                type="text"
                placeholder="Tìm tên bộ phận..."
                class="font-nunitoSans font-medium text-[#6b7280] text-sm h-9 w-full pl-10 pr-3 py-1 bg-transparent border-none outline-none rounded-lg"
              />
            </div>
            <img :src="icons.search" alt="" class="absolute left-3 top-2.5 w-4 h-4" />
          </div>

          <!-- Add Division Button -->
          <button
            @click="handleAddDivision"
            class="bg-[#5a9690] flex gap-1.5 items-center justify-center px-14 py-1 rounded-lg w-full hover:bg-[#4a7f79] transition-colors"
          >
            <img :src="icons.plus" alt="" class="w-4 h-4" />
            <span class="font-nunitoSans font-medium text-white text-base leading-6">
              Thêm Bộ Phận
            </span>
          </button>
        </div>

        <!-- Division List -->
        <div class="flex flex-col h-[371px] overflow-y-auto w-full">
          <button
            v-for="div in filteredDivisions"
            :key="div.id"
            @click="selectDivision(div)"
            :class="selectedDivision?.id === div.id ? 'bg-[#f0fdfa] border-l-4 border-l-[#5a9690]' : 'border-b border-[rgba(0,0,0,0.15)]'"
            class="h-[93px] w-full relative transition-colors hover:bg-gray-50"
          >
            <div class="absolute flex flex-col gap-2 h-[60px] left-5 top-4 w-[228px]">
              <div class="flex h-9 items-start justify-between w-full">
                <div class="flex-1 flex flex-col items-start">
                  <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                    {{ div.name }}
                  </p>
                  <p class="font-nunitoSans font-medium text-[#6b7280] text-sm leading-5">
                    {{ div.code }}
                  </p>
                </div>
                <div class="bg-[#dcfce7] border border-transparent rounded-lg h-6 w-[30px] flex items-center justify-center">
                  <img :src="icons.checkCircle" alt="" class="w-4 h-4" />
                </div>
              </div>
              <div class="flex gap-3 h-4 w-full">
                <span class="font-nunitoSans font-medium text-[#4b5563] text-sm">
                  {{ div.receptionists }} LT
                </span>
                <span class="font-nunitoSans font-medium text-[#4b5563] text-sm">
                  {{ div.cashiers }}Thu ngân
                </span>
              </div>
            </div>
          </button>
        </div>
      </div>

      <!-- Division Details Card -->
      <div 
        v-if="selectedDivision"
        class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-6 flex-1 flex flex-col gap-8 min-h-[330px]"
      >
        <!-- Header with Edit Button -->
        <div class="flex items-center justify-between h-10">
          <div class="flex flex-col gap-1">
            <h3 class="font-nunitoSans font-medium text-black text-base leading-5">
              {{ selectedDivision.name }}
            </h3>
            <p class="font-nunitoSans font-medium text-[#6b7280] text-sm leading-5">
              {{ selectedDivision.code }}
            </p>
          </div>
          <button
            @click="handleEditDivision"
            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg flex gap-2 items-center px-4 py-1 hover:bg-gray-50 transition-colors"
          >
            <img :src="icons.edit" alt="" class="w-4 h-4" />
            <span class="font-nunitoSans font-medium text-black text-sm leading-6">
              Sửa thông tin
            </span>
          </button>
        </div>

        <!-- Tab Navigation -->
        <div class="flex flex-col gap-2 flex-1">
          <div class="bg-[#f3f4f6] h-9 rounded-[14px] grid grid-cols-3 gap-0 p-[3px]">
            <button
              v-for="tab in divisionTabs"
              :key="tab.id"
              @click="activeTab = tab.id"
              :class="activeTab === tab.id ? 'bg-white font-semibold' : 'font-medium'"
              class="font-nunitoSans text-black text-sm leading-5 text-center px-2 py-1 rounded-[14px] transition-all"
            >
              {{ tab.label }}
            </button>
          </div>

          <!-- Tab Content -->
          <div class="flex flex-col gap-6 flex-1">
            <!-- Overview Tab for Division -->
            <div v-if="activeTab === 'overview'" class="flex flex-col gap-6">
              <!-- Manager Info Card -->
              <div class="bg-[#f3f4f6] rounded-[10px] p-4 flex flex-col gap-4 h-[160px]">
                <!-- Manager Section -->
                <div class="flex gap-4 h-16 items-center">
                  <div class="bg-[#ccfbf1] rounded-full w-16 h-16 flex items-center justify-center">
                    <img :src="icons.manager" alt="" class="w-8 h-8" />
                  </div>
                  <div class="flex-1 flex flex-col gap-1">
                    <p class="font-nunitoSans font-semibold text-[#6b7280] text-base leading-5">
                      Người quản lý
                    </p>
                    <p class="font-nunitoSans font-medium text-black text-sm leading-7">
                      {{ selectedDivision.manager }}
                    </p>
                  </div>
                </div>

                <!-- Description Section -->
                <div class="flex flex-col gap-1 h-12">
                  <p class="font-nunitoSans font-semibold text-[#6b7280] text-base leading-5">
                    Mô tả chức năng
                  </p>
                  <p class="font-nunitoSans font-medium text-black text-sm leading-6">
                    {{ selectedDivision.description }}
                  </p>
                </div>
              </div>

              <!-- Total Staff Card -->
              <div class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-4 h-[94px] flex items-center">
                <div class="flex items-center justify-between w-full">
                  <div class="flex flex-col gap-1">
                    <p class="font-nunitoSans font-medium text-[#6b7280] text-sm leading-5">
                      Tổng nhân sự
                    </p>
                    <p class="font-nunitoSans font-medium text-[#9333ea] text-xl leading-7">
                      {{ selectedDivision.totalStaff }}
                    </p>
                  </div>
                  <img :src="icons.manager" alt="" class="w-8 h-8" />
                </div>
              </div>
            </div>

            <!-- Staff Tab for Division -->
            <div v-else-if="activeTab === 'staff'" class="flex flex-col gap-4">
              <div class="flex items-center justify-between h-8">
                <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
                  Tổng: {{ selectedDivision.staffList.length }} nhân viên
                </p>
                <button
                  @click="handleAddStaff"
                  class="bg-[#5a9690] flex gap-2 items-center justify-center px-3 py-1 rounded-lg hover:bg-[#4a7f79] transition-colors"
                >
                  <img :src="icons.addStaff" alt="" class="w-4 h-4" />
                  <span class="font-nunitoSans font-medium text-white text-base leading-6">
                    Thêm nhân sự
                  </span>
                </button>
              </div>

              <!-- Staff Table (same as departments) -->
              <div class="overflow-clip">
                <table class="w-full"> 
                  <thead>
                    <tr class="border-b border-[rgba(0,0,0,0.15)] h-10">
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-left px-2">
                        Nhân viên
                      </th>
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-left px-2">
                        Chức danh
                      </th>
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-left px-2">
                        Trạng thái
                      </th>
                      <th class="font-nunitoSans font-medium text-black text-sm leading-6 text-right px-2">
                        Thao tác
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="staff in selectedDivision.staffList"
                      :key="staff.id"
                      class="border-b border-[rgba(0,0,0,0.15)] h-[57px]"
                    >
                      <td class="px-2">
                        <div class="flex gap-3 items-center">
                          <img
                            :src="staff.avatar"
                            alt=""
                            class="w-10 h-10 rounded-full object-cover"
                          />
                          <div class="flex flex-col">
                            <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                              {{ staff.name }}
                            </p>
                            <p class="font-nunitoSans font-medium text-[#6b7280] text-xs leading-5">
                              {{ staff.role }}
                            </p>
                          </div>
                        </div>
                      </td>
                      <td class="px-2">
                        <p class="font-nunitoSans font-medium text-[#111827] text-sm leading-5">
                          {{ staff.position }}
                        </p>
                      </td>
                      <td class="px-2">
                        <div class="bg-[#dcfce7] border border-transparent rounded-lg px-2 py-0 inline-block">
                          <p class="font-nunitoSans font-medium text-[#15803d] text-sm leading-6">
                            {{ staff.status }}
                          </p>
                        </div>
                      </td>
                      <td class="px-2">
                        <div class="flex gap-2 items-center justify-end">
                          <button
                            @click="handleTransferStaff(staff)"
                            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg flex gap-2 items-center px-2 py-1 hover:bg-gray-50 transition-colors"
                          >
                            <img :src="icons.transfer" alt="" class="w-4 h-4" />
                            <span class="font-nunitoSans font-medium text-black text-base leading-6">
                              Chuyển bộ phận
                            </span>
                          </button>
                          <button
                            @click="handleRemoveStaff(staff)"
                            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg flex gap-2 items-center px-2 py-2 hover:bg-gray-50 transition-colors"
                          >
                            <img :src="icons.remove" alt="" class="w-4 h-4" />
                            <span class="font-nunitoSans font-medium text-[#dc2626] text-base leading-4">
                              Gỡ
                            </span>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Workrooms Tab -->
            <div v-else class="flex flex-col gap-4">
              <div class="flex items-center justify-between h-8">
                <p class="font-nunitoSans font-medium text-[#4b5563] text-sm leading-5">
                  Tổng: {{ selectedDivision.rooms.length }} phòng
                </p>
                <button
                  @click="handleAddRoom"
                  class="bg-[#5a9690] flex gap-2 items-center justify-center px-3 py-1 rounded-lg hover:bg-[#4a7f79] transition-colors"
                >
                  <img :src="icons.plus" alt="" class="w-4 h-4" />
                  <span class="font-nunitoSans font-medium text-white text-base leading-6">
                    Thêm phòng
                  </span>
                </button>
              </div>

              <!-- Workrooms table for divisions -->
              <div class="overflow-clip">
                <table class="w-full">
                  <thead>
                    <tr class="border-b border-[rgba(0,0,0,0.15)] h-10">
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Tên phòng
                      </th>
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Loại
                      </th>
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Sức chứa
                      </th>
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Trạng thái
                      </th>
                      <th class="font-nunitoSans font-semibold text-black text-sm leading-5 text-left px-2">
                        Thao tác
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="room in selectedDivision.rooms"
                      :key="room.id"
                      class="border-b border-[rgba(0,0,0,0.15)] h-[49px]"
                    >
                      <td class="px-2">
                        <p class="font-nunitoSans font-normal text-[#111827] text-sm leading-5">
                          {{ room.name }}
                        </p>
                      </td>
                      <td class="px-2">
                        <div class="border border-[rgba(0,0,0,0.15)] rounded-lg px-2 py-0 inline-block">
                          <p class="font-nunitoSans font-medium text-black text-sm leading-6">
                            {{ room.type }}
                          </p>
                        </div>
                      </td>
                      <td class="px-2">
                        <p class="font-nunitoSans font-medium text-black text-sm leading-5">
                          {{ room.capacity || '-' }}
                        </p>
                      </td>
                      <td class="px-2">
                        <div 
                          :class="room.status === 'Trống' ? 'bg-[#e5e7eb] text-[#4b5563]' : 'bg-[#dbeafe] text-[#2563eb]'"
                          class="border border-transparent rounded-lg px-2 py-0 inline-block"
                        >
                          <p class="font-nunitoSans font-medium text-sm leading-6">
                            {{ room.status }}
                          </p>
                        </div>
                      </td>
                      <td class="px-2">
                        <div class="flex gap-2 items-center">
                          <button
                            @click="handleEditRoom(room)"
                            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg w-[38px] h-8 flex items-center justify-center hover:bg-gray-50 transition-colors"
                          >
                            <img :src="icons.editIcon" alt="" class="w-4 h-4" />
                          </button>
                          <button
                            @click="handleDeleteRoom(room)"
                            class="bg-white border border-[rgba(0,0,0,0.15)] rounded-lg w-[38px] h-8 flex items-center justify-center hover:bg-gray-50 transition-colors"
                          >
                            <img :src="icons.deleteIcon" alt="" class="w-4 h-4" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State for Divisions -->
      <div 
        v-else
        class="bg-white border border-[rgba(0,0,0,0.15)] rounded-[14px] p-6 flex-1 flex items-center justify-center min-h-[330px]"
      >
        <p class="font-nunitoSans font-medium text-[#6b7280] text-base">
          Chọn một bộ phận từ danh sách để xem chi tiết
        </p>
      </div>
    </div>

    <!-- Add Department Modal -->
    <div v-if="isAddModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <ThemKhoa @close="isAddModalOpen = false" @submit="handleSubmitAddModal" />
    </div>

    <!-- Edit Department Modal -->
    <div v-if="isEditModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <CapNhatThongTinKhoa 
        :department="selectedDepartment"
        @close="isEditModalOpen = false" 
        @submit="handleSubmitEditModal"
        @selectHead="handleSelectHeadForEdit"
      />
    </div>
    <!-- Add Staff Modal -->
    <div v-if="isAddStaffModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <ThemNhanSu 
        :available-employees="availableEmployees"
        @close="isAddStaffModalOpen = false" 
        @submit="handleSubmitAddStaff"
        @selectEmployee="handleSelectEmployeeForAdd"
        @selectPosition="handleSelectPositionForAdd"
      />
    </div>
    <!-- Transfer Staff Modal -->
    <div v-if="isTransferModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <ChuyenKhoa 
        :staff="selectedStaffForTransfer"
        :current-department-id="selectedDepartment.id"
        :available-departments="departments"
        @close="isTransferModalOpen = false" 
        @submit="handleSubmitTransfer"
        @selectDepartment="handleSelectDepartmentForTransfer"
      />
    </div>

    <!-- Add Room Modal -->
    <div v-if="isAddRoomModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <ThemPhong 
        @close="isAddRoomModalOpen = false" 
        @submit="handleSubmitAddRoom"
        @selectRoomType="handleSelectRoomTypeForAdd"
      />
    </div>

    <!-- Edit Room Modal -->
    <div v-if="isEditRoomModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <CapNhatPhong 
        :room="selectedRoomForEdit"
        @close="isEditRoomModalOpen = false" 
        @submit="handleSubmitEditRoom"
        @selectRoomType="handleSelectRoomTypeForEdit"
      />
    </div>

    <!-- Remove Staff Modal -->
    <XoaNhanSu
      v-if="isRemoveStaffModalOpen"
      :modal-type="removeStaffModalType"
      :staff="selectedStaffForRemove"
      :appointment-count="staffAppointmentCount"
      :department-name="selectedDepartment ? selectedDepartment.name : ''"
      @close="isRemoveStaffModalOpen = false"
      @confirm="handleSubmitRemoveStaff"
    />

    <!-- Delete Room Modal -->
    <XoaPhong
      v-if="isDeleteRoomModalOpen"
      :modal-type="deleteRoomModalType"
      :room="selectedRoomForDelete"
      @close="isDeleteRoomModalOpen = false"
      @confirm="handleSubmitDeleteRoom"
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ThemKhoa from './ThemKhoa/index.vue';
import CapNhatThongTinKhoa from './CapNhatThongTinKhoa/index.vue';
import ThemNhanSu from './ThemNhanSu/index.vue';
import ChuyenKhoa from './ChuyenKhoa/index.vue';
import ThemPhong from './ThemPhong/index.vue';
import CapNhatPhong from './CapNhatPhong/index.vue';
import XoaNhanSu from './XoaNhanSu/index.vue';
import XoaPhong from './XoaPhong/index.vue';

// Icons from Figma
const icons = {
  search: "https://www.figma.com/api/mcp/asset/4fab7871-7ecc-4b6e-add9-7a0b40d950bc",
  plus: "https://www.figma.com/api/mcp/asset/7518cdac-68ba-43e5-ba24-ff537964b3e9",
  checkCircle: "https://www.figma.com/api/mcp/asset/117aef47-e2f3-4281-b270-66798120ca13",
  edit: "https://www.figma.com/api/mcp/asset/343e3db2-b9ce-415e-a735-ac8e6088a235",
  revenue: "https://www.figma.com/api/mcp/asset/a0e30a54-c2d0-48c6-9400-932b8730692e",
  appointments: "https://www.figma.com/api/mcp/asset/f71d2fc9-d758-4f5d-b232-35a65250cf64",
  staff: "https://www.figma.com/api/mcp/asset/3e8700dd-879a-4f0f-a824-bdd60cd761f4",
  transfer: "https://www.figma.com/api/mcp/asset/dc51c3b9-efd7-4beb-bcec-de9eb29014ca",
  remove: "https://www.figma.com/api/mcp/asset/82fdbee3-1eb4-4d9d-9339-ec7a27f2d1ea",
  addStaff: "https://www.figma.com/api/mcp/asset/1e1878c6-a905-46f2-bbb0-a75fc9688942",
  editIcon: "https://www.figma.com/api/mcp/asset/d279377b-bfd7-408a-b3ec-2dd012a7d367",
  deleteIcon: "https://www.figma.com/api/mcp/asset/027e3e06-0f8c-41ac-89a0-d3cb6dbec038",
  viewIcon: "https://www.figma.com/api/mcp/asset/48f8ca01-f363-444c-95fd-7be95f28d632",
  manager: "https://www.figma.com/api/mcp/asset/6cd4c824-db31-4709-aa56-bab7b66ceb59",
  avatarNguyenThiX: "https://www.figma.com/api/mcp/asset/dfda8b11-52f1-43ea-9c8a-ecdbdc06451a",
  avatarTranThuHa: "https://www.figma.com/api/mcp/asset/d9a3445e-946b-4d81-b144-2d1ace2cc963",
  avatarLeVanMinh: "https://www.figma.com/api/mcp/asset/f169b54c-d1b1-4d9e-8b57-e72d2a70d185"
};

// State
const activeMainTab = ref('khoa');
const activeTab = ref('overview');
const searchQuery = ref('');
const searchQueryDivision = ref('');
const selectedDepartment = ref(null);
const selectedDivision = ref(null);
const isAddModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isAddStaffModalOpen = ref(false);
const isTransferModalOpen = ref(false);
const selectedStaffForTransfer = ref(null);
const isAddRoomModalOpen = ref(false);
const isEditRoomModalOpen = ref(false);
const selectedRoomForEdit = ref(null);
const isRemoveStaffModalOpen = ref(false);
const selectedStaffForRemove = ref(null);
const removeStaffModalType = ref('confirm'); // 'error' or 'confirm'
const staffAppointmentCount = ref(0);
const isDeleteRoomModalOpen = ref(false);
const selectedRoomForDelete = ref(null);
const deleteRoomModalType = ref('confirm'); // 'error' or 'confirm'

// Mock available employees for adding to department
const availableEmployees = ref([
  { id: 101, name: 'BS. Phạm Văn F', role: 'Bác sĩ' },
  { id: 102, name: 'Y tá Nguyễn Thị G', role: 'Y tá' },
  { id: 103, name: 'KTV Trần Văn H', role: 'Kỹ thuật viên' }
]);

// Tabs for department detail view
const tabs = [
  { id: 'overview', label: 'Tổng quan' },
  { id: 'staff', label: 'Nhân sự & Biên chế' },
  { id: 'services', label: 'Dịch vụ' },
  { id: 'rooms', label: 'Phòng & Chuồng' }
];

// Tabs for division detail view (only 3 tabs)
const divisionTabs = [
  { id: 'overview', label: 'Tổng quan' },
  { id: 'staff', label: 'Nhân sự & Biên chế' },
  { id: 'workrooms', label: 'Phòng làm việc' }
];

// Mock divisions data (Bộ Phận)
const divisions = ref([
  {
    id: 1,
    name: 'Bộ phận Hành Chính',
    code: 'BP-01',
    receptionists: 2,
    cashiers: 1,
    manager: 'Nguyễn Thị X',
    description: 'Quản lý bộ phận hành chính như Lễ Tân, Thu Ngân',
    totalStaff: 3,
    staffList: [
      {
        id: 1,
        name: 'Nguyễn Thị X',
        role: 'Lễ tân',
        position: 'Trưởng bộ phận',
        status: 'Đang trực',
        avatar: icons.avatarNguyenThiX
      },
      {
        id: 2,
        name: 'Trần Thu Hà',
        role: 'Thu ngân',
        position: 'Thu ngân trưởng',
        status: 'Đang trực',
        avatar: icons.avatarTranThuHa
      },
      {
        id: 3,
        name: 'Lê Văn Minh',
        role: 'Lễ tân',
        position: 'Lễ tân',
        status: 'Đang trực',
        avatar: icons.avatarLeVanMinh
      }
    ],
    rooms: [
      { id: 1, name: 'Phòng Họp 1', type: 'Văn Phòng', capacity: '10 người', status: 'Trống' },
      { id: 2, name: 'Phòng Phỏng Vấn', type: 'Văn Phòng', capacity: '4 người', status: 'Đang sử dụng' }
    ]
  },
  {
    id: 2,
    name: 'Bộ phận Kỹ thuật',
    code: 'BP-02',
    receptionists: 0,
    cashiers: 0,
    manager: 'Trần Văn Y',
    description: 'Bảo trì thiết bị và hệ thống kỹ thuật',
    totalStaff: 4,
    staffList: [],
    rooms: []
  }
]);

// Mock departments data
const departments = ref([
  {
    id: 1,
    name: 'Khoa Lâm Sàng',
    code: 'KHOA-01',
    doctors: 3,
    nurses: 2,
    head: 'BS. Nguyễn Văn A',
    description: 'Chuyên khám và điều trị bệnh nội khoa cho thú cưng',
    revenue: 45000000,
    appointments: 156,
    totalStaff: 5,
    staffList: [
      {
        id: 1,
        name: 'BS. Nguyễn Văn A',
        role: 'Bác sĩ',
        position: 'Trưởng khoa',
        status: 'Đang trực',
        avatar: 'https://www.figma.com/api/mcp/asset/3fb75028-8370-435f-944e-32fc76620650'
      },
      {
        id: 2,
        name: 'Y tá Lê Thị C',
        role: 'Y tá',
        position: 'Điều dưỡng trưởng',
        status: 'Đang trực',
        avatar: 'https://www.figma.com/api/mcp/asset/0b5fc44c-e362-49f0-9d97-2a01aa950417'
      },
      {
        id: 3,
        name: 'BS. Hoàng Văn E',
        role: 'Bác sĩ',
        position: 'Bác sĩ chính',
        status: 'Đang trực',
        avatar: 'https://www.figma.com/api/mcp/asset/f5dfd8af-e416-4afd-a85d-a6fccfa6896a'
      }
    ],
    services: [
      { id: 1, name: 'Khám tổng quát', price: 200000 },
      { id: 2, name: 'Tiêm phòng dại (Rabies)', price: 150000 }
    ],
    rooms: [
      { id: 1, name: 'Phòng Khám 01', type: 'Phòng khám', beds: null, status: 'Trống' },
      { id: 2, name: 'Phòng Khám 02', type: 'Phòng khám', beds: null, status: 'Đang sử dụng' }
    ]
  },
  {
    id: 2,
    name: 'Khoa Ngoại',
    code: 'KHOA-02',
    doctors: 2,
    nurses: 3,
    head: 'BS. Trần Thị B',
    description: 'Phẫu thuật và điều trị ngoại khoa',
    revenue: 38000000,
    appointments: 98,
    totalStaff: 5,
    staffList: [],
    services: [],
    rooms: []
  },
  {
    id: 3,
    name: 'Khoa Chẩn đoán hình ảnh',
    code: 'KHOA-CDHA',
    doctors: 2,
    nurses: 1,
    head: 'BS. Lê Văn C',
    description: 'X-quang, siêu âm và chẩn đoán hình ảnh',
    revenue: 22000000,
    appointments: 67,
    totalStaff: 3,
    staffList: [],
    services: [],
    rooms: []
  },
  {
    id: 4,
    name: 'Khoa Spa & Grooming',
    code: 'KHOA-VH',
    doctors: 0,
    nurses: 4,
    head: 'Phan Thị D',
    description: 'Spa, grooming và chăm sóc thú cưng',
    revenue: 15000000,
    appointments: 234,
    totalStaff: 4,
    staffList: [],
    services: [],
    rooms: []
  }
]);

// Computed
const filteredDepartments = computed(() => {
  if (!searchQuery.value) return departments.value;
  
  const query = searchQuery.value.toLowerCase();
  return departments.value.filter(dept => 
    dept.name.toLowerCase().includes(query) ||
    dept.code.toLowerCase().includes(query)
  );
});

const filteredDivisions = computed(() => {
  if (!searchQueryDivision.value) return divisions.value;
  
  const query = searchQueryDivision.value.toLowerCase();
  return divisions.value.filter(div => 
    div.name.toLowerCase().includes(query) ||
    div.code.toLowerCase().includes(query)
  );
});

// Methods
const selectDepartment = (dept) => {
  selectedDepartment.value = dept;
  activeTab.value = 'overview'; // Reset to overview tab
};

const selectDivision = (div) => {
  selectedDivision.value = div;
  activeTab.value = 'overview'; // Reset to overview tab
};

const handleAddDepartment = () => {
  isAddModalOpen.value = true;
};

const handleSubmitAddModal = (data) => {
  // Add logic to add to departments list
  const newId = departments.value.length + 1;
  departments.value.push({
    id: newId,
    name: data.name,
    code: data.code,
    doctors: 0,
    nurses: 0,
    head: 'Chưa có',
    description: data.description,
    revenue: 0,
    appointments: 0,
    totalStaff: 0,
    staffList: [],
    services: [],
    rooms: []
  });
  isAddModalOpen.value = false;
};

const handleAddDivision = () => {
  console.log('Add division');
  // Implement add division modal/form
};

const handleEditDepartment = () => {
  isEditModalOpen.value = true;
};

const handleSubmitEditModal = (data) => {
  if (selectedDepartment.value) {
    selectedDepartment.value.description = data.description;
    selectedDepartment.value.head = data.head;
    
    // Also update in the main list
    const index = departments.value.findIndex(d => d.id === selectedDepartment.value.id);
    if (index !== -1) {
      departments.value[index] = { ...selectedDepartment.value };
    }
  }
  isEditModalOpen.value = false;
};

const handleSelectHeadForEdit = () => {
  console.log('Select head for edit');
  // Implement staff selection logic
};

const handleEditDivision = () => {
  console.log('Edit division:', selectedDivision.value);
  // Implement edit division modal/form
};

const handleAddStaff = () => {
  isAddStaffModalOpen.value = true;
};

const handleSubmitAddStaff = (data) => {
  if (selectedDepartment.value) {
    const employee = availableEmployees.value.find(e => e.id === data.employeeId);
    if (employee) {
      const newStaff = {
        id: employee.id,
        name: employee.name,
        role: employee.role,
        position: data.position,
        status: 'Đang trực',
        avatar: 'https://www.figma.com/api/mcp/asset/dfda8b11-52f1-43ea-9c8a-ecdbdc06451a' // Placeholder avatar
      };
      
      // Add to department staff list
      if (!selectedDepartment.value.staffList) {
        selectedDepartment.value.staffList = [];
      }
      selectedDepartment.value.staffList.push(newStaff);
      
      // Update counts
      selectedDepartment.value.totalStaff++;
      if (employee.role === 'Bác sĩ') selectedDepartment.value.doctors++;
      if (employee.role === 'Y tá') selectedDepartment.value.nurses++;
    }
  }
  isAddStaffModalOpen.value = false;
};

const handleSelectEmployeeForAdd = (callback) => {
  // In a real app, this would open another modal to select an employee
  // For now, we'll just pick the first available one for demonstration
  // or simulate a selection
  const employee = availableEmployees.value[0];
  if (employee && callback) {
    callback(employee);
  }
};

const handleSelectPositionForAdd = (callback) => {
  // In a real app, this would open a dropdown or modal
  // For now, we'll just pass a default value
  if (callback) {
    callback('Bác sĩ chính');
  }
};



const handleTransferStaff = (staff) => {
  selectedStaffForTransfer.value = staff;
  isTransferModalOpen.value = true;
};

const handleSubmitTransfer = (data) => {
  // Find source and target departments
  const sourceDept = departments.value.find(d => d.id === data.fromDepartmentId);
  const targetDept = departments.value.find(d => d.id === data.toDepartmentId);
  
  if (sourceDept && targetDept) {
    // Find staff in source
    const staffIndex = sourceDept.staffList.findIndex(s => s.id === data.staffId);
    if (staffIndex !== -1) {
      const staff = sourceDept.staffList[staffIndex];
      
      // Remove from source
      sourceDept.staffList.splice(staffIndex, 1);
      sourceDept.totalStaff--;
      if (staff.role === 'Bác sĩ') sourceDept.doctors--;
      if (staff.role === 'Y tá') sourceDept.nurses--;
      
      // Add to target
      if (!targetDept.staffList) targetDept.staffList = [];
      targetDept.staffList.push(staff);
      targetDept.totalStaff++;
      if (staff.role === 'Bác sĩ') targetDept.doctors++;
      if (staff.role === 'Y tá') targetDept.nurses++;
    }
  }
  isTransferModalOpen.value = false;
};

const handleSelectDepartmentForTransfer = (availableDepts, callback) => {
  // In a real app, this would open a modal to select a department
  // For now, we'll just pick the first available one that isn't the current one
  if (availableDepts.length > 0 && callback) {
    callback(availableDepts[0]);
  }
};

const handleRemoveStaff = (staff) => {
  selectedStaffForRemove.value = staff;
  
  // Mock logic to determine if staff has pending appointments
  // For demonstration, let's say staff with ID divisible by 3 has pending appointments
  const pendingAppointments = staff.id % 3 === 0 ? Math.floor(Math.random() * 5) + 1 : 0;
  
  if (pendingAppointments > 0) {
    removeStaffModalType.value = 'error';
    staffAppointmentCount.value = pendingAppointments;
  } else {
    removeStaffModalType.value = 'confirm';
    staffAppointmentCount.value = 0;
  }
  
  isRemoveStaffModalOpen.value = true;
};

const handleSubmitRemoveStaff = () => {
  if (selectedDepartment.value && selectedStaffForRemove.value) {
    const index = selectedDepartment.value.staffList.findIndex(s => s.id === selectedStaffForRemove.value.id);
    if (index !== -1) {
      const staff = selectedDepartment.value.staffList[index];
      
      // Remove from list
      selectedDepartment.value.staffList.splice(index, 1);
      
      // Update counts
      selectedDepartment.value.totalStaff--;
      if (staff.role === 'Bác sĩ') selectedDepartment.value.doctors--;
      if (staff.role === 'Y tá') selectedDepartment.value.nurses--;
    }
  }
  isRemoveStaffModalOpen.value = false;
};
const handleAddRoom = () => {
  isAddRoomModalOpen.value = true;
};

const handleSubmitAddRoom = (data) => {
  if (selectedDepartment.value) {
    const newRoom = {
      id: Date.now(), // Generate a temporary unique ID
      name: data.name,
      type: data.type,
      capacity: null, // Default or can be added to form
      status: 'Trống'
    };
    
    if (!selectedDepartment.value.rooms) {
      selectedDepartment.value.rooms = [];
    }
    selectedDepartment.value.rooms.push(newRoom);
  }
  isAddRoomModalOpen.value = false;
};

const handleSelectRoomTypeForAdd = (types, callback) => {
  // In a real app, this would open a modal to select a room type
  // For now, we'll just pick the first one
  if (types.length > 0 && callback) {
    callback(types[0]);
  }
};

const handleEditRoom = (room) => {
  selectedRoomForEdit.value = room;
  isEditRoomModalOpen.value = true;
};

const handleSubmitEditRoom = (data) => {
  if (selectedDepartment.value && selectedDepartment.value.rooms) {
    const index = selectedDepartment.value.rooms.findIndex(r => r.id === data.id);
    if (index !== -1) {
      selectedDepartment.value.rooms[index] = {
        ...selectedDepartment.value.rooms[index],
        name: data.name,
        type: data.type,
        beds: data.beds,
        capacity: data.beds ? `${data.beds} giường` : null
      };
    }
  }
  isEditRoomModalOpen.value = false;
};

const handleSelectRoomTypeForEdit = (types, callback) => {
  // Reuse the same logic as adding room
  if (types.length > 0 && callback) {
    callback(types[0]);
  }
};

const handleDeleteRoom = (room) => {
  selectedRoomForDelete.value = room;
  
  // Mock logic to determine if room is in use
  // For demonstration, let's say room with status 'Đang sử dụng' cannot be deleted
  // Or randomly for demo purposes if status is not explicitly set
  const isInUse = room.status === 'Đang sử dụng' || (room.id % 2 === 0);
  
  if (isInUse) {
    deleteRoomModalType.value = 'error';
  } else {
    deleteRoomModalType.value = 'confirm';
  }
  
  isDeleteRoomModalOpen.value = true;
};

const handleSubmitDeleteRoom = () => {
  if (selectedDepartment.value && selectedDepartment.value.rooms && selectedRoomForDelete.value) {
    const index = selectedDepartment.value.rooms.findIndex(r => r.id === selectedRoomForDelete.value.id);
    if (index !== -1) {
      selectedDepartment.value.rooms.splice(index, 1);
    }
  }
  isDeleteRoomModalOpen.value = false;
};

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(amount);
};

// Auto-select first department on mount
if (departments.value.length > 0) {
  selectedDepartment.value = departments.value[0];
}

// Auto-select first division on mount
if (divisions.value.length > 0) {
  selectedDivision.value = divisions.value[0];
}
</script>

<style scoped>
/* Custom scrollbar for department list */
.overflow-y-auto::-webkit-scrollbar {
  width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f3f4f6;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}
</style>
