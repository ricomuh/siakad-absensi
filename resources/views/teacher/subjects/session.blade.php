<x-main-layout>
    @section('title', 'Sesi Tanggal ' . $session->created_at->isoFormat('dddd, D MMMM Y'))
</x-main-layout>
