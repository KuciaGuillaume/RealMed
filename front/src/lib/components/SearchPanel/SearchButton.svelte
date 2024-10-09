<script lang="ts">
  import Spinner from "../Spinner.svelte";

  export let isFetching: boolean = false;

</script>

<div class="flex flex-row h-full w-[10rem] p-1">
  <button on:click class="flex flex-row gap-2 px-4 items-center justify-center h-full w-full rounded-lg {isFetching ? "cursor-default" : "hover:bg-cblueHover"} bg-cblue duration-200">
    {#if isFetching}
      <Spinner />
    {:else}
      <span class="font-poppins text-white"> Rechercher </span>
    {/if}
  </button>
</div>