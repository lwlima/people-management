<script setup>
import { Button } from "@/components/ui/button";
import { Card, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import {
  Pagination,
  PaginationFirst,
  PaginationLast,
  PaginationList,
  PaginationListItem,
  PaginationNext,
  PaginationPrev,
} from "@/components/ui/pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { MagnifyingGlassIcon, PlusIcon } from "@radix-icons/vue";
import { debounce } from "lodash";
import { ref, watch } from "vue";
import EditAddressDialog from "./components/EditAddressDialog.vue";
import CreatePessoaDialog from "./components/CreatePessoaDialog.vue";
import { Toaster } from "@/components/ui/toast";

const props = defineProps({
  pagination: Array,
  search: String,
});

const isOpen = ref(false);
const searchTerm = ref(props.search);
const residentialAddress = ref();
const commercialAddress = ref();
const isOpenCreateDialog = ref(false);
const personId = ref();

function handleClose() {
  isOpen.value = false;
}

function openDialog(person) {
  if (person) {
    residentialAddress.value = person.addresses[1];
    commercialAddress.value = person.addresses[0];
  }
  isOpen.value = true;
}

function setPersonId(id) {
  personId.value = id;
}

function handleCloseCreateDialog() {
  isOpenCreateDialog.value = false;
}

function openCreateDialog() {
  isOpenCreateDialog.value = true;
}

function handleSearch(value) {
  router.reload({
    data: { page: 1, search: value },
  });
}
const debouncedHandleSearch = debounce(handleSearch, 300);
watch(searchTerm, (value) => debouncedHandleSearch(value));

const headers = [
  { title: "Id", key: "id" },
  { title: "Nome", key: "name" },
  { title: "Nome social", key: "preferred_name" },
  { title: "CPF", key: "cpf" },
  { title: "Nome do pai", key: "father_name" },
  { title: "Nome da mãe", key: "mother_name" },
  { title: "Telefone", key: "phone_number" },
  { title: "Email", key: "email" },
  { title: "End. residencial", key: "residential_address" },
  { title: "End. comercial", key: "commercial_address" },
];
</script>

<template>
  <Head title="Pessoas" />

  <AuthenticatedLayout>
    <Toaster class="bg-white" />
    <CreatePessoaDialog
      :isOpen="isOpenCreateDialog"
      :handleClose="handleCloseCreateDialog"
      :openAddressDialog="openDialog"
      :setPersonId="setPersonId"
    />
    <EditAddressDialog
      :isOpen="isOpen"
      :handleClose="handleClose"
      :residentialAddress="residentialAddress"
      :commercialAddress="commercialAddress"
      :personId="personId"
    />
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Pessoas
        </h2>
        <Button
          @Click="openCreateDialog()"
          class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75"
          ><PlusIcon class="w-5 h-5 mr-1 text-white" /> Nova Pessoa</Button
        >
      </div>
    </template>

    <div class="py-12">
      <div
        class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-1 min-w-3xl overflow-x-auto"
      >
        <div class="w-[1200px]">
          <div class="flex justify-end bg-gray-200 p-6 rounded-lg mb-4">
            <div class="relative w-80 max-w-sm items-center">
              <Input
                v-model="searchTerm"
                name="search"
                id="search"
                type="text"
                placeholder="Search..."
                class="pl-10"
              />
              <span
                class="absolute start-0 inset-y-0 flex items-center justify-center px-2"
              >
                <MagnifyingGlassIcon class="size-6 text-muted-foreground" />
              </span>
            </div>
          </div>
          <div class="grid grid-cols-12">
            <div
              v-for="header in headers"
              class="flex mx-auto px-2 items-center text-center"
              :class="{
                'col-span-2':
                  header.key === 'residential_address' ||
                  header.key === 'commercial_address',
                'col-span-1':
                  header.key !== 'residential_address' ||
                  header.key !== 'commercial_address',
              }"
            >
              {{ header.title }}
            </div>
          </div>
          <Card
            v-for="person in props.pagination.data"
            class="grid grid-cols-12 cursor-pointer bg-gray-100 hover:bg-gray-300 transition duration-300 text-sm"
            @click="openDialog(person)"
          >
            <div class="flex col-span-1 break-all mx-auto px-2 items-center">
              {{ person.id }}
            </div>
            <div class="flex col-span-1 break-all mx-auto px-2 items-center">
              {{ person.name }}
            </div>
            <div class="flex col-span-1 break-all mx-auto px-2 items-center">
              {{ person.preferred_name }}
            </div>
            <div class="flex col-span-1 break-all mx-auto px-2 items-center">
              {{ person.cpf }}
            </div>
            <div class="flex col-span-1 break-all mx-auto px-2 items-center">
              {{ person.father_name }}
            </div>
            <div class="flex col-span-1 break-all mx-auto px-2 items-center">
              {{ person.mother_name }}
            </div>
            <div class="flex col-span-1 break-all mx-auto px-2 items-center">
              {{ person.phone_number }}
            </div>
            <div class="flex col-span-1 break-all mx-auto px-2 items-center">
              {{ person.email }}
            </div>
            <div class="flex col-span-2 break-all mx-auto px-2 items-center">
              {{ person.addresses[1]?.street }},
              {{ person.addresses[1]?.number }} -
              {{ person.addresses[1]?.city }}/{{ person.addresses[1]?.state }} -
              {{ person.addresses[1]?.cep }}
            </div>
            <div class="flex col-span-2 break-all mx-auto px-2 items-center">
              {{ person.addresses[0]?.street }},
              {{ person.addresses[0]?.number }} -
              {{ person.addresses[0]?.city }}/{{ person.addresses[0]?.state }} -
              {{ person.addresses[0]?.cep }}
            </div>
          </Card>
          <Pagination
            v-slot="{ page }"
            class="flex justify-end mt-2"
            :total="pagination.total"
            :sibling-count="1"
            show-edges
            :default-page="pagination.current_page"
            :items-per-page="pagination.per_page"
          >
            <PaginationList v-slot="{ items }" class="flex items-center gap-1">
              <PaginationFirst
                @click="router.visit(pagination.first_page_url)"
              />
              <PaginationPrev
                @click="router.visit(pagination.prev_page_url)"
                :disabled="page === 1"
              />

              <template v-for="(item, index) in items" :key="index">
                <PaginationListItem :value="item.value" as-child>
                  <Button
                    class="w-10 h-10 p-0"
                    :variant="
                      item.value === pagination.current_page
                        ? 'default'
                        : 'outline'
                    "
                    @click="
                      () => {
                        router.visit(
                          pagination.links.find(
                            (link) => item.value == link.label
                          ).url
                        );
                      }
                    "
                  >
                    {{ item.value }}
                  </Button>
                </PaginationListItem>
              </template>

              <PaginationNext
                @click="router.visit(pagination.next_page_url)"
                :disabled="page === pagination.last_page"
              />
              <PaginationLast @click="router.visit(pagination.last_page_url)" />
            </PaginationList>
          </Pagination>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
