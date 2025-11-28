<x-app>
    <livewire:keanggotaan.daftar-anggota-component />

</x-app>

<script>
    function loadPdfInModal(button) {
        const url = button.getAttribute('data-url');
        const iframe = document.getElementById('previewIframe');
        if (iframe) {
            iframe.src = url;
        }
    }

    const printModal = document.getElementById('printPreviewModal');
    if (printModal) {
        printModal.addEventListener('hidden.bs.modal', function () {
            const iframe = document.getElementById('previewIframe');
            if (iframe) {
                iframe.src = 'about:blank';
            }
        });
    }
</script>
