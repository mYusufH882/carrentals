<template>
    <div class="bg-white shadow-md px-4 py-2 flex items-center justify-between">
      <h2 class="text-gray-700 text-xl font-semibold">Dashboard</h2>
      <div class="relative">
        <button @click="toggleDropdown" class="flex items-center space-x-2 focus:outline-none">
          <img class="w-10 h-10 rounded-full object-cover" src="https://via.placeholder.com/150" alt="Profile">
          <span class="text-gray-700 font-medium">John Doe</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
  
        <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-10">
          <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
          <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
          <a @click.prevent="loggedOut" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
        </div>
      </div>
    </div>
</template>
  
<script setup>
  import axios from 'axios';
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  
  const isDropdownOpen = ref(false);
  const router = useRouter();
  
  const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
  };
  
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
  }
</script>
  