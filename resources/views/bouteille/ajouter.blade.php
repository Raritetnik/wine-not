@extends('layouts.app')
@section('content')
<div class="flex gap-10 justify-between max-w-[600px] lg:max-w-[1050px] px-6 mx-auto pt-5 items-center">
  <a href="{{ url()->previous() }}" class="hover:opacity-80 transition-opacity  duration-200 ease-in-out"><img class="h-[15px] sm:min-h-[17px]" src="{{asset('img/svg/arrowL-w.svg')}}" alt="back"></a>
</div>

<div class="flex flex-col justify-center mb-7 mt-4">
  <!-- formulaire SAQ -->
  <!-- Form d'ajout de bouteilles dans ce cellier-->
  <div class="max-w-[800px] min-w-[330px] mx-auto w-full">
    <form id="form-saq" action="{{ route('bouteille.saq') }}" method="post" enctype="multipart/form-data" class="w-full px-6 pt-3">
      <!-- passer la méthode PUT et aussi le token expired réémission du token-->
      @csrf
      @method('PUT')
      <div class="pb-3 flex justify-between w-full">
        <h2 class="text-accent_wine text-xl font-extrabold">
          Rechercher
        </h2>
        <a href="{{route('bouteille.ajouterBouteillePasSAQ')}}" id="form-p-p" class="text-accent_wine text-xl font-extrabold">Pas à la SAQ?</a>
      </div>
      <section class="flex flex-col pb-6 justify-center">
        <div class="w-full mb-1">
          <v-recherche :bouteilles="{{ $bouteilles }}" />
        </div>
        <div class="w-full flex flex-col">
          <!-- Remplisser le formulaire afin d'ajouter le vin à votre colection -->
          <div class="mb-2 flex justify-between gap-3">
            <div class="w-full mb-3">
              <label for="cellier" class="block text-section_title text-sm font-bold mb-2">Celliers</label>
              <select name="vino_cellier_id" id="cellier" class="w-full block py-3 px-3 bg-transparent bg-gray-50  rounded-md border border-gray-300 focus:border-secondary focus:outline-none" required>
                @foreach($celliers as $index => $cellier)
                @if($index === 0)
                <option value="{{$cellier->id}}" selected>{{$cellier->nom}}</option>
                @else
                <option value="{{$cellier->id}}">{{$cellier->nom}}</option>
                @endif
                @endforeach

              </select>
            </div>

          </div>
          <div class="mb-2 flex justify-between gap-3">
            <div class="w-1/2 mb-2">
              <label for="quantite" class="block text-section_title text-sm font-bold mb-2">Quantité<b class="text-accent_wine"> *</b></label>
              <input class="block w-full py-3 px-3 placeholder-section_title rounded-md border border-gray-300 focus:border-secondary focus:outline-none appearance-none {{ $errors->has('quantite') ? 'border-error' : '' }}" name="quantite" id="quantite" min="1" placeholder="Quantité de bouteilles" value="{{ old('quantite') }}" required>
              </input>

            </div>
            <div class="w-1/2 mb-2">
              <label for="millesime" class="block text-section_title text-sm font-bold mb-2">Millésime</label>
              <input class="block w-full py-3 px-3 placeholder-section_title rounded-md border border-gray-300 focus:border-secondary focus:outline-none appearance-none" name="millesime" id="millesime" min="1" placeholder="Entrer l'année du vin">
              </input>
            </div>
          </div>
          <div class="mb-2 flex flex-wrap md:flex-nowrap gap-3">
            <div class="w-full mb-2">
              <label for="date_achat" class="block text-section_title text-sm font-bold mb-2">Date d'achat</label>
              <div class="flex flex-col md:flex-row md:space-x-4">
                <input type="date" name="date_achat" id="date_achat" placeholder="Date d'achat" class="block w-full placeholder-section_title py-3 px-3 rounded-md border border-gray-300 focus:border-secondary focus:outline-none" />
              </div>
            </div>
            <div class="w-full mb-2">
              <label for="date_exp" class="block text-section_title text-sm font-bold mb-2">Date de péremption</label>
              <div class="flex flex-col md:flex-row md:space-x-4">
                <input type="date" name="garde_jusqua" id="date_exp" placeholder="Garde jusqu'à quand" class="block w-full py-3 px-3 rounded-md border border-gray-300 placeholder-section_title focus:border-secondary focus:outline-none" />
              </div>
            </div>
          </div>
          <div class="mt-5 flex">
            <button type="submit" class="w-1/2 px-7 py-1.5 rounded-md bg-accent_wine text-lg font-medium text-main hover:bg-transparent border hover:border-accent_wine hover:text-accent_wine transition duration-300 ease-in-out">Ajouter</button>
          </div>
        </div>


      </section>
    </form>
  </div>
  <!-- bouton d'ajout de bouteille -->
  <div class="add_btn absolute right-5 bottom-0 z-50">
    <a href="{{ route('bouteille.create') }}">
      <div class="shadow-md h-16 w-16 rounded-full transition-colors duration-200 flex justify-center cursor-pointer p-2.5 bg-accent_wine_light hover:bg-accent_wine text-main"><img class="absolute left-6 h-11 self-center" src="{{asset('img/svg/bouteille-plus.svg')}}" alt="add-button"></div>
    </a>
  </div>
</div>
@endsection