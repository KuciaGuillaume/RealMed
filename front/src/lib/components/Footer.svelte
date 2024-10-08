<script>
  import { slide } from "svelte/transition";
</script>

<div
    out:slide={{ duration: 300, axis: 'y' }}
    in:slide={{ duration: 300, axis: 'y' }}
    class="w-full flex flex-row font-poppins text-sm gap-10 bottom-px left-px h-16 text-center align-text-bottom items-center justify-center bg-cgray text-cblueHover"
    style="text-transform:uppercase"
>
    <a href="about">A propos de nous</a>
    <a href="legal_notices">Mentions légales</a>
    <a href="contact_us">Nous contacter</a>
    <a href="personal_data">Données personnelles</a>
</div>
