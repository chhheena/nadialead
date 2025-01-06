<template>
    <Modal ref="modal" :show="showModal" @click="$emit('close')">
        <button @click="showList" class="absolute right-1 top-1 sm:right-5 sm:top-5">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.8913 9.99599L19.5043 2.38635C20.032 1.85888 20.032 1.02306 19.5043 0.495589C18.9768 -0.0317329 18.141 -0.0317329 17.6135 0.495589L10.0001 8.10559L2.38673 0.495589C1.85917 -0.0317329 1.02343 -0.0317329 0.495873 0.495589C-0.0318274 1.02306 -0.0318274 1.85888 0.495873 2.38635L8.10887 9.99599L0.495873 17.6056C-0.0318274 18.1331 -0.0318274 18.9689 0.495873 19.4964C0.717307 19.7177 1.05898 19.9001 1.4413 19.9001C1.75372 19.9001 2.13282 19.7971 2.40606 19.4771L10.0001 11.8864L17.6135 19.4964C17.8349 19.7177 18.1766 19.9001 18.5589 19.9001C18.8724 19.9001 19.2531 19.7964 19.5265 19.4737C20.0319 18.9452 20.0245 18.1256 19.5043 17.6056L11.8913 9.99599Z"
                    fill=""></path>
            </svg>
        </button>
        <DefaultCard cardTitle="Manage Permission" @click.stop>
            <div class="p-4 shadow sm:rounded-lg sm:p-8">
                <form id="permissionsForm">
                    <div class="flex flex-wrap gap-4">
                        <div v-for="(field, index) in getFields" :key="index" class="flex items-center">
                            <input type="checkbox" :id="index" v-model="permissions[index]" value="id" class="mr-2"
                                :checked="assignedFileds.includes(field)">
                            <label :for="index">{{ formatLabel(field) }}</label>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" class="bg-gray-300 px-4 py-2 rounded" @click="$emit('close')">
                            Cancel
                        </button>
                        <button type="submit" @click.prevent="submitHandler"
                            class="bg-blue-500 text-white px-4 py-2 rounded">
                            Update Permission
                        </button>
                    </div>
                </form>
            </div>
        </DefaultCard>
    </Modal>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from "vue";
import HTTP from "@/axios";
import Modal from "@/Components/Modal.vue";
import { useAuthStore } from "@/stores/auth.js";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import { notificationMessage } from "@/helpers";
const emit = defineEmits();
const roles = ref([]);
const fieldsData = ref([]);
const assignFields = ref([]);
const store = useAuthStore();

const permissions = ref([]);

const props = defineProps({
    getFields: {
        type: Array,
        default: [],
        required: true
    },
    showModal: {
        type: Boolean,
        default: false,
    },
    roleId: {
        type: [String, Number],
        required: true,
    },
    assignedFileds: {
        type: Array,
        default: [],
    }
});

const getUserRoleId = computed(() => store.getUser.id);
const getAssignLeadFields = computed(() => store.getAssignedFields);
const getCheckedFields = computed(() => {
    const checkedFields = props.getFields.filter((field, index) => {
        return permissions.value[index] === true;
    });
    const mergedFields = [...new Set([...checkedFields, ...props.assignedFileds])];
    return mergedFields;
});



onMounted(() => {

});

const submitHandler = () => {
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}assign/fields`;

    let payload = {
        'roleId': props.roleId,
        'leadAssignFields': getCheckedFields.value
    }

    HTTP
        .post(endPoint, payload)
        .then((response) => {
            let status = response.data?.status;
            if (status) {
                notificationMessage('success', 'Permission added successfully');
                emit('close');
            }
        })
        .catch((error) => { })
        .finally(() => { });
}

const formatLabel = (label) => {
    return label
        .split('_') // Split string into an array by underscore
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalize each word
        .join(' '); // Join the array back into a string with spaces
}

</script>
