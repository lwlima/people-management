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
import { ref } from "vue";
import { cn } from "@/lib/utils";
import { Button } from "@/components/ui/button";
import { toast } from "@/components/ui/toast";
import DialogClose from "@/components/ui/dialog/DialogClose.vue";
import axios from "axios";

const props = defineProps({
  isOpen: Boolean,
  handleClose: Function,
  openAddressDialog: Function,
  setPersonId: Function,
});

const name = ref("");
const preferredName = ref("");
const cpf = ref("");
const fatherName = ref("");
const motherName = ref("");
const phone = ref("");
const email = ref("");

const form = useForm({});

function resetForm() {
  name.value = "";
  preferredName.value = "";
  cpf.value = "";
  fatherName.value = "";
  motherName.value = "";
  phone.value = "";
  email.value = "";
}

function createPessoa() {
  axios
    .post("/people", {
      name: name.value,
      preferred_name: preferredName.value,
      cpf: cpf.value,
      father_name: fatherName.value,
      mother_name: motherName.value,
      phone_number: phone.value,
      email: email.value,
    })
    .then((res) => {
      toast({
        title: "Pessoa registrada com sucesso.",
      });
      resetForm();
      if (props.handleClose) props.handleClose();
      if (props.openAddressDialog) props.openAddressDialog();
      console.log(res.data.data.id);
      if (props.setPersonId) props.setPersonId(res.data.data.id);
      console.log("test");
    })
    .catch((err) => {
      console.log(err);
      toast({
        title: "Erro ao registrar pessoa.",
      });
    });
}
</script>

<template>
  <Dialog
    :open="isOpen"
    @update:open="props.handleClose && props.handleClose()"
  >
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Nova Pessoa</DialogTitle>
        <DialogDescription>
          Preencha os detalhes abaixo para criar uma nova pessoa.
        </DialogDescription>
      </DialogHeader>

      <div>
        <Label for="name">Nome</Label>
        <Input
          name="name"
          id="name"
          type="text"
          v-model="name"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
        />
      </div>
      <div>
        <Label for="preferredName">Nome social</Label>
        <Input
          name="preferredName"
          id="preferredName"
          type="text"
          v-model="preferredName"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
        />
      </div>
      <div>
        <Label for="cpf">Cpf</Label>
        <Input
          name="cpf"
          id="cpf"
          type="text"
          v-model="cpf"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
        />
      </div>
      <div>
        <Label for="fatherName">Nome do pai</Label>
        <Input
          name="fatherName"
          id="fatherName"
          type="text"
          v-model="fatherName"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
        />
      </div>
      <div>
        <Label for="motherName">Nome da mãe</Label>
        <Input
          name="motherName"
          id="motherName"
          type="text"
          v-model="motherName"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
        />
      </div>
      <div>
        <Label for="phone">Telefone</Label>
        <Input
          name="phone"
          id="phone"
          type="text"
          v-model="phone"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
        />
      </div>
      <div>
        <Label for="email">Email</Label>
        <Input
          name="email"
          id="email"
          type="text"
          v-model="email"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm"
        />
      </div>
      <DialogFooter>
        <DialogClose>
          <Button
            @click="createPessoa"
            class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75"
          >
            Registrar pessoa
          </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
