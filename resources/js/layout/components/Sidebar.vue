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
          <li :class="{'bg-blue-300': isActive('/dashboard')}" class="px-4 py-2 hover:bg-blue-300">
            <a href="/dashboard" class="flex items-center text-gray-700">
              <i class="fas fa-tachometer-alt w-6 h-6 pt-1"></i>
              <span v-if="isSidebarExpanded" class="ml-4">Dashboard</span>
            </a>
          </li>
          <li :class="{'bg-blue-300': isActive('/mobil')}" class="px-4 py-2 hover:bg-blue-300">
            <a href="/mobil" class="flex items-center text-gray-700">
              <i class="fas fa-car w-6 h-6 pt-1"></i>
              <span v-if="isSidebarExpanded" class="ml-4">Mobil</span>
            </a>
          </li>
          <li :class="{'bg-blue-300': isActive('/peminjaman-admin')}" class="px-4 py-2 hover:bg-blue-300">
            <a href="/peminjaman-admin" class="flex items-center text-gray-700">
              <i class="fas fa-exchange-alt w-6 h-6 pt-1"></i>
              <span v-if="isSidebarExpanded" class="ml-4">Peminjaman</span>
            </a>
          </li>
          <li :class="{'bg-blue-300': isActive('/pengembalian-admin')}" class="px-4 py-2 hover:bg-blue-300">
            <a href="/pengembalian-admin" class="flex items-center text-gray-700">
              <i class="fas fa-undo w-6 h-6 pt-1"></i>
              <span v-if="isSidebarExpanded" class="ml-4">Pengembalian</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</template>
  
<script setup>
import { defineProps } from 'vue';
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
  