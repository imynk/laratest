<template>
    <div class="max-w-md mx-auto mt-5">
        <input 
            v-model="searchQuery" 
            @input="searchUsers" 
            placeholder="Search users..." 
            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        <ul class="mt-2 bg-white border border-gray-300 rounded-md shadow-md">
            <li 
                v-for="user in users" 
                :key="user.id" 
                class="p-2 hover:bg-gray-100 cursor-pointer"
            >
                {{ user.first_name }} {{ user.last_name }}
            </li>
        </ul>
    </div>
</template>



<script>

export default {
    name: 'Welcome',
};
</script>

<style scoped>
/* Add your styles here */
</style>
