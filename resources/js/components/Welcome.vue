<template>
  <div class="container mx-auto">
    <div class="relative bg-gray-800 p-4 rounded-lg max-w-md mx-auto">
      <input v-model="query" @input="fetchApiUsers" type="text" placeholder="Search users..."
        class="w-full p-2 text-white bg-gray-700 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" />

      <ul v-if="apiUsers.length"
        class="absolute w-full bg-gray-800 text-white rounded-lg mt-1 max-h-40 overflow-y-auto shadow-lg">
        <li v-for="user in apiUsers" :key="user.id" class="p-2 border-b border-gray-600 hover:bg-gray-700">
          {{ user.first_name }}
        </li>
      </ul>

      <p v-else class="absolute w-full mt-1 text-gray-400 bg-gray-800 rounded-lg p-2 shadow-lg" v-if="query">No users
        found</p>
    </div>

    <div class="bg-gray-800 mx-auto p-6 rounded-lg max-w-4xl mt-6">
      <h1 class="text-white text-center text-3xl font-bold mb-6">All Users</h1>
      <div v-for="user in allUsers" :key="user.id" class="flex items-center gap-6 p-4 bg-gray-700 rounded-lg mb-4">
        <div class="text-white flex-1 font-medium">{{ user.first_name }} {{ user.last_name }}</div>
        <div class="text-gray-300 flex-1">{{ user.email }}</div>
        <div class="flex items-center justify-center flex-1">
          <img :src="user.avatar" alt="avatar" class="w-16 h-16 rounded-full object-cover">
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      query: "",
      apiUsers: [],
      allUsers: [],
    };
  },
  created() {
    this.fetchAllUsers();
  },
  methods: {
    async fetchApiUsers() {
      if (this.query.length > 2) {
        try {
          const response = await axios.get('/users/search', {
            params: { search: this.query },
          });
          this.apiUsers = response.data;
        } catch (error) {
          console.error("Error fetching users:", error);
        }
      } else {
        this.apiUsers = [];
      }
    },
    async fetchAllUsers() {
      try {
        const response = await axios.get('/user');
        this.allUsers = response.data;
      } catch (error) {
        console.error("Error while fetching users:", error);
      }
    }
  },
};
</script>




<style scoped>
/* Add any additional styling if needed */
</style>