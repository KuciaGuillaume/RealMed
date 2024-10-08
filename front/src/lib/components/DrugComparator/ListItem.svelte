<script lang="ts">
  import Pellet from "../Pellet.svelte";


  export let label: string;
  export let color: 'green' | 'red' | 'orange' = 'green';

</script>

<li class="flex flex-row gap-1 items-center"><Pellet {color}/>{label}</li>