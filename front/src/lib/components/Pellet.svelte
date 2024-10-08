<script lang="ts">

  export let color: 'green' | 'red' | 'orange' = 'green';

</script>

{#if color === 'green'}
  <div class="min-w-2 min-h-2 bg-green-500 rounded-full mr-2"/>
{:else if color === 'red'}
  <div class="min-w-2 min-h-2 bg-red-500 rounded-full mr-2"/>
{:else if color === 'orange'}
  <div class="min-w-2 min-h-2 bg-orange-500 rounded-full mr-2"/>
{/if}