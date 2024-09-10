<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <UserSidebar :isSidebarExpanded="isSidebarExpanded" :toggleSidebar="toggleSidebar" />
  
      <!-- Main Content -->
      <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <UserNavbar />
  
        <!-- Dashboard Content -->
        <div class="flex-1 p-6 bg-gray-50">
          <h3 class="text-2xl font-bold text-gray-700">Welcome, John Doe</h3>
          <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-4 shadow-md rounded-md">
              <h4 class="text-lg font-semibold text-gray-700">Recent Activity</h4>
              <p class="text-gray-500 mt-2">You completed 4 tasks today</p>
            </div>
            <div class="bg-white p-4 shadow-md rounded-md">
              <h4 class="text-lg font-semibold text-gray-700">Messages</h4>
              <p class="text-gray-500 mt-2">You have 3 new messages</p>
            </div>
            <div class="bg-white p-4 shadow-md rounded-md">
              <h4 class="text-lg font-semibold text-gray-700">Stats</h4>
              <p class="text-gray-500 mt-2">Your task completion rate is 85%</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
<script setup>
    import { ref } from 'vue';
    import UserSidebar from './components/user/UserSidebar.vue';
    import UserNavbar from './components/user/UserNavbar.vue';

    const isSidebarExpanded = ref(true);

    const toggleSidebar = () => {
        isSidebarExpanded.value = !isSidebarExpanded.value;
    };
</script>
  