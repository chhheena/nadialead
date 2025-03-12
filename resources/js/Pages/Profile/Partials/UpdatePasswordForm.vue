<template>
    <section>
        <p class="text-sm text-gray-600">
            Ensure your account is using a long, random password to stay secure.
        </p>

        <form @submit.prevent="submitHandler" class="mt-6 space-y-6">
            <div>
                <InputLabel for="current_password" value="Current Password" />
                <div class="flex relative">
                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        :type="passwordType" class="mt-1 block w-full" autocomplete="current-password" />

                    <svg @click="viewPassword('password')"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current" width="18" height="18"
                        viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
                            fill="" />
                        <path
                            d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
                            fill="" />
                    </svg>
                </div>
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password" value="New Password" />

                <div class="flex relative">
                    <TextInput id="password" ref="passwordInput" v-model="form.new_password" :type="newPasswordType"
                    class="mt-1 block w-full" autocomplete="new-password" />

                    <svg @click="viewPassword('newPassword')"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 fill-current" width="18" height="18"
                        viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
                            fill="" />
                        <path
                            d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
                            fill="" />
                    </svg>
                </div>

                <InputError :message="form.errors.new_password" class="mt-2" />
            </div>


            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>


<script setup>
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { notificationMessage } from '@/helpers';
import { useRouter } from 'vue-router';
import DefaultCard from "@/components/Forms/DefaultCard.vue";
const store = useAuthStore();
const router = useRouter();

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const user = computed(() => store.getUser);

const form = useForm({
    id: user.value.id,
    current_password: '',
    new_password: '',
});
const passwordType = ref('password');
const newPasswordType = ref('password');

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};

const submitHandler = async () => {
    const { id, current_password, new_password } = form;
    let response = await store.updateProfilePassword({ id, current_password, new_password })
    if (store.error) {
        form.errors.new_password = (store.error?.new_password) ? store.error?.new_password[0] : '';
        form.errors.current_password = (store.error?.current_password) ? store.error?.current_password[0] : '';
    }
    if (response?.status) {
        notificationMessage('success', 'User password updated successfully');
        router.push({ name: 'login' });
    }
}

const viewPassword = (type) => {
    if(type == 'password'){
        passwordType.value = (passwordType.value == 'password') ? 'text' : 'password';
    }else{
        newPasswordType.value = (newPasswordType.value == 'password') ? 'text' : 'password';
    }
}
</script>