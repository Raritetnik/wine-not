<template>
  <div class="flex flex-col">
    <div class="grid">
      <div class="flex flex-col relative mb-4">
        <div class="flex justify-between items-center rounded border-2 border-secondary">
        <input type="text" class="border-2 rounded border-l-secondary border-t-secondary border-b-secondary  hover-no-box-shadow hover-no-border-color placeholder-accent_wine w-full font-medium tracking-wide px-6  h-11 text-accent_wine transition duration-200  focus:outline-none" :placeholder="!this.loaded ? 'Chargement en cours...' : 'Recherche'" @keyup="showSearchOptions($event.target.value);"
        :value="this.textInput">
        <img :src="require('/img/svg/loop.svg')" alt="loop" class="px-2 transition-opacity duration-200 hover:opacity-80">
      </div>
        <input name="vino_bouteille_id" type="hidden" :value="this.choixBouteille.id">
      </div>
      <ResultatsRecherche :closest-vine-list="closestVineList" @take-bouteille="takeBouteille"></ResultatsRecherche>
    </div>
    <div>
      <div v-if="selectedVine" class="flex gap-3 bg-gray-100 rounded-md w-full p-2 border-2 border-secondary">
        <header>
          <img :src="showImage(this.choixBouteille)" :alt="this.choixBouteille.nom" class="object-cover max-w-100 h-[150px]">
        </header>
        <div>
          <h2 class="font-bold text-md text-accent_wine">{{ this.choixBouteille.nom }}</h2>
          <h3 style="color: var(--color_text)">{{ this.choixBouteille.type }} | {{ this.choixBouteille.format }} | {{ this.choixBouteille.pays }} </h3>
          <h2 class="font-bold text-md text-section_title">${{ this.choixBouteille.prix_saq }} CAD</h2>
          <input name="prix_saq" type="hidden" :value="this.choixBouteille.prix_saq">
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import ResultatsRecherche from './ResultatsRecherche.vue';

export default {
  props: ['bouteilles', 'user'],
  components: {
    ResultatsRecherche
  },
  data() {
    return {
      isMenuOpen: false,
      textInput: '',
      loaded: false,
      vineList: [],
      closestVineList: [],
      choixBouteille: {},
      selectedVine: false
    };
  },
  methods: {
    /**
     * Recherche de bouteilles de vin par: Nom, Type, Pays, Format
     * Retourne seulement les 4 premiers résultats
     * @param {string} text - Texte saisie par l'utilisateur
     * @return {array} closestVineList - La liste des bouteilles compatibles
     */
    showSearchOptions (text) {
      this.selectedVine = false;
      this.textInput = text;
      // Code pour filtrer la recherche
      this.closestVineList = [];
      if(text !== "" && text.length >= 2) {
        // Only START WITH NAME ELEMENTS --- FIRST
        this.vineList.forEach( (vine) => {
          if(vine.utilisateur_id === null || this.user === vine.utilisateur_id) {
            // Recherche par le nom
            if(String(vine.nom.toLowerCase()).startsWith(text.toLowerCase())) {
              this.closestVineList.push(vine)
            }

            // Recherche par le type
            if(String(vine.type.toLowerCase()).startsWith(text.toLowerCase())) {
              this.closestVineList.push(vine)
            }

            // Recherche par le pays
            if(String(vine.pays.toLowerCase()).startsWith(text.toLowerCase())) {
              this.closestVineList.push(vine)
            }

            // Recherche par le format
            if(String(vine.format.toLowerCase()).startsWith(text.toLowerCase())) {
              this.closestVineList.push(vine)
            }
          }
        })

        // Only CONTAINS && NOT START WITH --- AFTER
        this.vineList.forEach( (vine) => {
          if(vine.utilisateur_id === null || this.user === vine.utilisateur_id) {
            // Recherche par le nom
            if(!String(vine.nom.toLowerCase()).startsWith(text.toLowerCase())
            && String(vine.nom.toLowerCase()).includes(text.toLowerCase())) {
              this.closestVineList.push(vine);
            }

            // Recherche par le type
            if(!String(vine.type.toLowerCase()).startsWith(text.toLowerCase())
            && String(vine.type.toLowerCase()).includes(text.toLowerCase())) {
              this.closestVineList.push(vine);
            }

            // Recherche par le pays
            if(!String(vine.pays.toLowerCase()).startsWith(text.toLowerCase())
            && String(vine.pays.toLowerCase()).includes(text.toLowerCase())) {
              this.closestVineList.push(vine);
            }

            // Recherche par le format
            if(!String(vine.format.toLowerCase()).startsWith(text.toLowerCase())
            && String(vine.format.toLowerCase()).includes(text.toLowerCase())) {
              this.closestVineList.push(vine);
            }
          }
        })
        this.closestVineList = this.closestVineList.slice(0, 4);
      }
    },

    /**
     * Enregistrmenet de selection de la bouteille par l'utilisateur
     * @param {*} vine
     */
    takeBouteille (vine) {
      this.textInput = vine.nom
      this.choixBouteille = vine;
      this.selectedVine = true;
      this.closestVineList = [];
    },
    showImage (vine) {
      try {
        if(vine.url_img == null) {
          return require("/storage/uploads/"+vine.image);
        } else {
          return vine.url_img;
        }
      } catch (e) {
        return vine.url_img;
      }
    }
  },
  /**
   * Méthode API:
   * Téléchargement des toutes les bouteilles dans la base de données
   */
  async beforeMount () {
      this.vineList = this.bouteilles;
      this.loaded = true;
  }
};
</script>