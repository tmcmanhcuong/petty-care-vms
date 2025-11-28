<template>
  <div
    class="bg-[#2f5755] flex flex-col items-start h-full w-64"
    data-name="Sidebar"
  >
    <!-- Header Section with Logo -->
    <div
      class="border-b border-[#0f766e] h-[93px] w-64"
      data-name="Container"
    >
      <div class="flex flex-col h-[93px] items-start px-6 pt-6 pb-px">
        <div class="flex gap-4 h-11 items-center w-full">
          <!-- Logo -->
          <div class="bg-white rounded-[10px] w-10 h-10 flex items-center justify-center">
            <img
              :src="logoIcon"
              alt="Petty Logo"
              class="w-8 h-8"
            />
          </div>
          
          <!-- Title Container -->
          <div class="h-11 flex flex-col items-start">
            <h1 class="font-nunitoSans font-medium text-white text-xl leading-6">
              Petty Admin
            </h1>
            <p class="font-nunitoSans font-medium text-[#5eead4] text-xs leading-6">
              Quản trị hệ thống
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Section -->
    <div class="flex-1 w-64 min-h-0 pt-4" data-simplebar>
      <!-- Dashboard - Active -->
      <router-link
        to="/admin/dashboard"
        class="flex h-12 items-center justify-between pl-6 pr-[120px] cursor-pointer transition-colors"
        :class="activeItem === 'dashboard' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:bg-[#3a6664]'"
        @click="navigateTo('dashboard')"
      >
        <div class="flex gap-3 items-center">
          <img :src="dashboardIcon" alt="" class="w-5 h-5" />
          <span class="font-nunitoSans font-semibold text-white text-base">
            Dashboard
          </span>
        </div>
      </router-link>

      <!-- Tài nguyên -->
      <div
        class="flex h-12 items-center justify-between px-6 cursor-pointer hover:bg-[#3a6664] transition-colors"
        :class="{ 'bg-[#3a6664]': openSubmenus.taiNguyen }"
        @click="toggleSubmenu('taiNguyen')"
      >
        <div class="flex gap-3 items-center">
          <img :src="resourceIcon" alt="" class="w-5 h-5" />
          <span class="font-nunitoSans font-medium text-white text-base">
            Tài nguyên
          </span>
        </div>
        <button 
          class="w-4 h-4 transition-transform duration-200"
          :class="{ 'rotate-180': openSubmenus.taiNguyen }"
        >
          <img :src="chevronIcon" alt="" class="w-full h-full" />
        </button>
      </div>

      <!-- Submenu Tài nguyên -->
      <div v-show="openSubmenus.taiNguyen" class="flex flex-col bg-[#264a48] w-full transition-all duration-300 ease-in-out">
        <router-link 
          to="/admin/quan-ly-khoa"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'quanLyKhoa' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('quanLyKhoa')"
        >
          <span class="font-nunitoSans font-medium text-sm">Quản lý Khoa</span>
        </router-link>
        <router-link 
          to="/admin/quan-ly-dich-vu"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'quanLyDichVu' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('quanLyDichVu')"
        >
          <span class="font-nunitoSans font-medium text-sm">Quản lý Dịch vụ</span>
        </router-link>
        <router-link 
          to="/admin/kho-thuoc-vat-tu"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'khoThuocVatTu' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('khoThuocVatTu')"
        >
          <span class="font-nunitoSans font-medium text-sm">Kho thuốc & Vật tư</span>
        </router-link>
      </div>

      <!-- Nhân sự -->
      <div
        class="flex h-12 items-center justify-between px-6 cursor-pointer hover:bg-[#3a6664] transition-colors"
        :class="{ 'bg-[#3a6664]': openSubmenus.nhanSu }"
        @click="toggleSubmenu('nhanSu')"
      >
        <div class="flex gap-3 items-center">
          <img :src="staffIcon" alt="" class="w-5 h-5" />
          <span class="font-nunitoSans font-medium text-white text-base">
            Nhân sự
          </span>
        </div>
        <button 
          class="w-4 h-4 transition-transform duration-200"
          :class="{ 'rotate-180': openSubmenus.nhanSu }"
        >
          <img :src="chevronIcon" alt="" class="w-full h-full" />
        </button>
      </div>

      <!-- Submenu Nhân sự -->
      <div v-show="openSubmenus.nhanSu" class="flex flex-col bg-[#264a48] w-full transition-all duration-300 ease-in-out">
        <router-link 
          to="/admin/tai-khoan"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'nhanSu_Item1' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('nhanSu_Item1')"
        >
          <span class="font-nunitoSans font-medium text-sm">Tài Khoản</span>
        </router-link>
        <router-link 
          to="/admin/lich-lam-viec"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'nhanSu_Item2' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('nhanSu_Item2')"
        >
          <span class="font-nunitoSans font-medium text-sm">Lịch Làm Việc</span>
        </router-link>
      </div>

      <!-- Vận hành -->
      <div
        class="flex h-12 items-center justify-between px-6 cursor-pointer hover:bg-[#3a6664] transition-colors"
        :class="{ 'bg-[#3a6664]': openSubmenus.vanHanh }"
        @click="toggleSubmenu('vanHanh')"
      >
        <div class="flex gap-3 items-center">
          <img :src="operationIcon" alt="" class="w-5 h-5" />
          <span class="font-nunitoSans font-medium text-white text-base">
            Vận hành
          </span>
        </div>
        <button 
          class="w-4 h-4 transition-transform duration-200"
          :class="{ 'rotate-180': openSubmenus.vanHanh }"
        >
          <img :src="chevronIcon" alt="" class="w-full h-full" />
        </button>
      </div>

      <!-- Submenu Vận hành -->
      <div v-show="openSubmenus.vanHanh" class="flex flex-col bg-[#264a48] w-full transition-all duration-300 ease-in-out">
        <router-link 
          to="/admin/quan-ly-lich-hen"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'vanHanh_Item1' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('vanHanh_Item1')"
        >
          <span class="font-nunitoSans font-medium text-sm">Quản lý lịch hẹn</span>
        </router-link>
        <router-link 
          to="/admin/ho-so-benh-an"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'vanHanh_Item2' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('vanHanh_Item2')"
        >
          <span class="font-nunitoSans font-medium text-sm">Hồ sơ bệnh án</span>
        </router-link>
      </div>

      <!-- Tài chính & Hóa đơn -->
      <div
        class="flex h-12 items-center justify-between px-6 cursor-pointer hover:bg-[#3a6664] transition-colors"
        :class="{ 'bg-[#3a6664]': openSubmenus.taiChinh }"
        @click="toggleSubmenu('taiChinh')"
      >
        <div class="flex gap-3 items-center">
          <img :src="financeIcon" alt="" class="w-5 h-5" />
          <span class="font-nunitoSans font-medium text-white text-base">
            Tài chính & Hóa đơn
          </span>
        </div>
        <button 
          class="w-4 h-4 transition-transform duration-200"
          :class="{ 'rotate-180': openSubmenus.taiChinh }"
        >
          <img :src="chevronIcon" alt="" class="w-full h-full" />
        </button>
      </div>

      <!-- Submenu Tài chính & Hóa đơn -->
      <div v-show="openSubmenus.taiChinh" class="flex flex-col bg-[#264a48] w-full transition-all duration-300 ease-in-out">
        <router-link 
          to="/admin/danh-sach-hoa-don"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'taiChinh_Item1' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('taiChinh_Item1')"
        >
          <span class="font-nunitoSans font-medium text-sm">Danh sách hóa đơn</span>
        </router-link>
        <router-link 
          to="/admin/phieu-chi"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'taiChinh_Item2' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('taiChinh_Item2')"
        >
          <span class="font-nunitoSans font-medium text-sm">Phiếu chi</span>
        </router-link>
      </div>

      <!-- Truyền thông -->
      <div
        class="flex h-12 items-center justify-between px-6 cursor-pointer hover:bg-[#3a6664] transition-colors"
        :class="{ 'bg-[#3a6664]': openSubmenus.truyenThong }"
        @click="toggleSubmenu('truyenThong')"
      >
        <div class="flex gap-3 items-center">
          <img :src="mediaIcon" alt="" class="w-5 h-5" />
          <span class="font-nunitoSans font-medium text-white text-base">
            Truyền thông
          </span>
        </div>
        <button 
          class="w-4 h-4 transition-transform duration-200"
          :class="{ 'rotate-180': openSubmenus.truyenThong }"
        >
          <img :src="chevronIcon" alt="" class="w-full h-full" />
        </button>
      </div>

      <!-- Submenu Truyền thông -->
      <div v-show="openSubmenus.truyenThong" class="flex flex-col bg-[#264a48] w-full transition-all duration-300 ease-in-out">
        <router-link 
          to="/admin/bai-viet"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'truyenThong_Item1' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('truyenThong_Item1')"
        >
          <span class="font-nunitoSans font-medium text-sm">Bài viết</span>
        </router-link>
        <router-link 
          to="/admin/khuyen-mai"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'truyenThong_Item2' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('truyenThong_Item2')"
        >
          <span class="font-nunitoSans font-medium text-sm">Khuyến Mãi</span>
        </router-link>
      </div>

      <!-- Báo cáo -->
      <div
        class="flex h-12 items-center justify-between px-6 cursor-pointer hover:bg-[#3a6664] transition-colors"
        :class="{ 'bg-[#3a6664]': openSubmenus.baoCao }"
        @click="toggleSubmenu('baoCao')"
      >
        <div class="flex gap-3 items-center">
          <img :src="reportIcon" alt="" class="w-5 h-5" />
          <span class="font-nunitoSans font-medium text-white text-base">
            Báo cáo
          </span>
        </div>
        <button 
          class="w-4 h-4 transition-transform duration-200"
          :class="{ 'rotate-180': openSubmenus.baoCao }"
        >
          <img :src="chevronIcon" alt="" class="w-full h-full" />
        </button>
      </div>

      <!-- Submenu Báo cáo -->
      <div v-show="openSubmenus.baoCao" class="flex flex-col bg-[#264a48] w-full transition-all duration-300 ease-in-out">
        <router-link 
          to="/admin/bao-cao-doanh-thu"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'baoCao_Item1' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('baoCao_Item1')"
        >
          <span class="font-nunitoSans font-medium text-sm">Doanh thu</span>
        </router-link>
        <router-link 
          to="/admin/bao-cao-hieu-suat"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'baoCao_Item2' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('baoCao_Item2')"
        >
          <span class="font-nunitoSans font-medium text-sm">Hiệu suất</span>
        </router-link>

        <router-link 
          to="/admin/bao-cao-thuoc-vat-tu"
          class="h-10 flex items-center pl-14 pr-6 cursor-pointer transition-colors"
          :class="activeItem === 'baoCao_Item3' ? 'bg-[#5a9690] border-r-4 border-white' : 'hover:text-[#5eead4] text-white'"
          @click="navigateTo('baoCao_Item3')"
        >
          <span class="font-nunitoSans font-medium text-sm">Thuốc & Vật Tư</span>
        </router-link>
      </div>

      <!-- Cấu hình -->
      <div
        class="flex h-12 items-center justify-between px-6 cursor-pointer hover:bg-[#3a6664]"
        @click="navigateTo('config')"
      >
        <div class="flex gap-3 items-center">
          <img :src="settingsIcon" alt="" class="w-5 h-5" />
          <span class="font-nunitoSans font-medium text-white text-base">
            Cấu hình
          </span>
        </div>
      </div>
    </div>

    <!-- Footer Section -->
    <div class="border-t border-[#0f766e] h-[93px] w-64">
      <div class="flex flex-col gap-2 h-[93px] items-start px-4 pt-[17px]">
        <!-- Logout Button -->
        <button
          class="h-9 rounded-lg w-full flex items-center gap-3 px-3 hover:bg-[#3a6664]"
          @click="handleLogout"
        >
          <img :src="logoutIcon" alt="" class="w-4 h-4" />
          <span class="font-nunitoSans font-medium text-white text-base">
            Đăng xuất
          </span>
        </button>
        
        <!-- Version -->
        <div class="h-4 w-full">
          <p class="font-nunitoSans font-medium text-[#5eead4] text-base text-center">
            Phiên bản v1.0
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

// Image URLs from Figma
const logoIcon = "https://www.figma.com/api/mcp/asset/fae20d1b-2870-422a-b6b3-19faaf6051ee";
const dashboardIcon = "https://www.figma.com/api/mcp/asset/de829f5f-9250-441a-a9ed-1d80054e1c1a";
const resourceIcon = "https://www.figma.com/api/mcp/asset/bb90decb-1ed7-40e9-8d18-1420a1ac4fa1";
const chevronIcon = "https://www.figma.com/api/mcp/asset/a133d436-5c70-4a4b-964c-aeee989f483b";
const staffIcon = "https://www.figma.com/api/mcp/asset/88e96d06-b45f-4d93-aa39-5544f66e5d85";
const operationIcon = "https://www.figma.com/api/mcp/asset/6413c5d7-d9de-47f7-adb1-60d9c6fc64f0";
const financeIcon = "https://www.figma.com/api/mcp/asset/78f6f448-fb75-4de8-a234-173bbebee868";
const mediaIcon = "https://www.figma.com/api/mcp/asset/420d4dcc-ebcb-4c4c-af6b-e3ef6d80dad3";
const reportIcon = "https://www.figma.com/api/mcp/asset/decd1476-2ded-4433-b7a9-727fd8bb498e";
const settingsIcon = "https://www.figma.com/api/mcp/asset/736ac9f6-dd30-419c-a308-56fafcbf1393";
const logoutIcon = "https://www.figma.com/api/mcp/asset/35d9a009-5d0e-4369-a8f1-1e8b002fcb3b";

// State for active item
const activeItem = ref('dashboard');

// State for submenu toggles
const openSubmenus = ref({
  taiNguyen: false,
  nhanSu: false,
  vanHanh: false,
  taiChinh: false,
  truyenThong: false,
  baoCao: false
});

// Toggle submenu
// Toggle submenu
const toggleSubmenu = (menuKey) => {
  // If opening a closed menu, close all others first
  if (!openSubmenus.value[menuKey]) {
    Object.keys(openSubmenus.value).forEach(key => {
      openSubmenus.value[key] = false;
    });
    openSubmenus.value[menuKey] = true;
  } else {
    // If closing an open menu, just close it
    openSubmenus.value[menuKey] = false;
  }
};

// Navigation handler
const navigateTo = (route) => {
  // Set active item
  activeItem.value = route;
  
  // Implement navigation logic
  console.log('Navigate to:', route);
  // router.push({ name: route });
};

// Logout handler
const handleLogout = () => {
  // Implement logout logic
  console.log('Logging out...');
  // Example: Clear auth token and redirect to login
  // localStorage.removeItem('authToken');
  // router.push('/login');
};
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
