<template>
    <div class="p-6 bg-white m-5">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-gray-700 text-2xl font-semibold">Data Mobil</h2>
        <button 
          @click="addMobil"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
          Tambah Mobil
        </button>
      </div>
      <div>
        <table id="mobilTable" class="display responsive">
          <thead>
            <tr>
              <th>Merek</th>
              <th>Model</th>
              <th>Nomor Plat</th>
              <th>Tarif Sewa/Hari</th>
              <th>Ketersediaan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
</template>
  
<script setup>
  import { ref, onMounted, nextTick, onBeforeUnmount, render } from 'vue';
  import axios from 'axios';
  import $ from 'jquery';
  import 'datatables.net';
  import 'datatables.net-dt/css/datatables.dataTables.css';
import router from '../../router';
  
  const dataMobil = ref([]);
  let dataTable = null; 
  
  const fetchDataMobil = async () => {
      try {
        const token = localStorage.getItem('authToken');
        const response = await axios.get('/api/mobil', {
        headers: {
          'Authorization': `Bearer ${token}`
            }
        });

        dataMobil.value = response.data.data;
        await nextTick();
        populateDataTable(); 
    } catch (error) {
        console.error('Error fetching mobil data:', error);
    }
  };
  
  const populateDataTable = () => {
    if (dataTable) {
      dataTable.destroy(); 
    }
  
    dataTable = $('#mobilTable').DataTable({
      data: dataMobil.value,
      columns: [
        { data: 'merek' },
        { data: 'model' },
        { data: 'nomor_plat' },
        { data: 'tarif_sewa_per_hari' },
        { 
            data: 'ketersediaan',
            render: (data) => {
                if(data == true) return `<span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-800 ring-1 ring-inset ring-green-600/20">Tersedia</span>`
                else return `<span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Tidak Tersedia</span>`
            } 
        },
        {
          data: null,
          render: function (data, type, row) {
            return `
              <button onclick="editMobil(${row.id})" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 mr-2">Edit</button>
              <button onclick="deleteMobil(${row.id})" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus</button>
            `;
          }
        }
      ]
    });
  
    window.editMobil = editMobil;
    window.deleteMobil = deleteMobil;
  };
  
  const editMobil = (id) => {
    router.push(`/edit-mobil/${id}`);
  };
  
  const deleteMobil = async (id) => {
    const isConfirmed = window.confirm('Are you sure you want to delete this menu?');
    if(isConfirmed) {
        try {
            const token = localStorage.getItem('authToken');
          await axios.delete(`/api/mobil/delete/${id}`, {
            headers: {
              'Authorization': `Bearer ${token}`
            }
          });
          fetchDataMobil(); 
        } catch (error) {
          console.error('Error deleting mobil:', error);
        }
    }
  };
  
  const addMobil = () => {
    router.push('/input-mobil');
  };
  
  onMounted(() => {
    fetchDataMobil();
  });
  
  onBeforeUnmount(() => {
    if (dataTable) {
      dataTable.destroy();
    }
  });
</script>
  