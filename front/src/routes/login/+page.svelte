<script lang="ts">
  import { goto } from "$app/navigation";
  import { registerEmailStore } from "$lib/store";
  import { faCheck } from "@fortawesome/free-solid-svg-icons";
  import { onMount } from "svelte";
  import Fa from "svelte-fa";
  import { faChevronRight, faEye, faEyeSlash } from "@fortawesome/free-solid-svg-icons";
  import { fly } from "svelte/transition";
  import Spinner from "$lib/components/Spinner.svelte";

  let isPasswordVisible = false;
  let inputElement: HTMLInputElement | null = null;
  let inputValue: string = '';
  let isFocused = false;
  let isInvalidPassword = false;
  let isLoading = false;

  $: if (inputValue) isInvalidPassword = false;

  const handlePasswordVisibility = () => {
    isPasswordVisible = !isPasswordVisible;
  };

  const handleOnFocus = () => {
    isFocused = true;
  };

  const handleOnBlur = () => {
    isFocused = false;
  };

  const getPasswordStrength =(password: string): number => {
    let score = 0;
    const length = password.length;

    if (length <= 0)
      return 0;

    if (length >= 8) {
      score += 25;
    } else if (length >= 5) {
      score += 10;
    }

    if (/[a-z]/.test(password)) {
      score += 15;
    }

    if (/[A-Z]/.test(password)) {
      score += 20;
    }

    if (/[0-9]/.test(password)) {
      score += 20;
    }

    if (/[^A-Za-z0-9]/.test(password)) {
      score += 20;
    }

    if (score > 100) {
      score = 100;
    }

    return score;
  }

  const login = async () => {

    isLoading = true;

    const res = await fetch('/api/login', {
      method: 'POST',
      body: JSON.stringify({
        username: $registerEmailStore,
        password: inputValue
      }),
      credentials: 'include',
    });

    if (!res.ok) {
      isInvalidPassword = true;
      isLoading = false;
      return;
    } else {
      goto('/');
    }

    isLoading = false;
    
  }

  onMount(() => {
    if ($registerEmailStore == null || $registerEmailStore == '') {
      goto('/signin');
    }
  });

</script>

<main class="flex flex-row items-center justify-center w-full h-screen py-[7rem]">
  <div class="flex flex-row gap-14 max-w-[58rem] w-full h-full">
    <div class="flex flex-col h-full w-[55%] bg-cgray rounded-xl overflow-hidden">
      <div class="w-full aspect-video">
        <img src="/medical_illustration.jpg" alt="" class="object-cover size-full">
      </div>
      <div class="w-full flex flex-grow items-end">
        <div class="flex flex-col gap-2 w-full p-8">
          <h2 class="font-poppins font-semibold text-lg pb-1">Préparez-vous à :</h2>
          <span class="font-poppins flex flex-row gap-4 text-sm items-center">
            <Fa icon={faCheck}/>
            Obtenir rapidement des informations fiables sur vos médicaments.
          </span>
          <span class="font-poppins flex flex-row gap-4 text-sm items-center">
            <Fa icon={faCheck}/>
            Trouver gratuitement les médicaments les mieux adaptés à vos besoins.
          </span>
        </div>
      </div>
    </div>
    <div 
      in:fly|global={{ duration: 600, x: 50, delay: 500 }}
      out:fly|global={{ duration: 200, y: -50 }}
      class="h-full w-[45%]">
      <a href="/" class="font-poppins text-2xl text-cblue font-semibold">RealMed</a>
      <div class="w-full h-[calc(100%-32px)] flex flex-col justify-center gap-4">
        <a href="/signin" class="text-sm flex flex-row gap-2 items-center font-poppins">
          <Fa icon={faChevronRight} size="sm" class="rotate-180" />
          {$registerEmailStore}
        </a>
        <h2 class="font-poppins text-2xl font-semibold">
          Entrer votre mot de passe
        </h2>
        <div class="flex flex-col gap-2">
          <div class="flex flex-row justify-between h-4">
            <span class="font-poppins text-xs font-semibold">
              Mot de passe
            </span>
            <button 
              on:click={handlePasswordVisibility}
              class="h-full aspect-square pr-2">
              {#if !isPasswordVisible}
                <Fa icon={faEyeSlash} class="text-white" size="sm" color="black" />
              {:else}
                <Fa icon={faEye} class="text-white" size="sm" color="black" />
              {/if}
            </button>
          </div>
          <div class="flex flex-row w-full h-fit border {isInvalidPassword ? 'bg-red-100 border-red-500' : ''} rounded-lg {isFocused ? "outline outline-cblue outline-offset-2 outline-[2px]": ""}">
            {#if isPasswordVisible}
              <input 
                on:focus={handleOnFocus}
                on:blur={handleOnBlur}
                bind:this={inputElement}
                bind:value={inputValue}
                type="text"
                class="w-full h-12 pl-4 outline p-2 outline-none rounded-lg border-none bg-transparent" 
                placeholder="Saisissez votre mot de passe"
              >
            {:else}
              <input 
                on:focus={handleOnFocus}
                on:blur={handleOnBlur}
                bind:this={inputElement}
                bind:value={inputValue}
                type="password" 
                class="w-full h-12 pl-4 outline p-2 outline-none rounded-lg border-none bg-transparent" 
                placeholder="Saisissez votre mot de passe"
              >
            {/if}
          </div>
          <button 
            on:click={login}
            class="w-full h-12 bg-cblue text-white font-poppins rounded-lg hover:bg-cblueHover font-semibold">
            {#if !isLoading}
              Se connecter
            {:else}
              <Spinner />
            {/if}
          </button>
        </div>
        <a href="/password_forgot" class="font-poppins text-xs pt-2 text-cblue hover:underline">
          Mot de passe oublié ?
        </a>
      </div>
    </div>
  </div>
</main>