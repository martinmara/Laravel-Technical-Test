<template>
  <div class="container">
    <h2 class="title">{{ editing ? 'Edit Your Timesheet' : 'Submit Your Timesheet' }}</h2>

    <div v-if="timesheet">
      <form @submit.prevent="submitTimesheet" class="timesheet-form">
        <label for="date">Date:</label>
        <input type="date" v-model="timesheet.date" required>

        <label for="start_time">Start Time:</label>
        <input type="time" v-model="timesheet.start_time" required>

        <label for="end_time">End Time:</label>
        <input type="time" v-model="timesheet.end_time" required>

        <label for="notes">Notes:</label>
        <textarea v-model="timesheet.notes" placeholder="Optional notes..."></textarea>

        <button type="submit" class="submit-btn">{{ editing ? 'Update' : 'Submit' }}</button>
      </form>
    </div>
   
    <div v-else>
      <p>Loading timesheet data...</p>
    </div>

    <div v-if="message" class="alert">
      {{ message }}
    </div>

    <h2 class="title">Your Timesheets</h2>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Notes</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="entry in timesheets" :key="entry.id">
            <td>{{ entry.date }}</td>
            <td>{{ entry.start_time }}</td>
            <td>{{ entry.end_time }}</td>
            <td>{{ entry.notes }}</td>
            <td>
              <button @click="editTimesheet(entry)" class="edit-btn">Edit</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Timesheet',
  data() {
    return {
      timesheet: {
        date: '',
        start_time: '',
        end_time: '',
        notes: '',
      },
      message: '',
      timesheets: [],
      editing: false,
      editingTimesheetId: null,
    };
  },
  methods: {
    async submitTimesheet() {
      try {
        let response;

        if (this.editing) {
          response = await axios.put(`/timesheets/${this.editingTimesheetId}`, this.timesheet);
          this.message = 'Timesheet updated successfully!';
        } else {
          response = await axios.post('/timesheets', this.timesheet);
          this.message = 'Timesheet submitted successfully!';
        }

        this.resetForm();
        this.fetchTimesheets();
      } catch (error) {
        console.error('Error submitting timesheet:', error.response);
        this.message = error.response.data.message || 'Error submitting timesheet.';
      }
    },
    async fetchTimesheets() {
      try {
        const response = await axios.get('/timesheets');
        this.timesheets = response.data;
      } catch (error) {
        console.error('Error fetching timesheets:', error);
      }
    },
    resetForm() {
      this.timesheet = {
        date: '',
        start_time: '',
        end_time: '',
        notes: '',
      };
      this.editing = false;
      this.editingTimesheetId = null;
    },
    editTimesheet(entry) {
      this.timesheet = { ...entry };
      this.editing = true;
      this.editingTimesheetId = entry.id;
    },
  },
  mounted() {
    this.fetchTimesheets();
  },
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.title {
  text-align: center;
  color: #333;
  margin-bottom: 15px;
}

.timesheet-form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

label {
  font-weight: bold;
  margin-top: 10px;
}

input,
textarea {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}

textarea {
  height: 80px;
  resize: none;
}

.submit-btn {
  margin-top: 15px;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s ease-in-out;
}

.submit-btn:hover {
  background-color: #0056b3;
}

.alert {
  margin-top: 10px;
  padding: 10px;
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
  border-radius: 5px;
  text-align: center;
}

.table-container {
  overflow-x: auto;
  margin-top: 20px;
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

.edit-btn {
  padding: 5px 10px;
  background-color: #f0ad4e;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.edit-btn:hover {
  background-color: #ec971f;
}
</style>
