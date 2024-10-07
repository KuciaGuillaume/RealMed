<script lang="ts">
  import PersonSpecificity from "./PersonSpecificity.svelte";
  import Restrictions from "./Restrictions.svelte";
  import SeachButtonSection from "./SeachButtonSection.svelte";
  import SearchButton from "./SearchButton.svelte";
  import Separator from "./Separator.svelte";


</script>

<div class="relative flex justify-center w-full h-96 bg-cgray">
  <div class="flex z-0 absolute right-0 bottom-0">
    <img src="/search_illustration.png" alt="search_illustration" class="w-[600px] aspect-auto">
  </div>
  <div class="flex z-10 flex-col max-w-[60rem] w-full p-10 gap-10">
    <div class="flex flex-col gap-2">
      <h2 class="font-poppins text-3xl font-semibold"> Découvrez les médicaments que vous prenez au quotidien.  </h2>
      <h3 class="font-poppins text-black/70"> Analysez les compositions et prenez soin de votre bien-être. </h3>
    </div>
    <div class="flex flex-row w-full h-[4rem] bg-white rounded-xl shadow-md p-1 border relative gap-2 z-10">
      <SeachButtonSection />
      <Separator />
      <PersonSpecificity />
      <Separator />
      <Restrictions />
      <SearchButton />
    </div>
  </div>
</div>