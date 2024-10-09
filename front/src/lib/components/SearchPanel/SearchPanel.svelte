<script lang="ts">
  import { goto } from "$app/navigation";
  import { fly, slide } from "svelte/transition";
  import PersonSpecificity from "./PersonSpecificity.svelte";
  import Restrictions from "./Restrictions.svelte";
  import SeachButtonSection from "./SeachButtonSection.svelte";
  import SearchButton from "./SearchButton.svelte";
  import Separator from "./Separator.svelte";
  import Fa from "svelte-fa";
  import { faArrowLeft } from "@fortawesome/free-solid-svg-icons";
  import { onMount } from "svelte";
  import { selectedDrugStore } from "$lib/store";

  let selectedDrug  = "";
  let selectedCondition = "";
  let selectedAllergie = "";
  let drugs : { name: string, shortDescription: string }[] = [];

  export let isSearched = false;
  export let isLargePanel = false;
  export let drugData : DrugResult[] | null = null;

  let isFetching = false;
  let isMounted = false;
  let fetchedOnce = false;

  const handleSearch = async () => {
    isFetching = true;
    const res = await fetch(`/api/drug?drugName=${selectedDrug}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    });
    if (!res.ok) {
      isFetching = false;
      return;
    }
    drugData = await res.json();

    const params = new URLSearchParams();
    if (selectedDrug) {
      params.append('drug', selectedDrug);
    }
    if (selectedCondition) {
      params.append('condition', selectedCondition);
    }
    if (selectedAllergie) { 
      params.append('allergie', selectedAllergie);
    }

    if (params.toString() === '') {
      params.append('drug', 'Doliprane');
    }

    goto(`?${params.toString()}`);
    isFetching = false;
    selectedDrugStore.set("");
    fetchedOnce = true;
  }

  onMount(async () => {
    isMounted = true;

    if (isSearched) isFetching = true;
    const res = await fetch('/api/drugs', {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json'
      }
    });
    drugs = await res.json();

    if (isSearched && !fetchedOnce) {
      selectedDrug = drugs.find((drug) => drug.name.toLowerCase() === (drug.name || "").toLowerCase())?.name || "";
      handleSearch();
    }
  });

</script>

<div class="relative flex justify-center w-full duration-200  {isSearched ? isLargePanel ? 'h-0' : 'h-40 bg-white border-b' : 'h-96 bg-cgray'}">
  <div class="flex z-0 absolute right-0 bottom-0">
    <img src="/search_illustration.png" alt="search_illustration" class="{isSearched ? isLargePanel ? 'h-0' : 'h-40' : 'h-96'} duration-200 aspect-auto">
  </div>
  {#if isMounted && (!isLargePanel || !isSearched)}
    <div 
      in:fly={{ duration: 300, y: -10 }}
      class="flex flex-col max-w-[60rem] w-full p-10 z-20">
      {#if !isSearched}
        <div out:slide={{ duration: 300 }} in:slide={{ duration: 300 }} class="flex flex-col gap-2">
          <h2 class="font-poppins text-3xl font-semibold"> Découvrez les médicaments que vous prenez au quotidien.  </h2>
          <h3 class="font-poppins text-black/70"> Analysez les compositions et prenez soin de votre bien-être. </h3>
        </div>
      {/if}
      <div 
        in:fly={{ duration: 300, y: -10 }} class="flex flex-row gap-4">
        {#if isSearched}
          <div class="flex flex-row min-w-[4rem] min-h-[4rem] bg-white rounded-xl shadow-md border relative gap-2 z-10 duration-200">
            <button 
              on:click={() => goto('/')}
              class="size-full flex items-center justify-center hover:bg-gray-50 rounded-xl duration-200">
              <Fa icon={faArrowLeft} />
            </button>
          </div>
        {/if}
        <div
          in:fly={{ duration: 300, y: -10 }}
          class="flex flex-row w-full h-[4rem] bg-white rounded-xl shadow-md p-1 border relative gap-2 z-20 {isSearched ? '': 'mt-6'} duration-200">
          <SeachButtonSection bind:query={selectedDrug} bind:drugs />
          <Separator />
          <PersonSpecificity bind:query={selectedCondition} />
          <Separator />
          <Restrictions bind:query={selectedAllergie} />
          <SearchButton on:click={handleSearch} bind:isFetching />
        </div>
      </div>
    </div>
  {/if}
</div>