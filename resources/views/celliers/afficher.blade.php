@extends('layouts.app')
@section('content')
<!-- Reste du doc pour visualiser -->
<div class="conteneur-de-toute-la-page">
    <div class="container pb-8 px-6 flex flex-col items-center justify-center mx-auto">
        <div class="w-full">
            <div class="rounded-md bg-gray-100 flex items-baseline gap-4 border px-4 py-3 sm:rounded justify-between w-full max-w-[560px] mx-auto" style="width:100%; padding: 16px;">
                <!-- Nom du cellier -->
                <div class="flex  flex-wrap gap-1 items-baseline  ps-3 sm:ps-0">
                    <a href="{{ route('celliers.index') }}" class="text-secondary flex-shrink-0 text-lg hover:opacity-70 transition-opacity duration-200 ease-in-out font-medium pe-3" alt="back">Mes Celliers <span class="text-xl sm:text-2xl">\</span></a>
                    <span class="flex-shrink-0 text-xl font-bold text-accent_wine sm:text-2xl"> {{$cellier->nom}} </span>
                </div>
                <div class="flex items-center ml-auto pe-3 sm:pe-0">
                    <!-- Modifier -->
                    <div class="flex items-right ml-auto mr-6" onclick="location.href=`{{ route('celliers.modifier', $cellier->id) }}`">
                        <div class="cursor-pointer mr-0 hover:opacity-70 transition-opacity duration-200 ease-in-out">
                            <svg width="23" height="23" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.7349 3.53024H6.72527C4.72124 3.53024 3.71922 3.53024 2.95378 3.92025C2.28048 4.26331 1.73307 4.81072 1.39001 5.48402C1 6.24946 1 7.25148 1 9.25551V19.2747C1 21.2788 1 22.2808 1.39001 23.0462C1.73307 23.7195 2.28048 24.2669 2.95378 24.61C3.71922 25 4.72124 25 6.72527 25H16.7445C18.7485 25 19.7505 25 20.516 24.61C21.1893 24.2669 21.7367 23.7195 22.0798 23.0462C22.4698 22.2808 22.4698 21.2788 22.4698 19.2747V14.2651M8.15656 17.8434H10.1539C10.7374 17.8434 11.0291 17.8434 11.3037 17.7775C11.5471 17.7191 11.7798 17.6227 11.9932 17.4919C12.2339 17.3444 12.4402 17.1381 12.8528 16.7255L24.2589 5.31939C25.247 4.33127 25.247 2.72921 24.2589 1.74109C23.2708 0.752971 21.6687 0.75297 20.6806 1.74109L9.27449 13.1472C8.8619 13.5598 8.65561 13.7661 8.50809 14.0068C8.37729 14.2202 8.28091 14.4529 8.22247 14.6963C8.15656 14.9709 8.15656 15.2626 8.15656 15.8461V17.8434Z" stroke="#ABA08D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <v-bouton-filtre />
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Box -->
    <div id="popup-modal" tabindex="-1" class="bg-black bg-opacity-40 fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full rounded-lg border border-accent_wine top-[50%] translate-y-[-50%] left-[50%] translate-x-[-50%]">
            <div class="relative bg-white rounded-lg">
                <button type="button" id="close_popup-modal" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-red-500 w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-black">Etes-vous sûr(e) de vouloir supprimer?</h3>
                    <form action="{{ route('supprimer.bouteille') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="BouteilleID" name="BouteilleID" value="0">
                        <input type="hidden" id="CellierID" name="CellierID" value="0">
                        <input type="hidden" name="redirect" value="true">
                        <input type="submit" data-modal-hide="popup-modal" class="p-2 px-4 bg-green-600 text-white rounded" type="button" alt="delete" value="Oui" />
                        <button data-modal-hide="popup-modal" class="p-2 px-4 bg-gray-800 text-white rounded" type="button" id="no_popup-modal">No</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- bouton d'ajout de bouteille -->
  <div class="add_btn fixed right-5 btn-bouteille z-50">
    <a href="{{ route('bouteille.createDansCellier', $cellier) }}">
        <div class="shadow-md h-16 w-16 rounded-full transition-colors duration-200 flex justify-center cursor-pointer p-2.5 bg-accent_wine_light text-main"><img class="absolute left-6 h-11 self-center" src="{{asset('img/svg/bouteille-plus.svg')}}" alt="add-button"></div>
    </a>
  </div>
<!-- Affichage filtres et des cartes des bouteilles présentes dans ce cellier ** passer en paramètre de la composante vue toutes le infos néessaires-->
<v-filtre :type="{{ $type }}" :pays="{{ $pays }}" :cellier="{{ $cellier }}" :bouteilles="{{ $bouteilles }}" :liste="{{ $liste }}" />
@endsection