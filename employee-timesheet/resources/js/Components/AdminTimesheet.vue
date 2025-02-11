<template>
  <div class="container">
    <h2 class="title">Admin Timesheet Management</h2>
    <h3 style="text-align: center;margin-bottom:10px;">Filter by employee name and date</h3>
    <div class="filters">
      <input
        type="text"
        v-model="searchName"
        @input="debouncedFetchTimesheets" 
        placeholder="employee name"
        class="filter-text"
      />
      <input
        type="date"
        v-model="selectedDate"
        @change="fetchTimesheets"
        class="filter-date"
      />
    </div>

    <div v-if="loading" class="loading">Loading timesheets...</div>

    
    <div v-else class="table-container">
      <table>
        <thead>
          <tr>
            <th>Employee</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="timesheet in timesheets" :key="timesheet.id">
            <td>{{ timesheet.user.name }}</td>
            <td>{{ timesheet.date }}</td>
            <td>{{ timesheet.start_time }}</td>
            <td>{{ timesheet.end_time }}</td>
            <td>{{ timesheet.notes }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import debounce from 'lodash/debounce';

export default {
  setup() {
    const employees = ref([]);
    const timesheets = ref([]);
    const searchName = ref('');
    const selectedDate = ref('');
    const loading = ref(false);

    const fetchEmployees = async () => {
      try {
        const response = await axios.get('/admin/employees');
        employees.value = response.data;
      } catch (error) {
        console.error('Error fetching employees:', error);
      }
    };

    const fetchTimesheets = async () => {
      loading.value = true;
      try {
        const response = await axios.get('/admin/timesheets', {
          params: {
            employee_name: searchName.value,
            date: selectedDate.value,
          }
        });
        timesheets.value = response.data;
      } catch (error) {
        console.error('Error fetching timesheets:', error);
      } finally {
        loading.value = false;
      }
    };

    const debouncedFetchTimesheets = debounce(fetchTimesheets, 800);

    fetchEmployees();
    fetchTimesheets();

    return {
      employees,
      timesheets,
      searchName,
      selectedDate,
      loading,
      fetchTimesheets,
      debouncedFetchTimesheets,
    };
  }
};
</script>

<style scoped>

.container {
  max-width: 900px;
  margin: 20px auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.title {
  text-align: center;
  font-size: 22px;
  color: #333;
  margin-bottom: 15px;
}


.filters {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
  justify-content: center;
}

.filter-text,
.filter-date {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}


.loading {
  text-align: center;
  font-size: 16px;
  color: #777;
}


.table-container {
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  background: white;
  border-radius: 10px;
  overflow: hidden;
}

th,
td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: center;
}

th {
  background-color: #007bff;
  color: white;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}

tr:hover {
  background-color: #d6eaff;
}
</style>
