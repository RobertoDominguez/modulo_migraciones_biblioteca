@extends('layouts.template')


@section('title')
    Migracion de personas
@endsection


@section('content')
    <form action="{{ route('migrar.personas') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}




        <section class="container">


            @if ($errors->any())
                <div class="alert alert-danger">
                    <h3>Migracion realizada</h3>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="file" name="personas">

            <button class="btn btn-primary mb-1 ripple-surface">enviar</button>
        </section>



    </form>
@endsection
