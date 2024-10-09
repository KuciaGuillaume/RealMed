<script lang="ts">
  import { onMount } from "svelte";
  import { goto } from "$app/navigation";
  import { Fa } from "svelte-fa";
  import { faTrash, faSearch } from "@fortawesome/free-solid-svg-icons";

  let isLoggedIn = true; // ! Development purpose only

  // Redirect to home page
  onMount(() => {
    if (!isLoggedIn) {
      goto("/signin");
      return;
    }
  });

  let profile = {
    name: "Nom Prénom",
    email: "admail@mail.com",
    birthdate: "01/01/2000",
    phone: "06 12 34 56 78",
  };

  let favorites = [
    {
      name: "Nom du médicament",
      description: "Description du médicament",
      img: "https://via.placeholder.com/100",
    },
    {
      name: "Nom du médicament",
      description: "Description du médicament",
      img: "https://via.placeholder.com/100",
    },
    {
      name: "Nom du médicament",
      description: "Description du médicament",
      img: "https://via.placeholder.com/100",
    },
  ];
</script>

{#if isLoggedIn}
  <div class="flex z-0 w-full justify-center">
    <div class="z-10 max-w-[60rem] w-full px-10 py-4">
      <h1 class="font-poppins text-xl text-black font-semibold py-4">Bienvenue sur votre profil</h1>

      <img src="https://via.placeholder.com/200" alt="profil img" class="rounded-full" />

      <div class="flex flex-col gap-4 py-10">
        <p class="font-poppins text-lg text-cblue font-semibold">{profile.name}</p>
        <p class="font-poppins text-base text-gray-700">
          Email : <span>{profile.email}</span>
        </p>
        <p class="font-poppins text-base text-gray-700">
          Date de naissance : <span>{profile.birthdate}</span>
        </p>
        <p class="font-poppins text-base text-gray-700">
          Numéro de téléphone : <span>{profile.phone}</span>
        </p>
      </div>
    </div>

    <div class="flex flex-col w-full px-10 py-4 overflow-y-auto">
      <h2 class="font-poppins text-xl text-cblue font-semibold py-4">Vos favoris</h2>

      {#if Array.isArray(favorites) && favorites.length > 0}
        <div class="flex flex-col max-h-[70vh] overflow-y-auto w-fit w-full">
          {#each favorites as favorite}
            <div
              class="flex items-center gap-4 md:gap-10 pr-10 rounded-lg transition-all duration-300 ease-in-out hover:bg-cgray p-2"
            >
              <img
                src={favorite.img}
                alt={`Image of ${favorite.name}`}
                class="w-16 h-16 md:w-20 md:h-20 rounded-lg object-cover"
              />
              <div class="flex flex-col gap-1 md:gap-2 flex-grow">
                <p class="font-poppins text-base md:text-lg text-cblue font-semibold">
                  {favorite.name}
                </p>
                <p class="font-poppins text-sm md:text-base text-gray-700">
                  {favorite.description}
                </p>
              </div>
              <button
                class="p-2 rounded-lg font-poppins text-sm font-medium text-white bg-cred hover:bg-credHover focus:outline-none focus:ring-2 focus:ring-cred focus:ring-opacity-50"
                aria-label="Remove {favorite.name} from favorites"
              >
                <Fa icon={faTrash} class="text-white m-1" />
              </button>
            </div>
          {/each}
        </div>
      {:else}
        <div class="flex flex-col overflow-y-auto w-full h-fit justify-center items-center">
          <!-- Placeholders items -->
          {#each Array(3) as _}
            <div
              class="flex items-center rounded-lg bg-gray-200 animate-pulse py-2 my-1 w-full h-20"
            ></div>
          {/each}

          <!-- Not found indication -->
          <div class="flex flex-col items-center absolute w-fit">
            <Fa icon={faSearch} class="text-black" />
            <p class="text-gray-500 text-center text-sm leading-tight">
              Aucun favori trouvé.<br />Recherchez un médicament pour l'ajouter à vos favoris !
            </p>
          </div>
        </div>
      {/if}
    </div>
  </div>
{/if}
