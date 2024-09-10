<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <Sidebar :isSidebarExpanded="isSidebarExpanded" :toggleSidebar="toggleSidebar" />
  
      <!-- Main content -->
      <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <Navbar />
  
        <!-- Main Dashboard Content -->
        <div class="flex-1 p-6 bg-gray-50">
          <h3 class="text-2xl font-bold text-gray-700">Welcome to your dashboard</h3>
          <p class="mt-4 text-gray-600">Here you can manage all your settings and data.</p>
        </div>
      </div>
    </div>
</template>
  
<script setup>
import { ref } from 'vue';
import Navbar from './components/Navbar.vue';
import Sidebar from './components/Sidebar.vue';
  
  // Sidebar expanded state
  const isSidebarExpanded = ref(true);
  const isDropdownOpen = ref(false);
  
  // Toggle sidebar
  const toggleSidebar = () => {
    isSidebarExpanded.value = !isSidebarExpanded.value;
  };
  
  // Toggle dropdown menu
  const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
  };
</script>
  
<style scoped>
  /* Custom scrollbar styles for the sidebar */
  ::-webkit-scrollbar {
    width: 8px;
  }
  
  ::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background-color: rgba(0, 0, 0, 0.2);
  }
</style>
  