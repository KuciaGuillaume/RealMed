<script lang="ts">
  import { tick } from 'svelte';
  import Fa from 'svelte-fa';
  import { faSearch, faX } from '@fortawesome/free-solid-svg-icons';
  import { fly } from 'svelte/transition';

  let isSelected = false;
  let inputEl: HTMLInputElement | null = null;
  let value = '';

  const handleClick = async () => {
    isSelected = !isSelected;

    if (isSelected) {
      await tick();
      inputEl?.focus();
    }
  };

  function clickOutside(node: HTMLElement) {
    const handleOutsideClick = (event: MouseEvent) => {
      if (node && !node.contains(event.target as Node)) {
        isSelected = false;
      }
    };

    document.addEventListener('click', handleOutsideClick, true);

    return {
      destroy() {
        document.removeEventListener('click', handleOutsideClick, true);
      },
    };
  }
</script>

<button
  use:clickOutside
  on:click={handleClick}
  class="flex flex-row h-full w-[15rem] rounded-lg duration-200 {isSelected ? 'border-cblue border-2' : 'hover:bg-gray-100 border-2 border-transparent'} cursor-text">
  <div class="flex items-center justify-center h-full aspect-square">
    <Fa icon={faSearch} class="text-gray-500" size="lg" color="black" />
  </div>
  <div class="flex flex-col h-full justify-center items-start flex-grow">
    <span class="font-poppins text-xs text-gray-500">Médicament</span>
    {#if !isSelected}
      <span class="font-poppins text-sm">{value == "" ? "Doliprane" : value}</span>
    {:else}
      <input
        bind:this={inputEl}
        bind:value={value}
        placeholder="Que cherchez-vous ?"
        class="font-poppins text-sm w-full outline-none bg-transparent"
      />
    {/if}
  </div>
  {#if !isSelected}
    <div class="h-full aspect-square flex items-center justify-center">
      <button on:click={() => value=""} class="p-2">
        <Fa icon={faX} class="text-gray-500" size="xs" color="black" />
      </button>
    </div>
  {/if}
  {#if isSelected}
    <div in:fly={{ duration: 100, y: 10 }} out:fly={{ duration: 100, y: 10 }} class="absolute top-full left-0 pt-4 w-40 h-60">
      <div class="flex flex-col w-[450px] h-40 rounded-xl bg-white shadow-md border overflow-hidden">
      </div>
    </div>
  {/if}
</button>