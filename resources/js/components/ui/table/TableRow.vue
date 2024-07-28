<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <tr
    :class="
      cn(
        'border-b transition-colors hover:bg-slate-100/50 data-[state=selected]:bg-slate-100',
        props.class,
      )
    "
  >
    <slot />
  </tr>
</template>
