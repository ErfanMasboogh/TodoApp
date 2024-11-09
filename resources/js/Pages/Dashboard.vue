<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white grid grid-cols-1 shadow-sm sm:rounded-lg"
                >
                    <div class="grid grid-cols-2">
                        <div class="p-6 text-gray-900">Categories:</div>

                        <div
                            class="p-6 grid grid-cols-2 justify-self-end -mr-36"
                        >
                            <div class="-mt-[11px]">
                                <TextInput
                                    class="m-2"
                                    v-model="form.name"
                                ></TextInput>
                            </div>

                            <div>
                                <PrimaryButton @click="sendForm"
                                    >+</PrimaryButton
                                >
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="grid m-2 lg:grid-cols-3 grid-cols-1">
                        <div
                            v-for="item in props.context.categories"
                            :key="item.id"
                            class="p-2 border-2 m-2 rounded-lg items-center grid grid-cols-2 border-purple-500"
                        >
                            <div class="text-lg">
                                {{ item.name }}
                            </div>
                            <div class="grid grid-cols-2 justify-self-end">
                                <div class="m-1">
                                    <SecondaryButton
                                        @click="
                                            deleteCategoryModalStatusF(item.id)
                                        "
                                    >
                                        <TrashIcon></TrashIcon
                                    ></SecondaryButton>
                                    <ConfirmModal
                                        :show="deleteCategoryModalStatus"
                                        @no="deleteCategoryModalStatusF"
                                        @yes="deleteCategory"
                                    >
                                        <div class="grid grid-cols-1">
                                            <div
                                                class="justify-self-center text-center"
                                            >
                                                Are You Sure That You Want To
                                                Delete This Category?
                                            </div>
                                            <div
                                                class="justify-self-center text-center text-xs font-bold"
                                            >
                                                Notice: If you delete this
                                                category , all Todos which have
                                                this category will be delete
                                                too!
                                            </div>
                                        </div>
                                    </ConfirmModal>
                                </div>
                                <div class="m-1">
                                    <SecondaryButton
                                        @click="
                                            editCategoryModalStatusF(
                                                item.name,
                                                item.id
                                            )
                                        "
                                        ><EditIcon></EditIcon
                                    ></SecondaryButton>
                                    <ConfirmModal
                                        :show="editCategoryModalStatus"
                                        @no="editCategoryModalStatusF"
                                        @yes="editCategory"
                                    >
                                        <div class="grid grid-cols-1">
                                            <div
                                                class="justify-self-center m-2"
                                            >
                                                <TextInput
                                                    v-model="
                                                        editCategoryModalTextValue
                                                    "
                                                ></TextInput>
                                            </div>
                                            <div
                                                class="justify-self-center text-lg text-center m-2"
                                            >
                                                Are you sure with this name?
                                            </div>
                                        </div>
                                    </ConfirmModal>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import ConfirmModal from "@/Components/ConfirmModal.vue";
import EditIcon from "@/Components/EditIcon.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TrashIcon from "@/Components/TrashIcon.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    context: Object,
});

const form = useForm({
    name: null,
});

function sendForm() {
    form.post(route("category.store"));
}

const editCategoryModalStatus = ref(false);
const editCategoryModalTextValue = ref();
const editCategoryModalId = ref();
function editCategoryModalStatusF(p, i) {
    editCategoryModalStatus.value = !editCategoryModalStatus.value;
    editCategoryModalTextValue.value = p;
    editCategoryModalId.value = i;
}

function editCategory() {
    form.name = editCategoryModalTextValue.value;
    form.post(route("category.update", editCategoryModalId.value));
    form.name = null;
    editCategoryModalStatus.value = !editCategoryModalStatus.value;
}
const deleteCategoryModalId = ref();
const deleteCategoryModalStatus = ref(false);
function deleteCategoryModalStatusF(categoryId) {
    deleteCategoryModalStatus.value = !deleteCategoryModalStatus.value;
    deleteCategoryModalId.value = categoryId;
}
function deleteCategory() {
    deleteCategoryModalStatus.value = !deleteCategoryModalStatus.value;
    router.delete(route("category.delete", deleteCategoryModalId.value));
}
</script>
