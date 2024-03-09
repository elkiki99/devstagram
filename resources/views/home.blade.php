@extends("layouts.app")

@section("titulo")
    Más reciente
@endsection

@section("contenido")
    <x-listar-post :posts="$posts" />
@endsection