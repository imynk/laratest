<template>
  <div class="container mx-auto">
    <div class="relative bg-gray-800 p-4 rounded-lg max-w-md mx-auto">
      <input v-model="query" @input="fetchApiUsers" type="text" placeholder="Search users..."
        class="w-full p-2 text-white bg-gray-700 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" />

      <ul v-if="apiUsers.length"
        class="absolute w-full bg-gray-800 text-white rounded-lg mt-1 max-h-40 overflow-y-auto shadow-lg p-2">
        <li v-for="user in apiUsers" :key="user.id" class="p-2 border-b border-gray-600 hover:bg-gray-700">
          {{ user.first_name }}
        </li>
      </ul>

      <p v-else class="absolute w-full mt-1 text-gray-400 bg-gray-800 rounded-lg p-2 shadow-lg" v-if="query">No users found</p>
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

      <!-- Conditional form rendering -->
      <div v-if="isFormOpen" class="mt-6">
        <form @submit.prevent="formSubmit" class="w-full">
          <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
              <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="first-name">
                First Name
              </label>
              <input v-model="newUser.first_name" required
                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                id="first-name" type="text" placeholder="Jane">
            </div>
            <div class="w-full md:w-1/2 px-3">
              <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="last-name">
                Last Name
              </label>
              <input v-model="newUser.last_name" required
                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="last-name" type="text" placeholder="Doe">
            </div>
            <div class="w-full md:w-1/2 px-3">
              <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="email">
                Email
              </label>
              <input v-model="newUser.email" required
                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="email" type="email" placeholder="Doe@mail.com">
            </div>
            <div class="w-full md:w-1/2 px-3">
              <label class="block uppercase tracking-wide text-white text-xs font-bold mb-2" for="avatar">
                Image URL
              </label>
              <input v-model="newUser.avatar" required
                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                id="avatar" type="url" placeholder="https://picsum.photos/id/237/200/300">
            </div>
          </div>
          <!-- Submit button -->
          <button type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mb-4">
            Submit
          </button>
        </form>
      </div>
      <!-- Button to toggle form visibility -->
      <button @click="isFormOpen = !isFormOpen"
        class="bg-transparent hover:bg-blue-500 text-white font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
        Add a new User
      </button>

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
      isFormOpen: false, // Add this to control form visibility
      newUser: {
        first_name: "",
        last_name: "",
        email: "",
        avatar: "",
      }
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
        const response = await axios.get('/users');
        this.allUsers = response.data;
      } catch (error) {
        console.error("Error while fetching users:", error);
      }
    },

    async formSubmit() {
      try {
        const response = await axios.post('/users/add', this.newUser);
        this.allUsers.push(response.data);
        this.isFormOpen = false;
        this.newUser = { first_name: "", last_name: "", email: "", avatar: "" };
      } catch (error) {
        console.error("Error while saving form Data:", error);
      }
    },
  }
};
</script>

<style scoped>
/* Add any additional styling if needed */
</style>
