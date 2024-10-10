<script lang="ts">
  import { onMount } from "svelte";
  import { Fa } from "svelte-fa";
  import { faChevronLeft, faStar } from "@fortawesome/free-solid-svg-icons";
  import DrugItem from "$lib/components/DrugComparator/DrugItem.svelte";
  import { goto } from "$app/navigation";
  import { getScore } from "$lib/functions";
  import Spinner from "$lib/components/Spinner.svelte";
  import { isLoggerStore } from "$lib/store";
  import { fly } from "svelte/transition";

  let favorites : DrugResult[] = [];
  let innerHeight = 0;
  let isLoading = true;
  let isMounted = false;

  const onDrugHandleFavorite = (drug: string) => {
    favorites = favorites.filter(favorite => favorite.name !== drug);
  };

  const onDrugClick = (drug: DrugResult) => {
    goto(`/?drug=${drug.name}`);
  };

  // Redirect to home page
  onMount(async () => {
    isMounted = true;
    const res = await fetch("/api/favorite", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });
    favorites = await res.json();
    isLoading = false;
  });
</script>

<svelte:window bind:innerHeight />

{#if isMounted}
  <div class="flex z-0 w-full justify-center">
    <div class="flex flex-row w-full px-10 py-4 max-w-[70rem] pt-10 gap-8">
      <div class="w-[25%] h-fit flex flex-col gap-2">
        <a href="/" class="font-poppins text-cblue flex items-center flex-row gap-2 text-sm mb-2">
          <Fa icon={faChevronLeft} color={"rgb(2 121 194)"} />
          Back
        </a>
        <a 
          class="w-full h-12 rounded-xl hover:bg-gray-200 duration-200 flex items-center p-4 text-sm flex-row gap-2"
          href="/favoris">
          <div class="w-1 h-full bg-gray-700">

          </div>
          Favoris
        </a>
        <a 
          class="w-full h-12 rounded-xl hover:bg-gray-200 duration-200 flex items-center p-4 text-sm text-black/40 hover:text-black"
          href="/help_and_support">
          Aide et support
        </a>
      </div>
      <div 
        in:fly={{ duration: 200, y: 10 }}
        class="w-[75%] flex flex-col gap-4">
        {#if $isLoggerStore == 'notlogged'}
          <div class="flex w-full h-20 rounded-lg shadow-lg border flex-row pl-2">
            <div class="h-full w-14 flex justify-center pt-4">
              <div class="rounded-full w-8 h-8 flex items-center justify-center bg-cgray">
                <Fa icon={faStar} color={"rgb(2 121 194)"} />
              </div>
            </div>
            <div class="flex flex-col p-4 gap-1">
              <h2 class="font-poppins text-lg font-semibold">
                Prenez note de vos médicaments préférés
              </h2>
              <p class="font-poppins text-xs text-gray-600">
                <a href="/signin" class="text-cblueHover hover:underline">Connectez-vous ou créez un compte</a> pour enregistrer vos médicaments favoris sur votre compte.
              </p>
            </div>
          </div>
        {:else}
          <h1 class="font-poppins text-3xl font-semibold">
            Vos favoris
          </h1>
          {#if !isLoading}
            <div
              style="height: calc({innerHeight}px - 180px);"
              class="flex flex-col gap-4 pr-10 overflow-y-auto">
              {#if favorites.length > 0}
                {#each favorites as favorite}
                  <DrugItem 
                    on:click={() => onDrugClick(favorite)}
                    handleFavorite={onDrugHandleFavorite}
                    drug={{
                      name: favorite.name,
                      description: favorite.shortDescription,
                      imgLink: favorite.imageLink,
                      score: getScore(favorite),
                      data: favorite
                    }}
                  />
                {/each}
              {:else}
                  <p class="font-poppin text-gray-400 text-sm pl-1">
                    Il semblerais que vous n'avez pas encore mis de médicament en favoris. Vous pouvez ajouter des médicaments en favoris en cliquant sur la petite étoile sur la page de détails d'un médicament.
                  </p>
              {/if}
            </div>
          {:else}
            <div 
              style="height: calc({innerHeight}px - 180px);"
              class="size-full flex items-center justify-center">
              <Spinner size={"size-10"} />
            </div>
          {/if}
        {/if}
      </div>
    </div>
  </div>
{/if}
