<template>
    <article class="mx-auto bg-gray-100 flex gap-1 border px-4 py-3 rounded-md justify-between max-w-[560px] w-100">
        <header class="flex items-start relative">
            <img id="open_popup-modal" v-if="quantitecelliers > 1" :src="require('/img/svg/close.svg')" style="width: 25px; min-width: 25px;" class="" alt="close" :data-idCellier="this.cellier.id">
        </header>
        <a :href="'/celliers/'+this.cellier.id" class="desc flex flex-col justify-between py-4 gap-2">
            <header class="hover-carte" @click="redirection(this.cellier.id)">
                <h1 class="font-extrabold text-xl text-accent_wine">{{ this.cellier.nom }}</h1>
            </header>
            <span class="flex justify-between"><h3>Quantite totale bouteilles:</h3> <h3>{{ this.cellier.quantiteBouteilles }}/{{ this.cellier.quantite_max }}</h3></span>
            <h1 class="font-medium text-section_title text-lg"></h1>
            <footer class="flex gap-2 flex-wrap">
                <span>Description:</span>
                <h3 class="flex">{{ this.cellier.description }}</h3>
            </footer>
        </a>
        <footer class="flex flex-col justify-between items-end">
            <a :href="'/celliers-modifier/'+this.cellier.id">
                <img :src="require('/img/svg/modify.svg')" alt="modify" width="25">
            </a>
        </footer>
    </article>
</template>

<script>

export default {
    data() {
        return {
            estVide: false
        };
    },
    props: ['cellier', 'quantitecelliers'],
    methods: {
        // Supprimer l'element de la liste DOM
        supprimer () {
            axios.delete('/api.delete-cellier', { params: {
                    'CellierID': this.cellier.id
                }}) .then(response => {
                console.log('Modification est enrégistrée');
            });
            this.$el.parentElement.removeChild(this.$el)
        },
        redirection(cellier) {
            // rediriger en passant le id de la bouteille qui vient du @click sur la carte
            location.href = `${window.location.pathname}/cellier/${cellier}`;
        },
    },
};

</script>

<style lang="scss" scoped>
.desc {
    width: 30ch;
}
.carte {
    background-color: #DCDCDC;
}
</style>
