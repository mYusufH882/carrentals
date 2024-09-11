<template>
    <div class="p-6 bg-white m-5">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-gray-700 text-2xl font-semibold">Data Peminjaman Mobil</h2>
        </div>
        <div>
            <table id="peminjamanTable" class="display responsive">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Merek Mobil</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Total Sewa/Hari</th>
                        <th>Status Sewa</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import axios from 'axios';
import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-dt/css/datatables.dataTables.css';
import { formatDate } from '../../helpers/formatHelper';

const dataPeminjaman = ref([]);
let dataTable = null;

const fetchDataPinjam = async () => {
    const token = localStorage.getItem('authToken');
    try {
        const response = await axios.get('/api/peminjaman', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        dataPeminjaman.value = response.data.data;
        console.log(response.data.data);
        
        await nextTick(); 
        populateDataTable(); 
    } catch (error) {
        console.error('Error fetching peminjaman data:', error);
    }
};

const populateDataTable = () => {
    if (dataTable) {
        dataTable.destroy();
    }

    dataTable = $('#peminjamanTable').DataTable({
        data: dataPeminjaman.value,
        columns: [
            { data: 'user.name' }, 
            { data: 'mobil.merek' },    
            { 
                data: 'tgl_mulai',
                render: (data) => formatDate(data) 
             },
            { 
                data: 'tgl_selesai',
                render: (data) => formatDate(data) 
            },
            { 
                data: 'total_hari_sewa',
                render: (total) => {
                    return total + ` hari`
                } 
            },
            { 
                data: 'status_sewa',
                render: (status) => {
                    if(status == "ongoing") return `<span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Dipakai</span>`
                    if(status == "returned") return `<span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Selesai</span>`
                }  
            },
        ]
    });

    window.editPeminjaman = editPeminjaman;
    window.deletePeminjaman = deletePeminjaman;
};

const editPeminjaman = (id) => {
    console.log('Edit peminjaman id:', id);
};

const deletePeminjaman = async (id) => {
    const token = localStorage.getItem('authToken');
    try {
        await axios.delete(`/api/peminjaman/${id}`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        fetchDataPinjam(); 
    } catch (error) {
        console.error('Error deleting peminjaman:', error);
    }
};

onMounted(() => {
    fetchDataPinjam();
});

onBeforeUnmount(() => {
    if (dataTable) {
        dataTable.destroy();
    }
});
</script>
