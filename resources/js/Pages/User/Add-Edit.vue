<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <DefaultCard cardTitle="User Add Form">
      <div class="p-8 rounded-lg shadow-md">
        <div class="grid grid-cols-12 gap-6 mb-6">
          <div class="col-span-6">
            <InputLabel for="name" value="Name" class="text-gray-600" />
            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
              placeholder="Enter your name"
            />
          </div>
          <div class="col-span-6">
            <InputLabel for="email" value="Email" class="text-gray-600" />
            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
              v-model="form.email"
              required
              placeholder="Enter your email"
            />
          </div>
        </div>
        <div class="grid grid-cols-12 gap-6 mb-6">
          <div class="col-span-6">
            <InputLabel for="password" value="Password" class="text-gray-600" />
            <TextInput
              id="password"
              type="password"
              class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
              v-model="form.password"
              required
              placeholder="Enter your password"
            />
          </div>
          <div class="col-span-6">
            <InputLabel
              for="confirm_password"
              value="Confirm Password"
              class="text-gray-600"
            />
            <TextInput
              id="confirm_password"
              type="password"
              class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
              v-model="form.confirmPassword"
              required
              placeholder="Confirm your password"
            />
          </div>
        </div>
        <div class="mb-6">
          <InputLabel for="role" value="Role" class="text-gray-600" />
          <SelectInput
            v-model="form.role"
            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="" selected>Select user role</option>
            <option value="client">Client</option>
            <option value="team">Team</option>
          </SelectInput>
        </div>
        <div class="mt-8">
          <PrimaryButton
            @click="submitForm()"
            class="w-full py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-300"
          >
            Add
          </PrimaryButton>
        </div>
      </div>
    </DefaultCard>
  </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { convertJsonToFormData } from "@/helpers";

const pageTitle = ref("User");
const form = ref({});

const props = defineProps({
  id: Number,
});

const errors = ref({});

const createTable = () => {
  axios
    .get(route("users.show", { id: props.id }))
    .then((response) => {
      form.value = response.data.data;
    })
    .catch((error) => {})
    .finally(() => {});
};

const submitForm = () => {
  let method = "";
  let actionUrl = "";
  let formData = "";

  const config = {
    headers: {
      "content-type": "multipart/form-data",
    },
  };
  formData = convertJsonToFormData(form.value);

  if (form.value.id) {
    formData.append("_method", "PUT");
    method = "post";
    actionUrl = "users.update";
  } else {
    method = "post";
    actionUrl = "users.store";
  }
  axios[method](route(actionUrl, { id: form.value.id }), formData, config)
    .then((response) => {
      form.value = response.data.data;
    })
    .catch((error) => {})
    .finally(() => {});
};

onMounted(() => {
  if (props.id) {
    createTable();
  }
});
</script>
