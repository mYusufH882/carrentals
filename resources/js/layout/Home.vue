<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <div :class="isSidebarExpanded ? 'w-64' : 'w-20'" class="bg-blue-800 text-white min-h-full transition-all duration-300">
        <div class="flex items-center justify-center py-4">
          <h1 v-if="isSidebarExpanded" class="text-xl font-bold mr-3">Car Rental</h1>
          <button @click="toggleSidebar" class="text-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" :class="isSidebarExpanded ? 'w-6 h-6' : 'w-8 h-8'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
          </button>
        </div>
        <nav class="mt-4">
          <ul>
            <li class="px-4 py-2 hover:bg-blue-600">
              <a href="#" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M5 6h18M5 18h18" />
                </svg>
                <span v-if="isSidebarExpanded" class="ml-4">Dashboard</span>
              </a>
            </li>
            <li class="px-4 py-2 hover:bg-blue-600">
              <a href="#" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span v-if="isSidebarExpanded" class="ml-4">Tasks</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
  
      <!-- Main Content -->
      <div class="flex-1 flex flex-col">
        <!-- Navbar -->
        <div class="bg-white shadow-md px-4 py-3 flex items-center justify-between">
          <h2 class="text-gray-800 text-xl font-semibold">Dashboard</h2>
          <div class="relative">
            <button @click="toggleDropdown" class="flex items-center space-x-2 focus:outline-none">
              <img class="w-10 h-10 rounded-full object-cover" src="https://via.placeholder.com/150" alt="Profile">
              <span class="text-gray-700 font-medium">John Doe</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
  
            <!-- Dropdown -->
            <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-10">
              <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
              <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
              <a href="#" @click="loggedOut" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
          </div>
        </div>
  
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
    import axios from 'axios';
    import { useRouter } from 'vue-router';

    const isSidebarExpanded = ref(true);
    const isDropdownOpen = ref(false);
    const router = useRouter();
  
    // Toggle sidebar
    const toggleSidebar = () => {
        isSidebarExpanded.value = !isSidebarExpanded.value;
    };

    // Toggle dropdown menu
    const toggleDropdown = () => {
        isDropdownOpen.value = !isDropdownOpen.value;
    };

    // Logout function
    const loggedOut = async () => {
    const token = localStorage.getItem('authToken');

    try {
        await axios.post('/api/logout', {}, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        localStorage.removeItem('authToken');
        localStorage.removeItem('userRole');

        router.push('/login');
    } catch (error) {
        console.error('Logout error:', error);
    }
};
</script>
  