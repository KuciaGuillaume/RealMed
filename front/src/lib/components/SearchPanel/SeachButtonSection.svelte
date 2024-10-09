<script lang="ts">
  import { onMount, tick } from 'svelte';
  import Fa from 'svelte-fa';
  import { faNotesMedical, faSearch, faX } from '@fortawesome/free-solid-svg-icons';
  import { fly } from 'svelte/transition';

  let isSelected = false;
  let inputElement: HTMLInputElement | null = null;
  export let drugs : { name: string, shortDescription: string}[] = [];
  
  export let query = '';

  const handleClick = async () => {
    isSelected = !isSelected;

    if (isSelected) {
      await tick();
      inputElement?.focus();
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

  const handleKeyDown = (event: any) => {
    if (event.code === "Space") {
      event.stopPropagation();
      event.preventDefault();
      query = query + " ";
    }
  };

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
      <span class="font-poppins text-sm line-clamp-1 text-left {query == "" ? "text-gray-600" : ""}">{query == "" ? "Que cherchez-vous ?" : query}</span>
    {:else}
      <input
        bind:this={inputElement}
        bind:value={query}
        on:keydown={handleKeyDown}
        placeholder="Que cherchez-vous ?"
        class="font-poppins text-sm w-full outline-none bg-transparent"
      />
    {/if}
  </div>
  {#if !isSelected && query != ""}
    <div class="h-full aspect-square flex items-center justify-center">
      <button on:click={() => query=""} class="p-2">
        <Fa icon={faX} class="text-gray-500" size="xs" color="black" />
      </button>
    </div>
  {/if}
  {#if isSelected}
    <div in:fly={{ duration: 100, y: 10 }} out:fly={{ duration: 100, y: 10 }} class="absolute top-full left-0 pt-4 w-40">
      <div class="flex flex-col w-[450px] max-h-60 h-fit rounded-xl bg-white shadow-md border overflow-hidden p-2 overflow-y-scroll gap-2">
        {#each drugs as drug}
          {#if query == "" || drug.name.toLowerCase().includes(query.toLowerCase())}
          <button
            on:click={() => query=drug.name} 
            class="flex flex-row w-full min-h-20 items-center justify-start p-2 px-4 hover:bg-gray-100 rounded-xl cursor-pointer gap-4">
            <div class="flex items-center justify-center h-full aspect-square">
              <Fa icon={faNotesMedical} class="text-gray-500" size="lg" color={"#0279C2"} />
            </div>
            <div class="flex flex-col h-full justify-center items-start flex-grow">
              <span class="font-poppins text-sm text-left">{drug.name}</span>
              <span class="font-poppins text-xs text-gray-500 text-left">{drug.shortDescription}</span>
            </div>
          </button>
          {/if}
        {/each}
      </div>
    </div>
  {/if}
</button>