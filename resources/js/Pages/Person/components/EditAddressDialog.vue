<script setup lang="ts">
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { Toaster, useToast } from "@/components/ui/toast";
import axios from "axios";

const props = defineProps({
  isOpen: Boolean,
  handleClose: Function,
  residentialAddress: Object,
  commercialAddress: Object,
  personId: Number,
});

const { toast } = useToast();

const residentialId = ref("");
const residentialNumber = ref("");
const residentialStreet = ref("");
const residentialCity = ref("");
const residentialState = ref("");
const residentialCep = ref("");

const commercialId = ref("");
const commercialNumber = ref("");
const commercialStreet = ref("");
const commercialCity = ref("");
const commercialState = ref("");
const commercialCep = ref("");

function resetForm() {
  residentialId.value = "";
  residentialNumber.value = "";
  residentialStreet.value = "";
  residentialCity.value = "";
  residentialState.value = "";
  residentialCep.value = "";

  commercialId.value = "";
  commercialNumber.value = "";
  commercialStreet.value = "";
  commercialCity.value = "";
  commercialState.value = "";
  commercialCep.value = "";
}

watch(residentialCep, (cep) => {
  if (cep.length === 8)
    axios
      .get(`/get-address-by-cep/${cep}`)
      .then((res) => {
        const address = res.data.data;
        if (!address) {
          toast({
            title: "Erro encontrar cep.",
          });
          return;
        }

        residentialStreet.value = address.logradouro;
        residentialCity.value = address.localidade;
        residentialState.value = address.uf;
      })
      .catch(() =>
        toast({
          title: "Erro encontrar cep.",
        })
      );
});
watch(commercialCep, (cep) => {
  if (cep.length === 8)
    axios
      .get(`/get-address-by-cep/${cep}`)
      .then((res) => {
        const address = res.data.data;
        if (!address) {
          toast({
            title: "Erro encontrar cep.",
          });
          return;
        }
        commercialStreet.value = address.logradouro;
        commercialCity.value = address.localidade;
        commercialState.value = address.uf;
      })
      .catch(() =>
        toast({
          title: "Erro encontrar cep.",
        })
      );
});

watch(
  () => props.residentialAddress,
  (address) => {
    residentialId.value = address?.id;
    residentialNumber.value = address?.number;
    residentialStreet.value = address?.street;
    residentialCity.value = address?.city;
    residentialState.value = address?.state;
    residentialCep.value = address?.cep;
  }
);

watch(
  () => props.commercialAddress,
  (address) => {
    commercialId.value = address?.id;
    commercialNumber.value = address?.number;
    commercialStreet.value = address?.street;
    commercialCity.value = address?.city;
    commercialState.value = address?.state;
    commercialCep.value = address?.cep;
  }
);

function updateAddress() {
  form.post(
    route("address.store", {
      person_id: props.personId,
      residential: {
        id: residentialId.value,
        number: residentialNumber.value,
        street: residentialStreet.value,
        city: residentialCity.value,
        state: residentialState.value,
        cep: residentialCep.value,
      },
      commercial: {
        id: commercialId.value,
        number: commercialNumber.value,
        street: commercialStreet.value,
        city: commercialCity.value,
        state: commercialState.value,
        cep: commercialCep.value,
      },
    }),
    {
      onSuccess: () => {
        toast({
          title: "Endereço atualizado com sucesso.",
        });
        resetForm();
        if (props.handleClose) props.handleClose();
      },
      onError: (res) => {
        toast({
          title: "Erro ao atualizar endereço.",
        });
      },
    }
  );
}

const form = useForm({});
</script>

<template>
  <Dialog
    :open="isOpen"
    @update:open="props.handleClose && props.handleClose()"
  >
    <DialogContent>
      <DialogHeader>
        <DialogTitle> Editar Endereço </DialogTitle>
        <DialogDescription>
          Atualize os endereços abaixo conforme necessário.
        </DialogDescription>
      </DialogHeader>

      <div class="p-6 space-y-6">
        <div class="bg-white p-4 border rounded-lg shadow-md">
          <h2 class="text-xl font-semibold mb-4">Endereço Residencial</h2>
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <Label
                for="residential-cep"
                class="block text-sm font-medium text-gray-700"
                >Cep</Label
              >
              <Input
                name="cep"
                id="residential-cep"
                type="text"
                v-model="residentialCep"
                maxLength="8"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
              />
            </div>
            <div></div>
            <div>
              <Label
                for="residential-street"
                class="block text-sm font-medium text-gray-700"
                >Rua</Label
              >
              <Input
                name="street"
                id="residential-street"
                type="text"
                v-model="residentialStreet"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
              />
            </div>
            <div>
              <Label
                for="residential-number"
                class="block text-sm font-medium text-gray-700"
                >Número</Label
              >
              <Input
                name="number"
                id="residential-number"
                type="text"
                v-model="residentialNumber"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
              />
            </div>
            <div>
              <Label
                for="residential-city"
                class="block text-sm font-medium text-gray-700"
                >Cidade</Label
              >
              <Input
                name="city"
                id="residential-city"
                type="text"
                v-model="residentialCity"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
                disabled
              />
            </div>
            <div>
              <Label
                for="residential-state"
                class="block text-sm font-medium text-gray-700"
                >Estado</Label
              >
              <Input
                name="state"
                id="residential-state"
                type="text"
                v-model="residentialState"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
                disabled
              />
            </div>
          </div>
        </div>

        <div class="bg-white p-4 border rounded-lg shadow-md">
          <h2 class="text-xl font-semibold mb-4">Endereço Comercial</h2>
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <Label
                for="commercial-cep"
                class="block text-sm font-medium text-gray-700"
                >Cep</Label
              >
              <Input
                name="cep"
                id="commercial-cep"
                type="text"
                maxLength="8"
                v-model="commercialCep"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
              />
            </div>
            <div></div>
            <div>
              <Label
                for="commercial-street"
                class="block text-sm font-medium text-gray-700"
                >Rua</Label
              >
              <Input
                name="street"
                id="commercial-street"
                type="text"
                v-model="commercialStreet"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
              />
            </div>
            <div>
              <Label
                for="commercial-number"
                class="block text-sm font-medium text-gray-700"
                >Número</Label
              >
              <Input
                name="number"
                id="commercial-number"
                type="text"
                v-model="commercialNumber"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
              />
            </div>
            <div>
              <Label
                for="commercial-city"
                class="block text-sm font-medium text-gray-700"
                >Cidade</Label
              >
              <Input
                name="city"
                id="commercial-city"
                type="text"
                v-model="commercialCity"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
                disabled
              />
            </div>
            <div>
              <Label
                for="commercial-state"
                class="block text-sm font-medium text-gray-700"
                >Estado</Label
              >
              <Input
                name="state"
                id="commercial-state"
                type="text"
                v-model="commercialState"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
                disabled
              />
            </div>
          </div>
        </div>
      </div>
      <DialogFooter>
        <Button
          @click="updateAddress()"
          class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75"
        >
          Salvar alterações
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
