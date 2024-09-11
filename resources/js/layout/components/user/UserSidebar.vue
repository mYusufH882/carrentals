<template>
    <div :class="isSidebarExpanded ? 'w-64' : 'w-20'" class="bg-blue-800 text-white min-h-screen transition-all duration-300">
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
          <li :class="{'bg-blue-300': isActive('/peminjaman-user')}" class="px-4 py-2 hover:bg-blue-600">
            <a href="/peminjaman-user" class="flex items-center">
              <i class="fas fa-exchange-alt w-6 h-6 pt-1"></i>
              <span v-if="isSidebarExpanded" class="ml-4">Peminjaman</span>
            </a>
          </li>
          <li  :class="{'bg-blue-300': isActive('/pengembalian-user')}" class="px-4 py-2 hover:bg-blue-600">
            <a href="/pengembalian-user" class="flex items-center">
              <i class="fas fa-undo w-6 h-6 pt-1"></i>
              <span v-if="isSidebarExpanded" class="ml-4">Pengembalian</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</template>
  
<script setup>
import { useRoute } from 'vue-router'; 

const props = defineProps({
  isSidebarExpanded: Boolean,
  toggleSidebar: Function
});
  
const route = useRoute();
const isActive = (path) => {
  return route.path === path;
};
</script>
  