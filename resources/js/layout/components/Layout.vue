<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <Sidebar :isSidebarExpanded="isSidebarExpanded" :toggleSidebar="toggleSidebar" />
  
      <!-- Main content -->
      <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <Navbar />
  
        <!-- Main Dashboard Content -->
        <RouterView />
      </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { RouterView } from 'vue-router';
import Sidebar from './Sidebar.vue';
import Navbar from './Navbar.vue';
  
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