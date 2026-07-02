@extends('dashboard.layouts.main')

@section('fullpage', true)

@section('content')
    <div class="flex flex-1 items-start justify-center p-4 min-h-0">
        <div class="w-full max-w-2xl border border-slate-300 bg-white flex flex-col self-stretch min-h-0">
            <x-ai.chat-widget />
        </div>
    </div>
@endsection
