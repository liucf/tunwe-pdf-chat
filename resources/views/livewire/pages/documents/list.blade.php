<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Reactive;

new class extends Component {
    #[Reactive]
    public $documents;
};
?>
<div class="-mx-4 mt-10 ring-1 ring-gray-300 sm:-mx-6 md:mx-0 md:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300 table-fixed">
        <thead>
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Docuemnt</th>
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Size</th>
                <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Upload Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $document)
                <tr wire:key="{{ $document->id }}">
                    <td class="relative py-4 pl-4 sm:pl-6 pr-3 text-sm">
                        <div class="font-medium text-gray-900"> {{ $document->name }} </div>
                        <div class="mt-1 flex flex-col text-gray-500 sm:block lg:hidden">
                            <span>{{ Illuminate\Support\Number::fileSize($document->size, 2) }}</span>
                            <span> {{ $document->created_at->diffForHumans() }} </span>
                        </div>
                    </td>
                    <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">{{ Illuminate\Support\Number::fileSize($document->size, 2) }}</td>
                    <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">{{ $document->created_at->diffForHumans() }}</td>

                    <td class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-sm font-medium">
                        <button type="button" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
