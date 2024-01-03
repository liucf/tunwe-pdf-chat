<div class="-mx-4 mt-10 ring-1 ring-gray-300 sm:-mx-6 md:mx-0 md:rounded-lg" 
{{ $hasEmbedding ? 'wire:poll' : '' }}
>
    @if(count($documents) > 0 )
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
                <tr wire:key="{{ $document->id }}" class="hover:bg-white">
                    <td class="relative py-4 pl-4 sm:pl-6 pr-3">
                        <div class="font-medium text-gray-900"> 
                            @if($document->embedded)
                            <a class="hover:underline" href="{{ route('documents.show', ['document' => $document]) }}">
                                {{ $document->name }}
                            </a> 
                            @else
                                <div class="flex space-x-2 animate-pulse items-center">
                                    <div class="h-8 bg-primary dark:bg-slate-700 rounded flex items-center">
                                        <div class="px-4">{{ $document->name }}</div>
                                    </div>
                                    <div>
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                          </svg>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($document->embedded)
                        <div class="mt-1 flex flex-col text-gray-500 sm:block lg:hidden">
                            <span>{{ Illuminate\Support\Number::fileSize($document->size, 2) }}</span>
                            <span> {{ $document->created_at->diffForHumans() }} </span>
                        </div>
                        @endif
                    </td>
                    @if($document->embedded)
                    <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">{{ Illuminate\Support\Number::fileSize($document->size, 2) }}</td>
                    <td class="hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell">{{ $document->created_at->diffForHumans() }}</td>

                    <td class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right text-sm font-medium">
                        
                        <button 
                        wire:click="delete('{{ $document->id }}')" 
                        wire:confirm="Are you sure you want to delete this document?" 
                        type="button" 
                        class="inline-flex items-center rounded-md border bg-red-600 hover:bg-red-500 text-white px-3 py-2 text-sm font-medium leading-4 shadow-sm  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30">Delete</button>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($documents->hasPages())
    <div class="p-6 border border-t mt-6">
        {{ $documents->links() }}
    </div>
    @endif
    @else
    <div class="p-4">
        No documents found.
    </div>
    @endif
</div>
