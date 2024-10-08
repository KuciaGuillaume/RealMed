<script lang="ts">
  import { fly, slide } from "svelte/transition";
  import NewsCard from "./NewsCard.svelte";

  const news = [
    {
      title: "La FDA approuve un nouveau médicament contre Alzheimer",
      content: "La FDA a approuvé Leqembi, un nouveau médicament conçu pour ralentir la progression de la maladie d'Alzheimer, offrant de l'espoir à des millions de patients et à leurs familles.",
      date: "2023-07-10",
      imgLink: "https://media.ouest-france.fr/v1/pictures/MjAyMjEyY2I4YzA4MTRlZTkxMTc0NzFjYzJiNGM3NjdmYmU1ZjY?width=1260&height=708&focuspoint=0%2C0&cropresize=1&client_id=bpeditorial&sign=9c872daaad170cb1bed798c520b7a15131b5242071edaa4db7e8523aa37700ae",
    },
    {
      title: "L'OMS déclare la fin de l'urgence sanitaire mondiale du COVID-19",
      content: "L'Organisation mondiale de la santé a officiellement déclaré la fin de l'urgence sanitaire mondiale liée au COVID-19, marquant une étape importante dans la lutte contre la pandémie.",
      date: "2023-05-05",
      imgLink: "https://www.un.org/sites/un2.un.org/files/field/image/2023/05/image1170x530cropped_0.jpg",
    },
    {
      title: "Une avancée dans l'immunothérapie contre le cancer",
      content: "Des scientifiques ont développé un nouveau traitement d'immunothérapie qui montre une efficacité prometteuse dans le ciblage et l'élimination des cellules cancéreuses.",
      date: "2023-08-20",
      imgLink: "https://www.leem.org/sites/default/files/inline-images/25_Les%20sept%20etapes%20cles%20Immunotherapie_0.jpg",
    },
    {
      title: "Augmentation des problèmes de santé mentale chez les adolescents",
      content: "De récentes études indiquent une augmentation significative des troubles de santé mentale chez les adolescents, ce qui incite à une demande accrue de soutien et de ressources.",
      date: "2023-09-05",
      imgLink: "https://drees.solidarites-sante.gouv.fr/sites/default/files/2021-10/ER%201210%20EpiCov%20Graph.%20de%20UNE%20WEB%2001_0.jpg",
    },
    {
      title: "Un nouveau vaccin contre le paludisme montre une haute efficacité",
      content: "Un nouveau vaccin contre le paludisme a démontré une haute efficacité lors d'essais cliniques, offrant l'espoir de sauver des millions de vies dans les régions endémiques.",
      date: "2023-06-30",
      imgLink: "https://www.africanconstituency.org/wp-content/uploads/2021/11/shutterstock_1744369802_h2.jpg",
    }
  ]

</script>

<div 
  out:slide={{ duration: 300, axis: 'y' }}
  in:slide={{ duration: 300, axis: 'y' }}
  class="flex z-0 w-full justify-center flex-col">
  <div class="flex z-10 max-w-[60rem] w-full p-10 gap-4 h-fit">
    <h2 class="font-poppins text-xl text-cblueHover font-semibold">
      Fil d’actualitées
    </h2>
  </div>
  <div class="w-full flex flex-row gap-4 overflow-x-auto px-10 pb-10 scroll-container">
    {#each news as item}
      <NewsCard {item} />
    {/each}
  </div>
</div>

<style>
  .scroll-container {
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .scroll-container::-webkit-scrollbar {
    display: none;
  }
</style>