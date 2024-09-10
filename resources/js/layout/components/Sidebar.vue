<template>
    <div :class="isSidebarExpanded ? 'w-64' : 'w-20'" class="bg-blue-200 shadow-lg min-h-screen flex flex-col transition-all duration-300">
      <div class="flex items-center justify-center py-4">
        <h1 v-if="isSidebarExpanded" class="text-xl font-bold text-gray-700">Dashboard</h1>
        <button @click="toggleSidebar" class="text-gray-600 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" :class="isSidebarExpanded ? 'w-6 h-6' : 'w-8 h-8'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
          </svg>
        </button>
      </div>
      <nav class="mt-4">
        <ul>
          <li class="px-4 py-2 hover:bg-blue-300">
            <a href="#" class="flex items-center text-gray-700">
              <span v-if="isSidebarExpanded" class="ml-4">Home</span>
            </a>
          </li>
          <li class="px-4 py-2 hover:bg-blue-300">
            <a href="#" class="flex items-center text-gray-700">
              <span v-if="isSidebarExpanded" class="ml-4">Settings</span>
            </a>
          </li>
          <li class="px-4 py-2 hover:bg-blue-300">
            <a href="#" class="flex items-center text-gray-700">
              <span v-if="isSidebarExpanded" class="ml-4">Profile</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</template>
  
<script>
import { defineProps } from 'vue';
  
export default {
    name: 'Sidebar',
    setup() {
        const props = defineProps({
            isSidebarExpanded: Boolean,
            toggleSidebar: Function
        });
    }
}
</script>
  