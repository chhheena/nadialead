<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">

        <!-- Table Section -->
        <div class="mt-2 overflow-x-auto">
            <table
                class="w-full min-w-full border-collapse border border-gray-200 rounded-lg shadow-md dark:border-gray-700">
                <thead class="border-b-2 border-gray-300">
                    <tr class="bg-gray-2 text-left dark:bg-meta-4 whitespace-nowrap">
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            #
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(role, index) in roles" :key="role"
                        class="border-t last:border-b hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ index + 1 }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ role.name }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-end space-x-3.5">
                                <PrimaryButton class="ms-4">
                                    Assign Permission
                                </PrimaryButton>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import HTTP from "../../axios.js";
import PrimaryButton from '@/Components/PrimaryButton.vue';

const roles = ref([]);

const createTable = (page) => {
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}roles`;
    HTTP
        .get(endPoint)
        .then((response) => {
            roles.value = response.data.data;
        })
        .catch((error) => { })
        .finally(() => { });
};


onMounted(() => {
    createTable(1);
});

</script>
