<script setup lang="ts">
import { computed } from 'vue';

interface CircularTextProps {
  text: string;
  className?: string;
}

const props = withDefaults(defineProps<CircularTextProps>(), {
  className: ''
});

const letters = computed(() => Array.from(props.text));

const getLetterTransform = (index: number) => {
  const rotationDeg = (360 / letters.value.length) * index;
  const factor = Math.PI / letters.value.length;
  const x = factor * index;
  const y = factor * index;

  return `rotateZ(${rotationDeg}deg) translate3d(${x}px, ${y}px, 0)`;
};
</script>

<template>
    <span
      v-for="(letter, i) in letters"
      :key="i"
      class="inline-block absolute inset-0 text-2xl transition-all duration-500 ease-[cubic-bezier(0,0,0,1)]"
      :style="{
        transform: getLetterTransform(i),
        WebkitTransform: getLetterTransform(i)
      }"
    >
      {{ letter }}
    </span>
</template>