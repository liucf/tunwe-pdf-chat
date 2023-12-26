<x-app-layout>
    <div id="demo" class="px-4 mt-10">


        <div class="flex">
            <div id="pdfview"></div>
            <div class="pdfobject-container flex flex-col">
                <div class="flex-1">
                    messages
                </div>
                <div class="w-full bg-purple-100 py-6 px-4 flex items-center">
                    <input class="w-full rounded-md pr-10" type="text" name="question" placeholder="Enter your question (max 1,000 characters)">

                    <button class="size-4 absolute right-12">
                        <svg stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg></button>
                </div>
            </div>
        </div>

        <x-slot:style>
            <style>
                .pdfobject-container {
                    height: calc(100vh - 110px);
                    width: 50%;
                    /* border: 1rem solid rgba(0, 0, 0, .1); */
                }
            </style>
        </x-slot:style>

        <x-slot:scripts>
          
            <script>
                PDFObject.embed("/pdf/bitcoin.pdf", "#pdfview");
            </script>
        </x-slot>
    </div>
</x-app-layout>
