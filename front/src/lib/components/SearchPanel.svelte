<script lang="ts">
  import SeachButtonSection from "./SeachButtonSection.svelte";


</script>

<div class="flex justify-center w-full h-96 bg-cgray">
  <div class="flex flex-col max-w-[60rem] w-full p-10 gap-10">
    <div class="flex flex-col gap-2">
      <h2 class="font-poppins text-3xl font-semibold"> Découvrez les médicaments que vous prenez au quotidien.  </h2>
      <h3 class="font-poppins text-black/70"> Analysez les compositions et prenez soin de votre bien-être. </h3>
    </div>
    <div class="w-full h-[4rem] bg-white rounded-xl shadow-md p-1 border relative">
      <SeachButtonSection />
    </div>
  </div>
</div>