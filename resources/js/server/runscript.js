import * as PDFJS from './pdf.mjs'

// let filepath = process.argv[2];
// const DEFAULT_URL = "/Users/michael/Sites/tunwe-pdf-chat/storage/app/public/documents/M8vPHTspKJCNbOpf1VDKj577uu1md0fWneIffKP6.pdf";
const DEFAULT_URL = process.argv[2];

// console.log(DEFAULT_URL);

const loadingTask = PDFJS.getDocument({
    url: DEFAULT_URL,
    verbosity: 0
});
const pdfDocument = await loadingTask.promise;
let pages = pdfDocument.numPages;
let allchunks = [];

for (let j = 1; j <= pages; j++) {
    let chunks = [];
    let page = await pdfDocument.getPage(j);

    let content = await page.getTextContent();
    let currentChunk = '';
    for (let i = 0; i < content.items.length; i++) {
        let item = content.items[i];
        currentChunk += item.str;
        if (item.str == '') {
            // get the last character of the last item
            let lastChar = content.items[i - 1].str.slice(-1);
            if (lastChar == '-') {
                // if the last character is a hyphen, remove it and add a space
                currentChunk = currentChunk.slice(0, -1);
            } else {
                currentChunk += ' ';
            }
        } else {
            if (item.hasEOL) {
                currentChunk += ' ';
            }
        }

        if (currentChunk.length > 1800 && item.str.slice(-1) == '.') {
            chunks.push(currentChunk);
            allchunks.push({
                "page": j,
                "content": currentChunk
            });
            currentChunk = '';
        }
    }

    allchunks.push({
        "page": j,
        "content": currentChunk
    });
}


let returnJson = {
    "pages": pages,
    "chunks": allchunks
};
console.log(JSON.stringify(returnJson));
