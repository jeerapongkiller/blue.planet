/**
 * High-resolution JPG export for job sheets / documents (uses dom-to-image).
 *
 * dom-to-image captures at 1x screen resolution by default, which prints blurry.
 * This renders the node at `scale`x (default 3x) by enlarging the output canvas
 * and applying a CSS transform to the cloned node.
 *
 * Usage: exportNodeAsJpeg(document.getElementById('div-boat-job-image'), 'file-name');
 */
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
    if (isJobSheet) node.classList.add('job-sheet--export');
    const cleanup = () => { if (isJobSheet) node.classList.remove('job-sheet--export'); };

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
