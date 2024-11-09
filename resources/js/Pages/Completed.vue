<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Completed Todo's List
                </h2>
            </div>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <span class="text-xl text-purple-900 font-bold"
                            >Completed:</span
                        >
                        <hr class="my-2" />
                        <div class="grid grid-cols-1">
                            <div
                                class="grid m-5 grid-cols-2 sm:grid-cols-3"
                                v-for="(item, index) in props.context.todos"
                                :key="item.id"
                            >
                                <div>
                                    <img
                                        class="max-w-52 sm:ml-0 -ml-4 max-h-24 rounded"
                                        :src="item.image"
                                        :alt="item.title"
                                    />
                                </div>
                                <div
                                    class="grid grid-cols-1 sm:-ml-10 w-52 h-auto justify-self-start"
                                >
                                    <h2
                                        class="text-xl text-purple-900 font-bold"
                                    >
                                        {{ item.title }}
                                    </h2>
                                    <p class="text-base">
                                        <span
                                            class="hover:cursor-pointer hover:text-purple-950 text-sm"
                                            @click="
                                                showDescription(
                                                    item.description
                                                )
                                            "
                                            >Click Here For Description</span
                                        >
                                    </p>
                                    <Modal
                                        @close="showDescription"
                                        :show="modalStatus"
                                        ><div class="m-2">
                                            {{ descriptionValue }}
                                        </div></Modal
                                    >
                                </div>
                                <div class="grid grid-cols-2">
                                    <template
                                        v-for="cat in props.context.categories"
                                    >
                                        <h3
                                            class="text-xl -ml-2 sm:-ml-10 my-auto"
                                            v-if="cat.id == item.category_id"
                                        >
                                            {{ cat.name }}
                                        </h3>
                                    </template>
                                    <div
                                        class="grid grid-cols-2 sm:-ml-14 ml-10"
                                    >
                                        <div
                                            class="grid grid-cols-2 sm:grid-cols-1"
                                        >
                                            <div class="ml-4 my-auto sm:ml-0">
                                                <SecondaryButton
                                                    ><TrashIcon
                                                        @click="
                                                            deleteModalStatusF(
                                                                item.id
                                                            )
                                                        "
                                                    ></TrashIcon
                                                ></SecondaryButton>
                                                <ConfirmModal
                                                    @no="deleteModalStatusF"
                                                    @yes="deleteTodo"
                                                    :show="deleteModalStatus"
                                                    ><div
                                                        class="m-2 text-center"
                                                    >
                                                        Are You Sure?
                                                    </div></ConfirmModal
                                                >
                                            </div>
                                            <div class="-ml-16 my-auto sm:ml-0">
                                                <SecondaryButton
                                                    disabled
                                                    @click="editTodo(item.id)"
                                                    ><EditIcon></EditIcon
                                                ></SecondaryButton>
                                            </div>
                                        </div>
                                        <div>
                                            <div
                                                class="justify-self-stretch sm:ml-0 my-auto ml-20 sm:mr-2"
                                            >
                                                <PrimaryButton
                                                    class="my-7"
                                                    disabled
                                                    v-if="item.is_done == 1"
                                                    >Completed</PrimaryButton
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <button @click="log">test</button> -->
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { router, useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import TrashIcon from "@/Components/TrashIcon.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import EditIcon from "@/Components/EditIcon.vue";
import ConfirmModal from "@/Components/ConfirmModal.vue";
const props = defineProps({
    context: Object,
});

const form = useForm({
    todo_id: null,
});
const modalStatus = ref(false);
const descriptionValue = ref();
function showDescription(t) {
    modalStatus.value = !modalStatus.value;
    descriptionValue.value = t;
}
const deleteModalStatus = ref(false);
function deleteModalStatusF() {
    deleteModalStatus.value = !deleteModalStatus.value;
}

function deleteTodo(todoId) {
    deleteModalStatus.value = !deleteModalStatus.value;
    router.delete(route("todo.delete", todoId));
}
function editTodo(todoId) {
    router.put(route("todo.edit", todoId));
}
</script>
