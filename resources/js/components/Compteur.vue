<template>
  <div class="flex flex-col items-center py-3">
    <div class="inline-flex items-center">
      <button
        @click="decrementerCompteur"
        class="bg-main rounded-l border text-gray-600 hover:bg-gray-50 active:bg-gray-200 disabled:opacity-50 inline-flex items-center px-2 py-1 border-r border-gray-200"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
        </svg>
      </button>
      <div
        v-if="!editerManuellement"
        @click="editerManuellement = true"
        class="bg-gray-50 text-gray-600 hover:bg-gray-50 inline-flex items-center px-4 py-1 select-none min-w-8"
      >
        {{ compteur }}
      </div>
      <input
        v-if="editerManuellement"
        type="number"
        min="0"
        step="1"
        v-model="compteur"
        @keyup="editer($event.target.value)"
        @blur="editerManuellement = false"
        class="bg-gray-200 text-gray-600 hover:bg-gray-50 inline-flex items-center px-4 py-1 select-none min-w-8 w-12"
      />
      <button
        @click="incrementerCompteur"
        class="bg-main rounded-r border text-gray-600 hover:bg-gray-50 active:bg-gray-200 disabled:opacity-50 inline-flex items-center px-2 py-1 border-r border-gray-200"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
// 2 param nombre de bouteille et l'id du cellier
// éditerManuellement est faux par défaut donc on incrémente avec + et -
// si on clique sur l'input, alors éditerManuellement devient vrai
export default {
  props: ["nbbouteille", "id", "idcellier", "historique"],
  data() {
    return {
      compteur: this.nbbouteille,
      editerManuellement: false,
    };
  },
  methods: {
    // à chaque incrémentation modifier le nombre de bouteille dans la database
    incrementerCompteur() {
      this.compteur++;
      this.modifierNbBouteille();
    },
    decrementerCompteur() {
      if (this.compteur > 0) {
        this.compteur--;
        this.modifierNbBouteille();
      }
    },
    // modifier avec la méthode axios .put l'url de la page avec nombre de bouteilles
    modifierNbBouteille() {
      // envoyer vers la route de modification vers webd.php
      let url = window.location.origin + "/celliers/" + this.idcellier + "/" + this.id;
      axios
        .put(url, { nbbouteille: this.compteur })
        .then((response) => {
          //console.log(response.data);
        })
        .catch((error) => {
          //console.log(error);
        });
    },
    // éditer manuellement lorsqu'on clique sur le compteur
    editer(number) {
      if (number === "") {
        this.compteur = this.compteurPrecedent
      } else {
        this.compteur = number
        this.modifierNbBouteille()
      }
    }
  },
};
</script>
