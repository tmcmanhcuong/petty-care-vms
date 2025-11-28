<template>
  <div
    class="bg-white border-b border-[#f3f4f6] flex flex-col justify-center px-6 py-3 w-full h-full"
    data-name="Header"
  >
    <div class="flex flex-col gap-2.5 items-start w-full">
      <div class="flex items-center justify-between w-full">
        <!-- Breadcrumbs / Page Title -->
        <div class="h-5">
          <div class="flex gap-2 items-center h-5">
            <div class="flex gap-2 items-center h-5">
              <p class="font-nunitoSans font-bold text-[#0d9488] text-base leading-6">
                {{ pageTitle }}
              </p>
            </div>
          </div>
        </div>

        <!-- Right Section: Search, Notification, User Profile -->
        <div class="flex gap-4 items-center">
          <!-- Search Input -->
          <div class="relative h-9 w-64">
            <div
              class="absolute bg-[#f3f4f6] border border-[rgba(0,0,0,0.15)] h-9 left-0 rounded-lg top-0 w-64"
            >
              <div class="flex h-9 items-center overflow-hidden pl-10 pr-3 py-1 rounded-lg w-64">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Tìm kiếm..."
                  class="font-nunitoSans font-medium text-[#6b7280] text-sm bg-transparent border-none outline-none w-full"
                  @keyup.enter="handleSearch"
                />
              </div>
            </div>
            <div class="absolute left-3 top-2.5 w-4 h-4">
              <img :src="searchIcon" alt="Search" class="w-full h-full" />
            </div>
          </div>

          <!-- Notification Button -->
          <button
            class="relative rounded-lg w-9 h-9 hover:bg-gray-100 flex items-center justify-center"
            @click="handleNotificationClick"
            aria-label="Thông báo"
          >
            <div class="w-4 h-4">
              <img :src="notificationIcon" alt="Notification" class="w-full h-full" />
            </div>
            <!-- Notification Badge -->
            <div
              v-if="hasUnreadNotifications"
              class="absolute bg-[#ef4444] left-6 top-1 rounded-full w-2 h-2"
            />
          </button>

          <!-- User Profile Button -->
          <button
            class="flex gap-2 items-center justify-center rounded-lg hover:bg-gray-50 p-1 transition-colors"
            @click="toggleUserMenu"
          >
            <!-- Avatar -->
            <div class="bg-[#0d9488] rounded-full w-8 h-8 flex items-center justify-center">
              <p class="font-nunitoSans font-medium text-white text-sm text-center">
                {{ userInitials }}
              </p>
            </div>
            
            <!-- User Info -->
            <div class="flex flex-col items-start">
              <p class="font-nunitoSans font-medium text-black text-sm leading-6">
                {{ userName }}
              </p>
              <p class="font-nunitoSans font-medium text-[#6b7280] text-sm leading-6">
                {{ userEmail }}
              </p>
            </div>
          </button>
        </div>
      </div>
    </div>

    <!-- User Dropdown Menu (Optional) -->
    <div
      v-if="showUserMenu"
      class="absolute right-6 top-16 bg-white border border-gray-200 rounded-lg shadow-lg p-2 z-50 min-w-[200px]"
    >
      <button
        class="w-full text-left px-4 py-2 hover:bg-gray-100 rounded text-sm font-nunitoSans"
        @click="handleProfile"
      >
        Hồ sơ cá nhân
      </button>
      <button
        class="w-full text-left px-4 py-2 hover:bg-gray-100 rounded text-sm font-nunitoSans"
        @click="handleSettings"
      >
        Cài đặt
      </button>
      <hr class="my-2" />
      <button
        class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600 rounded text-sm font-nunitoSans"
        @click="handleLogout"
      >
        Đăng xuất
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();

// Props
const props = defineProps({
  title: {
    type: String,
    default: 'Dashboard'
  },
  user: {
    type: Object,
    default: () => ({
      name: 'Admin User',
      email: 'admin@petty.vn',
      avatar: null
    })
  }
});

// Icons from Figma
const searchIcon = "https://www.figma.com/api/mcp/asset/1c5e1070-66d5-4289-be1e-c05be4b2cbf1";
const notificationIcon = "https://www.figma.com/api/mcp/asset/ef0a35ec-1c9b-40d8-908a-051f762ff10d";

// State
const searchQuery = ref('');
const showUserMenu = ref(false);
const hasUnreadNotifications = ref(true); // Example: set to true to show notification badge

// Computed
const pageTitle = computed(() => props.title);
const userName = computed(() => props.user?.name || 'Admin User');
const userEmail = computed(() => props.user?.email || 'admin@petty.vn');

const userInitials = computed(() => {
  const name = userName.value;
  if (!name) return 'AD';
  
  const parts = name.split(' ');
  if (parts.length >= 2) {
    return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
  }
  return name.substring(0, 2).toUpperCase();
});

// Methods
const handleSearch = () => {
  console.log('Search query:', searchQuery.value);
  // Implement search logic here
  // Example: router.push({ name: 'search', query: { q: searchQuery.value } });
};

const handleNotificationClick = () => {
  console.log('Notification clicked');
  // Implement notification panel toggle or navigation
  // Example: router.push({ name: 'notifications' });
};

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value;
};

const handleProfile = () => {
  console.log('Navigate to profile');
  showUserMenu.value = false;
  // router.push({ name: 'profile' });
};

const handleSettings = () => {
  console.log('Navigate to settings');
  showUserMenu.value = false;
  // router.push({ name: 'settings' });
};

const handleLogout = () => {
  console.log('Logout');
  showUserMenu.value = false;
  // Implement logout logic
  // Example:
  // localStorage.removeItem('authToken');
  // router.push('/admin/dang-nhap');
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
  const dropdown = event.target.closest('.absolute.right-6');
  const button = event.target.closest('button');
  
  if (!dropdown && !button?.querySelector('.bg-\\[\\#0d9488\\]')) {
    showUserMenu.value = false;
  }
};

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>

<style scoped>
/* Remove input default styles */
input::placeholder {
  color: #6b7280;
}

input:focus {
  outline: none;
}
</style>
