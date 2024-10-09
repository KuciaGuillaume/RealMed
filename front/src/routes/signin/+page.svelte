<script lang="ts">
  import { goto } from "$app/navigation";
  import { registerEmailStore } from "$lib/store";
  import { faCheck } from "@fortawesome/free-solid-svg-icons";
  import Fa from "svelte-fa";
  import { fly } from "svelte/transition";

  let inputValue: string = '';
  let errorMessage: string = '';
  let changed = false;

  $: if (inputValue) {
    changed = true;
  }

  const handleContinue = () => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    changed = false;

    if (!inputValue || !inputValue.trim()) {
      errorMessage = 'Le champ email ne peut pas être vide.';
    } else if (!emailRegex.test(inputValue)) {
      errorMessage = 'Veuillez entrer une adresse email valide.';
    } else {
      errorMessage = '';
      registerEmailStore.set(inputValue);

      // if user dot exist
      goto('/register');
      // else
      // goto('/login')
    }
  }

</script>

<main 
  class="flex flex-row items-center justify-center w-full h-screen py-[7rem]">
  <div class="flex flex-row gap-14 max-w-[58rem] w-full h-full">
    <div
      class="flex flex-col h-full w-[55%] bg-cgray rounded-xl overflow-hidden">
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
      in:fly|global={{ duration: 1000, x: 50, delay: 300 }}
      out:fly|global={{ duration: 200, y: -50 }}
      class="h-full w-[45%]">
      <a href="/" class="font-poppins text-2xl text-cblue font-semibold">RealMed</a>
      <div class="w-full h-[calc(100%-32px)] flex flex-col justify-center gap-4">
        <h2 class="font-poppins text-2xl font-semibold">
          Économisez plus grâce à votre statut de membre
        </h2>
        <div class="flex flex-col gap-2">
          <span class="font-poppins text-xs font-semibold">
            Connectez-vous ou créez un compte avec votre e-mail.
          </span>
          <input  
            bind:value={inputValue}
            type="email" 
            class="w-full h-12 pl-4 outline {errorMessage && errorMessage != '' && !changed ? 'outline-red-500 bg-red-100' : 'focus:outline-cblue'} border rounded-lg p-2 outline-none" 
            placeholder="Saisissez votre adresse e-mail"
          >
          {#if errorMessage && errorMessage !== '' && !changed}
            <p 
              role="alert" 
              class="FormFieldErrorMessage_errorHint text-red-500"
              data-testid="form-field-error-notification">
              {errorMessage}
            </p>
          {/if}
          <button 
            on:click={handleContinue}
            class="w-full h-12 bg-cblue text-white font-poppins rounded-lg hover:bg-cblueHover font-semibold">
            Continuer
          </button>
        </div>
        <p class="font-poppins text-xs pt-4">
          En créant un compte, vous acceptez notre <a href="/personal_data" class="text-cblue hover:underline">Charte de confidentialité</a>
          et nos <a href="/legal_notices" class="text-cblue hover:underline">Conditions générales d’utilisation.</a>
        </p>
      </div>
    </div>
  </div>
</main>

<style>
  .FormFieldErrorMessage_errorHint {
    border-radius: 4px;
    padding: 8px;
    width: 100%;
    z-index: 2;
    margin-top: 4px;
    font-size: .875rem;
    line-height: 18px;
    position: relative;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, .1), 0 2px 4px -2px rgba(0, 0, 0, .1);
    white-space: break-spaces;
  }

  .FormFieldErrorMessage_errorHint:before {
    content: "";
    position: absolute;
    left: 15px;
    top: -6px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    display: block;
    width: 12px;
    height: 12px;
  }

  .FormFieldErrorMessage_errorHint:after {
    content: "";
    position: absolute;
    left: 12px;
    width: 18px;
    background-color: #fff;
    height: 8px;
    top: 0;
  }

  .FormFieldErrorMessage_errorHint, .FormFieldErrorMessage_errorHint:before {
    border-width: 1px;
    border-style: solid;
    border-color: var(--color-dark-red);
    background-color: #fff;
  }
</style>
