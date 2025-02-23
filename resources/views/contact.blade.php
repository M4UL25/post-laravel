<x-Layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h3>Haii dari Contact</h3>
    <br>
    <ul class="text-xl">
        <li><span>Email : {{ $email }}</span></li>
        <li><span>Phone : {{ $phone }}</span></li>
    </ul>
</x-Layout>
