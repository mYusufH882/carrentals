<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <UserSidebar :isSidebarExpanded="isSidebarExpanded" :toggleSidebar="toggleSidebar" />
  
      <!-- Main Content -->
      <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <UserNavbar />
  
        <!-- Dashboard Content -->
        <RouterView />
      </div>
    </div>
  </template>
  
<script setup>
import { ref } from 'vue';
import UserSidebar from './components/user/UserSidebar.vue';
import UserNavbar from './components/user/UserNavbar.vue';
import { RouterView } from 'vue-router';

const isSidebarExpanded = ref(true);

const toggleSidebar = () => {
    isSidebarExpanded.value = !isSidebarExpanded.value;
};
</script>
  