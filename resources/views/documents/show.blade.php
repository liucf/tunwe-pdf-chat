<x-app-layout>
  
    <div class="px-4 mt-10">
        <div class="flex flex-col lg:flex-row relative">
            <div id="viewerContainer" class="lg:w-1/2 lg:block w-full hidden">
                <div id="viewer" class="pdfViewer w-full"></div>
            </div>

            <div class="w-full lg:w-1/2">
                <livewire:chatwindow  :$document/>
            </div>

        </div>


        @push('styles')
        <style>
            body {
              background-color: #808080;
              margin: 0;
              padding: 0;
            }
            #viewerContainer {
              overflow: auto;
              position: absolute;
              /* width: 50%; */
              height: calc(100vh - 110px);
              left: 0;
              top: 0
            }
            </style>
            <link rel="stylesheet" href="https://unpkg.com/pdfjs-dist@4.0.269/web/pdf_viewer.css">
        @endpush 

        @push('scripts')
            <script src="https://unpkg.com/pdfjs-dist@4.0.269/build/pdf.mjs" type="module"></script>
            <script src="https://unpkg.com/pdfjs-dist@4.0.269/web/pdf_viewer.mjs" type="module"></script>
            <script type="module">
                var { pdfjsLib } = globalThis;
                // console.log(pdfjsLib);

                pdfjsLib.GlobalWorkerOptions.workerSrc = "https://unpkg.com/pdfjs-dist@4.0.269/build/pdf.worker.mjs";
                // pdfjsLib.GlobalWorkerOptions.workerSrc = "./pdf.worker.mjs";

                // Some PDFs need external cmaps.
                const CMAP_URL = "https://unpkg.com/browse/pdfjs-dist@4.0.269/cmaps/";
                const CMAP_PACKED = true;
                const ENABLE_XFA = true;

                const SANDBOX_BUNDLE_SRC = new URL(
                    "https://unpkg.com/pdfjs-dist@4.0.269/build/pdf.sandbox.mjs",
                    window.location
                );

                const container = document.getElementById("viewerContainer");
                const eventBus = new pdfjsViewer.EventBus();

                const pdfLinkService = new pdfjsViewer.PDFLinkService({
                    eventBus,
                });
                const pdfFindController = new pdfjsViewer.PDFFindController({
                    eventBus,
                    linkService: pdfLinkService,
                });

                const pdfScriptingManager = new pdfjsViewer.PDFScriptingManager({
                    eventBus,
                    sandboxBundleSrc: SANDBOX_BUNDLE_SRC,
                });

                const pdfViewer = new pdfjsViewer.PDFViewer({
                    container,
                    eventBus,
                    linkService: pdfLinkService,
                    findController: pdfFindController,
                    scriptingManager: pdfScriptingManager,
                });


                pdfLinkService.setViewer(pdfViewer);
                pdfScriptingManager.setViewer(pdfViewer);

                const SEARCH_FOR = "";

                eventBus.on("pagesinit", function () {
                    // We can use pdfViewer now, e.g. let's change default scale.
                    pdfViewer.currentScaleValue = "page-width";
                    // pdfViewer.currentScaleValue = "auto";
                    // We can try searching for things.
                    // console.log('searching for' + SEARCH_FOR);
                    if (SEARCH_FOR) {
                        eventBus.dispatch("find", { type: "", query: SEARCH_FOR, highlightAll: true, phraseSearch: true });
                    }
                });

                window.eventBus = eventBus;

                const DEFAULT_URL = "{{ $pdfurl }}";

                // Loading document.
                const loadingTask = pdfjsLib.getDocument({
                    url: DEFAULT_URL,
                    cMapUrl: CMAP_URL,
                    cMapPacked: CMAP_PACKED,
                    enableXfa: ENABLE_XFA,
                });

                const pdfDocument = await loadingTask.promise;
                pdfViewer.setDocument(pdfDocument);
                pdfLinkService.setDocument(pdfDocument, null);
            </script>

            <script>
                document.addEventListener('livewire:init', () => {
                    Livewire.on('search-chunk', (event) => {
                        // console.log('search-chunk', event.text);
                        eventBus.dispatch("find", { type: "", query: event.text, highlightAll: true, phraseSearch: true, caseSensitive: false });
                    });
                });
            </script>

        @endpush

    </div>

</x-app-layout>