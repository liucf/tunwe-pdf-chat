<x-app-layout>
    <?php
        $document = App\Models\Document::take(1)->get()->first();
        $pdffile = storage_path('app/' . $document->path);
        $pdfurl = asset('pdf/' . $document->path);
        // dd($pdffile, $pdfurl);
    ?>
    <div id="demo" class="px-4 mt-10">
        <div class="flex">
            {{-- <div id="pdfview"></div> --}}

            <div id="viewerContainer">
                <div id="viewer" class="pdfViewer"></div>
            </div>

            <div class="pdfobject-container flex flex-col absolute right-0">
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
              width: 50%;
              height: 100%;
              left: 0;
            }
            </style>
            <link rel="stylesheet" href="https://unpkg.com/pdfjs-dist@4.0.269/web/pdf_viewer.css">
        @endpush 

        @push('scripts')
            <script src="https://unpkg.com/pdfjs-dist@4.0.269/build/pdf.mjs" type="module"></script>
            <script src="https://unpkg.com/pdfjs-dist@4.0.269/web/pdf_viewer.mjs" type="module"></script>
            <script type="module">
                var { pdfjsLib } = globalThis;
                console.log(pdfjsLib);

                pdfjsLib.GlobalWorkerOptions.workerSrc = "./pdf.worker.mjs";

                // Some PDFs need external cmaps.
                const CMAP_URL = "../cmaps/";
                const CMAP_PACKED = true;
                const ENABLE_XFA = true;

                const SANDBOX_BUNDLE_SRC = new URL(
                    "./pdf.sandbox.mjs",
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
                    // pdfViewer.currentScaleValue = "page-width";
                    // We can try searching for things.
                    // console.log('searching for' + SEARCH_FOR);
                    if (SEARCH_FOR) {
                        eventBus.dispatch("find", { type: "", query: SEARCH_FOR, highlightAll: true, phraseSearch: true });
                    }
                });

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
        @endpush
    </div>
</x-app-layout>
