/**
 * High-resolution JPG export for job sheets / documents (uses dom-to-image).
 *
 * dom-to-image captures at 1x screen resolution by default, which prints blurry.
 * This renders the node at `scale`x (default 3x) by enlarging the output canvas
 * and applying a CSS transform to the cloned node.
 *
 * Usage: exportNodeAsJpeg(document.getElementById('div-boat-job-image'), 'file-name');
 */
// Header texts (lowercase) of the columns drivers/guides read first: pickup time, customer, hotel
const JOB_SHEET_KEY_HEADERS = [
    'เวลารับ', 'ชื่อลูกค้า', 'โรงแรม',
    'pick up time', 'pickup time', 'time',
    "customer's name", 'client', 'hotel', 'pickup'
];

/**
 * Mark body cells of the key columns (matched by header text) with .job-sheet__cell--key
 * so the export renders them bold. Returns the marked cells for cleanup.
 */
function markKeyColumns(root) {
    const marked = [];
    const tables = root.matches('table') ? [root] : Array.from(root.querySelectorAll('table'));

    tables.forEach((table) => {
        const headRows = table.tHead ? table.tHead.rows : [];
        if (!headRows.length) return;
        // The last header row holds the per-column titles (earlier rows are colspan groups)
        const headerCells = Array.from(headRows[headRows.length - 1].cells);
        const keyIndexes = headerCells
            .map((th, i) => (JOB_SHEET_KEY_HEADERS.includes(th.textContent.trim().toLowerCase()) ? i : -1))
            .filter((i) => i !== -1);
        if (!keyIndexes.length) return;

        Array.from(table.tBodies).forEach((tbody) => {
            Array.from(tbody.rows).forEach((row) => {
                // Skip summary rows that use colspan (column positions would not line up)
                if (row.cells.length !== headerCells.length) return;
                keyIndexes.forEach((i) => {
                    row.cells[i].classList.add('job-sheet__cell--key');
                    marked.push(row.cells[i]);
                });
            });
        });
    });
    return marked;
}

const JOB_SHEET_EXPORT_WIDTH = 1050; // px — A4-friendly width for the exported image

/**
 * With the large export font, long values (voucher numbers, joined names) can make a table
 * wider than the fixed export width. It then overflows: the right columns get cut off
 * and the header no longer lines up with the table. Widen the node to fit the widest table.
 */
function fitNodeToTables(node) {
    // Set inline (not via a CSS class): dom-to-image copies inline width to its clone, while a
    // class rule with !important would override the clone's width and clip the image.
    node.style.setProperty('width', `${JOB_SHEET_EXPORT_WIDTH}px`, 'important');
    node.style.setProperty('max-width', 'none', 'important');

    const nodeRect = node.getBoundingClientRect();
    const tables = node.matches('table') ? [node] : Array.from(node.querySelectorAll('table'));
    let needed = JOB_SHEET_EXPORT_WIDTH;
    tables.forEach((table) => {
        // Right edge of the table's content, measured from the node's left edge
        const right = table.getBoundingClientRect().left - nodeRect.left + table.scrollWidth;
        needed = Math.max(needed, Math.ceil(right) + 30); // small safety margin on the right
    });
    if (needed > JOB_SHEET_EXPORT_WIDTH) node.style.setProperty('width', `${needed}px`, 'important');
}

function exportNodeAsJpeg(node, fileName, scale = 3) {
    if (!node) {
        if (typeof toastr !== 'undefined') toastr.error('ไม่พบข้อมูลสำหรับบันทึกรูป');
        return Promise.resolve();
    }

    // Job sheets: lay out at a fixed A4-friendly width while capturing (see .job-sheet--export
    // in style.css). On a wide monitor the sheet would otherwise be ~1600px+ wide and the
    // text shrinks to ~5pt when the image is printed on A4. Reading scrollWidth below
    // forces the re-layout synchronously.
    const isJobSheet = node.classList.contains('job-sheet');
    const boldCells = isJobSheet ? markKeyColumns(node) : [];
    const originalStyle = node.getAttribute('style');
    if (isJobSheet) {
        node.classList.add('job-sheet--export');
        fitNodeToTables(node);
    }
    const cleanup = () => {
        if (!isJobSheet) return;
        node.classList.remove('job-sheet--export');
        // Restore the original inline style (some sheets set their own width inline)
        if (originalStyle === null) node.removeAttribute('style');
        else node.setAttribute('style', originalStyle);
        boldCells.forEach((cell) => cell.classList.remove('job-sheet__cell--key'));
    };

    const width = node.scrollWidth;
    const height = node.scrollHeight;

    // Keep the canvas inside browser limits (max side ~32k px; iOS Safari max area ~16.7M px)
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) ||
        (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    const maxArea = isIOS ? 16000000 : 120000000;
    const maxSide = isIOS ? 4096 : 32000;
    let finalScale = Math.min(
        scale,
        maxSide / width,
        maxSide / height,
        Math.sqrt(maxArea / (width * height))
    );
    finalScale = Math.max(1, Math.floor(finalScale * 100) / 100);

    return domtoimage.toJpeg(node, {
            quality: 0.95,
            // JPEG has no alpha: transparent areas would render black, so force white
            bgcolor: '#FFFFFF',
            width: Math.round(width * finalScale),
            height: Math.round(height * finalScale),
            style: {
                transform: `scale(${finalScale})`,
                transformOrigin: 'top left',
                // Fix the clone to its on-screen size so % widths don't stretch to the scaled canvas
                width: `${width}px`,
                height: `${height}px`
            }
        })
        .then((dataUrl) => {
            const link = document.createElement('a');
            link.download = fileName + '.jpg';
            link.href = dataUrl;
            link.click();
        })
        .catch(() => {
            if (typeof toastr !== 'undefined') toastr.error('บันทึกรูปไม่สำเร็จ กรุณาลองใหม่');
        })
        .finally(cleanup);
}
