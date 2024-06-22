<div class="container mx-auto py-8 ">
    <h2 class="text-2xl font-bold mb-8 text-orange-600 uppercase">Catálogo de Películas</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($peliculas as $pelicula)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('storage/'.$pelicula->portada) }}" alt="{{ $pelicula->titulo }}" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-2">{{ $pelicula->titulo }}</h2>
                    <p class="text-gray-700 mb-4">{{ $pelicula->descripcion }}</p>
                    <p>Fecha estreno:<span class=" font-bold"> {{$pelicula->fecha_estreno}} <span></p>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-900 font-bold">{{ $pelicula->genero }}</span>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Ver más</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
