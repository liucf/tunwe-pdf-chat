<!DOCTYPE html>
<html dir="ltr" mozdisallowselectionprint>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="google" content="notranslate">
  <title>PDF.js viewer using built components</title>

  <style>
    body {
      background-color: #808080;
      margin: 0;
      padding: 0;
    }
    #viewerContainer {
      overflow: auto;
      position: absolute;
      width: 100%;
      height: 100%;
    }
  </style>
  <link rel="stylesheet" href="https://unpkg.com/pdfjs-dist@4.0.269/web/pdf_viewer.css">
</head>

<body tabindex="1">
  <div id="viewerContainer">
    <div id="viewer" class="pdfViewer"></div>
  </div>

<script src="https://unpkg.com/pdfjs-dist@4.0.269/build/pdf.mjs" type="module"></script>
{{-- <script src="https://raw.githubusercontent.com/mozilla/pdf.js/master/web/viewer.js"></script> --}}
<script src="https://unpkg.com/pdfjs-dist@4.0.269/web/pdf_viewer.mjs" type="module"></script>
<script type="module">
    var { pdfjsLib } = globalThis;
    // console.log(pdfjsLib);

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

    // (Optionally) enable scripting support.
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
    
    const SEARCH_FOR = "use information gain as the split criterion. Information gain describes a change in entropy H from some previous state to a new state. Entropy is defined as HðTÞ ¼ \u0004 X y2Y P";

    eventBus.on("pagesinit", function () {
        // We can use pdfViewer now, e.g. let's change default scale.
        // pdfViewer.currentScaleValue = "page-width";
        // We can try searching for things.
        // console.log('searching for' + SEARCH_FOR);
        if (SEARCH_FOR) {
            eventBus.dispatch("find", { type: "", query: SEARCH_FOR, highlightAll: true, phraseSearch: true });
        }
    });

    // const DEFAULT_URL = "/pdf/Accelerating the XGBoost algorithm using GPU computing.pdf";
    const DEFAULT_URL = "http://tunwe-pdf-chat.test/documents/nT8Od6tKXGrybEQQB0l5jRCCaNUmZjGix8aE9qJP.pdf";
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

    let pages = pdfDocument.numPages;
    console.log('pages', pages);


    let allchunks = [];
    for(let j=1; j<=pages; j++) {
        let chunks = [];
        pdfDocument.getPage(j).then(page => {
            // console.log('page', page);
            page.getTextContent().then(content => {
                // console.log('content', content);
                var currentChunk = '';
                for (let i = 0; i < content.items.length; i++) {
                    let item = content.items[i];
                    if(j==4){
                        console.log('item', item);
                    }
                    // console.log('item', item);
                    currentChunk += item.str;

                    if(item.str == ''){
                        currentChunk += ' ';
                    }
                    // last character of item.str
                    if (currentChunk.length > 1800 && item.str.slice(-1) == '.') {
                        if(j==4){
                            console.log('currentChunk', currentChunk);
                        }

                        chunks.push(currentChunk);   
                        currentChunk = '';
                        
                    }
                }
               
                chunks.push(currentChunk);  
                // console.log('page',  j);
                // console.log('chunks',  chunks);
            }).catch(contentErr => {
                console.log('error', contentErr);
            });

        
        }).catch(pageErr => {
            console.log('error', pageErr);
        });
        allchunks.push(chunks);
    }

    let returnJson = {
        pages: pages,
        chunks: allchunks
    };
    console.log('returnJson', returnJson);

    // console.log('allchunks',  allchunks);
    // await Promise.all(chunks).then(values => {
    //     console.log(values);
    // }); 


</script>
</body>
</html>