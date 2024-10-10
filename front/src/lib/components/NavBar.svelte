<script lang="ts">
  import { onMount } from "svelte";
  import Fa from "svelte-fa";
  import { faStar, faRightFromBracket, faHeadphones } from "@fortawesome/free-solid-svg-icons";
  import { isLoggerStore } from "$lib/store";

  let isOpen = false;

  const toggleMenu = (event: { stopPropagation: () => void }) => {
    event.stopPropagation();
    isOpen = !isOpen;
  };

  let dropdown: HTMLDivElement;

  const handleLogOut = async () => {
    const res = await fetch("/api/logout", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
    });
    $isLoggerStore = !res.ok ? 'logged' : 'notlogged';
  };

  onMount(() => {
    const pageClickEvent = (e: { target: any }) => {
      if (dropdown && !dropdown.contains(e.target)) {
        isOpen = false;
      }
    };
    setTimeout(() => {
      window.addEventListener("click", pageClickEvent);
    });
    return () => {
      window.removeEventListener("click", pageClickEvent);
    };
  });
</script>

<aside class="flex w-full h-16 bg-white border-b shadow-sm">
  <div class="flex items-center justify-between w-full h-full px-4">
    <div class="flex items-center">
      <a href="/" class="font-poppins text-xl text-cblue font-semibold">RealMed</a>
    </div>
    {#if $isLoggerStore != 'fetching'}
      <div class="relative flex items-center">
        {#if $isLoggerStore == 'logged'}
          <!-- menu burger -->
          <button
            type="button"
            class="block text-black hover:text-cblueHover focus:text-cblueHover focus:outline-none"
            on:click|stopPropagation={toggleMenu}
          >
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"
              ></path>
            </svg>
          </button>

          <!-- dropdown menu -->
          {#if isOpen}
            <div
              class="absolute right-0 top-10 w-48 bg-white rounded-md shadow-xl origin-top-right ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
              role="menu"
              aria-orientation="vertical"
              aria-labelledby="options-menu"
              bind:this={dropdown}
            >
              <div class="py-1" role="none">
                <a on:click={() => isOpen = false} href="/favoris" class="flex px-4 py-2 gap-4 hover:bg-gray-100">
                  <div class="h-full aspect-square items-center justify-start">
                    <Fa icon={faStar} class="text-cblue" size="lg" />
                  </div>
                  <span class="font-poppins text-sm text-gray-700">Favoris</span>
                </a>
                <a on:click={() => isOpen = false} href="/help_and_support" class="flex px-4 py-2 gap-4 hover:bg-gray-100">
                  <div class="h-full aspect-square items-center justify-start">
                    <Fa icon={faHeadphones} class="text-cblue" size="lg" />
                  </div>
                  <span class="font-poppins text-sm text-gray-700">Aide et support</span>
                </a>
                <button on:click={handleLogOut} class="flex px-4 py-2 gap-4 hover:bg-gray-100 w-full">
                  <div class="h-full aspect-square items-center justify-start">
                    <Fa icon={faRightFromBracket} class="text-cblue" size="lg" />
                  </div>
                  <span class="font-poppins text-sm text-gray-700">Se déconnecter</span>
                </button>
              </div>
            </div>
          {/if}
        {:else}
          <div class="flex flex-row gap-4 items-center">
            <a
              href="/help_and_support"
              class="font-poppins ml-4 text-sm font-medium text-gray-500">
              Aide et support
            </a>
            <a
              href="/favoris"
              class="font-poppins ml-4 text-sm font-medium text-gray-500 mr-10">
              Favoris
            </a>
            <a
              href="/signin"
              class="p-2 rounded-lg font-poppins text-sm font-medium text-white bg-cblue hover:bg-cblueHover"
              >Se connecter</a
            >
            <a href="/signin" class="font-poppins text-sm font-medium text-gray-500">S'inscrire</a>
          </div>
        {/if}
      </div>
    {/if}
  </div>
</aside>
