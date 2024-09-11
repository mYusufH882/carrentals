<template>
  <div class="flex-1 p-6 bg-gray-50">
    <h3 class="text-2xl font-bold text-gray-700">Welcome to your dashboard</h3>
    <p class="mt-4 text-gray-600">Here you can manage all your data.</p>
    
    <div class="mt-8 grid gap-6 md:grid-cols-3">
      <!-- Card Mobil -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-xl font-semibold text-gray-800">Mobil</h4>
        <p class="mt-2 text-gray-600">Manage all your vehicles here.</p>
        <div class="mt-4">
          <p class="text-3xl font-bold text-gray-700">{{ mobilCount }}</p>
          <p class="text-gray-500">Total Mobil</p>
        </div>
        <router-link to="/mobil" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View Details</router-link>
      </div>

      <!-- Card Peminjaman -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-xl font-semibold text-gray-800">Peminjaman</h4>
        <p class="mt-2 text-gray-600">Manage all your rentals here.</p>
        <div class="mt-4">
          <p class="text-3xl font-bold text-gray-700">{{ peminjamanCount }}</p>
          <p class="text-gray-500">Total Peminjaman</p>
        </div>
        <router-link to="/peminjaman-admin" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View Details</router-link>
      </div>

      <!-- Card Pengembalian -->
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-xl font-semibold text-gray-800">Pengembalian</h4>
        <p class="mt-2 text-gray-600">Manage all returns here.</p>
        <div class="mt-4">
          <p class="text-3xl font-bold text-gray-700">{{ pengembalianCount }}</p>
          <p class="text-gray-500">Total Pengembalian</p>
        </div>
        <router-link to="/pengembalian-admin" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View Details</router-link>
      </div>
    </div>
  </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const mobilCount = ref(0);
const peminjamanCount = ref(0);
const pengembalianCount = ref(0);

const fetchCounts = async () => {
  const token = localStorage.getItem('authToken');
  try {
    const [mobilResponse, peminjamanResponse, pengembalianResponse] = await Promise.all([
      axios.get('/api/mobil/count', { headers: { 'Authorization': `Bearer ${token}` } }),
      axios.get('/api/peminjaman/count', { headers: { 'Authorization': `Bearer ${token}` } }),
      axios.get('/api/pengembalian/count', { headers: { 'Authorization': `Bearer ${token}` } })
    ]);

    mobilCount.value = mobilResponse.data.data;
    peminjamanCount.value = peminjamanResponse.data.data;
    pengembalianCount.value = pengembalianResponse.data.data;
  } catch (error) {
    console.error('Error fetching counts:', error);
  }
};

onMounted(() => {
  fetchCounts();
});
</script>
